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
$gateway_id = protect($_GET['gateway_id']);
if(empty($gateway_id)) {
	echo $settings['url']."assets/icons/Missing.png"; 
} else {
	$external_icon = 0;
	$name = gatewayinfo($gateway_id,"name");
	if($name == "PayPal") { $icon = 'PayPal.png'; }
	elseif($name == "Skrill") { $icon = 'Skrill.png'; }
	elseif($name == "WebMoney") { $icon = 'WebMoney.png'; }
	elseif($name == "Payeer") { $icon = 'Payeer.png'; }
	elseif($name == "Perfect Money") { $icon = 'PerfectMoney.png'; }
	elseif($name == "AdvCash") { $icon = 'AdvCash.png'; }
	elseif($name == "OKPay") { $icon = 'OKPay.png'; }
	elseif($name == "Entromoney") { $icon = 'Entromoney.png'; }
	elseif($name == "SolidTrust Pay") { $icon = 'SolidTrustPay.png'; }
	elseif($name == "2checkout") { $icon = '2checkout.png'; }
	elseif($name == "Litecoin") { $icon = 'Litecoin.png'; }
	elseif($name == "Neteller") { $icon = 'Neteller.png'; }
	elseif($name == "UQUID") { $icon = 'UQUID.png'; }
	elseif($name == "Dash") { $icon = 'Dash.png'; }
	elseif($name == "Dogecoin") { $icon = 'Dogecoin.png'; }
	elseif($name == "BTC-e") { $icon = 'BTCe.png'; }
	elseif($name == "Ethereum") { $icon = 'Ethereum.png'; }
	elseif($name == "Peercoin") { $icon = 'Peercoin.png'; }
	elseif($name == "Yandex Money") { $icon = 'YandexMoney.png'; }
	elseif($name == "QIWI") { $icon = 'QIWI.png'; }
	elseif($name == "Payza") { $icon = 'Payza.png'; }
	elseif($name == "Bitcoin") { $icon = 'Bitcoin.png'; }
	elseif($name == "Bank Transfer") { $icon = 'BankTransfer.png'; }
	elseif($name == "Western Union") { $icon = 'Westernunion.png'; }
	elseif($name == "Moneygram") { $icon = 'Moneygram.png'; }
	elseif($name == "TheBillioncoin") { $icon = 'TheBillioncoin.png'; }
	elseif($name == "Xoomwallet") { $icon = 'Xoomwallet.png'; }
	else {
		$check = $db->query("SELECT * FROM bit_gateways WHERE name='$name' and external_gateway='1'");
		if($check->num_rows>0) {
			$r = $check->fetch_assoc();
			$icon = $r['external_icon'];
			$external_icon = 1;
		} else {
			$iocn = "Missing.png";
		}
	}
	if($external_icon == "1") {
		echo $settings['url'].$icon;
	} else {
		echo $settings['url']."assets/icons/".$icon;
	}
}
?>