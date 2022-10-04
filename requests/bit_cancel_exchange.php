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
	$update = $db->query("UPDATE bit_exchanges SET status='7' WHERE id='$id'");
	emailsys_exchange_change_status($row['id']);
	echo info("$lang[info_9]");
	echo '<meta http-equiv="refresh" content="2;URL='.$settings[url].'" />    ';
} else {
	echo error("$lang[error_25]");
}
?>