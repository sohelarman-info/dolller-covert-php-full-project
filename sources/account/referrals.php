<h3><?php echo $lang['referrals']; ?></h3>
<hr/>
	<div class="input-group">
	  <span class="input-group-addon" id="basic-addon1"><?php echo $lang['your_referral_link']; ?></span>
	  <input type="text" class="form-control" value="<?php echo $settings['url']; ?>ref/<?php echo $_SESSION['bit_uid']; ?>" onClick="this.select();">
	</div>
	<br>
	
	<?php
	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 10;
	$startpoint = ($page * $limit) - $limit;
	if($page == 1) {
		$i = 1;
	} else {
		$i = $page * $limit;
	}
	$statement = "bit_exchanges WHERE status='4' and referral_id='$_SESSION[bit_uid]'";
	$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
	if($query->num_rows>0) {
			while($row = $query->fetch_assoc()) {
				?>
				<div class="panel panel-default">
					<div class="panel-body">
						<table class="table table-striped">
						<tbody>
							<tr>
								<td colspan="4">
									<?php echo $lang['exchange_id']; ?>: <?php echo $row['exchange_id']; ?>
									<span class="pull-right">
										from <img src="<?php echo gatewayicon(gatewayinfo($row['gateway_send'],"name")); ?>" width="24px" height="24px" class="img-circle"> <b><?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></b>
										to <img src="<?php echo gatewayicon(gatewayinfo($row['gateway_receive'],"name")); ?>" width="24px" height="24px" class="img-circle"> <b><?php echo gatewayinfo($row['gateway_receive'],"name"); ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></b>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo $lang['client_exchange']; ?>: <?php echo $row['amount_send']; ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></td>
								<td><?php echo $lang['your_profit']; ?>: <?php if($row['referral_amount']) {  echo $row['referral_amount']." ".$row['referral_currency']; } else { echo '-'; } ?></td>
								<td>
									<span class="pull-right">
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
									</span>
								</td>
								<td>
									<span class="pull-right">
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
									</span>
								</td>
							</tr>
							</tbody>
					</table>
						<?php
						if(empty($row['referral_amount']) or $row['referral_amount'] == "0") {
							echo info($lang['profit_not_calculated']);
						}
						?>
					</div>
				</div>
				<?php
			}
	} else {
		echo info($lang['info_6']);
	}
	?>

<?php
$ver = $settings['url']."account/referrals";
if(web_pagination($statement,$ver,$limit,$page)) {
	echo web_pagination($statement,$ver,$limit,$page);
}
?>