<?php
$b = protect($_GET['b']);

if($b == "approve") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_testimonials WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=testimonials"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Operator</a></li>
		<li><a href="./?a=testimonials">Testimonials</a></li>
		<li class="active">Approve testimonial</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Approve testimonial
		</div>
		<div class="panel-body">
			<?php
			$update = $db->query("UPDATE bit_testimonials SET status='1' WHERE id='$row[id]'");
			echo success("Testimonial was approved.");
			echo '<meta http-equiv="refresh" content="3; url=./?a=testimonials" />';
			?>
		</div>
	</div>
	<?php
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_testimonials WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=testimonials"); }
	$row = $query->fetch_assoc();
	$user = idinfo($row['uid'],"username");
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Operator</a></li>
		<li><a href="./?a=testimonials">Testimonials</a></li>
		<li class="active">Delete testimonial</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Delete testimonial
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM bit_testimonials WHERE id='$row[id]'");
				echo success("Testimonial was deleted.");
			} else {
				echo info("Are you sure you want to delete testimonial <b>$row[content]</b> from <b>$user</b>?");
				echo '<a href="./?a=testimonials&b=delete&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=testimonials" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./">BitExchanger Operator</a></li>
	<li class="active">Testimonials</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Testimonials
	</div>
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="50%">Feedback</th>
					<th width="15%">User</th>
					<th width="25%">Exchange ID</th>
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
				$statement = "bit_testimonials";
				$query = $db->query("SELECT * FROM {$statement} ORDER BY id LIMIT {$startpoint} , {$limit}");
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $row['content']; ?></td>
							<td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"username"); ?></a></td>
							<td><a href="./?a=exchanges&b=explore&id=<?php echo $row['exchange_id']; ?>"><?php echo exchangeinfo($row['exchange_id'],"exchange_id"); ?></a></td>
							<td>
								<?php if($row['status'] == "0") { ?><a href="./?a=testimonials&b=approve&id=<?php echo $row['id']; ?>" title="Approve"><i class="fa fa-check"></i></a><?php } ?> 
								<a href="./?a=testimonials&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
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