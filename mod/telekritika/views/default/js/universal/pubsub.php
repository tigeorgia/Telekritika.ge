jQuery(document).ready(function(){
                  
<? if(elgg_is_admin_logged_in()){ ?>
      //translation
      jQuery(".elgg-echo-string").hover(function(e){
        var self = jQuery(this);
        var message_key = self.data("key");
        var appendme = jQuery("<a class=\"translate-link\" href=\"<?=$CONFIG->wwwroot;?>translation_editor/ka/custom_keys/#"+message_key+"\">Translate</a>");
        self.append(appendme);
      }, function(e){                  
        var self = jQuery(this);
        self.find(".translate-link").remove();
      });                  
<? } ?>                  
                            
    jQuery("body")
        .delegate("a[data-pub],a[data-paginate]:not([data-pub], [data-multipub], [data-onlyjs]),a[data-multipub]:not([data-pub], [data-paginate], [data-onlyjs])", "click", function(e){
            e.preventDefault();
            var publisher = jQuery(this);
            pubsub(e, publisher);
        })
        .delegate("span[data-pub]", "click", function(e){
            e.stopPropagation();
            e.preventDefault();
            var publisher = jQuery(this);
            pubsub(e, publisher);
        })
        .delegate("[data-onlyjs]", "click contextmenu", function(e){
            var publisher = jQuery(this);    
            if(e.type != "contextmenu")e.preventDefault();            
            var publisherData = jQuery.extend({}, publisher.data());
            publisherData.publisherSelector = "#" + set_id(publisher);
            publisherData.eventType = e.type;
            var onlyjsArr = publisherData.onlyjs.substring(1,publisherData.onlyjs.length-1).split("|");
            for(var i=0, count = onlyjsArr.length; i < count; i++){
                callbacks[onlyjsArr[i]](publisherData);
            }
        })
        .delegate("input[type!='submit'][data-pub],textarea[data-pub],select[data-pub]", "custom", function(e){
            var origpublisher = jQuery(this);
            var val = origpublisher.val();
            if(val != "" && val != false && val.length > 2){                
                var publisher = jQuery.extend({}, origpublisher[0].dataset);
                var name = origpublisher.attr("name");
                if(name && val)publisher[name] = val;
                publisher.publisherSelector = "#" + set_id(origpublisher);
                pubsub(e, publisher);
            }
        })
        .delegate("button[type='submit'][data-pub],input[type='submit'][data-pub],input[type='submit'][data-multipub]", "click", function(e){
            e.preventDefault();
            var publisher = jQuery(this);
            var name = publisher.attr("name");
            var val = publisher.val();
            if(name && val)publisher.data(name,val);
            pubsub(e, publisher);
        })
        .delegate("[data-hoverjs]", "mouseenter mouseleave", function(e){
            e.preventDefault();
            var publisher = jQuery(this);    
            var publisherData = jQuery.extend({}, publisher.data());
            publisherData.eventType = e.type;
            publisherData.toElement = jQuery.browser.mozilla ? "#"+set_id(jQuery(e.relatedTarget)) : "#"+set_id(jQuery(e.toElement));
            publisherData.publisherSelector = "#" + set_id(publisher);
            var hoverjsArr = publisherData.hoverjs.substring(1,publisherData.hoverjs.length-1).split("|");
            for(var i=0, count = hoverjsArr.length; i < count; i++){
                callbacks[hoverjsArr[i]](publisherData);
            }        
        }).delegate("textarea", "click", function(e){
            var self = target = jQuery(e.target);
            var captcha = jQuery("#recaptcha_widget_div");
            if(captcha.length && self.closest('form[action*="comments"]').length){
                var self = jQuery(this);
                var capoff = self.offsetParent();
                var captchaTop = capoff.top + self.height();
                var captchaLeft = capoff.left;
                captcha.appendTo(self.closest("form"));                    
                captcha.css({top: captchaTop+"px", left: captchaLeft+"px"}).show();                
            }
        }).click(function(e){
            var self = target = jQuery(e.target);
            if(!target.closest("#recaptcha_widget_div").length
                && !target.closest("textarea").length 
            ){
                var captcha = jQuery("#recaptcha_widget_div");
                captcha.hide();            
            } 
            if(!target.closest(".cv_generate_link").length
            && !target.closest(".showlink").length
            && !target.closest(".copyme").length
            && !target.closest(".fblike").length
            ){
                jQuery(".copyme, .fblike").remove();            
            } 
//        }).delegate(".thumbs", "click hover", function(e){
        }).delegate(".thumbs", "hover", function(e){
            var self = jQuery(this);
            if(self.hasClass("nohl"))return false;
            self = self.find("img");
            var which = (e.type == "mouseleave" || e.eventType == "mouseout") ? "src" : "hov";
            self.attr("src", self.data(which));
        }).delegate(".segtags > span, .tv[href], .tinylink[href]", "click", function(e){
            window.open(jQuery(this).attr("href"), '_blank');
            return false;        
        }).mousedown(function(e) {            
            isMouseDown = true;
        }).mouseup(function(e) {
            isMouseDown = false;
            var target = jQuery(e.target);
            /*if(!target.closest(".cv-hovermodule_commentswrapper").length){
                jQuery(".cv-segment-comments .jspDrag").fadeOut(100);                                  
            }
            if(!target.closest(".returned_segments").length){
                jQuery(".returned_segments > .jspContainer .jspDrag").hide();                                  
            } */
        });
        isMouseDown = false;

                //var captcha = jQuery("#recaptcha_widget_div");
});

function pubsub(e, publisher){
    //immediately disable publisher so there cant be multiple clicks
    if(typeof publisher.parent == "function"){
        //build a publisherData object to send onwards to subscribers
        publisher.parent().block(blockOpts);
        var publisherData = jQuery.extend({}, publisher.data());    
        //if no ID on publisher, set it
        publisherData.publisherSelector = "#" + set_id(publisher);
    }else{
        var publisherData = jQuery.extend({}, publisher);
        delete publisher;
        var publisher = jQuery(publisherData.publisherSelector);
        publisher.parent().block(blockOpts);
    }

    var subscriberSelectors = [];
    var refreshSelectors = [];    

    //add in global vars
    if(typeof(publisherData.vars) != "undefined"){
        var vars = publisherData.vars.split(",");
        for(var i=0, varcount = vars.length; i < varcount; i++){
            //    alert("yeswin"+window[i]);
             //   alert("yeswin"+vars[i]);
            publisherData[vars[i]] = window[vars[i]];    
        }    
        delete publisherData.vars;
    }

    //alert("1"+jQuery.toJSON(publisherData));

    publisherData.isPaginate = (typeof(publisherData.paginate) != "undefined");
    publisherData.isMultipub = (typeof(publisherData.multipub) != "undefined");
    
    //if ONLY paginate, then dont bother with other crapola
    if(publisherData.isPaginate && (typeof(publisherData.pub) == "undefined")){
        //exception for pagination, only 1 subscriber, and refresh selector is the same
        subscriberSelectors.push("[data-refresh='"+publisherData.paginate+"']");
        refreshSelectors.push("[data-refresh='"+publisherData.paginate+"']");                    
    }else if(publisherData.isMultipub){ 
        var multipubnamespace = publisherData.multipub;
        subscriberSelectors.push("[data-pub*='|"+multipubnamespace+"'][href*='/action/']");
        var multipublishers = jQuery("[data-pub*='|"+multipubnamespace+"'][href*='/action/']");
        multipublishers.each(function(index){
            var mpub = jQuery(this).data("pub");
            //get pubtypes
            var mpubtypes = get_namespaced(mpub);
            //refreshSelector and subscriberSelector for parent check and selecting respectively
            for(var xx = 0, count = mpubtypes.length; xx < count; xx++){
                subscriberSelectors.push("[data-sub*='|"+mpubtypes[xx]+"|']");
                refreshSelectors.push("[data-sub*='|"+mpubtypes[xx]+"|'][data-refresh]");    
            }            
        });
    }
//    alert("2"+jQuery.toJSON(publisherData));

    //preJS from the publisher, run it then delete it so all subscribers arent forced to run it
    if(publisherData.prejs){
        var prejsArr = publisherData.prejs.substring(1,publisherData.prejs.length-1).split("|");
        //asyncronous preJS commands to speed up the process
        for(var i=0, count = prejsArr.length; i < count; i++){
                callbacks[prejsArr[i]](publisherData);
        }
        delete publisherData.prejs;
    }
//    alert("3"+jQuery.toJSON(publisherData));

    if(publisherData.pub){
        //get pubtypes
        var pubtypes = get_namespaced(publisherData.pub);
        
        //refreshSelector and subscriberSelector for parent check and selecting respectively
        for(var i = 0, count = pubtypes.length; i < count; i++){
            var subsc = "[data-sub*='|"+pubtypes[i]+"|']";
            subscriberSelectors.push(subsc);
            refreshSelectors.push(subsc+"[data-refresh]");    
        }    
    }
    publisherData.subscriberSelector = subscriberSelectors.unique().join(",");
    publisherData.refreshSelector = refreshSelectors.unique().join(",");
//    alert("1"+jQuery.toJSON(publisherData));    
//    alert(publisherData.noForm+"noform");
    if(typeof publisherData.noform == "undefined"){
        var parentForm = publisher.closest("form");    
        if(parentForm.length){
            var paramstring = jQuery(parentForm).serialize();
            jQuery.extend(publisherData, jQuery.deparam(paramstring));
            var jclickTarget = jQuery(e.clickTarget);
            publisherData[jclickTarget.attr("name")] = jclickTarget.val(); 
            var href = parentForm.attr("action");        
        }else{
            var href = publisher.attr("href");
        }
    }else if(typeof publisherData.noform != "undefined"){
        var href = publisher.attr("href");
        delete publisherData.noform;    
    }

//    alert("2"+jQuery.toJSON(publisherData));
    //action and params are taken from href / action from form
//    var href = publisher.attr("href") || parentForm.attr("action");
    if(typeof href != "undefined" && href && href != "#" && href != "http://#"){
        var url1 = href.split("?");
        var action = url1[0].split("action/")[1];
        if(typeof(url1) != "undefined" && typeof(action) != "undefined" && url1.length > 1 && action.length > 1){
            jQuery.extend(publisherData, jQuery.deparam(url1[1]));
        }else if(typeof action == "undefined"){
            var action = "UI";
        }
    }else if(publisherData.isMultipub){
        var action = "multipub";    
    }else{
        var action = "UI";    
    }    
//    alert("3"+jQuery.toJSON(publisherData));

    jQuery.each(publisherData, function(key, value){
        if(key.indexOf("__elgg") != -1){
            delete publisherData[key];
        }       
    });                            
//    alert("4"+jQuery.toJSON(publisherData));
    
    //condition for running the publish, if fails, stops entire action
    if(publisherData.condjs){
        var condjsArr = publisherData.condjs.substring(1,publisherData.condjs.length-1).split("|");
        for(var i=0, count = condjsArr.length; i < count; i++){
            //conditional fails, so return everything to normal, register errors IN conditional
            if(conditionals[condjsArr[i]](publisherData) == -1){
                var theparent = publisher.parent();
                var theparentparent = theparent.parent();
                jQuery(".blockUI", theparentparent).css({cursor: "pointer"});
                theparent.unblock();
                return false;
            }
        }
        delete publisherData.condjs;
    }
    
    //INITIATE actors with first as the triggered action
    var actors = [];
    //actor gets publisherData, then push to actors var
    var actor = jQuery.extend({}, publisherData);
    actor.action = action;
    if(action == "multipub")
        actor.type = "multipub";
    else if(action == "UI")
        actor.type = "UI";
    else        
        actor.type = "action";
//    elgg.system_message(publisherData.publisherSelector);
    actor.target = publisherData.publisherSelector;
    actors.push(actor);

//alert("6"+jQuery.toJSON(actors));
//alert("6"+jQuery.toJSON(publisherData));
    var subscriberArr = process_subscribers(publisherData);
            
    jQuery.merge(actors, subscriberArr);
//alert("actors: "+jQuery.toJSON(actors));
    multiAct(actors);
}

function process_subscribers(publisherData){
    //get subscribers
    var subscribers = jQuery(publisherData.subscriberSelector);

    var subscriberArr = [];
    //go through all subscribers
    subscribers.each(function(index){
        var subscriber = jQuery(this);
        //temp actor to hold data
//        delete publisherData.postjs;
//        var tempActor = jQuery.extend({}, subscriber.data(), publisherData);                
        var tempActor = jQuery.extend({}, publisherData, subscriber.data());                

        if(publisherData.isMultipub){
            var subparentForm = subscriber.parents("form:first");
            if(subparentForm.length){
                var paramstring = jQuery(subparentForm).serialize();
                jQuery.extend(tempActor, jQuery.deparam(paramstring));
                if(subscriber.attr("name"))tempActor[subscriber.attr("name")] = subscriber.val(); 
            }
            //action and params are taken from href / action from form
            var href = subscriber.attr("href") || subparentForm.attr("action");
            if(href && href != "#" && href != "http://#"){
                var url1 = href.split("?");
                var action = url1[0].split("action/")[1];
                if(url1.length > 1){
                    jQuery.extend(tempActor, jQuery.deparam(url1[1]));
                }
            }else{
                var action = "UI";    
            }        
        tempActor.action = action;
        }

        //build a tempActor and save data into it
        if(tempActor.action && tempActor.action != "UI")
            tempActor.type = "action";
        else if(tempActor.refresh)
            tempActor.type = "refresh";
        else if (tempActor.add)
            tempActor.type = "add";
        else
            tempActor.type = "UI";

        //use previously built refresh string to load all subscribers that have refresh
        //if there are parents refreshing, then no need to refresh this node
        if(subscriber.parents(tempActor.refreshSelector).length == 0 || tempActor.type == "action"){
                
            //check and make sure subsrciber has an id
            tempActor.target = "#" + set_id(subscriber);
            //elgg.system_message("type"+tempActor.type);
            
            if(tempActor.prejs){
                var prejsArr = tempActor.prejs.substring(1,tempActor.prejs.length-1).split("|");
                for(var i=0, count = prejsArr.length; i < count; i++){
                        callbacks[prejsArr[i]](tempActor);
                }
            }
            delete tempActor.subscriberSelector;
            delete tempActor.refreshSelector;
            subscriberArr.push(tempActor);            
        }
    });                                                                           
    //jQuery("body").prepend("<p>subscriberArr: "+jQuery.toJSON(subscriberArr)+"</p>");
    return subscriberArr;
}

function multiAct(actors){
    elgg.action("parseAJAX",{
        data: {
            json: jQuery.toJSON(actors)
        },
        success: function(data) {
            var returnArr = data.output;
            if(!returnArr){
                //error returned from PHP, return error and UI back to normal
                var theparentparent = jQuery("[data-pub]").parent().unblock().parent();
                jQuery(".blockUI", theparentparent).css("cursor", "pointer");
                jQuery("[data-sub]").unblock();
                return false;
            }
            var globular = data.extra;
            var messages = data.system_messages;
//elgg.system_message("return"+jQuery.toJSON(returnArr));
            jQuery.each(returnArr, function(index, val){
                jQuery.extend(val,globular);
                jQuery.extend(val,messages);
                //elgg.system_message("type:"+val.type+" targ:"+val.target);
                switch(val.type){
                    //case "action":                        
                    //break;
                    /*case "UI":                        
                    break;*/
                    case "refresh":                        
                        //elgg.system_message("refresh!:"+val.target);
                        var thetarget = jQuery(val.target);                                
                        var theparent = thetarget.parent();
                        if(val.prejs && (val.prejs.indexOf("freeze") != -1 || val.prejs.indexOf("blockOverlay") != -1)){
                            jQuery(".blockUI", theparent).css({cursor: "pointer"});
                            thetarget.unblock();
                            jQuery("[aria-role='progressbar']", theparent).fadeOut(400);
                        }
                        
                        var thistarget = jQuery(val.target);
                        if(val.isPaginate || val.ispaginate || typeof(val.paginate) != "undefined") thistarget.siblings(".elgg-pagination").remove();            
                        thistarget.replaceWith(val.data);
                        if(val.postjs){
                            var postjsArr = val.postjs.substring(1,val.postjs.length-1).split("|");
                            for(var i=0, count = postjsArr.length; i < count; i++){
                                //alert("refresh"+postjsArr[i]);
                                callbacks[postjsArr[i]](val);   
                            }
                        }

                    break;
                    case "add":
                        var thetarget = jQuery(val.target);                                
                        var theparent = thetarget.parent();
                        if(val.postjs){
                            var postjsArr = val.postjs.substring(1,val.postjs.length-1).split("|");
                            for(var i=0, count = postjsArr.length; i < count; i++){
                                callbacks[postjsArr[i]](val);   
                                    //alert("add"+postjsArr[i]);
                            }
                        }else{
                            theparent.append(val.data);                            
                        }   
                    break;
                    default:
                        var thetarget = jQuery(val.target);                                
                        var theparent = thetarget.parent();
                        var theparentparent = theparent.parent();
                        jQuery(".blockUI", theparentparent).css({cursor: "pointer"});
                        theparent.unblock();
                        if(val.postjs){
                            var postjsArr = val.postjs.substring(1,val.postjs.length-1).split("|");
                            for(var i=0, count = postjsArr.length; i < count; i++){
                                //alert("default"+postjsArr[i]);
                                callbacks[postjsArr[i]](val);   
                            }
                        }
                    break;
                }
            });                
        },
        error: function(data){
            elgg.action("notify_error",{
                data: {
                    error: jQuery.toJSON(data)
                },
            });
            jQuery(".blockUI").remove();
        }  
    });                
}


elgg.provide('callbacks');
callbacks.grabcaptcha = function (data){
/*    var self = jQuery(data.publisherSelector) || data;
    var captchaval = jQuery("#recaptcha_response_field").val();
    var challenge = jQuery("#recaptcha_challenge_field").val();
    self.parent().find('input[name="recaptcha_response_field"], input[name="recaptcha_challenge_field"]').remove();
    self.parent()
        .append('<input type=\"hidden\" name="recaptcha_response_field" value="'+captchaval+'" />')
        .append('<input type=\"hidden\" name="recaptcha_challenge_field" value="'+challenge+'" />');
*/
    //alert("grab");      
}

callbacks.gotocaptcha = function (data){
/*    var self = jQuery(data.publisherSelector);
    var captcha = jQuery("#recaptcha_response_field").val();
    var challenge = jQuery("#recaptcha_challenge_field").val();
    self.parent().find('input[name="recaptcha_response_field"], input[name="recaptcha_challenge_field"]').remove();
    self.parent()
        .append('<input name="recaptcha_response_field" value="'+captcha+'" />')
        .append('<input name="recaptcha_challenge_field" value="'+challenge+'" />');
*/
    //alert("goto");                                    \

}

callbacks.refreshcaptcha = function (data){
    if(typeof Recaptcha != "undefined")
        Recaptcha.reload();
    
    //alert("refresh");                                                                           \
}

callbacks.spinner = function (data){
    var opts = {
      lines: 8, // The number of lines to draw
      length: 8, // The length of each line
      width: 1, // The line thickness
      radius: 2, // The radius of the inner circle
      color: '#000', // #rgb or #rrggbb
      speed: 1.5, // Rounds per second
      trail: 60, // Afterglow percentage
      shadow: false // Whether to render a shadow
    };
    var theparent = jQuery(data.target).spin(opts).parent();
    jQuery("[aria-role='progressbar']", theparent).css("display", "none").fadeIn(200);
}

callbacks.blockOverlay = function (data){
    var opts = {
        overlayCSS:  { 
            backgroundColor: '#000', 
            opacity:         .1,
            cursor: "wait" 
        },
        fadeIn: 200,
        fadeOut: 400,
        message: null,
    }
    jQuery(data.target).block(opts);
}
          
callbacks.blockNoOverlay = function (data){
    var opts = {
        overlayCSS:  { 
            backgroundColor: "#FFF",
            opacity:         .1,
            cursor: "pointer", 
        },
        message: null,
        fadeIn: 10,
        fadeOut: 10,         
    }
    jQuery(data.target).block(opts);
}

callbacks.mustlogin = function(data){
    var logindropdown = function(){
        if(!jQuery("#login-dropdown-box:visible").length){
            jQuery("#login-dropdown > a").trigger("click");
            elgg.system_message(elgg.echo("pleaselogin"));
        }
    }
    var whichone = ( jQuery.browser.mozilla || jQuery.browser.msie || jQuery.browser.opera )? "html" : "body";
    var body = jQuery(whichone);
    if(body.scrollTop() === 0){
        setTimeout(logindropdown, 10);
    }else{                
        body.animate({ scrollTop: 0 }
                                , 1000
                                , logindropdown
        );
    }            
}
          
callbacks.freeze = function (data){
    callbacks.blockOverlay(data);
//    setTimeout(jQuery.proxy(function(){
        callbacks.spinner(data);
//    }, data), 200);
}
                
//utils
function get_namespaced(pubtypeString){
    pubtypeString = pubtypeString.substring(1,pubtypeString.length-1);
    var pubtypeArr = pubtypeString.split("|");
    var types = [];
    for(var i=0, typeLen=pubtypeArr.length; i < typeLen; i++){
        var tempTypes = pubtypeArr[i].split(".");
        for(var x=0, typeLenx = tempTypes.length, tempString = ""; x < typeLenx; x++){
            tempString = "";
            for(var y=0; y <= x ; y++){
                tempString += "."+tempTypes[y];
            }
            tempString = tempString.ltrim(".");
            types.push(tempString);                
        }
    }
    return types;    
}    

function set_id(item){
    var pubid = item.attr("id");
    if(pubid == "" || typeof(pubid) == "undefined" || !pubid){
        var newid = "item"+Math.floor(Math.random()*111111);
        item.attr("id", newid);
        return newid;
    }
    return pubid;
}

var blockOpts = {
    overlayCSS:  { 
        backgroundColor: "#FFF",
        opacity:         .1,
        cursor: "pointer", 
    },
    message: null,
    fadeIn: 10,
    fadeOut: 10,         
}

Array.prototype.unique =
  function() {
    var a = [];
    var l = this.length;
    for(var i=0; i<l; i++) {
      for(var j=i+1; j<l; j++) {
        // If this[i] is found later in the array
        if (this[i] === this[j])
          j = ++i;
      }
      a.push(this[i]);
    }
    return a;
};

// Chosen, a Select Box Enhancer for jQuery and Protoype
// by Patrick Filler for Harvest, http://getharvest.com
// 
// Version 0.9.8
// Full source at https://github.com/harvesthq/chosen
// Copyright (c) 2011 Harvest http://getharvest.com

// MIT License, https://github.com/harvesthq/chosen/blob/master/LICENSE.md
// This file is generated by `cake build`, do not edit it by hand.
((function(){var a;a=function(){function a(){this.options_index=0,this.parsed=[]}return a.prototype.add_node=function(a){return a.nodeName==="OPTGROUP"?this.add_group(a):this.add_option(a)},a.prototype.add_group=function(a){var b,c,d,e,f,g;b=this.parsed.length,this.parsed.push({array_index:b,group:!0,label:a.label,children:0,disabled:a.disabled}),f=a.childNodes,g=[];for(d=0,e=f.length;d<e;d++)c=f[d],g.push(this.add_option(c,b,a.disabled));return g},a.prototype.add_option=function(a,b,c){if(a.nodeName==="OPTION")return a.text!==""?(b!=null&&(this.parsed[b].children+=1),this.parsed.push({array_index:this.parsed.length,options_index:this.options_index,value:a.value,text:a.text,html:a.innerHTML,selected:a.selected,disabled:c===!0?c:a.disabled,group_array_index:b,classes:a.className,style:a.style.cssText})):this.parsed.push({array_index:this.parsed.length,options_index:this.options_index,empty:!0}),this.options_index+=1},a}(),a.select_to_array=function(b){var c,d,e,f,g;d=new a,g=b.childNodes;for(e=0,f=g.length;e<f;e++)c=g[e],d.add_node(c);return d.parsed},this.SelectParser=a})).call(this),function(){var a,b;b=this,a=function(){function a(a,b){this.form_field=a,this.options=b!=null?b:{},this.set_default_values(),this.is_multiple=this.form_field.multiple,this.set_default_text(),this.setup(),this.set_up_html(),this.register_observers(),this.finish_setup()}return a.prototype.set_default_values=function(){var a=this;return this.click_test_action=function(b){return a.test_active_click(b)},this.activate_action=function(b){return a.activate_field(b)},this.active_field=!1,this.mouse_on_container=!1,this.results_showing=!1,this.result_highlighted=null,this.result_single_selected=null,this.allow_single_deselect=this.options.allow_single_deselect!=null&&this.form_field.options[0]!=null&&this.form_field.options[0].text===""?this.options.allow_single_deselect:!1,this.disable_search_threshold=this.options.disable_search_threshold||0,this.search_contains=this.options.search_contains||!1,this.choices=0,this.max_selected_options=this.options.max_selected_options||Infinity},a.prototype.set_default_text=function(){return this.form_field.getAttribute("data-placeholder")?this.default_text=this.form_field.getAttribute("data-placeholder"):this.is_multiple?this.default_text=this.options.placeholder_text_multiple||this.options.placeholder_text||"Select Some Options":this.default_text=this.options.placeholder_text_single||this.options.placeholder_text||"Select an Option",this.results_none_found=this.form_field.getAttribute("data-no_results_text")||this.options.no_results_text||"No results match"},a.prototype.mouse_enter=function(){return this.mouse_on_container=!0},a.prototype.mouse_leave=function(){return this.mouse_on_container=!1},a.prototype.input_focus=function(a){var b=this;if(!this.active_field)return setTimeout(function(){return b.container_mousedown()},50)},a.prototype.input_blur=function(a){var b=this;if(!this.mouse_on_container)return this.active_field=!1,setTimeout(function(){return b.blur_test()},100)},a.prototype.result_add_option=function(a){var b,c;return a.disabled?"":(a.dom_id=this.container_id+"_o_"+a.array_index,b=a.selected&&this.is_multiple?[]:["active-result"],a.selected&&b.push("result-selected"),a.group_array_index!=null&&b.push("group-option"),a.classes!==""&&b.push(a.classes),c=a.style.cssText!==""?' style="'+a.style+'"':"",'<li id="'+a.dom_id+'" class="'+b.join(" ")+'"'+c+">"+a.html+"</li>")},a.prototype.results_update_field=function(){return this.is_multiple||this.results_reset_cleanup(),this.result_clear_highlight(),this.result_single_selected=null,this.results_build()},a.prototype.results_toggle=function(){return this.results_showing?this.results_hide():this.results_show()},a.prototype.results_search=function(a){return this.results_showing?this.winnow_results():this.results_show()},a.prototype.keyup_checker=function(a){var b,c;b=(c=a.which)!=null?c:a.keyCode,this.search_field_scale();switch(b){case 8:if(this.is_multiple&&this.backstroke_length<1&&this.choices>0)return this.keydown_backstroke();if(!this.pending_backstroke)return this.result_clear_highlight(),this.results_search();break;case 13:a.preventDefault();if(this.results_showing)return this.result_select(a);break;case 27:return this.results_showing&&this.results_hide(),!0;case 9:case 38:case 40:case 16:case 91:case 17:break;default:return this.results_search()}},a.prototype.generate_field_id=function(){var a;return a=this.generate_random_id(),this.form_field.id=a,a},a.prototype.generate_random_char=function(){var a,b,c;return a="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ",c=Math.floor(Math.random()*a.length),b=a.substring(c,c+1)},a}(),b.AbstractChosen=a}.call(this),function(){var a,b,c,d,e=Object.prototype.hasOwnProperty,f=function(a,b){function d(){this.constructor=a}for(var c in b)e.call(b,c)&&(a[c]=b[c]);return d.prototype=b.prototype,a.prototype=new d,a.__super__=b.prototype,a};d=this,a=jQuery,a.fn.extend({chosen:function(c){return!a.browser.msie||a.browser.version!=="6.0"&&a.browser.version!=="7.0"?this.each(function(d){var e;e=a(this);if(!e.hasClass("chzn-done"))return e.data("chosen",new b(this,c))}):this}}),b=function(b){function e(){e.__super__.constructor.apply(this,arguments)}return f(e,b),e.prototype.setup=function(){return this.form_field_jq=a(this.form_field),this.is_rtl=this.form_field_jq.hasClass("chzn-rtl")},e.prototype.finish_setup=function(){return this.form_field_jq.addClass("chzn-done")},e.prototype.set_up_html=function(){var b,d,e,f;return this.container_id=this.form_field.id.length?this.form_field.id.replace(/[^\w]/g,"_"):this.generate_field_id(),this.container_id+="_chzn",this.f_width=this.form_field_jq.outerWidth(),b=a("<div />",{id:this.container_id,"class":"chzn-container"+(this.is_rtl?" chzn-rtl":""),style:"width: "+this.f_width+"px;"}),this.is_multiple?b.html('<ul class="chzn-choices"><li class="search-field"><input type="text" value="'+this.default_text+'" class="default" autocomplete="off" style="width:25px;" /></li></ul><div class="chzn-drop" style="left:-9000px;"><ul class="chzn-results"></ul></div>'):b.html('<a href="javascript:void(0)" class="chzn-single chzn-default"><span>'+this.default_text+'</span><div><b></b></div></a><div class="chzn-drop" style="left:-9000px;"><div class="chzn-search"><input type="text" autocomplete="off" /></div><ul class="chzn-results"></ul></div>'),this.form_field_jq.hide().after(b),this.container=a("#"+this.container_id),this.container.addClass("chzn-container-"+(this.is_multiple?"multi":"single")),this.dropdown=this.container.find("div.chzn-drop").first(),d=this.container.height(),e=this.f_width-c(this.dropdown),this.dropdown.css({width:e+"px",top:d+"px"}),this.search_field=this.container.find("input").first(),this.search_results=this.container.find("ul.chzn-results").first(),this.search_field_scale(),this.search_no_results=this.container.find("li.no-results").first(),this.is_multiple?(this.search_choices=this.container.find("ul.chzn-choices").first(),this.search_container=this.container.find("li.search-field").first()):(this.search_container=this.container.find("div.chzn-search").first(),this.selected_item=this.container.find(".chzn-single").first(),f=e-c(this.search_container)-c(this.search_field),this.search_field.css({width:f+"px"})),this.results_build(),this.set_tab_index(),this.form_field_jq.trigger("liszt:ready",{chosen:this})},e.prototype.register_observers=function(){var a=this;return this.container.mousedown(function(b){return a.container_mousedown(b)}),this.container.mouseup(function(b){return a.container_mouseup(b)}),this.container.mouseenter(function(b){return a.mouse_enter(b)}),this.container.mouseleave(function(b){return a.mouse_leave(b)}),this.search_results.mouseup(function(b){return a.search_results_mouseup(b)}),this.search_results.mouseover(function(b){return a.search_results_mouseover(b)}),this.search_results.mouseout(function(b){return a.search_results_mouseout(b)}),this.form_field_jq.bind("liszt:updated",function(b){return a.results_update_field(b)}),this.search_field.blur(function(b){return a.input_blur(b)}),this.search_field.keyup(function(b){return a.keyup_checker(b)}),this.search_field.keydown(function(b){return a.keydown_checker(b)}),this.is_multiple?(this.search_choices.click(function(b){return a.choices_click(b)}),this.search_field.focus(function(b){return a.input_focus(b)})):this.container.click(function(a){return a.preventDefault()})},e.prototype.search_field_disabled=function(){this.is_disabled=this.form_field_jq[0].disabled;if(this.is_disabled)return this.container.addClass("chzn-disabled"),this.search_field[0].disabled=!0,this.is_multiple||this.selected_item.unbind("focus",this.activate_action),this.close_field();this.container.removeClass("chzn-disabled"),this.search_field[0].disabled=!1;if(!this.is_multiple)return this.selected_item.bind("focus",this.activate_action)},e.prototype.container_mousedown=function(b){var c;if(!this.is_disabled)return c=b!=null?a(b.target).hasClass("search-choice-close"):!1,b&&b.type==="mousedown"&&!this.results_showing&&b.stopPropagation(),!this.pending_destroy_click&&!c?(this.active_field?!this.is_multiple&&b&&(a(b.target)[0]===this.selected_item[0]||a(b.target).parents("a.chzn-single").length)&&(b.preventDefault(),this.results_toggle()):(this.is_multiple&&this.search_field.val(""),a(document).click(this.click_test_action),this.results_show()),this.activate_field()):this.pending_destroy_click=!1},e.prototype.container_mouseup=function(a){if(a.target.nodeName==="ABBR"&&!this.is_disabled)return this.results_reset(a)},e.prototype.blur_test=function(a){if(!this.active_field&&this.container.hasClass("chzn-container-active"))return this.close_field()},e.prototype.close_field=function(){return a(document).unbind("click",this.click_test_action),this.is_multiple||(this.selected_item.attr("tabindex",this.search_field.attr("tabindex")),this.search_field.attr("tabindex",-1)),this.active_field=!1,this.results_hide(),this.container.removeClass("chzn-container-active"),this.winnow_results_clear(),this.clear_backstroke(),this.show_search_field_default(),this.search_field_scale()},e.prototype.activate_field=function(){return!this.is_multiple&&!this.active_field&&(this.search_field.attr("tabindex",this.selected_item.attr("tabindex")),this.selected_item.attr("tabindex",-1)),this.container.addClass("chzn-container-active"),this.active_field=!0,this.search_field.val(this.search_field.val()),this.search_field.focus()},e.prototype.test_active_click=function(b){return a(b.target).parents("#"+this.container_id).length?this.active_field=!0:this.close_field()},e.prototype.results_build=function(){var a,b,c,e,f;this.parsing=!0,this.results_data=d.SelectParser.select_to_array(this.form_field),this.is_multiple&&this.choices>0?(this.search_choices.find("li.search-choice").remove(),this.choices=0):this.is_multiple||(this.selected_item.addClass("chzn-default").find("span").text(this.default_text),this.form_field.options.length<=this.disable_search_threshold?this.container.addClass("chzn-container-single-nosearch"):this.container.removeClass("chzn-container-single-nosearch")),a="",f=this.results_data;for(c=0,e=f.length;c<e;c++)b=f[c],b.group?a+=this.result_add_group(b):b.empty||(a+=this.result_add_option(b),b.selected&&this.is_multiple?this.choice_build(b):b.selected&&!this.is_multiple&&(this.selected_item.removeClass("chzn-default").find("span").text(b.text),this.allow_single_deselect&&this.single_deselect_control_build()));return this.search_field_disabled(),this.show_search_field_default(),this.search_field_scale(),this.search_results.html(a),this.parsing=!1},e.prototype.result_add_group=function(b){return b.disabled?"":(b.dom_id=this.container_id+"_g_"+b.array_index,'<li id="'+b.dom_id+'" class="group-result">'+a("<div />").text(b.label).html()+"</li>")},e.prototype.result_do_highlight=function(a){var b,c,d,e,f;if(a.length){this.result_clear_highlight(),this.result_highlight=a,this.result_highlight.addClass("highlighted"),d=parseInt(this.search_results.css("maxHeight"),10),f=this.search_results.scrollTop(),e=d+f,c=this.result_highlight.position().top+this.search_results.scrollTop(),b=c+this.result_highlight.outerHeight();if(b>=e)return this.search_results.scrollTop(b-d>0?b-d:0);if(c<f)return this.search_results.scrollTop(c)}},e.prototype.result_clear_highlight=function(){return this.result_highlight&&this.result_highlight.removeClass("highlighted"),this.result_highlight=null},e.prototype.results_show=function(){var a;if(!this.is_multiple)this.selected_item.addClass("chzn-single-with-drop"),this.result_single_selected&&this.result_do_highlight(this.result_single_selected);else if(this.max_selected_options<=this.choices)return this.form_field_jq.trigger("liszt:maxselected",{chosen:this}),!1;return a=this.is_multiple?this.container.height():this.container.height()-1,this.form_field_jq.trigger("liszt:showing_dropdown",{chosen:this}),this.dropdown.css({top:a+"px",left:0}),this.results_showing=!0,this.search_field.focus(),this.search_field.val(this.search_field.val()),this.winnow_results()},e.prototype.results_hide=function(){return this.is_multiple||this.selected_item.removeClass("chzn-single-with-drop"),this.result_clear_highlight(),this.form_field_jq.trigger("liszt:hiding_dropdown",{chosen:this}),this.dropdown.css({left:"-9000px"}),this.results_showing=!1},e.prototype.set_tab_index=function(a){var b;if(this.form_field_jq.attr("tabindex"))return b=this.form_field_jq.attr("tabindex"),this.form_field_jq.attr("tabindex",-1),this.is_multiple?this.search_field.attr("tabindex",b):(this.selected_item.attr("tabindex",b),this.search_field.attr("tabindex",-1))},e.prototype.show_search_field_default=function(){return this.is_multiple&&this.choices<1&&!this.active_field?(this.search_field.val(this.default_text),this.search_field.addClass("default")):(this.search_field.val(""),this.search_field.removeClass("default"))},e.prototype.search_results_mouseup=function(b){var c;c=a(b.target).hasClass("active-result")?a(b.target):a(b.target).parents(".active-result").first();if(c.length)return this.result_highlight=c,this.result_select(b)},e.prototype.search_results_mouseover=function(b){var c;c=a(b.target).hasClass("active-result")?a(b.target):a(b.target).parents(".active-result").first();if(c)return this.result_do_highlight(c)},e.prototype.search_results_mouseout=function(b){if(a(b.target).hasClass("active-result"))return this.result_clear_highlight()},e.prototype.choices_click=function(b){b.preventDefault();if(this.active_field&&!a(b.target).hasClass("search-choice")&&!this.results_showing)return this.results_show()},e.prototype.choice_build=function(b){var c,d,e=this;return this.is_multiple&&this.max_selected_options<=this.choices?(this.form_field_jq.trigger("liszt:maxselected",{chosen:this}),!1):(c=this.container_id+"_c_"+b.array_index,this.choices+=1,this.search_container.before('<li class="search-choice" id="'+c+'"><span>'+b.html+'</span><a href="javascript:void(0)" class="search-choice-close" rel="'+b.array_index+'"></a></li>'),d=a("#"+c).find("a").first(),d.click(function(a){return e.choice_destroy_link_click(a)}))},e.prototype.choice_destroy_link_click=function(b){return b.preventDefault(),this.is_disabled?b.stopPropagation:(this.pending_destroy_click=!0,this.choice_destroy(a(b.target)))},e.prototype.choice_destroy=function(a){return this.choices-=1,this.show_search_field_default(),this.is_multiple&&this.choices>0&&this.search_field.val().length<1&&this.results_hide(),this.result_deselect(a.attr("rel")),a.parents("li").first().remove()},e.prototype.results_reset=function(){this.form_field.options[0].selected=!0,this.selected_item.find("span").text(this.default_text),this.is_multiple||this.selected_item.addClass("chzn-default"),this.show_search_field_default(),this.results_reset_cleanup(),this.form_field_jq.trigger("change");if(this.active_field)return this.results_hide()},e.prototype.results_reset_cleanup=function(){return this.selected_item.find("abbr").remove()},e.prototype.result_select=function(a){var b,c,d,e;if(this.result_highlight)return b=this.result_highlight,c=b.attr("id"),this.result_clear_highlight(),this.is_multiple?this.result_deactivate(b):(this.search_results.find(".result-selected").removeClass("result-selected"),this.result_single_selected=b,this.selected_item.removeClass("chzn-default")),b.addClass("result-selected"),e=c.substr(c.lastIndexOf("_")+1),d=this.results_data[e],d.selected=!0,this.form_field.options[d.options_index].selected=!0,this.is_multiple?this.choice_build(d):(this.selected_item.find("span").first().text(d.text),this.allow_single_deselect&&this.single_deselect_control_build()),(!a.metaKey||!this.is_multiple)&&this.results_hide(),this.search_field.val(""),this.form_field_jq.trigger("change",{selected:this.form_field.options[d.options_index].value}),this.search_field_scale()},e.prototype.result_activate=function(a){return a.addClass("active-result")},e.prototype.result_deactivate=function(a){return a.removeClass("active-result")},e.prototype.result_deselect=function(b){var c,d;return d=this.results_data[b],d.selected=!1,this.form_field.options[d.options_index].selected=!1,c=a("#"+this.container_id+"_o_"+b),c.removeClass("result-selected").addClass("active-result").show(),this.result_clear_highlight(),this.winnow_results(),this.form_field_jq.trigger("change",{deselected:this.form_field.options[d.options_index].value}),this.search_field_scale()},e.prototype.single_deselect_control_build=function(){if(this.allow_single_deselect&&this.selected_item.find("abbr").length<1)return this.selected_item.find("span").first().after('<abbr class="search-choice-close"></abbr>')},e.prototype.winnow_results=function(){var b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s;this.no_results_clear(),j=0,k=this.search_field.val()===this.default_text?"":a("<div/>").text(a.trim(this.search_field.val())).html(),g=this.search_contains?"":"^",f=new RegExp(g+k.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&"),"i"),n=new RegExp(k.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&"),"i"),s=this.results_data;for(o=0,q=s.length;o<q;o++){c=s[o];if(!c.disabled&&!c.empty)if(c.group)a("#"+c.dom_id).css("display","none");else if(!this.is_multiple||!c.selected){b=!1,i=c.dom_id,h=a("#"+i);if(f.test(c.html))b=!0,j+=1;else if(c.html.indexOf(" ")>=0||c.html.indexOf("[")===0){e=c.html.replace(/\[|\]/g,"").split(" ");if(e.length)for(p=0,r=e.length;p<r;p++)d=e[p],f.test(d)&&(b=!0,j+=1)}b?(k.length?(l=c.html.search(n),m=c.html.substr(0,l+k.length)+"</em>"+c.html.substr(l+k.length),m=m.substr(0,l)+"<em>"+m.substr(l)):m=c.html,h.html(m),this.result_activate(h),c.group_array_index!=null&&a("#"+this.results_data[c.group_array_index].dom_id).css("display","list-item")):(this.result_highlight&&i===this.result_highlight.attr("id")&&this.result_clear_highlight(),this.result_deactivate(h))}}return j<1&&k.length?this.no_results(k):this.winnow_results_set_highlight()},e.prototype.winnow_results_clear=function(){var b,c,d,e,f;this.search_field.val(""),c=this.search_results.find("li"),f=[];for(d=0,e=c.length;d<e;d++)b=c[d],b=a(b),b.hasClass("group-result")?f.push(b.css("display","auto")):!this.is_multiple||!b.hasClass("result-selected")?f.push(this.result_activate(b)):f.push(void 0);return f},e.prototype.winnow_results_set_highlight=function(){var a,b;if(!this.result_highlight){b=this.is_multiple?[]:this.search_results.find(".result-selected.active-result"),a=b.length?b.first():this.search_results.find(".active-result").first();if(a!=null)return this.result_do_highlight(a)}},e.prototype.no_results=function(b){var c;return c=a('<li class="no-results">'+this.results_none_found+' "<span></span>"</li>'),c.find("span").first().html(b),this.search_results.append(c)},e.prototype.no_results_clear=function(){return this.search_results.find(".no-results").remove()},e.prototype.keydown_arrow=function(){var b,c;this.result_highlight?this.results_showing&&(c=this.result_highlight.nextAll("li.active-result").first(),c&&this.result_do_highlight(c)):(b=this.search_results.find("li.active-result").first(),b&&this.result_do_highlight(a(b)));if(!this.results_showing)return this.results_show()},e.prototype.keyup_arrow=function(){var a;if(!this.results_showing&&!this.is_multiple)return this.results_show();if(this.result_highlight)return a=this.result_highlight.prevAll("li.active-result"),a.length?this.result_do_highlight(a.first()):(this.choices>0&&this.results_hide(),this.result_clear_highlight())},e.prototype.keydown_backstroke=function(){return this.pending_backstroke?(this.choice_destroy(this.pending_backstroke.find("a").first()),this.clear_backstroke()):(this.pending_backstroke=this.search_container.siblings("li.search-choice").last(),this.pending_backstroke.addClass("search-choice-focus"))},e.prototype.clear_backstroke=function(){return this.pending_backstroke&&this.pending_backstroke.removeClass("search-choice-focus"),this.pending_backstroke=null},e.prototype.keydown_checker=function(a){var b,c;b=(c=a.which)!=null?c:a.keyCode,this.search_field_scale(),b!==8&&this.pending_backstroke&&this.clear_backstroke();switch(b){case 8:this.backstroke_length=this.search_field.val().length;break;case 9:this.results_showing&&!this.is_multiple&&this.result_select(a),this.mouse_on_container=!1;break;case 13:a.preventDefault();break;case 38:a.preventDefault(),this.keyup_arrow();break;case 40:this.keydown_arrow()}},e.prototype.search_field_scale=function(){var b,c,d,e,f,g,h,i,j;if(this.is_multiple){d=0,h=0,f="position:absolute; left: -1000px; top: -1000px; display:none;",g=["font-size","font-style","font-weight","font-family","line-height","text-transform","letter-spacing"];for(i=0,j=g.length;i<j;i++)e=g[i],f+=e+":"+this.search_field.css(e)+";";return c=a("<div />",{style:f}),c.text(this.search_field.val()),a("body").append(c),h=c.width()+25,c.remove(),h>this.f_width-10&&(h=this.f_width-10),this.search_field.css({width:h+"px"}),b=this.container.height(),this.dropdown.css({top:b+"px"})}},e.prototype.generate_random_id=function(){var b;b="sel"+this.generate_random_char()+this.generate_random_char()+this.generate_random_char();while(a("#"+b).length>0)b+=this.generate_random_char();return b},e}(AbstractChosen),c=function(a){var b;return b=a.outerWidth()-a.width()},d.get_side_border_padding=c}.call(this);
