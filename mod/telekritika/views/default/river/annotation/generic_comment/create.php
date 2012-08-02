<?php
/**
 * Post comment river view
 */
$object = $vars['item']->getObjectEntity();
$comment = $vars['item']->getAnnotation();
$comment_info = @json_decode($comment->value, true);

$theexcerpt = (is_array($comment_info))?$comment_info['originalvalue']:$comment->value;

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => elgg_get_excerpt($theexcerpt),
));
