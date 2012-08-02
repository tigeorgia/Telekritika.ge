<?php

$entity = elgg_extract('entity', $vars);
$fields = elgg_extract('fields', $vars, null);
$viewtype = elgg_extract('viewtype', $vars, '');
$intro = elgg_extract('intro', $vars, '');

if ($viewtype == 'gallery') {
    $content = $intro;
}

if (is_array($fields)) {
    foreach ($fields as $field) {
        $field_name = $field->name;
        if ($entity->$field_name != '' && !in_array($field->input_type, array('access', 'hidden'))) {
            $output_value = $entity->$field_name;
            $output_type = $field->input_type;
            $output_label = elgg_echo($field->getLabel());
            $output_text = elgg_view("output/$output_type", array('value' => $output_value));
            //$output_icon = elgg_view_icon($entity->$field_name);
            if (!empty($output_value)) {
                $content .= <<<HTML
                        <div class="hj-field-module-output clearfix">
                            $output_icon<span class="hj-field-module hj-output-label left">$output_label: </span>
                            <span class="hj-field-module hj-output-text left">$output_text</span>
                        </div>
HTML;
            }
        }
    }
}

echo $content;