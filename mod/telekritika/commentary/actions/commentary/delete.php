<?php
/**
 * Delete commentary entity
 *
 * @package Commentary
 */

$commentary_guid = get_input('guid');
$commentary = get_entity($commentary_guid);

if (elgg_instanceof($commentary, 'object', 'commentary') && $commentary->canEdit()) {
	$container = get_entity($commentary->container_guid);
	if ($commentary->delete()) {
		system_message(elgg_echo('commentary:message:deleted_post'));
		if (elgg_instanceof($container, 'group')) {
			forward("commentary/group/$container->guid/all");
		} else {
			forward("commentary/owner/$container->username");
		}
	} else {
		register_error(elgg_echo('commentary:error:cannot_delete_post'));
	}
} else {
	register_error(elgg_echo('commentary:error:post_not_found'));
}

forward(REFERER);