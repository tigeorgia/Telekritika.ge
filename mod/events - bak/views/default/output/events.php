<?php
/**
 * View events on an entity
 *
 * @uses $vars['entity']
 */

$linkstr = '';
if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {

	$events = $vars['entity']->universal_events;
	if (!empty($events)) {
		if (!is_array($events)) {
			$events = array($events);
		}
		foreach($events as $event) {
			$link = elgg_get_site_url() . 'events/list?event=' . urlencode($event);
			if (!empty($linkstr)) {
				$linkstr .= ', ';
			}
			$linkstr .= '<a href="'.$link.'">' . $event . '</a>';
		}
	}

}

if ($linkstr) {
	echo '<p class="elgg-output-events">' . elgg_echo('events') . ": $linkstr</p>";
}
