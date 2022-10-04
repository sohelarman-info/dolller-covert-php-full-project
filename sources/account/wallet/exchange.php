<h3><?php echo $lang['exchange']; ?></h3>
<p><?php echo $lang['exchange_text_1']; ?></p>
<hr/>
<?php
if(isset($_POST['bit_exchange'])) {
	$wallet_id = protect($_POST['wallet_id']);
	$gateway_receive = protect($_POST['gateway_receive']);
	$amount_send = protect($_POST['amount_send']);
	$amount_receive = protect($_POST['amount_receive']);
	$amount_receive = number_format($amount_receive,2);
	$wallet_rate = protect($_POST['wallet_rate']);
	$u_field_1 = protect($_POST['u_field_1']);
	$u_field_2 = protect($_POST['u_field_2']);
	$u_field_3 = protect($_POST['u_field_3']);
	$u_field_4 = protect($_POST['u_field_4']);
	$u_field_5 = protect($_POST['u_field_5']);
	$email = idinfo($_SESSION['bit_uid'],"email");
	$passwd = protect($_POST['passwd']);
	$passwd = md5($passwd);
	$exchange_id = randomHash(7)."-".randomHash(13)."-".randomHash(6);
	$time = time();
	$walletinfo = $db->query("SELECT * FROM bit_users_earnings WHERE id='$wallet_id' and uid='$_SESSION[bit_uid]'");
	$w = $walletinfo->fetch_assoc();
	if(empty($wallet_id) or empty($gateway_receive) or empty($amount_send) or empty($amount_receive) or empty($wallet_rate) or empty($u_field_1) or empty($_POST['passwd'])) { echo success($lang['error_1']); }
	elseif(!is_numeric($amount_send)) { echo error($lang['error_20']); }
	elseif($amount_send > $w['amount']) { echo error("$lang[error_22] $w[amount] $w[currency]."); }
	elseif(idinfo($_SESSION['bit_uid'],"password") !== $passwd) { echo error($lang['error_24']); }
	else {
		$insert = $db->query("INSERT bit_exchanges (uid,wid,gateway_receive,amount_send,amount_receive,rate_from,status,created,u_field_1,u_field_2,u_field_3,u_field_4,u_field_5,u_field_6,exchange_id) VALUES ('$_SESSION[bit_uid]','$wallet_id','$gateway_receive','$amount_send','$amount_receive','$wallet_rate','3','$time','$email','$u_field_1','$u_field_2','$u_field_3','$u_field_4','$u_field_5','$exchange_id')");
		$am = $w['amount'] - $amount_send;
		$update = $db->query("UPDATE bit_users_earnings SET amount='$am' WHERE id='$w[id]'");
		echo success("$lang[success_13]");
	}
}
?>
<form action="" method="POST">
	<div class="form-group">
		<label><?php echo $lang['from_wallet']; ?></label>
		<select class="form-control input-lg form_style_1" name="wallet_id" id="wallet_id">
			<option value=""></option>
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
		<label><?php echo $lang['to_gateway']; ?></label>
		<select class="form-control input-lg form_style_1" name="gateway_receive" onchange="bit_l_acc_fields(this.value);">
			<option value=""></option>
			<?php
			$gateways = $db->query("SELECT * FROM bit_gateways WHERE allow_receive='1' ORDER BY id");
			if($gateways->num_rows>0) {
				while($g = $gateways->fetch_assoc()) {
					echo '<option value="'.$g[id].'">'.$g[name].' '.$g[currency].'</option>';
				}
			} else {
				echo '<option></option>'; 
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<label><?php echo $lang['amount']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="amount_send" id="amount" onkeyup="bit_exch_cal(this.value);" onkeydown="bit_exch_cal(this.value);">
	</div>
	<div class="form-group">
		<label><?php echo $lang['will_receive']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" id="amount_receive" disabled>
		<input type="hidden" name="amount_receive" id="amount_receive2">
		<input type="hidden" name="rate_from" id="rate_from">
		<input type="hidden" name="rate_to" id="rate_to">
		<input type="hidden" name="currency_from" id="currency_from">
		<input type="hidden" name="currency_to" id="currency_to">
	</div>
	<div class="form-group" id="bitexc_exchange_rate" style="display:none;">
		<span class="text text-muted"><?php echo $lang['exchange_rate']; ?>: <span id="bit_rate_from"></span> <span id="bit_currency_from"></span> = <span id="bit_rate_to"></span> <span id="bit_currency_to"></span></span>
	</div>
	<div id="account_fields">
	
	</div>
	<div class="form-group">
		<label><?php echo $lang['your_password']; ?></label>
		<input type="password" class="form-control input-lg form_style_1" name="passwd">
	</div>
	<button type="submit" class="btn btn-primary" name="bit_exchange"><?php echo $lang['btn_send']; ?></button>
</form>