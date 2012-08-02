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

if(!elgg_in_context("channelsadmin")){    
    $entity = $vars['entity'];
//    $img_src = $entity->getIconURL("large");
//    $params['entity'] = $vars['entity'];
//    $params['size'] = "small";
    $img_src = elgg_trigger_plugin_hook('entity:icon:url', 'group', $vars);
    $img = "<img src=\"$img_src\" alt=\"$title\" />";

    echo elgg_view('output/url', array(
        'href' => $vars['href'],
        'text' => $img,
        'data-channelguid' => $entity->guid,
    ));    
}else{
    $icon = elgg_view_entity_icon($vars['entity'], 'small');

    $title = $vars['entity']->title;
    if (!$title) {
        $title = $vars['entity']->name;
    }
    if (!$title) {
        $title = get_class($vars['entity']);
    }

    if (elgg_instanceof($vars['entity'], 'object')) {
        $metadata = elgg_view('navigation/menu/metadata', $vars);
    }

    $owner_link = '';
    $owner = $vars['entity']->getOwnerEntity();
    if ($owner) {
        $owner_link = elgg_view('output/url', array(
            'href' => $owner->getURL(),
            'text' => $owner->name,
        ));
    }

    $params = array(
        'entity' => $vars['entity'],
        'title' => $title,
        'metadata' => $metadata,
        'subtitle' => $subtitle,
        'tags' => $vars['entity']->tags,
    );
    $params = $params + $vars;
    $body = elgg_view('object/elements/summary', $params);

    echo elgg_view_image_block($icon, $body);

}