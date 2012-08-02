<?php
/**
 * Elgg likes button
 *
 * @uses $vars['entity']
 */

if (!elgg_is_logged_in() || !isset($vars['annotation'])) {
	return true;
}

$comment = $vars['annotation'];
$deladd = $vars['deladd'];
$guid = $comment->id;

$pubstrings = array("likes.annotation.".$guid);
$pubstring = prep_pipe_string($pubstrings);

$url = elgg_get_site_url() . "action/dislikes/{$deladd}dislikecomment?annotation_id={$guid}";
$params = array(
    'href' => $url,
    'text' => ($deladd == "delete")?elgg_view_icon('thumbs-down-alt'):elgg_view_icon('thumbs-down'),
    'title' => elgg_echo("dislikes:{$deladd}"),
    'is_action' => true,
    'data-pub' => $pubstring,
);
$dislikes_button = elgg_view('output/url', $params);

echo $dislikes_button;