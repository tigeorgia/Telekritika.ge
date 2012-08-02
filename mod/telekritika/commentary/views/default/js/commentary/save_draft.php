<?php
/**
 * Save draft through ajax
 *
 * @package Commentary
 */
?>
elgg.provide('elgg.commentary');

elgg.commentary.init = function() {

    lastdate = '<?=date("Y-m-d", strtotime("yesterday"));?>';
    lastkeyword = '';        

    jQuery('.elgg-channelbar-item a').click(function(e){
        e.preventDefault();
        var amtcheck = jQuery('#cv_segmentselect_module_holder > .channelviewer_module').length;
        if(amtcheck < <?=$CONFIG->maxChannelsInChannelViewer;?>){
            var self = jQuery(this);
            var channelguid = self.data('channelguid');
            elgg.action('cv_segmentselect_module', {
                data: {
                      channel_guid: channelguid,
                      keyword: lastkeyword,
                      requested_date: lastdate,
                  },
                  success: function(json){
                    create_module(json.output);
                  },        
            });
        }else{
            elgg.register_error(elgg.echo('commentary:toomanychannels'));
        }
    });
        
    jQuery('input[placeholder], textarea[placeholder]').placeholder();
    
};

function create_module(html){
    var module = jQuery(html).css('display', 'none');
    module.prependTo('#cv_segmentselect_module_holder')
        .fadeIn('slow');
    jQuery('.cv_datepicker', module).val(lastdate);
    cv_closeModuleInit(module);
    cv_accordionModuleInit(module);
    cv_autocompleteModuleInit(module);
    cv_datepickerModuleInit(module);
    cv_show_allModuleInit(module);
}

function cv_remove_module(module){
    var conf = confirm(elgg.echo('deleteconfirm'));
    if(conf)module.fadeOut('slow', function(){
        module.remove();
        cv_assessHiddenSegments();
    });
}

function cv_closeModuleInit(module){
    jQuery('.close_module', module).click(function(e){
        e.preventDefault();
        var module = jQuery(this).parent();
        cv_remove_module(module);
    });
}

function cv_show_allModuleInit(module){
    jQuery('.show_all_segments', module).click(function(e){
        e.preventDefault();
        var accordion = jQuery('.ui-accordion', module);
        if(accordion){
            accordion.accordion("destroy");
            jQuery('.cv_header', module)
                .addClass('ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top');
            jQuery('.cv_content', module)
                .addClass('ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active');
            accordion.parent().css('overflow', 'auto');
            cv_assessHiddenSegments();
        }
    });
}

function cv_accordionModuleInit(module){
    jQuery(module).delegate('.cv_header, .cv_content', 'click', function(e){
        var clicktarget = jQuery(this);
        if(!jQuery(e.target).hasClass('videolink')){
            e.preventDefault();
        }
        var accordion = clicktarget.parents('.accordion');
        var activeIndex = cv_getAccordionIndex(accordion, clicktarget);    

        //if not yet accordionized
        if(!accordion.hasClass("ui-accordion")){
            cv_createAccordion(accordion, activeIndex);
        }else{
        //is accordionized
            
        }
    }).delegate('input', 'keypress', function(e){
        if (e.keyCode == 13){ e.preventDefault();jQuery('.cv_keyword').autocomplete( "close" );jQuery(this).change(); }
    });
}

function cv_getAccordionIndex(accordion, clicktarget){
    if(clicktarget.is('.cv_header')){
        var index = jQuery(".cv_header", accordion).index(clicktarget);
    };
    if(clicktarget.is('.cv_content')){
        var index = jQuery(".cv_content", accordion).index(clicktarget);
    };
    return index;
}

function cv_createAccordion(accordion, activeIndex){
    accordion.parent().css('overflow', 'hidden');
    jQuery('.cv_header', accordion).removeClass('ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top');
    jQuery('.cv_content', accordion).removeClass('ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active');
    accordion.accordion({
        active: activeIndex, 
        collapsible: true, 
        fillSpace: true,
        create: function(event, ui){
            cv_assessHiddenSegments();
        },
        change: function(event, ui){
            cv_assessHiddenSegments();
        }
    });
}

function cv_assessHiddenSegments(){
    jQuery("#hidden_segments").html("");
    jQuery(".ui-accordion").each(function(){
        var self = jQuery(this);
        var segmentguid = jQuery(".ui-state-active", self).data('segmentguid');
        jQuery('<input type="hidden" name="linked_segments[]">').val(segmentguid).appendTo('#hidden_segments');
    });
}

function cv_datepickerModuleInit(module){
    var cv_date = jQuery('.elgg-input-date', module);
    if(lastdate != '')cv_date.val(lastdate);
    cv_date.datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: -1,
    });
    cv_date.change(function(){
            var self = jQuery(this);
            var parent_module = self.parents(".channelviewer_module");
            jQuery('.cv_keyword', parent_module).val('');
            lastdate = self.val();
            lastkeyword = '';        
            data = {};
            data.date = lastdate;
            data.keyword = "";
            cv_loadSegments(parent_module, data);    
    });
}

function cv_autocompleteModuleInit(module){
    var cv_auto = jQuery('.elgg-input-autocomplete', module);
    if(lastkeyword != '')cv_auto.val(lastkeyword);
    cv_auto.autocomplete({
        source: elgg.autocomplete_cv.url, //gets set by input/autocomplete
        minLength: 1,
        select: function(event, ui) {
            jQuery(this).change();
        }
    });
    cv_auto.change(function(){
        var self = jQuery(this);
        var parent_module = self.parents(".channelviewer_module");
        jQuery('.cv_datepicker', parent_module).val('');        
        lastdate = '';
        lastkeyword = self.val();        
        data = {};
        data.date = "";
        data.keyword = lastkeyword;        
        cv_loadSegments(parent_module, data);
    });

}

function cv_loadSegments(module, data){
    var channelguid = module.data('channelguid');
    elgg.action('cv_return_segments', {
        data: {
              channel_guid: channelguid,
              keyword: data.keyword || lastkeyword,
              requested_date: data.date || lastdate,
          },
          success: function(json){
                jQuery(".returned_segments", module).html(json.output);
          },        
    });
}

elgg.register_hook_handler('init', 'system', elgg.commentary.init);