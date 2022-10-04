<h3><?php echo $lang['wallet']; ?>
<span class="pull-right">
	<a href="<?php echo $settings['url']; ?>account/wallet/exchange" class="btn btn-primary btn-sm"><?php echo $lang['exchange']; ?></a> 
	<a href="<?php echo $settings['url']; ?>account/wallet/deposit" class="btn btn-primary btn-sm"><?php echo $lang['deposit']; ?></a> 
	<a href="<?php echo $settings['url']; ?>account/wallet/send-money" class="btn btn-primary btn-sm"><?php echo $lang['send_money']; ?></a> 
	<a href="<?php echo $settings['url']; ?>account/wallet/transactions" class="btn btn-primary btn-sm"><?php echo $lang['transactions']; ?></a> 
</span>
</h3>
<hr/>
	<?php
	$query = $db->query("SELECT * FROM bit_users_earnings WHERE uid='$_SESSION[bit_uid]' ORDER BY id");
	if($query->num_rows>0) {
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="30%"><?php echo $lang['wallet']; ?></th>
						<th width="25%"><?php echo $lang['first_profit_on']; ?></th>
						<th width="25%"><?php echo $lang['last_profit_on']; ?></th>
						<th width="20%"><?php echo $lang['action']; ?></th>
					</tr>
				</thead>
				<tbody>
			<?php
			while($row = $query->fetch_assoc()) {
				?>
				<tr>
					<td><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></td>
					<td><span class="label label-default"><?php echo date("d/m/Y H:i:s",$row['created']); ?></span></td>
					<td><span class="label label-default"><?php echo date("d/m/Y H:i:s",$row['updated']); ?></span></td>
					<td><a href="<?php echo $settings['url']; ?>account/withdrawal"><i class="fa fa-download"></i> <?php echo $lang['withdrawal']; ?></a></td>
				</tr>
				<?php
			}
			?>
				</tbody>
			</table>
			<?php
	} else {
		echo info("$lang[info_8]");
	}
	?>