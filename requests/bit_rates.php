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
$gateway_sendname = gatewayinfo($gateway_send,"name");
	$gateway_receivename = gatewayinfo($gateway_receive,"name");
if(empty($gateway_send) or empty($gateway_receive)) {
	$data['status'] = 'error';
	$data['msg'] = '-';
} else {
	$data['status'] = 'success';
	$currency_from = gatewayinfo($gateway_send,"currency");
	$currency_to = gatewayinfo($gateway_receive,"currency");
	$fee = gatewayinfo($gateway_receive,"fee");
	$query = $db->query("SELECT * FROM bit_rates WHERE gateway_from='$gateway_send' and gateway_to='$gateway_receive'");
			if($query->num_rows>0) {
				$row = $query->fetch_assoc();
				$data['status'] = 'success';
				$rate_from = $row['rate_from'];
				$rate_to = $row['rate_to'];
			} else {
					if($currency_from == $currency_to) { 
						$fee = str_ireplace("-","",$fee);
						$calculate1 = (1 * $fee) / 100;
						$calculate2 = 1 - $calculate1;
						$rate_from = 1;
						$rate_to = $calculate2;
					} elseif($currency_to == "BTC") {
						if(checkCryptoExchange($gateway_sendname,$gateway_receivename)) {
							$query = $db->query("SELECT * FROM bit_rates WHERE gateway_from='$gateway_send' and gateway_to='$gateway_receive'");
							if($query->num_rows>0) {
								$row = $query->fetch_assoc();
								$data['status'] = 'success';
								$rate_from = $row['rate_from'];
								$rate_to = $row['rate_to'];
							} else {
								$data['status'] = 'error';
								$data['msg'] = '-';
							}
						} else {
							$ch = curl_init();
										$url = "https://www.changer.com/api/v2/rates/bitcoin_BTC/payeer_USD";
										// Disable SSL verification
										curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
										// Will return the response, if false it print the response
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										// Set the url
										curl_setopt($ch, CURLOPT_URL,$url);
										// Execute
										$result=curl_exec($ch);
										// Closing
										curl_close($ch);
										$json = json_decode($result, true);
								$price = $json['rate'];
								$price = currencyConvertor($price,"USD",$currency_from);
								$calculate1 = ($price * $fee) / 100;
								$calculate2 = $price - $calculate1;
								$calculate2 = number_format($calculate2, 2, '.', '');
								$rate_to = 1;
								$rate_from = $calculate2;
						}
					}  elseif($currency_from == "BTC") {
						if(checkCryptoExchange($gateway_sendname,$gateway_receivename)) {
							$query = $db->query("SELECT * FROM bit_rates WHERE gateway_from='$gateway_send' and gateway_to='$gateway_receive'");
							if($query->num_rows>0) {
								$row = $query->fetch_assoc();
								$data['status'] = 'success';
								$rate_from = $row['rate_from'];
								$rate_to = $row['rate_to'];
							} else {
								$data['status'] = 'error';
								$data['msg'] = '-';
							}
						} else {
							$ch = curl_init();
										$url = "https://www.changer.com/api/v2/rates/bitcoin_BTC/payeer_USD";
										// Disable SSL verification
										curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
										// Will return the response, if false it print the response
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										// Set the url
										curl_setopt($ch, CURLOPT_URL,$url);
										// Execute
										$result=curl_exec($ch);
										// Closing
										curl_close($ch);
										$json = json_decode($result, true);
								$price = $json['rate'];
							$price = currencyConvertor($price,"USD",$currency_to);
							$calculate1 = ($price * $fee) / 100;
							$calculate2 = $price - $calculate1;
							$calculate2 = number_format($calculate2, 2, '.', '');
							$rate_from = 1;
							$rate_to = $calculate2;
						}
					} elseif(checkCryptoExchange($gateway_sendname,$gateway_receivename)) {
						$query = $db->query("SELECT * FROM bit_rates WHERE gateway_from='$gateway_send' and gateway_to='$gateway_receive'");
						if($query->num_rows>0) {
							$row = $query->fetch_assoc();
							$data['status'] = 'success';
							$rate_from = $row['rate_from'];
							$rate_to = $row['rate_to'];
						} else {
							$data['status'] = 'error';
							$data['msg'] = '-';
						}
					} else {
						if(isCrypto($gateway_sendname) == "1" && isCrypto($gateway_receivename) == "0") {
							$query = $db->query("SELECT * FROM bit_rates WHERE gateway_from='$gateway_send' and gateway_to='$gateway_receive'");
							if($query->num_rows>0) {
								$row = $query->fetch_assoc();
								$data['status'] = 'success';
								$rate_from = $row['rate_from'];
								$rate_to = $row['rate_to'];
							} else {
								$data['status'] = 'error';
								$data['msg'] = '-';
							}
						} elseif(isCrypto($gateway_sendname) == "0" && isCrypto($gateway_receivename) == "1") {
							$query = $db->query("SELECT * FROM bit_rates WHERE gateway_from='$gateway_send' and gateway_to='$gateway_receive'");
							if($query->num_rows>0) {
								$row = $query->fetch_assoc();
								$data['status'] = 'success';
								$rate_from = $row['rate_from'];
								$rate_to = $row['rate_to'];
							} else {
								$data['status'] = 'error';
								$data['msg'] = '-';
							}
						} else {
							$rate_from = 1;
							$calculate = currencyConvertor($rate_from,$currency_from,$currency_to);
							$calculate1 = ($calculate * $fee) / 100;
							$calculate2 = $calculate - $calculate1;
							if($calculate2 < 1) { 
								$calculate = currencyConvertor($rate_from,$currency_to,$currency_from);
								$calculate1 = ($calculate * $fee) / 100;
								$calculate2 = $calculate - $calculate1;
								$rate_from = number_format($calculate2, 2, '.', '');
								$rate_to = 1;
							} else {
								$rate_to = number_format($calculate2, 2, '.', '');
							}
						}
					}
	}
	$data['rate_from'] = $rate_from; 
	$data['rate_to'] = $rate_to;
	$data['currency_form'] = gatewayinfo($gateway_send,"currency");
	$data['currency_to'] = gatewayinfo($gateway_receive,"currency");
}
echo json_encode($data);
?>