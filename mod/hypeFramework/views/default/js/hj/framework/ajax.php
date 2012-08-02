<?php
/**
 * Javascript library to AJAXify hJ
 * 
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category AJAX
 * @category Menu
 * @category Javascript
 * 
 */
?><?php
//Fancybox
$js_path = elgg_get_config('path');
$js_path = "{$js_path}vendors/jquery/fancybox/jquery.fancybox-1.3.4.pack.js";
include $js_path;
?>
    elgg.provide('hj.framework.ajax.base');
       
    hj.framework.ajax.base.init = function() {
    
        window.loader = '<div class="hj-ajax-loader hj-loader-circle"></div>';
               
        $('.hj-ajaxed-add')
        .unbind('click')
        .bind('click', hj.framework.ajax.base.view);
        
        $('.hj-ajaxed-edit')
        .unbind('click')
        .bind('click', hj.framework.ajax.base.view);
        
        $('.hj-ajaxed-remove')
        .die()
        .bind('click', hj.framework.ajax.base.remove);
    
        $('.hj-ajaxed-save')
        .attr('onsubmit','')
        .unbind('submit')
        .bind('submit', hj.framework.ajax.base.save);
        
        $('.hj-ajaxed-refresh')
        .unbind('click')
        .bind('click', hj.framework.ajax.base.view);
        
        $('.hj-ajaxed-addwidget')
        .unbind('click')
        .bind('click', hj.framework.ajax.base.addwidget);
        
        $('.elgg-widget-edit > form')
        .die()
        .bind('submit', hj.framework.ajax.base.reloadwidget);
        
        $('.hj-ajaxed-gallery')
        .fancybox();
        
        if ($('.elgg-input-date').length) {
            elgg.ui.initDatePicker();
	}
        
    }

    hj.framework.ajax.base.view = function(event) {
        event.preventDefault();

        var action = $(this).attr('href');
        var targetContainer = $(this).attr('target');
        var tempContainer = targetContainer+'-temp';    
        var rel = $(this).attr('rel');
        
        $(tempContainer)
        .html('')
        .removeClass();
        
        if (rel == 'fancybox') {
            $.fancybox({
                content : window.loader
            });
        } else {
            $(targetContainer)
            .fadeIn()
            .html(window.loader);
        }
        
        elgg.action(action, {
            success : function(output) {
                if (rel == 'fancybox') {
                    $.fancybox({ 
                        content : output.data,
                        autoDimensions : false,
                        width : '400',
                        height : '400',
                        onComplete : function() {
                            elgg.trigger_hook('success', 'hj:framework:ajax');
                        }
                    });
                    $.fancybox.resize();
                } else {
                    $(targetContainer)
                    .slideDown(800)
                    .html(output.data);
                    elgg.trigger_hook('success', 'hj:framework:ajax');

                }
            }
        });
        
        
        
    }
    hj.framework.ajax.base.remove = function(event) {
        var action = $(this).attr('href');
        var subjectGuid = $(this).attr('id').replace('hj-ajaxed-remove-', '');
        var targetContainer = $('#elgg-object-'+subjectGuid);     
        var confirmText = $(this).attr('rel') || elgg.echo('question:areyousure');
        
        if (!subjectGuid.length) {
            return true;
        }

        $(this).attr('rel', '');
        $(this).attr('confirm', '');
                      
        event.preventDefault();    
        
        
        if (confirm(confirmText)) {
            elgg.action(action, {
                success : function(output) {
                    $(targetContainer)
                    .fadeOut(800, function() {
                        $(this).remove()
                    });
                }
            });

        }
    }
    
    hj.framework.ajax.base.save = function(event) {        
        event.preventDefault();
        
        var values = $(this).serialize();

        var action = $(this).attr('action');
        var actionType = $('input[name="ev"]').val();
        var target = $(this).attr('target');
        var tempContainer = target+'-temp';
        var formContainer = target+'-add';

        if (hj.framework.fieldcheck.init($(this))) {
            
            $.fancybox({
                content : window.loader
            });
            $.fancybox.resize();
            
            elgg.action(action, {
                data : values,
                success : function(output) {               
                    $.fancybox.close();    
                    if (actionType == 'update') {
                        $(target)
                        .fadeIn()
                        .html(output.data);
                    } else {
                        $(formContainer)
                        .fadeOut();
                        $(tempContainer)
                        .addClass('hj-active-temp')
                        .find('span.hj-append-after')
                        .after(output.data);
                    }
                    
                    elgg.trigger_hook('success', 'hj:framework:ajax');
                }
            });
        } else {
            event.preventDefault();
        }
        
    }
    
    hj.framework.ajax.base.addwidget = function(event) {
        event.preventDefault();
        var action = $(this).attr('href');
        
	elgg.action(action, {
            success: function(json) {
                $('#elgg-widget-col-1').prepend(json.output);
                elgg.trigger_hook('success', 'hj:framework:ajax');
            }
	});
    }
    
    hj.framework.ajax.base.reloadwidget = function(event) { 
        event.preventDefault();
        
        var action = $(this).attr('action');
        var widgetGuid = $('input[name="guid"]', $(this)).val();
        
        var sourceContainer = $('#elgg-widget-'+widgetGuid);
        
        $(sourceContainer)
        .removeClass()
        .wrap('<div></div>')
        .html(window.loader);
        
        elgg.action(action, {
            data : $(this).serialize(),
            success : function() {
                elgg.action('action/framework/widget/load', {
                    data : { 
                        e : widgetGuid
                    },
                    success : function(output) {
                        $(sourceContainer)
                        .parent('div')
                        .slideDown(800)
                        .html(output.data);
                        elgg.trigger_hook('success', 'hj:framework:ajax');

                    }
                });
            }
        });
    }
        
    elgg.register_hook_handler('init', 'system', hj.framework.ajax.base.init);
    elgg.register_hook_handler('success', 'hj:framework:ajax', elgg.ui.widgets.init, 200);
    elgg.register_hook_handler('success', 'hj:framework:ajax', hj.framework.ajax.base.init, 500);
    
    