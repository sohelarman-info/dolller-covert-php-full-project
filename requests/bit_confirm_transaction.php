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
	$transaction_id = protect($_POST['transaction_id']);
	if(empty($transaction_id)) {
		$data['status'] = 'error';
		if(gatewayinfo($row['gateway_send'],"name") == "Western Union" or gatewayinfo($row['gateway_send'],"name") == "Moneygram") {
			$name = gatewayinfo($row['gateway_send'],"name");
			$data['msg'] = error("$lang[error_26]");
		} else {
			$data['msg'] = error("$lang[error_27]");
		}
	} else {
		$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$transaction_id' WHERE id='$id'");
		emailsys_exchange_change_status($row['id']);
		$data['status'] = 'success';
		$return = success("$lang[success_15]");
		$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
		$return .= info("$lang[info_10]:<br/><a href='$link' style='color:#fff;'>$link</a>");
		$data['msg'] = $return;
	}
} else {
	$data['status'] = 'error';
	$data['msg'] = error($lang['error_25']);
}
echo json_encode($data);
?>