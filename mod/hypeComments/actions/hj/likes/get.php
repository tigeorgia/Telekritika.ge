<?php

gatekeeper();

$user = elgg_get_logged_in_user_guid();
$guids = explode(',', get_input('guids'));

foreach ($guids as $guid) {
    $entity = get_entity($guid);
    if ($entity instanceof ElggObject) {
        $count = elgg_get_annotations(array(
            'annotation_name' => 'likes',
            'annotation_value' => 1,
            'guid' => $entity->guid,
            'type' => $entity->getType(),
            'subtype' => $entity->getSubtype(),
            'count' => true
                ));
        $annotations = elgg_get_annotations(array(
            'annotation_name' => 'likes',
            'annotation_value' => 1,
            'guid' => $entity->guid,
            'type' => $entity->getType(),
            'subtype' => $entity->getSubtype(),
            'limit' => 500
            ));

        if ($count > 0) {
            foreach ($annotations as $annotation) {
                $owner = get_entity($annotation->owner_guid);
                $object_likes[] = array('username' => $owner->name, 'url' => $owner->getURL());
            }
        }
    }
    $data[] = array('guid' => $entity->guid, 'likes' => $object_likes);
    $object_likes = null;
}
print(json_encode($data));
die();