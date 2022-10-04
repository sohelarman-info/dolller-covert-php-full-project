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
$gateway_send = protect($_GET['gateway_send']);
$gateway_receive = protect($_GET['gateway_receive']);
if(empty($gateway_send) or empty($gateway_receive)) {
	echo '-';
} else {
		echo gatewayinfo($gateway_receive,"reserve").' '.gatewayinfo($gateway_receive,"currency");
}
?>