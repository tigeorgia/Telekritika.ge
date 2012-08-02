<?php
/**
 * Edit article form
 *
 * @package Article
 */
global $actionbuttons;

$article = get_entity($vars['guid']);
$vars['entity'] = $article;

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="message warning">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/article/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/confirmlink', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete elgg-state-disabled float-alt'
	));
}

// published articles do not get the preview button
if (!$vars['guid'] || ($article && $article->status != 'published')) {
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
$actionbuttons = $save_button . $preview_button . $delete_link;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'article_title',
	'value' => $vars['title']
));

$excerpt_label = elgg_echo('article:excerpt');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'article_excerpt',
	'value' => html_entity_decode($vars['excerpt'], ENT_COMPAT, 'UTF-8')
));

$body_label = elgg_echo('article:body');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'article_description',
	'value' => $vars['description']
));

$save_status = elgg_echo('article:save_status');
if ($vars['guid']) {
	$entity = get_entity($vars['guid']);
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('article:never');
}

$status_label = elgg_echo('article:status');
$status_input = elgg_view('input/dropdown', array(
	'name' => 'status',
	'id' => 'article_status',
	'value' => $vars['status'],
	'options_values' => array(
		'draft' => elgg_echo('article:status:draft'),
		'published' => elgg_echo('article:status:published')
	)
));

$comments_label = elgg_echo('comments');
$comments_input = elgg_view('input/dropdown', array(
	'name' => 'comments_on',
	'id' => 'article_comments_on',
	'value' => $vars['comments_on'],
	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
    'name' => 'tags',
    'id' => 'article_tags',
    'value' => $vars['tags']
));

$events_label = elgg_echo('events');
$events_input = elgg_view('input/tags', array(
    'name' => 'events',
    'id' => 'article_events',
    'value' => $vars['events']
));

$categories_input = elgg_view('categories', $vars);

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));

// hidden inputs
//$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$access_input = elgg_view('input/hidden', array('name' => 'access_id','value' => get_default_access()));
$context = ($vars['guid']) ? elgg_view('input/hidden', array('name' => 'context', 'value' => "edit")) : elgg_view('input/hidden', array('name' => 'context', 'value' => "new"));

echo <<<___HTML

$draft_warning

<div>
	<label for="article_title">$title_label</label>
	$title_input
</div>

<div>
	<label for="article_excerpt">$excerpt_label</label>
	$excerpt_input
</div>

<label for="article_description">$body_label</label>
$body_input
<br />

<div>
	<label for="article_tags">$tags_label</label>
	$tags_input
</div>

<div>
    <label for="segment_tags">$events_label</label>
    $events_input
</div>

$categories_input

<div>
	<label for="article_comments_on">$comments_label</label>
	$comments_input
</div>


<div>
	<label for="article_status">$status_label</label>
	$status_input
</div>

<div class="elgg-foot">
	<div class="elgg-subtext mbm">
	$save_status <span class="article-save-status-time">$saved</span>
	</div>

	$guid_input
    $access_input
    $context
	$container_guid_input

</div>

___HTML;
