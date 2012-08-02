<?php
gatekeeper();

$id = get_input('id');

$comment = get_annotation($id);
$entity = get_entity($comment->entity_guid);

if ($comment->canEdit() || $entity->canEdit()) {
    $comment->delete();
}
return true;
?>
