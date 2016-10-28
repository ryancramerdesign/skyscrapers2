<?php if(count($items)): ?>
	<div class='uk-alert'>
		Search Summary 
		<?php foreach($items as $key => $value):
			if(!$value) continue; ?>
			<i class='uk-icon-arrow-right'></i> 
			<strong class='uk-text-capitalize'><?=$key?></strong> <?=$value?> &nbsp; 
		<?php endforeach; ?>
	</div>
<?php endif; ?>
