<?php

$field = $vars['entity'];
$subject = $vars['subject'];

if (!elgg_instanceof($field)) {
    return true;
}

elgg_load_library('hj:framework:forms');

$form = $field->getContainerForm();
$options = $field->getParams($subject);

if ($field->input_type != 'hidden') {  
    $field_input .= elgg_view('input/' . $field->input_type, $options);

    if ($field->mandatory) {
        $mandatory = "mandatory";
    } else {
        $mandatory = null;
    }
    
    $field_view = <<<HTML
    <div class="$mandatory">
        <label for="$field->name">{$field->getLabel()}</label><br/>
        <div class="hj-formbuilder-input hj-margin-ten">$field_input</div>
    </div>
HTML;
} else {
    $field_view = elgg_view('input/' . $field->input_type, $options);
}


if (elgg_is_admin_logged_in() && elgg_in_context('admin')) {
    $field_view .= elgg_view('hj/formbuilder/menu', $vars);
}

echo $field_view;