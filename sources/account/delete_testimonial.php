<h3><?php echo $lang['delete_testimonial']; ?></h3>
<hr/>

<?php
$id = protect($_GET['id']);
$query = $db->query("SELECT * FROM bit_testimonials WHERE id='$id' and uid='$_SESSION[bit_uid]'");
if($query->num_rows>0) {
	$delete = $db->query("DELETE FROM bit_testimonials WHERE id='$id'");
	echo success($lang['success_3']);
} else {
	$redirect = $settings['url']."account/testimonials";
	header("Location:$redirect");
}
?>