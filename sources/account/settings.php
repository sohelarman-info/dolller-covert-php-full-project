<h3><?php echo $lang['settings']; ?></h3>
<hr/>

<?php
if(isset($_POST['bit_save'])) {
	$cpassword = protect($_POST['cpassword']);
	$password = protect($_POST['password']);
	$repassword = protect($_POST['repassword']);
	if(empty($cpassword) or empty($password) or empty($repassword)) { echo error($lang['error_1']); }
	elseif(idinfo($_SESSION['bit_uid'],"password") !== md5($cpassword)) { echo error($lang['error_5']); }
	elseif($password !== $repassword) { echo error($lang['error_6']); }
	else {
		$pass = md5($password);
		$update = $db->query("UPDATE bit_users SET password='$pass' WHERE id='$_SESSION[bit_uid]'");
		echo success($lang['success_4']);
	}
}
?>

<form action="" method="POST">
	<div class="form-group">
		<label><?php echo $lang['currenct_password']; ?></label>
		<input type="password" class="form-control input-lg form_style_1" name="cpassword">
	</div>
	<div class="form-group">
		<label><?php echo $lang['new_password']; ?></label>
		<input type="password" class="form-control input-lg form_style_1" name="password">
	</div>
	<div class="form-group">
		<label><?php echo $lang['renew_password']; ?></label>
		<input type="password" class="form-control input-lg form_style_1" name="repassword">
	</div>
	<button type="submit" class="btn btn-primary" name="bit_save"><i class="fa fa-check"></i> <?php echo $lang['btn_save_changes']; ?></button>
</form>