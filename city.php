<?php namespace ProcessWire;

/**
 * City Template: Display all the skyscrapers in a given city
 *
 * This just lists the current page's children, which are assumed to be skyscrapers
 *
 */

/** @var Page $page */

$skyscrapers = findSkyscrapers("parent=$page");
$map = $page->get('map');
$mapMarkup = renderMap($skyscrapers, array(
	'fitToMarkers' => false, 
	'lat' => $map->lat,
	'lng' => $map->lng
));

region('browserTitle', "Skyscrapers in $page->title");
region('content', renderSkyscraperList($skyscrapers));
region('sidebarHeader', $mapMarkup);
	

