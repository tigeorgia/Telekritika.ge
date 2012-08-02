<?php
/**
 * Elgg likes button
 *
 * @uses $vars['entity']
 */

$onlyjsstring = prep_pipe_string(array("mustlogin"));

$params = array(
    'href' => "#",
    'text' => elgg_view('input/thumbs/up-right-normal'),
    'title' => elgg_echo("likes:add"),
    'is_action' => false,
    'data-onlyjs' => $onlyjsstring,
);
$likes_button = elgg_view('output/url', $params);

echo $likes_button;