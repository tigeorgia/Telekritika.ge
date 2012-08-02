<?php
/**
 * Elgg add like action
 *
 */

$entity_guid = (int) get_input('guid');



//check to see if the user has already liked the item
if (elgg_annotation_exists($entity_guid, 'likes')) {
	register_error(elgg_echo("likes:alreadyliked"));
	forward(REFERER);
}
// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
	register_error(elgg_echo("likes:notfound"));
	forward(REFERER);
}

// limit like to prevent liking your own content 
if (elgg_get_logged_in_user_guid() == $entity->owner_guid) {
    // plugins should register the error message to explain why liking isn't allowed
    register_error(elgg_echo("likes:commentowner"));
    forward(REFERER);
}

// limit likes through a plugin hook (to prevent liking your own content for example)
if (!$entity->canAnnotate(0, 'likes')) {
	// plugins should register the error message to explain why liking isn't allowed
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();
$dislikes = elgg_get_annotations(array(
    'guid' => (int) get_input('guid'),
    'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
    'annotation_name' => 'dislikes',
));
if ($dislikes) {
    //flag to make sure we dont recalc controversy etc twice for create and delete of annotation
    global $haltCalculation;
    $haltCalculation = "halt";
}
$annotation = create_annotation($entity->guid,
								'likes',
								"likes",
								"",
								$user->guid,
								$entity->access_id);

// tell user annotation didn't work if that is the case
if (!$annotation) {
	register_error(elgg_echo("likes:failure"));
	forward(REFERER);
}else{
    //if it worked remove dislikes
    if ($dislikes) {
        $haltCalculation = false;
        if ($dislikes[0]->canEdit()) {
            $clone = clone $dislikes[0];
            $dislikes[0]->delete();
            elgg_trigger_event('delete', 'annotation', $clone);
            system_message(elgg_echo("dislikes:deleted"));
            forward(REFERER);
        }
    }
}

/* notify if poster wasn't owner
if ($entity->owner_guid != $user->guid) {

	likes_notify_user($entity->getOwnerEntity(), $user, $entity);
}*/

system_message(elgg_echo("likes:likes"));

// Forward back to the page where the user 'liked' the object
forward(REFERER);
