<?php
gatekeeper();

$guid = get_input('guid');
$entity = get_entity($guid);
$user = elgg_get_logged_in_user_guid();

if ($entity instanceof ElggObject) {
    $likes = elgg_get_annotations(array(
        'annotation_name' => 'likes',
        'annotation_value' => 1,
        'guid' => $entity->guid,
        'annotation_owner_guid' => $user,
        'type' => $entity->getType(),
        'subtype' => $entity->getSubtype(),
        'limit' => 500
            ));
    if (is_array($likes)) {
        foreach ($likes as $like) {
            $result = update_annotation($like->id, 'likes', 0, '', $user, $entity->access_id);
        }
    }
    print(json_decode($result));
}
return true;