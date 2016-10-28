<?php namespace ProcessWire;

/***************************************************************************************
 * SHARED SKYSCRAPER FUNCTIONS
 *
 * The following functions find and render skyscrapers are are defined here so that
 * they can be used by multiple template files.
 *
 */

/**
 * Returns an array of valid skyscraper sort properties
 *
 * The keys for the array are the field names
 * The values for the array are the printable labels
 *
 * @return array
 *
 */
function getValidSorts() {
	return array(
		// field => label
		'-images.count' => 'Images (Most)',
		'images.count' => 'Images (Least)',
		'name' => 'Name (A-Z)',
		'-name' => 'Name (Z-A)',
		'parent.name' => 'City (A-Z)',
		'-parent.name' => 'City (Z-A)',
		'-height' => 'Height (Highest)',
		'height' => 'Height (Lowest)',
		'-floors' => 'Floors (Most)',
		'floors' => 'Floors (Least)',
		'-year' => 'Year (Newest)',
		'year' => 'Year (Oldest)',
	);
}

/**
 * Find Skyscraper pages using criteria from the given selector string.
 *
 * Serves as a front-end to $pages->find(), filling in some of the redundant
 * functionality used by multiple template files.
 *
 * @param string $selector
 * @return PageArray
 *
 */
function findSkyscrapers($selector) {

	$validSorts = getValidSorts();

	// check if there is a valid 'sort' var in the GET variables
	$sort = sanitizer('name', input()->get('sort'));

	// if no valid sort, then use 'title' as a default
	if(!$sort || !isset($validSorts[$sort])) $sort = 'name';

	// whitelist the sort value so that it is retained in pagination
	if($sort != 'name') input()->whitelist('sort', $sort);

	// expand on the provided selector to limit it to 10 sorted skyscrapers
	$selector = "template=skyscraper, limit=10, " . trim($selector, ", ");

	// check if there are any keyword searches in the selector by looking for the presence of 
	// ~= operator. if present, then omit the 'sort' param, since ProcessWire sorts by 
	// relevance when no sort specified.
	if(strpos($selector, "~=") === false) $selector .= ", sort=$sort";

	// now call upon ProcessWire to find the skyscrapers for us
	$skyscrapers = pages($selector);

	// save skyscrapers for possible display in a map
	mapSkyscrapers($skyscrapers);

	return $skyscrapers;
}

/**
 * Serves as a place to store and retrieve loaded skyscrapers that will be displayed in a google map.
 *
 * To add skyscrapers, pass in a PageArray of them.
 * To retrieve skyscreapers, pass in nothing and retrieve the returned value.
 *
 * @param null|PageArray $items Skyscraper pages to store
 * @return PageArray All Skyscraper pages stored so far
 *
 */
function mapSkyscrapers($items = null) {
	static $skyscrapers = null;
	if(is_null($skyscrapers)) $skyscrapers = new PageArray();
	if(!is_null($items) && $items instanceof PageArray) $skyscrapers->add($items);
	return $skyscrapers;
}

/**
 * Render the <thead> portion of a Skyscraper list table
 *
 * @return string
 *
 */
function renderSkyscraperListSort() {

	// query string that will be used to retain other GET variables in searches
	input()->whitelist->remove('sort');
	$queryString = input()->whitelist->queryString();
	if($queryString) $queryString = sanitizer('entities', "&$queryString");

	// get the 'sort' property, if it's present
	$sort = input()->get('sort');
	$validSorts = getValidSorts();
	
	// validate the 'sort' pulled from input
	if(!$sort || !isset($validSorts[$sort])) $sort = 'name';

	$options = array();
	$selectedLabel = '';

	// generate options
	foreach($validSorts as $key => $label) {
		if($key === $sort) $selectedLabel = $label;
		$options["./?sort=$key$queryString"] = $label;
	}

	// render output
	$out = files()->render('./includes/skyscraper-list-sort.php', array(
		'options' => $options, 
		'selectedLabel' => $selectedLabel
	));
	
	return $out;
}

/**
 * Render a list of skyscrapers
 *
 * @param PageArray $skyscrapers Skyscrapers to render
 * @param bool $showPagination Whether pagination links should be shown
 * @param string $headline
 * @return string The rendered markup
 *
 */
function renderSkyscraperList(PageArray $skyscrapers, $showPagination = true, $headline = '') {

	$pagination = '';
	$sortSelect = '';
	$items = array();
	
	if($showPagination && $skyscrapers->count()) {
		$headline = $skyscrapers->getPaginationString('Skyscrapers'); // i.e. Skyscrapers 1-10 of 500
		$pagination = renderPagination($skyscrapers); // pagination links
		$sortSelect = renderSkyscraperListSort();
	}

	foreach($skyscrapers as $skyscraper) {
		$items[] = renderSkyscraperListItem($skyscraper);
	}

	$selector = (string) $skyscrapers->getSelectors();
	if($selector) $selector = makePrettySelector($selector);
	
	$out = files()->render('./includes/skyscraper-list.php', array(
		'skyscrapers' => $skyscrapers, 
		'headline' => $headline, 
		'items' => $items, 
		'pagination' => $pagination, 
		'sortSelect' => $sortSelect, 
		'selector' => $selector
	));
		
	return $out;
}

/**
 * Render a single skyscraper for presentation in a skyscraper list
 *
 * @param Page $skyscraper The Skyscraper to render
 * @return string
 *
 */
function renderSkyscraperListItem(Page $skyscraper) {

	/** @var Pageimages $images */
	$images = $skyscraper->get('images');

	// make a thumbnail if the first skyscraper image
	if(count($images)) {
		// our thumbnail is 200px wide with proportional height
		$thumb = $images->first()->width(200);
		$img = $thumb->url;

	} else {
		// skyscraper has no images
		$img = config()->urls->templates . "styles/images/photo_placeholder.png";
	}

	// here's a fun trick, set what gets displayed when value isn't available.
	// the property "unknown" is just something we made up and are setting to the page.
	$skyscraper->set('unknown', '??');

	// send to our view file in includes/skyscraper-list-item.php
	$out = files()->render('./includes/skyscraper-list-item.php', array(
		'skyscraper' => $skyscraper,
		'url' => $skyscraper->url,
		'img' => $img, 
		'title' => $skyscraper->title, 
		'city' => $skyscraper->parent->get("title"),
		'height' => $skyscraper->get('height|unknown'),
		'floors' => $skyscraper->get('floors|unknown'),
		'year' => $skyscraper->get('year|unknown'),
		'summary' => summarizeText($skyscraper->get('body'), 500)
	));
	
	return $out;
}

/**
 * Render a Google Map using the MarkupGoogleMap module
 * 
 * @param PageArray|null $items
 * @param array $options See header of MarkupGoogleMap.module file for all options
 * @return string
 * 
 */
function renderMap($items = null, array $options = array()) {
	
	static $mapQty = 0;
	$defaults = array(
		'height' => '320px', 
		'useHoverBox' => true,
	);
	
	$options = array_merge($defaults, $options);
	
	if(is_null($items)) {
		if($mapQty) return ''; // if no items given and map has already been rendered, return blank
		$items = mapSkyscrapers(); // otherwise map skyscrapers already listed on the page
	}
	
	$map = page('map');
	$out = '';
	
	if(($map && $map->lat) || count($items)) {
		$mapQty++;
		$map = modules('MarkupGoogleMap');
		if(count($items)) {
			$out .= $map->render($items, 'map', $options);
		} else {
			$out .= $map->render(page(), 'map', $options);
		}
	}
	
	return $out;
}

/**
 * ProcessWire pagination nav for UIkit
 *
 * @param PageArray $items
 * @return string
 *
 */
function renderPagination(PageArray $items) {

	if(!$items->getLimit() || $items->getTotal() <= $items->getLimit()) return '';
	$page = page();
	if(!$page->template->allowPageNum) {
		return "Pagination is not enabled for this template";
	}

	// customize the MarkupPagerNav to output in Foundation-style pagination links
	$options = array(
		'numPageLinks' => 5, 
		'nextItemLabel' => '<i class="uk-icon-angle-double-right"></i>',
		'nextItemClass' => '',
		'previousItemLabel' => '<span><i class="uk-icon-angle-double-left"></i></span>',
		'previousItemClass' => '',
		'lastItemClass' => '',
		'currentItemClass' => 'uk-active',
		'separatorItemLabel' => '<span>&hellip;</span>',
		'separatorItemClass' => 'uk-disabled',
		'listMarkup' => "<ul class='uk-pagination uk-text-left'>{out}</ul>",
		'itemMarkup' => "<li class='{class}'>{out}</li>",
		'linkMarkup' => "<a href='{url}'>{out}</a>",
		'currentLinkMarkup' => "<span>{out}</span>"
	);

	$pager = modules('MarkupPagerNav');
	$pager->setBaseUrl($page->url);

	return $pager->render($items, $options);
}

/**
 * Make the selector better for display readability
 *
 * Since we're displaying the selector to screen for demonstration purposes, this method optimizes the
 * selector is the most readable fashion and removes any parts that aren't necessary
 *
 * This is not something you would bother with on a site that wasn't demonstrating a CMS. :)
 * 
 * @param string $selector
 * @return string
 *
 */
function makePrettySelector($selector) {
	if(preg_match('/(architects|parent)=(\d+)/', $selector, $matches)) {
		if($page = pages()->get($matches[2]))
			$selector = str_replace($matches[0], "$matches[1]={$page->path}", $selector);
		if($matches[1] == 'parent') $selector = str_replace("template=skyscraper, ", "", $selector); // template not necessary here
	}
	$selector = sanitizer('entities', $selector);
	$span = "<span class='uk-text-nowrap'>";
	$selector = $span . str_replace(", ", ",</span> $span ", $selector) . "</span>";
	return $selector;
}


/**
 * Generate a summary from the given block of text or HTML and truncate to last sentence
 *
 * @param string $text
 * @param int $maxLength
 * @return string
 *
 */
function summarizeText($text, $maxLength = 500) {

	if(!strlen($text)) return '';
	$summary = trim(strip_tags($text));
	if(strlen($summary) <= $maxLength) return $summary;

	$summary = substr($summary, 0, $maxLength);
	$lastPos = 0;

	foreach(array('. ', '!', '?') as $punct) {
		// truncate to last sentence
		$pos = strrpos($summary, $punct);
		if($pos > $lastPos) $lastPos = $pos;
	}

	if(!$lastPos) {
		// if no last sentence was found, truncate to last space
		$lastPos = strrpos($summary, ' ');
	}

	if($lastPos) {
		$summary = substr($summary, 0, $lastPos + 1); // and truncate to last sentence
	}

	return trim($summary);
}


