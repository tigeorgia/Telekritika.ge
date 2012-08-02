<?php

/**
 * Action that renders a list of entities
 * 
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category AJAX
 * @category User Interface
 * 
 * @uses int hjForm::$guid NULL|INT GUID of an hjForm containing hjField
 * @params int $subject_entity_guid
 * @params int $subject_container_guid
 * @params int $owner_entity_guid
 * @params string $context
 * @params string $params A JSON encoded string of additional parameters
 * 
 * @return json
 */
?><?php

/**
 * Parsing the URL
 * 
 * cx - context
 * e - subject entity guid
 * c - container entity guid
 * f - form entity guid
 * o - owner entity guid
 */
$extract = hj_framework_extract_params_from_url();
$params = elgg_extract('params', $extract, array());
$entity = elgg_extract('entity', $extract, false);
$widget = elgg_extract('widget', $params, null);
$section = elgg_extract('subtype', $params, false);
$viewtype = elgg_extract('viewtype', $params, '');
$view_params = array(
    'list_class' => 'hj-ajaxed hj-view-list',
    'item_class' => 'hj-ajaxed hj-view-entity',
    'viewtype' => $viewtype
);

$params = array_merge($params, $view_params);

if ($entity) {
    $entities = array($entity);
} else if ($section) {
    $owner = elgg_extract('owner', $params, null);
    $container = elgg_extract('container', $params, null);
    if ($widget && elgg_instanceof($widget, 'object', 'widget')) {
        $segment = $widget->getContainerEntity();
        $entities = $segment->getSectionContent($section, $widget);
    } else {
        $entities = elgg_get_entities(array(
            'type' => 'object',
            'subtype' => $section,
            'owner_guid' => $owner->guid,
            'container_guid' => $container->guid,
            'limit' => 0
                ));
    }
}

$html = elgg_view_entity_list($entities, $params);

if (empty($html)) {
    $html = elgg_echo('hj:framework:ajax:noentity');
}

$html = elgg_view('page/components/hj/section', array('body' => $html, 'subtype' => $section));

$output['data'] = $html;
print(json_encode($output));
die();
