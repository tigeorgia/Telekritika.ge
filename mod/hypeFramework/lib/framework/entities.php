<?php

/**
 * Helper functions to manipulate entities
 * 
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category Forms
 * @category Framework Entities Library
 * 
 * @param int $form_entity_guid NULL|INT GUID of an hjForm containing hjField
 * @param int $form_field_entity_guid NULL|INT GUID of an hjField we are editing
 * 
 */
?><?php

/**
 * Set priority of an element in a list
 * 
 * @see ElggEntity::$priority
 * 
 * @param ElggEntity $entity
 * @return bool 
 */
function hj_framework_set_entity_priority($entity, $priority = null) {
    if ($priority) {
        $entity->priority = $priority;
        return true;
    }
    $count = elgg_get_entities(array(
        'type' => $entity->getType(),
        'subtype' => $entity->getSubtype(),
        'owner_guid' => $entity->owner_guid,
        'container_guid' => $entity->container_guid,
        'count' => true
            ));

    if (!$entity->priority)
        $entity->priority = $count + 1;

    return true;
}

/**
 * Get a list of entities sorted by ElggEntity::$priority
 * 
 * @param string $type
 * @param string $subtype
 * @param int $owner_guid
 * @param int $container_guid
 * @param int $limit
 * @return array An array of ElggEntity 
 */
function hj_framework_get_entities_by_priority($type, $subtype, $owner_guid = NULL, $container_guid = NULL, $limit = 0) {
    $db_prefix = elgg_get_config('dbprefix');
    $entities = elgg_get_entities(array(
        'type' => $type,
        'subtype' => $subtype,
        'onwer_guid' => $owner_guid,
        'container_guid' => $container_guid,
        'limit' => $limit,
        'joins' => array("JOIN {$db_prefix}metadata as mt on e.guid = mt.entity_guid 
                      JOIN {$db_prefix}metastrings as msn on mt.name_id = msn.id 
                      JOIN {$db_prefix}metastrings as msv on mt.value_id = msv.id"
        ),
        'wheres' => array("((msn.string = 'priority'))"),
        'order_by' => "CAST(msv.string AS SIGNED) ASC"
            ));
    return $entities;
}

function hj_framework_get_entities_from_metadata_by_priority($type, $subtype, $owner_guid = NULL, $container_guid = NULL, $metadata_name_value_pairs = null, $limit = 0) {
    if (is_array($metadata_name_value_pairs)) {
        $db_prefix = elgg_get_config('dbprefix');
        $entities = elgg_get_entities_from_metadata(array(
            'type' => $type,
            'subtype' => $subtype,
            'onwer_guid' => $owner_guid,
            'container_guid' => $container_guid,
            'metadata_name_value_pairs' => $metadata_name_value_pairs,
            'limit' => $limit,
            'joins' => array("JOIN {$db_prefix}metadata as mt on e.guid = mt.entity_guid 
                      JOIN {$db_prefix}metastrings as msn on mt.name_id = msn.id 
                      JOIN {$db_prefix}metastrings as msv on mt.value_id = msv.id"
            ),
            'wheres' => array("((msn.string = 'priority'))"),
            'order_by' => "CAST(msv.string AS SIGNED) ASC"
                ));
    } else {
        $entities = hj_framework_get_entities_by_priority($type, $subtype, $owner_guid, $container_guid, $limit);
    }
    return $entities;
}

/**
 * Get a DataPattern for a given hf entity
 * 
 * @param string $type
 * @param string $subtype
 * @return hjForm 
 */
function hj_framework_get_data_pattern($type, $subtype, $handler = null) {
    if ($container && elgg_instanceof($container)) {
        $subtype = $container->getSubtype();
    }
    $forms = elgg_get_entities_from_metadata(array(
        'type' => 'object',
        'subtype' => 'hjform',
        'metadata_name_value_pairs' => array(
            array(
                'name' => 'subject_entity_type',
                'value' => $type
            ),
            array(
                'name' => 'subject_entity_subtype',
                'value' => $subtype
            ),
            array(
                'name' => 'handler',
                'value' => $handler
            )
            )));
    return $forms[0];
}

function hj_framework_extract_params_from_entity($entity, $params = array(), $context = null) {

    $return = array();

    if ($context) {
        elgg_set_context($context);
    } else {
        $context = elgg_get_context();
    }

    if (elgg_instanceof($entity)) {

        $container = $entity->getContainerEntity();
        $owner = $entity->getOwnerEntity();
        $form_guid = get_input('f', $entity->data_pattern);
        $form = get_entity($form_guid);
        if (elgg_instanceof($form)) {
            $fields = $form->getFields();
            $handler = $form->handler;
        }
        $widget = get_entity($entity->widget);
        $viewtype = get_input('vt');

        $url_params = array(
            'e' => $entity->guid,
            's' => $entity->guid,
            'c' => $container->guid,
            'o' => $owner->guid,
            'f' => $form->guid,
            'w' => $widget->guid,
            'st' => $entity->getSubtype(),
            'cx' => $context,
            'hd' => $handler,
            'vt' => $viewtype,
            'ev' => 'update'
        );

        $obj_params = array(
            'subject' => $entity,
            'container' => $container,
            'owner' => $owner,
            'form' => $form,
            'fields' => $fields,
            'widget' => $widget->guid,
            'subtype' => $entity->getSubtype(),
            'context' => $context,
            'handler' => $handler,
            'viewtype' => $viewtype,
            'event' => 'update'
        );

        $params = array_merge($obj_params, $params);

        $return = array(
            'entity' => $entity,
            'params' => $params,
            'url_params' => $url_params
        );
    }
    return $return;
}

function hj_framework_extract_params_from_url() {

    $context = get_input('cx');
    if (!empty($context)) {
        elgg_set_context($context);
    } else {
        $context = elgg_get_context();
    }

    $section = get_input('st');
    if (empty($section)) {
        $section = "hj{$context}";
    }

    $handler = get_input('hd');
    if (empty($handler)) {
        $handler = '';
    }
    if ($params = get_input('params')) {
        $params = json_decode($params, true);
    } else {
        $params = array();
    }
    $entity_guid = get_input('s');
    if (!empty($entity_guid)) {
        $entity = get_entity($entity_guid);
        return hj_framework_extract_params_from_entity($entity, $params, $context);
    }

    $container_guid = get_input('c');
    $container = get_entity($container_guid);
    if (!elgg_instanceof($container)) {
        $container = elgg_get_page_owner_entity();
    }

    $owner_guid = get_input('o');
    if (!empty($owner_guid)) {
        $owner = get_entity($owner_guid);
    } else if (elgg_instanceof($container)) {
        $owner = $container->getOwnerEntity();
    } else if (elgg_is_logged_in()) {
        $owner = elgg_get_logged_in_user_entity();
    } else {
        $owner = elgg_get_site_entity();
    }

    $form_guid = get_input('f');
    $form = get_entity($form_guid);

    if (!elgg_instanceof($form)) {
        $form = hj_framework_get_data_pattern('object', $section, $handler);
    }
    if (elgg_instanceof($form)) {
        $fields = $form->getFields();
    }

    $widget_guid = get_input('w');
    $widget = get_entity($widget_guid);

    $viewtype = get_input('vt');

    $url_params = array(
        's' => null,
        'c' => $container->guid,
        'o' => $owner->guid,
        'f' => $form->guid,
        'w' => $widget->guid,
        'st' => $section,
        'cx' => $context,
        'hd' => $handler,
        'vt' => $viewtype,
        'ev' => 'create'
    );

    $obj_params = array(
        'subject' => null,
        'container' => $container,
        'owner' => $owner,
        'form' => $form,
        'fields' => $fields,
        'widget' => $widget,
        'subtype' => $section,
        'context' => $context,
        'handler' => $handler,
        'viewtype' => $viewtype,
        'event' => 'create'
    );

    $params = array_merge($obj_params, $params);

    $return = array(
        'params' => $params,
        'url_params' => $url_params
    );

    return $return;
}

function hj_framework_extract_params_from_params($params) {

    $context = $params['cx'];
    if (!empty($context)) {
        elgg_set_context($context);
    } else {
        $context = elgg_get_context();
    }

    $section = $params['st'];
    if (empty($section)) {
        $section = "hj{$context}";
    }

    $handler = $params['hd'];
    if (empty($handler)) {
        $handler = '';
    }

    $subject_guid = $params['s'];
    if (!empty($entity_guid)) {
        $subject = get_entity($subject_guid);
    }

    $container_guid = $params['c'];
    $container = get_entity($container_guid);
    if (!elgg_instanceof($container)) {
        $container = elgg_get_page_owner_entity();
    }

    $owner_guid = $params['o'];
    if (!empty($owner_guid)) {
        $owner = get_entity($owner_guid);
    } else if (elgg_instanceof($container)) {
        $owner = $container->getOwnerEntity();
    } else if (elgg_is_logged_in()) {
        $owner = elgg_get_logged_in_user_entity();
    } else {
        $owner = elgg_get_site_entity();
    }

    $form_guid = $params['f'];
    $form = get_entity($form_guid);
    if (!elgg_instanceof($form)) {
        $form = hj_framework_get_data_pattern('object', $section, $handler);
    }
    if (elgg_instanceof($form)) {
        $fields = $form->getFields();
    }

    $widget_guid = $params['w'];
    $widget = get_entity($widget_guid);

    $viewtype = $params['vt'];

    $url_params = array(
        's' => $subject->guid,
        'c' => $container->guid,
        'o' => $owner->guid,
        'f' => $form->guid,
        'w' => $widget->guid,
        'st' => $section,
        'cx' => $context,
        'hd' => $handler,
        'vt' => $viewtype,
        'ev' => 'create'
    );

    $obj_params = array(
        'subject' => $subject,
        'container' => $container,
        'owner' => $owner,
        'form' => $form,
        'fields' => $fields,
        'widget' => $widget,
        'subtype' => $section,
        'context' => $context,
        'handler' => $handler,
        'viewtype' => $viewtype,
        'event' => 'create'
    );

    $return = array(
        'params' => $obj_params,
        'url_params' => $url_params
    );

    return $return;
}

function hj_framework_get_email_url() {
    $extract = hj_framework_extract_params_from_url();
    $subject = elgg_extract('subject', $extract['params']);
    
    if (elgg_instanceof($subject)) {
        return $subject->getURL();
    } else {
        return elgg_get_site_url();
    }
}