<h3><?php echo $lang['deposit']; ?></h3>
<hr/>
<?php
$hide_form=0;

if(isset($_POST['bit_confirm_payment'])) {
	$txid = protect($_POST['txid']);
	$deposit_id = protect($_POST['deposit_id']);
	$check = $db->query("SELECT * FROM bit_users_deposits WHERE uid='$_SESSION[bit_uid]' and id='$deposit_id'");
	if(empty($txid)) { echo error($lang['error_21']); }
	else {
		if($check->num_rows>0) {
			$update = $db->query("UPDATE bit_users_deposits SET status='2',txid='$txid' WHERE id='$deposit_id'");
			echo success($lang['success_11']);
		}
	}
}

if(isset($_POST['bit_cancel_payment'])) {
	$deposit_id = protect($_POST['deposit_id']);
	$check = $db->query("SELECT * FROM bit_users_deposits WHERE uid='$_SESSION[bit_uid]' and id='$deposit_id'");
	if($check->num_rows>0) {
		$delete = $db->query("DELETE FROM bit_users_deposits WHERE id='$deposit_id'");
		echo success($lang['success_12']);
	}
}

if(isset($_POST['bit_deposit'])) {
	$gateway = protect($_POST['gateway']);
	$amount = protect($_POST['amount']);
	
	if(empty($gateway)) { echo error($lang['error_18']); }
	elseif(empty($amount)) { echo error("$lang[error_19]"); }
	elseif(!is_numeric($amount)) { echo error("$lang[error_20]"); }
	else {
		$hide_form=1;
		$time = time();
		$currency = gatewayinfo($gateway,"currency");
		$payment_hash = randomHash(10);
		$payment_hash = strtoupper($payment_hash);
		$insert = $db->query("INSERT bit_users_deposits (uid,gateway_id,amount,currency,payment_hash,status,time) VALUES ('$_SESSION[bit_uid]','$gateway','$amount','$currency','$payment_hash','1','$time')");
		$query = $db->query("SELECT * FROM bit_users_deposits WHERE uid='$_SESSION[bit_uid]' ORDER BY id DESC LIMIT 1");
		$row = $query->fetch_assoc();
		?>
		<?php echo success("Your deposit request was made. Please complete steps bellow."); ?>
		<p><?php echo $lang['deposit_text_1']; ?></p>
		<p><?php echo $lang['deposit_text_2']; ?> <?php echo $amount; ?> <?php echo gatewayinfo($gateway,"currency"); ?> <?php echo $lang['deposit_text_3']; ?><br/>
		<?php
		$gname = gatewayinfo($gateway,"name"); 
		if($gname == "Western Union" or $gname == "Moneygram") {
			echo 'Name: '.gatewayinfo($gateway,"a_field_1").'<br/>Location: '.gatewayinfo($gateway,"a_field_2");
		} elseif($gname == "Bana Transfer") {
			echo $lang[bank_holder_name].': '.gatewayinfo($gateway,"a_field_1").'<br/>'.$lang[bank_account_number].': '.gatewayinfo($gateway,"a_field_4").'<br/>'.$lang[swift_code].': '.gatewayinfo($gateway,"a_field_5").'<br/>'.$lang[bank_full_name].': '.gatewayinfo($gateway,"a_field_2").'<br/>'.$lang[bank_country].': '.gatewayinfo($gateway,"a_field_3");
		} elseif($gname == "Bitcoin" or $gname == "Litecoin" or $gname == "Dogecoin" or $gname == "Dash" or $gname == "Ethereum" or $gname == "Peercoin" or $gname == "TheBillioncoin") {
			echo $gname.' '.$lang[address].': '.gatewayinfo($gateway,"a_field_1");
		} else {
			echo $gname.' '.$lang[account].': '.gatewayinfo($gateway,"a_field_1");
		}
		?><br/>
		<?php echo $lang['enter_payment_description']; ?>: <?php echo $payment_hash; ?>
		</p>
		<br><br>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php if($gname == "Western Union" or $gname == "Moneygram") { echo $gname.' '.$lang['pin']; } else { echo $lang['transaction_id_batch']; } ?></label>
				<input type="text" class="form-control" name="txid">
				<input type="hidden" name="deposit_id" value="<?php echo $row['id']; ?>">
			</div>
			<button type="submit" class="btn btn-success" name="bit_confirm_payment"><?php echo $lang['btn_confirm_payment']; ?></button> <button type="submit" class="btn btn-danger" name="bit_cancel_payment"><?php echo $lang['btn_cancel_deposit']; ?></button>
		</form>
		<p><?php echo $lang['deposit_text_4']; ?></p>
		<?php
	}
}

if($hide_form == 0) { 
?>
<form action="" method="POST">
	<div class="form-group">
		<label><?php echo $lang['deposit_via']; ?></label>
		<select class="form-control input-lg form_style_1" name="gateway">
			<?php
			$gateways = $db->query("SELECT * FROM bit_gateways WHERE allow_send='1' ORDER BY id");
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
		<input type="text" class="form-control input-lg form_style_1" name="amount">
	</div>
	<button type="submit" class="btn btn-primary" name="bit_deposit"><?php echo $lang['btn_process_deposit']; ?></button>
</form>
<?php } ?>