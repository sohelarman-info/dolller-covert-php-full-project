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
$email = protect($_POST['email']);
$password = protect($_POST['password']);
$pass = md5($password);
$check = $db->query("SELECT * FROM bit_users WHERE email='$email' and password='$pass'");
if(empty($email) or empty($password)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_45]");
} elseif($check->num_rows==0) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_46]");
} else {
	$row = $check->fetch_assoc();
	if($row['status'] == "2") {
		$data['status'] = 'error';
		$data['msg'] = error("$lang[error_47]");
	} else {
		if($_POST['remember_me'] == "yes") {
			setcookie("bitexchanger_uid", $row['id'], time() + (86400 * 30), '/'); // 86400 = 1 day
		}
		$_SESSION['bit_uid'] = $row['id'];
		$data['status'] = 'success';
		$return = '<meta http-equiv="refresh" content="0;URL='.$settings[url].'account/exchanges" />  ';
		$return .= '<script type="text/javascript">
			window.location.href="'.$settings[url].'account/exchanges";
		</script>';
		$data['msg'] = $return;
	}
}
echo json_encode($data);
?>