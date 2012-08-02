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
if ($vars['entity']->canAnnotate(0, 'likes') && !$vars['inactive']) {
	if (!elgg_annotation_exists($guid, 'likes')) {
		$url = elgg_get_site_url() . "action/likes/add?guid={$guid}";
		$params = array(
			'href' => $url,
			'text' => $vars['slide_view'] ? elgg_view('input/thumbs/up-left-normal') : elgg_view('input/thumbs/up-right-normal'),
			'title' => elgg_echo('likes:likethis'),
			'is_action' => true,
            'data-pub' => $pubstring,
		);
		$likes_button = elgg_view('output/url', $params);
	} else {
		$url = elgg_get_site_url() . "action/likes/delete?guid={$guid}";
		$params = array(
			'href' => $url,
            'text' => $vars['slide_view'] ? elgg_view('input/thumbs/up-left-selected') : elgg_view('input/thumbs/up-right-selected'),
			'title' => elgg_echo('likes:remove'),
			'is_action' => true,
            'data-pub' => $pubstring,
		);
		$likes_button = elgg_view('output/url', $params);
	}
}elseif($vars['inactive']){
    $params = array(
        'href' => "#",
        'text' => $vars['slide_view'] ? elgg_view('input/thumbs/up-left-normal') : elgg_view('input/thumbs/up-right-normal'),
        'is_action' => false,
    );
    $likes_button = elgg_view('output/url', $params);
}

if($vars['slide_view']){    
    $likes_button = str_replace("<a", "<span", $likes_button);
    $likes_button = str_replace("</a", "</span", $likes_button);
}

echo $likes_button;