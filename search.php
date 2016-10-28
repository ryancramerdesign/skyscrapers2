<?php namespace ProcessWire;

/**
 * This template looks for search terms as GET vars and formulates a selector to find matching skyscrapers
 *
 */
	
/** @var WireInput $input */
/** @var Sanitizer $sanitizer */

// most of the code in this template file is here to build this selector string
// it will contain the search query that gets sent to $skyscraperList
$selector = '';

// we use this to store the info that generates the summary of what was searched for
// the summary will appear above the search results
$summary = array(
	"city" => "", 
	"height" => "",
	"floors" => "", 
	"year" => "", 
	"keywords" => "", 
	);

// if a city is specified, then we limit the results to having that city as their parent
if($input->get('city')) {
	$cityName = $sanitizer->pageName($input->get('city'));
	$city = pages("/cities/$cityName/");
	if($city->id) {
		$selector .= "parent=$city, ";
		$summary['city'] = $city->title;
		$input->whitelist('city', $city->name); 
	}
}

// we are allowing these GET vars in the format of 999, 999-9999, or 999+
// so we're using this loop to parse them into a selector
foreach(array('height', 'floors', 'year') as $key) {

	if(!$value = $input->get($key)) continue; 
	
	// see if the value is given as a range (i.e. two numbers separated by a dash)
	if(strpos($value, '-') !== false) {
		list($min, $max) = explode('-', $value); 
		$min = (int) $min;	
		$max = (int) $max; 
		$selector .= "$key>=$min, $key<=$max, ";
		$summary[$key] = (substr($max, 0, 3) == '999') ? "$min and above" : "$min to $max";
		$input->whitelist($key, "$min-$max"); 

	// see if the value ends with a +, which we used to indicate 'greater than or equal to'
	} else if(substr($value, -1) == '+') { 
		$value = (int) $value; 
		$selector .= "$key>=$value, ";
		$summary[$key] = "$value and above";
		$input->whitelist($key, "$value+"); 

	// plain value that doesn't need further parsing
	} else {	
		$value = (int) $value; 
		$selector .= "$key=$value, ";
		$summary[$key] = $value;
		$input->whitelist($key, $value); 
	}
}

// if there are keywords, look in the title and body fields for the words
if($input->get('keywords')) {
	$value = $sanitizer->selectorValue($input->get('keywords'));
	$selector .= "title|body%=$value, "; 
	$summary["keywords"] = $sanitizer->entities($value); 
	$input->whitelist('keywords', $value); 
}

// execute the search
$skyscrapers = findSkyscrapers($selector);

// generate a summary alert that appears at the top of the page, and browser <title> tag
$browserTitle = 'Skyscraper Search - ';

foreach($summary as $key => $value) {
	if($value) {
		$key = ucfirst($key);
		$browserTitle .= ucfirst($key) . ": $value, ";
	} else {
		unset($summary[$key]);
	}
}

region('browserTitle', rtrim($browserTitle, ', '));
region('content',
	files()->render('./includes/search-summary.php', array('items' => $summary)) . 
	renderSkyscraperList($skyscrapers)
);


