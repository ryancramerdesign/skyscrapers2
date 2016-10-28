<div id='skyscraper-search' class='uk-panel uk-panel-box xuk-panel-box-primary uk-margin-bottom'>
	
	<h3 class='uk-panel-title'><i class='uk-icon-building-o'></i> Skyscraper Search</h3>
	
	<form class='uk-form uk-form-stacked' method='get' action='<?php echo $config->urls->root?>search/'>

		<div class='uk-form-row'>
			<label class='uk-form-label' for='search_keywords'>Keywords</label>
			<div class='uk-form-controls'>
				<input type='text' class='uk-form-width-large' name='keywords' id='search_keywords' value='<?php 
					if($input->whitelist('keywords')) echo $sanitizer->entities($input->whitelist('keywords')); ?>' />
			</div>
		</div>

		<div class='uk-grid uk-grid-small uk-margin-top'>
			<div class='uk-width-1-2'>
				<div class='uk-form-row'>
					<label class='uk-form-label' for='search_city'>City</label>
					<div class='uk-form-controls'>
						<select id='search_city' name='city' class='uk-form-width-large'>
							<option value=''>Any</option><?php 
							// generate the city options, checking the whitelist to see if any are already selected
							foreach($pages->get("/cities/")->children() as $city) {
								$selected = $city->name == $input->whitelist->city ? " selected='selected' " : ''; 
								echo "<option$selected value='{$city->name}'>{$city->title}</option>"; 
							}
							?>
						</select>
					</div>	
				</div>
			</div>	
			<div class='uk-width-1-2'>
				<div class='uk-form-row'>
					<label class='uk-form-label' for='search_height'>Height</label>
					<div class='uk-form-controls'>
						<select id='search_height' name='height' class='uk-form-width-large'>
							<option value=''>Any</option><?php 
							// generate a range of heights, checking our whitelist to see if any are already selected
							foreach(array('0-250', '250-500', '500-750', '750-1000', '1000+') as $range) {
								$selected = $range == $input->whitelist->height ? " selected='selected'" : '';
								echo "<option$selected value='$range'>$range ft.</option>";
							}
							?>
						</select>
					</div>	
				</div>
			</div>	
		</div>	
		<div class='uk-grid uk-grid-small uk-margin-top'>
			<div class='uk-width-1-2'>
				<div class='uk-form-row'>
					<label class='uk-form-label' for='search_floors'>Floors</label>
					<div class='uk-form-controls'>
						<select id='search_floors' name='floors' class='uk-form-width-large'>
							<option value=''>Any</option><?php
							// generate our range of floors, checking to see if any are already selected
							foreach(array('1-20', '20-40', '40-60', '60-80', '80+') as $range) {
								$selected = $range == $input->whitelist->floors ? " selected='selected'" : '';
								echo "<option$selected value='$range'>$range floors</option>";
							}
							?>
						</select>
					</div>	
				</div>
			</div>	
			<div class='uk-width-1-2'>
				<div class='uk-form-row'>
					<label class='uk-form-label' for='search_year'>Year</label>
					<div class='uk-form-controls'>
						<select id='search_year' name='year' class='uk-form-width-large'>
							<option value=''>Any</option><?php
							// generate a range of years by decade, checking to see if any are selected
							for($year = 1850; $year <= 2010; $year += 10){
								$endYear = $year+9; 
								$range = "$year-$endYear";
								$selected = $input->whitelist->year == $range ? " selected='selected'" : '';
								echo "<option$selected value='$range'>{$year}s</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>		
		</div>	

		<div class='uk-margin-top'>
			<button type='submit' id='search_submit' class='uk-button uk-button-primary' name='submit' value='1'>
				<i class='uk-icon-search'></i>
				Search
			</button>
		</div>

	</form>
</div>

