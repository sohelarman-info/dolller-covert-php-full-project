

					<h3>Forgot password?</h3>
<hr/>
<?php
if(isset($_POST['bit_reset'])) {
	$email = protect($_POST['email']);
	$check = $db->query("SELECT * FROM bit_users WHERE email='$email'");
	if(empty($email)) { echo error("Please enter your email address."); }
	elseif($check->num_rows==0) { echo error("No such user with this email address."); }
	else {
		$row = $check->fetch_assoc();
		$randomHash = randomHash(13);
		$email = $row['email'];
		$update = $db->query("UPDATE bit_users SET password_recovery='$randomHash' WHERE id='$row[id]'");
		$msubject = '['.$settings[name].'] Forgot Password';
		$mreceiver = $email;
		$message = 'Hello, '.$email.'

	You request a change of password, use the link below to replace it. If you have not done you simply ignore.
	'.$settings[url].'password/change/'.$randomHash.'

	If you have some problems please feel free to contact with us on '.$settings[supportemail];
		$headers = 'From: '.$settings[infoemail].'' . "\r\n" .
			'Reply-To: '.$settings[infoemail].'' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$mail = mail($mreceiver, $msubject, $message, $headers);
		if($mail) {
			echo success("We sent you verification email. Check your inbox or spam folder.");
		} else {
			echo error("Error with sending email. Please try again later.");
		}
	}
} else {
	echo info("Please enter your email address in form below to send you link for password reset.");
}
?>

<form action= "" method="POST">
	<div class="form-group">
		<label>Email address</label>
		<input type="text" class="form-control input-lg form_style_1" name="email">
	</div>
	<button type="submit" class="btn btn-primary btn-lg" name="bit_reset"><i class="fa fa-check"></i> Reset</button>
</form>
