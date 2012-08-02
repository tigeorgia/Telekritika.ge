<?php
/**
 * Elgg likes button
 *
 * @uses $vars['entity']
 */

if (!isset($vars['entity']) || !$vars['entity'] instanceof ElggSegment || !elgg_is_admin_logged_in()) {
    return true;
}

$segment = $vars['entity'];
$guid = $segment->getGUID();

$pubstring = prep_pipe_string(array("segment.approve.".$guid));

// check to see if the segment has been approve
if ($segment->status != "published") {
    $url = elgg_get_site_url() . "action/segment/approve?guid={$guid}";
    $params = array(
        'href' => $url,
        'text' => elgg_view_icon('thumbs-up-alt'),
        'title' => elgg_echo('segment:approve'),
        'is_action' => true,
        'data-pub' => $pubstring,
    );
    $approve_button = elgg_view('output/url', $params);
}

//echo "<script>alert('".$approve_button."');</script>";
echo $approve_button;