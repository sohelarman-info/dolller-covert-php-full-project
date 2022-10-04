<?php
$b = protect($_GET['b']);

if($b == "approve") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_users_withdrawals WHERE id='$id' and status='1'");
	if($query->num_rows==0) { header("Location: ./?a=withdrawals"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Operator</a></li>
		<li><a href="./?a=testimonials">Withdrawals</a></li>
		<li class="active">Approve withdrawal</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Approve withdrawal
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$time = time();
				$update = $db->query("UPDATE bit_users_withdrawals SET status='2',processed_on='$time' WHERE id='$row[id]'");
				echo success("Withdrawal of user <b>$user</b> for $row[amount] $row[currency] was approved.");
			} else {
				echo info("Did you make payment to <b>$user</b> for $row[amount] $row[currency]?");
				echo '<a href="./?a=withdrawals&b=approve&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=withdrawals" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} elseif($b == "reject") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_users_withdrawals WHERE id='$id' and status='1'");
	if($query->num_rows==0) { header("Location: ./?a=withdrawals"); }
	$row = $query->fetch_assoc();
	$user = idinfo($row['uid'],"username");
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Operator</a></li>
		<li><a href="./?a=withdrawals">Withdrawals</a></li>
		<li class="active">Reject withdrawal</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Reject withdrawal
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$update = $db->query("UPDATE bit_users_withdrawals SET status='3' WHERE id='$row[id]'");
				$getwallet = $db->query("SELECT * FROM bit_users_earnings WHERE uid='$row[uid]' and currency='$row[currency]'");
				$w = $getwallet->fetch_assoc();
				$newearnings = $w['amount']+$row['amount'];
				$update = $db->query("UPDATE bit_users_earnings SET amount='$newearnings' WHERE id='$w[id]'");
				echo success("Withdrawal of user <b>$user</b> for $row[amount] $row[currency] was rejected.");
			} else {
				echo info("Are you sure you want to reject withdrawal of user <b>$user</b> for $row[amount] $row[currency]?");
				echo '<a href="./?a=withdrawals&b=reject&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=withdrawals" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./">BitExchanger Operator</a></li>
	<li class="active">Withdrawals</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Withdrawals
	</div>
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="5%">ID</th>
					<th width="15%">User</th>
					<th width="15%">Amount</th>
					<th width="25%">Account</th>
					<th width="10%">Status</th>
					<th width="10%">Requested on</th>
					<th width="10%">Processed on</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;
				if($page == 1) {
					$i = 1;
				} else {
					$i = $page * $limit;
				}
				$statement = "bit_users_withdrawals";
				$query = $db->query("SELECT * FROM {$statement} ORDER BY id LIMIT {$startpoint} , {$limit}");
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $row['id']; ?>
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
					}
				} else {
					echo '<tr><td colspan="4">Still no have testimonials.</td></tr>';
				}
				?>
			</tbody>
		</table>
		<?php
		$ver = "./?a=testimonials";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
</div>
<?php
}
?>