<?php namespace ProcessWire;

region('content', files()->render('./includes/nav-cols.php', array(
	'items' => page()->children, 
	'cols' => 2
)));

