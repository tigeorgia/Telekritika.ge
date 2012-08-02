<?php
/**
 * Elgg add like action
 *
 */

$entity_guid = (int) get_input('guid');

//check to see if the user has already liked the item
if (elgg_annotation_exists($entity_guid, 'dislikes')) {
    register_error(elgg_echo("dislikes:alreadyliked"));
    forward(REFERER);
}
// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
    register_error(elgg_echo("dislikes:notfound"));
    forward(REFERER);
}

// limit like to prevent liking your own content 
if (elgg_get_logged_in_user_guid() == $entity->owner_guid) {
    // plugins should register the error message to explain why liking isn't allowed
    register_error(elgg_echo("likes:commentowner"));
    forward(REFERER);
}


// limit dislikes through a plugin hook (to prevent liking your own content for example)
if (!$entity->canAnnotate(0, 'dislikes')) {
    // plugins should register the error message to explain why liking isn't allowed
    forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();
$likes = elgg_get_annotations(array(
    'guid' => (int) get_input('guid'),
    'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
    'annotation_name' => 'likes',
));
if ($likes) {
    //flag to make sure we dont recalc controversy etc twice for create and delete of annotation
    global $haltCalculation;
    $haltCalculation = "halt";
}
$annotation = create_annotation($entity->guid,
                                'dislikes',
                                "dislikes",
                                "",
                                $user->guid,
                                $entity->access_id);
// tell user annotation didn't work if that is the case
if (!$annotation) {
    register_error(elgg_echo("dislikes:failure"));
    forward(REFERER);
}else{
    // if it worked remove likes
    if ($likes) {
        $haltCalculation = false;
        if ($likes[0]->canEdit()) {
            $clone = clone $likes[0];
            $likes[0]->delete();
            elgg_trigger_event('delete', 'annotation', $clone);
//            elgg_trigger_event('delete', 'annotation', $annotation);
            system_message(elgg_echo("likes:deleted"));
            forward(REFERER);
        }
    }    
}

/* notify if poster wasn't owner
if ($entity->owner_guid != $user->guid) {
    likes_notify_user($entity->getOwnerEntity(), $user, $entity, 'dislike');
}*/

system_message(elgg_echo("dislikes:dislikes"));

// Forward back to the page where the user 'liked' the object
forward(REFERER);
