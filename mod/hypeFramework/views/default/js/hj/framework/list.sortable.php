    
elgg.provide('hj.framework.list.sortable');

    hj.framework.list.sortable.init = function () {
        $('#hj-section > ul.hj-ajaxed').sortable({
            items:                'li:has(> .elgg-state-draggable)',
            cursor:               'move',
            //cursorAt:             'top',
            forcePlaceholderSize: true,
            placeholder:          'elgg-widget-placeholder',
            opacity:              0.8,
            revert:               100,
            stop:                 hj.framework.list.sortable.moveItem
        });
    }
    
    hj.framework.list.sortable.moveItem = function(event, ui) {
        var priorities = $('#hj-section > ul.hj-ajaxed').sortable("toArray");
        
        elgg.action('action/framework/entities/move', {
            data: {
                priorities: priorities
            }
        });
    };
    
    elgg.register_hook_handler('init', 'system', hj.framework.list.sortable.init);
    elgg.register_hook_handler('success', 'hj:framework:ajax', hj.framework.list.sortable.init);
