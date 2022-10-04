<h3><?php echo $lang['withdrawal']; ?></h3>
<hr/>

<?php
if(isset($_POST['bit_add'])) {
	$eid = protect($_POST['eid']);
	$amount = protect($_POST['amount']);
	$company = protect($_POST['company']);
	$u_field_1 = protect($_POST['u_field_1']);
	$time = time();
	$query = $db->query("SELECT * FROM bit_users_earnings WHERE id='$eid' and uid='$_SESSION[bit_uid]'");
	$row = $query->fetch_assoc();
	if(empty($eid) or empty($amount) or empty($company) or empty($u_field_1)) { echo error($lang['error_1']); }
	elseif(!is_numeric($amount)) { echo error("$lang[error_16]"); }
	elseif($amount > $row['amount']) { echo error("$lang[error_17] $row[amount] $row[currency]."); }
	else {
		$new_amount = $row['amount']-$amount;
		$insert = $db->query("INSERT bit_users_withdrawals (uid,eid,amount,currency,company,u_field_1,status,processed_on,requested_on) VALUES ('$_SESSION[bit_uid]','$eid','$amount','$row[currency]','$company','$u_field_1','1','0','$time')");
		$update = $db->query("UPDATE bit_users_earnings SET amount='$new_amount' WHERE id='$eid' and uid='$_SESSION[bit_uid]'");
		echo success("$lang[success_10]");
	}
}
?>

<form action="" method="POST">
	<div class="form-group">
		<label><?php echo $lang['wallet']; ?></label>
		<select class="form-control input-lg form_style_1" name="eid">
			<?php
			$query = $db->query("SELECT * FROM bit_users_earnings WHERE uid='$_SESSION[bit_uid]' ORDER BY id");
			if($query->num_rows>0) {
				while($row = $query->fetch_assoc()) {
					echo '<option value="'.$row[id].'">'.$row[amount].' '.$row[currency].'</option>';
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
		<label><?php echo $lang['w_to']; ?></label>
		<select class="form-control input-lg form_style_1" name="company" onchange="bit_decode_company(this.value);">
			<option value="PayPal">PayPal</option>
			<option value="Skrill">Skrill</option>
			<option value="WebMoney">WebMoney</option>
			<option value="Payeer">Payeer</option>
			<option value="Perfect Money">Perfect Money</option>
			<option value="AdvCash">AdvCash</option>
			<option value="OKPay">OKPay</option>
			<option value="Entromoney">Entromoney</option>
			<option value="SolidTrust Pay">SolidTrust Pay</option>
			<option value="Neteller">Neteller</option>
			<option value="UQUID">UQUID</option>
			<option value="BTC-e">BTC-e</option>
			<option value="Yandex Money">Yandex Money</option>
			<option value="QIWI">QIWI</option>
			<option value="Payza">Payza</option>
			<option value="Bitcoin">Bitcoin</option>
			<option value="Litecoin">Litecoin</option>
			<option value="Dogecoin">Dogecoin</option>
			<option value="Dash">Dash</option>
			<option value="Peercoin">Peercoin</option>
			<option value="Ethereum">Ethereum</option>
		</select>
	</div>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> <span id="bit_company">PayPal</span> <span id="bit_account"><?php echo $lang['account']; ?></span><span id="bit_address" style="display:none;"><?php echo $lang['address']; ?></span></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<button type="submit" class="btn btn-primary" name="bit_add"><i class="fa fa-plus"></i> <?php echo $lang['btn_new_request']; ?></button>
</form>