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

//    if(elgg_is_logged_in()){
        echo elgg_view('output/url', array(
            'href' => $vars['href'],
            'text' => $img,
            'data-guid' => !$vars['main'] ? $entity->guid : false,
            'data-noform' => !$vars['main'] ? "true" : false,
            'data-pub' => !$vars['main'] ? prep_pipe_string(array("cv.addmodule.{$entity->guid}")) : false,        
            'data-condjs' => !$vars['main'] ? prep_pipe_string(array("mod_amt")) : false,        
            'data-vars' => !$vars['main'] ? implode(",", array("lastkeyword", "lastdate")) : false,        
        ));    
/*    }else{
        echo elgg_view('output/url', array(
            'href' => $vars['href'],
            'text' => $img,
            'data-guid' => $entity->guid,
            'data-onlyjs' => prep_pipe_string(array("mustlogin")),        
            'data-vars' => implode(",", array("lastkeyword", "lastdate")),        
        ));    
    }
 */
}else{
    $icon = elgg_view_entity_icon($vars['entity'], 'medium');

//    $url = $vars['entity']->getURL();
    $url = "edit/{$vars['entity']->getGUID()}";
    $title = $vars['entity']->title;
    if (!$title) {
        $title = $vars['entity']->name;
    }
    if (!$title) {
        $title = get_class($vars['entity']);
    }

    $title = "EDIT: " . $title;
    $params = array(
        'entity' => $vars['entity'],
        'title' => $title,
        'subtitle' => $subtitle,
    );
    $params = $params + $vars;
    $body = "<a href=\"$url\">$title</a>";

    echo elgg_view_image_block($icon, $body);

}
