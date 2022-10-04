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
					<?php
					$prefix = protect($_GET['prefix']);
						$query = $db->query("SELECT * FROM bit_pages WHERE prefix='$prefix'");
						if($query->num_rows>0) {
							$row = $query->fetch_assoc();
							?>
							<h3><?php echo $row['title']; ?></h3>
							<hr/>
							<?php echo $row['content']; ?></h3>
							<?php
						} else {
							header("Location: $settings[url]");
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