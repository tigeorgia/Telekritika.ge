<?php

	global $CONFIG;

	$tab = $vars['tab'];
	
	$settingsselect = ''; 
	$statsselect = '';
	switch($tab) {
		case 'list':
			$list = 'class="selected"';
			break;
		case 'assign':
			$assign = 'class="selected"';
			break;
		case 'upload':
			$upload = 'class="selected"';
			break;
	}
	
?>
<div class="contentWrapper">
	<div id="elgg_horizontal_tabbed_nav">
		<ul>
			<li <?php echo $list; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/badges/admin.php?tab=list'; ?>"><?php echo elgg_echo('badges:list'); ?></a> | <a href="<?php echo $CONFIG->wwwroot . 'mod/badges/admin.php?tab=list'; ?>&showindividual=true"><?php echo elgg_echo('badges:list'); ?> individual</a></li>
			<li <?php echo $assign; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/badges/admin.php?tab=assign'; ?>"><?php echo elgg_echo('badges:assign'); ?></a></li>
			<li <?php echo $upload; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/badges/admin.php?tab=upload'; ?>"><?php echo elgg_echo('badges:upload'); ?></a></li>
		</ul>
	</div>
<?php
	switch($tab) {
		case 'list':
			echo elgg_view("badges/list");
			break;
		case 'assign':
			echo elgg_view("badges/assign");
			break;
		case 'upload':
			echo elgg_view("badges/upload");
			break;
	}
?>
</div>
