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
$username = protect($_POST['username']);
$email = protect($_POST['email']);
$password = protect($_POST['password']);
$repassword = protect($_POST['repassword']);
$time = time();
$ip = $_SERVER['REMOTE_ADDR'];

$check_username = $db->query("SELECT * FROM bit_users WHERE username='$username'");
$check_email = $db->query("SELECT * FROM bit_users WHERE email='$email'");

if(empty($username) or empty($email) or empty($password) or empty($repassword)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_1]");
} elseif(!isValidUsername($username)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_48]");
} elseif($check_username->num_rows>0) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_49]");
} elseif(!isValidEmail($email)) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_50]");
} elseif($check_email->num_rows>0) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_51]");
} elseif($password !== $repassword) {
	$data['status'] = 'error';
	$data['msg'] = error("$lang[error_52]");
} else {
	$data['status'] = 'success';
	$pass = md5($password);
	$insert = $db->query("INSERT bit_users (username,email,password,status,ip,signup_time,email_verified,document_verified,mobile_verified) VALUES ('$username','$email','$pass','1','$ip','$time','0','0','0')");
	$query = $db->query("SELECT * FROM bit_users WHERE username='$username' and email='$email' and password='$pass'");
	$row = $query->fetch_assoc();
	$_SESSION['bit_uid'] = $row['id'];
	$verify_type = get_verify_type();
	if($verify_type == "9") {
		$update = $db->query("UPDATE bit_users SET status='3' WHERE id='$row[id]'");
	}
	$return = success("$lang[success_16]");
	$return .= '<meta http-equiv="refresh" content="3;URL='.$settings[url].'account/exchanges" />  ';
	$return .= '<script type="text/javascript">
			window.location.href="'.$settings[url].'account/exchanges";
		</script>';
	$data['msg'] = $return;
}
echo json_encode($data);
?>