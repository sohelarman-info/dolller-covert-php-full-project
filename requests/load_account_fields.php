<?php
ob_start();
session_start();
error_reporting(0);
include("../includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM bit_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("../includes/functions.php");
include(getLanguage($settings['url'],null,2));
$gateway = protect($_GET['gateway']);
$gateway = gatewayinfo($gateway,"name");
if($gateway == "PayPal") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> PayPal <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Skrill") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Skrill <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "WebMoney") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> WebMoney <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Payeer") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Payeer <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Perfect Money") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Perfect Money <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "AdvCash") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> AdvCash <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "OKPay") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> OKPay <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Entromoney") { 
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Entromoney <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "SolidTrust Pay") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> SolidTrust Pay <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Neteller") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Neteller <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "UQUID") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> UQUID <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "BTC-e") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> BTC-e <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Yandex Money") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Yandex Money <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "QIWI") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> QIWI <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Payza") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Payza <?php echo $lang['account']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Bitcoin") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Bitcoin <?php echo $lang['address']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Litecoin") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Litecoin <?php echo $lang['address']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Dogecoin") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Dogecoin <?php echo $lang['address']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Dash") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Dash <?php echo $lang['address']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Peercoin") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Peercoin <?php echo $lang['address']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Ethereum") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Ethereum <?php echo $lang['address']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
}  elseif($gateway == "TheBillioncoin") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> TheBillioncoin <?php echo $lang['address']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
	}  elseif($gateway == "Pipcoin") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your']; ?> Pipcoin <?php echo $lang['address']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<?php
} elseif($gateway == "Bank Transfer") {
	?>
	<div class="form-group">
		<label><?php echo $lang['bank_holder_name']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<div class="form-group">
		<label><?php echo $lang['bank_account_number']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_4">
	</div>
	<div class="form-group">
		<label><?php echo $lang['swift_code']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_5">
	</div>
	<div class="form-group">
		<label><?php echo $lang['bank_full_name']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_2">
	</div>
	<div class="form-group">
		<label><?php echo $lang['bank_country']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_3">
	</div>
	<?php
} elseif($gateway == "Western Union") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your_name']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<div class="form-group">
		<label><?php echo $lang['your_location']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_2">
	</div>
	<?php
} elseif($gateway == "Moneygram") {
	?>
	<div class="form-group">
		<label><?php echo $lang['your_name']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_1">
	</div>
	<div class="form-group">
		<label><?php echo $lang['your_location']; ?></label>
		<input type="text" class="form-control input-lg form_style_1" name="u_field_2">
	</div>
	<?php
} else {}
?>