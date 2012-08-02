<?php
/**
 * Default view for an entity returned in a search
 *
 * Display largely controlled by a set of overrideable volatile data:
 *   - search_icon (defaults to entity icon)
 *   - search_matched_title 
 *   - search_matched_description
 *   - search_matched_extra
 *   - search_url (defaults to entity->getURL())
 *   - search_time (defaults to entity->time_updated or entity->time_created)
 *
 * @uses $vars['entity'] Entity returned in a search
 */

$entity = $vars['entity'];

$icon = $entity->getVolatileData('search_icon');
if (!$icon && $entity instanceOf ElggCommentary) {
	// display the entity's owner by default if available.
	// @todo allow an option to switch to displaying the entity's icon instead.
	$type = $entity->getType();
	if ($type == 'user' || $type == 'group') {
		$icon = elgg_view_entity_icon($entity, 'tiny');
	} elseif ($owner = $entity->getOwnerEntity()) {
		$icon = elgg_view_entity_icon($owner, 'tiny');
	} else {
		// display a generic icon if no owner, though there will probably be
		// other problems if the owner can't be found.
		$icon = elgg_view_entity_icon($entity, 'tiny');
	}
}

$title = $entity->getVolatileData('search_matched_title');
$description = $entity->getVolatileData('search_matched_description');
$extra_info = $entity->getVolatileData('search_matched_extra');
$url = $entity->getVolatileData('search_url');

if (!$url) {
	$url = $entity->getURL();
}

if(($channel = get_entity($entity->container_guid)) instanceOf ElggChannel){
    $theicon = elgg_view_entity_icon($channel, "tiny", array("nourl" => true));    
}

$time = $entity->getVolatileData('search_time');
if (!$time) {
	$tc = $entity->time_created;
	$tu = $entity->time_updated;
	$time = elgg_view_friendly_time(($tu > $tc) ? $tu : $tc);
}

$body = "<a href=\"$url\">$theicon $title $description";
if ($extra_info) {
	$body .= "<p class=\"elgg-subtext\">$extra_info</p>";
}
$body .= "<p class=\"elgg-subtext\">$time</p></a>";

//echo elgg_view_image_block($icon, $body);
echo elgg_view_image_block($icon, $body);
