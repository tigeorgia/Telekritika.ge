<?php

gatekeeper();

$user = elgg_get_logged_in_user_guid();
$guids = explode(',', get_input('guids'));

foreach ($guids as $guid) {
    $entity = get_entity($guid);
    $input = '';
    if ($entity instanceof ElggObject) {
        //$count = elgg_count_comments($entity);
        if ($entity->getSubtype() == 'groupforumtopic') {
            $annotation_type = 'group_topic_post';
            if (get_entity($entity->container_guid)->isMember())
                $input = '<div class="hj-comments-item-comment">' . elgg_view('input/text', array('internalid' => $entity->guid, 'name' => 'hj-comments-item-comment-input', 'value' => elgg_echo('hj:comments:newcomment'))) . '</div>';
        } else {
            $annotation_type = 'generic_comment';
            $input = '<div class="hj-comments-item-comment">' . elgg_view('input/text', array('internalid' => $entity->guid, 'name' => 'hj-comments-item-comment-input', 'value' => elgg_echo('hj:comments:newcomment'))) . '</div>';
        }
        $comments = elgg_get_annotations(array(
            'annotation_name' => $annotation_type,
            'guid' => $entity->guid,
            'limit' => 500
                ));
        if ($comments) {
            foreach ($comments as $comment) {
                $icon = elgg_view_entity_icon(get_entity($comment->owner_guid), 'tiny');
                $owner = get_entity($comment->owner_guid);
                $owner_stamp = '<a href="' . $owner->getURL() . '" class="hj-comments-item-comment-owner left">' . $owner->name . '</a>';
                if ($entity->canEdit() or $comment->canEdit()) {
                    $delete = '<a id="' . $comment->id . '" href="javascript:void(0)" class="comment-delete">' . elgg_echo('hj:comments:deletecomment') . '</a>';
                } else {
                    $delete = '';
                }
                $object_comments[] = array('id' => $comment->id, 'time' => elgg_view_friendly_time($comment->time_created), 'owner' => $owner_stamp, 'text' => $comment->value, 'icon' => $icon, 'deletebutton' => $delete);
            }
        }
    }
    $data[] = array('guid' => $entity->guid, 'comments' => $object_comments, 'input' => $input);
    $object_comments = null;
}
print(json_encode($data));
die();