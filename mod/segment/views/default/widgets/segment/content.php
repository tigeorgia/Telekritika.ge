<?php
/**
 * User segment widget display view
 */

$num = $vars['entity']->num_display;

$options = array(
	'type' => 'object',
	'subtype' => 'segment',
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);

echo $content;

if ($content) {
	$segment_url = "segment/owner/" . elgg_get_page_owner_entity()->guid;
	$more_link = elgg_view('output/url', array(
		'href' => $segment_url,
		'text' => elgg_echo('segment:moresegments'),
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('segment:nosegments');
}
