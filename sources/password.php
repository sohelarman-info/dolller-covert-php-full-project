<!-- signin-page -->
	<section id="main" class="clearfix user-page">
		<div class="container">
			<div class="row text-center">
				<!-- user-login -->			
				<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
					<div class="user-account">
					<?php
					$b = protect($_GET['b']);
					if($b == "reset") {
						include("password/reset.php");
					} elseif($b == "change") {
						include("password/change.php");
					} else {
						header("Location: $settings[url]");
					}
					?>
</div><!-- user-login -->			
			</div><!-- row -->	
		</div><!-- container -->
	</section><!-- signin-page -->