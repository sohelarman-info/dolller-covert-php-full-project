<?php include("sources/header.php"); ?>
<section style="margin-top:50px; margin-bottom:50px;"> 
        <div class="container ex_container">
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Payment status</h4>
							<?php
							$action = protect($_GET['action']);
							if($action == "success") {	
								echo success("Payment completed! You will be notified via email when the exchange is completed.");
								$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
							} elseif($action == "cancel") {
								echo error("Your order was cancaled.");
							} elseif($action == "ipn") {
								// read the post from PayPal system and add 'cmd'
								$req = 'cmd=_notify-validate';

								foreach ($_POST as $key => $value) {
								$value = urlencode(stripslashes($value));
								$req .= "&$key=$value";
								}

								// post back to PayPal system to validate
								$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
								$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
								$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
								$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

								// assign posted variables to local variables
								$item_name = $_POST['item_name'];
								$item_number = $_POST['item_number'];
								$payment_status = $_POST['payment_status'];
								$payment_amount = $_POST['mc_gross'];
								$payment_currency = $_POST['mc_currency'];
								$txn_id = $_POST['txn_id'];
								$receiver_email = $_POST['receiver_email'];
								$payer_email = $_POST['payer_email'];
								$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$item_number'");
								if($query->num_rows>0) {
									$row = $query->fetch_assoc();
									$date = date("d/m/Y H:i:s");
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
									$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$txn_id'");
									if (!$fp) {
										echo error("Cant connect to PayPal server.");
									} else {
									fputs ($fp, $header . $req);
									while (!feof($fp)) {
									$res = fgets ($fp, 1024);
									if (strcmp ($res, "VERIFIED") == 1) {

										if ($payment_status == 'Completed') {

												if ($receiver_email==gatewayinfo($row['gateway_send'],"a_field_1")) {
												
													if($payment_amount == $amount && $payment_currency == $currency) {
													
														if($check_trans->num_rows==0) {
															$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$txn_id','completed','PayPal','$payment_amount','$payment_currency','$date')");
															$time = time();
															$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$txn_id',updated='$time' WHERE id='$row[id]'");
															emailsys_exchange_change_status($row['id']);
														}
													}
													
												} 

										}

									}

									else if (strcmp ($res, "INVALID") == 0) {
										echo 'Invalid payment.';
									}
									}
									fclose ($fp);
									}  
								}
							} else {
								echo error("Something was wrong. Please try again.");
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include("sources/footer.php"); ?>