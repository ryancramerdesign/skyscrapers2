<div class='banner-photo uk-margin-bottom'>
	<img src='<?=$photo->url?>' alt='<?=$photo->description?>' />
	<?php if(!empty($caption)): ?>
		<small class='uk-text-muted'><?=$caption?></small>
	<?php endif; ?>
</div>