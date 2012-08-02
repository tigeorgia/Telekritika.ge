<?php
/**
 * Delete segment entity
 *
 * @package Segment
 */

$segment_guid = get_input('guid');
$segment = get_entity($segment_guid);

if (elgg_instanceof($segment, 'object', 'segment') && $segment->canEdit()) {
	$container = get_entity($segment->container_guid);
	if ($segment->delete()) {
		system_message(elgg_echo('segment:message:deleted_post'));
		if (elgg_instanceof($container, 'group')) {
			forward("segment/channel/$container->guid/all");
		} else {
			forward("segment/owner/$container->guid");
		}
	} else {
		register_error(elgg_echo('segment:error:cannot_delete_post'));
	}
} else {
	register_error(elgg_echo('segment:error:post_not_found'));
}

forward(REFERER);