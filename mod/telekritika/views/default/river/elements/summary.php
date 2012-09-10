<?php
/**
 * Short summary of the action that occurred
 *
 * @vars['item'] ElggRiverItem
 */
global $CONFIG;
$item = $vars['item'];

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();
$target = $object->getContainerEntity();

$subject_link = "<b>$subject->name</b>";

$object_link = $object->title ? $object->title : $object->name;

$action = $item->action_type;
$type = $item->type;
$subtype = $item->subtype ? $item->subtype : 'default';

$container = $object->getContainerEntity();

echo elgg_echo("river:$action:$type:$subtype", array($subject_link, $object_link));