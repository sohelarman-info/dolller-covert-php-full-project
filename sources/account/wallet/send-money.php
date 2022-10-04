<h3><?php echo $lang['send_money']; ?></h3>
<p><?php echo $lang['send_money_text']; ?></p>
<hr/>
<?php
$hide_form=0;
if(isset($_POST['bit_send'])) {
	$recipient = protect($_POST['recipient']);
	$wallet_id = protect($_POST['wallet_id']);
	$amount = protect($_POST['amount']);
	$description = protect($_POST['description']);
	$passwd = protect($_POST['passwd']);
	$passwd = md5($passwd);
	$check = $db->query("SELECT * FROM bit_users WHERE username='$recipient' or email='$recipient'");
	$walletsql = $db->query("SELECT * FROM bit_users_earnings WHERE id='$wallet_id' and uid='$_SESSION[bit_uid]'");
	$w = $walletsql->fetch_assoc();
	if(empty($recipient) or empty($wallet_id) or empty($amount) or empty($description) or empty($_POST['passwd'])) { echo error($lang['error_1']); }
	elseif($check->num_rows==0) { echo error("$lang[error_23] <b>$recipient</b>."); }
	elseif($amount > $w['amount']) { echo error("$lang[error_22] $w[amount] $w[currency]."); }
	elseif(idinfo($_SESSION['bit_uid'],"password") !== $passwd) { echo error($lang['error_24']); }
	else {
		$r = $check->fetch_assoc();
		$am = $w['amount'] - $amount;
		$update = $db->query("UPDATE bit_users_earnings SET amount='$am' WHERE id='$w[id]'");
		$time = time();
		$insert = $db->query("INSERT bit_users_transactions (sender,recipient,amount,currency,description,status,time) VALUES ('$_SESSION[bit_uid]','$r[id]','$amount','$w[currency]','$description','1','$time')");
		$chk = $db->query("SELECT * FROM bit_users_earnings WHERE uid='$r[id]' and currency='$w[currency]'");
		if($chk->num_rows>0) {
			$c = $chk->fetch_assoc();
			$na = $c['amount'] + $amount;
			$update = $db->query("UPDATE bit_users_earnings SET amount='$na',updated='$time' WHERE id='$c[id]'");
		} else {
			$insert = $db->query("INSERT bit_users_earnings (uid,amount,currency,created) VALUES ('$r[id]','$amount','$w[currency]','$time')");
		}
		echo success("$lang[success_14_1] <b>$amount $w[currency]</b> $lang[success_14_2] <b>$recipient</b>.");
	}
}

if($hide_form == 0) { 
?>
<form action="" method="POST">
	<div class="form-group">
		<label><?php echo $lang['recipient_email']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="recipient">
	</div>
	<div class="form-group">
		<label><?php echo $lang['wallet']; ?></label>
		<select class="form-control input-lg form_style_1" name="wallet_id">
			<?php
			$gateways = $db->query("SELECT * FROM bit_users_earnings WHERE uid='$_SESSION[bit_uid]' ORDER BY id");
			if($gateways->num_rows>0) {
				while($g = $gateways->fetch_assoc()) {
					echo '<option value="'.$g[id].'">'.$g[amount].' '.$g[currency].'</option>';
				}
			} else {
				echo '<option></option>'; 
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<label><?php echo $lang['amount']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="amount">
	</div>
	<div class="form-group">
		<label><?php echo $lang['payment_description']; ?></label>
		<textarea class="form-control input-lg form_style_1" name="description" rows="3"></textarea>
	</div>
	<div class="form-group">
		<label><?php echo $lang['your_password']; ?></label>
		<input type="password" class="form-control input-lg form_style_1" name="passwd">
	</div>
	<button type="submit" class="btn btn-primary" name="bit_send"><?php echo $lang['btn_send']; ?></button>
</form>
<?php } ?>