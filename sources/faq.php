	<section id="main" class="clearfix page">
		<div class="container">
			<div class="faq-page">
				<div class="accordion">
					<div class="panel-group" id="accordion">			
				
					<h2 class="title"><?php echo $lang['faq']; ?></h2>
				</div>

					<?php
					$query = $db->query("SELECT * FROM bit_faq ORDER BY id");
					if($query->num_rows>0) {
						while($row = $query->fetch_assoc()) {
							?>

							<div class="panel panel-default panel-faq">
							<div class="panel-heading">
								<a data-toggle="collapse" data-parent="#accordion" href="#faq-<?php echo $row['id']; ?>">
									<h4 class="panel-title">
									<?php echo $row['question']; ?>
									<span class="pull-right"><i class="fa fa-minus"></i></span>
									</h4>
								</a>
							</div><!-- panel-heading -->

							<div id="faq-<?php echo $row['id']; ?>" class="panel-collapse collapse collapse in">
								<div class="panel-body">
									<p><?php echo $row['answer']; ?></p>
								</div>
							</div>
						</div><!-- panel -->
							<?php
						}
					} else {
						echo $lang['error_4']; 
					}
					?>
			</div>
				</div>
				
			</div><!-- faq-page -->
		</div><!-- container -->
	</section>