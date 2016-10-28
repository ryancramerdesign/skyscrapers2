<?php namespace ProcessWire;

/**
 * Outputs list of all skyscrapers, regardless of city
 *
 */

region('content', renderSkyscraperList(findSkyscrapers('')));

