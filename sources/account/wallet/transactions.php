<h3><?php echo $lang['transactions']; ?></h3>
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
	$statement = "bit_users_transactions WHERE sender='$_SESSION[bit_uid]' or recipient='$_SESSION[bit_uid]'";
	$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
	if($query->num_rows>0) {
				?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="20%"><?php echo $lang['sender']; ?></th>
						<th width="20%"><?php echo $lang['recipient']; ?></th>
						<th width="20%"><?php echo $lang['amount']; ?></th>
						<th width="20%"><?php echo $lang['payment_description']; ?></th>
						<th width="20%"><?php echo $lang['date']; ?></th>
					</tr>
				</thead>
				<tbody>
			<?php
			while($row = $query->fetch_assoc()) {
				?>
				<tr>
					<td><?php echo idinfo($row['sender'],"username"); ?> <?php if($row['sender'] == $_SESSION['bit_uid']) { echo '(You)'; } ?></td>
					<td><?php echo idinfo($row['recipient'],"username"); ?> <?php if($row['recipient'] == $_SESSION['bit_uid']) { echo '(You)'; } ?></td>
					<td><?php echo $row['amount']." ".$row['currency']; ?></td>
					<td><?php echo $row['description']; ?></td>
					<td><?php echo date("d/m/Y H:i",$row['time']); ?></td>
				</tr>
				<?php
			}
			?>
				</tbody>
			</table>
			<?php
	} else {
		echo info("$lang[info_7]");
	}
	?>

<?php
$ver = $settings['url']."account/wallet/transactions";
if(web_pagination($statement,$ver,$limit,$page)) {
	echo web_pagination($statement,$ver,$limit,$page);
}
?>