<?php
/**
 * Group segment module
 */

$group = elgg_get_page_owner_entity();

//if ($group->segment_enable == "no") {
	return true;
//}

$all_link = elgg_view('output/url', array(
	'href' => "segment/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'segment',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('segment:none') . '</p>';
}

$new_link = (isMonitor())
    ? elgg_view('output/url', array(
    	'href' => "segment/add/$group->guid",
        'text' => elgg_echo('segment:write'),
    ))
    : elgg_view('output/url', array(
        'href' => "segment/add/$group->guid",
        'text' => elgg_echo('segment:write'),
    ));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('segment:channel'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));