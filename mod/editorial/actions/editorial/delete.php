<?php
/**
 * Delete editorial entity
 *
 * @package Blog
 */

$editorial_guid = get_input('guid');
$editorial = get_entity($editorial_guid);

if (elgg_instanceof($editorial, 'object', 'editorial') && $editorial->canEdit()) {
	$container = get_entity($editorial->container_guid);
	if ($editorial->delete()) {
		system_message(elgg_echo('editorial:message:deleted_post'));
		if (elgg_instanceof($container, 'group')) {
			forward("editorial/group/$container->guid/all");
		} else {
			forward("editorial/owner/$container->username");
		}
	} else {
		register_error(elgg_echo('editorial:error:cannot_delete_post'));
	}
} else {
	register_error(elgg_echo('editorial:error:post_not_found'));
}

forward(REFERER);