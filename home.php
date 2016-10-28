<?php namespace ProcessWire;

$cities = pages('/cities/')->children();

region('headline', 'Skyscrapers in the United States');
region('browserTitle', 'United States Skyscrapers - A ProcessWire Demo Site');
region('sidebar', renderMap($cities));

// display a random photo from this page to display at the top
if($photo = page()->images->getRandom()) {
	region('mainHeader', files()->render('./includes/banner-photo.php', array(
		'photo' => $photo->maxWidth(1600),
		'caption' => sanitizer()->entitiesMarkdown($photo->description),
	)));
}

$skyscrapers = page()->skyscrapers->find("limit=3, sort=random");

region('content+',  	
	renderSkyscraperList($skyscrapers, false, 'Featured Skyscrapers') . 
	files()->render('./includes/cities-list.php', array(
		'items' => $cities,
		'headline' => 'Skyscrapers by City'
	))
);

