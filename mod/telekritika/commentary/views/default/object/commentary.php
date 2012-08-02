<?php
/**
 * View for commentary objects
 *
 * @package Commentary
 */

$full = elgg_extract('full_view', $vars, FALSE);
$commentary = elgg_extract('entity', $vars, FALSE);

if (!$commentary) {
	return TRUE;
}

$owner = $commentary->getOwnerEntity();
$container = $commentary->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$channels = elgg_view('output/channels', $vars);
$excerpt = $commentary->excerpt;

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "commentary/owner/$owner->username",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));
$tags = elgg_view('output/tags', array('tags' => $commentary->tags));
$date = elgg_view_friendly_time($commentary->time_created);

// The "on" status changes for comments, so best to check for !Off
if ($commentary->comments_on != 'Off') {
	$comments_count = $commentary->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $commentary->getURL() . '#commentary-comments',
			'text' => $text,
		));
	} else {
		$comments_link = '';
	}
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'channels',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "<p>$author_text $date $comments_link</p>";
$subtitle .= $categories;
$subtitle .= $channels;

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full) {

	$body = elgg_view('output/longtext', array(
		'value' => $commentary->description,
		'class' => 'commentary-post',
	));

	$header = elgg_view_title($commentary->title);

	$params = array(
		'entity' => $commentary,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	$commentary_info = elgg_view_image_block($owner_icon, $list_body);

	echo <<<HTML
$header
$commentary_info
$body
HTML;

} else {
	// brief view

	$params = array(
		'entity' => $commentary,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($owner_icon, $list_body);
}
