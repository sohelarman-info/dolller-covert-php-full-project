<?php
$hash = protect($_GET['hash']);
$query = $db->query("SELECT * FROM bit_users WHERE password_recovery='$hash'");
if($query->num_rows==0) { header("Location: $settings[url]"); }
$row = $query->fetch_assoc();
?>
<h3>Change Password</h3>
<hr/>
<?php
if(isset($_POST['bit_change'])) {
	$password = protect($_POST['password']);
	$repassword = protect($_POST['repassword']);
	if(empty($password)) { echo error("Please enter your new password."); }
	elseif($password !== $repassword) { echo error("Passwords does not match."); }
	else {
		$pass = md5($password);
		$update = $db->query("UPDATE bit_users SET password='$pass',password_recovery='' WHERE id='$row[id]'");
		echo success("Your password was changed successfully.");
	}
}
?>

<form action= "" method="POST">
	<div class="form-group">
		<label>New password</label>
		<input type="password" class="form-control input-lg form_style_1" name="password">
	</div>
	<div class="form-group">
		<label>Re-type password</label>
		<input type="password" class="form-control input-lg form_style_1" name="repassword">
	</div>
	<button type="submit" class="btn btn-primary btn-lg" name="bit_reset"><i class="fa fa-check"></i> Change</button>
</form>