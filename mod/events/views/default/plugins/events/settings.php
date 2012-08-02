<?php
/**
 * Administrator sets the events for the site
 *
 * @package ElggEvents
 */

// Get site events
$site = elgg_get_site_entity();
$events = $site->events;

if (empty($events)) {
	$events = array();
}

?>
<div>
	<p><?php echo elgg_echo('events:explanation'); ?></p>
<?php
	echo elgg_view('input/tags', array('value' => $events, 'name' => 'events'));
?>
</div>