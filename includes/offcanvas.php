<?php namespace ProcessWire; ?>
<div id="offcanvas" class="uk-offcanvas">
	<div class="uk-offcanvas-bar">
		<ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon uk-contrast uk-margin-bottom" data-uk-nav>
			<?php
			$home = pages('/');
			echo $home->and($home->children())->each("<li><a href='{url}'>{title}</a></li>");
			?>
		</ul>
		<p>&nbsp;</p>
	</div>
</div>
<a id='offcanvas-toggle' href='#offcanvas' class='uk-visible-small uk-navbar-toggle' data-uk-offcanvas></a>
