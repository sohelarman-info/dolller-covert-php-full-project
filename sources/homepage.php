




<div><div style=" background-image: linear-gradient(90deg, rgba(5,156,70,1) 0%, rgba(20,157,84,1) 50%, rgba(0,158,90,1) 100%); border-bottom-color: rgb(10,168,129); ">
	<div class="container">
<br>

	
	
	
	
	<div class="row">
							
						
							<div class="col-md-12 page-content">
							    
                        <div class="btn btn" style="text-align: center; background-image: linear-gradient(-90deg,rgb(0, 128, 62) 20%,#3949AB 100%) !important; font-size: 16px; color: white; width: 100%; height:40px;"><strong><marquee behavior="scroll" direction="left"><font color="white"><b><font color="yellow">Notice:-</font> Document Verification ছাড়া প্রতিদিন সর্বোচ্চ ১০ হাজার টাকার ডলার Buy/Sell করতে পারবেন। যে কোন প্রয়োজনে কল করুন 01735-846478। ধন্যবাদ।</b></font> </marquee></strong></div>
							<div class="inner-box" style="background: linear-gradient(#00803e, #FFFFFF);">
								
								<h4 class="title-2"> <center><span class="pull-center" style="text-align: center; font-size: 14px; color: #060000; font-family: Roboto Condensed, Helvetica, Arial, sans-serif; font-weight: normal;">Exchange Instantly - 5 minutes To (30 minutes max) </span></center></h4>
								
								
								
								
							<div class="row" id="bit_exchange_box">
    					<div id="bit_exchange_results"></div>
    								<form id="bit_exchange_form">
    								<div class="col-md-6">
    									<div class="row">
    										<div class="col-md-3 hidden-xs hidden-sm">
    											<div style="margin-top:50px;">
    												<img src="assets/icons/Bitcoin.png" id="bit_image_send" width="72px" height="72px" class="img-circle img-bordered">
    											</div>
    										</div>
    										<div class="col-md-9">
    											<h3><i class="fa fa-arrow-down"></i> <?php echo $lang['send']; ?> </h3>
    											<div class="form-group">
    												<select class="form-control form_style_1 input-lg" id="bit_gateway_send" name="bit_gateway_send" onchange="bit_refresh('1');">
    													<?php
    													$gateways = $db->query("SELECT * FROM bit_gateways WHERE allow_send='1' and status='1' ORDER BY id");
    													if($gateways->num_rows>0) {
    														while($g = $gateways->fetch_assoc()) {
    															if($g['default_send'] == "1") { $sel = 'selected'; } else { $sel = ''; }
    															echo '<option value="'.$g[id].'" '.$sel.'>'.$g[name].' '.$g[currency].'</option>';
    														}
    													} else {
    														echo '<option>'.$lang[no_have_gateways].'</option>';
    													}
    													?>
    												</select>
    											</div>
    											<div class="form-group">
    												<input type="text" class="form-control form_style_1 input-lg" id="bit_amount_send" name="bit_amount_send" value="0" onkeyup="bit_calculator();" onkeydown="bit_calculator();">
    											</div>
    											<div class="text pull-right exchange_rate_text" style="padding-bottom:10px;font-weight:bold;"><?php echo $lang['exchange_rate']; ?>: <span id="bit_exchange_rate">-</span></div>
    										</div>
    									</div>
    								</div>
    								<div class="col-md-6">
    									<div class="row">
    										<div class="col-md-9">
    											<h3><i class="fa fa-arrow-up"></i> <?php echo $lang['receive']; ?></h3>
    											<div class="form-group">
    												<select class="form-control form_style_1 input-lg" id="bit_gateway_receive" name="bit_gateway_receive"  onchange="bit_refresh('2');">
    													<?php
    											$gateways = $db->query("SELECT * FROM bit_gateways WHERE allow_receive='1' and status='1' ORDER BY id");
    											if($gateways->num_rows>0) {
    												while($g = $gateways->fetch_assoc()) {
    													if($g['default_receive'] == "1") { $sel = 'selected'; } else { $sel = ''; }
    													echo '<option value="'.$g[id].'" '.$sel.'>'.$g[name].' '.$g[currency].'</option>';
    												}
    											} else {
    												echo '<option>'.$lang[no_have_gateways].'</option>';
    											}
    											?>
    												</select>
    											</div>
    											<div class="form-group">
    												<input type="text" class="form-control form_style_1 input-lg" id="bit_amount_receive" name="bit_amount_receive" disabled value="0">
    											</div>
    											<div class="text exchange_rate_text" style="padding-bottom:10px;font-weight:bold;"><?php echo $lang['reserve']; ?>: <span id="bit_reserve">-</span></div>
    										</div>
    										<div class="col-md-3 hidden-xs hidden-sm">
    											<div style="margin-top:50px;">
    												<img src="assets/icons/Skrill.png" id="bit_image_receive" width="72px" height="72px" class="img-circle img-bordered">
    											</div>
    										</div>
    									</div>
    								</div>
								<div class="col-md-12">
									<input type="hidden" name="bit_amount_receive" id="bit_amount_receive2">
									<input type="hidden" name="bit_rate_from" id="bit_rate_from">
									<input type="hidden" name="bit_rate_to" id="bit_rate_to">
									<input type="hidden" name="bit_currency_from" id="bit_currency_from">
									<input type="hidden" name="bit_currency_to" id="bit_currency_to">
									<input type="hidden" id="bit_login_to_exchange" name="bit_login_to_exchange" value="<?php echo $settings['login_to_exchange']; ?>">
									<input type="hidden" id="bit_ses_uid" name="bit_ses_uid" value="<?php if(checkSession()) { echo $_SESSION['bit_uid']; } else { echo '0'; } ?>">
									<center>
										<button type="button" class="btn btn-primary btn-lg"  onclick="bit_exchange_step_1();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i> <?php echo $lang['btn_exchange']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
									</center>
								</div>
							</form>			
						</div>

					
								
								
								
								
								
								
								
								
							</div>
						</div>
					</div><br>
    
    <div class="row">
    <div class="col-md-6 col-12">
    <div class="btn btn-danger btn-block no-border" style="background-image: linear-gradient(rgba(0,100,0,0), #00803e); text-align: left; color: white; width: 100%; text-align:center;"><strong><i class="fa fa-money"> </i> <?php echo $lang['sales_info']; ?></strong> </div>
    <div class="card-body" style="background: #ffffff">
    <div class="table-responsive" style="margin-top:0px">
             <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  text-align: left;
  padding: 5px 10px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
                <table>
  <tr>
    <th>Gateways</th>
    <th>Sell </th>
    <th>Buy </th>
  </tr>
  <tr style="font-size: 15px">
    <td><img src="https://usdshops.com/uploads/1640195299_icon.png" width="30px" height="30px" class="img-circle pull-left"> &nbsp;<b style="font-size: 12px; padding: 0px 5px 0px 5px">Bitcoin</b></td>
    <td><b>89</b> TK</td>
    <td><b>96</b> TK</td>
  </tr><tr style="font-size: 15px">
    <td><img src="https://usdshops.com/uploads/1641301552_icon.png" width="30px" height="30px" class="img-circle pull-left"> &nbsp;<b style="font-size: 12px; padding: 0px 5px 0px 5px">Tether (TRC20)</b></td>
    <td><b>89</b> TK</td>
    <td><b>94</b> TK</td>
  </tr><tr style="font-size: 15px">
    <td><img src="https://usdshops.com/assets/icons/Litecoin.png" width="30px" height="30px" class="img-circle pull-left"> &nbsp;<b style="font-size: 12px; padding: 0px 5px 0px 5px">Litecoin</b></td>
    <td><b>88</b> TK</td>
    <td><b>94</b> TK</td>
  </tr><tr style="font-size: 15px">
    <td><img src="https://www.ipsewallet.com/uploads/1650330717_icon.png" width="30px" height="30px" class="img-circle pull-left"> &nbsp;<b style="font-size: 12px; padding: 0px 5px 0px 5px">Ethereum</b></td>
    <td><b>86</b> TK</td>
    <td><b>94</b> TK</td>
  </tr><tr style="font-size: 15px">
    <td><img src="https://usdshops.com/assets/icons/PerfectMoney.png" width="30px" height="30px" class="img-circle pull-left"> &nbsp;<b style="font-size: 12px; padding: 0px 5px 0px 5px">Perfect Money</b></td>
    <td><b>87</b> TK</td>
    <td><b>92</b> TK</td>
  </tr><tr style="font-size: 15px">
    <td><img src="https://usdshops.com/uploads/1641302544_icon.png" width="30px" height="30px" class="img-circle pull-left"> &nbsp;<b style="font-size: 12px; padding: 0px 5px 0px 5px">TRX Tron</b></td>
    <td><b>88</b> TK</td>
    <td><b>94</b> TK</td>
  </tr><tr style="font-size: 15px">
    <td><img src="https://usdshops.com/uploads/1641302380_icon.png" width="30px" height="30px" class="img-circle pull-left"> &nbsp;<b style="font-size: 12px; padding: 0px 5px 0px 5px">Smartchain (BNB)</b></td>
    <td><b>88</b> TK</td>
    <td><b>94</b> TK</td>
  </tr><tr style="font-size: 15px">
    <td><img src="https://www.ipsewallet.com/uploads/1650333211_icon.png" width="30px" height="30px" class="img-circle pull-left"> &nbsp;<b style="font-size: 12px; padding: 0px 5px 0px 5px">Dogecoin</b></td>
    <td><b>87</b> TK</td>
    <td><b>94</b> TK</td>
  </tr><tr style="font-size: 15px">
    <td><img src="https://usdshops.com/uploads/1641302059_icon.png" width="30px" height="30px" class="img-circle pull-left"> &nbsp;<b style="font-size: 12px; padding: 0px 5px 0px 5px">BUSD</b></td>
    <td><b>88</b> TK</td>
    <td><b>94</b> TK</td>
  </tr>  
</table>
    </div>
    </div>
    <br></div>
    
    
    <div class="col-md-6 col-12">
    <div class="btn btn-danger btn-block no-border" style="background-image: linear-gradient(rgba(0,100,0,0), #00803e); text-align: left; color: white; width: 100%; text-align:center; marg"><strong> <i class=" fa fa-archive"></i> <?php echo $lang['our_reserve']; ?></strong></div>
        <style>
.exhover {
}

.exhover1:hover {
  background: linear-gradient(158deg, #343a40 44%, #dc3545 85%) no-repeat 0 0 #16A085;
  font-size:15px;
  color: #f2f2f2;
}
 
 .bgtheme1 {
   background: linear-gradient(158deg, #16A085 44%, #2ECC71 85%) no-repeat 0 0 #16A085; 
   padding: 5px; 
   margin-bottom: 2px
}
</style>


	<?php
								$query2 = $db->query("SELECT * FROM bit_gateways ORDER BY id");
								if($query2->num_rows>0) {
									while($row = $query2->fetch_assoc()) {
									?>
<div class="bgtheme1 exhover1">
<div style="margin-bottom:4px;"><img src="<?php echo gatewayicon($row['name']); ?>" width="30px" height="30px" class="img-circle pull-left">
<span style="margin-left: 10px; font-size: 16px; font-family: Arial;"><strong><?php echo $row['name']." ".$row['currency']; ?></strong></span>
<span class="pull-right"><b>
<span style="color: #e6e600; font-size: 18px; font-family: Arial"><?php echo $row['reserve']; ?></span><span style="color: #666666;"> <?php echo $row['currency']; ?></span></b></span></div>
</div>								<style>
.exhover {
}

.exhover1:hover {
  background: linear-gradient(158deg, #343a40 44%, #dc3545 85%) no-repeat 0 0 #16A085;
  font-size:15px;
  color: #f2f2f2;
}
 
 .bgtheme1 {
   background: linear-gradient(158deg, #16A085 44%, #2ECC71 85%) no-repeat 0 0 #16A085; 
   padding: 5px; 
   margin-bottom: 2px
}
</style><style>
.exhover {
}

.exhover1:hover {
  background: linear-gradient(158deg, #343a40 44%, #dc3545 85%) no-repeat 0 0 #16A085;
  font-size:15px;
  color: #f2f2f2;
}
 
 .bgtheme1 {
   background: linear-gradient(158deg, #16A085 44%, #2ECC71 85%) no-repeat 0 0 #16A085; 
   padding: 5px; 
   margin-bottom: 2px
}
</style>
 
 <?php
									}
								} else {
									?>
									<div class="">
										<?php echo $lang['no_have_gateways']; ?>
									</div>
									<?php
								}
								?>
 
    
   </div></div>
                <br>
                <div class="row">
      <div class="col-md-12">
    <div class="btn btn-danger btn-block no-border" style="background-image: linear-gradient(rgba(0,100,0,0), #00803e); text-align: left; color: white; width: 100%; text-align:center;"><strong><i class="fa fa-book"></i> User Reviews</strong>
                       <a href="/testimonials" class="badge badge-info pull-right" style="background-image: linear-gradient(rgba(0,100,0,0), #00803e); color: white;">
                        <i class="fa fa-star"></i> <span>Check All</span> </a></div>
			            <div class="row">
						<div class="col-md-12">
            <?php
							$query = $db->query("SELECT * FROM bit_testimonials WHERE status='1' ORDER BY RAND() LIMIT 20");
							if($query->num_rows>0) {
								while($row = $query->fetch_assoc()) {
								?>
								
								
                        <div class="inner-box"> 
        <h4><span class="text text-success"></span><?php echo $row['content']; ?></h4></div>
          <div style="background: linear-gradient(158deg, #16A085 44%, #cc0000 90%) no-repeat 0 0 #16A085; margin-top: -40px; margin-bottom:15px; font-weight: normal; height: 30px; color: #fff; line-height: 2.5; display: block; border-color: #d9534f;border-radius: 0px 0px 5px 5px; text-align: center;">
            <span class="pull-left" style="margin-left:5px"> <i class="fa fa-smile"></i> </span> <?php echo idinfo($row['uid'],"username"); ?> <span class="pull-right" style="margin-right:5px"><i class="fa fa-clock"></i><?php
                    										if($row['created']) {
                    										    date_default_timezone_set("Asia/Dhaka");
                    											echo date("d/m/Y",$row[created]);
                    											echo '<span> '.date("h: i: A",$row[created]).'</span>';
                    										} 
                    										?></span></div>
    
    
                       
                        <?php
									}
							} else {
								echo $lang['no_have_testimonials'];
							}
							?>
                </div></div> <br>
                    
    
    <div class="btn btn-danger btn-block no-border" style="background-image: linear-gradient(rgba(0,100,0,0), #00803e); text-align: left; color: white; width: 100%; text-align:center;"><strong><i class="fa fa-handshake-o"> </i> <?php echo $lang['completed_exchanges']; ?></strong></div>
    <div class="row">  
                    <br>
                    
                    	<?php
											$query = $db->query("SELECT * FROM bit_exchanges WHERE STATUS in(4) ORDER BY `bit_exchanges`.`id` DESC LIMIT 5"); 
											if($query->num_rows>0) {
												while($row = $query->fetch_assoc()) {
													?>
       <div class="col-md-6">
    <div class="inner-box">
                <center><img src="<?php echo gatewayicon(gatewayinfo($row['gateway_send'],"name")); ?>" class="img-circle cryptoexchanger-icon-reserve" width="40px" height="40px"> <span class="cryptoexchanger-exchange-text"><?php echo $row['amount_send']; ?> <?php echo gatewayinfo($row['gateway_send'],"currency"); ?></span>
                <span class="cryptoexchanger-padding"><i class="fa fa-exchange fa-1x"></i> </span>
                <img src="<?php echo gatewayicon(gatewayinfo($row['gateway_receive'],"name")); ?>" class="img-circle cryptoexchanger-icon-reserve" width="40px" height="40px"> <span class="cryptoexchanger-exchange-text"><?php echo $row['amount_receive']; ?> <?php echo gatewayinfo($row['gateway_receive'],"currency"); ?></span></center>
                </div><div style="background: linear-gradient(158deg, #16A085 44%, #2ECC71 85%) no-repeat 0 0 #16A085; margin-top: -40px; margin-bottom:15px; font-weight: normal; height: 30px; text-transform: uppercase;color: #fff; line-height: 2.5; display: block; border-color: #d9534f;border-radius: 0px 0px 5px 5px; text-align: center;">
           <span class="badge badge-success pull-right" style="border-radius: 0px 0px 0px 5px; font-weight: normal; height: 30px; line-height: 2.5;"><b> Completed </b></span><P align="left"><i class="fa fa-clock"></i> <?php
                    										if($row['created']) {
                    										    date_default_timezone_set("Asia/Dhaka");
                    											echo date("d/m/Y",$row[created]);
                    											echo '<span> '.date("h: i: A",$row[created]).'</span>';
                    										} else {
                    											echo '-';
                    										}
                    										?></p>
</div></div>
   				<?php
												}
											} else {
												echo '<tr><td colspan="5">'.$lang[still_no_exchanges].'</td></tr>';
											}
											?>
   		
   		<br><br></div>	

  </div>
 </div>
    </div></div>
    </div>
