<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="exchangesoftware.info">
   	<meta name="description" content="<?php echo $settings['description']; ?>">
	<meta name="keywords" content="<?php echo $settings['keywords']; ?>">
	<meta property="og:image" content="<?php echo $settings['url']; ?>assets/images/logo.png"/>

    <title><?php echo BitDecodeTitle($_GET['a']); ?></title>
    <link rel="icon" href="<?php echo $settings['url']; ?>assets/images/icon.png" type="image/gif" sizes="16x16">

   <!-- CSS --> 
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/bootstrap.min.css" >
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/font-awesome.min.css">
 
	<link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/icofont.css">
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/owl.carousel.css">  
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/slidr.css">     
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/main.css">  
	<link id="preset" rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/presets/preset2.css">	
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/responsive.css">
        <link href="<?php echo $settings['url']; ?>assets/css/style.css" rel="stylesheet">
		<?php if($lang['lang_type'] == "rtl") { ?>
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap-flipped.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" media="all" />
	<?php } ?>
	<!-- font -->
	<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500,700,300' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700' rel='stylesheet' type='text/css'>

	<script src="<?php echo $settings['url']; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo $settings['url']; ?>assets/js/BitExchanger.js"></script>

	


    
    <style>#header a.btn {
    position: unset !important;
    margin-left: unset !important;
    margin: 5px;
    padding: 10px;
}
        #header a.btn{position:unset !important; margin-left:unset !important;}
        .srzmenu {
    overflow-y: unset !important;}
    @media (min-width: 992px){
        .navbar-nav>li{
           margin: 3px !important;
       }#header a.btn { 
           margin: 0px !important;
        }
        .loginsrz{
    margin-left: 83px !important;}
    .spacesrz{display:unset !Important;}
    }
    @media (min-width: 768px){
        .navbar-nav>li{
           margin: 3px !important;
       } #header a.btn { 
           margin: 0px !important;
        }
        .loginsrz{
    margin-left: 83px !important;}
    .spacesrz{display:unset !Important;}
    }
    @media (min-width: 992px) and (max-width: 1199px){
    .spacesrz{display:unset !Important;}
        .loginsrz{
    margin-left: 83px !important;}
        #header a.btn { }
    }
    </style>
  </head>
  <body>
	<!-- header -->
	<header id="header" class="clearfix">
	    
	    <!-- navbar -->
		<nav class="navbar navbar-default">
			<div class="container">
				<!-- navbar-header -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo $settings['url']; ?>"><img class="img-responsive" src="<?php echo $settings['url']; ?>assets/images/logo.png" alt="Logo"></a>
				</div>
				<!-- /navbar-header -->
				
				<div class="navbar-left">
					<div class="collapse navbar-collapse srzmenu" id="navbar-collapse">
					    
						<ul class="nav navbar-nav ml-auto navbar-right"> 
        <li class="nav-item"><a href="/testimonials" class="btn btn-primary btn-block" style="background-image: linear-gradient(-158deg, #b3b300 10%, #262626 80%); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-star" aria-hidden="true"></i>&nbsp; Reviews</a>
        </li>
        <li class="nav-item"><a href="/page/news" class="btn btn-primary btn-block" style="background-image: linear-gradient(-158deg, #cc3300 10%, #262626 80%); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-newspaper"></i>&nbsp; News</a>
        </li>
        <li class="nav-item"><a href="<?php echo $settings['url']; ?>contact" class="btn btn-primary btn-block" style="background-image: linear-gradient(-158deg, #006699 10%, #262626 80%); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-phone"></i>&nbsp; <?php echo $lang['contact']; ?></a>
        </li>
        <li class="nav-item"><a href="/page/terms-of-services" class="btn btn-primary btn-block" style="background-image: linear-gradient(-158deg, #7575a3 10%, #262626 80%); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-briefcase"></i>&nbsp; Service</a>
        </li> 
        <li class="nav-item spacesrz" style="display: none;width: 34px !important;">
        </li>
        
        
        
        <?php if(checkSession()) { ?>
        <li class="nav-item loginsrz"><a href="<?php echo $settings['url']; ?>account/exchanges" class="btn btn-primary btn-block no-border" style="background-image: linear-gradient(rgba(0,100,0,0), #00803e); text-align: left; color: white; width: 100%; text-align:center;"> <i class="fa fa-lock"></i> <?php echo idinfo($_SESSION['bit_uid'],"username"); ?></a>
        </li>
        <li class="nav-item "><a class="btn btn-danger btn-block no-border" href="<?php echo $settings['url']; ?>logout">logout</a>
        <?php } else { ?>
        
        <li class="nav-item loginsrz"><a href="/login" class="btn btn-primary btn-block no-border" style="background-image: linear-gradient(rgba(0,100,0,0), #00803e); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-lock"></i> Login</a>
        </li>
        <li class="nav-item "><a class="btn btn-danger btn-block no-border" href="/register">Signup</a>
        </li>
        <?php } ?>
    
							<!---<li><a href="<?php echo $settings['url']; ?>"><?php echo $lang['exchange']; ?></a></li>
							<li><a href="<?php echo $settings['url']; ?>testimonials"><?php echo $lang['testimonials']; ?></a></li>
							<li><a href="<?php echo $settings['url']; ?>affiliate"><?php echo $lang['affiliate']; ?></a></li> 
							<li><a href="<?php echo $settings['url']; ?>contact"><?php echo $lang['contact']; ?></a></li>-->
						</ul>
					</div>
					
					
				</div>
				
				<!-- nav-right -->
				<div class="nav-right">
					<!-- language-dropdown -->

					<!-- sign-in -->					
				<?php /****	<ul class="sign-in">
						<li><i class="fa fa-user"></i></li>
						<?php if(checkSession()) { ?>
						<li><a href="<?php echo $settings['url']; ?>account/exchanges"><?php echo idinfo($_SESSION['bit_uid'],"username"); ?></a></li>
						<li><a href="<?php echo $settings['url']; ?>logout"><?php echo $lang['logout']; ?></a></li>
						<?php } else { ?>
						<li><a href="<?php echo $settings['url']; ?>login"><?php echo $lang['login']; ?></a></li>
						<li><a href="<?php echo $settings['url']; ?>register"><?php echo $lang['create_account']; ?></a></li>
						<?php } ?>
					</ul><!-- sign-in -->	
					
					<div style="margin-left:20px;" class="dropdown language-dropdown">
						<i class="fa fa-globe"></i> 						
						<a data-toggle="dropdown" href="#"><span class="change-text"><?php echo $_COOKIE['lang']; ?></span> <i class="fa fa-angle-down"></i></a>
						<ul class="dropdown-menu language-change">
							<?php echo getLanguage($settings['url'],null,1); ?>
						</ul>								
					</div><!-- language-dropdown -->	
					
					
					
					<div style="margin-left:20px;" class="opstatus">
						<?php if($settings['operator_status'] == "1") {
						        
                    			echo ($lang['operator']); echo (": <b class='online'>".$lang['operator_online']."</b>");
                    		} else {
                    			echo ($lang['operator']); echo (": <b class='offline'>".$lang['operator_offline']."</b>");
                    		}?>							
					</div><!-- Operator Status -->		<?php ***/?>			
				</div>
				<!-- nav-right -->
			</div><!-- container -->
		</nav><!-- navbar -->
		
		
		<?php /****** <!-- navbar -->
		<nav class="navbar navbar-default">
			<div class="container">
				<!-- navbar-header -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo $settings['url']; ?>">
					    <img class="img-responsive" src="<?php echo $settings['url']; ?>assets/images/logo.png" alt"Logo" height="72px"></a>
	
				</div>
				<!-- /navbar-header -->
				
				<div class="navbar-left">
					<div class="collapse navbar-collapse" id="navbar-collapse">
						<ul class="nav navbar-nav">
						    <div class="navbar-collapse [@UserMenuHide] collapse" style="">
                    <ul class="nav navbar-nav ml-auto navbar-right">
    <li><a href="/app/ipseWallet.apk" class="btn btn-primary btn-block" style="background-image: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(97,66,150,1) 0%, rgba(34,38,113,1) 100%); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-download"></i>&nbsp; Android App</a>
    </li>
        
        <li><a href="/reviews" class="btn btn-primary btn-block" style="background-image: linear-gradient(-158deg, #b3b300 10%, #262626 80%); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-star"></i>&nbsp; Reviews</a>
        </li>
        <li><a href="/news" class="btn btn-primary btn-block" style="background-image: linear-gradient(-158deg, #cc3300 10%, #262626 80%); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-newspaper"></i>&nbsp; News</a>
        </li>
        <li><a href="/contacts" class="btn btn-primary btn-block" style="background-image: linear-gradient(-158deg, #006699 10%, #262626 80%); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-phone"></i>&nbsp; Contacts</a>
        </li>
        <li><a href="/page/terms-of-services" class="btn btn-primary btn-block" style="background-image: linear-gradient(-158deg, #7575a3 10%, #262626 80%); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-briefcase"></i>&nbsp; Service</a>
        </li>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <li><a href="/login" class="btn btn-primary btn-block no-border" style="background-image: linear-gradient(rgba(0,100,0,0), #00803e); text-align: left; color: white; width: 100%; text-align:center;"><i class="fa fa-lock"></i> Login</a>
        </li>
        <li><a class="btn btn-danger btn-block no-border" style="height:36px;" href="/register">Signup</a>
        </li>
    </ul>
                                <!--/.nav-collapse -->
            </div>
     
     
						
						</ul>
					</div> 
				</div>
				
				<!-- nav-right -->
				<div class="nav-right">
					<!-- language-dropdown -->

					<!-- sign-in -->					
					<ul class="sign-in">
						<li><i class="fa fa-user"></i></li>
						<?php if(checkSession()) { ?>
						<li><a href="<?php echo $settings['url']; ?>account/exchanges"><?php echo idinfo($_SESSION['bit_uid'],"username"); ?></a></li>
						<li><a href="<?php echo $settings['url']; ?>logout"><?php echo $lang['logout']; ?></a></li>
						<?php } else { ?>
						<li><a href="<?php echo $settings['url']; ?>login"><?php echo $lang['login']; ?></a></li>
						<li><a href="<?php echo $settings['url']; ?>register"><?php echo $lang['create_account']; ?></a></li>
						<?php } ?>
					</ul><!-- sign-in -->	
					 	
				</div>
				<!-- nav-right -->
			</div><!-- container -->
		</nav><!-- navbar --><?php ***/ ?> 
	</header><!-- header -->
	
 <div style="padding: 4px 0;background: #17477E; color: #d9d9d9;">
    <div class="container">
           <div class="row">
          
            <li class="col-md-3 col-6"><span class="pull-left"><img src="/assets/images/clocks.png" height="19px"><?php echo $lang['work_time']; ?>: <?php echo $settings['worktime_from']; ?> - <?php echo $settings['worktime_to']; ?>
					</span></li>
         <li class="col-md-6 col-6 text-center hidden-xs"><img src="/assets/images/mobile.png" height="18px"> 01735846478
 
          <li class="col-md-3 col-6"><span class="pull-right"><?php if($settings['operator_status'] == "1") {
						        
                    			echo ($lang['operator']); echo (": <span class='badge badge-success'>".$lang['operator_online']."</span>");
                    		} else {
                    			echo ($lang['operator']); echo (": <span class='badge badge-danger'>".$lang['operator_offline']."</span>");
                    		}?>	<span style="font-size:17px"></span></span></li>

             
        </div> 
    </div>
</div>
