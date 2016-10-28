<?php namespace ProcessWire;
/** @var Page $page */

$url = config('urls')->root . "search/";
$height = $page->get('height');
$floors = $page->get('floors');
$year = $page->get('year');
$architects = $page->get('architect');

?>
<table class='uk-table skyscraper-info'>
	<tbody>
	
	<?php if($height): ?>
		<tr>
			<th>Height</th>
			<td><?php echo "<a href='$url?height=$height'>$height feet</a>"; ?></td>
		</tr>
	<?php endif; ?>
	
	<?php if($floors): ?>
		<tr>
			<th>Floors</th>
			<td><?php echo "<a href='$url?floors=$floors'>$floors</a>"; ?></td>
		</tr>
	<?php endif; ?>
	
	<?php if($year): ?>
		<tr>
			<th>Year</th>
			<td><?php echo "<a href='$url?year=$year'>$year</a>"; ?></td>
		</tr>
	<?php endif; ?>
	
	<?php if(count($architects)): ?>
		<tr>
			<th>Architects</th>
			<td>
				<ul class='uk-list uk-margin-remove'>
					<?php echo $architects->each("<li><a href='{url}'>{title}</a></li>"); ?>
				</ul>
			</td>
		</tr>
	<?php endif; ?>
	
	</tbody>
</table>
