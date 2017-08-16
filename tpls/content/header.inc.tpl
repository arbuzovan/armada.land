<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>%title%</title>
	<meta http-equiv="Cache-Control" content="max-age=86400, must-revalidate" />
	<meta name="description" content="%description%" />
	<meta name="keywords" content="%keywords%" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/js/bxslider/jquery.bxslider.css" />
	<link rel="stylesheet" type="text/css" href="/js/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" type="text/css" href="/js/owlcarousel/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css" />%users auth('account_css')%
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->	
</head>

<body>
%data getProperty('1', 'counter_google', 'clear')%
	<div id="wrap">

		<!-- header -->
		<div id="header">
			<div class="container-fluid">
				<div class="top-line">
					<div class="left">
						<div class="logo">
							<a href="http://armada.land"><img class="img-responsive" src="/images/template/logo.png" alt="ArmadaGroup" /></a>
						</div>
						<div class="menu">
							<div class="menu-inner">
								<div class="menu-slide-direction">Меню<span class="menu-slide-close pull-right"></span></div>
%content menu('main')%%users auth('account_menu_inside')%
								<div class="menu-slide-under">
									<span class="phone ya-phone">%data getProperty('1', 'phone', 'clear')%</span>
									<span class="button" data-target="#modal-ordercall" data-toggle="modal">Перезвоните мне</span>
								</div>
							</div>
						</div>
					</div>
					<div class="right">
						<span class="phone" data-target="#modal-ordercall"><i class="ya-phone">%data getProperty('1', 'phone', 'clear')%</i></span>
						<a class="button" href="#modal-ordercall" data-toggle="modal">Перезвоните мне</a>
						<span id="slide-menu-button"></span>
					</div>
				</div>
			</div>%users auth('account_menu')%
		</div>
		<!-- end header -->
			
		<!-- content -->
		<div id="content">