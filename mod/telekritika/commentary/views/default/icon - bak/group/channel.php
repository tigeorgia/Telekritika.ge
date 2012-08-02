<?php
/**
 * Generic icon view.
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['entity'] The entity the icon represents - uses getIconURL() method
 * @uses $vars['size']   topbar, tiny, small, medium (default), large, master
 * @uses $vars['href']   Optional override for link
 */

if(elgg_in_context("channelbar")){    
    $entity = $vars['entity'];
    $img_src = $entity->getIconURL("large");
    $img = "<img src=\"$img_src\" alt=\"$title\" />";
    echo $img;
}else{
    $entity = $vars['entity'];

    $sizes = array('small', 'medium', 'large', 'tiny', 'master', 'topbar');
    // Get size
    $vars['size'] = "medium";

    if (isset($entity->name)) {
	    $title = $entity->name;
    } else {
	    $title = $entity->title;
    }

    $url = $entity->getURL();
    if (isset($vars['href'])) {
	    $url = $vars['href'];
    }

    $img_src = $entity->getIconURL($vars['size']);
    $img = "<img src=\"$img_src\" alt=\"$title\" />";

    if ($url && elgg_is_admin_logged_in()) {
        echo elgg_view('output/url', array(
            'href' => $url,
            'text' => $img,
            'data-channelguid' => $entity->guid,
        ));
    } elseif($url) {
        echo elgg_view('output/url', array(
            'href' => "#",
            'text' => $img,
            'data-channelguid' => $entity->guid,
        ));    
    } else {
        echo $img;
    }
}