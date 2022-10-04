<?php
$c = protect($_GET['c']);

if($c == "deposit") {
	include("wallet/deposit.php");
} elseif($c == "send-money") {
	include("wallet/send-money.php");
}  elseif($c == "exchange") {
	include("wallet/exchange.php");
} elseif($c == "transactions") {
	include("wallet/transactions.php");
} else {
	include("wallet/wallet.php");
}
?>