<?php include("sources/header.php"); ?>
<section style="margin-top:50px; margin-bottom:50px;"> 
        <div class="container ex_container">
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Payment status</h4>
							<?php
							$transaction_id = $_POST['transaction_id'];
							$merchant_id = $_POST['pay_to_email'];
							$item_number = $_POST['detail1_text'];
							$item_name = $_POST['detail1_description'];
							$mb_amount = $_POST['mb_amount'];
							$mb_currency = $_POST['mb_currency'];
							$date = date("d/m/Y H:i:s");
							$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$item_number'");
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
							$a_field_1 = gatewayinfo($row['gateway_send'],"a_field_1");
							$a_field_2 = gatewayinfo($row['gateway_send'],"a_field_2");
							$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$transaction_id'");
							$concatFields = $_POST['merchant_id']
											.$_POST['transaction_id']
											.strtoupper(md5($a_field_2))
											.$_POST['mb_amount']
											.$_POST['mb_currency']
											.$_POST['status'];

										$MBEmail = $a_field_1;

										// Ensure the signature is valid, the status code == 2,
										// and that the money is going to you
										if (strtoupper(md5($concatFields)) == $_POST['md5sig']
											&& $_POST['status'] == 2
											&& $_POST['pay_to_email'] == $MBEmail)
										{
											// payment successfully...
													if($mb_amount == $amount && $mb_currency == $currency) {
														if($check_trans->num_rows>0) {
															echo info("You have already paid this order. Expect a response to your email address.");
														} else {
															$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$transaction_id','completed','Skrill','$mb_amount','$mb_currency','$date')");
															$time = time();
															$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$transaction_id',updated='$time' WHERE id='$row[id]'");
															echo success("Payment completed! You will be notified via email when the exchange is completed.");
															$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
								emailsys_exchange_change_status($row['id']);
														}
													} else {
														echo error("Error with your payment. The amount or currency does not match.");
													}
										}
										else
										{
											echo error("Error with your payment. The merchant does not match.");
										}
							} else {
								echo error("We cant find this exchange order.");
							}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include("sources/footer.php"); ?>