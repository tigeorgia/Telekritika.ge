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

    jQuery(document).ready(function(){
        jQuery("body")
            .delegate(".hovermodule", "click", function(e){
                if(!jQuery(this).hasClass("stickyhover")){
                    jQuery(".stickyhover").hide().removeClass("stickyhover").prev("a").removeClass("segmenthover");
                    jQuery(this).addClass("stickyhover").prev("a").addClass("segmenthover");
                }
            })            
            .click(function(event) {                  
                var stick = jQuery('.stickyhover');
                var self = jQuery(event.target);
                var captcha = jQuery("#recaptcha_widget_div");
                var all = self.parents().andSelf();
                if(all.index(stick) == -1 && all.index(captcha) == -1) {                    
                    if(!stick.closest(".moduleselected").length)
                        stick.parents(".returned_segments:first").find("input[type=radio]:checked").prop("checked", false);
                    stick.hide().removeClass("stickyhover").prev("a").removeClass("segmenthover");
                    captcha.hide();
                }else if(all.index(captcha) != -1){
                    jQuery(".hovermodule:visible").addClass("stickyhover");
                }
            });

        jQuery("#cv_segmentselect_module_holder .channelviewer_module").each(function(){
            var module = jQuery(this);
            var data = {};
            data.moduleSelector = "#"+set_id(module);
            cv_initmodule(module, data);
        });
        
        cv_refreshSelectedSegments();

    });            
};

function cv_remove_module(module){
    if(conditionals.confirm_delete() != -1){
        module.fadeOut('slow', function(){
            module.remove();
            cv_refreshSelectedSegments();
        });
    }
}

function cv_closeModuleInit(module){
    jQuery('.close_module', module).click(function(e){
        e.preventDefault();
        var module = jQuery(this).parent();
        cv_remove_module(module);
    });    
}

function cv_selectModuleInit(module){
    jQuery(module).delegate('a.segment', "click", function(e){
        e.preventDefault();
        var self = jQuery(this);
        if(self.hasClass("selectedsegment"))return false;
        self
            .parents(".moduleselected, .selectedsegment")
            .andSelf()
            .removeClass("selectedsegment")
            .removeClass("moduleselected");
        self.addClass("selectedsegment");
        module.addClass("moduleselected");
        cv_refreshSelectedSegments();
    });    
}

function cv_show_allModuleInit(module){
    jQuery('.show_all_segments', module).click(function(e){
        e.preventDefault();
        var parent = jQuery(this).closest(".moduleselected");
        parent.find(".selectedsegment")
            .andSelf()
            .removeClass("selectedsegment")
            .removeClass("moduleselected");
        cv_refreshSelectedSegments();
    });
}
                                          
function cv_refreshHiddenSegments(segarray){
    jQuery("#hidden_segments").html("");
    jQuery(segarray).each(function(index, val){
        jQuery('<input type="hidden" name="linked_segments[]">').val(val).appendTo('#hidden_segments');
    });
}

function cv_getSelectedSegments(){
    var returnArr = [];
    jQuery(".selectedsegment").each(function(){
        var self = jQuery(this);
        returnArr.push( self.data('guid') );
    });
    return returnArr;
}

function cv_refreshSelectedSegments(){
    var segarray = cv_getSelectedSegments();
    cv_refreshHiddenSegments(segarray);
}

function cv_datepickerModuleInit(module){
    var cv_date = jQuery('.elgg-input-date', module);
    if(lastdate != '' && lastkeyword == '' && cv_date.val() == "")cv_date.val(lastdate);
    cv_date.datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: -1,
        defaultDate: cv_date.val(),
        onSelect: function(date, inst) {
            jQuery(inst.input[0]).val(date).trigger({type:"custom",clickTarget:inst.input[0]});
        }
    });
}

function cv_autocompleteModuleInit(module){
    var cv_auto = jQuery('.elgg-input-autocomplete', module);
    cv_auto.click(function(){
        jQuery(this).val("");
    });
    if(lastkeyword != '')cv_auto.val(lastkeyword);
    cv_auto.autocomplete({
        source: elgg.autocomplete_cv.url, //gets set by input/autocomplete
        minLength: 1,
        select: function(event, ui) {
            jQuery(event.target).val(ui.item.value).trigger({type:"custom",clickTarget:event.target});
        }
    });
}

function cv_initmodule(module, data){
    cv_closeModuleInit(module);
    cv_selectModuleInit(module);
    cv_datepickerModuleInit(module);
    cv_autocompleteModuleInit(module);
    cv_show_allModuleInit(module);
    callbacks.post_segmentrefresh(data);
}

elgg.provide('callbacks');
callbacks.create_module = function (data){
    var html = data.data;
    var module = jQuery(html).css('display', 'none');
    module.prependTo(data.target)
        .fadeIn('slow');
//    var thedate = data.date || lastdate;
    cv_initmodule(module, data);
}

callbacks.grabcaptcha = function (data){
    var self = jQuery(data.publisherSelector);
    var captcha = jQuery("#recaptcha_response_field").val();
    var challenge = jQuery("#recaptcha_challenge_field").val();
    self.parent().find('input[name="recaptcha_response_field"], input[name="recaptcha_challenge_field"]').remove();
    self.parent()
        .append('<input type=\"hidden\" name="recaptcha_response_field" value="'+captcha+'" />')
        .append('<input type=\"hidden\" name="recaptcha_challenge_field" value="'+challenge+'" />');
}

callbacks.gotocaptcha = function (data){
    if(typeof data.error == "undefined")return false;
    var self = jQuery(data.publisherSelector);
    var captcha = jQuery("#recaptcha_response_field").val();
    var challenge = jQuery("#recaptcha_challenge_field").val();
    self.parent().find('input[name="recaptcha_response_field"], input[name="recaptcha_challenge_field"]').remove();
    self.parent()
        .append('<input name="recaptcha_response_field" value="'+captcha+'" />')
        .append('<input name="recaptcha_challenge_field" value="'+challenge+'" />');
}

callbacks.refreshcaptcha = function (data){
    Recaptcha.reload();
}

callbacks.prep_segmentrefresh = function (data){
    var self = jQuery(data.publisherSelector);
    var parent_module = jQuery("#"+data.parentid) || self.closest('.channelviewer_module');
    
    if(data.keyword){
        lastkeyword = self.val();        
        //alert("e"+self.val());
        jQuery('.cv_datepicker', parent_module).val('');        
        lastdate = '';    
    }else if(data.date){
        lastdate = self.val();        
        jQuery('.cv_keyword', parent_module).val('');        
        lastkeyword = '';    
    }    
}

callbacks.post_segmentrefresh = function (data){
    var self = jQuery(data.publisherSelector);
    var parent = jQuery("#"+data.parentid) || self.parents('.returned_segments:first');
    if(!parent.length){
        var parent = jQuery(data.moduleSelector);
    }

    self.closest(".moduleselected").removeClass("moduleselected").find(".selectedsegment").removeClass("selectedsegment");
    jQuery(".cv-segment-hotcomments", parent).next().css({"max-height":"150px"});
    jQuery(".cv-segment-comments", parent).scroll(function(e){
                var me = jQuery(this).parents(".hovermodule:first");
                if(!me.hasClass("stickyhover")){
                    jQuery(".stickyhover")
                        .hide()
                        .removeClass("stickyhover")
                        .prev("a")
                        .removeClass("segmenthover");
                    me
                    .addClass("stickyhover")
                    .prev("a")
                    .addClass("segmenthover");
                }
            });
                    
}

callbacks.togglesegmenttype = function (data){
    var self = jQuery(data.publisherSelector);
    var ind = self.find("span")
    var plusminus = ind.html();
    if(plusminus == "-"){
        self.parent().find("a").not(self).addClass("dontshowme");
        ind.html("+");
    }else if(plusminus == "+"){
        self.parent().find("a").removeClass("dontshowme");    
        ind.html("-");
    }    
}

callbacks.togglehoverpopup = function (data){
    var self = jQuery(data.publisherSelector);
    var captcha = jQuery("#recaptcha_widget_div");
    var toElement = jQuery(data.toElement);
    var all = toElement.parents().andSelf();                  
    var dropdown = jQuery(data.dropdown);
    if((data.eventType == "mouseenter" || data.eventType == "mouseover")
        && !dropdown.is(":visible")
        && all.index(dropdown) == -1
    ){
        jQuery(".cv-hovermodule").not(".stickyhover").hide();
        self.parents(".returned_segments:first").find('input[type=radio]:checked').prop("checked", false);
        var targetTop = self.position().top+"px";
        dropdown.css({top: targetTop}).show();    

        if(!jQuery(".stickyhover").length){
            capoff = self.offset();
            captchaTop = capoff.top - 270;
            captchaLeft = capoff.left + 150;
            captcha.css({top: captchaTop+"px", left: captchaLeft+"px"}).show();    
        }

        if(self.is("div")){
            self.prev("a").find('input[type=radio]').not(":checked").prop("checked", true);
        }else if(self.is("a")){
            self.find('input[type=radio]').not(":checked").prop("checked", true);    
        }
    }else if(
        (data.eventType == "mouseleave" || data.eventType == "mouseout") 
        && dropdown.is(":visible")
        && !dropdown.hasClass("stickyhover")
        && all.index(captcha) == -1
        && !(all.index(dropdown) != -1
            || data.dropdown == toElement.data("dropdown")
            || data.dropdown == toElement.parents("[hoverjs]:first").data("dropdown")        
            )
    ){
        dropdown.hide();        
        if(!jQuery(".stickyhover").length){
                captcha.hide();
        }
        if(self.is("div") && !self.closest(".moduleselected").length){
            self.prev("a").removeClass("segmenthover").find('input[type=radio]:checked').prop("checked", false);
        }else if(self.is("a") && !self.closest(".moduleselected").length){
            self.removeClass("segmenthover").find('input[type=radio]:checked').prop("checked", false);    
        }
    }

    if((data.eventType == "mouseenter" || data.eventType == "mouseover")
        && all.index(dropdown) != -1
        //&& !jQuery(".stickyhover").length
    ){
        //jQuery(".segmenthover").removeClass("segmenthover");
        dropdown.prev("a").addClass("segmenthover");        
    }


    return false;    
}


elgg.provide('conditionals');
conditionals.mod_amt = function(){
    var amtcheck = jQuery('#cv_segmentselect_module_holder > .channelviewer_module').length;
    if(amtcheck >= <?=$CONFIG->maxChannelsInChannelViewer;?>){
        elgg.register_error(elgg.echo('commentary:toomanychannels'));
        return -1;
    }
    return true;
}

conditionals.confirm_delete = function(){
    var conf = confirm(elgg.echo('deleteconfirm'));
    if(conf){
        return true;
    }else{
        return -1;
    }
}

elgg.register_hook_handler('init', 'system', elgg.commentary.init);