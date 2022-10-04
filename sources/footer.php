

<div style=" background-image: linear-gradient(rgba(0,100,0,0),  #149731); border-bottom-width: 3px; border-bottom-color: rgb(10,168,129); "><br>

              <div class="container">
                    <div class="row">
    
                 
    
                        <div class="col-md-2 col-xs-6">
                            <div class="footer-col">
                                <h4 class="footer-title">ABOUT US</h4>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="/page/terms-of-services">Terms of Services</a></li>
                                    <li><a href="/page/privacy-policy">Privacy Policy</a></li>
                                   
                                </ul>
                            </div>
                        </div>
    
                        <div class="col-md-2 col-xs-6">
                            <div class="footer-col">
                                <h4 class="footer-title">Help & Contact</h4>
                                <ul class="list-unstyled footer-nav">
                                     <li><a href="/page/about">About us</a></li>
                                   
                                    <li><a href="/contact">Contacts</a></li>
                                      <li><a href="/page/faq">FAQ</a></li>
                    
    
    
                                </ul>
                            </div>
                        </div>
                        
                          <div class="col-md-2 col-xs-6">
                            <div class="footer-col">
                               <div class="footer-col">
                                <h4 class="footer-title">More From Us</h4>
                                <ul class="list-unstyled footer-nav">
                                    
                                    <li><a href="/page/news">News</a></li>
                                    <li><a href="/sitemap">Site Map</a></li>
                                    <li><a href="/page/reviews">Customer Reviews</a></li>
                                    
                                </ul>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <div class="footer-col">
                                <h4 class="footer-title">Account</h4>
                                <ul class="list-unstyled footer-nav">
                                   
                                    <li><a href="/account/settings"> Manage Account
                                    </a></li>
                                 <?php if(checkSession()) { ?>
						<li><a href="<?php echo $settings['url']; ?>account/exchanges"><?php echo idinfo($_SESSION['bit_uid'],"username"); ?></a></li>
						<li><a href="<?php echo $settings['url']; ?>logout"><?php echo $lang['logout']; ?></a></li>
						<?php } else { ?>
						<li><a href="<?php echo $settings['url']; ?>login"><?php echo $lang['login']; ?></a></li>
						<li><a href="<?php echo $settings['url']; ?>register"><?php echo $lang['create_account']; ?></a></li>
						<?php } ?>
                                    <li><a href="account/exchanges"> My Exchanges
                                    </a></li>
                                    <li><a href="/account/settings"> Profile
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                        
                              
 
    
         
                        <div class="col-md-2 col-xs-6">
                            <div class="footer-col row">
    
    
                              
                                    <div class="hero-subscribe">
                                        <h4 class="footer-title no-margin">Follow us on</h4>
                                        <ul class="list-unstyled list-inline footer-nav social-list-footer social-list-color footer-nav-inline">
                                            <li><a class="icon-color fb" title="Facebook" data-placement="top" data-toggle="tooltip" href="/"><i class="fa fa-facebook"></i> </a></li>
                                            <li><a class="icon-color tw" title="Twitter" data-placement="top" data-toggle="tooltip" href="/"><i class="fa fa-twitter"></i> </a></li>
                                            <li><a class="icon-color gp" title="YouTube" data-placement="top" data-toggle="tooltip" href="h/"><i class="fa fa-youtube"></i> </a></li>
                                        <li><a class="icon-color pin" title="Linkedin" data-placement="top" data-toggle="tooltip" href="ht/"><i class="fa fa-pinterest-p"></i> </a></li>    
                                        </ul>
                                    
                                    </div>
    
   

                           
                            </div>
                        </div>
                              
                <a href="https://wa.me/+8801735846478">
<img src="/assets/images/whatsapps.png" class="img-circle " style="border: 4px solid #85adad; border-radius: 50px; margin: 0px 10px 10px 10px; bottom: 10px; right: 10px; position: fixed; width: 50px; height: 50px; cursor: pointer; z-index: 1; font-weight: bold;">
</a>
                       
     
                        <div style="clear: both"></div>
                            
                        <div class="copy-info text-center">
                              
                              <br>
                               <b>Copy &copy; 2020-2022 by <a href="/"><font color="white">UsdShops.Com</font></a>. All rights reserved.</b>
                            </div>
    
                   
    
   
                    </div>
                    
                    
                </div>
        
    
    </div>
    

	
<?php if(!checkSession()) { ?>
	<!-- login and register modals-->
		<div class="modal fade" id="login" tabindex="-1" role="dialog" >
				<div class="modal-dialog" role="document">
					<div class="modal-content modal-info">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>	
							<h4 class="modal-title"><?php echo $lang['login_with_your_account']; ?></h4>							
						</div>
						<div class="modal-body modal-spa">
							<div id="login_results"></div>
							<div id="bit_require_login" style="display:none;"><?php echo info($lang['info_3']); ?></div>
							<form id="login_form">
							<div class="form-group">
								<label><?php echo $lang['email_address']; ?></label>
								<input type="text" class="form-control input-lg form_style_1" name="email">
							</div>
							<div class="form-group">
								<label><?php echo $lang['password']; ?></label>
								<input type="password" class="form-control input-lg form_style_1" name="password">
								<a href="<?php echo $settings['url']; ?>password/reset"><?php echo $lang['forgot_password']; ?></a>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="checkbox">
										<label>
										  <input type="checkbox" name="remember_me" value="yes"> <?php echo $lang['remember_me']; ?>
										</label>
									  </div>
								</div>
								<div class="col-md-6">
									<button type="button" class="btn btn-danger pull-right btn-lg" onclick="bit_login();"><?php echo $lang['btn_login']; ?></button>
								</div>
							</div>
							</form>
						</div>
						<div class="modal-footer">
							<center>
									<p><?php echo $lang['with_entry']; ?> <a href="<?php echo $settings['url']; ?>page/terms-of-services"><?php echo $lang['terms_of_service']; ?></a> <?php echo $lang['and']; ?> <a href="<?php echo $settings['url']; ?>page/privacy-policy"><?php echo $lang['privacy_policy']; ?></a></p>
								</center>
							</div>
					</div>
				</div>
			</div>
<!-- //login -->
<!-- login -->
			<div class="modal fade" id="register" tabindex="-1" role="dialog" >
				<div class="modal-dialog" role="document">
					<div class="modal-content modal-info">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>	
							<h4 class="modal-title"><?php echo $lang['create_account_free']; ?></h4>							
						</div>
						<div class="modal-body modal-spa">
							<div id="register_results"></div>
							<form id="register_form">
							<div class="form-group">
								<label><?php echo $lang['username']; ?></label>
								<input type="text" class="form-control input-lg form_style_1" name="username">
							</div>
							<div class="form-group">
								<label><?php echo $lang['email_address']; ?></label>
								<input type="text" class="form-control input-lg form_style_1" name="email">
							</div>
							<div class="form-group">
								<label><?php echo $lang['password']; ?></label>
								<input type="password" class="form-control input-lg form_style_1" name="password">
							</div>
							<div class="form-group">
								<label><?php echo $lang['repassword']; ?></label>
								<input type="password" class="form-control input-lg form_style_1" name="repassword">
							</div>
							<div class="row">
								<div class="col-md-12">
									<button type="button" class="btn btn-danger pull-right btn-lg" onclick="bit_register();"><?php echo $lang['btn_register']; ?></button>
								</div>
							</div>
							</form>
						</div>
						<div class="modal-footer">
							<center>
								<p><?php echo $lang['with_registering']; ?> <a href="<?php echo $settings['url']; ?>page/terms-of-services"><?php echo $lang['terms_of_services']; ?></a> <?php echo $lang['and']; ?> <a href="<?php echo $settings['url']; ?>page/privacy-policy"><?php echo $lang['privacy_policy']; ?></a></p>
							</center>
						</div>
					</div>
				</div>
			</div>
			<!-- login and register modals-->
<?php } ?>
	
	<input type="hidden" id="url" value="<?php echo siteURL(); ?>">
    <!-- JS -->
    <script src="<?php echo $settings['url']; ?>assets/js/modernizr.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/smoothscroll.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/scrollup.min2.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/price-range.js"></script> 
    <script src="<?php echo $settings['url']; ?>assets/js/jquery.countdown.js"></script>    
    <script src="<?php echo $settings['url']; ?>assets/js/custom.js"></script>
  </body>
</html>