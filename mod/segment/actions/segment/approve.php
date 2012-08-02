<?php
/**
 * Save segment entity
 *
 * @package Segment
 */

admin_gatekeeper();


$guid = get_input('guid');
if ($guid) {
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'segment') && $entity->canEdit()) {
		$segment = $entity;
	} else {
		register_error(elgg_echo('segment:error:post_not_found'));
		forward(REFERER);
	}
}

if($segment->status == "published"){
    register_error(elgg_echo("segment:alreadyapproved"));    
    forward(REFERER);
}else{
    $segment->status = "published";
    system_message(elgg_echo("segment:approved"));    
    forward(REFERER);    
}