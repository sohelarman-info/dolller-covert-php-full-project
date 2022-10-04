<?php include("sources/header.php"); ?>
<section style="margin-top:50px; margin-bottom:50px;"> 
        <div class="container ex_container">
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Payment status</h4>
							<?php
							   // Read the post from OKPAY and add 'ok_verify'
							   $request = 'ok_verify=true';
							  
							   foreach ($_POST as $key => $value) {
								   $value = urlencode(stripslashes($value));
								   $request .= "&$key=$value";
							   }
							  
							   $fsocket = false;
							   $result = false;
							  
							   // Try to connect via SSL due sucurity reason
							   if ( $fp = @fsockopen('ssl://checkout.okpay.com', 443, $errno, $errstr, 30) ) {
								   // Connected via HTTPS
								   $fsocket = true;
							   } elseif ($fp = @fsockopen('checkout.okpay.com', 80, $errno, $errstr, 30)) {
								   // Connected via HTTP
								   $fsocket = true;
							   }
							  
							   // If connected to OKPAY
							   if ($fsocket == true) {
								   $header = 'POST /ipn-verify HTTP/1.1' . "\r\n" .
											 'Host: checkout.okpay.com'."\r\n" .
											 'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
											 'Content-Length: ' . strlen($request) . "\r\n" .
											 'Connection: close' . "\r\n\r\n";
							  
								   @fputs($fp, $header . $request);
								   $string = '';
								   while (!@feof($fp)) {
									   $res = @fgets($fp, 1024);
									   $string .= $res;
									   // Find verification result in response
									   if ( $res == 'VERIFIED' || $res == 'INVALID' || $res == 'TEST') {
										   $result = $res;
										   break;
									   }
								   }
								   @fclose($fp);
							   }
							  
							   if ($result == 'VERIFIED') {
								   // check the "ok_txn_status" is "completed"
								   // check that "ok_txn_id" has not been previously processed
								   // check that "ok_receiver_email" is your OKPAY email
								   // check that "ok_txn_gross"/"ok_txn_currency" are correct
								   // process payment
									
								   if($_POST['ok_txn_status'] == "completed") {
									$ok_txn_id = $_POST['ok_txn_id'];
									$ok_receiver_email = $_POST['ok_receiver_email'];
									$ok_item_1_id = $_POST['ok_item_1_id'];
									$ok_txn_gross = $_POST['ok_txn_gross'];
									$ok_txn_currency = $_POST['ok_txn_currency'];
									$ok_txn_datetime = $_POST['ok_txn_datetime'];
									$ok_payer_email = $_POST['ok_payer_email'];
									$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$ok_item_1_id'");
									if($query->num_rows>0) {
									$row = $query->fetch_assoc();
									if(gatewayinfo($row[gateway_send],"include_fee") == "1") {
										if (strpos(gatewayinfo($row[gateway_send],"fee"),'%') !== false) { 
											$amount = $row['amount_send'];
											$explode = explode("%",gatewayinfo($row[gateway_send],"fee"));
											$fee_percent = 100+$explode[0];
											$new_amount = ($amount * 100) / $fee_percent;
											$new_amount = round($new_amount,2);
											$fee_amount = $amount-$new_amount;
											$amount = $amount+$fee_amount;
											$fee_text = gatewayinfo($row[gateway_send],"fee");
										} else {
											$amount = $row['amount_send'] + gatewayinfo($row[gateway_send],"fee");
											$fee_text = gatewayinfo($row[gateway_send],"fee")." ".gatewayinfo($row[gateway_send],"currency");
										}
										$currency = gatewayinfo($row[gateway_send],"currency");
									} else {
										$amount = $row['amount_send'];
										$currency = gatewayinfo($row[gateway_send],"currency");
										$fee_text = '0';
									}
									if(checkSession()) { $uid = $_SESSION['bit_uid']; } else { $uid = 0; }
									$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$ok_txn_id'");
										if($ok_receiver_email == gatewayinfo($row['gateway_send'],"a_field_1")) {
											if($ok_txn_gross == $amount or $ok_txn_currency == $currency) {
												if($check_trans->num_rows>0) {
															echo info("You have already paid this order. Expect a response to your email address.");
														} else {
															$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$ok_txn_id','completed','OKPay','$ok_txn_gross','$ok_txn_currency','$date')");
															$time = time();
															$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$ok_txn_id',updated='$time' WHERE id='$row[id]'");
															echo success("Payment completed! You will be notified via email when the exchange is completed.");
															$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
								emailsys_exchange_change_status($row['id']);
														}
											} else {
												echo error("Error with your payment. The amount or currency does not match.");
											}
										} else { 
										echo error("Error with your payment. The merchant does not match.");
										}
									 } else {
										echo error("We cant find this exchange order.");
									}
								}
							   } elseif($result == 'INVALID') {
								   // If 'INVALID': log for manual investigation.
								echo error("Invalid payment request.");
							  
							   } elseif($result == 'TEST') {
								   // If 'TEST': do something
							  
							  
							   } else {
								   // IPN not verified or connection errors
								   // If status != 200 IPN will be repeated later
							  
								   header("HTTP/1.1 404 Not Found");
								   exit;
							   }
							?>
								</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include("sources/footer.php"); ?>