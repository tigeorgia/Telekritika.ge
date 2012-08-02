<?php
/**
 * View for editorial objects
 *
 * @package Blog
 */

$full = elgg_extract('full_view', $vars, FALSE);
$editorial = elgg_extract('entity', $vars, FALSE);

if (!$editorial) {
	return TRUE;
}

$owner = $editorial->getOwnerEntity();
$container = $editorial->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$channels = elgg_view('output/channels', $vars);
$excerpt = $editorial->excerpt;

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "editorial/owner/$owner->username",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));
$tags = elgg_view('output/tags', array('tags' => $editorial->tags));
$date = elgg_view_friendly_time($editorial->time_created);

// The "on" status changes for comments, so best to check for !Off
if ($editorial->comments_on != 'Off') {
	$comments_count = $editorial->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $editorial->getURL() . '#editorial-comments',
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
	'handler' => 'editorial',
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
		'value' => $editorial->description,
		'class' => 'editorial-post',
	));

	$header = elgg_view_title($editorial->title);

	$params = array(
		'entity' => $editorial,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	$editorial_info = elgg_view_image_block($owner_icon, $list_body);

	echo <<<HTML
$header
$editorial_info
$body
HTML;

} else {
	// brief view

	$params = array(
		'entity' => $editorial,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($owner_icon, $list_body);
}
