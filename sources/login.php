<!-- signin-page -->
	<section id="main" class="clearfix user-page">
		<div class="container">
			<div class="row text-center">
				<!-- user-login -->			
				<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
					<div class="user-account">
						<h2><?php echo $lang['login_with_your_account']; ?></h2>
						<?php
						if(isset($_POST['bit_login'])) {
							$email = protect($_POST['email']);
							$password = protect($_POST['password']);
							$pass = md5($password);
							$check = $db->query("SELECT * FROM bit_users WHERE email='$email' and password='$pass'");
							if(empty($email) or empty($password)) {
								echo error("$lang[error_45]");
							} elseif($check->num_rows==0) {
								echo error("$lang[error_46]");
							} else {
								$row = $check->fetch_assoc();
								if($row['status'] == "2") {
									echoerror("$lang[error_47]");
								} else {
									if($_POST['remember_me'] == "yes") {
										setcookie("bitexchanger_uid", $row['id'], time() + (86400 * 30), '/'); // 86400 = 1 day
									}
									$last_login = $row['last_login']+5000;
									if(time() > $last_login) {
										$time = time();
										$update = $db->query("UPDATE bit_users SET last_login='$time' WHERE id='$row[id]'");
									}
									$_SESSION['bit_uid'] = $row['id'];
									$redirect = $settings['url']."account/exchanges";
									header("Location: $redirect");
								}
							}
						}
						?>
						<!-- form -->
						<form action="" method="POST">
							<div class="form-group">
								<input type="text" class="form-control" name="email" placeholder="<?php echo $lang['email_address']; ?>" >
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" placeholder="<?php echo $lang['password']; ?>" >
							</div>
							<button type="submit" name="bit_login" class="btn"><?php echo $lang['btn_login']; ?></button>
						
					
						<!-- forgot-password -->
						<div class="user-option">
							<div class="checkbox pull-left">
								<label><input type="checkbox" name="remember_me" value="yes"> <?php echo $lang['remember_me']; ?></label>
							</div>
							<div class="pull-right forgot-password">
								<a href="<?php echo $settings['url']; ?>password/reset"><?php echo $lang['forgot_password']; ?></a>
							</div>
						</div><!-- forgot-password -->
						</form><!-- form -->
					</div>
					<a href="<?php echo $settings['url']; ?>register" class="btn-primary">Create new account</a>
				</div><!-- user-login -->			
			</div><!-- row -->	
		</div><!-- container -->
	</section><!-- signin-page -->