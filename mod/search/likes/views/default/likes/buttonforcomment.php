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

$url = elgg_get_site_url() . "action/likes/{$deladd}likecomment?annotation_id={$guid}";
$params = array(
    'href' => $url,
    'text' => ($deladd == "delete")?elgg_view_icon('thumbs-up-alt'):elgg_view_icon('thumbs-up'),
    'title' => elgg_echo("likes:{$deladd}"),
    'is_action' => true,
    'data-pub' => $pubstring,
    
);
$likes_button = elgg_view('output/url', $params);

echo $likes_button;