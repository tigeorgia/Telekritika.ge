<?php
/**
 * Elgg delete like action
 *
 */

$dislikes = elgg_get_annotations(array(
	'guid' => (int) get_input('guid'),
	'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
	'annotation_name' => 'dislikes',
));
if ($dislikes) {
	if ($dislikes[0]->canEdit()) {
        $clone = clone $dislikes[0];
        $dislikes[0]->delete();
        elgg_trigger_event('delete', 'annotation', $clone);
		system_message(elgg_echo("dislikes:deleted"));
		forward(REFERER);
	}
}

$dislikes = elgg_get_annotations(array(
    'guid' => (int) get_input('guid'),
    'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
    'annotation_name' => 'dislikes',
));
if ($dislikes) {
    register_error(elgg_echo("dislikes:notdeleted"));
    forward(REFERER);
}