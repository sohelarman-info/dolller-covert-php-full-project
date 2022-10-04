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
$id = protect($_GET['id']);
$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
if($query->num_rows>0) {	
	$row = $query->fetch_assoc();
	$update = $db->query("UPDATE bit_exchanges SET status='2' WHERE id='$id'");
	$gateway_send = gatewayinfo($row['gateway_send'],"name");
	if(gatewayinfo($row[gateway_send],"include_fee") == "1") {
		if (strpos(gatewayinfo($row[gateway_send],"extra_fee"),'%') !== false) { 
			$amount = $row['amount_send'];
			$explode = explode("%",gatewayinfo($row[gateway_send],"extra_fee"));
			$fee_percent = 100+$explode[0];
			$new_amount = ($amount * 100) / $fee_percent;
			$new_amount = round($new_amount,2);
			$fee_amount = $amount-$new_amount;
			$amount = $amount+$fee_amount;
			$fee_text = gatewayinfo($row[gateway_send],"extra_fee");
		} else {
			$amount = $row['amount_send'] + gatewayinfo($row[gateway_send],"extra_fee");
			$fee_text = gatewayinfo($row[gateway_send],"extra_fee")." ".gatewayinfo($row[gateway_send],"currency");
		}
		$currency = gatewayinfo($row[gateway_send],"currency");
	} else {
		$amount = $row['amount_send'];
		$currency = gatewayinfo($row[gateway_send],"currency");
		$fee_text = '0';
	}
	if($gateway_send == "Bank Transfer") {
	?>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div id="bit_transaction_results"><?php echo info("You need to make payment manually, use the data below and enter the number of the transaction in the form below."); ?></div>
			<form id="bit_confirm_transaction">
			<table class="table table-striped">
				<tr>
					<td colspan="2"><h4><?php echo $lang['data_about_transfer']; ?></h4></td>
				</tr>
				<?php if(gatewayinfo($row['gateway_send'],"exchange_type") == "2" or gatewayinfo($row['gateway_send'],"exchange_type") == "3") { ?>
				<tr>
					<td colspan="2"><?php echo $lang['exchange_was_manually']; ?> <?php echo $settings['worktime_from']; ?> - <?php echo $settings['worktime_to']; ?>, <?php echo $settings['worktime_gmt'] ;?></td>
				</tr>
				<?php } ?>
				<tr>
					<td><span class="pull-left"><?php echo $lang['our']; ?> <?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo $lang['details']; ?></span></td>
					<td><span class="pull-right"><?php echo gatewayinfo($row['gateway_send'],"a_field_1"); ?><br/>
												<?php echo gatewayinfo($row['gateway_send'],"a_field_2"); ?><br/>
												<?php echo gatewayinfo($row['gateway_send'],"a_field_3"); ?><br/>
												<?php echo gatewayinfo($row['gateway_send'],"a_field_4"); ?><br/>
												<?php echo gatewayinfo($row['gateway_send'],"a_field_5"); ?></span></td>
				</tr>
				<tr>
					<td><span class="pull-left"><?php echo $lang['enter_payment_amount']; ?></span></td>
					<td><span class="pull-right"><?php echo $amount; ?> <?php echo $currency; ?></span></td>
				</tr>
				<tr>
					<td><span class="pull-left"><?php echo $lang['enter_payment_description']; ?></span></td>
					<td><span class="pull-right">Exchange <?php echo $row['amount_send']; ?> <?php echo $currency; ?> (<?php echo $row['id']; ?>)</span></td>
				</tr>
			</table>
				<div class="form-group">
					<label><?php echo $lang['enter_transaction_number']; ?></label>
					<input type="text" class="form-control" name="transaction_id">
				</div>
				<button type="button" onclick="bit_confirm_transaction('<?php echo $row['id']; ?>');" class="btn btn-primary btn-block"><?php echo $lang['btn_confirm_transaction']; ?></button>
			</form>
		</div>
		<div class="col-md-2"></div>
	</div>
	<?php
	} elseif($gateway_send == "Western Union" or $gateway_send == "Monetgram") {
	?>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div id="bit_transaction_results"><?php echo info("$lang[info_11]"); ?></div>
			<form id="bit_confirm_transaction">
			<table class="table table-striped">
				<tr>
					<td colspan="2"><h4><?php echo $lang['data_about_transfer']; ?></h4></td>
				</tr>
				<?php if(gatewayinfo($row['gateway_send'],"exchange_type") == "2" or gatewayinfo($row['gateway_send'],"exchange_type") == "3") { ?>
				<tr>
					<td colspan="2"><?php echo $lang['exchange_was_manually']; ?> <?php echo $settings['worktime_from']; ?> - <?php echo $settings['worktime_to']; ?>, <?php echo $settings['worktime_gmt'] ;?></td>
				</tr>
				<?php } ?>
				<tr>
					<td><span class="pull-left"><?php echo $lang['our']; ?> <?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo $lang['details']; ?></span></td>
					<td><span class="pull-right"><?php echo gatewayinfo($row['gateway_send'],"a_field_1"); ?><br/><?php echo gatewayinfo($row['gateway_send'],"a_field_2"); ?></span></td>
				</tr>
				<tr>
					<td><span class="pull-left"><?php echo $lang['enter_payment_amount']; ?></span></td>
					<td><span class="pull-right"><?php echo $amount; ?> <?php echo $currency; ?></span></td>
				</tr>
				<tr>
					<td><span class="pull-left"><?php echo $lang['enter_payment_description']; ?></span></td>
					<td><span class="pull-right">Exchange <?php echo $row['amount_send']; ?> <?php echo $currency; ?> (<?php echo $row['id']; ?>)</span></td>
				</tr>
			</table>
				<div class="form-group">
					<label><?php echo $lang['enter']; ?> <?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo $lang['pin_code']; ?></label>
					<input type="text" class="form-control" name="transaction_id">
				</div>
				<button type="button" onclick="bit_confirm_transaction('<?php echo $row['id']; ?>');" class="btn btn-primary btn-block"><?php echo $lang['btn_confirm_transaction']; ?></button>
			</form>
		</div>
		<div class="col-md-2"></div>
	</div>
	<?php
	} elseif($gateway_send == "Bitcoin" or $gateway_send == "Litecoin" or $gateway_send == "Dogecoin" or $gateway_send == "Dash" or $gateway_send == "Peercoin" or $gateway_send == "Ethereum") {
	?>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div id="bit_transaction_results"><?php echo info("$lang[info_11]"); ?></div>
			<form id="bit_confirm_transaction">
			<table class="table table-striped">
				<tr>
					<td colspan="2"><h4><?php echo $lang['data_about_transfer']; ?></h4></td>
				</tr>
				<?php if(gatewayinfo($row['gateway_send'],"exchange_type") == "2" or gatewayinfo($row['gateway_send'],"exchange_type") == "3") { ?>
				<tr>
					<td colspan="2"><?php echo $lang['exchange_was_manually']; ?> <?php echo $settings['worktime_from']; ?> - <?php echo $settings['worktime_to']; ?>, <?php echo $settings['worktime_gmt'] ;?></td>
				</tr>
				<?php } ?>
				<tr>
					<td><span class="pull-left"><?php echo $lang['our']; ?> <?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo $lang['address']; ?></span></td>
					<td><span class="pull-right"><?php echo gatewayinfo($row['gateway_send'],"a_field_1"); ?></span></td>
				</tr>
				<tr>
					<td><span class="pull-left"><?php echo $lang['enter_payment_amount']; ?></span></td>
					<td><span class="pull-right"><?php echo $amount; ?> <?php echo $currency; ?></span></td>
				</tr>
				<tr>
					<td><span class="pull-left"><?php echo $lang['enter_payment_description']; ?></span></td>
					<td><span class="pull-right">Exchange <?php echo $row['amount_send']; ?> <?php echo $currency; ?> (<?php echo $row['id']; ?>)</span></td>
				</tr>
			</table>
				<div class="form-group">
					<label><?php echo $lang['enter_transaction_number']; ?></label>
					<input type="text" class="form-control" name="transaction_id">
				</div>
				<button type="button" onclick="bit_confirm_transaction('<?php echo $row['id']; ?>');" class="btn btn-primary btn-block"><?php echo $lang['btn_confirm_transaction']; ?></button>
			</form>
		</div>
		<div class="col-md-2"></div>
	</div>
	<?php
	} elseif($gateway_send == "Xoomwallet" or $gateway_send == "Neteller" or $gateway_send == "UQUID" or $gateway_send == "Yandex Money" or $gateway_send == "QIWI" or $gateway_send == "BTC-e" or $gateway_send == "2checkout") {
	?>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div id="bit_transaction_results"><?php echo info("You need to make payment manually, use the data below and enter the number of the transaction in the form below."); ?></div>
			<form id="bit_confirm_transaction">
			<table class="table table-striped">
				<tr>
					<td colspan="2"><h4><?php echo $lang['data_about_transfer']; ?></h4></td>
				</tr>
				<?php if(gatewayinfo($row['gateway_send'],"exchange_type") == "2" or gatewayinfo($row['gateway_send'],"exchange_type") == "3") { ?>
				<tr>
					<td colspan="2"><?php echo $lang['exchange_was_manually']; ?> <?php echo $settings['worktime_from']; ?> - <?php echo $settings['worktime_to']; ?>, <?php echo $settings['worktime_gmt'] ;?></td>
				</tr>
				<?php } ?>
				<tr>
					<td><span class="pull-left"><?php echo $lang['our']; ?> <?php echo gatewayinfo($row['gateway_send'],"name"); ?> account</span></td>
					<td><span class="pull-right"><?php echo gatewayinfo($row['gateway_send'],"a_field_1"); ?></span></td>
				</tr>
				<tr>
					<td><span class="pull-left"><?php echo $lang['enter_payment_amount']; ?></span></td>
					<td><span class="pull-right"><?php echo $amount; ?> <?php echo $currency; ?></span></td>
				</tr>
				<tr>
					<td><span class="pull-left"><?php echo $lang['enter_payment_description']; ?></span></td>
					<td><span class="pull-right">Exchange <?php echo $row['amount_send']; ?> <?php echo $currency; ?> (<?php echo $row['id']; ?>)</span></td>
				</tr>
			</table>
				<div class="form-group">
					<label><?php echo $lang['enter_transaction_number']; ?></label>
					<input type="text" class="form-control" name="transaction_id">
				</div>
				<button type="button" onclick="bit_confirm_transaction('<?php echo $row['id']; ?>');" class="btn btn-primary btn-block"><?php echo $lang['btn_confirm_transaction']; ?></button>
			</form>
		</div>
		<div class="col-md-2"></div>
	</div>
	<?php
	} elseif($gateway_send == "PayPal") {
		include("../includes/paypal_class.php");
		define('EMAIL_ADD', gatewayinfo($row[gateway_send],"a_field_1")); // For system notification.
		define('PAYPAL_EMAIL_ADD', gatewayinfo($row[gateway_send],"a_field_1"));
	
		// Setup class
		$p = new paypal_class( ); 				 // initiate an instance of the class.
		$p -> admin_mail = EMAIL_ADD; 
		$this_script = $settings['url']."payment.php?b=check&c=paypal&eid=".$row[id];
		$p->add_field('business', PAYPAL_EMAIL_ADD); //don't need add this item. if y set the $p -> paypal_mail.
		$p->add_field('return', $this_script.'&action=success');
		$p->add_field('cancel_return', $this_script.'&action=cancel');
		$p->add_field('notify_url', $this_script.'&action=ipn');
		$p->add_field('item_name', 'Exchange '.$amount.' '.$currency.' ('.$row[id].')');
		$p->add_field('item_number', $row['id']);
		$p->add_field('amount', $amount);
		$p->add_field('currency_code', $currency);
		$p->add_field('cmd', '_xclick');
		$p->add_field('rm', '2');	// Return method = POST
						 
		$p->submit_paypal_post(); // submit the fields to paypal
		$return = '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#paypal_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;
	} elseif($gateway_send == "Skrill") {
		$return = '<div style="display:none;"><form action="https://www.moneybookers.com/app/payment.pl" method="post" id="skrill_form">
					  <input type="hidden" name="pay_to_email" value="'.gatewayinfo($row[gateway_send],"a_field_1").'"/>
					  <input type="hidden" name="status_url" value="'.$settings[url].'payment.php?b=check&c=skrill"/> 
					  <input type="hidden" name="language" value="EN"/>
					  <input type="hidden" name="amount" value="'.$amount.'"/>
					  <input type="hidden" name="currency" value="'.$currency.'"/>
					  <input type="hidden" name="detail1_description" value="Exchange '.$amount.' '.$currency.' ('.$row[id].')"/>
					  <input type="hidden" name="detail1_text" value="'.$row[id].'"/>
					  <input type="submit" class="btn btn-primary" value="Click to pay."/>
					</form></div>';
		$return .= '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#skrill_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;
	} elseif($gateway_send == "WebMoney") {
		include("../includes/webmoney.inc.php");
		$paymentno = intval($row['id']);
		$wm_request = new WM_Request();
		  $wm_request->payment_amount = $amount;
		  $wm_request->payment_desc = 'Exchange '.$amount.' '.$currency.' ('.$row[id].')';
		  $wm_request->payment_no = $paymentno;
		  $wm_request->payee_purse = gatewayinfo($row['gateway_send'],"a_field_1");
		  $wm_request->sim_mode = WM_ALL_SUCCESS;
		  $wm_request->result_url = $settings['url']."payment.php?b=check&c=webmoney&d=result";
		  $wm_request->success_url = $settings['url']."payment.php?b=check&c=webmoney&d=success";
		  $wm_request->success_method = WM_POST;
		  $wm_request->fail_url = $settings['url']."payment.php?b=check&c=webmoney&d=fail";
		  $wm_request->fail_method = WM_POST;
		  $wm_request->extra_fields = array('FIELD1'=>'VALUE 1', 'FIELD2'=>'VALUE 2');
		  $wm_action = 'https://merchant.wmtransfer.com/lmi/payment.asp';
		  $wm_btn_label = 'Pay Webmoney';
		  $wm_request->SetForm();
			$return .= '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#webmoney_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;
	} elseif($gateway_send == "Payeer") {
		$m_shop = gatewayinfo($row['gateway_send'],"a_field_1");
		$m_orderid = $row['id'];
		$m_amount = number_format($amount, 2, '.', '');
		$m_curr = $currency;
		$desc = 'Exchange '.$amount.' '.$currency.' ('.$row[id].')';
		$m_desc = base64_encode($desc);
		$m_key = gatewayinfo($row['gateway_send'],"a_field_2");

		$arHash = array(
			$m_shop,
			$m_orderid,
			$m_amount,
			$m_curr,
			$m_desc,
			$m_key
		);
		$sign = strtoupper(hash('sha256', implode(':', $arHash)));
		$return = '<div style="display:none;"><form method="GET" id="payeer_form" action="https://payeer.com/merchant/">
		<input type="hidden" name="m_shop" value="'.$m_shop.'">
		<input type="hidden" name="m_orderid" value="'.$m_orderid.'">
		<input type="hidden" name="m_amount" value="'.$m_amount.'">
		<input type="hidden" name="m_curr" value="'.$m_curr.'">
		<input type="hidden" name="m_desc" value="'.$m_desc.'">
		<input type="hidden" name="m_sign" value="'.$sign.'">
		<!--
		<input type="hidden" name="form[ps]" value="2609">
		<input type="hidden" name="form[curr[2609]]" value="USD">
		-->
		<input type="submit" name="m_process" value="Pay with Payeer" />
		</form></div>';
		$return .= '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#payeer_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;
	} elseif($gateway_send == "Perfect Money") {
		$return = '<div style="display:none;">
				<form action="https://perfectmoney.is/api/step1.asp" id="pm_form" method="POST">
					<input type="hidden" name="PAYEE_ACCOUNT" value="'.gatewayinfo($row[gateway_send],"a_field_1").'">
					<input type="hidden" name="PAYEE_NAME" value="'.$settings[name].'">
					<input type="hidden" name="PAYMENT_ID" value="'.$row[id].'">
					<input type="text"   name="PAYMENT_AMOUNT" value="'.$amount.'"><BR>
					<input type="hidden" name="PAYMENT_UNITS" value="'.$currency.'">
					<input type="hidden" name="STATUS_URL" value="'.$settings[url].'payment.php?b=check&c=perfectmoney&d=status">
					<input type="hidden" name="PAYMENT_URL" value="'.$settings[url].'payment.php?b=check&c=perfectmoney&d=complete">
					<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="NOPAYMENT_URL" value="'.$settings[url].'payment.php?b=check&c=perfectmoney&d=failed">
					<input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="SUGGESTED_MEMO" value="">
					<input type="hidden" name="BAGGAGE_FIELDS" value="IDENT"><br>
					<input type="submit" name="PAYMENT_METHOD" value="Pay Now!" class="tabeladugme"><br><br>
					</form></div>';
		$return .= '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#pm_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;
	} elseif($gateway_send == "AdvCash") {
		$arHash = array(
			gatewayinfo($row[gateway_send],"a_field_1"),
			$settings[name],
			$amount,
			$currency,
			gatewayinfo($row[gateway_send],"a_field_2"),
			$row[id]
		);
		$sign = strtoupper(hash('sha256', implode(':', $arHash)));
		$return = '<div style="display:none;">
					<form method="GET" id="advcash_form" action="https://wallet.advcash.com/sci/">
					<input type="hidden" name="ac_account_email" value="'.gatewayinfo($row[gateway_send],"a_field_1").'">
					<input type="hidden" name="ac_sci_name" value="'.$settings[name].'">
					<input type="hidden" name="ac_amount" value="'.$amount.'">
					<input type="hidden" name="ac_currency" value="'.$currency.'">
					<input type="hidden" name="ac_order_id" value="'.$row[id].'">
					<input type="hidden" name="ac_sign"
					value="'.$sign.'">
					<input type="hidden" name="ac_success_url" value="'.$settings[url].'payment.php?b=check&c=advcash&d=success" />
					 <input type="hidden" name="ac_success_url_method" value="GET" />
					 <input type="hidden" name="ac_fail_url" value="'.$settings[url].'payment.php?b=check&c=advcash&d=fail" />
					 <input type="hidden" name="ac_fail_url_method" value="GET" />
					 <input type="hidden" name="ac_status_url" value="'.$settings[url].'payment.php?b=check&c=advcash&d=status" />
					 <input type="hidden" name="ac_status_url_method" value="GET" />
					<input type="hidden" name="ac_comments" value="Exchange '.$amount.' '.$currency.' ('.$row[id].')">
					</form>
					</div>';
		$return .= '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#advcash_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;
	} elseif($gateway_send == "OKPay") {
		$return = '<form  method="post" id="okpay_form" action="https://checkout.okpay.com/">
					   <input type="hidden" name="ok_receiver" value="'.gatewayinfo($row[gateway_send],"a_field_1").'"/>
					   <input type="hidden" name="ok_item_1_name" value="Exchange '.$amount.' '.$currency.'"/>
					   <input type="hidden" name="ok_item_1_price" value="'.$amount.'"/>
					   <input type="hidden" name="ok_item_1_id" value="'.$row[id].'"/>
					   <input type="hidden" name="ok_currency" value="'.$currency.'"/>
					</form>';
		$return .= '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#okpay_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;
	} elseif($gateway_send == "Entromoney") {
		include("../includes/entromoney.php");
		$config = array();
		$config['sci_user'] = gatewayinfo($row['gateway_send'],"a_field_1");
		$config['sci_id'] 	= gatewayinfo($row['gateway_send'],"a_field_2");
		$config['sci_pass'] = gatewayinfo($row['gateway_send'],"a_field_3");
		$config['receiver'] = gatewayinfo($row['gateway_send'],"a_field_4");

		// Call lib sci
		try {
			$sci = new Paygate_Sci($config);
		}
		catch (Paygate_Exception $e) {
			exit($e->getMessage());
		}
		$return = '';
		$input = array();
		$input['sci_user'] 		= $config['sci_user'];
		$input['sci_id'] 		= $config['sci_id'];
		$input['receiver'] 		= $config['receiver'];
		$input['amount'] 		= $amount;
		$input['desc'] 			= 'Exchange '.$amount.' '.$currency.' ('.$row[id].')';
		$input['payment_id'] 	= $row['id'];
		$input['up_1'] 			= 'user_param_1';
		$input['up_2'] 			= 'user_param_2';
		$input['up_3'] 			= 'user_param_3';
		$input['up_4'] 			= 'user_param_4';
		$input['up_5'] 			= 'user_param_5';
		$input['url_status'] 	= $settings[url].'payment.php?b=check&c=entromoney&d=status';
		$input['url_success'] 	= $settings[url].'payment.php?b=check&c=entromoney&d=success';
		$input['url_fail'] 		= $settings[url].'payment.php?b=check&c=entromoney&d=fail';

		// Create hash
		$input['hash']			= $sci->create_hash($input);
		?>
		<form action="<?php echo Paygate_Sci::URL_SCI; ?>" id="entromoney_form" method="post">
			<?php foreach ($input as $p => $v): ?>
				<input type="hidden" name="<?php echo $p; ?>" value="<?php echo $v; ?>">
			<?php endforeach; ?>
		</form>
		<?php
		$return .= '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#entromoney_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;	
	} elseif($gateway_send == "SolidTrust Pay") {
		$return = ' <form action="https://solidtrustpay.com/handle.php" method="post" id="solid_form">
						<input type=hidden name="merchantAccount" value="'.gatewayinfo($row[gateway_send],"a_field_1").'" />
						<input type="hidden" name="sci_name" value="'.gatewayinfo($row[gateway_send],"a_field_2").'">
						<input type="hidden" name="amount" value="'.$amount.'">
						<input type=hidden name="currency" value="'.$currency.'" />
						 <input type="hidden" name="notify_url" value="'.$settings[url].'payment.php?b=check&c=solidtrustpay&d=notify">
						  <input type="hidden" name="confirm_url" value="'.$settings[url].'payment.php?b=check&c=solidtrustpay&d=confirm">
						   <input type="hidden" name="return_url" value="'.$settings[url].'payment.php?b=check&c=solidtrustpay&d=return">
						<input type=hidden name="item_id" value="Exchange: '.$amount.' '.$currency.' ('.$row[id].')" />
						<input type=hidden name="user1" value="'.$row[id].'" />
					  </form>';
		$return .= '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#solid_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;	
	} elseif($gateway_send == "Payza") {
		$return = '<form method="post" id="payza_form" action="https://secure.payza.com/checkout" >
				<input type="hidden" name="ap_merchant" value="'.gatewayinfo($row[gateway_send],"a_field_1").'"/>
				<input type="hidden" name="ap_purchasetype" value="item-goods"/>
				<input type="hidden" name="ap_itemname" value="Exchange '.$amount.' '.$currency.' ('.$row[id].')"/>
				<input type="hidden" name="ap_amount" value="'.$amount.'"/>
				<input type="hidden" name="ap_currency" value="'.$currency.'"/>

				<input type="hidden" name="ap_quantity" value="1"/>
				<input type="hidden" name="ap_itemcode" value="'.$row[id].'"/>
				<input type="hidden" name="ap_description" value=""/>
				<input type="hidden" name="ap_returnurl" value="'.$settings[url].'payment.php?b=check&c=payza&d=results"/>
				<input type="hidden" name="ap_cancelurl" value="'.$settings[url].'payment.php?b=check&c=payza&d=cancel"/>

				<input type="hidden" name="ap_taxamount" value="0"/>
				<input type="hidden" name="ap_additionalcharges" value="0"/>
				<input type="hidden" name="ap_shippingcharges" value="0"/> 

				<input type="hidden" name="ap_discountamount" value="0"/> 
				<input type="hidden" name="apc_1" value="Blue"/>

			</form>';
		$return .= '<script type="text/javascript" src="'.$settings[url].'assets/js/jquery-1.10.2.js"></script>';
		$return .= '<script type="text/javascript">$(document).ready(function() { $("#payza_form").submit(); });</script>';
		$return .= '<div id="processing" class="ex_padding"><center><i class="fa fa-spin fa-refresh" style="font-size:90px;"></i><br/><h3>'.$lang[redirecting_to_secure].'</h3></center></div>';
		echo $return;	
	} else {
		$check = $db->query("SELECT * FROM bit_gateways WHERE name='$gateway_send' and external_gateway='1'");
		if($check->num_rows>0) {
			$r = $check->fetch_assoc();
			$fieldsquery = $db->query("SELECT * FROM bit_gateways_fields WHERE gateway_id='$r[id]' ORDER BY id");
			if($fieldsquery->num_rows>0) {
				while($field = $fieldsquery->fetch_assoc()) {
					$field_number = $field['field_number'];
					$fild = 'a_field_'.$field_number;
					$ret = $r[$fild];
					$account_data .= '<tr>
							<td><span class="pull-left">'.$field[field_name].'</span></td>
							<td><span class="pull-right">'.$ret.'</span></td>
					</tr>';
				}
			}
			?>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div id="bit_transaction_results"><?php echo info("You need to make payment manually, use the data below and enter the number of the transaction in the form below."); ?></div>
					<form id="bit_confirm_transaction">
					<table class="table table-striped">
						<tr>
							<td colspan="2"><h4><?php echo $lang['data_about_transfer']; ?></h4></td>
						</tr>
						<?php if(gatewayinfo($row['gateway_send'],"exchange_type") == "2" or gatewayinfo($row['gateway_send'],"exchange_type") == "3") { ?>
						<tr>
							<td colspan="2"><?php echo $lang['exchange_was_manually']; ?> <?php echo $settings['worktime_from']; ?> - <?php echo $settings['worktime_to']; ?>, <?php echo $settings['worktime_gmt'] ;?></td>
						</tr>
						<tr>
							<td colspan="2"><br></td>
						</tr>
						<?php } ?>
						<tr>
							<td><span class="pull-left"><?php echo $lang['our']; ?> <?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo $lang['details']; ?></span></td>
							<td><span class="pull-right"></span></td>
						</tr>
						<?php echo $account_data; ?>
						<tr>
							<td colspan="2"><br></td>
						</tr>
						<tr>
							<td><span class="pull-left"><?php echo $lang['enter_payment_amount']; ?></span></td>
							<td><span class="pull-right"><?php echo $amount; ?> <?php echo $currency; ?></span></td>
						</tr>
						<tr>
							<td><span class="pull-left"><?php echo $lang['enter_payment_description']; ?></span></td>
							<td><span class="pull-right">Exchange <?php echo $row['amount_send']; ?> <?php echo $currency; ?> (<?php echo $row['id']; ?>)</span></td>
						</tr>
					</table>
						<div class="form-group">
							<label><?php echo $lang['enter_transaction_number']; ?></label>
							<input type="text" class="form-control" name="transaction_id">
						</div>
						<button type="button" onclick="bit_confirm_transaction('<?php echo $row['id']; ?>');" class="btn btn-primary btn-block"><?php echo $lang['btn_confirm_transaction']; ?></button>
					</form>
				</div>
				<div class="col-md-2"></div>
			</div>
			<?php
		} else {
			echo error("We do not support this gateway. Please contact with administrator.");
		}
	}
} else {
	echo error("Something was wrong.. Please refresh page.");
}
?>