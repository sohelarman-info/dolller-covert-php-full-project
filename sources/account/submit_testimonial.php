<h3><?php echo $lang['submit_testimonial']; ?></h3>
<hr/>

<?php
if(isset($_POST['bit_submit'])) {
	$exchange_id = protect($_POST['exchange_id']);
	$content = protect($_POST['content']);
	$type = protect($_POST['type']);
	$time = time();
	if(empty($exchange_id)) { echo error($lang['error_7']); }
	elseif(empty($content)) { echo error($lang['error_8']); }
	else {
		$insert = $db->query("INSERT bit_testimonials (uid,exchange_id,status,type,time,content) VALUES ('$_SESSION[bit_uid]','$exchange_id','0','$type','$time','$content')");
		echo success($lang['success_5']);
	}
}
?>

<form action="" method="POST">
	<div class="form-group">
		<label><?php echo $lang['exchange']; ?></label>
		<select class="form-control input-lg form_style_1" name="exchange_id">
			<?php
			$query = $db->query("SELECT * FROM bit_exchanges WHERE uid='$_SESSION[bit_uid]' and status='4'");
			if($query->num_rows>0) {
				while($row = $query->fetch_assoc()) {
					$check = $db->query("SELECT * FROM bit_testimonials WHERE uid='$_SESSION[bit_uid]' and exchange_id='$row[id]'");
					if($check->num_rows==0) {
						echo '<option value="'.$row[id].'">'.$row[exchange_id].' - '.$lang[g_from].' '.gatewayinfo($row[gateway_send],"name").' '.gatewayinfo($row[gateway_send],"currency").' '.$lang[g_to].' '.gatewayinfo($row[gateway_receive],"name").' '.gatewayinfo($row[gateway_receive],"currency").' ('.$lang[amount].': '.$row[amount_send].' '.gatewayinfo($row[gateway_send],"currency").')</option>';
					}
				}
			} else {
				echo '<option>'.$lang[no_have_exchanges].'</option>';
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<label><?php echo $lang['type']; ?></label>
		<select class="form-control" name="type">
			<option value="1"><?php echo $lang['positive']; ?></option>
			<option value="2"><?php echo $lang['neutral']; ?></option>
			<option value="3"><?php echo $lang['negative']; ?></option>
		</select>
	</div>
	<div class="form-group">
		<label><?php echo $lang['feedback']; ?></label>
		<textarea class="form-control input-lg form_style_1" name="content" rows="3"></textarea>
	</div>
	<button type="submit" class="btn btn-primary" name="bit_submit"><i class="fa fa-plus"></i> <?php echo $lang['submit']; ?></button>
</form>
