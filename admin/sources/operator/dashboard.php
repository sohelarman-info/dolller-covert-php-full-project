<ol class="breadcrumb">
	<li><a href="./">BitExchanger Administrator</a></li>
	<li class="active">Dashboard</li>
</ol>

<div class="row">
	<div class="col-lg-12">
		<?php 
		$b = protect($_GET['b']);
		$c = protect($_GET['c']);
		if($b == "operator") {
			if($c == "turn_offline") {
				$update = $db->query("UPDATE bit_settings SET operator_status='0'");
				header("Location: ./");
			} 
			if($c == "turn_online") {
				$update = $db->query("UPDATE bit_settings SET operator_status='1'");
				header("Location: ./");
			}
		}
		if($settings['operator_status'] == "1") {
			echo info("Current operator status is: <b>Online</b>. <a href='./?a=dashboard&b=operator&c=turn_offline'>Click here</a> to change status to offline.");
		} else {
			echo info("Current operator status is: <b>Offline</b>. <a href='./?a=dashboard&b=operator&c=turn_online'>Click here</a> to change status to online.");
		}
		?>
	</div>
	<div class="col-lg-3">
		 <div class="panel panel-default twitter">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Users</small>
                        <h3 class="count">
                            <?php $get_stats = $db->query("SELECT * FROM bit_users"); echo $get_stats->num_rows; ?></h3>
                        <i class="fa fa-users"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-default google-plus">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Exchanges</small>
                        <h3 class="count">
                            <?php $get_stats = $db->query("SELECT * FROM bit_exchanges"); echo $get_stats->num_rows; ?></h3>
                        <i class="fa fa-refresh"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-default facebook-like">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Testimonials</small>
                        <h3 class="count">
                            <?php $get_stats = $db->query("SELECT * FROM bit_testimonials"); echo $get_stats->num_rows; ?></h3>
                        <i class="fa fa-comments"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-default visitor">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Withdrawals</small>
                        <h3 class="count">
                            <?php $get_stats = $db->query("SELECT * FROM bit_users_withdrawals"); echo $get_stats->num_rows; ?></h3>
                        <i class="fa fa-dollar"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-12">
		<?php
		if(isset($_POST['btn_update_reserve'])) {
			$gateway_id = protect($_POST['gateway_id']);
			$reserve = protect($_POST['reserve']);
			if(empty($gateway_id) or empty($reserve)) { echo error("Please select gateway and enter reserve."); }
			elseif(!is_numeric($reserve)) { echo error("Please enter reserve with numbers."); }
			else {
				$update = $db->query("UPDATE bit_gateways SET reserve='$reserve' WHERE id='$gateway_id'");
				echo success("Reserve was updated successfully.");
			}
		}
		
		if(isset($_POST['btn_update_rate'])) {
			$rid = protect($_POST['rid']);
			$rate_from = protect($_POST['rate_from']);
			$rate_to = protect($_POST['rate_to']);
			if(empty($rid) or empty($rate_from) or empty($rate_to)) { echo error("Please select exchange rate and enter rate from and rate to."); }
			elseif(!is_numeric($rate_from)) { echo error("Please enter rate from with numbers."); }
			elseif(!is_numeric($rate_to)) { echo error("Please enter rate to with numbers."); } 
			else {
				$update = $db->query("UPDATE bit_rates SET rate_from='$rate_from',rate_to='$rate_to' WHERE id='$rid'");
				echo success("Exchange rate was updated successfully.");
			}
		}
		?>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">Quickly update reserve</div>
			<div class="panel-body">
				<form action="" method="POST">
					<div class="form-group">
						<label>Gateway</label>
						<select class="form-control" name="gateway_id">
							<?php
							$query = $db->query("SELECT * FROM bit_gateways WHERE status='1' ORDER BY id");
							if($query->num_rows>0) {
								while($row = $query->fetch_assoc()) {
									echo '<option value="'.$row[id].'">'.$row[name].' '.$row[currency].' (Current reserve: '.$row[reserve].' '.$row[currency].')</option>';
								}
							} else {
								echo '<option>No gateways</option>';
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>New reserve</label>
						<input type="text" class="form-control" name="reserve">
					</div>
					<button type="submit" class="btn btn-primary" name="btn_update_reserve"><i class="fa fa-check"></i> Update</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">Quickly update exchange rate</div>
			<div class="panel-body">
				<form action="" method="POST">
					<div class="form-group">
						<label>List with exchange rates</label>
						<select class="form-control" name="rid">
							<?php
							$query = $db->query("SELECT * FROM bit_rates ORDER BY id");
							if($query->num_rows>0) {
								while($row = $query->fetch_assoc()) {
									echo '<option value="'.$row[id].'">'.gatewayinfo($row[gateway_from],"name").' '.gatewayinfo($row[gateway_from],"currency").' ('.$row[rate_from].' '.gatewayinfo($row[gateway_from],"currency").') = '.gatewayinfo($row[gateway_to],"name").' '.gatewayinfo($row[gateway_to],"currency").' ('.$row[rate_to].' '.gatewayinfo($row[gateway_to],"currency").')</option>';
								}
							} else {
								echo '<option>No gateways</option>';
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>New exchange rate</label>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Rate from</span>
							<input type="text" class="form-control" name="rate_from" placeholder="1" aria-describedby="basic-addon1">
							<span class="input-group-addon" id="basic-addon1">=&nbsp;&nbsp; Rate to</span>
							<input type="text" class="form-control" name="rate_to" placeholder="0.95" aria-describedby="basic-addon1">
						</div>
					</div>
					<button type="submit" class="btn btn-primary" name="btn_update_rate"><i class="fa fa-check"></i> Update</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">Pending exchanges</div>
			<div class="panel-body">
				<table class="table">
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
			  $t=1;
			  $query = $db->query("SELECT * FROM bit_exchanges WHERE status='3' ORDER BY id");
			  if($query->num_rows>0) {
			    while($row = $query->fetch_assoc()) {
				?>
				<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php if($row['wid']>0) { echo 'Wallet '.walletinfo($row['wid'],"currency"); } else { ?><?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?><?php } ?></td>
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
				$t++;
				}
			  } else {
				echo '<tr><td colspan="8">No have requests for exchanges.</td></tr>';
			  }
			  ?>
		      </tbody>
		    </table>
			</div>	
		</div>
		<?php
		$query = $db->query("SELECT * FROM bit_users WHERE document_1 != '' and document_verified='0' ORDER BY id");
		if($query->num_rows>0) {
		?>
		<br>
		<div class="panel panel-primary">
			<div class="panel-heading">Pending documents for approval</div>
			<div class="panel-body">
				<table class="table">
		      <thead>
		        <tr>
					<th width="5%">ID</th>
					<th width="15%">Username</th>
					<th width="15%">Email address</th>
					<th width="15%">Document 1</th>
					<th width="15%">Document 2</th>
					<th width="15%">Registered on</th>
					<th width="10%">Action</th>
				</tr>
		      </thead>
		      <tbody>
		      <?php
			    while($row = $query->fetch_assoc()) {
				?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['username']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><a href="<?php echo $settings['url'].$row['document_1']; ?>" target="_blank"><?php echo basename($row['document_1']); ?></a></td>
							<td><a href="<?php echo $settings['url'].$row['document_2']; ?>" target="_blank"><?php echo basename($row['document_2']); ?></a></td>
							<td><span class="label label-primary"><?php echo date("d/m/Y H:i:s",$row['signup_time']); ?></span></td>
							<td>
								<a href="./?a=users&b=edit&id=<?php echo $row['id']; ?>" title="Approve"><i class="fa fa-check"></i></a>
							</td>
						</tr>
				<?php 
				$i++;
				}
			  ?>
		      </tbody>
		    </table>
			
			</div>	
		</div>
		<?php
		}
		?>
		
				<br>
		<div class="panel panel-primary">
			<div class="panel-heading">Pending withdrawals</div>
			<div class="panel-body">
				<table class="table">
		      <thead>
		        <tr>
					<th width="5%">ID</th>
					<th width="15%">User</th>
					<th width="15%">Amount</th>
					<th width="25%">Account</th>
					<th width="10%">Status</th>
					<th width="10%">Requested on</th>
					<th width="15%">Processed on</th>
					<th width="10%">Action</th>
				</tr>
		      </thead>
		      <tbody>
		      <?php
			  $i=1;
			  $query = $db->query("SELECT * FROM bit_users_withdrawals WHERE status='1' ORDER BY id");
			  if($query->num_rows>0) {
			    while($row = $query->fetch_assoc()) {
				?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"username"); ?></a></td>
							<td><?php echo $row['amount']." ".$row['currency']; ?></td>
							<td><?php echo $row['u_field_1']; ?> (<?php echo $row['company']; ?>)</td>
								<td>
									<?php
									if($row['status'] == "1") {
										echo '<span class="label label-info"><i class="fa fa-clock-o"></i> Awaiting</span>'; 
									} elseif($row['status'] == "2") {
										echo '<span class="label label-success"><i class="fa fa-check"></i> Processed</span>';
									} elseif($row['status'] == "3") {
										echo '<span class="label label-danger"><i class="fa fa-times"></i> Cancaled</span>';
									} else {
										echo '<span class="label label-default">Unknown</span>';
									}
									?>
								</td>
								<td><span class="label label-default"><?php echo date("d/m/Y H:i",$row['requested_on']); ?></span></td>
								<td><?php if($row['processed_on']>0) { ?><span class="label label-default"><?php echo date("d/m/Y H:i",$row['processed_on']); ?></span><?php } else { echo '-'; } ?></td>
									<td>
								<?php if($row['status'] == "1") { ?>
								<a href="./?a=withdrawals&b=approve&id=<?php echo $row['id']; ?>" title="Approve"><i class="fa fa-check"></i></a>
								<a href="./?a=withdrawals&b=reject&id=<?php echo $row['id']; ?>" title="Reject"><i class="fa fa-times"></i></a>
								<?php } ?>
							</td>
						</tr>
				<?php 
				$i++;
				}
			  } else {
				echo '<tr><td colspan="5">No have requests for withdrawal.</td></tr>';
			  }
			  ?>
		      </tbody>
		    </table>
			
			</div>	
		</div>
				<br>
		<div class="panel panel-primary">
			<div class="panel-heading">Pending deposits</div>
			<div class="panel-body">
				<table class="table">
		      <thead>
		        <tr>
					<th width="15%">User</th>
					<th width="10%">Amount</th>
					<th width="15%">Gateway</th>
					<th width="15%">Payment description</th>
					<th width="30%">Transaction ID/Batch/PIN</th>
					<th width="10%">Action</th>
				</tr>
		      </thead>
		      <tbody>
		      <?php
			  $i=1;
			  $query = $db->query("SELECT * FROM bit_users_deposits WHERE status='2' ORDER BY id");
			  if($query->num_rows>0) {
			    while($row = $query->fetch_assoc()) {
				?>
						<tr>
							<td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"username"); ?></a></td>
							<td><?php echo $row['amount']." ".gatewayinfo($row['gateway_id'],"currency"); ?></td>
							<td><?php echo gatewayinfo($row['gateway_id'],"name").' '.gatewayinfo($row['gateway_id'],"currency"); ?></td>
							<td><?php echo $row['payment_hash']; ?></td>
							<td><?php echo $row['txid']; ?></td>
							<td>
								<a href="./?a=deposits&b=confirm&id=<?php echo $row['id']; ?>" title="Confirm deposit"><i class="fa fa-check"></i></a>
								<a href="./?a=deposits&b=reject&id=<?php echo $row['id']; ?>" title="Reject deposit"><i class="fa fa-times"></i></a>
							</td>
						</tr>
				<?php 
				$i++;
				}
			  } else {
				echo '<tr><td colspan="5">No have requests for deposit.</td></tr>';
			  }
			  ?>
		      </tbody>
		    </table>
			
			</div>	
		</div>
		
	</div>
</div>