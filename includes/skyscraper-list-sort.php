<form method='get' class='uk-form sort-form'>
	<label for='skyscraper-sort-select' class='uk-text-muted'>
		Sort:
	</label>
	<select id='skyscraper-sort-select' class='sort-select'><?php 
		foreach($options as $value => $label) {
			$selected = $label == $selectedLabel ? ' selected' : '';
			echo "<option$selected value='$value'>$label</option>";
		}
	?></select>	
</form>
