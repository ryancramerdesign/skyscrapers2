<?php if($headline) echo "<h2>$headline</h2>"; ?>

<ul class='uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-margin-bottom'>
	<?php foreach($items as $item): ?>
	<li>
		<a href='<?=$item->url?>'><?=$item->title?></a> 
		<small class='uk-text-muted'><?=$item->numChildren?></small>
	</li>
	<?php endforeach; ?>
</ul>
