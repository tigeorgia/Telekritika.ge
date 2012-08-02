<?php
$guid = get_input('guid');
$entity = get_entity($guid);
$user = elgg_get_logged_in_user_entity();

if ($entity instanceof ElggObject) {
    $count_likes = elgg_get_annotations(array(
        'annotation_name' => 'likes',
        'annotation_value' => 1,
        'guid' => $entity->guid,
        'annotation_owner_guid' => $user->guid,
        'type' => $entity->getType(),
        'subtype' => $entity->getSubtype(),
        'count' => true
            ));
    $count_unlikes = elgg_get_annotations(array(
        'annotation_name' => 'likes',
        'annotation_value' => 0,
        'guid' => $entity->guid,
        'annotation_owner_guid' => $user->guid,
        'type' => $entity->getType(),
        'subtype' => $entity->getSubtype(),
        'count' => true
            ));
    if ($count_likes == 0 && $count_unlikes == 0) {
        return create_annotation($entity->getGUID(), 'likes', 1, '', $user->guid, $entity->access_id);
    } else if ($count_unlikes > 0) {
        $likes = elgg_get_annotations(array(
            'annotation_name' => 'likes',
            'annotation_value' => 0,
            'guid' => $entity->guid,
            'annotation_owner_guid' => $user->guid,
            'type' => $entity->getType(),
            'subtype' => $entity->getSubtype(),
            'limit' => 500
                ));

        if (is_array($likes)) {
            foreach ($likes as $like) {
                return update_annotation($like->id, 'likes', 1, '', $user->guid, $entity->access_id);
            }
        }
    }
    //print(json_decode($result));
}