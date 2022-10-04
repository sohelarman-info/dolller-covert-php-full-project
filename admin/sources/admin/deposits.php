<?php
$b = protect($_GET['b']);

if($b == "confirm") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_users_deposits WHERE id='$id' and status='2'");
	if($query->num_rows==0) { header("Location: ./?a=dashboard"); }
	$row = $query->fetch_assoc();
	$user = idinfo($row['uid'],"username");
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=dashboard">Deposits</a></li>
		<li class="active">Confirm deposit</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Confirm deposit
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$time = time();
				$update = $db->query("UPDATE bit_users_deposits SET status='3' WHERE id='$row[id]'");
				$amount = $row['amount'];
				$currency = gatewayinfo($row['gateway_id'],"currency");
				$time = time();
				$check = $db->query("SELECT * FROM bit_users_earnings WHERE uid='$row[uid]' and currency='$currency'");
				if($check->num_rows>0) {
					$r = $check->fetch_assoc();
					$am = $r['amount']+$amount;
					$update = $db->query("UPDATE bit_users_earnings SET amount='$am',updated='$time' WHERE id='$r[id]'");
				} else {
					$insert = $db->query("INSERT bit_users_earnings (uid,amount,currency,created) VALUES ('$row[uid]','$amount','$currency','$time')");
				}
				echo success("Money was deposited to <b>$user</b> wallet.");
			} else {
				echo info("Did you check payment from <b>$user</b> is valid?");
				echo '<a href="./?a=deposits&b=confirm&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=deposits" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} elseif($b == "reject") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_users_deposits WHERE id='$id' and status='2'");
	if($query->num_rows==0) { header("Location: ./?a=dashboard"); }
	$row = $query->fetch_assoc();
	$user = idinfo($row['uid'],"username");
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=dashboard">Deposits</a></li>
		<li class="active">Reject deposit</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Reject deposit
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM bit_users_deposits WHERE id='$row[id]'");
				echo success("Deposit of user <b>$user</b> was rejected.");
			} else {
				echo info("Are you sure you want to reject deposit of user <b>$user</b>?");
				echo '<a href="./?a=deposits&b=reject&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=deposits" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
	header("Location: ./?a=dashboard");
}
?>