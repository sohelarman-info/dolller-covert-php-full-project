<h3><?php echo $lang['my_testimonials']; ?> <span class="pull-right"><a href="<?php echo $settings['url']; ?>account/submit_testimonial" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> <?php echo $lang['new']; ?></a></h3>
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
	$statement = "bit_testimonials WHERE uid='$_SESSION[bit_uid]' and status='1'";
	$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
	if($query->num_rows>0) {
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="40%"><?php echo $lang['feedback']; ?></th>
						<th width="40%"><?php echo $lang['exchange_id']; ?></th>
						<th width="10%"><?php echo $lang['action']; ?></th>
					</tr>
				</thead>
				<tbody>
			<?php
			while($row = $query->fetch_assoc()) {
				?>
				<tr>
					<td><?php echo $row['content']; ?></td>
					<td><a href="<?php echo $settings['url']; ?>account/exchange/<?php echo exchangeinfo($row['exchange_id'],"exchange_id"); ?>"><?php echo exchangeinfo($row['exchange_id'],"exchange_id"); ?></a></td>
					<td><a href="<?php echo $settings['url']; ?>account/delete_testimonial/<?php echo $row['id']; ?>"><i class="fa fa-times"></i> <?php echo $lang['delete']; ?></a></td>
				</tr>
				<?php
			}
			?>
				</tbody>
			</table>
			<?php
	} else {
		echo info("$lang[no_have_testimonials] <a href='$settings[url]account/submit_testimonial' style='color:#E3E3E3;'>$lang[button_1]</a> $lang[to_submit_testimonial].");
	}
	?>

<?php
$ver = $settings['url']."account/testimonials";
if(web_pagination($statement,$ver,$limit,$page)) {
	echo web_pagination($statement,$ver,$limit,$page);
}
?>