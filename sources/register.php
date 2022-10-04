<!-- signin-page -->
	<section id="main" class="clearfix user-page">
		<div class="container">
			<div class="row text-center">
				<!-- user-login -->			
				<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
					<div class="user-account">
						<h2><?php echo $lang['create_account_free']; ?></h2>
						<?php
						if(isset($_POST['bit_login'])) {
							$username = protect($_POST['username']);
							$email = protect($_POST['email']);
							$password = protect($_POST['password']);
							$repassword = protect($_POST['repassword']);
							$time = time();
							$ip = $_SERVER['REMOTE_ADDR'];

							$check_username = $db->query("SELECT * FROM bit_users WHERE username='$username'");
							$check_email = $db->query("SELECT * FROM bit_users WHERE email='$email'");

							if(empty($username) or empty($email) or empty($password) or empty($repassword)) {
								echo error("$lang[error_1]");
							} elseif(!isValidUsername($username)) {
								echo error("$lang[error_48]");
							} elseif($check_username->num_rows>0) {
								echo error("$lang[error_49]");
							} elseif(!isValidEmail($email)) {
								echo error("$lang[error_50]");
							} elseif($check_email->num_rows>0) {
								echo error("$lang[error_51]");
							} elseif($password !== $repassword) {
								echo error("$lang[error_52]");
							} else {
								$data['status'] = 'success';
								$pass = md5($password);
								$insert = $db->query("INSERT bit_users (username,email,password,status,ip,signup_time,email_verified,document_verified,mobile_verified) VALUES ('$username','$email','$pass','1','$ip','$time','0','0','0')");
								$query = $db->query("SELECT * FROM bit_users WHERE username='$username' and email='$email' and password='$pass'");
								$row = $query->fetch_assoc();
								$_SESSION['bit_uid'] = $row['id'];
								$verify_type = get_verify_type();
								if($verify_type == "9") {
									$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$row[id]'");
								}
								echo success("$lang[success_16]");
								echo '<meta http-equiv="refresh" content="3;URL='.$settings[url].'account/exchanges" />  ';
								echo '<script type="text/javascript">
										window.location.href="'.$settings[url].'account/exchanges";
									</script>';
							}
						}
						?>
						<!-- form -->
						<form action="" method="POST">
							<div class="form-group">
								<input type="text" class="form-control" name="username" placeholder="<?php echo $lang['username']; ?>" >
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="email" placeholder="<?php echo $lang['email_address']; ?>" >
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" placeholder="<?php echo $lang['password']; ?>" >
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="repassword" placeholder="<?php echo $lang['repassword']; ?>" >
							</div>
							<button type="submit" name="bit_login" class="btn"><?php echo $lang['btn_register']; ?></button>
						
					
						<!-- forgot-password -->
						<div class="user-option">
							<div class="pull-right forgot-password">
								<a href="<?php echo $settings['url']; ?>password/reset"><?php echo $lang['forgot_password']; ?></a>
							</div>
						</div><!-- forgot-password -->
						</form><!-- form -->
					</div>
					<a href="<?php echo $settings['url']; ?>login" class="btn-primary">Login with account</a>
				</div><!-- user-login -->			
			</div><!-- row -->	
		</div><!-- container -->
	</section><!-- signin-page -->