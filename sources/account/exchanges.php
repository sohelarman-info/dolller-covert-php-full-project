<h3><?php echo $lang['my_exchanges']; ?></h3>
<hr/>
	<?php
	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 10;
	$startpoint = ($page * $limit) - $limit;
	if($page == 1) {
		$i = 1;
	} else {
		$i = $page * $limit;
	}
	$statement = "bit_exchanges WHERE uid='$_SESSION[bit_uid]'";
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
									<?php echo $lang['exchange_id']; ?>: <a href="<?php echo $settings['url']; ?>account/exchange/<?php echo $row['exchange_id']; ?>"><?php echo $row['exchange_id']; ?></a>
									<span class="pull-right">
										from <?php if($row['wid']>0) { echo 'Wallet '.walletinfo($row[wid],"currency"); } else { ?><img src="<?php echo gatewayicon(gatewayinfo($row['gateway_send'],"name")); ?>" width="24px" height="24px" class="img-circle"> <b><?php echo gatewayinfo($row['gateway_send'],"name"); ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?><?php } ?></b>
										to <img src="<?php echo gatewayicon(gatewayinfo($row['gateway_receive'],"name")); ?>" width="24px" height="24px" class="img-circle"> <b><?php echo gatewayinfo($row['gateway_receive'],"name"); ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></b>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo $lang['send']; ?>: <?php echo $row['amount_send']; ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></td>
								<td><?php echo $lang['receive']; ?>: <?php echo $row['amount_receive']; ?> <?php echo gatewayinfo($row['gateway_receive'],"currency"); ?></td>
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
							<?php
							if($row['status'] == "1") {
								$link = $settings['url']."account/exchange/".$row['exchange_id'];
								$msg = info("$lang[info_4] <a href='$link' style='color:#E3E3E3;'>$lang[button_1]</a> $lang[to_take_action].");
								echo '<tr><td colspan="4">'.$msg.'</td></tr>';
							}
							if($row['status'] == "2") {
								$link = $settings['url']."account/exchange/".$row['exchange_id'];
								$msg = info("$lang[info_5] <a href='$link' style='color:#E3E3E3;'>$lang[button_1]</a> $lang[to_take_action].");
								echo '<tr><td colspan="4">'.$msg.'</td></tr>';
							}
							?>
							</tbody>
					</table>
					</div>
				</div>
				<?php
			}
	} else {
		echo info("$lang[no_have_exchanges] <a href='$settings[url]' style='color:#E3E3E3;'>$lang[button_1]</a> $lang[to_make_first_exchange].");
	}
	?>

<?php
$ver = $settings['url']."account/exchanges";
if(web_pagination($statement,$ver,$limit,$page)) {
	echo web_pagination($statement,$ver,$limit,$page);
}
?>