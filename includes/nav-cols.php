<?php namespace ProcessWire;
if(!isset($cols)) $cols = 2;
/** @var PageArray $items */
?>
<ul class='uk-grid uk-grid-width-medium-1-<?=$cols?>'>
	<?=$items->each("<li><a href='{url}'>{title}</a></li>")?>
</ul>
