<?php include("sources/header.php"); ?>
<section style="margin-top:50px; margin-bottom:50px;"> 
        <div class="container ex_container">
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Payment status</h4>
							<?php
							if($d == "notify") {
								$tr_id = $_POST['tr_id'];
								$eamount = $_POST['amount'];
								$ecurrency = $_POST['currency'];
								$orderid = $_POST['user1'];
								$merchant = $_POST['merchantAccount'];
								$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$orderid'");
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
										$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$tr_id'");
										$sci_pwd = gatewayinfo($row[gateway_send],"u_field_3");
										$sci_pwd = md5($sci_pwd.'s+E_a*');  //encryption for db
										$hash_received = MD5($_POST['tr_id'].":".MD5($sci_pwd).":".$_POST['amount'].":".$_POST['merchantAccount'].":".$_POST['payerAccount']);

											if ($hash_received == $_POST['hash']) {
													if($merchant == gatewayinfo($row['gateway_send'],"u_field_1")) {
																		if($check_trans->num_rows>0) {
																			echo info("You have already paid this order. Expect a response to your email address.");
																		} else {
																			$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$tr_id','completed','SolidTrust Pay','$eamount','$ecurrency','$date')");
																			$time = time();
																			$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$tr_id',updated='$time' WHERE id='$row[id]'");
																			echo success("Payment completed! You will be notified via email when the exchange is completed.");
																			$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
								emailsys_exchange_change_status($row['id']);
																		}
																} else { 
																	echo error("Error with your payment. The merchant does not match.");
																}
											}
											else {
												echo error("Error with your payment. Please try again.");
											} 
								} else {
									echo error("We cant find this exchange order.");
								}
							} elseif($d == "confirm") {
								$tr_id = $_POST['tr_id'];
								$eamount = $_POST['amount'];
								$ecurrency = $_POST['currency'];
								$orderid = $_POST['user1'];
								$merchant = $_POST['merchantAccount'];
								$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$orderid'");
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
										$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$tr_id'");
										$sci_pwd = gatewayinfo($row[gateway_send],"u_field_3");
										$sci_pwd = md5($sci_pwd.'s+E_a*');  //encryption for db
										$hash_received = MD5($_POST['tr_id'].":".MD5($sci_pwd).":".$_POST['amount'].":".$_POST['merchantAccount'].":".$_POST['payerAccount']);

											if ($hash_received == $_POST['hash']) {
													if($merchant == gatewayinfo($row['gateway_send'],"u_field_1")) {
																		if($check_trans->num_rows>0) {
																			echo info("You have already paid this order. Expect a response to your email address.");
																		} else {
																			$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$tr_id','completed','SolidTrust Pay','$eamount','$ecurrency','$date')");
																			$time = time();
																			$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$tr_id',updated='$time' WHERE id='$row[id]'");
																			echo success("Payment completed! You will be notified via email when the exchange is completed.");
																		}
																} else { 
																	echo error("Error with your payment. The merchant does not match.");
																}
											}
											else {
												echo error("Error with your payment. Please try again.");
											} 
								} else {
									echo error("We cant find this exchange order.");
								}
							} elseif($d == "return") {
								echo success("Payment completed! You will be notified via email when the exchange is completed.");
							} else {  }
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include("sources/footer.php"); ?>