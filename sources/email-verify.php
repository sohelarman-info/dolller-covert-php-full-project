<?php
$hash = protect($_GET['hash']);
$query = $db->query("SELECT * FROM bit_users WHERE email_hash='$hash'");
if($query->num_rows==0) { header("Location: $settings[url]"); }
$row = $query->fetch_assoc();
?>
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

							<h3><?php echo $lang['email_verification']; ?></h3>
							<hr/>
<?php
					$update = $db->query("UPDATE bit_users SET email_verified='1',email_hash='' WHERE id='$row[id]'");
					echo success($lang['success_2']);
					?>
				
								</div>
							</div>
						</div><!-- category-ad -->	
						
						
					</div><!-- product-list -->
				</div><!-- row -->
			</div><!-- main-content -->
		</div><!-- container -->
	</section><!-- main -->