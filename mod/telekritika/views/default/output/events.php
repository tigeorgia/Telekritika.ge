<?php
/**
 * Elgg events
 * events can be a single string (for one tag) or an array of strings
 *
 * @uses $vars['value']   Array of events or a string
 * @uses $vars['type']    The entity type, optional
 * @uses $vars['subtype'] The entity subtype, optional
 * @uses $vars['entity']  Optional. Entity whose events are being displayed (metadata ->events)
 */

if (isset($vars['entity'])) {
	$vars['events'] = $vars['entity']->events;
	unset($vars['entity']);
}

if (!empty($vars['subtype'])) {
	$subtype = "&subtype=" . urlencode($vars['subtype']);
} else {
	$subtype = "";
}
if (!empty($vars['object'])) {
	$object = "&object=" . urlencode($vars['object']);
} else {
	$object = "";
}

if (empty($vars['events']) && !empty($vars['value'])) {
	$vars['events'] = $vars['value'];
}

if (empty($vars['events']) && isset($vars['entity'])) {
	$vars['events'] = $vars['entity']->events;
}

if (!empty($vars['events'])) {
	if (!is_array($vars['events'])) {
		$vars['events'] = array($vars['events']);
	}

	echo '<div class="elgg-events">';
	echo elgg_echo('events')." ";
	//echo '<ul >';
	foreach($vars['events'] as $tag) {
		if (!empty($vars['type'])) {
			$type = "&type={$vars['type']}";
		} else {
			$type = "";
		}
		$url = elgg_get_site_url() . 'search?q=' . urlencode($tag) . "&search_type=events{$type}{$subtype}{$object}";
		if (is_string($tag)) {
			//echo '<li>';
			echo elgg_view('output/url', array('href' => $url, 'text' => $tag, 'rel' => 'tag'))." ";
		//	echo '</li>';
		}
	}
	//echo '</ul>';
	echo '</div>';
}
