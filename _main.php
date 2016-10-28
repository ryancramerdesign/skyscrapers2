<?php namespace ProcessWire;

/*
 * Main output template for Skyscrapers site using Uikit
 *
 * Copyright 2016 by Ryan Cramer
 * 
 * The follow phpdoc doc declarations are just to keep IDE inspections happy, 
 * and they are not necessary to keep here. 
 */

/** @var Config $config */
/** @var Page $page */

$home = pages('/');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<title><?php 
		echo region('browserTitle');
		if(input()->pageNum() > 1) echo " (Page " . input()->pageNum() . ")";
	?></title>
	
	<script type='text/javascript' src='<?=modules('FieldtypeMapMarker')->getGoogleMapsURL();?>'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
	
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lato:400,400i,700' />
	<link rel='stylesheet' type='text/css' href='<?=urls('templates')?>uikit/css/uikit.gradient.min.css' />
	<link rel='stylesheet' type='text/css' href='<?=urls('templates')?>uikit/css/components/slidenav.gradient.min.css' />
	<link rel='stylesheet' type='text/css' href='<?=urls('templates')?>styles/skyscrapers.css' />
	
	<?php if(config('httpHost') == 'demo.processwire.com') include("./includes/google-analytics.php"); ?>
</head>

<body>
	<div id='masthead' class='uk-margin-large-top uk-margin-bottom'>
				
		<div id='primary-headline' class='uk-container uk-container-center uk-margin-bottom'>
			<h1>
				<?php
				$home->set('headline', 'Skyscrapers');
				echo $page->parents->each("<a href='{url}'>{headline|title}</a> <i class='uk-icon-angle-right'></i> ");
				echo region('headline');
				?>
			</h1>
		</div>
			
		<nav id='topnav' class='uk-navbar uk-navbar-attached uk-hidden-small'>
			<div class='uk-container uk-container-center'>
				<ul class='uk-navbar-nav'><?php 
					foreach($home->and($home->children) as $item) {
						$class = $item->id == $page->rootParent->id ? 'uk-active' : '';
						echo "<li class='$class'><a href='$item->url'>$item->title</a></li>";
					}
				?></ul>
				<div class='uk-navbar-flip'>
					<ul class='uk-navbar-nav'><?php 
						if(user()->isGuest()) {
							echo "<li><a href='{$config->urls->admin}login/'><i class='uk-icon-user'></i> Login</a></li>";
						} else {
							if(page()->editable()) echo "<li><a href='$page->editUrl'><i class='uk-icon-edit'></i> Edit</a></li>";
							echo "<li><a href='{$config->urls->admin}login/logout/'><i class='uk-icon-user'></i> Logout</a></li>";
						}
					?></ul>
				</div>
			</div>	
		</nav>
		
	</div><!--/masthead-->

	<div id='main'>
		<div class='uk-container uk-container-center'>
			<?php echo region('mainHeader'); ?>
			<div class='uk-grid uk-grid-medium'>
				<div id='content' class='uk-width-large-2-3 uk-margin-bottom'>
					<?php echo region('content'); ?>
				</div>
				<div id='sidebar' class='uk-width-large-1-3'>
					<?php
					echo region('sidebarHeader'); 
					include("./includes/search-form.php");
					echo renderMap();
					echo region('sidebar');
					include("./includes/sidebar-links.php");
					?>
				</div>	
			</div>
		</div>
	</div><!--/main-->

	<footer id='foot' class='uk-margin-large-top'>
		<div class='uk-container uk-container-center uk-margin-bottom'>
			<div class='uk-text-muted uk-text-center'>
				<span class='foot-text'>Powered by <a href='https://processwire.com'>ProcessWire Open Source CMS</a></span>
				<span class='foot-line uk-text-small'>Data and photos from Wikipedia and Freebase</span>
			</div>
		</div>
	</footer>
	
	<?php include("./includes/offcanvas.php"); ?>

	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
	<script src='<?=urls('templates')?>uikit/js/uikit.min.js'></script>
	<script src='<?=urls('templates')?>uikit/js/components/lightbox.min.js'></script>
	<script src='<?=urls('templates')?>scripts/skyscrapers.js'></script>

</body>
</html>
