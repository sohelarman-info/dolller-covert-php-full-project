<?php
error_reporting(0);
ob_start();
session_start(); 
if(file_exists("../install.php")) {
	header("Location: ../install.php");
} 
include("../includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM bit_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("../includes/functions.php");
$a = protect($_GET['a']);

if(checkAdminSession()) {
	include("sources/admin/header.php");
	switch($a) {
		case "gateways": include("sources/admin/gateways.php"); break;
		case "rates": include("sources/admin/rates.php"); break;
		case "exchanges": include("sources/admin/exchanges.php"); break;
		case "users": include("sources/admin/users.php"); break;
		case "testimonials": include("sources/admin/testimonials.php"); break;
		case "withdrawals": include("sources/admin/withdrawals.php"); break;
		case "pages": include("sources/admin/pages.php"); break;
		case "faq": include("sources/admin/faq.php"); break;
		case "settings": include("sources/admin/settings.php"); break;
		case "deposits": include("sources/admin/deposits.php"); break;
		case "logout": 
			unset($_SESSION['bit_admin_uid']);
			session_unset();
			session_destroy();
			header("Location: ./");
		break;
		default: include("sources/admin/dashboard.php"); 
	}
	include("sources/admin/footer.php");
} elseif(checkOperatorSession()) {
	include("sources/operator/header.php");
	switch($a) {
		case "exchanges": include("sources/operator/exchanges.php"); break; 
		case "testimonials": include("sources/operator/testimonials.php"); break;
		case "withdrawals": include("sources/operator/withdrawals.php"); break;
		case "deposits": include("sources/operator/deposits.php"); break;
		case "logout": 
			unset($_SESSION['bit_operator_uid']);
			session_unset();
			session_destroy();
			header("Location: ./");
		break;
		default: include("sources/operator/dashboard.php"); 
	}
	include("sources/operator/footer.php");
} else { 
	include("sources/login.php");
}
mysqli_close($db);
?>