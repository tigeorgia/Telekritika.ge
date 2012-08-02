<?php
/**
 * Elgg delete like action
 *
 */

$likes = elgg_get_annotations(array(
	'guid' => (int) get_input('guid'),
	'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
	'annotation_name' => 'likes',
));
if ($likes) {
	if ($likes[0]->canEdit()) {
        $clone = clone $likes[0];
        $likes[0]->delete();
        elgg_trigger_event('delete', 'annotation', $clone);
		system_message(elgg_echo("likes:deleted"));
		forward(REFERER);
	}
}

$likes = elgg_get_annotations(array(
    'guid' => (int) get_input('guid'),
    'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
    'annotation_name' => 'likes',
));
if ($likes) {
    register_error(elgg_echo("likes:notdeleted"));
    forward(REFERER);
}