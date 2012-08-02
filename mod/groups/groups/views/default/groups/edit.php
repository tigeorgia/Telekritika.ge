<?php
/**
 * Edit/create a group wrapper
 *
 * @uses $vars['entity'] ElggGroup object
 */

$entity = elgg_extract('entity', $vars, null);
$subtype = $vars['subtype'];

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);
$body_vars = array('entity' => $entity, 'subtype' => $subtype);
echo elgg_view_form('groups/edit'.$subtype, $form_vars, $body_vars);
