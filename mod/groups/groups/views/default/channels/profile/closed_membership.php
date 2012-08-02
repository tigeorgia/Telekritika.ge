<?php
/**
 * Display message about closed membership
 * 
 * @package ElggGroups
 */

?>
<p class="mtm">
<?php 
echo elgg_echo('channels:closedgroup');
if (elgg_is_logged_in()) {
	echo ' ' . elgg_echo('channels:closedgroup:request');
}
?>
</p>
