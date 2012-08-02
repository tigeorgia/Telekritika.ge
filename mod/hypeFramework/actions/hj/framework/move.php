<?php
/**
 * Action to reorder entities
 * 
 * @uses $priorities An array of  position => guid
 * 
 * @return bool
 */

$priorities = get_input('priorities');

if (is_array($priorities)) {
    foreach ($priorities as $priority => $guid) {
        $guid = substr($guid, -3, 3);
        $entity = get_entity($guid);
        $entity->priority = $priority;
    }
}
return true;
die();