<?php
/**
 * Elgg add like action
 *
 */

$annotation_id = (int) get_input('annotation_id');
$comment = elgg_get_annotation_from_id($annotation_id);
//smail("id1,value1", $annotation_id.",".$comment->value);
// Let's see if we can get an entity with the specified GUID
if (!$comment) {
    register_error(elgg_echo("likes:notfound"));
    forward(REFERER);
}

//check to see if the user has already liked the item
$comment_info = @json_decode($comment->value, true);         
//smail(comment_infp,$comment_info);
if (isset($comment_info['likes']) && in_array(elgg_get_logged_in_user_guid(), $comment_info['likes'])) {
    system_message(elgg_echo("likes:alreadyliked"));
    forward(REFERER);
}

// limit like to prevent liking your own content 
if (elgg_get_logged_in_user_guid() == $comment->owner_guid) {
    // plugins should register the error message to explain why liking isn't allowed
    system_message(elgg_echo("likes:commentowner"));
    forward(REFERER);
}

//$user = elgg_get_logged_in_user_entity();
if (!empty($comment_info)){
    $comment_info['likes'][(string)elgg_get_logged_in_user_guid()] = elgg_get_logged_in_user_guid();
    unset($comment_info['dislikes'][(string)elgg_get_logged_in_user_guid()]);
}else{
    $reverseme = true;
    $comment_info['originalvalue'] = $comment->value;
    $comment_info['likes'][(string)elgg_get_logged_in_user_guid()] = elgg_get_logged_in_user_guid();        
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


system_message(elgg_echo("likes:likes"));

// Forward back to the page where the user 'liked' the object
forward(REFERER);