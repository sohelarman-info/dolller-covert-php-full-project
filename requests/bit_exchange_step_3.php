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
$receive = gatewayinfo($bit_gateway_receive,"name");
$bit_amount_send = protect($_POST['bit_amount_send']);
$bit_amount_receive = protect($_POST['bit_amount_receive']);
$bit_rate_from = protect($_POST['bit_rate_from']);
$bit_rate_to = protect($_POST['bit_rate_to']);
$bit_currency_from = protect($_POST['bit_currency_from']);
$bit_currency_to = protect($_POST['bit_currency_to']);
$bit_u_field_1 = protect($_POST['bit_u_field_1']);
$bit_u_field_2 = protect($_POST['bit_u_field_2']);
$bit_u_field_3 = protect($_POST['bit_u_field_3']);
$bit_u_field_4 = protect($_POST['bit_u_field_4']);
$bit_u_field_5 = protect($_POST['bit_u_field_5']);
$bit_u_field_6 = protect($_POST['bit_u_field_6']);
$bit_u_field_7 = protect($_POST['bit_u_field_7']);
$bit_u_field_8 = protect($_POST['bit_u_field_8']);
$bit_u_field_9 = protect($_POST['bit_u_field_9']);
$bit_u_field_10 = protect($_POST['bit_u_field_10']);
if(!isValidEmail($bit_u_field_1)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_38]");
} elseif($receive == "Western Union" && empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_39]");
} elseif($receive == "Western Union" && empty($bit_u_field_3)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_40]");
} elseif($receive == "Moneygram" && empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_39]");
} elseif($receive == "Moneygram" && empty($bit_u_field_3)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_40]");
} elseif($receive == "Bank Transfer" && empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_39]");
} elseif($receive == "Bank Transfer" && empty($bit_u_field_3)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_40]");
} elseif($receive == "Bank Transfer" && empty($bit_u_field_4)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_41]");
}  elseif($receive == "Bank Transfer" && empty($bit_u_field_5)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_42]");
}  elseif($receive == "Bank Transfer" && empty($bit_u_field_6)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_43]");
} elseif($receive == "Bitcoin" && empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_44] $receive $lang[address].");
} elseif($receive == "Litecoin" && empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_44] $receive $lang[address].");
} elseif($receive == "Dogecoin" && empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_44] $receive $lang[address].");
} elseif($receive == "Dash" && empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_44] $receive $lang[address].");
} elseif($receive == "Peercoin" && empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_44] $receive $lang[address].");
} elseif($receive == "Ethereum" && empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_44] $receive $lang[address].");
} elseif(empty($bit_u_field_2)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_44] $receive $lang[account].");
} else {
	if(checkSession()) { $uid = $_SESSION['bit_uid']; } else { $uid = 0; }
	if($_SESSION['refid']) { $referral_id = $_SESSION['refid']; } else { $referral_id = 0; }
	$ip = $_SERVER['REMOTE_ADDR'];
	$time = time();
	$exchange_id = randomHash(20);
	$exchange_id = strtoupper($exchange_id);
	$insert = $db->query("INSERT bit_exchanges (uid,gateway_send,gateway_receive,amount_send,amount_receive,rate_from,rate_to,status,created,updated,expired,u_field_1,u_field_2,u_field_3,u_field_4,u_field_5,u_field_6,u_field_7,u_field_8,u_field_9,u_field_10,ip,exchange_id,referral_id,referral_status) VALUES ('$uid','$bit_gateway_send','$bit_gateway_receive','$bit_amount_send','$bit_amount_receive','$bit_rate_from','$bit_rate_to','1','$time','0','0','$bit_u_field_1','$bit_u_field_2','$bit_u_field_3','$bit_u_field_4','$bit_u_field_5','$bit_u_field_6','$bit_u_field_7','$bit_u_field_8','$bit_u_field_9','$bit_u_field_10','$ip','$exchange_id','$referral_id','0')");
	$query = $db->query("SELECT * FROM bit_exchanges WHERE exchange_id='$exchange_id'");
	$row = $query->fetch_assoc();
	emailsys_new_exchange($row['id']);
	$_SESSION['bit_requested_exchange_id'] = $row['exchange_id'];
	if(gatewayinfo($bit_gateway_send,"include_fee") == "1") {
		if (strpos(gatewayinfo($bit_gateway_send,"extra_fee"),'%') !== false) { 
				$amount = $bit_amount_send;
			$explode = explode("%",gatewayinfo($bit_gateway_send,"extra_fee"));
			$fee_percent = 100+$explode[0];
			$new_amount = ($amount * 100) / $fee_percent;
			$new_amount = round($new_amount,2);
			$fee_amount = $amount-$new_amount;
			$amount = $amount+$fee_amount;
			$fee_text = gatewayinfo($bit_gateway_send,"extra_fee");
		} else {
			$amount = $bit_amount_send + gatewayinfo($bit_gateway_send,"extra_fee");
			$fee_text = gatewayinfo($bit_gateway_send,"extra_fee")." ".gatewayinfo($bit_gateway_send,"currency");
		}
		$currency = $bit_currency_from;
	} else {
		$amount = $bit_amount_send;
		$currency = $bit_currency_from;
		$fee_text = '0';
	}
	$data['status'] = 'success';
	if($receive == "Bank Transfer") {
		$account_data = '<tr>
							<td><span class="pull-left">'.$lang[your_name].'</span></td>
							<td><span class="pull-right">'.$row[u_field_2].'</span></td>
					</tr><tr>
							<td><span class="pull-left">'.$lang[your_location].'</span></td>
							<td><span class="pull-right">'.$row[u_field_3].'</span></td>
					</tr><tr>
							<td><span class="pull-left">'.$lang[your_bank_name].'</span></td>
							<td><span class="pull-right">'.$row[u_field_4].'</span></td>
					</tr><tr>
							<td><span class="pull-left">'.$lang[your_bank_account].'</span></td>
							<td><span class="pull-right">'.$row[u_field_5].'</span></td>
					</tr><tr>
							<td><span class="pull-left">'.$lang[your_bank_swift].'</span></td>
							<td><span class="pull-right">'.$row[u_field_6].'</span></td>
					</tr>';
	} elseif($receive == "Western Union" or $receive == "Moneygram") {
		$account_data = '<tr>
							<td><span class="pull-left">'.$lang[your_name].'</span></td>
							<td><span class="pull-right">'.$row[u_field_2].'</span></td>
					</tr><tr>
							<td><span class="pull-left">'.$lang[your_location].'</span></td>
							<td><span class="pull-right">'.$row[u_field_3].'</span></td>
					</tr>';
	} elseif($receive == "Bitcoin" or $receive == "Litecoin" or $receive == "Dogecoin" or $receive == "Dash" or $receive == "Peercoin" or $receive == "Ethereum") {
		$account_data = '<tr>
							<td><span class="pull-left">'.$lang[your].' '.$receive.' '.$lang[address].'</span></td>
							<td><span class="pull-right">'.$row[u_field_2].'</span></td>
					</tr>';
	} else {
		$account_data = '';
		$check = $db->query("SELECT * FROM bit_gateways WHERE name='$receive' and external_gateway='1'");
		if($check->num_rows>0) {
			$r = $check->fetch_assoc();
			$fieldsquery = $db->query("SELECT * FROM bit_gateways_fields WHERE gateway_id='$r[id]' ORDER BY id");
			if($fieldsquery->num_rows>0) {
				while($field = $fieldsquery->fetch_assoc()) {
					$field_number = $field['field_number']+1;
					$fild = 'u_field_'.$field_number;
					$ret = $row[$fild];
					$account_data .= '<tr>
							<td><span class="pull-left">'.$field[field_name].'</span></td>
							<td><span class="pull-right">'.$ret.'</span></td>
					</tr>';
				}
			}
		} else {
		$account_data = '<tr>
							<td><span class="pull-left">'.$lang[your].' '.$receive.' '.$lang[account].'</span></td>
							<td><span class="pull-right">'.$row[u_field_2].'</span></td>
					</tr>';
		}
	}
	if(gatewayinfo($row['gateway_send'],"exchange_type") == "2" or gatewayinfo($row['gateway_send'],"exchange_type") == "3") {
			$custom_msg = '	<tr>
					<td colspan="2">'.$lang[exchange_was_manually].' '.$settings[worktime_from].' - '.$settings[worktime_to].', '.$settings[worktime_gmt].'</td>
				</tr>';
	} else { $custom_msg = ''; }
	$html_form = '<div id="bit_exchange_results"></div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div>
									<table class="table table-striped">
										<tr>
											<td colspan="2"><h4>'.gatewayinfo($bit_gateway_send,"name").' '.gatewayinfo($bit_gateway_send,"currency").' <i class="fa fa-exchange"></i> '.gatewayinfo($bit_gateway_receive,"name").' '.gatewayinfo($bit_gateway_receive,"currency").'</h4></td>
										</tr>
										'.$custom_msg.'
										<tr>
											<td><span class="pull-left"><b>'.$lang[exchange_id].'</b></span></td>
											<td><span class="pull-right"><b>'.$row[exchange_id].'</span></td>
										</tr>
										<tr>
											<td><span class="pull-left">'.$lang[amount_send].'</span></td>
											<td><span class="pull-right">'.$row[amount_send].' '.$bit_currency_from.'</span></td>
										</tr>
										<tr>
											<td><span class="pull-left">'.$lang[amount_receive].'</span></td>
											<td><span class="pull-right">'.$row[amount_receive].' '.$bit_currency_to.'</span></td>
										</tr>
										'.$account_data.'
										<tr>
											<td><span class="pull-left">'.$lang[your_email].'</span></td>
											<td><span class="pull-right">'.$row[u_field_1].'</span></td>
										</tr>
									</table>
									<br>
									<table class="table table-striped">
										<tr>
											<td><span class="pull-left">'.gatewayinfo($bit_gateway_send,"name").' '.$lang[fee].'</span></td>
											<td><span class="pull-right">'.$fee_text.'</span></td>
										</tr>
										<tr>
											<td><span class="pull-left">'.$lang[total_for_payment].'</span></td>
											<td><span class="pull-right">'.$amount.' '.$currency.'</span></td>
										</tr>
									</table>
									<div class="row">
										<div class="col-sm-6 col-md-6 col-lg-6">
											<button type="button" class="btn btn-success btn-block" onclick="bit_make_exchange('.$row[id].');"><i class="fa fa-check"></i> '.$lang[btn_confirm_order].'</button>
											<br>
										</div>
										<div class="col-sm-6 col-md-6 col-lg-6">
											<button type="button" class="btn btn-danger btn-block" onclick="bit_cancel_exchange('.$row[id].');"><i class="fa fa-times"></i> '.$lang[btn_cancel_order].'</button>
											<br>
										</div>
									</div>
								</div>
				</div>
				<div class="col-md-2"></div>
			</div>';
	$data['msg'] = $html_form;
}
echo json_encode($data);
?>