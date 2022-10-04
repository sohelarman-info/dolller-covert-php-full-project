<?php
if(!checkSession()) { header("Location: $settings[url]"); }
$b = protect($_GET['b']);
?>
<!-- myads-page -->
	<section id="main" class="clearfix myads-page">
		<div class="container">
		
			<div class="ad-profile section">	
					<div class="user-profile">
						<div class="user">
							<h2>Hello, <a href="<?php echo $settings['url']; ?>account/exchanges"><?php echo idinfo($_SESSION['bit_uid'],"username"); ?></a></h2>
							<h5>You last logged in at: <?php echo date("d F Y H:i",idinfo($_SESSION['bit_uid'],"last_login")); ?></h5>
						</div>

						<div class="favorites-user">
							<div class="my-ads">
								<a href="<?php echo $settings['url']; ?>account/exchanges"><?php $nums = $db->query("SELECT * FROM bit_exchanges WHERE uid='$_SESSION[bit_uid]'"); echo $nums->num_rows; ?><small>Exchanges</small></a>
							</div>
						</div>								
					</div><!-- user-profile -->
							
					<ul class="user-menu">
						<li><a href="<?php echo $settings['url']; ?>account/exchanges"><i class="fa fa-refresh"></i> <?php echo $lang['my_exchanges']; ?></a></li>
							<li><a href="<?php echo $settings['url']; ?>account/testimonials"><i class="fa fa-comments-o"></i> <?php echo $lang['my_testimonials']; ?></a></li>
							<li><a href="<?php echo $settings['url']; ?>account/referrals"><i class="fa fa-users"></i> <?php echo $lang['referrals']; ?></a></li>
							<li><a href="<?php echo $settings['url']; ?>account/wallet"><i class="fa fa-money"></i> <?php echo $lang['wallet']; ?></a></li>
							<li><a href="<?php echo $settings['url']; ?>account/withdrawals"><i class="fa fa-download"></i> <?php echo $lang['withdrawals']; ?></a></li>
							<li><a href="<?php echo $settings['url']; ?>account/settings"><i class="fa fa-cogs"></i> <?php echo $lang['settings']; ?></a></li>
							<?php if(idinfo($_SESSION['bit_uid'],"status") == "1") { ?>
							<li><a href="<?php echo $settings['url']; ?>account/verification"><i class="fa fa-check"></i> <?php echo $lang['account_verification']; ?></a></li>
							<?php } ?>
					</ul>
			
			</div><!-- ad-profile -->			
			
			<div class="ads-info" style="display:block;">
				<div class="row">
					<div class="col-sm-12">
						<div class="my-ads section" style="display:block;">
						<?php
									if($b == "exchanges") {
										include("account/exchanges.php");
									} elseif($b == "exchange") {
										include("account/exchange.php");
									} elseif($b == "testimonials") {
										include("account/testimonials.php");
									} elseif($b == "submit_testimonial") {
										include("account/submit_testimonial.php");
									} elseif($b == "delete_testimonial") {
										include("account/delete_testimonial.php");
									} elseif($b == "verification") {
										include("account/verification.php");
									} elseif($b == "referrals") {
										include("account/referrals.php");
									} elseif($b == "wallet") {
										include("account/wallet.php");
									} elseif($b == "withdrawals") {
										include("account/withdrawals.php");
									} elseif($b == "withdrawal") {
										include("account/withdrawal.php");
									} elseif($b == "settings") {
										include("account/settings.php");
									} else {
										$redirect = $settings['url']."account/exchanges";
										header("Location: $redirect");
									}
									?>
									
						</div>
					</div><!-- my-ads -->

				</div><!-- row -->
			</div><!-- row -->
		</div><!-- container -->
	</section><!-- myads-page -->
	