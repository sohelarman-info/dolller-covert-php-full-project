<section id="main" class="clearfix home-default">
		<div class="container">
			
			<!-- main-content -->
			<div class="main-content">
				<!-- row -->
				<div class="row">
					<!-- product-list -->
					<div class="col-md-12">
						<!-- categorys -->
						<div class="section">
							<div class="row">
								<div class="col-md-12">

							<h3><?php echo $lang['track_exchange']; ?></h3>
							<hr/>
							<?php
							$order_id = protect($_POST['order_id']);
							$query = $db->query("SELECT * FROM bit_exchanges WHERE exchange_id='$order_id'");
							if($query->num_rows>0) {
								$redirect = $settings['url']."exchange/".$order_id;
								header("Location: $redirect");
							} else {
								echo error("$lang[no_found_results_for_exchange] <b>$order_id</b>.");
								?>
								<form action="<?php echo $settings['url']; ?>track" method="POST">
								<div class="form-group">
									<input type="text" class="form-control" name="order_id" placeholder="<?php echo $lang['type_here_exchange_id']; ?>">
								</div>
								<button type="submit" class="btn btn-primary" name="bit_track"><?php echo $lang['btn_track']; ?></button>
							</form>
								<?php
							}
							?>
						
								</div>
							</div>
						</div><!-- category-ad -->	
						
						
					</div><!-- product-list -->
				</div><!-- row -->
			</div><!-- main-content -->
		</div><!-- container -->
	</section><!-- main -->