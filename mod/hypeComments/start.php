<?php

/* hypeComments
 *
 * Comments
 * Likes
 *
 * @package hypeJunction
 * @subpackage hypeComments
 *
 * @author Ismayil Khayredinov <ismayil.khayredinov@gmail.com>
 * @copyright Copyrigh (c) 2011, Ismayil Khayredinov
 */

elgg_register_event_handler('init', 'system', 'hj_comments_init');

/**
 * Initialize hypeComments
 */
function hj_comments_init() {
    
    $plugin = 'hypeComments';
    
    if (!elgg_is_active_plugin('hypeFramework')) {
        register_error(elgg_echo('hj:framework:disabled', array($plugin, $plugin)));
        disable_plugin($plugin);
    }
    $shortcuts = hj_framework_path_shortcuts($plugin);
    
   // Actions for Comments
    elgg_register_action('hjcomments/get', $shortcuts['actions'] . 'hj/comments/get.php');
    elgg_register_action('hjcomments/save', $shortcuts['actions'] . 'hj/comments/save.php');
    elgg_register_action('hjcomments/delete', $shortcuts['actions'] . 'hj/comments/delete.php');
    // Actions for Likes
    elgg_register_action('hjlikes/get', $shortcuts['actions'] . 'hj/likes/get.php');
    elgg_register_action('hjlikes/save', $shortcuts['actions'] . 'hj/likes/save.php');
    elgg_register_action('hjlikes/delete', $shortcuts['actions'] . 'hj/likes/delete.php');

    // Register JS and CSS libraries
    $css_url = elgg_get_simplecache_url('css', 'hj/comments/bar');
    elgg_register_css('hj.comments.bar', $css_url);

    $js_generic_url = elgg_get_simplecache_url('js', 'hj/comments/base');
    elgg_register_js('hj.comments.base', $js_generic_url);

    // Register a hook to replace Elgg comments with hypeComments
    elgg_register_plugin_hook_handler('comments', 'all', 'hj_comments_replacement');
    
    // Unregister entity menu items to avoid duplication of likes and comments
    elgg_unregister_plugin_hook_handler('register', 'menu:river', 'elgg_river_menu_setup');
    elgg_unregister_plugin_hook_handler('register', 'menu:entity', 'likes_entity_menu_setup');
    elgg_unregister_plugin_hook_handler('register', 'menu:river', 'likes_river_menu_setup');
}

/**
 *  Replaces native Elgg comments with hypeComments
 */
function hj_comments_replacement($hook, $entity_type, $returnvalue, $params) {
    return elgg_view('hj/comments/bar', $params);
}