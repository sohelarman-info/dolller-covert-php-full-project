<?php include("sources/header.php"); ?>
<section style="margin-top:50px; margin-bottom:50px;"> 
        <div class="container ex_container">
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Payment Status</h4>
							<?php
							if (isset($_POST['m_operation_id']) && isset($_POST['m_sign']))
							{
								$m_operation_id = $_POST['m_operation_id'];
								$m_operation_date = $_POST['m_operation_date'];
								$m_orderid = $_POST['m_orderid'];
								$m_amount = $_POST['m_amount'];
								$m_currency = $_POST['m_curr'];
								$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$m_orderid'");
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
									$check_trans = $db->query("SELECT * FROM bit_transactions WHERE transaction_id='$m_operation_id'");
									$m_key = gatewayinfo($row['gateway_send'],"a_field_2");
									$arHash = array($_POST['m_operation_id'],
											$_POST['m_operation_ps'],
											$_POST['m_operation_date'],
											$_POST['m_operation_pay_date'],
											$_POST['m_shop'],
											$_POST['m_orderid'],
											$_POST['m_amount'],
											$_POST['m_curr'],
											$_POST['m_desc'],
											$_POST['m_status'],
											$m_key);
									$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));
									if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success')
									{
											if($m_amount == $amount or $m_currency == $currency) {
														if($check_trans->num_rows>0) {
															echo info("You have already paid this order. Expect a response to your email address.");
														} else {
															$insert = $db->query("INSERT bit_transactions (transaction_id,status,gateway,amount,currency,time) VALUES ('$m_operation_id','completed','Payeer','$mb_amount','$mb_currency','$date')");
															$time = time();
															$update = $db->query("UPDATE bit_exchanges SET status='3',transaction_id='$m_operation_id',updated='$time' WHERE id='$row[id]'");
															echo success("Payment completed! You will be notified via email when the exchange is completed.");
															$link = $settings[url].'exchange/'.$_SESSION[bit_requested_exchange_id];
								echo info("You can track your exchange at this link:<br/><a href='$link' style='color:#fff;'>$link</a>");
								emailsys_exchange_change_status($row['id']);
														}
											} else {
												echo error("Error with your payment. The amount or currency does not match.");
											}
									} else {
										$update = $db->query("UPDATE exchanges SET status='6' WHERE id='$row[id]'");
										echo error("Error with your payment. Please try again");
									}
								} else {
									echo error("We cant find this exchange order.");
								}
							} else {
								echo error("Error with your payment. The merchant account, amount or currency does not match.");
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include("sources/footer.php"); ?>