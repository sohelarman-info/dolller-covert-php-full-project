<?php include("sources/header.php"); ?>
<section style="margin-top:50px; margin-bottom:50px;"> 
        <div class="container ex_container">
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Payment status</h4>
							<?php
							if($d == "results") {
								$receivedSecurityCode = $_POST['ap_securitycode'];
								$receivedMerchantEmailAddress = $_POST['ap_merchant'];	
								$transactionStatus = $_POST['ap_status'];
								$testModeStatus = $_POST['ap_test'];	 
								$purchaseType = $_POST['ap_purchasetype'];
								$totalAmountReceived = $_POST['ap_totalamount'];
								$feeAmount = $_POST['ap_feeamount'];
								$netAmount = $_POST['ap_netamount'];
								$transactionReferenceNumber = $_POST['ap_referencenumber'];
								$currency = $_POST['ap_currency']; 	
								$transactionDate= $_POST['ap_transactiondate'];
								$transactionType= $_POST['ap_transactiontype'];
								
								//Setting the customer's information from the IPN post variables
								$customerFirstName = $_POST['ap_custfirstname'];
								$customerLastName = $_POST['ap_custlastname'];
								$customerAddress = $_POST['ap_custaddress'];
								$customerCity = $_POST['ap_custcity'];
								$customerState = $_POST['ap_custstate'];
								$customerCountry = $_POST['ap_custcountry'];
								$customerZipCode = $_POST['ap_custzip'];
								$customerEmailAddress = $_POST['ap_custemailaddress'];
								
								//Setting information about the purchased item from the IPN post variables
								$myItemName = $_POST['ap_itemname'];
								$myItemCode = $_POST['ap_itemcode'];
								$myItemDescription = $_POST['ap_description'];
								$myItemQuantity = $_POST['ap_quantity'];
								$myItemAmount = $_POST['ap_amount'];
								
								$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$myItemCode'");
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
									$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$transactionReferenceNumber'");
									//Setting extra information about the purchased item from the IPN post variables
									$additionalCharges = $_POST['ap_additionalcharges'];
									$shippingCharges = $_POST['ap_shippingcharges'];
									$taxAmount = $_POST['ap_taxamount'];
									$discountAmount = $_POST['ap_discountamount'];
								 
									//Setting your customs fields received from the IPN post variables
									$myCustomField_1 = $_POST['apc_1'];
									$myCustomField_2 = $_POST['apc_2'];
									$myCustomField_3 = $_POST['apc_3'];
									$myCustomField_4 = $_POST['apc_4'];
									$myCustomField_5 = $_POST['apc_5'];
									$myCustomField_6 = $_POST['apc_6'];
									
										if ($receivedMerchantEmailAddress != gatewayinfo($row['gateway_send'],"a_field_1")) {
											echo error("Error with your payment. The merchant does not match.");
										}
										else {	
											//Check if the security code matches
											if ($receivedSecurityCode !=  gatewayinfo($row['gateway_send'],"a_field_2")) {
												echo error("Gateway was not configurated. Security code is missing or does not match.");
											}
											else {
												if ($transactionStatus == "Success") {
													if ($testModeStatus == "1") {
														// Since Test Mode is ON, no transaction reference number will be returned.
														// Your site is currently being integrated with Payza IPN for TESTING PURPOSES
														// ONLY. Don't store any information in your production database and 
														// DO NOT process this transaction as a real order.
													}
													else {
														if($check_trans->num_rows>0) {
															echo info("You have already paid this order. Expect a response to your email address.");
														} else {
															$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$transactionReferenceNumber','completed','Payza','$myItemAmount','$mb_currency','$date')");
															$time = time();
															$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$transactionReferenceNumber',updated='$time' WHERE id='$row[id]'");
															echo success("Payment completed! You will be notified via email when the exchange is completed.");
															$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
								emailsys_exchange_change_status($row['id']);
														}
													}			
												}
												else {
													echo error("Error with your payment. Please try again.");
												}
											}
										}
								} else {
									echo error("We cant find this exchange order.");
								}
							} elseif($c == "cancel") {
								echo error("Your order was cancaled.");
							} else { }
						
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include("sources/footer.php"); ?>