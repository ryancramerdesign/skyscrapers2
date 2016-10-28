<?php namespace ProcessWire;

/**
 * Architect Template: Display the skyscrapers associated with an architect
 *
 */

$skyscrapers = findSkyscrapers("architects=" . page());

region('browserTitle+', ' Skyscrapers');
region('content+', renderSkyscraperList($skyscrapers)); 

