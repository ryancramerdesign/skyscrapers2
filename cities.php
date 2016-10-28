<?php namespace ProcessWire;

/**
 * Cities Template: lists skyscraper cities
 *
 */

$cities = page()->children;

region('content',  
	renderMap($cities, array('height' => '320px')) . 
	page()->body . 
	files()->render('./includes/cities-list.php', array('items' => $cities))
);

