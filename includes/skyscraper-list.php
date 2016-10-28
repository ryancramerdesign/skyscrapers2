<?php if($headline): ?> 
	<h2><?=$headline?></h2>
<?php endif; ?>

<?php if($pagination): ?>
	<div class='uk-grid uk-margin-bottom pagination'>
		<div class='uk-width-medium-2-3'><?=$pagination?></div>	
		<div class='uk-width-medium-1-3'><?=$sortSelect?></div>
	</div>	
<?php endif; ?>

<?php if(count($items)): ?>
	<div class='skyscraper-list'>
		<?php foreach($items as $item): ?>
			<?=$item?>
		<?php endforeach; ?>
	</div>
	<?php if($selector): ?>
		<p class='uk-alert uk-margin-bottom'>
		The selector used to find the pages shown above is:<br />
		<span class='pw-selector'><?=$selector?></span>
	</p>
	<?php endif; ?>
<?php else: ?>
	<div class='uk-alert uk-alert-danger'>
		<i class='uk-icon-warning'></i> No skyscrapers found
	</div>
<?php endif; ?>

	