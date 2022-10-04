<ol class="breadcrumb">
	<li><a href="./">BitExchanger Administrator</a></li>
	<li class="active">Web Settings</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Web Settings
	</div>
	<div class="panel-body">
		<?php
		if(isset($_POST['btn_save'])) {
			$title = protect($_POST['title']);
			$description = protect($_POST['description']);
			$keywords = protect($_POST['keywords']);
			$name = protect($_POST['name']);
			$url = protect($_POST['url']);
			$infoemail = protect($_POST['infoemail']);
			$supportemail = protect($_POST['supportemail']);
			$skype = protect($_POST['skype']);
			$whatsapp = protect($_POST['whatsapp']);
			$referral_comission = protect($_POST['referral_comission']);
			$wallet_comission = protect($_POST['wallet_comission']);
			$login_to_exchange = protect($_POST['login_to_exchange']);
			if(isset($_POST['document_verification'])) { $document_verification = '1'; } else { $document_verification = '0'; }
			if(isset($_POST['email_verification'])) { $email_verification = '1'; } else { $email_verification = '0'; }
			if(isset($_POST['phone_verification'])) { $phone_verification = '1'; } else { $phone_verification = '0'; }
			$nexmo_api_key = protect($_POST['nexmo_api_key']);
			$nexmo_api_secret = protect($_POST['nexmo_api_secret']);
			$worktime_from = protect($_POST['worktime_from']);
			$worktime_to = protect($_POST['worktime_to']);
			$worktime_gmt = protect($_POST['worktime_gmt']);
			$footer_information = protect($_POST['footer_information']);
			if(empty($title) or empty($description) or empty($keywords) or empty($name) or empty($url) or empty($infoemail) or empty($supportemail) or empty($worktime_from) or empty($worktime_to) or empty($worktime_gmt) or empty($footer_information)) {
				echo error("Required fields: title, description, keywords, site name, site url address, info email address, support email address, work time start, work time end, work time gmt zone and footer short info"); 
			} elseif(!isValidURL($url)) { 
				echo error("Please enter valid site url address.");
			} elseif(!isValidEmail($infoemail)) { 
				echo error("Please enter valid info email address.");
			} elseif(!isValidEmail($supportemail)) { 
				echo error("Please enter valid support email address.");
			} elseif(!is_numeric($referral_comission)) {
				echo error("Please enter referral comission with numbers.");
			} elseif(!is_numeric($wallet_comission)) { 
				echo error("Please enter wallet comission with numbers.");
			} elseif($phone_verification == "1" && empty($nexmo_api_key)) {
				echo error("Please enter Nexmo API Key."); 
			} elseif($phone_verification == "1" && empty($nexmo_api_secret)) {
				echo error("Please enter Nexmo API Secret.");
			} else {
				$update = $db->query("UPDATE bit_settings SET title='$title',description='$description',keywords='$keywords',name='$name',url='$url',infoemail='$infoemail',supportemail='$supportemail',skype='$skype',whatsapp='$whatsapp',referral_comission='$referral_comission',wallet_comission='$wallet_comission',login_to_exchange='$login_to_exchange',document_verification='$document_verification',email_verification='$email_verification',phone_verification='$phone_verification',nexmo_api_key='$nexmo_api_key',nexmo_api_secret='$nexmo_api_secret',worktime_from='$worktime_from',worktime_to='$worktime_to',worktime_gmt='$worktime_gmt',footer_information='$footer_information'");
				$settingsQuery = $db->query("SELECT * FROM bit_settings ORDER BY id DESC LIMIT 1");
				$settings = $settingsQuery->fetch_assoc();
				echo success("Your changes was saved successfully.");
			}
		}
		?>
		<form action="" method="POST">
			<div class="form-group">
				<label>Title</label>
				<input type="text" class="form-control" name="title" value="<?php echo $settings['title']; ?>">
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea class="form-control" name="description" rows="2"><?php echo $settings['description']; ?></textarea>
			</div>
			<div class="form-group">
				<label>Keywords</label>
				<textarea class="form-control" name="keywords" rows="2"><?php echo $settings['keywords']; ?></textarea>
			</div>
			<div class="form-group">
				<label>Site name</label>
				<input type="text" class="form-control" name="name" value="<?php echo $settings['name']; ?>">
			</div>
			<div class="form-group">
				<label>Site url address</label>
				<input type="text" class="form-control" name="url" value="<?php echo $settings['url']; ?>">
			</div>
			<div class="form-group">
				<label>Info email address</label>
				<input type="text" class="form-control" name="infoemail" value="<?php echo $settings['infoemail']; ?>">
			</div>
			<div class="form-group">
				<label>Support email address</label>
				<input type="text" class="form-control" name="supportemail" value="<?php echo $settings['supportemail']; ?>">
			</div>
			<div class="form-group">
				<label>Skype</label>
				<input type="text" class="form-control" name="skype" value="<?php echo $settings['skype']; ?>">
			</div>
			<div class="form-group">
				<label>Whatsapp</label>
				<input type="text" class="form-control" name="whatsapp" value="<?php echo $settings['whatsapp']; ?>">
			</div>
			<div class="form-group">
				<label>Referral comission</label>
				<input type="text" class="form-control" name="referral_comission" value="<?php echo $settings['referral_comission']; ?>">
				<small>Put here number of referral comission. Example if type 10 system will calculate referral comission with 10%. Enter number without %</small>
			</div>
			<div class="form-group">
				<label>Wallet comission</label>
				<input type="text" class="form-control" name="wallet_comission" value="<?php echo $settings['wallet_comission']; ?>">
				<small>Put here number of wallet comission. This comission is earned by you when client want to exchange from their wallet. Example if type 10 system will calculate wallet comission with 10%. Enter number without %</small>
			</div>
			<div class="form-group">
				<label>Require user login to exchange</label>
				<select class="form-control" name="login_to_exchange">
					<option value="1" <?php if($settings['login_to_exchange'] == "1") { echo 'selected'; } ?>>Yes</option>
					<option value="0" <?php if($settings['login_to_exchange'] == "0") { echo 'selected'; } ?>>No</option>
				</select>		
			</div>
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="document_verification" value="yes" <?php if($settings['document_verification'] == "1") { echo 'checked'; }?>> Require user to upload documents and you verify it before exchange
					</label>
			</div>
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="email_verification" value="yes" <?php if($settings['email_verification'] == "1") { echo 'checked'; }?>> Require user to verify their email address before exchange
					</label>
			</div>
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="phone_verification" value="yes" <?php if($settings['phone_verification'] == "1") { echo 'checked'; }?>> Require user to verify their mobile number before exchange
					</label>
			</div>
			<div class="form-group">
				<label>Nexmo API Key</label>
				<input type="text" class="form-control" name="nexmo_api_key" value="<?php echo $settings['nexmo_api_key']; ?>">
				<small>Type Nexmo API Key if you turned on mobile verification. Get api key form <a href="http://nexmo.com" target="_blank">www.nexmo.com</a></small>
			</div>
			<div class="form-group">
				<label>Nexmo API Secret</label>
				<input type="text" class="form-control" name="nexmo_api_secret" value="<?php echo $settings['nexmo_api_secret']; ?>">
				<small>Type Nexmo API Secret if you turned on mobile verification. Get api key form <a href="http://nexmo.com" target="_blank">www.nexmo.com</a></small>
			</div>
			<div class="form-group">
				<label>Work time start</label>
				<input type="text" class="form-control" name="worktime_from" value="<?php echo $settings['worktime_from']; ?>">
			</div>
			<div class="form-group">
				<label>Work time end</label>
				<input type="text" class="form-control" name="worktime_to" value="<?php echo $settings['worktime_to']; ?>">
			</div>
			<div class="form-group">
				<label>Work time GMT zone</label>
				<input type="text" class="form-control" name="worktime_gmt" value="<?php echo $settings['worktime_gmt']; ?>">
			</div>
			<div class="form-group">
				<label>Footer short info</label>
				<textarea class="form-control" name="footer_information" rows="2"><?php echo $settings['footer_information']; ?></textarea>
			</div>
			<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
		</form>
	</div>
</div>