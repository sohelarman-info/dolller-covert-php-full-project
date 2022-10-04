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

							<h3><?php echo $lang['testimonials']; ?></h3>
							<hr/>
<?php
					$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
					$limit = 15;
					$startpoint = ($page * $limit) - $limit;
					if($page == 1) {
						$i = 1;
					} else {
						$i = $page * $limit;
					}
					$statement = "bit_testimonials WHERE status='1'";
					$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
					if($query->num_rows>0) {
						while($row = $query->fetch_assoc()) {
						$gateway_send = exchangeinfo($row['exchange_id'],"gateway_send");
									$gateway_receive = exchangeinfo($row['exchange_id'],"gateway_receive");
									$exchange_from = gatewayinfo($gateway_send,"name").' '.gatewayinfo($gateway_send,"currency");
									$exchange_to = gatewayinfo($gateway_receive,"name").' '.gatewayinfo($gateway_receive,"currency");
						?>
							<div class="col-md-6">
										<div class="testimonials">
											<div class="active item">
											  <blockquote>
												<p><?php echo $row['content']; ?></p>
											  
											   <div class="carousel-info">
												<div class="pull-left">
												  <span class="testimonials-name"><?php echo idinfo($row['uid'],"username"); ?></span>
												  <span class="testimonials-post"><?php echo $lang['exchange_from']; ?> <?php echo $exchange_from; ?> <?php echo $lang['exchange_to']; ?> <?php echo $exchange_to; ?></span>
												</div>
											  </div>
											  </blockquote>
											 
											</div>
										</div>
									</div>
						<?php
						}
					} else {
						echo $lang['no_have_testimonials'];
					}
				$ver = $settings['url']."testimonials";
				if(web_pagination($statement,$ver,$limit,$page)) {
					echo web_pagination($statement,$ver,$limit,$page);
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