<?php namespace ProcessWire;

/***************************************************************************************
 * This is the global init file included before all template files.
 *
 * Use of this is optional and set via $config->prependTemplateFile in /site/config.php.
 * We are using this init file to define shared functions and variables. 
 * See _main.php for the main markup file where everything is output.
 *
 */

include_once("./_func.php");  // shared functions

/***************************************************************************************
 * DEFINE REGIONS
 *
 * These are the regions we've decided template files may choose to populate.
 * and they are ultimately output by the _main.php file. 
 *
 */

region('browserTitle', page('title'));
region('headline', page('title'));
region('mainHeader', '');
region('content', page('body'));
region('sidebar', '');
region('sidebarHeader', '');

