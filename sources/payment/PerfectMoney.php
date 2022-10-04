<?php include("sources/header.php"); ?>
<section style="margin-top:50px; margin-bottom:50px;"> 
        <div class="container ex_container">
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Payment status</h4>
							<?php
								$orderid = $_POST['PAYMENT_ID'];
								$eamount = $_POST['PAYMENT_AMOUNT'];
								$ecurrency = $_POST['PAYMENT_UNITS'];
								$buyer = $_POST['PAYEE_ACCOUNT'];
								$trans_id = $_POST['PAYMENT_BATCH_NUM'];
								$date = date("d/m/Y H:i:s");
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
									$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$trans_id'");
									$passpharce = gatewayinfo($row['gateway_send'],"a_field_2");
									$alternate = strtoupper(md5($passpharce));
									$string=
										  $_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
										  $_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
										  $_POST['PAYMENT_BATCH_NUM'].':'.
										  $_POST['PAYER_ACCOUNT'].':'.$alternate.':'.
										  $_POST['TIMESTAMPGMT'];
									$hash=strtoupper(md5($string));
									if($hash==$_POST['V2_HASH']){ // proccessing payment if only hash is valid

									   /* In section below you must implement comparing of data you recieved
									   with data you sent. This means to check if $_POST['PAYMENT_AMOUNT'] is
									   particular amount you billed to client and so on. */

									   if($_POST['PAYMENT_AMOUNT']==$amount && $_POST['PAYEE_ACCOUNT']==gatewayinfo($row['gateway_send'],"a_field_1") && $_POST['PAYMENT_UNITS']==$currency){

											if($check_trans->num_rows>0) {
															echo info("You have already paid this order. Expect a response to your email address.");
														} else {
															$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$trans_id','completed','Perfect Money','$eamount','$ecurrency','$date')");
															$time = time();
															$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$trans_id',updated='$time' WHERE id='$row[id]'");
															echo success("Payment completed! You will be notified via email when the exchange is completed.");
															$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
								emailsys_exchange_change_status($row['id']);
														}
										 
									   }else{ // you can also save invalid payments for debug purposes

											echo error("Error with your payment. The merchant account, amount or currency does not match.");
									   }


									}else{ // you can also save invalid payments for debug purposes

										echo error("Error with your payment. Please try again.");

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