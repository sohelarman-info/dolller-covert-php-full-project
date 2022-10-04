<!DOCTYPE html>
<html>
<head>
	<title><?php echo $settings['title']; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $settings['description']; ?>" />
	<meta name="keywords" content="<?php echo $settings['keywords']; ?>" />
	<link rel="shortcut icon" href="<?php echo $settings['url']; ?>assets/imgs/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $settings['url']; ?>assets/imgs/favicon.ico" type="image/x-icon">
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap.cosmo.min.css" rel="stylesheet" type="text/css" media="all" />
	<?php if($lang['lang_type'] == "rtl") { ?>
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap-flipped.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" media="all" />
	<?php } ?>
	<link href="<?php echo $settings['url']; ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo $settings['url']; ?>assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/functions.js"></script>
</head>
<body>

	<nav class="navbar navbar-default navbar-static-top ex_navbar">
      <div class="container ex_container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <?php if($settings['skype']) { ?><li><a href="<?php echo $settings['url']; ?>contact"><i class="fa fa-skype fa-1x"></i> <?php echo $settings['skype']; ?></a></li><?php } ?>
            <?php if($settings['whatsapp']) { ?><li><a href="<?php echo $settings['url']; ?>contact"><i class="fa fa-whatsapp fa-1x"></i> <?php echo $settings['whatsapp']; ?></a></li><?php } ?>
            <?php if($settings['supportemail']) { ?><li><a href="<?php echo $settings['url']; ?>contact"><i class="fa fa-at fa-1x"></i> <?php echo $settings['supportemail']; ?></a></li><?php } ?>
		  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<?php if(checkSession()) { ?>
			<li><a href="<?php echo $settings['url']; ?>account/exchanges"><i class="fa fa-user"></i> <?php echo idinfo($_SESSION['bit_uid'],"username"); ?></a></li>
			<lI><a href="<?php echo $settings['url']; ?>logout"><i class="fa fa-power-off"></i></a></li>
			<?php } else { ?>
            <li><a href="#" data-toggle="modal" data-target="#login"><?php echo $lang['login']; ?></a></li>
			<li><a href="#" data-toggle="modal" data-target="#register"><?php echo $lang['create_account']; ?></a></li>
			<?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
	<div class="ex_header">
		<div class="container ex_container">
			<div class="row">
				<div class="col-md-3">
					<a href="<?php echo $settings['url']; ?>"><div class="ex_logo"></div></a>
				</div>
				<div class="col-md-9">
					<ul class="nav nav-pills pull-right">
					  <li><a href="<?php echo $settings['url']; ?>"><?php echo $lang['exchange']; ?></a></li>
					  <li><a href="<?php echo $settings['url']; ?>testimonials"><?php echo $lang['testimonials']; ?></a></li>
					  <li><a href="<?php echo $settings['url']; ?>affiliate"><?php echo $lang['affiliate']; ?></a></li>
					  <li><a href="<?php echo $settings['url']; ?>page/about"><?php echo $lang['about']; ?></a></li>
					  <li><a href="<?php echo $settings['url']; ?>contact"><?php echo $lang['contact']; ?></a></li>
					</ul>
					<span class="pull-right text text-muted" style="margin-top:15px;margin-right:15px;">
						<i class="fa fa-clock-o fa-1x"></i> <?php echo $lang['work_time']; ?>: <?php echo $settings['worktime_from']; ?>-<?php echo $settings['worktime_to']; ?>, <?php echo $settings['worktime_gmt']; ?>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-user-secret fa-1x"></i> <?php echo $lang['operator']; ?>: <?php if($settings['operator_status'] == "1") { echo '<span class="text text-success">'.$lang[operator_online].'</span>'; } else { echo '<span class="text text-danger">'.$lang[operator_offline].'</span>'; } ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	