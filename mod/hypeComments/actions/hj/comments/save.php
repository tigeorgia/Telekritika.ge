<?php
gatekeeper();

$value = get_input('value');
$entity_guid = (int) get_input('entity_guid');
$entity = get_entity($entity_guid);

if ($entity instanceof ElggObject) {
    if ($entity->getSubtype() == 'groupforumtopic') {
        $annotation_type = 'group_topic_post';
    } else {
        $annotation_type = 'generic_comment';
    }
    create_annotation($entity->getGUID(), $annotation_type, $value, '', elgg_get_logged_in_user_guid(), $entity->access_id);
}
return true;
?>
