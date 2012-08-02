<?php
/**
 * Elgg likes button
 *
 * @uses $vars['entity']
 */

$onlyjsstring = prep_pipe_string(array("mustlogin"));

$params = array(
	'href' => "#",
	'text' => $vars['slide_view'] ? elgg_view('input/thumbs/up-left-normal') : elgg_view('input/thumbs/up-right-normal'),
	'title' => elgg_echo('likes:likethis'),
	'is_action' => false,
    'data-onlyjs' => $onlyjsstring,
);
$likes_button = elgg_view('output/url', $params);

if($vars['slide_view']){    
    $likes_button = str_replace("<a", "<span", $likes_button);
    $likes_button = str_replace("</a", "</span", $likes_button);
}


echo $likes_button;
