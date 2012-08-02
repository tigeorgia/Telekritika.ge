<?php
function hj_framework_object_icons($hook, $type, $return, $params) {
    $entity = $params['entity'];
    $size = $params['size'];

    if (!elgg_instanceof($entity)) {
        return $return;
    }

    switch ($entity->getSubtype()) {

        case 'hjfile' :

            if ($entity->simpletype == 'image') {
                return "mod/hypeFramework/pages/file/icon.php?guid={$entity->guid}&size={$size}";
            }

            $mapping = hj_framework_mime_mapping();

            $mime = $entity->mimetype;
            if ($mime) {
                $base_type = substr($mime, 0, strpos($mime, '/'));
            } else {
                $mime = 'none';
                $base_type = 'none';
            }

            if (isset($mapping[$mime])) {
                $type = $mapping[$mime];
            } elseif (isset($mapping[$base_type])) {
                $type = $mapping[$base_type];
            } else {
                $type = 'general';
            }

            $url = "mod/hypeFramework/graphics/mime/{$size}/{$type}.png";
            return $url;

            break;

        case 'hjfilefolder' :

            $type = $folder->datatype;
            if (!$type)
                $type = "default";
            
            $url = "mod/hypeFramework/graphics/folder/{$size}/{$type}.png";
            return $url;

            break;

        default :
            return $return;
    }
}

function hj_framework_setup_segment_widgets($hook, $type, $return, $params) {

    $entity_guid = elgg_extract('guid', $params, 0);
    $entity = get_entity($entity_guid);
    $context = elgg_extract('context', $params, 'framework');
    $event = elgg_extract('event', $params, 'update');
    
    if ($entity->getSubtype() == 'hjsegment' && $event == 'create') {
        $sections = elgg_trigger_plugin_hook('hj:framework:widget:types', 'all', array('context' => $context), array());
//        $widgets = $entity->getWidgets($context);
//
//        if (is_array($widgets)) {
//            foreach ($widgets as $widget) {
//                if (elgg_instanceof($widget))
//                        $widget->delete();
//            }
//        }
        if (is_array($sections)) {
            foreach ($sections as $section => $name) {
                $entity->addWidget($section, null, $context);
            }
        }
    }
    return $return;
    
}