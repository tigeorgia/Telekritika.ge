<?php
/**
 * Edit commentary form
 *
 * @package Commentary
 */

$commentary = get_entity($vars['guid']);
$vars['entity'] = $commentary;

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="message warning">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

/*if ($vars['guid'] && elgg_is_admin_logged_in()) {
	// add a delete button if editing
	$delete_url = "action/commentary/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/confirmlink', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete elgg-state-disabled float-alt'
	));
} */

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'name' => 'save',
));
$action_buttons = $save_button . $preview_button . $delete_link;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'commentary_title',
	'value' => $vars['title']
));

$excerpt_label = elgg_echo('commentary:excerpt');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'commentary_excerpt',
	'value' => html_entity_decode($vars['excerpt'], ENT_COMPAT, 'UTF-8')
));

$body_input = elgg_view('input/longtextnomce', array(
	'name' => 'description',
	'id' => 'commentary_description',
	'value' => $vars['description'],
    'placeholder' => elgg_echo('becomeacritic')
));

$save_status = elgg_echo('commentary:save_status');
if ($vars['guid']) {
	$entity = get_entity($vars['guid']);
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('commentary:never');
}

$status_label = elgg_echo('commentary:status');
$status_input = elgg_view('input/dropdown', array(
    'name' => 'status',
    'id' => 'commentary_status',
    'value' => $vars['status'],
    'options_values' => array(
        'draft' => elgg_echo('commentary:status:draft'),
        'published' => elgg_echo('commentary:status:published')
    )
));

$linked_segments = get_linked_segments_guids($vars['entity']);
$segments_keyval = get_segments_keyval();
/*
$linked_segments_label = elgg_echo('linked_segments');
$linked_segments_input = elgg_view('input/dropdownmulti', array(
    'size' => 5,
	'name' => 'linked_segments[]',
	'id' => 'linked_segment_status',
	'value' => $linked_segments,
	'options_values' => $segments_keyval
));
*/

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));

elgg_load_js('elgg.autocomplete_cv');

$available_tags = "['". implode("', '", get_all_tags($options)) . "']";
$implodedsegments = "['". implode("', '", $linked_segments) . "']";

echo <<<___HTML

<div id="commentary_input_wrapper">
    $body_input <br />
    $action_buttons
</div>

<div id="cv_segmentselect_module_holder"></div>
                                
<div class="elgg-foot">
	$guid_input
	$container_guid_input
</div>

<div id="hidden_segments"></div>

<script type="text/javascript">
linked_segments = $implodedsegments;
availableTags = $available_tags;
elgg.provide('elgg.autocomplete_cv');
elgg.autocomplete_cv.url = availableTags;
</script> 


___HTML;
