<?php
/**
 * segment sidebar
 *
 * @package Segment
 */

 
/* fetch & display latest comments
if ($vars['page'] == 'all') {
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'segment',
	));
} elseif ($vars['page'] == 'owner') {
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'segment',
		'owner_guid' => elgg_get_page_owner_guid(),
	));
}*/


// only users can have archives at present
if (elgg_instanceof(elgg_get_page_owner_entity(), 'user')) {
	echo elgg_view('segment/sidebar/archives', $vars);
}

if ($vars['page'] != 'friends') {
    echo elgg_view('page/elements/tagcloud_block', array(
        'subtypes' => 'segment',
        'page' => $vars['page'],
        //'owner_guid' => elgg_get_page_owner_guid(),
    ));
	echo elgg_view('page/elements/eventcloud_block', array(
		'subtypes' => 'segment',
        'page' => $vars['page'],
		//'owner_guid' => elgg_get_page_owner_guid(),
	));
}
