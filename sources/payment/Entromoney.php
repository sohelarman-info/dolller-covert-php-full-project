<?php include("sources/header.php"); ?>
<section style="margin-top:50px; margin-bottom:50px;"> 
        <div class="container ex_container">
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Payment status</h4>
							<?php
							if($d == "success") {
								echo success("Payment completed! You will be notified via email when the exchange is completed.");
								$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
							} elseif($d == "fail") { 
								echo error("Your order was cancaled.");
							} elseif($d == "status") {
								include("includes/entromoney.php");
								$accountQuery = $db->query("SELECT * FROM bit_gateways WHERE name='Entromoney'");
								$acc = $accountQuery->fetch_assoc();
								$config = array();
								$config['sci_user'] = $acc['a_field_1'];
								$config['sci_id'] 	= $acc['a_field_2'];
								$config['sci_pass'] = $acc['a_field_3'];
								$config['receiver'] = $acc['a_field_4'];
								try {
									$sci = new Paygate_Sci($config);
								}
								catch (Paygate_Exception $e) {
									exit($e->getMessage());
								}

								$input = array();
								$input['hash'] = $_POST['hash'];

								// Decode hash
								$error = '';
								$tran = $sci->query($input, $error);
								foreach($tran as $v => $k) {
									$trans[$v] = $k;
								}
								$date = date("d/m/Y H:i:s");
								$status = $trans['status'];
								$payment_id = $trans['payment_id'];
								$receiver = $trans['account_purse'];
								$sender = $trans['purse'];
								$eamount = $trans['amount'];
								$batch = $trans['batch'];
								$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$trans[payment_id]'");
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
									$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$batch'");
										if($error) {
											echo error($error);
										} else {
											if($status == "completed") {
												if($check_trans->num_rows>0) {
															echo info("You have already paid this order. Expect a response to your email address.");
														} else {
															$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$batch','completed','Skrill','$eamount','$mb_currency','$date')");
															$time = time();
															$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$batch',updated='$time' WHERE id='$row[id]'");
															echo success("Payment completed! You will be notified via email when the exchange is completed.");
															$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
								emailsys_exchange_change_status($row['id']);
														}
											} else {
												echo error("Error with your payment. Please try again.");
											}
										}
								} else {
									echo error("We cant find this exchange order.");
								}
							} else { }
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include("sources/footer.php"); ?>