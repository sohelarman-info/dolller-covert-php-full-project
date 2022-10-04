<?php
$eid = protect($_GET['id']);
$query = $db->query("SELECT * FROM bit_exchanges WHERE exchange_id='$eid'");
if($query->num_rows==0) { $redirect = $settings['url']; header("Location: $redirect"); }
$row = $query->fetch_assoc();
$receive = gatewayinfo($row['gateway_receive'],"name");
$send = gatewayinfo($row['gateway_send'],"name");
$bit_gateway_send = $row['gateway_send'];
$bit_gateway_receive = $row['gateway_receive'];
$bit_amount_send = $row['amount_send'];
$bit_amount_receive = $row['amount_receive'];
$bit_currency_from = gatewayinfo($row['gateway_send'],"currency");
$bit_currency_to = gatewayinfo($row['gateway_receive'],"currency");
?>
	<!-- main -->
	<section id="main" class="clearfix home-default">
		<div class="container">
			
			<!-- main-content -->
			<div class="main-content">
				<!-- row -->
				<div class="row">
					<!-- product-list -->
					<div class="col-md-12">
						<!-- categorys -->
						<div class="section">
							<div class="row">
								<div class="col-md-12">
									<div id="bit_exchange_box">
					<?php
					if($row['status'] == "1") {
							if(gatewayinfo($bit_gateway_send,"include_fee") == "1") {
								if (strpos(gatewayinfo($bit_gateway_send,"extra_fee"),'%') !== false) { 
										$amount = $bit_amount_send;
									$explode = explode("%",gatewayinfo($bit_gateway_send,"extra_fee"));
									$fee_percent = 100+$explode[0];
									$new_amount = ($amount * 100) / $fee_percent;
									$new_amount = round($new_amount,2);
									$fee_amount = $amount-$new_amount;
									$amount = $amount+$fee_amount;
									$fee_text = gatewayinfo($bit_gateway_send,"extra_fee");
								} else {
									$amount = $bit_amount_send + gatewayinfo($bit_gateway_send,"extra_fee");
									$fee_text = gatewayinfo($bit_gateway_send,"extra_fee")." ".gatewayinfo($bit_gateway_send,"currency");
								}
								$currency = $bit_currency_from;
							} else {
								$amount = $bit_amount_send;
								$currency = $bit_currency_from;
								$fee_text = '0';
							}
							$data['status'] = 'success';
							if($receive == "Bank Transfer") {
								$account_data = '<tr>
													<td><span class="pull-left">'.$lang[your_name].'</span></td>
													<td><span class="pull-right">'.$row[u_field_2].'</span></td>
											</tr><tr>
													<td><span class="pull-left">'.$lang[your_location].'</span></td>
													<td><span class="pull-right">'.$row[u_field_3].'</span></td>
											</tr><tr>
													<td><span class="pull-left">'.$lang[your_bank_name].'</span></td>
													<td><span class="pull-right">'.$row[u_field_4].'</span></td>
											</tr><tr>
													<td><span class="pull-left">'.$lang[your_bank_account].'</span></td>
													<td><span class="pull-right">'.$row[u_field_5].'</span></td>
											</tr><tr>
													<td><span class="pull-left">'.$lang[your_bank_swift].'</span></td>
													<td><span class="pull-right">'.$row[u_field_6].'</span></td>
											</tr>';
							} elseif($receive == "Western Union" or $receive == "Moneygram") {
								$account_data = '<tr>
													<td><span class="pull-left">'.$lang[your_name].'</span></td>
													<td><span class="pull-right">'.$row[u_field_2].'</span></td>
											</tr><tr>
													<td><span class="pull-left">'.$lang[your_location].'</span></td>
													<td><span class="pull-right">'.$row[u_field_3].'</span></td>
											</tr>';
							} elseif($receive == "Bitcoin" or $receive == "Litecoin" or $receive == "Dogecoin" or $receive == "Dash" or $receive == "Peercoin" or $receive == "Ethereum" or $receive == "TheBillioncoin") {
								$account_data = '<tr>
													<td><span class="pull-left">'.$lang[your].' '.$receive.' '.$lang[address].'</span></td>
													<td><span class="pull-right">'.$row[u_field_2].'</span></td>
											</tr>';
							} else {
								$account_data = '';
								$check = $db->query("SELECT * FROM bit_gateways WHERE name='$receive' and external_gateway='1'");
								if($check->num_rows>0) {
									$r = $check->fetch_assoc();
									$fieldsquery = $db->query("SELECT * FROM bit_gateways_fields WHERE gateway_id='$r[id]' ORDER BY id");
									if($fieldsquery->num_rows>0) {
										while($field = $fieldsquery->fetch_assoc()) {
											$field_number = $field['field_number']+1;
											$fild = 'u_field_'.$field_number;
											$ret = $row[$fild];
											$account_data .= '<tr>
													<td><span class="pull-left">'.$field[field_name].'</span></td>
													<td><span class="pull-right">'.$ret.'</span></td>
											</tr>';
										}
									}
								} else {
								$account_data = '<tr>
													<td><span class="pull-left">'.$lang[your].' '.$receive.' '.$lang[account].'</span></td>
													<td><span class="pull-right">'.$row[u_field_2].'</span></td>
											</tr>';
								}
							}
							if(gatewayinfo($row['gateway_send'],"exchange_type") == "2" or gatewayinfo($row['gateway_send'],"exchange_type") == "3") {
									$custom_msg = '	<tr>
											<td colspan="2">'.$lang[exchange_was_manually].' '.$settings[worktime_from].' - '.$settings[worktime_to].', '.$settings[worktime_gmt].'</td>
										</tr>';
							} else { $custom_msg = ''; }
							$html_form = '<div id="bit_exchange_results"></div>
									<div class="row">
										<div class="col-md-12">
											<div>
															<table class="table table-striped">
																<tr>
																	<td colspan="2"><h4>'.gatewayinfo($bit_gateway_send,"name").' '.gatewayinfo($bit_gateway_send,"currency").' <i class="fa fa-exchange"></i> '.gatewayinfo($bit_gateway_receive,"name").' '.gatewayinfo($bit_gateway_receive,"currency").'</h4></td>
																</tr>
																'.$custom_msg.'
																<tr>
																	<td><span class="pull-left"><b>'.$lang[exchange_id].'</b></span></td>
																	<td><span class="pull-right"><b>'.$row[exchange_id].'</span></td>
																</tr>
																<tr>
																	<td><span class="pull-left">'.$lang[amount_send].'</span></td>
																	<td><span class="pull-right">'.$row[amount_send].' '.$bit_currency_from.'</span></td>
																</tr>
																<tr>
																	<td><span class="pull-left">'.$lang[amount_receive].'</span></td>
																	<td><span class="pull-right">'.$row[amount_receive].' '.$bit_currency_to.'</span></td>
																</tr>
																'.$account_data.'
																<tr>
																	<td><span class="pull-left">'.$lang[your_email].'</span></td>
																	<td><span class="pull-right">'.$row[u_field_1].'</span></td>
																</tr>
															</table>
															<br>
															<table class="table table-striped">
																<tr>
																	<td><span class="pull-left">'.gatewayinfo($bit_gateway_send,"name").' '.$lang[fee].'</span></td>
																	<td><span class="pull-right">'.$fee_text.'</span></td>
																</tr>
																<tr>
																	<td><span class="pull-left">'.$lang[total_for_payment].'</span></td>
																	<td><span class="pull-right">'.$amount.' '.$currency.'</span></td>
																</tr>
															</table>
															<div class="row">
																<div class="col-sm-6 col-md-6 col-lg-6">
																	<button type="button" class="btn btn-success btn-block" onclick="bit_make_exchange('.$row[id].');"><i class="fa fa-check"></i> '.$lang[btn_confirm_order].'</button>
																	<br>
																</div>
																<div class="col-sm-6 col-md-6 col-lg-6">
																	<button type="button" class="btn btn-danger btn-block" onclick="bit_cancel_exchange('.$row[id].');"><i class="fa fa-times"></i> '.$lang[btn_cancel_order].'</button>
																	<br>
																</div>
															</div>
														</div>
										</div>
									</div>';
							echo $html_form;
					} elseif($row['status'] == "2") {
					?>				
					<script type="text/javascript">
						$(document).ready(function() {
							bit_make_exchange('<?php echo $row['id']; ?>');
						});
					</script>
					<?php
					} else {
					?>
						<table class="table table-striped">
						<tbody>
							<tr>
								<td colspan="4">
									<h2 class="text-center">
										<?php if($row['wid']>0) { echo 'Wallet '.walletinfo($row['wid'],"currency"); } else { ?><img src="<?php echo gatewayicon(gatewayinfo($row['gateway_send'],"name")); ?>" width="36px" height="36px" class="img-circle"> <b><?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></b><?php } ?>
										&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;
										<img src="<?php echo gatewayicon(gatewayinfo($row['gateway_receive'],"name")); ?>" width="36px" height="36px" class="img-circle"> <b><?php echo gatewayinfo($row['gateway_receive'],"name"); ?> <?php echo gatewayinfo($row['gateway_receive'],"currency"); ?></b>
									</h2><br>
									<?php echo $lang['exchange_id']; ?>: <?php echo $row['exchange_id']; ?>
								</td>
							</tr>
							<tr>
								<td colspan="2"><?php echo $lang['send']; ?>: <?php echo $row['amount_send']; ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></td>
								<td colspan="2"><?php echo $lang['receive']; ?>: <?php echo $row['amount_receive']; ?> <?php echo gatewayinfo($row['gateway_receive'],"currency"); ?></td>
							</tr>
							<tr>
								<td colspan="2"><?php echo $lang['exchange_rate']; ?>: <?php echo $row['rate_from']." ".$bit_currency_from; ?> = <?php echo $row['rate_to']." ".$bit_currency_to; ?></td>
								<td colspan="2"><?php echo $lang['transaction_id']; ?>: <?php if($row['transaction_id']) { echo $row['transaction_id']; } else { echo '-'; } ?></td>
							</tr>
							<tr>
								<td colspan="2">
										<?php echo $lang['process_type']; ?>:
										<?php
										$process_type = gatewayinfo($row['gateway_send'],"exchange_type");
										if($process_type == "1") {
											echo '<span class="label label-info">'.$lang[process_type_automatically].'</span>';
										} elseif($process_type == "2") {
											echo '<span class="label label-info">'.$lang[process_type_semi_automatic].'</span>';
										} elseif($process_type == "3") {	
											echo '<span class="label label-info">'.$lang[process_type_manually].'</span>';
										} else {
											echo '<span class="label label-default">'.$lang[process_type_manually].'</span>';
										}
										?>
								</td>
								<td colspan="2">
										<?php echo $lang['status']; ?>:
										<?php
										if($row['status'] == "1") {
											echo '<span class="label label-warning"><i class="fa fa-clock-o"></i> '.$lang[status_1].'</span>';
										} elseif($row['status'] == "2") {
											echo '<span class="label label-warning"><i class="fa fa-clock-o"></i> '.$lang[status_2].'</span>';
										} elseif($row['status'] == "3") {
											echo '<span class="label label-info"><i class="fa fa-clock-o"></i> '.$lang[status_3].'</span>';
										} elseif($row['status'] == "4") {
											echo '<span class="label label-success"><i class="fa fa-check"></i> '.$lang[status_4].'</span>';
										} elseif($row['status'] == "5") {
											echo '<span class="label label-danger"><i class="fa fa-times"></i> '.$lang[status_5].'</span>';
										} elseif($row['status'] == "6") {
											echo '<span class="label label-danger"><i class="fa fa-times"></i> '.$lang[status_6].'</span>';
										} elseif($row['status'] == "7") {
											echo '<span class="label label-danger"><i class="fa fa-times"></i> '.$lang[status_7].'</span>';
										} else {
											echo '<span class="label label-default">'.$lang[status_unknown].'</span>';
										}
										?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<?php echo $lang['created_on']; ?> 
										<?php
										if($row['created']) {
											echo '<span class="label label-default">'.date("d/m/Y H:i:s",$row[created]).'</span>';
										} else {
											echo '-';
										}
										?>
								</td>
								<?php if($row['status']>4 && $row['expired']>0) { ?>
								<td colspan="2">
									<?php echo $lang['expired_on']; ?> 
										<?php
										if($row['expired']) {
											echo '<span class="label label-default">'.date("d/m/Y H:i:s",$row[expired]).'</span>';
										} else {
											echo '-';
										}
										?>
								</td>
								<?php } ?>
								<?php if($row['status'] == "4" && $row['updated']>0) { ?>
								<td colspan="2">
									<?php echo $lang['processed_on']; ?> 
										<?php
										if($row['updated']) {
											echo '<span class="label label-default">'.date("d/m/Y H:i:s",$row[updated]).'</span>';
										} else {
											echo '-';
										}
										?>
								</td>
								<?php } ?>
							</tr>
							</tbody>
					</table>
					
					<?php
					}
					?>
			</div>
								</div>
							</div>
						</div><!-- category-ad -->	
						
						
					</div><!-- product-list -->
				</div><!-- row -->
			</div><!-- main-content -->
		</div><!-- container -->
	</section><!-- main -->
