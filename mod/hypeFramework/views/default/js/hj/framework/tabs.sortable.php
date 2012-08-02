    
elgg.provide('hj.framework.tabs.sortable');

    hj.framework.tabs.sortable.init = function () {
        $('#hj-sortable-tabs > ul').sortable({
            items:                'li:has(> .elgg-state-draggable)',
            axis:                 'x',
            cursor:               'move',
            //cursorAt:             'top',
            forcePlaceholderSize: true,
            placeholder:          'elgg-widget-placeholder',
            opacity:              0.8,
            revert:               100,
            stop:                 hj.framework.tabs.sortable.moveTab
        });
    }
    
    hj.framework.tabs.sortable.moveTab = function(event, ui) {
        var priorities = $('#hj-sortable-tabs > ul').sortable("toArray");
        
        elgg.action('action/framework/entities/move', {
            data: {
                priorities: priorities
            }
        });
    };
    
    elgg.register_hook_handler('init', 'system', hj.framework.tabs.sortable.init);
    elgg.register_hook_handler('success', 'hj:framework:ajax', hj.framework.tabs.sortable.init);