<?php
function protect($string) {
	$protection = htmlspecialchars(trim($string), ENT_QUOTES);
	return $protection;
}

function randomHash($lenght = 7) {
	$random = substr(md5(rand()),0,$lenght);
	return $random;
}

function isValidURL($url) {
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

function cropexchangeid($text,$chars) {
	$string = $text;
	if(strlen($string) > $chars) $string = substr($string, 0, $chars).'***************';
	echo $string;
}

function checkAdminSession() {
	if(isset($_SESSION['bit_admin_uid'])) {
		return true;
	} else {
		return false;
	}
}

function checkCryptoExchange($gateway_send,$gateway_receive) {
	$isCrypto_1 = isCrypto($gateway_send);
	$isCrypto_2 = isCrypto($gateway_receive);
	if($isCrypto_1 == "1" && $isCrypto_2 == "1") {
		return true;
	} else {
		return false;
	}
}

function cryptoPrefix($gateway) {
	if($gateway == "Bitcoin") { $prefix = 'bitcoin_BTC'; }
	elseif($gateway == "Litecoin") { $prefix = 'litecoin_LTC'; }
	elseif($gateway == "Dogecoin") { $prefix = 'dogecoin_DOGE'; }
	elseif($gateway == "Dash") { $prefix = 'dash_DASH'; }
	elseif($gateway == "Ethereum") { $prefix = 'ethereum_ETH'; }
	elseif($gateway == "Peercoin") { $prefix = 'peercoin_PPC'; }
	else {
		$prefix = 'Unknown';
	}	
	return $prefix;
}

function isCrypto($gateway) {
	if($gateway == "Bitcoin") { $prefix = '1'; }
	elseif($gateway == "Litecoin") { $prefix = '1'; }
	elseif($gateway == "Dogecoin") { $prefix = '1'; }
	elseif($gateway == "Dash") { $prefix = '1'; }
	elseif($gateway == "Ethereum") { $prefix = '1'; }
	elseif($gateway == "Peercoin") { $prefix = '1'; }
	else {
		$prefix = '0';
	}	
	return $prefix;
}

function currencyConvertor($amount,$from_Currency,$to_Currency) {
	 $amount = urlencode($amount);
	  $from_Currency = urlencode($from_Currency);
	  $to_Currency = urlencode($to_Currency);
	  $get = "https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";
	  $ch = curl_init();
										$url = $get;
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
	  $get = explode("<span class=bld>",$result);
	  $get = explode("</span>",$get[1]);  
	  $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
	  return number_format($converted_amount, 2, '.', '');
}

function checkOperatorSession() {
	if(isset($_SESSION['bit_operator_uid'])) {
		return true;
	} else {
		return false;
	}
}

function BitDecodeTitle($prefix) {
	global $db, $settings;
	return $settings['title'];
}

function isValidUsername($str) {
    return preg_match('/^[a-zA-Z0-9-_]+$/',$str);
}

function isValidEmail($str) {
	return filter_var($str, FILTER_VALIDATE_EMAIL);
}

function checkSession() {
	if(isset($_SESSION['bit_uid'])) {
		return true;
	} else {
		return false;
	}
}

function success($text) {
	return '<div class="alert alert-success"><i class="fa fa-check"></i> '.$text.'</div>';
}

function error($text) {
	return '<div class="alert alert-danger"><i class="fa fa-times"></i> '.$text.'</div>';
}

function info($text) {
	return '<div class="alert alert-info"><i class="fa fa-info-circle"></i> '.$text.'</div>';
}

function admin_pagination($query,$ver,$per_page = 10,$page = 1, $url = '?') { 
    	global $db;
		$query = $db->query("SELECT * FROM $query");
    	$total = $query->num_rows;
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='active'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'>...</li>";
    				$pagination.= "<li><a href='$ver&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='$ver&page=1'>1</a></li>";
    				$pagination.= "<li><a href='$ver&page=2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>...</a></li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='$ver&page=1'>1</a></li>";
    				$pagination.= "<li><a href='$ver&page=2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='$ver&page=$next'>Next</a></li>";
                $pagination.= "<li><a href='$ver&page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='disabled'>Next</a></li>";
                $pagination.= "<li><a class='disabled'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
} 

function web_pagination($query,$ver,$per_page = 10,$page = 1, $url = '?') { 
    	global $db;
		$query = $db->query("SELECT * FROM $query");
    	$total = $query->num_rows;
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='active'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='$ver/$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver/$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'>...</li>";
    				$pagination.= "<li><a href='$ver/$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver/$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='$ver/1'>1</a></li>";
    				$pagination.= "<li><a href='$ver/2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>...</a></li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver/$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				$pagination.= "<li><a href='$ver/$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver/$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='$ver/1'>1</a></li>";
    				$pagination.= "<li><a href='$ver/2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver/$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='$ver/$next'>Next</a></li>";
                $pagination.= "<li><a href='$ver/$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='disabled'>Next</a></li>";
                $pagination.= "<li><a class='disabled'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
} 

function idinfo($uid,$value) {
	global $db;
	$query = $db->query("SELECT * FROM bit_users WHERE id='$uid'");
	$row = $query->fetch_assoc();
	return $row[$value];
}	

function gatewayinfo($gid,$value) {
	global $db;
	$query = $db->query("SELECT * FROM bit_gateways WHERE id='$gid'");
	$row = $query->fetch_assoc();
	return $row[$value];
}	

function exchangeinfo($eid,$value) {
	global $db;
	$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$eid'");
	$row = $query->fetch_assoc();
	return $row[$value];
}	


function walletinfo($eid,$value) {
	global $db;
	$query = $db->query("SELECT * FROM bit_users_earnings WHERE id='$eid'");
	$row = $query->fetch_assoc();
	return $row[$value];
}	

function siteURL() {
  global $db, $settings;
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 
    $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $domainName = $_SERVER['HTTP_HOST'];
  $path = Dirname($_SERVER[PHP_SELF]);
  if(empty($path)) { $sub_dir = '/'; } else { $sub_dir = $path.'/'; }
  if(empty($domainName)) {
	return $settings['url'];
  } else {
	return $protocol.$domainName.$sub_dir;
  }
}

function getIcon($name,$width,$height) {
	global $db, $settings;
	$path = "assets/icons/";
	$external_icon = 0;
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
		return '<img src="'.$settings[url].$icon.'" width="'.$width.'" height="'.$height.'">';
	} else {
		return '<img src="'.$settings[url].$path.$icon.'" width="'.$width.'" height="'.$height.'">';
	}
}

function gatewayicon($name) {
	global $db, $settings;
	$path = "assets/icons/";
	$external_icon = 0;
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
		return $settings[url].$icon;
	} else {
		return $settings[url].$path.$icon;
	}
}

function exchangetype($name) {
	global $db, $settings;
	if($name == "PayPal") { $type = '2'; }
	elseif($name == "Skrill") { $type = '2'; }
	elseif($name == "WebMoney") { $type = '2'; }
	elseif($name == "Payeer") { $type = '2'; }
	elseif($name == "Perfect Money") { $type = '2'; }
	elseif($name == "AdvCash") { $type = '2'; }
	elseif($name == "OKPay") { $type = '2'; }
	elseif($name == "Entromoney") { $type = '2'; }
	elseif($name == "SolidTrust Pay") { $type = '2'; }
	elseif($name == "2checkout") { $type = '3'; }
	elseif($name == "Litecoin") { $type = '3'; }
	elseif($name == "Neteller") { $type = '3'; }
	elseif($name == "UQUID") { $type = '3'; }
	elseif($name == "Dash") { $type = '3'; }
	elseif($name == "Dogecoin") { $type = '3'; }
	elseif($name == "BTC-e") { $type = '3'; }
	elseif($name == "Ethereum") { $type = '3'; }
	elseif($name == "Peercoin") { $type = '3'; }
	elseif($name == "Yandex Money") { $type = '3'; }
	elseif($name == "QIWI") { $type = '3'; }
	elseif($name == "Payza") { $type = '2'; }
	elseif($name == "Bitcoin") { $type = '3'; }
	elseif($name == "Bank Transfer") { $type = '3'; }
	elseif($name == "Western Union") { $type = '3'; }
	elseif($name == "Moneygram") { $type = '3'; }
	elseif($name == "TheBillioncoin") { $type = '3'; }
	else { $type = '3'; }
	return $type;
}

function get_verify_type() {
	global $settings;
	if($settings['document_verification'] == "1" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "1") {
		$status = '1';
	} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "0") {
		$status = '2';
	} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "1") {
		$status = '3'; 
	} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "1") {
		$status = '4';
	} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "0") {
		$status = '5';
	} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "0") {
		$status = '6';
	} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "0") {
		$status = '7';
	} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "1") {
		$status = '8';
	} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "0") {
		$status = '9';
	} else {
		$status = '0';
	}
	return $status;
}

function check_user_verify_status() {
	global $db,$settings;
	$email_verified = idinfo($_SESSION['bit_uid'],"email_verified");
	$mobile_verified = idinfo($_SESSION['bit_uid'],"mobile_verified");
	$document_verified = idinfo($_SESSION['bit_uid'],"document_verified");
	$ustatus = idinfo($_SESSION['bit_uid'],"status");
	if($ustatus !== "666" && $ustatus !== "777") { 
		if($settings['document_verification'] == "1" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "1") {
			if($document_verified == "1" && $email_verified == "1" && $mobile_verified == "1") {
				$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$_SESSION[bit_uid]'");
			}
		} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "0") {
			if($document_verified == "1" && $email_verified == "1") {
				$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$_SESSION[bit_uid]'");
			}
		} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "1") {
			if($document_verified == "1" && $mobile_verified == "1") {
				$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$_SESSION[bit_uid]'");
			}
		} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "1") {
			if($email_verified == "1" && $mobile_verified == "1") {
				$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$_SESSION[bit_uid]'");
			}
		} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "0") {
			if($document_verified == "1" && $email_verified == "1") {
				$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$_SESSION[bit_uid]'");
			}
		} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "0") {
			if($document_verified == "1") {
				$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$_SESSION[bit_uid]'");
			}
		} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "0") {
			if($email_verified == "1") {
				$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$_SESSION[bit_uid]'");
			}
		} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "1") {
			if($mobile_verified == "1") {
				$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$_SESSION[bit_uid]'");
			}
		} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "0") {
			$status = '9';
		} else {
			$status = '0';
		}
	}
}

function getLanguage($url, $ln = null, $type = null) {
	// Type 1: Output the available languages
	// Type 2: Change the path for the /requests/ folder location
	// Set the directory location
	if($type == 2) {
		$languagesDir = '../languages/';
	} else {
		$languagesDir = './languages/';
	}
	// Search for pathnames matching the .png pattern
	$language = glob($languagesDir . '*.php', GLOB_BRACE);

	if($type == 1) {
		// Add to array the available images
		foreach($language as $lang) {
			// The path to be parsed
			$path = pathinfo($lang);
			
			// Add the filename into $available array
			$available .= '<li><a href="'.$url.'index.php?lang='.$path['filename'].'">'.ucfirst(strtolower($path['filename'])).'</a></li>';
		}
		return substr($available, 0, -3);
	} else {
		// If get is set, set the cookie and stuff
		$lang = 'English'; // DEFAULT LANGUAGE
		if($type == 2) {
			$path = '../languages/';
		} else {
			$path = './languages/';
		}
		if(isset($_GET['lang'])) {
			if(in_array($path.$_GET['lang'].'.php', $language)) {
				$lang = $_GET['lang'];
				setcookie('lang', $lang, time() +  (10 * 365 * 24 * 60 * 60)); // Expire in one month
			} else {
				setcookie('lang', $lang, time() +  (10 * 365 * 24 * 60 * 60)); // Expire in one month
			}
		} elseif(isset($_COOKIE['lang'])) {
			if(in_array($path.$_COOKIE['lang'].'.php', $language)) {
				$lang = $_COOKIE['lang'];
			}
		} else {
			setcookie('lang', $lang, time() +  (10 * 365 * 24 * 60 * 60)); // Expire in one month
		}

		if(in_array($path.$lang.'.php', $language)) {
			return $path.$lang.'.php';
		}
	}
}

function emailsys_new_exchange($id) {
	global $db, $settings;
	$eQuery = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
	if($eQuery->num_rows>0) {
		$e = $eQuery->fetch_assoc();
		$email = $e['u_field_1'];
		$msubject = '['.$settings[name].'] New request for exchange '.$e[exchange_id];
		$mreceiver = $email;
		$message = 'Hello, '.$email.'
		
You make new request for exchange from '.gatewayinfo($e[gateway_send],"name").' '.gatewayinfo($e[gateway_send],"currency").' to '.gatewayinfo($e[gateway_receive],"name").' '.gatewayinfo($e[gateway_receive],"currency").' for '.$e[amount_send].' '.gatewayinfo($e[gateway_send],"currency").'
You must make payment before passing 24 hours because when the time expires your request will be not active.
Can complete payment on this link: '.$settings[url].'exchange/'.$e[exchange_id].'
	
If you have some problems please feel free to contact with us on '.$settings[supportemail];
		$message2 = 'Hello, Admin
		
You have new request for exchange from '.gatewayinfo($e[gateway_send],"name").' '.gatewayinfo($e[gateway_send],"currency").' to '.gatewayinfo($e[gateway_receive],"name").' '.gatewayinfo($e[gateway_receive],"currency").' for '.$e[amount_send].' '.gatewayinfo($e[gateway_send],"currency").'

Thanks';
		$headers = 'From: '.$settings[infoemail].'' . "\r\n" .
					'Reply-To: '.$settings[infoemail].'' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		$mail = mail($mreceiver, $msubject, $message, $headers);
		$mail2 = mail($settings['supportemail'], $msubject, $message2, $headers);
		if($mail) { 
			return true;
		} else {
			return false;
		}
	}
}

function emailsys_exchange_change_status($id) {
	global $db, $settings;
	$eQuery = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
	if($eQuery->num_rows>0) {
		$e = $eQuery->fetch_assoc();
		$email = $e['u_field_1'];
		if($e['status'] == "1") {
			$status = 'Awaiting Confirmation';
		} elseif($e['status'] == "2") {
			$status = 'Awaiting Payment';
		} elseif($e['status'] == "3") {
			$status = 'Processing';
		} elseif($e['status'] == "4") {
			$status = 'Processed';
		} elseif($e['status'] == "5") {
			$status = 'Timeout';
		} elseif($e['status'] == "6") {
			$status = 'Denied';
		} elseif($e['status'] == "7") {
			$status = 'Canceled';
		} else {
			$status = 'Unknown';
		}
		$msubject = '['.$settings[name].'] Exchange Status Changed';
		$mreceiver = $email;
		$message = 'Hello, '.$email.'

Your new exchange status is: '.$status.'
----------------------------------------------------------------------
Exchange details: 		
Exchange from '.gatewayinfo($e[gateway_send],"name").' '.gatewayinfo($e[gateway_send],"currency").' to '.gatewayinfo($e[gateway_receive],"name").' '.gatewayinfo($e[gateway_receive],"currency").' for '.$e[amount_send].' '.gatewayinfo($e[gateway_send],"currency").'
Can track your exchange at this link: '.$settings[url].'exchange/'.$e[exchange_id].'
	
If you have some problems please feel free to contact with us on '.$settings[supportemail];
		$headers = 'From: '.$settings[infoemail].'' . "\r\n" .
					'Reply-To: '.$settings[infoemail].'' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		$mail = mail($mreceiver, $msubject, $message, $headers);
		if($mail) { 
			return true;
		} else {
			return false;
		}
	}
}

function emailsys_exchange_processed($id) {
	global $db, $settings;
	$eQuery = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
	if($eQuery->num_rows>0) {
		$e = $eQuery->fetch_assoc();
		$email = $e['u_field_1'];
		if($e['u_field_10']) {
			$yourpin = 'Your '.gatewayinfo($e[gateway_receive],"name").' PIN: '.$e[u_field_10];
		} else {
			$yourpin = '';
		}
		$msubject = '['.$settings[name].'] Your exchange was processed';
		$mreceiver = $email;
		$message = 'Hello, '.$email.'
	
Your exchange from '.gatewayinfo($e[gateway_send],"name").' '.gatewayinfo($e[gateway_send],"currency").' to '.gatewayinfo($e[gateway_receive],"name").' '.gatewayinfo($e[gateway_receive],"currency").' was processed. I.e. You receive money!
Your '.gatewayinfo($e[gateway_receive],"name").' account receive '.$e[amount_receive].' '.gatewayinfo($e[gateway_receive],"currency").'
'.$yourpin.'
	
If you have some problems please feel free to contact with us on '.$settings[supportemail];
		$headers = 'From: '.$settings[infoemail].'' . "\r\n" .
					'Reply-To: '.$settings[infoemail].'' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		$mail = mail($mreceiver, $msubject, $message, $headers);
		if($mail) { 
			return true;
		} else {
			return false;
		}
	}
}

function emailsys_new_profit($id,$email,$refid,$profit,$currency) {
	global $db, $settings;
	$eQuery = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
	if($eQuery->num_rows>0) {
		$e = $eQuery->fetch_assoc();
		$msubject = '['.$settings[name].'] New profit earned';
		$mreceiver = $email;
		$message = 'Hello, '.$email.'
	
You earn '.$profit.' '.$currency.' from exchange made by your referral link.
Exchange ID: '.$e[exchange_id].'
You can view your earnings in your account. Open '.$settings[url].' ,login with your account and then go to tab "Earnings".
	
If you have some problems please feel free to contact with us on '.$settings[supportemail];
		$headers = 'From: '.$settings[infoemail].'' . "\r\n" .
					'Reply-To: '.$settings[infoemail].'' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		$mail = mail($mreceiver, $msubject, $message, $headers);
		if($mail) { 
			return true;
		} else {
			return false;
		}
	}
}

function formatBytes($bytes, $precision = 2) { 
    if ($bytes > pow(1024,3)) return round($bytes / pow(1024,3), $precision)."GB";
    else if ($bytes > pow(1024,2)) return round($bytes / pow(1024,2), $precision)."MB";
    else if ($bytes > 1024) return round($bytes / 1024, $precision)."KB";
    else return ($bytes)."B";
} 

function check_unpayed() {
	global $db;
	$query = $db->query("SELECT * FROM bit_exchanges WHERE status='1' or status='2' ORDER BY id");
	if($query->num_rows>0) {
		while($row = $query->fetch_assoc()) {
			$time = $row['created']+86400;
			if(time() > $time) {
				$time = time();
				$update = $db->query("UPDATE bit_exchanges SET status='5',expired='$time' WHERE id='$row[id]'");
				emailsys_exchange_change_status($row['id']);
			}
		}
	} 
}

?>