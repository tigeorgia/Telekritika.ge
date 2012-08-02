<?php
/**
 * Edit editorial form
 *
 * @package Blog
 */

$editorial = get_entity($vars['guid']);
$vars['entity'] = $editorial;

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="message warning">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/editorial/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/confirmlink', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete elgg-state-disabled float-alt'
	));
}

// published editorials do not get the preview button
if (!$vars['guid'] || ($editorial && $editorial->status != 'published')) {
	$preview_button = elgg_view('input/submit', array(
		'value' => elgg_echo('preview'),
		'name' => 'preview',
		'class' => 'mls',
	));
}

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'name' => 'save',
));
$action_buttons = $save_button . $preview_button . $delete_link;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'editorial_title',
	'value' => $vars['title']
));

$excerpt_label = elgg_echo('editorial:excerpt');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'editorial_excerpt',
	'value' => html_entity_decode($vars['excerpt'], ENT_COMPAT, 'UTF-8')
));

$body_label = elgg_echo('editorial:body');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'editorial_description',
	'value' => $vars['description']
));

$save_status = elgg_echo('editorial:save_status');
if ($vars['guid']) {
	$entity = get_entity($vars['guid']);
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('editorial:never');
}

$status_label = elgg_echo('editorial:status');
$status_input = elgg_view('input/dropdown', array(
	'name' => 'status',
	'id' => 'editorial_status',
	'value' => $vars['status'],
	'options_values' => array(
		'draft' => elgg_echo('editorial:status:draft'),
		'published' => elgg_echo('editorial:status:published')
	)
));

$comments_label = elgg_echo('comments');
$comments_input = elgg_view('input/dropdown', array(
	'name' => 'comments_on',
	'id' => 'editorial_comments_on',
	'value' => $vars['comments_on'],
	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'id' => 'editorial_tags',
	'value' => $vars['tags']
));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'id' => 'editorial_access_id',
	'value' => $vars['access_id']
));

$categories_input = elgg_view('categories', $vars);
$events_input = elgg_view('events', $vars);

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));


echo <<<___HTML

$draft_warning

<div>
	<label for="editorial_title">$title_label</label>
	$title_input
</div>

<div>
	<label for="editorial_excerpt">$excerpt_label</label>
	$excerpt_input
</div>

<label for="editorial_description">$body_label</label>
$body_input
<br />

<div>
	<label for="editorial_tags">$tags_label</label>
	$tags_input
</div>

$categories_input
$events_input

<div>
	<label for="editorial_comments_on">$comments_label</label>
	$comments_input
</div>

<div>
	<label for="editorial_access_id">$access_label</label>
	$access_input
</div>

<div>
	<label for="editorial_status">$status_label</label>
	$status_input
</div>

<div class="elgg-foot">
	<div class="elgg-subtext mbm">
	$save_status <span class="editorial-save-status-time">$saved</span>
	</div>

	$guid_input
	$container_guid_input

	$action_buttons
</div>

___HTML;
