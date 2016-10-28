<div class='uk-grid uk-grid-medium'>
	
	<div class='skyscraper-images uk-width-medium-1-3 uk-text-center'>
		<?php include('./skyscraper-page-images.php'); ?>
	</div>
	
	<div class='uk-width-medium-2-3'>
		
		<?php include('./skyscraper-page-table.php'); ?>
		
		<h2>About <?=$page->title?></h2>
		<?=$page->body?>

		<?php if($page->get('wikipedia_id')): ?>
			<p>
				<a target='_blank' href='http://en.wikipedia.org/wiki/index.html?curid=<?=$page->wikipedia_id?>'>
					Read More at Wikipedia
				</a>
			</p>
		<?php endif; ?>

		<h2>See Also</h2>

		<ul class='uk-list uk-list-line uk-margin-bottom'>
			<?php foreach($related as $item): ?>
				<li>
					<a href='<?=$item->url?>'>
						<?=$item->title?>, 
						<?=$item->parent->title?>
					</a>
				</li>
			<?php endforeach; ?>	
			
			<?php foreach($page->architects as $item): ?>
				<li><a href='<?=$item->url?>'>Skyscrapers by <?=$item->title?></a></li>
			<?php endforeach; ?>
			
			<li><a href='../'><?=$page->parent->title?> Skyscrapers</a></li>
		</ul>	
	</div>	
</div>
