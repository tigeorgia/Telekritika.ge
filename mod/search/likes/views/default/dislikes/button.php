<?php
/**
 * Elgg likes button
 *
 * @uses $vars['entity']
 */

if (!isset($vars['entity'])) {
	return true;
}

$guid = $vars['entity']->getGUID();
$pubstrings = array("likes.object.".$guid);
$pubstring = prep_pipe_string($pubstrings);

// check to see if the user has already liked this
if (elgg_is_logged_in() && $vars['entity']->canAnnotate(0, 'dislikes')) {
	if (!elgg_annotation_exists($guid, 'dislikes')) {
		$url = elgg_get_site_url() . "action/dislikes/add?guid={$guid}";
        $params = array(
			'href' => $url,
			'text' => elgg_view_icon('thumbs-down'),
			'title' => elgg_echo('dislikes:dislikethis'),
			'is_action' => true,
            'data-pub' => $pubstring,
		);
		$dislikes_button = elgg_view('output/url', $params);
	} else {
		$url = elgg_get_site_url() . "action/dislikes/delete?guid={$guid}";
		$params = array(
			'href' => $url,
			'text' => elgg_view_icon('thumbs-down-alt'),
			'title' => elgg_echo('dislikes:remove'),
			'is_action' => true,
            'data-pub' => $pubstring,
		);
		$dislikes_button = elgg_view('output/url', $params);
	}
}

echo $dislikes_button;
