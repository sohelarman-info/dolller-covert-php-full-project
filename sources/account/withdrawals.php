<h3><?php echo $lang['withdrawals']; ?> <span class="pull-right"><a href="<?php echo $settings['url']; ?>account/withdrawal" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> <?php echo $lang['new']; ?></a></h3>
<hr/>
	<?php
	$query = $db->query("SELECT * FROM bit_users_withdrawals WHERE uid='$_SESSION[bit_uid]' ORDER BY id DESC");
	if($query->num_rows>0) {
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="20%"><?php echo $lang['amount']; ?></th>
						<th width="20%"><?php echo $lang['w_to']; ?></th>
						<th width="20%"><?php echo $lang['status']; ?></th>
						<th width="20%"><?php echo $lang['requested_on']; ?></th>
						<th width="20%"><?php echo $lang['processed_on']; ?></th>
					</tr>
				</thead>
				<tbody>
			<?php
			while($row = $query->fetch_assoc()) {
				?>
				<tr>
					<td><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></td>
					<td><?php echo $row['u_field_1']; ?> (<?php echo $row['company']; ?>)</td>
					<td>
						<?php
						if($row['status'] == "1") {
							echo '<span class="label label-info"><i class="fa fa-clock-o"></i> '.$lang[w_status_1].'</span>'; 
						} elseif($row['status'] == "2") {
							echo '<span class="label label-success"><i class="fa fa-check"></i> '.$lang[w_status_2].'</span>';
						} elseif($row['status'] == "3") {
							echo '<span class="label label-danger"><i class="fa fa-times"></i> '.$lang[w_status_3].'</span>';
						} else {
							echo '<span class="label label-default">'.$lang[status_unknown].'</span>';
						}
						?>
					</td>
					<td><span class="label label-default"><?php echo date("d/m/Y H:i",$row['requested_on']); ?></span></td>
					<td><?php if($row['processed_on']>0) { ?><span class="label label-default"><?php echo date("d/m/Y H:i",$row['processed_on']); ?></span><?php } else { echo '-'; } ?></td>
				</tr>
				<?php
			}
			?>
				</tbody>
			</table>
			<?php
	} else {
		echo info("$lang[no_withdrawals]");
	}
	?>
