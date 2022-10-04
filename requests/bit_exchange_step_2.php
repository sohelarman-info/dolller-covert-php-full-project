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
$bit_gateway_send = protect($_POST['bit_gateway_send']);
$bit_gateway_receive = protect($_POST['bit_gateway_receive']);
$bit_amount_send = protect($_POST['bit_amount_send']);
$bit_amount_receive = protect($_POST['bit_amount_receive']);
$bit_rate_from = protect($_POST['bit_rate_from']);
$bit_rate_to = protect($_POST['bit_rate_to']);
$bit_currency_from = protect($_POST['bit_currency_from']);
$bit_currency_to = protect($_POST['bit_currency_to']);
$min_amount = gatewayinfo($bit_gateway_send,"min_amount");
$max_amount = gatewayinfo($bit_gateway_send,"max_amount");
$account = gatewayinfo($bit_gateway_send,"a_field_1");
$gateway = gatewayinfo($bit_gateway_send,"name").' '.gatewayinfo($bit_gateway_send,"currency");
if(empty($bit_rate_from) or empty($bit_rate_to)) {
	$data['status'] = 'error'; 
	$data['msg'] = error($lang['error_28']);
} elseif($settings['login_to_exchange'] == "1" && get_verify_type() !== "9" && idinfo($_SESSION['bit_uid'],"status") == "1") {
	$data['status'] = 'error';
	$data['msg'] = error($lang['error_29']);
} elseif(empty($bit_gateway_send)) {
	$data['status'] = 'error'; 
	$data['msg'] = error("$lang[error_30]");
} elseif(empty($bit_gateway_receive)) {
	$data['status'] = 'error'; 
	$data['msg'] = error("$lang[error_31]");
} elseif(empty($account)) {
	$data['status'] = 'error'; 
	$data['msg'] = error("$lang[error_32] $gateway.");
} elseif(empty($bit_amount_send)) {
	$data['status'] = 'error'; 
	$data['msg'] = error("$lang[error_33]");
} elseif(!is_numeric($bit_amount_send)) {
	$data['status'] = 'error'; 
	$data['msg'] = error("$lang[error_34]");
} elseif($bit_amount_receive > gatewayinfo($bit_gateway_receive,"reserve")) {
	$data['status'] = 'error'; 
	$data['msg'] = error("$lang[error_35]");
} elseif($min_amount > $bit_amount_send) {
	$data['status'] = 'error'; 
	$data['msg'] = error("$lang[error_36] $min_amount $bit_currency_from.");
} elseif($bit_amount_send > $max_amount) {
	$data['status'] = 'error'; 
	$data['msg'] = error("$lang[error_37] $max_amount $bit_currency_from.");
} else {
	$data['status'] = 'success';
	$receive = gatewayinfo($bit_gateway_receive,"name");
	if($receive == "Bank Transfer") {
		$html_form = '<div id="bit_exchange_results"></div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<h3><i class="fa fa-user"></i> '.$lang[your_data_to_receive].'</h3>
					<form id="bit_exchange_form">
						<div class="form-group">
							<label>'.$lang[your_email].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_1">
						</div>
						<div class="form-group">
							<label>'.$lang[your_name].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_2">
						</div>
						<div class="form-group">
							<label>'.$lang[your_location].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_3">
						</div>
						<div class="form-group">
							<label>'.$lang[your_bank_name].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_4">
						</div>
						<div class="form-group">
							<label>'.$lang[your_bank_account].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_5">
						</div>
						<div class="form-group">
							<label>'.$lang[your_bank_swift].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_6">
						</div>
						<input type="hidden" name="bit_gateway_send" value="'.$bit_gateway_send.'">
						<input type="hidden" name="bit_gateway_receive" value="'.$bit_gateway_receive.'">
						<input type="hidden" name="bit_amount_send" value="'.$bit_amount_send.'">
						<input type="hidden" name="bit_amount_receive" value="'.$bit_amount_receive.'">
						<input type="hidden" name="bit_rate_from" value="'.$bit_rate_from.'">
						<input type="hidden" name="bit_rate_to" value="'.$bit_rate_to.'">
						<input type="hidden" name="bit_currency_from" value="'.$bit_currency_from.'">
						<input type="hidden" name="bit_currency_to" value="'.$bit_currency_to.'">
						<center>
							<button type="button" class="btn btn-primary btn-lg" onclick="bit_exchange_step_3();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i> '.$lang[btn_process_exchange].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
						</center>
					</form>
				</div>
				<div class="col-md-2"></div>
			</div>';
	} elseif($receive == "Moneygram" or $receive == "Western Union") {
		$html_form = '<div id="bit_exchange_results"></div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<h3><i class="fa fa-user"></i> '.$lang[your_data_to_receive].'</h3>
					<form id="bit_exchange_form">
						<div class="form-group">
							<label>'.$lang[your_email].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_1">
						</div>
						<div class="form-group">
							<label>'.$lang[your_name].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_2">
						</div>
						<div class="form-group">
							<label>'.$lang[your_location].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_3">
						</div>
						<input type="hidden" name="bit_gateway_send" value="'.$bit_gateway_send.'">
						<input type="hidden" name="bit_gateway_receive" value="'.$bit_gateway_receive.'">
						<input type="hidden" name="bit_amount_send" value="'.$bit_amount_send.'">
						<input type="hidden" name="bit_amount_receive" value="'.$bit_amount_receive.'">
						<input type="hidden" name="bit_rate_from" value="'.$bit_rate_from.'">
						<input type="hidden" name="bit_rate_to" value="'.$bit_rate_to.'">
						<input type="hidden" name="bit_currency_from" value="'.$bit_currency_from.'">
						<input type="hidden" name="bit_currency_to" value="'.$bit_currency_to.'">
						<center>
							<button type="button" class="btn btn-primary btn-lg" onclick="bit_exchange_step_3();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i> '.$lang[btn_process_exchange].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
						</center>
					</form>
				</div>
				<div class="col-md-2"></div>
			</div>';
	} elseif($receive == "Bitcoin" or $receive == "Litecoin" or $receive == "Dogecoin" or $receive == "Dash" or $receive == "Peercoin" or $receive == "Ethereum" or $receive == "TheBillioncoin") {
		$html_form = '<div id="bit_exchange_results"></div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<h3><i class="fa fa-user"></i> '.$lang[your_data_to_receive].'</h3>
					<form id="bit_exchange_form">
						<div class="form-group">
							<label>'.$lang[your_email].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_1">
						</div>
						<div class="form-group">
							<label>'.$lang[your].' '.$receive.' '.$lang[address].'</label>
							<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_2">
						</div>
						<input type="hidden" name="bit_gateway_send" value="'.$bit_gateway_send.'">
						<input type="hidden" name="bit_gateway_receive" value="'.$bit_gateway_receive.'">
						<input type="hidden" name="bit_amount_send" value="'.$bit_amount_send.'">
						<input type="hidden" name="bit_amount_receive" value="'.$bit_amount_receive.'">
						<input type="hidden" name="bit_rate_from" value="'.$bit_rate_from.'">
						<input type="hidden" name="bit_rate_to" value="'.$bit_rate_to.'">
						<input type="hidden" name="bit_currency_from" value="'.$bit_currency_from.'">
						<input type="hidden" name="bit_currency_to" value="'.$bit_currency_to.'">
						<center>
							<button type="button" class="btn btn-primary btn-lg" onclick="bit_exchange_step_3();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i> '.$lang[btn_process_exchange].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
						</center>
					</form>
				</div>
				<div class="col-md-2"></div>
			</div>';
	} else {
		$fields = '';
		$check = $db->query("SELECT * FROM bit_gateways WHERE name='$receive' and external_gateway='1'");
		if($check->num_rows>0) {
			$r = $check->fetch_assoc();
			$fieldsquery = $db->query("SELECT * FROM bit_gateways_fields WHERE gateway_id='$r[id]' ORDER BY id");
			if($fieldsquery->num_rows>0) {
				while($field = $fieldsquery->fetch_assoc()) {
					$field_number = $field['field_number']+1;
					$fields .= '<div class="form-group">
								<label>'.$field[field_name].'</label>
								<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_'.$field_number.'">
							</div>';
				}
			}
			$html_form = '<div id="bit_exchange_results"></div>
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<h3><i class="fa fa-user"></i> '.$lang[your_data_to_receive].'</h3>
						<form id="bit_exchange_form">
							<div class="form-group">
								<label>'.$lang[your_email].'</label>
								<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_1">
							</div>
							'.$fields.'
							<input type="hidden" name="bit_gateway_send" value="'.$bit_gateway_send.'">
							<input type="hidden" name="bit_gateway_receive" value="'.$bit_gateway_receive.'">
							<input type="hidden" name="bit_amount_send" value="'.$bit_amount_send.'">
							<input type="hidden" name="bit_amount_receive" value="'.$bit_amount_receive.'">
							<input type="hidden" name="bit_rate_from" value="'.$bit_rate_from.'">
							<input type="hidden" name="bit_rate_to" value="'.$bit_rate_to.'">
							<input type="hidden" name="bit_currency_from" value="'.$bit_currency_from.'">
							<input type="hidden" name="bit_currency_to" value="'.$bit_currency_to.'">
							<center>
								<button type="button" class="btn btn-primary btn-lg" onclick="bit_exchange_step_3();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i> '.$lang[btn_process_exchange].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</center>
						</form>
					</div>
					<div class="col-md-2"></div>
				</div>';
		} else {
			$html_form = '<div id="bit_exchange_results"></div>
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<h3><i class="fa fa-user"></i> '.$lang[your_data_to_receive].'</h3>
						<form id="bit_exchange_form">
							<div class="form-group">
								<label>'.$lang[your_email].'</label>
								<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_1">
							</div>
							<div class="form-group">
								<label>'.$lang[your].' '.$receive.' '.$lang[account].'</label>
								<input type="text" class="form-control input-lg form_style_1" name="bit_u_field_2">
							</div>
							<input type="hidden" name="bit_gateway_send" value="'.$bit_gateway_send.'">
							<input type="hidden" name="bit_gateway_receive" value="'.$bit_gateway_receive.'">
							<input type="hidden" name="bit_amount_send" value="'.$bit_amount_send.'">
							<input type="hidden" name="bit_amount_receive" value="'.$bit_amount_receive.'">
							<input type="hidden" name="bit_rate_from" value="'.$bit_rate_from.'">
							<input type="hidden" name="bit_rate_to" value="'.$bit_rate_to.'">
							<input type="hidden" name="bit_currency_from" value="'.$bit_currency_from.'">
							<input type="hidden" name="bit_currency_to" value="'.$bit_currency_to.'">
							<center>
								<button type="button" class="btn btn-primary btn-lg" onclick="bit_exchange_step_3();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i> '.$lang[btn_process_exchange].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</center>
						</form>
					</div>
					<div class="col-md-2"></div>
				</div>';
		}
	}
	$data['msg'] = $html_form;
}
echo json_encode($data);
?>