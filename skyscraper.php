<?php namespace ProcessWire;

/**
 * The Skyscraper template displays a single skyscraper with a table of stats, photos, description and map
 *
 */
	
/** @var Page $page */

// related skyscrapers are those that mention the same title in their body copy
$related = pages("template=skyscraper, id!=$page->id, body*=" . sanitizer()->selectorValue($page->title));

// populate regions
region('browserTitle', "$page->title, {$page->parent->title} Skyscraper");
region('sidebarHeader', renderMap()); 
region('content', files()->render('./includes/skyscraper-page.php', array(
	'page' => $page,
	'related' => $related
)));
