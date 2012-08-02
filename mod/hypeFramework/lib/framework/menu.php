<?php

/**
 * Various Menu Hook Handlers
 * 
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category AJAX
 * @category Menu
 * @category Object
 * 
 */
?><?php

/**
 * Hook handler for menu:hjentityhead
 * Header menu of an entity
 * By default, contains Edit and Delete buttons
 *      Edit button loads ajax and replaces entity content in <div id="elgg-object-{$guid}">
 *      Delete button sends an ajax request and on success removes <div id="elgg_object_{$guid}">
 * 
 * 
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return array
 * 
 * @tip $params needs to contain $params['is_hj_menu'] to check if the calling entity is part of the hypeJunction bundle
 * @tip $params needs to contain $params['hj_params'] an array of 
 *      $e ElggEntity subject entity
 *      $c ElggEntity container entity
 *      $o ElggEntity owner entity
 *      $f hjForm form entity / data pattern
 *      $cx string current context 
 */
function hj_framework_entity_head_menu($hook, $type, $return, $params) {

    // Extract available parameters
    $entity = elgg_extract('entity', $params);
    $handler = elgg_extract('handler', $params);
    $viewtype = elgg_extract('viewtype', $params);
    $url_params = elgg_extract('url_params', $params['params']);
    $url = http_build_query($url_params);

    if ($entity && elgg_instanceof($entity) && $entity->canEdit()) {

        if ($viewtype == 'gallery') {
            $fullview = array(
                'name' => 'fullview',
                'title' => elgg_echo('hj:framework:gallerytitle', array($entity->title)),
                'text' => elgg_view_icon('hj hj-icon-zoom'),
                'rel' => 'hj-gallery',
                'class' => 'hj-ajaxed-gallery',
                'href' => "#hj-gallery-{$entity->guid}",
                'priority' => 300,
            );
            $return[] = ElggMenuItem::factory($fullview);
            if ($handler == 'hjfile') {
                $file_guid = elgg_extract('file_guid', $params);
                $download = array(
                    'name' => 'download',
                    'title' => elgg_echo('hj:framework:download'),
                    'text' => elgg_view_icon('hj hj-icon-download'),
                    'id' => "hj-ajaxed-download-{$file_guid}",
                    'href' => "hj/file/download/{$file_guid}/",
                    'target' => '_blank',
                    'priority' => 500,
                );
                $return[] = ElggMenuItem::factory($download);
            }
        }

        // AJAXed Edit Button
        $edit = array(
            'name' => 'edit',
            'title' => elgg_echo('hj:framework:edit'),
            'text' => elgg_view_icon('hj hj-icon-edit'),
            'rel' => 'fancybox',
            'href' => "action/framework/entities/edit?{$url}",
            'id' => "hj-ajaxed-edit-{$entity->guid}",
            'class' => "hj-ajaxed-edit",
            'target' => "#elgg-object-{$entity->guid}",
            'priority' => 800
        );
        $return[] = ElggMenuItem::factory($edit);

        // AJAXed Delete Button
        $delete = array(
            'name' => 'delete',
            'title' => elgg_echo('hj:framework:delete'),
            'text' => elgg_view_icon('hj hj-icon-delete'),
            'href' => "action/framework/entities/delete?{$url}",
            'id' => "hj-ajaxed-remove-{$entity->guid}",
            'class' => 'hj-ajaxed-remove',
            'target' => "#elgg-object-{$entity->guid}",
            'priority' => 900,
        );
        $return[] = ElggMenuItem::factory($delete);
    }
    return $return;
}

/**
 * Hook handler for menu:hjentityfoot
 * Footer menu of an entity
 * By default, contains a full_view of an element in a hidden div
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return array 
 */
function hj_framework_entity_foot_menu($hook, $type, $return, $params) {
    $entity = elgg_extract('entity', $params);
    $viewtype = elgg_extract('viewtype', $params);
    $handler = elgg_extract('handler', $params);
    $extras = elgg_extract('extras', $params);

    if ($viewtype != 'gallery') {
        $fullview = array(
            'name' => 'fullview',
            'title' => elgg_echo('hj:framework:fullview'),
            'text' => elgg_view_icon('hj hj-icon-info') . '<span class="hj-icon-text">' . elgg_echo('hj:framework:fullview') . '<span>',
            'id' => "hj-ajaxed-toggle-fullview-{$entity->guid}",
            'href' => "#hj-fullview-{$entity->guid}",
            'rel' => 'toggle',
            'priority' => 300,
        );
        $return[] = ElggMenuItem::factory($fullview);

        if ($handler == 'hjfile') {
            $file_guid = elgg_extract('file_guid', $extras);
            $download = array(
                'name' => 'download',
                'title' => elgg_echo('hj:framework:download'),
                'text' => elgg_view_icon('hj hj-icon-download') . '<span class="hj-icon-text">' . elgg_echo('hj:framework:download') . '<span>',
                'id' => "hj-ajaxed-download-{$file_guid}",
                'href' => "hj/file/download/{$file_guid}/",
                'target' => '_blank',
                'priority' => 500,
            );
            $return[] = ElggMenuItem::factory($download);
        }
    }

    return $return;
}

/**
 * Hook handler for menu:hjsectionhead
 * Contains a sectional menu
 * By default, contains Add and Refresh
 *      Add button - loads a form to add a new element
 *      Refresh button - reloads section content
 * 
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return array
 * 
 * - $c - container entity
 * - $o - owner entity
 * - $f - form entity
 * - $cx - context
 * - $sn - section name
 * 
 */
function hj_framework_segment_head_menu($hook, $type, $return, $params) {

    // Extract available parameters
    $entity = elgg_extract('entity', $params);
    $obj_params = elgg_extract('params', $params['params'], array());
    $container = elgg_extract('container', $obj_params);
    $section = elgg_extract('subtype', $obj_params);
    $obj_handler = elgg_extract('handler', $obj_params);

    $url_params = elgg_extract('url_params', $params['params']);
    $url = http_build_query($url_params);

    if (elgg_instanceof($entity, 'object', 'hjsegment') && $container->canEdit()) {

        
        // AJAXed Edit Button
        $edit = array(
            'name' => 'edit',
            'title' => elgg_echo('hj:framework:edit'),
            'text' => elgg_view_icon('hj hj-icon-edit'),
            'href' => "action/framework/entities/edit?{$url}",
            //'is_action' => true,
            'id' => "hj-ajaxed-edit-{$entity->guid}",
            'class' => "hj-ajaxed-edit",
            'target' => "#elgg-object-{$entity->guid}",
            'priority' => 800
        );
        $return[] = ElggMenuItem::factory($edit);

        // AJAXed Delete Button
        $delete = array(
            'name' => 'delete',
            'title' => elgg_echo('hj:framework:delete'),
            'text' => elgg_view_icon('hj hj-icon-delete'),
            'href' => "action/framework/entities/delete?{$url}",
            //'is_action' => true,
            'id' => "hj-ajaxed-remove-{$entity->guid}",
            'class' => 'hj-ajaxed-remove',
            'target' => "#elgg-object-{$entity->guid}",
            'priority' => 900,
        );
        $return[] = ElggMenuItem::factory($delete);
    }

    return $return;
}

/**
 * Hook handler for menu:hjsectionfoot
 * Contains a sectional menu
 * By default, contains Add and Refresh
 *      Add button - loads a form to add a new element
 *      Refresh button - reloads section content
 * 
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return array
 * 
 * - $c - container entity
 * - $o - owner entity
 * - $f - form entity
 * - $cx - context
 * - $sn - section name
 * 
 */
function hj_framework_section_foot_menu($hook, $type, $return, $params) {

    // Extract available parameters
    $obj_params = elgg_extract('params', $params['params'], array());
    $container = elgg_extract('container', $obj_params);
    $section = elgg_extract('subtype', $obj_params);
    $widget = elgg_extract('widget', $obj_params);

    $url_params = elgg_extract('url_params', $params['params']);
    $url = http_build_query($url_params);

    if ($container && elgg_instanceof($container) && $container->canEdit()) {

        // AJAXed Add Button
        $add = array(
            'name' => 'add',
            'title' => elgg_echo('hj:framework:addnew'),
            'text' => elgg_view_icon('hj hj-icon-add') . '<span class="hj-icon-text">' . elgg_echo('hj:framework:addnew') . '</span>',
            'href' => "action/framework/entities/edit?{$url}",
            'is_action' => true,
            'rel' => 'fancybox',
            'id' => "hj-ajaxed-add-{$section}",
            'class' => "hj-ajaxed-add",
            'target' => "#elgg-widget-{$widget->guid} #hj-section-{$section}-add",
            'priority' => 200
        );
        $return[] = ElggMenuItem::factory($add);

        // AJAXed Refresh Button
        $refresh = array(
            'name' => 'refresh',
            'title' => elgg_echo('hj:framework:refresh'),
            'text' => elgg_view_icon('hj hj-icon-refresh') . '<span class="hj-icon-text">' . elgg_echo('hj:framework:refresh') . '</span>',
            'href' => "action/framework/entities/view?{$url}",
            'is_action' => true,
            'id' => "hj-ajaxed-refresh-{$section}",
            'class' => "hj-ajaxed-refresh",
            'target' => "#elgg-widget-{$widget->guid} #hj-section-{$section}",
            'priority' => 300
        );
        $return[] = ElggMenuItem::factory($refresh);
    }

    return $return;
}