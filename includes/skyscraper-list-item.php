<div class='skyscraper-list-item'>
	<div class='uk-grid uk-grid-medium'>
		<div class='uk-width-1-3 uk-width-small-1-5'>
			<a href='<?=$url?>'>
				<img src='<?=$img?>' alt='<?=$title?>' />
			</a>
		</div>
		<div class='uk-width-2-3 uk-width-small-4-5'>
			<div class='uk-grid uk-grid-small uk-margin-small-bottom'>
				<div class='uk-width-1-1 uk-width-small-2-5 uk-margin-small-bottom'>
					<a href='<?=$url?>' class='uk-text-bold'>
						<?=$title?>
					</a>
					<div class='skyscraper-city uk-text-muted'>
						<?=$city?>
					</div>
				</div>
				<div class='uk-width-1-3 uk-width-small-1-5'>
					<?=$height?><br />
					<small class='uk-text-muted'>feet</small>
				</div>
				<div class='uk-width-1-3 uk-width-small-1-5'>
					<?=$floors?><br />
					<small class='uk-text-muted'>floors</small>
				</div>
				<div class='uk-width-1-3 uk-width-small-1-5'>
					<?=$year?><br />
					<small class='uk-text-muted'>year built</small>
				</div>
			</div>
			<p><?=$summary?></p>
		</div>
	</div>	
</div>
