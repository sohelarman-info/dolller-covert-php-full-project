<?php
$b = protect($_GET['b']);

if($b == "add") {
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=rates">Rates</a></li>
		<li class="active">Add rate</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Add rate
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_add'])) {
				$gateway_from = protect($_POST['gateway_from']);
				$gateway_to = protect($_POST['gateway_to']);
				$rate_from = protect($_POST['rate_from']);
				$rate_to = protect($_POST['rate_to']);
				$check = $db->query("SELECT * FROM bit_rates WHERE gateway_from='$gateway_from' and gateway_to='$gateway_to'");
				if(empty($gateway_from) or empty($gateway_to) or empty($rate_from) or empty($rate_to)) { echo error("All fields are required."); }
				elseif($check->num_rows>0) { echo error("This exchange rate already exists."); }
				elseif(!is_numeric($rate_from)) { echo error("Please enter rate from with numbers."); }
				elseif(!is_numeric($rate_to)) { echo error("Please enter rate to with numbers."); }
				else {
					$insert = $db->query("INSERT bit_rates (gateway_from,gateway_to,rate_from,rate_to) VALUES ('$gateway_from','$gateway_to','$rate_from','$rate_to')");
					echo success("Exchange rate was added successfully.");
				}
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
					<label>Gateway from</label>
					<select class="form-control" name="gateway_from">
						<?php
						$list = $db->query("SELECT * FROM bit_gateways WHERE allow_send='1' and status='1' ORDER BY id");
						if($list->num_rows>0) {
							while($l = $list->fetch_assoc()) {
								echo '<option value="'.$l[id].'">'.$l[name].' '.$l[currency].'</option>';
							}
						} else {
							echo '<option>No have gateways.</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Gateway to</label>
					<select class="form-control" name="gateway_to">
						<?php
						$list = $db->query("SELECT * FROM bit_gateways WHERE allow_receive='1' and status='1' ORDER BY id");
						if($list->num_rows>0) {
							while($l = $list->fetch_assoc()) {
								echo '<option value="'.$l[id].'">'.$l[name].' '.$l[currency].'</option>';
							}
						} else {
							echo '<option>No have gateways.</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Rate from</span>
						<input type="text" class="form-control" name="rate_from" placeholder="1" aria-describedby="basic-addon1">
						<span class="input-group-addon" id="basic-addon1">=&nbsp;&nbsp; Rate to</span>
						<input type="text" class="form-control" name="rate_to" placeholder="0.95" aria-describedby="basic-addon1">
					</div>
				</div>
				<button type="submit" class="btn btn-primary" name="btn_add"><i class="fa fa-plus"></i> Add</button>
			</form>		
		</div>
	</div>
	<?php
} elseif($b == "edit") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_rates WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=rates"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./">Administrator</a></li>
		<li><a href="./?a=rate">Rates</a></li>
		<li class="active">Edit rate</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Edit rate
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_save'])) {
				$gateway_from = protect($_POST['gateway_from']);
				$gateway_to = protect($_POST['gateway_to']);
				$rate_from = protect($_POST['rate_from']);
				$rate_to = protect($_POST['rate_to']);
				if(empty($rate_from) or empty($rate_to)) { echo error("All fields are required."); }
				elseif(!is_numeric($rate_from)) { echo error("Please enter rate from with numbers."); }
				elseif(!is_numeric($rate_to)) { echo error("Please enter rate to with numbers."); }
				else {
					$update = $db->query("UPDATE bit_rates SET rate_from='$rate_from',rate_to='$rate_to' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM bit_rates WHERE id='$id'");
					$row = $query->fetch_assoc();
					echo success("Your changes was saved successfully.");
				}
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
					<label>Gateway from</label>
					<select class="form-control" name="gateway_from" disabled>
						<?php
						$list = $db->query("SELECT * FROM bit_gateways WHERE allow_send='1' and status='1' ORDER BY id");
						if($list->num_rows>0) {
							while($l = $list->fetch_assoc()) {
								if($row['gateway_from'] == $l['id']) { $sel = 'selected'; } else { $sel = ''; }
								echo '<option value="'.$l[id].'" '.$sel.'>'.$l[name].' '.$l[currency].'</option>';
							}
						} else {
							echo '<option>No have gateways.</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Gateway to</label>
					<select class="form-control" name="gateway_to" disabled>
						<?php
						$list = $db->query("SELECT * FROM bit_gateways WHERE allow_receive='1' and status='1' ORDER BY id");
						if($list->num_rows>0) {
							while($l = $list->fetch_assoc()) {
								if($row['gateway_to'] == $l['id']) { $sel = 'selected'; } else { $sel = ''; } 
								echo '<option value="'.$l[id].'" '.$sel.'>'.$l[name].' '.$l[currency].'</option>';
							}
						} else {
							echo '<option>No have gateways.</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Rate from</span>
						<input type="text" class="form-control" name="rate_from" value="<?php echo $row['rate_from']; ?>" placeholder="1" aria-describedby="basic-addon1">
						<span class="input-group-addon" id="basic-addon1">=&nbsp;&nbsp; Rate to</span>
						<input type="text" class="form-control" name="rate_to" value="<?php echo $row['rate_to']; ?>" placeholder="0.95" aria-describedby="basic-addon1">
					</div>
				</div>
				<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
			</form>
		</div>
	</div>
	<?php
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_rates WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=rates"); }
	$row = $query->fetch_assoc();
	$rate_from = $row['rate_from'];
	$rate_to =$row['rate_to'];
	$currency_from = gatewayinfo($row['gateway_from'],"currency");
	$currency_to = gatewayinfo($row['gateway_to'],"currency");
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=rates">Rates</a></li>
		<li class="active">Delete rate</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Delete rate
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM bit_rates WHERE id='$row[id]'");
				echo success("Exchange rate <b>$rate_from $currency_from = $rate_to $currency_to</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete exchange rate <b>$rate_from $currency_from = $rate_to $currency_to</b>?");
				echo '<a href="./?a=rates&b=delete&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=rates" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./">Administrator</a></li>
	<li class="active">Rates</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Rates
		<span class="pull-right">
			<a href="./?a=rates&b=add"><i class="fa fa-plus"></i> Add rate</a>
		</span>
	</div>
	<div class="panel-body">
		<?php
		echo info("NOTE! Script used Google Currency Convertor API to take real exchange rate of all international currencies, so you only enter your fee in the gateuey and do not have to constantly update the exchange rate. Also take and the market value of 1 Bitcoin from BTC-e.com which can also put your fee percentage that each time is calculated from the real value of bitcoin. For other cryptocurrencies like Litecoin, Dogecoin, Dash, Peercoin, Ehterum and TheBillioncoin need to enter rates manually in this page.");
		?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="30%">Gateway from</th>
					<th width="30%">Gateway to</th>
					<th width="30%">Exchange rate</th>
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
				$statement = "bit_rates";
				$query = $db->query("SELECT * FROM {$statement} ORDER BY id LIMIT {$startpoint} , {$limit}");
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo gatewayinfo($row['gateway_from'],"name"); ?> <?php echo gatewayinfo($row['gateway_from'],"currency"); ?></td>
							<td><?php echo gatewayinfo($row['gateway_to'],"name"); ?> <?php echo gatewayinfo($row['gateway_to'],"currency"); ?></td>
							<td><?php echo $row['rate_from']; ?> <?php echo gatewayinfo($row['gateway_from'],"currency"); ?> = <?php echo $row['rate_to']; ?> <?php echo gatewayinfo($row['gateway_to'],"currency"); ?></td>
							<td>
								<a href="./?a=rates&b=edit&id=<?php echo $row['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a> 
								<a href="./?a=rates&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php
					}
				} else {
					echo '<tr><td colspan="4">Still no have rates. <a href="./?a=rates&b=add">Click here</a> to add.</td></tr>';
				}
				?>
			</tbody>
		</table>
		<?php
		$ver = "./?a=rates";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
</div>
<?php
}
?>