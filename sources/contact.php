<section id="main" class="clearfix home-default">
		<div class="container">
			
			<!-- main-content -->
			<div class="main-content">
				<!-- row -->
				<div class="row">
					<!-- product-list -->
					<div class="col-md-12">
						<!-- categorys -->
						<div class="section">
							<div class="row">
								<div class="col-md-12">

							<h3><?php echo $lang['contact']; ?></h3>
							<hr/>
<div class="row">
						<div class="col-md-12">
							<?php
							if(isset($_POST['bit_send'])) {
								$name = protect($_POST['name']);
								$email = protect($_POST['email']);
								$subject = protect($_POST['subject']);
								$message = protect($_POST['message']);
								
								if(empty($name) or empty($email) or empty($subject) or empty($message)) {
									echo error($lang['error_1']);
								} elseif(!isValidEmail($email)) {
									echo error($lang['error_2']);
								} else {
									$msubject = '['.$settings[name].'] '.$subject;
									$mreceiver = $settings['supportemail'];
									$headers = 'From: '.$supportemail.'' . "\r\n" .
										'Reply-To: '.$email.'' . "\r\n" .
										'X-Mailer: PHP/' . phpversion();
									$mail = mail($mreceiver, $msubject, $message, $headers);
									if($mail) { 
										echo success($lang['success_1']);
									} else {
										echo error($lang['error_3']);
									}
								}
							}
							?>
						</div>
						<div class="col-md-3">
							<?php if($settings['skype']) { ?>
							<b><i class="fa fa-skype"></i> <?php echo $lang['skype']; ?></b><br/>
							<?php echo $settings['skype']; ?>
							<br><br>
							
							<?php } ?>
							<?php if($settings['whatsapp']) { ?>
							
							<b><i class="fa fa-phone"></i> Contact number </b><br>
							01735846478
							<br><br>
							
							<b><i class="fa fa-whatsapp"></i> <?php echo $lang['whatsapp']; ?></b><br/>
							<?php echo $settings['whatsapp']; ?>
							<br><br>
							<?php } ?>
							<?php if($settings['supportemail']) { ?>
							<b><i class="fa fa-at"></i> <?php echo $lang['support_email']; ?></b><br/>
							<?php echo $settings['supportemail']; ?>
							<br><br>
							<?php } ?>
						</div>
						<div class="col-md-9">
							<form action="" method="POST">
								<div class="form-group">
									<label><?php echo $lang['your_name'];?></label>
									<input type="text" class="form-control input-lg form_style_1" name="name">
								</div>	
								<div class="form-group">
									<label><?php echo $lang['your_email']; ?></label>
									<input type="text" class="form-control input-lg form_style_1" name="email">
								</div>	
								<div class="form-group">
									<label><?php echo $lang['subject']; ?></label>
									<input type="text" class="form-control input-lg form_style_1" name="subject">
								</div>	
								<div class="form-group">
									<label><?php echo $lang['message']; ?></label>
									<textarea class="form-control input-lg form_style_1" name="message" rows="3"></textarea>
								</div>	
								<button type="submit" class="btn btn-primary" name="bit_send"><?php echo $lang['btn_send_message']; ?></button>
							</form>
						</div>
					</div>
								</div>
							</div>
						</div><!-- category-ad -->	
						
						
					</div><!-- product-list -->
				</div><!-- row -->
			</div><!-- main-content -->
		</div><!-- container -->
	</section><!-- main -->