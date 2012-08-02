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
$pubstrings = array("likes.{$vars['entity']->getSubType()}.$guid");
$pubstring = prep_pipe_string($pubstrings);

// check to see if the user has already liked this
if ($vars['entity']->canAnnotate(0, 'dislikes') && !$vars['inactive']) {
	if (!elgg_annotation_exists($guid, 'dislikes')) {
		$url = elgg_get_site_url() . "action/dislikes/add?guid={$guid}";
        $params = array(
			'href' => $url,
			'text' => $vars['slide_view'] ? elgg_view('input/thumbs/down-right-normal') : elgg_view('input/thumbs/down-left-normal'),
			'title' => elgg_echo('dislikes:dislikethis'),
			'is_action' => true,
            'data-pub' => $pubstring,
		);
		$dislikes_button = elgg_view('output/url', $params);
	} else {
		$url = elgg_get_site_url() . "action/dislikes/delete?guid={$guid}";
		$params = array(
			'href' => $url,
			'text' => $vars['slide_view'] ? elgg_view('input/thumbs/down-right-selected') : elgg_view('input/thumbs/down-left-selected'),
			'title' => elgg_echo('dislikes:remove'),
			'is_action' => true,
            'data-pub' => $pubstring,
		);
		$dislikes_button = elgg_view('output/url', $params);
	}
}elseif($vars['inactive']){
    $params = array(
        'href' => "#",
        'text' => $vars['slide_view'] ? elgg_view('input/thumbs/down-right-normal') : elgg_view('input/thumbs/down-left-normal'),
        'is_action' => false,
    );
    $dislikes_button = elgg_view('output/url', $params);
}
if($vars['slide_view']){    
    $dislikes_button = str_replace("<a", "<span", $dislikes_button);
    $dislikes_button = str_replace("</a", "</span", $dislikes_button);
}

echo $dislikes_button;
