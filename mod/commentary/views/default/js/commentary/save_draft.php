elgg.provide('elgg.commentary');

elgg.commentary.init = function() {

    lastdate = '';
    lastkeyword = '';
    //jScrollDefaults = { "verticalDragMinHeight": 50 };
    jScrollDefaults = { };

    jQuery(window).resize(function(){
        var theones = jQuery(".channelviewer_module").not(".moduleselected").find(".returned_segments");
        bilbob = theones;
        theones.each(function(){
            if(jQuery(this).data("jsp")){
                jQuery(this).data("jsp").reinitialise();
            }else{
                jQuery(this).jScrollPane(jScrollDefaults);
            }
        })
        jQuery(".stickyhover")
            .fadeOut(100)
            //.css({"z-index":250})
            .removeClass("stickyhover");
        jQuery(".segmenthover").removeClass("segmenthover");
    });
    
    jQuery(document).ready(function(){
        jQuery("body")
            .delegate(".hovermodule", "click", function(e){
                if(!jQuery(this).hasClass("stickyhover")){
                    jQuery(".stickyhover")
                        .fadeOut(100)
                        .removeClass("stickyhover")
                        .each(function(){
                            var parentid = jQuery(this).data("parentid");
                            jQuery("#"+parentid)
                                .removeClass("segmenthover");    
                        });
                    var selff = jQuery(this);
                    selff.addClass("stickyhover");
                    jQuery("#"+selff.data("parentid")).addClass("segmenthover");
                }
            })            
            .click(function(event) {                  
                var stick = jQuery('.stickyhover');
                var self = jQuery(event.target);
                if(!self.closest(".commentbubble").length && !self.closest(".stickyhover").length && !self.closest("#recaptcha_widget_div").length) {                    
                    stick
                        .fadeOut(100)
                        .removeClass("stickyhover")
                        .each(function(){
                            var parentid = jQuery(this).data("parentid");
                            jQuery("#"+parentid)
                                .removeClass("segmenthover");
                        });
                    jQuery(".segmenthover").removeClass("segmenthover");
                }else if(self.closest("#recaptcha_widget_div").length){
                    jQuery(".hovermodule:visible").addClass("stickyhover");
                }
            });
        jQuery("#cv_segmentselect_module_holder .channelviewer_module").each(function(){
            var module = jQuery(this);
            var data = {};
            data.moduleSelector = "#"+set_id(module);
            data.date = module.data("date");
            data.keyword = module.data("keyword");
            cv_initmodule(module, data);
        });

        var read = jQuery(".cv_read_module");
        if(read.length){
            var returned = read.jScrollPane(jScrollDefaults).children(".jspContainer");
            //returned.mousemove(function(e){var me = jQuery(this); var off = e.pageY - me.offset().top; var percent = off / me.height(); me.parent().data("jsp").scrollToPercentY(percent);});        
        }else{
            cv_refresh_width();        
        }
            cv_refreshSelectedSegments();
        
    });            
};

function cv_remove_module(module, other){
    if(other == "solo"){
        module = jQuery(".channelviewer_module").not(module);
    }
    //if(conditionals.confirm_delete() != -1){
        var captcha = jQuery("#recaptcha_widget_div", module);
        captcha.appendTo("body").hide();
        module.animate({ opacity: 0 }, 1000, function(){
            module.animate({ height: 0, width: 0, paddingLeft: 0, paddingRight: 0, marginRight: 0, marginLeft: 0 }, 1000, function(){
                    module.remove();
                    cv_refreshSelectedSegments();
                    cv_refresh_width();                            
            });
        });
    //}
}

function cv_refresh_width(plusone){
    var holder = jQuery("#cv_segmentselect_module_holder") || jQuery(".cv_read_module");
    if(typeof holder == "undefined")return true;
    var thelength = holder.find(".channelviewer_module").length;
    thelength = typeof plusone != "undefined" ? thelength + 1 : thelength;
    var newleng = thelength * 315;
    if( (newleng + holder.offset().left) > (jQuery('body').width() + 20) ){
        delete stophover;
        if( jQuery("#moresegs, #lesssegs").length ){
            jQuery("#moresegs, #lesssegs").width(newleng - 940).animate({opacity: .4}, 500);
        }else{
            var more = jQuery("<a id=\"moresegs\" href=\"#\">&nbsp;</a>").css({
                width: newleng - 940,
            });
            var less = jQuery("<a id=\"lesssegs\" href=\"#\">&nbsp;</a>").css({
                width: newleng - 940,
            });
            less.add(more).appendTo(holder).animate({opacity: .4}, 500);
            less
                .hover(function(){arrows("left");}, function(){arrows("clear");})
                .click(function(e){e.preventDefault();gotoarrows("previous");});
            more
                .hover(function(){arrows("right");}, function(){arrows("clear");})
                .click(function(e){e.preventDefault();gotoarrows("next");});
        }
        holder.width(newleng);
    }else{
        stophover = "true";
        if(typeof plusone != "undefined")holder.width(newleng);        
        jQuery("#moresegs, #lesssegs").stop().animate({opacity: 0}, 500, function(){
            var bilbo = jQuery("#moresegs, #lesssegs").detach();
            if(typeof plusone == "undefined")holder.width(newleng);
            delete bilbo;
        });
    };
}

/*
function cv_refresh_height(plusone){
    var holder = jQuery("#cv_segmentselect_module_holder") || jQuery(".cv_read_module");
    var returnedsegments = jQuery(".returned_segments", holder);
    var wrapper = jQuery(".segments_wrapper", returnedsegments);

    thelength = typeof plusone != "undefined" ? thelength + 1 : thelength;
    var newleng = thelength * 315;
    if( (newleng + holder.offset().left) > (jQuery('body').width() + 20) ){
        delete stophover;
        if( jQuery("#moresegs, #lesssegs").length ){
            jQuery("#moresegs, #lesssegs").width(newleng - 940).animate({opacity: .4}, 500);
        }else{
            var more = jQuery("<a id=\"moresegs\" href=\"#\">&nbsp;</a>").css({
                width: newleng - 940,
            });
            var less = jQuery("<a id=\"lesssegs\" href=\"#\">&nbsp;</a>").css({
                width: newleng - 940,
            });
            less.add(more).appendTo(holder).animate({opacity: .4}, 500);
            less
                .hover(function(){arrows("left");}, function(){arrows("clear");})
                .click(function(e){e.preventDefault();gotoarrows("previous");});
            more
                .hover(function(){arrows("right");}, function(){arrows("clear");})
                .click(function(e){e.preventDefault();gotoarrows("next");});
        }
        holder.width(newleng);
    }else{
        stophover = "true";
        if(typeof plusone != "undefined")holder.width(newleng);        
        jQuery("#moresegs, #lesssegs").stop().animate({opacity: 0}, 500, function(){
            var bilbo = jQuery("#moresegs, #lesssegs").detach();
            if(typeof plusone == "undefined")holder.width(newleng);
            delete bilbo;
        });
    };
}
*/

function gotoarrows(which){
    if( !jQuery("html").is(':animated') && !jQuery("body").is(':animated') ) {
        var mods = jQuery(".channelviewer_module").length;
        var html = jQuery("html");
        var body = jQuery("body");
        var scrollLeft = body.scrollLeft() || html.scrollLeft();
        var bodyw = jQuery("body").width();
        var cv = jQuery("#cv_segmentselect_module_holder");
        var takeoff = cv.offset().left;
        var cvwidth = cv.width();
        var total = cvwidth + takeoff;    
        var remaining = total - (scrollLeft + bodyw);
        var fromr = which == "next" ? (remaining / 315) - .2 : (remaining / 315) + .2;
        var whereat = mods - Math.floor(fromr);    
        var whereto = which == "next" ? whereat : whereat - 1;
        var remaining2 = which == "next" ? (mods-whereto)*312 : (mods-whereto)*317;
        var real = total - bodyw - remaining2;    
        real = real > 0 ? real : 0;
        var animme = jQuery("html").add(body);
        animme.animate({scrollLeft: real}, 1000);
    }
}

function arrows(action){
    switch(action){
        case "left":
            arrowgoleft();
            goarrows = setInterval("arrowgoleft()", 3000);        
            //setInterval("arrowgoleft()", 3000);        
        break;
        case "right":
            arrowgoright();
            goarrows = setInterval("arrowgoright()", 3000);        
            //setInterval("arrowgoright()", 3000);        
        break;
        case "clear":
            stoparrows();
        break;
    }

}

function stoparrows(){
    if(typeof stophover == "undefined"){
        jQuery("#lesssegs, #moresegs").stop().css("opacity",.4);
    }
    clearInterval(goarrows);        
    delete goarrows;            
}

function arrowgoleft(){
    if(typeof stophover == "undefined"){
        var thearrow = jQuery("#lesssegs");
        var current = parseInt(thearrow.stop().css("background-position"));
        thearrow.css("opacity",.6).animate({"background-position": current-40}, 3000, "linear");
    }
}

function arrowgoright(){
    if(typeof stophover == "undefined"){
        var thearrow = jQuery("#moresegs");
        var current = parseInt(thearrow.stop().css("background-position"));
        thearrow.css("opacity",.6).animate({"background-position": current+40}, 3000, "linear");
    }
}

function cv_closeModuleInit(module){
    jQuery('.close_module', module).click(function(e){
        e.preventDefault();
        var module = jQuery(this).parent();
        cv_remove_module(module);
    });    
    jQuery('.solo_module', module).click(function(e){
        e.preventDefault();
        var module = jQuery(this).parent();
        cv_remove_module(module, "solo");
    });    
}

function cv_selectModuleInit(module){
    jQuery(module).delegate('a.segment', "click", function(e){
        e.preventDefault();
        var self = jQuery(this);
        if(!self.hasClass("selectedsegment") && !jQuery(e.target).closest(".sliderthumbs").length){
            jQuery(".segmenthover").removeClass("segmenthover");
            jQuery(".hovermodule").hide().removeClass("stickyhover");
            self
                .parents(".moduleselected, .selectedsegment")
                .andSelf()
                .removeClass("selectedsegment")
                .removeClass("moduleselected");
            self.addClass("selectedsegment");
            module
                .addClass("moduleselected")
                .find(".returned_segments")
                .data('jsp').destroy();                
            
            self.parents(".moduleselected").find(".selectasegment").removeClass("showme");

            cv_refreshSelectedSegments();
        }
    });    
}

function cv_show_allModuleInit(module){
    jQuery('.show_all_segments', module).click(function(e){
        e.preventDefault();
        var parent = jQuery(this).closest(".moduleselected");
        parent.find(".selectedsegment")
            .andSelf()
            .removeClass("segmenthover")
            .removeClass("selectedsegment")
            .removeClass("moduleselected");
        parent.find(".selectasegment").addClass("showme");

        var returned = module.find(".returned_segments").jScrollPane(jScrollDefaults).children(".jspContainer");
        //returned.mousemove(function(e){var me = jQuery(this); var off = e.pageY - me.offset().top; var percent = off / me.height(); me.parent().data("jsp").scrollToPercentY(percent);});

        jQuery(".returned_segments > .jspContainer .jspDrag", module).mousedown(function() {            
            isMouseDown = true;
            jQuery(".segmenthover").removeClass("segmenthover");
            jQuery(".hovermodule")
                .removeClass("stickyhover")
                .fadeOut(150);
        });

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
    var cv_auto = jQuery('.elgg-input-autocomplete', module);
    /*if(lastdate != '' && lastkeyword == '' && cv_date.val() == "" && cv_auto.val() == ""){
        cv_date.val(lastdate); 
    }*/
    cv_date.datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: -1,
        defaultDate: cv_date.val() || lastdate,
        beforeShowDay: jQuery.datepicker.noWeekends,
        onSelect: function(date, inst) {
            jQuery(inst.input[0]).val(date).trigger({type:"custom",clickTarget:inst.input[0]});
        }
    });
}

function cv_autocompleteModuleInit(module){
    var cv_auto = jQuery('.elgg-input-autocomplete', module);
    //cv_auto.val(lastkeyword);
    cv_auto.chosen({
        allow_single_deselect: true,
    }).change(
        function(e){
            var self = jQuery(this);
            //var module = self.closest(".hovermodule");
            var id = set_id(self);
//            alert(id);
            self.trigger({type:"custom",clickTarget:e.target});
        }
    );    
    
}

function cv_hoverInit(module){
    var hovers = jQuery(".hovermodule", module);
    hovers.appendTo(module);
//hovermodule 
}

function cv_initmodule(module, data){
//    lastdate = typeof lastdate == "undefined" ? data.date : lastdate;
//    lastkeyword = typeof lastkeyword == "undefined" ? data.keyword : lastkeyword;
    if(data.date){
        lastdate = data.date;
        lastkeyword = '';
    }else if (data.keyword){
        lastkeyword = data.keyword;
        lastdate = '';
    }    
    if(lastkeyword && lastdate){
        lastkeyword = '';
    }

    cv_closeModuleInit(module);
    cv_selectModuleInit(module);
    cv_datepickerModuleInit(module);
    cv_autocompleteModuleInit(module);
    cv_show_allModuleInit(module);
    callbacks.post_segmentrefresh(data);
}

function cv_make_link(){
    var link = [];
    jQuery(".channelviewer_module").each(function(){
        var self = jQuery(this);
        if(self.is(".moduleselected")){
            link.push(self.find(".selectedsegment:first").data("guid"));
        }else{
            link.push(self.find(".channelname:first").text().replace(" ", "%20"));
            link.push(self.find(".elgg-input-date:first").val().replace(" ", "%20") || self.find(".elgg-input-autocomplete:first").val().replace(" ", "%20"));
        }    
    });
    return elgg.config.wwwroot+"channels/"+link.join("/");
}


elgg.provide('callbacks');

callbacks.stickme = function(data){
    var self = jQuery(data.publisherSelector);
    var dropdown = jQuery(data.dropdown) || jQuery(self).closest(".hovermodule");
    if(dropdown.hasClass("stickyhover") && !(data.eventType == "mouseenter" || data.eventType == "mouseover" || data.eventType == "mouseleave" || data.eventType == "mouseout")){
        jQuery("#"+dropdown.data("parentid")).removeClass("segmenthover");
        //.removeClass("stickyhover").fadeOut(100).css({"z-index":250});
        dropdown.removeClass("stickyhover").fadeOut(100);
        //.css({"z-index":250});
    }else if(!isMouseDown && data.eventType == "mouseenter" || data.eventType == "mouseover" || data.eventType == "click"){
        jQuery(".segmenthover").not("#"+dropdown.data("parentid")).removeClass("segmenthover");
        //.css({"z-index":250});
        jQuery(".stickyhover").not(dropdown).fadeOut(150).removeClass("stickyhover");
        //.css({"z-index":250});
        //++zcount;
        dropdown.fadeIn(150).addClass("stickyhover");
        //.css({"z-index":zcount});
        jQuery("#"+dropdown.data("parentid")).addClass("segmenthover");
        //.css({"z-index":zcount});
    }
}
callbacks.cv_generate_link = function(data){
    var madelink = cv_make_link();
    var publisher = jQuery(data.publisherSelector);        
    var actuallink = jQuery("<input />").addClass("showlink").val(madelink).click(function(){jQuery(this).focus().select();return false;});
    var showlink = jQuery(".showlink");
    if(showlink.length){
        publisher.find(".showlink:first").replaceWith(actuallink);
    }else{
        var copyme = jQuery("<span class=\"copyme\">"+elgg.echo("copyme")+"<br /></span>");
        publisher.prepend(copyme.append(actuallink));    
    }
    actuallink.focus().select();
    publisher.attr("href", madelink);
    madelink = madelink.replace("https://", "https%3A%2F%2F");
    var iframe = jQuery('<iframe class="fblike" src="//www.facebook.com/plugins/like.php?href='+madelink+'&amp;locale=ka_GE&amp;send=false&amp;layout=standard&amp;width=80&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" allowTransparency="true"></iframe>');
    publisher.before(iframe); 
}                                  

callbacks.update_forwarder_submit = function(data){
    jQuery("input[name='forward']").val(cv_make_link());
    if(data.eventType == "contextmenu")return true;
//    alert(cv_make_link()+jQuery("input[name='forward']").val());
    jQuery(data.publisherSelector).closest("form").submit();
}

callbacks.create_module = function (data){
    cv_refresh_width("true");
    var html = data.data;
    var module = jQuery(html);
    module.css({
        width: "1px",
        opacity: 0,
        height: "1px",
    });
    module.prependTo(data.target)
        .animate({ height: "1px", width: "299px" }, 1000, function(){
            cv_initmodule(module, data);
            module.css({height: "auto"});
            module.animate({ opacity: 1 }, 1000, function(){ });
        });
}

callbacks.prep_segmentrefresh = function (data){
    var self = jQuery(data.publisherSelector);
    var parent_module = jQuery("#"+data.parentid) || self.closest('.channelviewer_module');

    jQuery(".hovermodule", parent_module).remove();
    
    if(data.keyword){
        lastkeyword = self.val();        
        //alert("e"+self.val());
        jQuery('.cv_datepicker', parent_module).val('');        
        lastdate = '';    
    }else if(data.date){
        lastdate = self.val();        
        jQuery('.cv_keyword', parent_module).val('').trigger("liszt:updated");
        lastkeyword = '';    
    }    
}

callbacks.post_segmentrefresh = function (data){
    var self = jQuery(data.publisherSelector);
    var parent = jQuery("#"+data.parentid) || self.parents('.returned_segments:first');
    if(!parent.length){
        var parent = jQuery(data.moduleSelector);
    }

    cv_hoverInit(parent.closest(".channelviewer_module"));

    var returned = parent.not(".moduleselected").find(".returned_segments").jScrollPane(jScrollDefaults).children(".jspContainer");
    //returned.mousemove(function(e){var me = jQuery(this); var off = e.pageY - me.offset().top; var percent = off / me.height(); me.parent().data("jsp").scrollToPercentY(percent);});
    jQuery(".returned_segments > .jspContainer .jspDrag", parent).mousedown(function() {            
        isMouseDown = true;
        jQuery(".segmenthover").removeClass("segmenthover");
        jQuery(".hovermodule")
            .removeClass("stickyhover")
            .fadeOut(150);
    });
    
    self.closest(".moduleselected").removeClass("moduleselected").find(".selectedsegment").removeClass("selectedsegment");
    if(data.results == "false"){
        parent.find(".showme").removeClass("showme");
        parent.find(".noresults").addClass("showme");    
    }
    else if(data.results == "true"){
        parent.find(".showme").removeClass("showme");
        parent.find(".selectasegment").addClass("showme");    
    }
        
}

callbacks.togglesegmenttype = function (data){
    var self = jQuery(data.publisherSelector);
    var ind = self.find("span")
    var plusminus = ind.html();
    var module = self.closest(".returned_segments");
    if(plusminus == "-"){
        self.parent().find("a").not(self).addClass("dontshowme");
        ind.html("+");
    }else if(plusminus == "+"){
        self.parent().find("a").removeClass("dontshowme");    
        ind.html("-");
    }    
    if(module.data("jsp")){
        module.data("jsp").reinitialise();
    }else{
        module.jScrollPane(jScrollDefaults);
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
        && !isMouseDown
    ){
        jQuery(".stickyhover").fadeOut(100);
        jQuery(".segmenthover").removeClass("segmenthover");
        if(self.is(".segment"))self.addClass("segmenthover");

        var read = self.closest(".channelviewer_module") || self.closest(".cv_read_module");
        //if(read.length){
            var tops = read.offset().top;
            var left = read.offset().left - read.width() - 1;
            dropdown.css({"top": tops, "left": left, "position": "absolute"}).appendTo("body").children(".cv-hovermodule_commentswrapper").addClass("poopleft");
        /*}else{
            var tops = 86;        
            //var tops = self.closest(".cv_read_module").length ? 286 : 86;
            var targetTop = (tops)+"px";        
            var popclass = (self.offset().left - 80 > (jQuery("body").width() / 2)) 
                        ? "popleft" : "popright";
            var removeclass = (self.offset().left - 80 > (jQuery("body").width() / 2)) 
                        ?  "popright" : "popleft";
            dropdown.find(".cv-hovermodule_commentswrapper").removeClass(removeclass).addClass(popclass);
            dropdown
            .css({top: targetTop})
        }*/
            dropdown.fadeIn(150);


        //build jScrollPane
        var comments = jQuery('.cv-segment-comments', dropdown);
        var heightcheck = comments[0].scrollHeight > 190;
        if(heightcheck)comments.jScrollPane(jScrollDefaults);
        jQuery(".jspDrag", comments).mousedown(function() {            
            isMouseDown = true;
            var addto = comments.closest(".hovermodule");
            if(!addto.hasClass("stickyhover")){
                jQuery(".stickyhover")
                    .not(addto)
                    .fadeOut(100)
                    .removeClass("stickyhover")
                    .each(function(){
                        var parentid = jQuery(this).data("parentid");
                        jQuery("#"+parentid)
                            .removeClass("segmenthover");
                    });
                var parentid = addto.addClass("stickyhover").data("parentid");
                jQuery("#"+parentid).addClass("segmenthover");
            }
        });    
    }else if(
        (data.eventType == "mouseleave" || data.eventType == "mouseout") 
        && !isMouseDown
        && dropdown.is(":visible")
        && !self.closest(dropdown).length
        && !dropdown.hasClass("stickyhover")
        && !self.closest(captcha).length
        && data.dropdown != "#"+set_id(jQuery(data.toElement).closest(".hovermodule"))
//        && !(
//            || data.dropdown == toElement.closest("[hoverjs]:first").data("dropdown")        
//            || toElement.is(".jspTrack, .jspDrag, .jspVerticalBar")        
//            )
    ){
        
        //removeJSP setup
        var comments = jQuery('.cv-segment-comments', dropdown);
        //remove dropdown reset z
        dropdown.fadeOut(100);
        if(comments.data('jsp'))comments.data('jsp').destroy();

        //fix segment hovering, z index
        var seg = jQuery("#"+dropdown.data("parentid")).removeClass("segmenthover");
        
        var module = self.closest(".channelviewer_module");        

    }

    if((data.eventType == "mouseenter" || data.eventType == "mouseover")
    ){
        //simply add seghover class to segment title
        if(all.index(dropdown) != -1)jQuery("#"+dropdown.data("parentid")).addClass("segmenthover");
    }

    return false;    
}

callbacks.togglejsppopup = function(data){
    /*var self = jQuery(data.publisherSelector);
    var captcha = jQuery("#recaptcha_widget_div");
    var toElement = jQuery(data.toElement);
    if((data.eventType == "mouseenter" || data.eventType == "mouseover")){
        jQuery(".jspDrag", self).css("opacity", 1);
    }else if(!isMouseDown){
        jQuery(".jspDrag", self).css("opacity", 0);            
    }             */
}
callbacks.togglejsppopup3 = function(data){
    /*var self = jQuery(data.publisherSelector);
    var parent = self.closest(".returned_segments");
    var captcha = jQuery("#recaptcha_widget_div");
    var toElement = jQuery(data.toElement);
    if((data.eventType == "mouseenter" || data.eventType == "mouseover")){
        //jQuery(".jspDrag", parent).css("opacity", 1);
    }else if(!isMouseDown && !jQuery(data.toElement).is(".jspTrack, .jspDrag, .jspVerticalBar")){
        //jQuery(".jspDrag", parent).css("opacity", 0);            
    }             */
}

callbacks.refreshJSP = function(data){
    var parent = jQuery(data.publisherSelector).closest(".hovermodule");
    //build jScrollPane
    var comments = jQuery('.cv-segment-comments', parent).jScrollPane(jScrollDefaults);
    jQuery("textarea", parent).html("").val("");
    jQuery(".jspDrag", comments).mousedown(function() {            
        isMouseDown = true;
        var addto = comments.closest(".hovermodule");
        if(!addto.hasClass("stickyhover")){
                jQuery(".stickyhover")
                    .fadeOut(100)
                    .removeClass("stickyhover")
                    .each(function(){
                        var parentid = jQuery(this).data("parentid");
                        jQuery("#"+parentid)
                            .removeClass("segmenthover");
                    })
            var parentid = jQuery(this).addClass("stickyhover").data("parentid");
            jQuery("#"+parentid).addClass("segmenthover");
        }
    });    
}

elgg.provide('conditionals');
conditionals.mod_amt = function(){
    var amtcheck = jQuery('#cv_segmentselect_module_holder > .channelviewer_module').length;
    if(amtcheck >= elgg.config.maxChannelsInChannelViewer){
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

