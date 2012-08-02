<?php
/**
 * Events input view
 *
 * @package ElggEvents
 *
 * @uses $vars['entity'] The entity being edited or created
 */

if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
	$selected_events = $vars['entity']->universal_events;
}
$events = elgg_get_site_entity()->events;
if (empty($events)) {
	$events = array();
}
if (empty($selected_events)) {
	$selected_events = array();
}

if (!empty($events)) {
	if (!is_array($events)) {
		$events = array($events);
	}

	// checkboxes want Label => value, so in our case we need event => event
	$events = array_flip($events);
	array_walk($events, create_function('&$v, $k', '$v = $k;'));

	?>

<div class="events">
	<label><?php echo elgg_echo('events'); ?></label><br />
	<?php
		echo elgg_view('input/checkboxes', array(
			'options' => $events,
			'value' => $selected_events,
			'name' => 'universal_events_list',
			'align' => 'horizontal',
		));

	?>
	<input type="hidden" name="universal_event_marker" value="on" />
</div>

	<?php

} else {
	echo '<input type="hidden" name="universal_event_marker" value="on" />';
}
