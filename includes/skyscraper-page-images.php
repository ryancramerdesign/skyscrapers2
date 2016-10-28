<?php namespace ProcessWire; 
/** @var Page $page */
if(count($page->get('images'))):
	foreach($page->get('images') as $image): 
		$thumb = $image->width(300); ?>
		<div class='skyscraper-image uk-margin-small'>
			<a href='<?=$image->url?>' data-uk-lightbox="{group:'photos'}">
				<img src='<?=$thumb->url?>' alt='$image->description'>
			</a>
			<?php if($image->description): ?>
				<div class='caption uk-text-small uk-text-muted'>
					<span><?=$image->description?></span>
				</div>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class='skyscraper-image uk-margin-small'>
		<img src='<?=urls()->templates?>styles/images/photo_placeholder.png' alt='' />
		<div class='caption uk-text-small uk-text-muted'>
			<span>Photo not available</span>
		</div>	
	</div>	
<?php endif; ?>

