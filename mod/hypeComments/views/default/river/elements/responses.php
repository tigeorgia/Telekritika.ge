<?php
/**
 * River item footer
 *
 * @uses $vars['item'] ElggRiverItem
 * @uses $vars['responses'] Alternate override for this item
 */

if (!elgg_is_logged_in()) {
    return true;
}

// allow river views to override the response content
$responses = elgg_extract('responses', $vars, false);
if ($responses) {
	echo $responses;
	return true;
}

$item = $vars['item'];
$object = $item->getObjectEntity();

// annotations do not have comments
if ($item->annotation_id != 0 || !$object) {
	return true;
}


echo elgg_view('hj/comments/bar', array('entity' => $object));

