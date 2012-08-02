<?php
/**
 * Elgg add like action
 *
 */

$annotation_id = (int) get_input('annotation_id');
$comment = get_annotation($annotation_id);
// Let's see if we can get an entity with the specified GUID
if (!$comment) {
    register_error(elgg_echo("likes:notfound"));
    forward(REFERER);
}

//check to see if the user has already liked the item
$comment_info = @json_decode($comment->value, true);         
if (!empty($comment_info['dislikes']) && in_array(elgg_get_logged_in_user_guid(), $comment_info['dislikes'])) {
    unset($comment_info['dislikes'][(string)elgg_get_logged_in_user_guid()]);
}else{
    system_message(elgg_echo("likes:alreadyundisliked"));
    forward(REFERER);    
}

$numberlikes = count($comment_info['likes']);
$numberdislikes = count($comment_info['dislikes']);

$origPopularity = $comment_info['popularity'];
$origControversy = $comment_info['controversy'];

$comment_info['popularity'] = calc_popularity($numberlikes, $numberdislikes);
$comment_info['controversy'] = calc_controversy($numberlikes, $numberdislikes);    

$entity = get_entity($comment->entity_guid);
$owner = get_user($entity->owner_guid);

$owner->popularityMonthTotal = $owner->popularityMonthTotal + ($comment_info['popularity'] - $origPopularity);
$owner->popularityTotal = $owner->popularityTotal + ($comment_info['popularity'] - $origPopularity);

$owner->controversyMonthTotal = $owner->controversyMonthTotal + ($comment_info['controversy'] - $origControversy);
$owner->controversyTotal = $owner->controversyTotal + ($comment_info['controversy'] - $origControversy);

$comment_info = $reverseme ? array_reverse($comment_info, true) : $comment_info;

$comment->value = json_encode($comment_info);
$comment->save();


system_message(elgg_echo("likes:undislikes"));

// Forward back to the page where the user 'liked' the object
forward(REFERER);