<?php
$b = protect($_GET['b']);

if($b == "explore") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=exchanges"); }
	$row = $query->fetch_assoc();
	$bit_currency_from = gatewayinfo($row['gateway_send'],"currency");
	$bit_currency_to = gatewayinfo($row['gateway_receive'],"currency");
	?>
	<script type="text/javascript">
		function show_field(value) {
			if(value == "4") {
				$("#wfield").show();
			} else {
				$("#wfield").hide();
			}
		}
	</script>
	
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=exchanges">Exchanges</a></li>
		<li class="active">Explore</li>
	</ol>
	
	<div class="row">
		<div class="col-md-12">
			<?php
			if(isset($_POST['btn_update'])) {
				$status = protect($_POST['status']);
				$time = time();
				if($status == "4") {
					$receive = gatewayinfo($row['gateway_receive'],"name");
					$pin = protect($_POST['pin']);
					if($receive == "Western Union" && empty($pin)) { echo error("Please enter $receive transaction pin."); }
					elseif($receive == "Moneygram" && empty($pin)) { echo error("Please enter $receive transaction pin."); }
					else {
						$reserve = gatewayinfo($row['gateway_receive'],"reserve");
						$nreserve = $reserve-$row[amount_receive];
						$update = $db->query("UPDATE bit_gateways SET reserve='$nreserve' WHERE id='$row[gateway_receive]'");
						$update = $db->query("UPDATE bit_exchanges SET status='4',u_field_10='$pin',updated='$time' WHERE id='$row[id]'");
						$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
						$row = $query->fetch_assoc();
						emailsys_exchange_processed($row['id']);
						echo success("Status changed to Processed. Client will be notified via email.");
					}
				} else {
					if($status == "1") {
						$status_txt = 'Awaiting Confirmation';
					} elseif($status == "2") {
						$status_txt = 'Awaiting Payment';
					} elseif($status == "3") {
						$status_txt = 'Processing';
					} elseif($status == "4") {
						$status_txt = 'Processed';
					} elseif($status == "5") {
						$status_txt = 'Timeout';
					} elseif($status == "6") {
						$status_txt = 'Denied';
					} elseif($status == "7") {
						$status_txt = 'Canceled';
					} else {
						$status_txt = 'Unknown';
					}
					$update = $db->query("UPDATE bit_exchanges SET status='$status',updated='$time' WHERE id='$row[id]'");
					echo success("Status changed to $status_txt. Client will be notified via email.");
					$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
					$row = $query->fetch_assoc();
					emailsys_exchange_change_status($row['id']);
				}
			}
			
			if(isset($_POST['btn_profit'])) {
				$profit = protect($_POST['profit']);
				$time = time();
				if(empty($profit)) { echo error("Please enter user profit."); }
				elseif(!is_numeric($profit)) { echo error("Please enter profit with numbers."); }
				else {
					$cur = gatewayinfo($row['gateway_receive'],"currency");
					$refid = $row['referral_id'];
					$refemail = idinfo($refid,"email");
					$refuser = idinfo($refid,"username");
					$equery = $db->query("SELECT * FROM bit_users_earnings WHERE uid='$refid' and currency='$cur'");
					if($equery->num_rows>0) {
						$e = $equery->fetch_assoc();
						$nearnings = $e['amount']+$profit;
						$update = $db->query("UPDATE bit_users_earnings SET amount='$nearnings' WHERE id='$e[id]'");
						$update = $db->query("UPDATE bit_exchanges SET referral_amount='$profit',referral_currency='$cur',referral_status='1' WHERE id='$row[id]'");
						$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
						$row = $query->fetch_assoc();
						emailsys_new_profit($row['id'],$refemail,$refid,$profit,$cur);
						echo success("Profit <b>$profit $cur</b> was gived to $refuser.");
					} else {
						$insert = $db->query("INSERT bit_users_earnings (uid,amount,currency,created,updated) VALUES ('$refid','$profit','$cur','$time','$time')");
						$update = $db->query("UPDATE bit_exchanges SET referral_amount='$profit',referral_currency='$cur',referral_status='1' WHERE id='$row[id]'");
						$query = $db->query("SELECT * FROM bit_exchanges WHERE id='$id'");
						$row = $query->fetch_assoc();
						emailsys_new_profit($row['id'],$refemail,$refid,$profit,$cur);
						echo success("Profit <b>$profit $cur</b> was gived to $refuser.");
					}
				}
			}
			?>
		</div>
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					Explore
				</div>
				<div class="panel-body">

					<table class="table table-striped">
						<tbody>
							<tr>
								<td colspan="4">
									<h2 class="text-center">
										<?php if($row['wid']>0) { echo 'Wallet '.idinfo($row['wid'],"currency"); } else { ?><img src="<?php echo gatewayicon(gatewayinfo($row['gateway_send'],"name")); ?>" width="36px" height="36px" class="img-circle"> <b><?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></b><?php } ?>
										&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;
										<img src="<?php echo gatewayicon(gatewayinfo($row['gateway_receive'],"name")); ?>" width="36px" height="36px" class="img-circle"> <b><?php echo gatewayinfo($row['gateway_receive'],"name"); ?> <?php echo gatewayinfo($row['gateway_receive'],"currency"); ?></b>
									</h2><br>
									Exchange ID: <?php echo $row['exchange_id']; ?>
								</td>
							</tr>
							<tr>
								<td colspan="2">Send: <?php echo $row['amount_send']; ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></td>
								<td colspan="2">Receive: <?php echo $row['amount_receive']; ?> <?php echo gatewayinfo($row['gateway_receive'],"currency"); ?></td>
							</tr>
							<tr>
								<td colspan="2">Exchange rate: <?php echo $row['rate_from']." ".$bit_currency_from; ?> = <?php echo $row['rate_to']." ".$bit_currency_to; ?></td>
								<td colspan="2">Transaction ID: <?php if($row['transaction_id']) { echo $row['transaction_id']; } else { echo '-'; } ?></td>
							</tr>
							<tr>
								<td colspan="2">
										Process type: 
										<?php
										$process_type = gatewayinfo($row['gateway_send'],"exchange_type");
										if($process_type == "1") {
											echo '<span class="label label-info">Automatically</span>';
										} elseif($process_type == "2") {
											echo '<span class="label label-info">Semi-automatic</span>';
										} elseif($process_type == "3") {	
											echo '<span class="label label-info">Manually</span>';
										} else {
											echo '<span class="label label-default">Unknown</span>';
										}
										?>
								</td>
								<td colspan="2">
										Status:
										<?php
										if($row['status'] == "1") {
											echo '<span class="label label-warning"><i class="fa fa-clock-o"></i> Awaiting Confirmation</span>';
										} elseif($row['status'] == "2") {
											echo '<span class="label label-warning"><i class="fa fa-clock-o"></i> Awaiting Payment</span>';
										} elseif($row['status'] == "3") {
											echo '<span class="label label-info"><i class="fa fa-clock-o"></i> Processing</span>';
										} elseif($row['status'] == "4") {
											echo '<span class="label label-success"><i class="fa fa-check"></i> Processed</span>';
										} elseif($row['status'] == "5") {
											echo '<span class="label label-danger"><i class="fa fa-times"></i> Timeout</span>';
										} elseif($row['status'] == "6") {
											echo '<span class="label label-danger"><i class="fa fa-times"></i> Denied</span>';
										} elseif($row['status'] == "7") {
											echo '<span class="label label-danger"><i class="fa fa-times"></i> Canceled</span>';
										} else {
											echo '<span class="label label-default">Unknown</span>';
										}
										?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Created on 
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
									Expired on 
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
									Processed on 
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
					
					<br>
					
					<table class="table table-striped">
						<tbody>
							<tr>
								<td colspan="2">
									<h3 class="text-center">
										Data about transfer
									</h3>
								</td>
							</tr>
							<?php
							$receive = gatewayinfo($row['gateway_receive'],"name");
							if($receive == "Bank Transfer") {
								$account_data = '<tr>
													<td><span class="pull-left">Client name</span></td>
													<td><span class="pull-right">'.$row[u_field_2].'</span></td>
											</tr><tr>
													<td><span class="pull-left">Client location</span></td>
													<td><span class="pull-right">'.$row[u_field_3].'</span></td>
											</tr><tr>
													<td><span class="pull-left">Client bank name</span></td>
													<td><span class="pull-right">'.$row[u_field_4].'</span></td>
											</tr><tr>
													<td><span class="pull-left">Client bank account number/iban</span></td>
													<td><span class="pull-right">'.$row[u_field_5].'</span></td>
											</tr><tr>
													<td><span class="pull-left">Client bank swift code</span></td>
													<td><span class="pull-right">'.$row[u_field_6].'</span></td>
											</tr>';
							} elseif($receive == "Western Union" or $receive == "Moneygram") {
								$account_data = '<tr>
													<td><span class="pull-left">Client name</span></td>
													<td><span class="pull-right">'.$row[u_field_2].'</span></td>
											</tr><tr>
													<td><span class="pull-left">Client location</span></td>
													<td><span class="pull-right">'.$row[u_field_3].'</span></td>
											</tr>';
							} elseif($receive == "Bitcoin" or $receive == "Litecoin" or $receive == "Dogecoin" or $receive == "Dash" or $receive == "Peercoin" or $receive == "Ethereum") {
								$account_data = '<tr>
													<td><span class="pull-left">Client '.$receive.' address</span></td>
													<td><span class="pull-right">'.$row[u_field_2].'</span></td>
											</tr>';
							} else {
								$account_data = '<tr>
													<td><span class="pull-left">Client '.$receive.' account</span></td>
													<td><span class="pull-right">'.$row[u_field_2].'</span></td>
											</tr>';
							}
							echo $account_data;
							?>
							<tr>
								<td><span class="pull-left">Client email address</span></td>
								<td><span class="pull-right"><?php echo $row['u_field_1']; ?></span></td>
							</tr>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					Exchange status
				</div>
				<div class="panel-body">
					<form action="" method="POST">
						<div class="form-group">
							<label>Status</label>
							<select class="form-control" name="status" onchange="show_field(this.value);">
								<option value="1" <?php if($row['status'] == "1") { echo 'selected'; } ?>>Awaiting Confirmation</option>
								<option value="2" <?php if($row['status'] == "2") { echo 'selected'; } ?>>Awaiting Payment</option>
								<option value="3" <?php if($row['status'] == "3") { echo 'selected'; } ?>>Processing</option>
								<option value="4" <?php if($row['status'] == "4") { echo 'selected'; } ?>>Processed</option>
								<option value="5" <?php if($row['status'] == "5") { echo 'selected'; } ?>>Timeout</option>
								<option value="6" <?php if($row['status'] == "6") { echo 'selected'; } ?>>Denied</option>
								<option value="7" <?php if($row['status'] == "7") { echo 'selected'; } ?>>Canceled</option>
							</select>
						</div>
						<?php if($receive == "Western Union" or $receive == "Moneygram") { ?>
						<div class="form-group" id="wfield" style="display:none;"> 
							<label><?php echo $receive; ?> PIN</label>
							<input type="text" class="form-control" name="pin">
							<small>Please enter in field PIN code of transaction so that customers can get their money</smalL>
						</div>
						<?php } ?>
						<button type="submit" class="btn btn-primary" name="btn_update"><i class="fa fa-check"></i> Update</button>
					</form>	
				</div>
			</div>
			
			<?php
			if($row['referral_id']>0 && $row['referral_status'] == "0") {
				?>
				<div class="panel panel-default">
					<div class="panel-heading">
						Give referral profit
					</div>
					<div class="panel-body">
						<small>This exchange is due to the user <a href="./?a=users&b=edit&id=<?php echo $row['referral_id']; ?>"><?php echo idinfo($row['referral_id'],"username"); ?></a> according partner program, he/she must get its reward from system.</small>
						<form action="" method="POST">
							<?php if(gatewayinfo($row['gateway_send'],"currency") == gatewayinfo($row['gateway_receive'],"currency")) { ?>
								<?php
								$com = $row['amount_send'] - $row['amount_receive'];
								$percentage = 100 + $settings['referral_comission'];
								$com2 = ($com * 100) / $percentage; 
								$com = $com-$com2; 
								$comission = number_format($com,2);
								?>
								<div class="form-group">
									<label>Profit</label>
									<div class="input-group">
									  <input type="text" class="form-control" placeholder="Amount" name="profit" value="<?php echo $comission; ?>" aria-describedby="basic-addon1">
									  <span class="input-group-addon" id="basic-addon1"><?php echo gatewayinfo($row['gateway_receive'],"currency"); ?></span>
									</div>
								</div>
							<?php } else { ?>
								<?php echo info("As the currencies of exchange are different, we can not automatically calculate the profit of the user. Please enter it manually."); ?>
								<div class="form-group">
									<label>Profit</label>
									<div class="input-group">
									  <input type="text" class="form-control" placeholder="Amount" name="profit" aria-describedby="basic-addon1">
									  <span class="input-group-addon" id="basic-addon1"><?php echo gatewayinfo($row['gateway_receive'],"currency"); ?></span>
									</div>
								</div>
							<?php } ?>
							<button type="submit" class="btn btn-primary" name="btn_profit"><i class="fa fa-check"></i> Give profit</button>
						</form>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./">BitExchanger Administrator</a></li>
	<li class="active">Exchanges</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Exchanges
		<span class="pull-right">
			<form action="" method="POST">
				<input type="text" class="input_search" name="qry" placeholder="Search...">
			</form>
		</span>
	</div>
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="5%">ID</th>
					<th width="10%">From</th>
					<th width="10%">To</th>
					<th width="20%">Amount send (receive)</th>
					<th width="20%">Exchange ID</th>
					<th width="10%">Status</th>
					<th width="10%">Process type</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$searching=0;
				if(isset($_POST['qry'])) {
					$searching=1;
					$qry = protect($_POST['qry']);
				}
				$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;
				if($page == 1) {
					$i = 1;
				} else {
					$i = $page * $limit;
				}
				$statement = "bit_exchanges";
				if($searching==1) {
					if(empty($qry)) {
						$qry = 'empty query';
					}
					$query = $db->query("SELECT * FROM {$statement} WHERE id LIKE '%$qry%' or exchange_id LIKE '%$qry%' ORDER BY id");
				} else {
					$query = $db->query("SELECT * FROM {$statement} ORDER BY id LIMIT {$startpoint} , {$limit}");
				}
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php if($row['wid']>0) { echo 'Wallet '.walletinfo($row['wid'],"currency"); } else { echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); } ?></td>
							<td><?php echo gatewayinfo($row['gateway_receive'],"name"); ?> <?php echo gatewayinfo($row['gateway_receive'],"currency"); ?></td>
							<td><?php echo $row['amount_send']; ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?> (<?php echo $row['amount_receive']; ?> <?php echo gatewayinfo($row['gateway_receive'],"currency"); ?>)</td>
							<td><span class="label label-default"><?php echo $row['exchange_id']; ?></span></td>
							<td>
								<?php
										if($row['status'] == "1") {
											echo '<span class="label label-warning"><i class="fa fa-clock-o"></i> Awaiting Confirmation</span>';
										} elseif($row['status'] == "2") {
											echo '<span class="label label-warning"><i class="fa fa-clock-o"></i> Awaiting Payment</span>';
										} elseif($row['status'] == "3") {
											echo '<span class="label label-info"><i class="fa fa-clock-o"></i> Processing</span>';
										} elseif($row['status'] == "4") {
											echo '<span class="label label-success"><i class="fa fa-check"></i> Processed</span>';
										} elseif($row['status'] == "5") {
											echo '<span class="label label-danger"><i class="fa fa-times"></i> Timeout</span>';
										} elseif($row['status'] == "6") {
											echo '<span class="label label-danger"><i class="fa fa-times"></i> Denied</span>';
										} elseif($row['status'] == "7") {
											echo '<span class="label label-danger"><i class="fa fa-times"></i> Canceled</span>';
										} else {
											echo '<span class="label label-default">Unknown</span>';
										}
										?>
							</td>
							<td>
										<?php
										$process_type = gatewayinfo($row['gateway_send'],"exchange_type");
										if($process_type == "1") {
											echo '<span class="label label-info">Automatically</span>';
										} elseif($process_type == "2") {
											echo '<span class="label label-info">Semi-automatic</span>';
										} elseif($process_type == "3") {	
											echo '<span class="label label-info">Manually</span>';
										} else {
											echo '<span class="label label-default">Manually</span>';
										}
										?>
							</td>
							<td>
								<a href="./?a=exchanges&b=explore&id=<?php echo $row['id']; ?>" title="Explore"><i class="fa fa-search"></i> Explore</a>
							</td>
						</tr>
						<?php
					}
				} else {
					if($searching == "1") {
						echo '<tr><td colspan="8">No found results for <b>'.$qry.'</b>.</td></tr>';
					} else {
						echo '<tr><td colspan="8">Still no have exchanges.</td></tr>';
					}
				}
				?>
			</tbody>
		</table>
		<?php
		if($searching == "0") {
			$ver = "./?a=exchanges";
			if(admin_pagination($statement,$ver,$limit,$page)) {
				echo admin_pagination($statement,$ver,$limit,$page);
			}
		}
		?>
	</div>
</div>
<?php
}
?>