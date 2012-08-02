<?php
/**
 * Action that renders an edit form using an instance of hjForm
 * If subject_entity is supplied, sets the input values to those of the entity and populates hidden fields with extras
 * If subject_entity is not supplied, looks for a container_entity to create a new entity within that container
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
$params = elgg_extract('params', $extract);

// We want to see the form
$form = array($params['form']);
$html = elgg_view_entity_list($form, $params);

if (empty($html)) {
    $html = elgg_echo('hj:framework:ajax:noentity');
}

$output['data'] = $html;
print(json_encode($output));
die();
