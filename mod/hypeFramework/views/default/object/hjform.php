<?php

$form = $vars['entity'];

if (!elgg_instanceof($form)) {
    return true;
}

elgg_load_library('hj:framework:forms');
elgg_load_library('hj:framework:knowledge');
elgg_load_js('hj.framework.fieldcheck');
elgg_load_js('hj.formbuilder.sortable');


$extract = hj_framework_extract_params_from_url();
$params = elgg_extract('params', $extract, array());

$subject = $params['subject'];
$container = $params['container'];
$owner = $params['owner'];
$fields = $params['fields'];
$context = $params['context'];
$event = $params['event'];
$widget = $params['widget'];
$viewtype = $params['viewtype'];

$form_title = elgg_echo($form->getTitle($subject));
$form_description = elgg_echo($form->description);
if (is_array($fields)) {
    foreach ($fields as $field) {
        if ($field->input_type == 'file') {
            $multipart = true;
        }
        if (!$multipart || elgg_is_logged_in()) {
            $form_fields .= elgg_view_entity($field, array('subject' => $subject, 'container' => $container));
        }
    }
}

$form_fields .= elgg_view('input/hidden', array('value' => $form->guid, 'name' => 'f'));
$form_fields .= elgg_view('input/hidden', array('value' => $subject->guid, 'name' => 's'));
$form_fields .= elgg_view('input/hidden', array('value' => $container->guid, 'name' => 'c'));
$form_fields .= elgg_view('input/hidden', array('value' => $owner->guid, 'name' => 'o'));
$form_fields .= elgg_view('input/hidden', array('value' => $widget->guid, 'name' => 'w'));
$form_fields .= elgg_view('input/hidden', array('value' => $form->subject_entity_subtype, 'name' => 'st'));
$form_fields .= elgg_view('input/hidden', array('value' => $context, 'name' => 'cx'));
$form_fields .= elgg_view('input/hidden', array('value' => $event, 'name' => 'ev'));
$form_fields .= elgg_view('input/hidden', array('value' => $viewtype, 'name' => 'vt'));
$form_fields .= elgg_view('input/submit', array(
    'value' => elgg_echo('submit')
        ));

if ($form->ajaxify && !$multipart) {
    $class = "hj-ajaxed-save";
    if (elgg_instanceof($widget, 'object', 'widget')) {
        $target = "#elgg-widget-{$widget->guid} ";
    }
    if ($event == 'create') {
        $target .= "#hj-section-{$form->subject_entity_subtype}";
    } else {
        $target .= "#elgg-object-{$subject->guid}";
    }
}

$form = elgg_view('input/form', array(
    'body' => $form_fields,
    'id' => "hj-form-entity-{$form->guid}",
    'action' => $form->action,
    'method' => $form->method,
    'enctype' => $form->enctype,
    'class' => "$form->class $class",
    'target' => "$target",
    'js' => 'onsubmit="return hj.framework.fieldcheck.init($(this));"'
        ));

$body = elgg_view_module('aside', $form_title, $form_description . $form);
if ($event == 'create') {
    $body = elgg_view('page/components/hj/section', array(
        'body' => $body,
        'subtype' => $form->subject_entity_subtype
            ));
}
echo $body;