<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Free Smart Store Website Template | Home :: w3layouts</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/NormalUser/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/NormalUser/menu.css" rel="stylesheet" type="text/css" media="all"/>
<script src="js/NormalUser/jquery.min.js"></script>
<script src="js/NormalUser/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/NormalUser/move-top.js"></script>
<script type="text/javascript" src="js/NormalUser/easing.js"></script>
<link href='//fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="wrap">
		<div class="header">
			<div class="header_top">
				<div class="logo">
                    <?php
                        echo $this->Html->image("NormalUser/logo.png", [
                            "alt" => "logo",
                            'url' => '/'
                        ]);

                    ?>

				</div>
				<div class="header_top_right">
					<div class="search_box">
						<form action='/search' method="get">
							<input name="keyword" type="text" value="Search for Products" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search for Products';}"><input type="submit" value="SEARCH">
						</form>
					</div>
					<div class="shopping_cart">
						<div class="cart">
							<a href="#" title="View my shopping cart" rel="nofollow">
								<strong class="opencart"> </strong>
								<span class="cart_title">Cart</span>
								<span class="no_product">(empty)</span>
							</a>
						</div>
					</div>
					<div class="languages" title="language">
						<div id="language" class="wrapper-dropdown" tabindex="1">EN
							<strong class="opencart"> </strong>
							<ul class="dropdown languges">
								<li>
									<a href="#" title="Français">
										<span><img src="img/NormalUser/gb.png" alt="en" width="26" height="26"></span><span class="lang">English</span>
									</a>
								</li>
								<li>
									<a href="#" title="Français">
										<span><img src="img/NormalUser/au.png" alt="fr" width="26" height="26"></span><span class="lang">Français</span>
									</a>
								</li>
								<li>
									<a href="#" title="Español">
										<span><img src="img/NormalUser/bm.png" alt="es" width="26" height="26"></span><span class="lang">Español</span>
									</a>
								</li>
								<li>
									<a href="#" title="Deutsch">
										<span><img src="img/NormalUser/ck.png" alt="de" width="26" height="26"></span><span class="lang">Deutsch</span>
									</a>
								</li>
								<li>
									<a href="#" title="Russian">
										<span><img src="img/NormalUser/cu.png" alt="ru" width="26" height="26"></span><span class="lang">Russian</span>
									</a>
								</li>
							</ul>
						</div>
						<script type="text/javascript">
							function DropDown(el) {
								this.dd = el;
								this.initEvents();
							}
							DropDown.prototype = {
								initEvents: function() {
									var obj = this;

									obj.dd.on('click', function(event) {
										$(this).toggleClass('active');
										event.stopPropagation();
									});
								}
							}

							$(function() {

								var dd = new DropDown($('#language'));

								$(document).click(function() {
									// all dropdowns
									$('.wrapper-dropdown').removeClass('active');
								});

							});
						</script>
					</div>
					<div class="currency" title="currency">
						<div id="currency" class="wrapper-dropdown" tabindex="1">$
							<strong class="opencart"> </strong>
							<ul class="dropdown">
								<li><a href="#"><span>$</span>Dollar</a></li>
								<li><a href="#"><span>€</span>Euro</a></li>
							</ul>
						</div>
						<script type="text/javascript">
							function DropDown(el) {
								this.dd = el;
								this.initEvents();
							}
							DropDown.prototype = {
								initEvents: function() {
									var obj = this;

									obj.dd.on('click', function(event) {
										$(this).toggleClass('active');
										event.stopPropagation();
									});
								}
							}

							$(function() {

								var dd = new DropDown($('#currency'));

								$(document).click(function() {
									// all dropdowns
									$('.wrapper-dropdown').removeClass('active');
								});

							});
						</script>
					</div>
					<div class="login">
						<span><a href="/login"><img src="img/NormalUser/login.png" alt="" title="login" /></a></span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="h_menu">
				<a id="touch-menu" class="mobile-menu" href="#">Menu</a>
				<nav>
					<ul class="menu list-unstyled">
						<li><a href="index.html">HOME</a></li>
						<?php foreach ($dataCategories as $Category) {?>
							<li><a href="/about"><?php echo $Category['category_name'] ?></a></li>
						<?php } ?>
						<li><a href="/about">About</a></li>
						<li><a href="/contact">CONTACT</a></li>
						<div class="clear"> </div>
					</ul>
				</nav>
				<script src="js/menu.js" type="text/javascript"></script>
			</div>
<?php
    $this->disableAutoLayout();

?>