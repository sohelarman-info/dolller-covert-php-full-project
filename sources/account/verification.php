<?php
$status = get_verify_type();

if(isset($_POST['bit_send_email'])) {
	$email = idinfo($_SESSION['bit_uid'],"email");
	$hash = md5($email);
	$update = $db->query("UPDATE bit_users SET email_hash='$hash' WHERE id='$_SESSION[bit_uid]'");
	$msubject = '['.$settings[name].'] Email verification';
	$mreceiver = $email;
	$message = 'Hello, '.$email.'

To activate your account and make exchanges need to confirm your email address. Click on the link below:
'.$settings[url].'email-verify/'.$hash.'

If you have some problems please feel free to contact with us on '.$settings[supportemail];
	$headers = 'From: '.$settings[infoemail].'' . "\r\n" .
		'Reply-To: '.$settings[infoemail].'' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	$mail = mail($mreceiver, $msubject, $message, $headers);
	if($mail) {
		echo success($lang['success_6']);
	} else {
		echo error($lang['error_9']);
	}
} 

if(isset($_POST['bit_upload'])) { 
	$ext = array('jpg','png','jpeg','pdf'); 
	$fileext1 = end(explode('.',$_FILES['document_1']['name'])); 
	$fileext1 = strtolower($fileext1); 
	$fileext2 = end(explode('.',$_FILES['document_2']['name'])); 
	$fileext2 = strtolower($fileext2); 
	if(empty($_FILES['document_1']['name']) or empty($_FILES['document_2']['name'])) { echo error($lang['error_10']); }
	elseif(!in_array($fileext1,$ext)) { echo error($lang['error_11']); }
	elseif(!in_array($fileext2,$ext)) { echo error($lang['error_11']); }
	else {
		$upload_dir = md5($settings['name'])."/";
		if(!is_dir($upload_dir)) { mkdir($upload_dir,0777); }
		$user_dir = $upload_dir."user_".$_SESSION['bit_uid'];
		if(!is_dir($user_dir)) { mkdir($user_dir,0777); }
		$document_1 = $user_dir."/".$_FILES['document_1']['name'];
		$document_2 = $user_dir."/".$_FILES['document_2']['name'];
		@move_uploaded_file($_FILES['document_1']['tmp_name'], $document_1);
		@move_uploaded_file($_FILES['document_2']['tmp_name'], $document_2);
		$update = $db->query("UPDATE bit_users SET document_1='$document_1',document_2='$document_2' WHERE id='$_SESSION[bit_uid]'");
		echo success($lang['success_7']);
	}
}

if(isset($_POST['bit_send_sms_code'])) { 
	include("includes/NexmoMessage.php");
	$nexmo_sms = new NexmoMessage($settings[nexmo_api_key],$settings[nexmo_api_secret]);
	// Step 2: Use sendText( $to, $from, $message ) method to send a message. 
	$rand = rand(00000,99999);
	$number = idinfo($_SESSION['bit_uid'],"mobile_number");
	$insert = $db->query("INSERT bit_sms_codes (uid,sms_code,verified) VALUES ('$_SESSION[bit_uid]','$rand','0')");
	$message = 'Your code for '.$settings[name].' is: '.$rand.' ';
	$info = $nexmo_sms->sendText( '+'.$number, $settings[name], $message );
	echo success("$lang[we_send_code] +$number. $lang[please_enter_code]");
}

if(isset($_POST['bit_verify_sms_code'])) {
	$sms_code = protect($_POST['sms_code']);
	$check_code = $db->query("SELECT * FROM bit_sms_codes WHERE uid='$_SESSION[bit_uid]' and sms_code='$sms_code' and verified='0'");
	if(empty($sms_code)) { echo error($lang['error_12']); }
	elseif($check_code->num_rows==0) { echo error($lang['error_13']); }
	else {
		$update = $db->query("UPDATE bit_sms_codes SET verified='1' WHERE uid='$_SESSION[bit_uid]' and sms_code='$sms_code'");
		$update = $db->query("UPDATE bit_users SET mobile_verified='1' WHERE id='$_SESSION[bit_uid]'");
		echo success($lang['success_8']);
	}
} 

if(isset($_POST['bit_add_number'])) {
	$mobile_number = protect($_POST['mobile_number']);
	if(empty($mobile_number)) { echo error($lang['error_14']); }
	elseif(!is_numeric($mobile_number)) { echo error($lang['error_15']); }
	else {
		$update = $db->query("UPDATE bit_users SET mobile_number='$mobile_number' WHERE id='$_SESSION[bit_uid]'");
		echo success($lang['success_9']);
	}
}

if($status == "1") {
	?>
	<h3><?php echo $lang['email_documentation']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_send_verification_email']; ?></button>
	</form>
	<?php } ?>

	<br>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_accepted']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['bit_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_awaiting_review']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_passpord']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_upload_files']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<br>
	<h3><?php echo $lang['mobile_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"mobile_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['mobile_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['bit_uid'],"mobile_number")) { ?>
		<p><?php echo $lang['click_sms_send']; ?> <b><?php echo idinfo($_SESSION['bit_uid'],"mobile_number"); ?></b></p>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['enter_sms_code']; ?></label>
				<input type="text" class="form-control" name="sms_code">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_send_sms_code"><i class="fa fa-reply"></i> <?php echo $lang['btn_send_sms_code']; ?></button> 
			<button type="submit" class="btn btn-primary btn-sm" name="bit_verify_sms_code"><i class="fa fa-check"></i> <?php echo $lang['btn_verify_sms_code']; ?></button>
		</form>
		<?php } else { ?>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['your_mobile_number']; ?></label>
				<input type="text" class="form-control" name="mobile_number">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_add_number"><i class="fa fa-plus"></i> <?php echo $lang['btn_add_number']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "2") {
?>
	<h3><?php echo $lang['email_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_send_verification_email']; ?></button>
	</form>
	<?php } ?>

	<br>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_accepted']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['bit_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_awaiting_review']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_passpord']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_upload_files']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "3") {
?>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['bit_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_awaiting_review']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_passpord']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_upload_files']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<br>
	<h3><?php echo $lang['mobile_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"mobile_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['mobile_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['bit_uid'],"mobile_number")) { ?>
		<p><?php echo $lang['click_sms_send']; ?> <b><?php echo idinfo($_SESSION['bit_uid'],"mobile_number"); ?></b></p>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['enter_sms_code']; ?>']; ?></label>
				<input type="text" class="form-control" name="sms_code">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_send_sms_code"><i class="fa fa-reply"></i> <?php echo $lang['btn_send_sms_code']; ?></button> 
			<button type="submit" class="btn btn-primary btn-sm" name="bit_verify_sms_code"><i class="fa fa-check"></i> <?php echo $lang['btn_verify_sms_code']; ?></button>
		</form>
		<?php } else { ?>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['your_mobile_number']; ?></label>
				<input type="text" class="form-control" name="mobile_number">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_add_number"><i class="fa fa-plus"></i> <?php echo $lang['btn_add_number']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "4") {
?>
	<h3><?php echo $lang['email_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_send_verification_email']; ?></button>
	</form>
	<?php } ?>
	
	<br>
	<h3><?php echo $lang['mobile_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"mobile_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['bit_uid'],"mobile_number")) { ?>
		<p><?php echo $lang['email_not_verified']; ?> <b><?php echo idinfo($_SESSION['bit_uid'],"mobile_number"); ?></b></p>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['enter_sms_code']; ?></label>
				<input type="text" class="form-control" name="sms_code">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_send_sms_code"><i class="fa fa-reply"></i> <?php echo $lang['btn_send_sms_code']; ?></button> 
			<button type="submit" class="btn btn-primary btn-sm" name="bit_verify_sms_code"><i class="fa fa-check"></i> <?php echo $lang['btn_verify_sms_code']; ?></button>
		</form>
		<?php } else { ?>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['your_mobile_number']; ?></label>
				<input type="text" class="form-control" name="mobile_number">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_add_number"><i class="fa fa-plus"></i> <?php echo $lang['btn_add_number']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "5") {
?>
	<h3><?php echo $lang['email_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_send_verification_email']; ?></button>
	</form>
	<?php } ?>

	<br>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_accepted']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['bit_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_awaiting_review']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_passpord']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_upload_files']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} elseif($status == "6") {
?>
	<h3><?php echo $lang['document_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"document_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['documents_accepted']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['bit_uid'],"document_1")) { ?>
		<p><span class="text text-info"><i class="fa fa-clock-o"></i> <?php echo $lang['documents_awaiting_review']; ?></span></p>
		<?php } else { ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label><?php echo $lang['scanned_passpord']; ?></label>
				<input type="file" class="form-control" name="document_1">
			</div>
			<div class="form-group">
				<label><?php echo $lang['scanned_invoice']; ?></label>
				<input type="file" class="form-control" name="document_2">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_upload"><i class="fa fa-upload"></i> <?php echo $lang['btn_upload_files']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	
	<?php
} elseif($status == "7") {
?>
	<h3><?php echo $lang['email_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"email_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
	<p><?php echo $lang['email_not_verified']; ?></p>
	<form action="" method="POST">
		<button type="submit" class="btn btn-primary btn-sm" name="bit_send_email"><i class="fa fa-reply"></i> <?php echo $lang['btn_send_verification_email']; ?></button>
	</form>
	<?php } ?>

	
	<?php
} elseif($status == "8") {
?>
	
	<h3><?php echo $lang['mobile_verification']; ?></h3>
	<hr/>
	<?php if(idinfo($_SESSION['bit_uid'],"mobile_verified") == "1") { ?>
	<p><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['your_email_was_verified']; ?></span></p>
	<?php } else { ?>
		<?php if(idinfo($_SESSION['bit_uid'],"mobile_number")) { ?>
		<p><?php echo $lang['email_not_verified']; ?> <b><?php echo idinfo($_SESSION['bit_uid'],"mobile_number"); ?></b></p>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['enter_sms_code']; ?></label>
				<input type="text" class="form-control" name="sms_code">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_send_sms_code"><i class="fa fa-reply"></i> <?php echo $lang['btn_send_sms_code']; ?></button> 
			<button type="submit" class="btn btn-primary btn-sm" name="bit_verify_sms_code"><i class="fa fa-check"></i> <?php echo $lang['btn_verify_sms_code']; ?></button>
		</form>
		<?php } else { ?>
		<form action="" method="POST">
			<div class="form-group">
				<label><?php echo $lang['your_mobile_number']; ?></label>
				<input type="text" class="form-control" name="mobile_number">
			</div>
			<button type="submit" class="btn btn-primary btn-sm" name="bit_add_number"><i class="fa fa-plus"></i> <?php echo $lang['btn_add_number']; ?></button>
		</form>
		<?php } ?>
	<?php } ?>
	
	<?php
} else {
	if($status == "9") {
		$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$_SESSION[bit_uid]'");
	}	
}
?>
