<!DOCTYPE html>
<html>
	<head>
		<meta name="keywords" content="<?php echo $keywords;?>">
		<meta name="description" content="<?php echo $description;?>">
		<meta charset="utf-8" />
		
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo App::getBaseUrl();?>/favicon.ico" />
		
		<link href="<?php echo App::getBaseUrl();?>/assets/css/styles.css" rel="stylesheet" type="text/css" />
		
		<script type="text/javascript" src="<?php echo App::getBaseUrl();?>/assets/js/links.js"></script>
		<script type="text/javascript" src="<?php echo App::getBaseUrl();?>/assets/js/forms.js"></script>
		<script type="text/javascript" src="<?php echo App::getBaseUrl();?>/assets/js/load.js"></script>
		
		<title><?php echo $title;?></title>
	</head>
	<body>
	
	<header>
		<a href="<?php echo App::getBaseUrl();?>/" id="logo"><img src="<?php echo App::getBaseUrl();?>/assets/images/logoInformatiqueVert.jpg" alt="logo" /></a>
		<nav id="menu">
			<a href="<?php echo App::getBaseUrl();?>/">Accueil</a>
			<a href="<?php echo App::getBaseUrl();?>/Articles/index">Liste</a>
			<a href="<?php echo App::getBaseUrl();?>/basket">Panier</a>
		</nav>
	</header>
		
	<div id="page">
	
		<?php if($flashMessage != ""){?>
			<div class="flashMessage"><?php echo $flashMessage;?></div><?php
		}?>
		
		<div id="content">
			<?php echo $content;?>
		</div><!-- content -->
	
	</div><!-- page -->
	
	<footer>
		&copy; 2015 <a href="http://www.cpnv.ch">CPNV</a> - YSN - All Rights Reserved
	</footer>
	
	</body>
</html>