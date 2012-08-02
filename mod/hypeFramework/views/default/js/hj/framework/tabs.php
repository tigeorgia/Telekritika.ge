<?php
/**
 * Javascript library to AJAXify tabs
 * 
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category AJAX
 * @category Tabs
 * @category Javascript
 * 
 */
?>
    elgg.provide('hj.framework.tabs');

    hj.framework.tabs.init = function() {
        $('.hj-ajax-tab-load')
        .unbind('.ajaxTabLoad')
        .bind('click.ajaxTabLoad', hj.framework.tabs.load);

        $('ul.hj-ajax-tabs li.elgg-state-selected')
        .trigger('click.ajaxTabLoad');

        
    }

    hj.framework.tabs.load = function(event) {

        var action = $(this).find('a').attr('href');
        var target = $(this).attr('target');
        var loader = '<div class="hj-ajax-loader hj-loader-circle"></div>';

        $(target).show().html(loader);
        $('li', $(this).parent('ul')).removeClass('elgg-state-selected');
        $(this).addClass('elgg-state-selected');

        elgg.action(action, {
            success : function(output) {
                $(target).html(output.data);
                elgg.trigger_hook('success', 'hj:framework:ajax');

            }
        });

        event.preventDefault();

    }

    elgg.register_hook_handler('init', 'system', hj.framework.tabs.init);
    // elgg.register_hook_handler('success', 'hj:framework:ajax', hj.framework.tabs.init);