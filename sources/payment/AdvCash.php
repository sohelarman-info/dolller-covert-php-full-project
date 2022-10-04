<?php include("sources/header.php"); ?>
<section style="margin-top:50px; margin-bottom:50px;"> 
        <div class="container ex_container">
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Payment Status</h4>
							<?php
							if($d == "success") {
								echo success("Payment completed! You will be notified via email when the exchange is completed.");
								$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
							} elseif($d == "fail") {
								echo error("Your order was cancaled.");
							} elseif($d == "status") {
								$ac_src_wallet = $_GET['ac_src_wallet'];
								$ac_dest_wallet = $_GET['ac_dest_wallet'];
								$ac_amount = $_GET['ac_amount'];
								$ac_merchant_currency = $_GET['ac_merchant_currency'];
								$ac_transfer = $_GET['ac_transfer'];
								$ac_start_date = $_GET['ac_start_date'];
								$ac_order_id = $_GET['ac_order_id'];
								$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$ac_order_id'");
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
									$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$ac_transfer'");
									
										if($ac_dest_wallet == gatewayinfo($row['gateway_send'],"a_field_1")) {
											if($ac_amount == $amount or $ac_merchant_currency == $currency) {
												if($check_trans->num_rows>0) {
															echo info("You have already paid this order. Expect a response to your email address.");
														} else {
															$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$ac_transfer','completed','AdvCash','$ac_amount','$ac_merchant_currency','$date')");
															$time = time();
															$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$ac_transfer',updated='$time' WHERE id='$row[id]'");
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
							} else { }
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include("sources/footer.php"); ?>