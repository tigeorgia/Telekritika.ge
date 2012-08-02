<?php
/**
 * Elgg likes button
 *
 * @uses $vars['entity']
 */

$onlyjsstring = prep_pipe_string(array("mustlogin"));

$params = array(
    'href' => "#",
    'text' => elgg_view('input/thumbs/down-left-normal'),
    'title' => elgg_echo("dislikes:add"),
    'is_action' => false,
    'data-onlyjs' => $onlyjsstring,
);
$dislikes_button = elgg_view('output/url', $params);

echo $dislikes_button;