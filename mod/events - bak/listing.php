<?php
/**
 * List entities by event
 *
 * @package ElggEvents
 */

$limit = get_input("limit", 10);
$offset = get_input("offset", 0);
$event = get_input("event");
$owner_guid = get_input("owner_guid", ELGG_ENTITIES_ANY_VALUE);
$subtype = get_input("subtype", ELGG_ENTITIES_ANY_VALUE);
$type = get_input("type", 'object');

$params = array(
	'metadata_name' => 'universal_events',
	'metadata_value' => $event,
	'types' => $type,
	'subtypes' => $subtype,
	'owner_guid' => $owner_guid,
	'limit' => $limit,
	'full_view' => FALSE,
	'metadata_case_sensitive' => FALSE,
);
$objects = elgg_list_entities_from_metadata($params);

$title = elgg_echo('events:results', array($event));

$content = elgg_view_title($title);
$content .= $objects;

$body = elgg_view_layout('two_column_left_sidebar', '', $content);

echo elgg_view_page($title, $body);
