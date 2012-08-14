<?php

?>
<!--//*************************************************//
<!--//********* BEGIN ** MAIN ** SLIDER ***************//
<!--//*************************************************//-->

<style>

#mainslider, #twitterbar{
    opacity:0;
    position:absolute;
}

#mainslider{
    color: #004d7a;
    height: 330px;
    width: 610px;
    position:relative;
}

.tk-main-slider{
    -webkit-box-shadow: -3px -3px 14px rgba(155, 155, 155, .6);
    -moz-box-shadow: -3px -3px 14px rgba(155, 155, 155, .6);
    box-shadow: -3px -3px 14px rgba(155, 155, 155, .6);    
    padding: 0;
    margin-top: 5px;
    margin-bottom: 0px;
}
    

#mainslider .thumbs, #mainslider .thumbs img{
    width: auto;
    cursor: pointer;
    vertical-align: top;
    margin-left:10px;
}

#mainslider .thumbs.tinythumb, 
#mainslider .thumbs.tinythumb img
{
    width:13px;
    margin-left:0px;
}

#mainslider .thumbs.tinythumb img,
#mainslider .tinychans img
{
    vertical-align: -60%;
    padding: 2px;    
    width: 12px;
}

#mainslider .dailystories .elgg-item{
    border-left: 1px solid grey;
    border-top: 1px solid #CCC;
    margin: 15px 55px 0 -15px;
    padding-left:4px;
    padding-top:3px;
    clear:both;
}

#mainslider .dailystories .elgg-item:hover{
    border-top: 1px solid grey;
    border-left: 2px solid black;
}
#mainslider .dailystories .friendlydate{
    font-size:10px;
}

#mainslider .dailystories .elgg-item a{
    
    display: block;
}

#mainslider .tinychans, #mainslider .tabmeta{
    float:right;
*margin-left: 5px;
    }
#mainslider .likescount{
    font-size: 16px;   
}

#mainslider .elgg-avatar > span, #mainslider .elgg-avatar > span > img{
    display: inline-block;
    width:25px;
    height:25px;
}

#mainslider .showcase-load
{
    height: 294px; /* Same as showcase javascript option */
    overflow: hidden;
background: rgb(250,250,250); /* Old browsers */
background: -moz-radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%, rgb(255,255,255) 62%); /* FF3.6+ */
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(31%,rgb(250,250,250)), color-stop(62%,rgb(255,255,255))); /* Chrome,Safari4+ */
background: -webkit-radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%,rgb(255,255,255) 62%); /* Chrome10+,Safari5.1+ */
background: -o-radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%,rgb(255,255,255) 62%); /* Opera 12+ */
background: -ms-radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%,rgb(255,255,255) 62%); /* IE10+ */
background: radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%,rgb(255,255,255) 62%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fafafa', endColorstr='#ffffff',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}

#mainslider .tweetbox a:hover{
    text-decoration: underline;   
}

#mainslider .showcase-content-wrapper{
    height:294px;
    text-align: left;
}

#mainslider .showcase-content-container > div.showcase-content{
    left:0px;
background: rgb(250,250,250); /* Old browsers */
background: -moz-radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%, rgb(255,255,255) 62%); /* FF3.6+ */
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(31%,rgb(250,250,250)), color-stop(62%,rgb(255,255,255))); /* Chrome,Safari4+ */
background: -webkit-radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%,rgb(255,255,255) 62%); /* Chrome10+,Safari5.1+ */
background: -o-radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%,rgb(255,255,255) 62%); /* Opera 12+ */
background: -ms-radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%,rgb(255,255,255) 62%); /* IE10+ */
background: radial-gradient(center, ellipse cover,  rgb(250,250,250) 31%,rgb(255,255,255) 62%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fafafa', endColorstr='#ffffff',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}

#mainslider .showcase-content-container{
border: 1px solid #d0a8b1;
border-bottom: 0;
}

/*#mainslider #slider-timerbar{
    clear:both;
    float:right;
    position:relative;
    bottom:0;
    left:0;
    background-color: #999;
    height: 3px;
    width: 100%;
    opacity: .4;
    *height: 1px;
    *width:570px;
} */
#mainslider{
    text-align:right;
}


#mainslider .showcase-arrow-previous, #mainslider .showcase-arrow-next{
    position: absolute;
    top: 140px;
    width: 0;
    height: 0;
    left: auto;
    right: -12px;
    cursor: pointer;
    z-index:999999;
    background-color: #999;
    color: #EEE;
    display: none;
}
#mainslider .showcase-arrow-previous:after, #mainslider .showcase-arrow-next:after{
    position: absolute;
    top: 0;
    right: 0;
    left: auto;
    font-size: 30px;
    font-weight: bold;
    width: 21px;
    height: 22px;
    cursor: pointer;
    z-index: 999999;
    content: ">";
    padding-top: 4px;
    padding-right: 3px;
    background-color: #999;
    color: #EEE;
}
#mainslider .showcase-arrow-previous{
    left: 13px;
    right: auto;
}
#mainslider .showcase-arrow-previous:after{
    width:21px;
    padding-right: 3px;
    content: "<";        
}

#mainslider .showcase-arrow-previous:hover:after, 
#mainslider .showcase-arrow-next:hover:after{
    background-color: #666;
    color: #EEE;
}


#mainslider .showcase-button-wrapper{
    margin-top: 0;
    text-align: right;
    height: 27px;
    background-color: #333;
    padding-top:8px;
    padding-right:8px;
}

#mainslider .showcase-button-wrapper > span{
    color: transparent;
    width:10px;
    height:10px;
    border-radius:5px;
    background-color:#DDD;
    padding:0 !important;
    display:inline-block;
    margin:6px;
    margin-left: 2px;
}
#mainslider .showcase-button-wrapper > span.active{
    background-color:white;
}


.mainslidetext {
position: absolute;
top: 64px;
font-size: 20px;
line-height: 30px;
color: #555;
text-shadow: 2px 2px 0px white;
display: inline-block;
width: 300px;
font-weight: bold;
}
.slide{
    display:block;
    width:100%;
    height:100%;
    padding:30px 35px;    
}

#mainslider .bigiconholder{
    position:absolute;
    right:40px;
    top:50px;
    opacity:.9;
    display: inline-block;
    z-index:100;
}

#mainslider .addshadow{
    text-align: center;
    display:inline-block;
}

#mainslider .addshadow .badge{
    max-width: 80px;
    max-height: 80px;
    margin-bottom: 18%;
}

#mainslider .addshadow .bigicon{
    margin-bottom: 18%;
    opacity: .9;
}

#mainslider .addshadow .icondrop{
    z-index: 1;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
}

#mainslider .icondrop{
    height: 30%;
    opacity: .2;    
}

#mainslider .badgeholder{
    position:absolute;
    bottom:175px;
    right:25px;        
}

.contentslide{
    width: 540px;    
}

.badgespacer{
    float:right;
    width:75px;
    height:10px;
}

.showcase-content-wrapper .badge{
 opacity: .6;
}
.showcase-content-wrapper:hover .badge{
 opacity: .8;
}

#mainslider h3{
    margin-bottom:6px;
    font-size: 12px;   
    
}
#mainslider h2{
    margin-bottom: 10px;
    border: 0;
    padding:0;
}

#mainslider .elgg-image-block{
 display:block;
 width: 100%;
 
 margin-bottom:10px;
 color: #AAA;   
    
}


.slide-commentary-post{
    
 margin-bottom: 20px;   
}

#mainslider .doyoulike{
    font-size:14px;
    display:inline-block;
}

</style>

<div id="mainslider">
<? 


//INTRO SLIDE
$url = "{$CONFIG->wwwroot}channels/lastnight";
$img = '<img class="bigicon" src="' . elgg_normalize_url("_graphics/becomeacritic/becomeacritic_2.png") . '">';
$icondrop = '<img class="icondrop" src="' . elgg_normalize_url("_graphics/icondrop.png") . '">';
$text = elgg_echo("becomeacritic:lastnight");
$slides[] = <<< ENDSLIDE

<a href="$url" class="mainslide slide">
    <span class="mainslideimg">
        <span class="bigiconholder addshadow">
            $icondrop
            $img
        </span>
    </span>
    <span class="mainslidetext">
        $text  
    </span>
</a>

ENDSLIDE;
//INTRO SLIDE
        
//SET UP COMMENTARY GETTER OPTIONS
    $options = array(
        'type' => 'object',
        'subtype' => 'commentary',
        'full_view' => FALSE,
        'slide_view' => TRUE,
        'hot_comments' => FALSE,
        'normal_comments' => FALSE,
        'limit' => 1,
    );
//SET UP COMMENTARY GETTER OPTIONS
/*
//LATEST ADMIN EDITORIAL
    $admins = elgg_get_admins();
    foreach($admins as $admin)$owner_guids[] = $admin->guid;
    $options['owner_guids'] = $owner_guids;
    $moduletitle = elgg_echo("commentary:editor_created");
    $commentary = elgg_get_entities($options);
    if($commentary){
        $body = elgg_view_entity($commentary[0], $options);
        $url = $commentary[0]->getURL();
        $slides[] = "<a href=\"$url\" class=\"slide contentslide\">"
            . elgg_view_module('commentary', $moduletitle, $body)
            . "</a>";
    }
    unset($options['owner_guids']); 
//LATEST ADMIN EDITORIAL
*/

//DAILY STORIES
    $moduletitle = elgg_echo("commentary:dailystory");

    $options['metadata_name_value_pairs'] = array('name' => 'status', 'value' => 'dailystory');
    $options['limit'] = 5;
    $options['full_view'] = false;
    $options['slide_view'] = false;
    $options['story_view'] = true;
    $options['pagination'] = false;
    $options['class'] = "dailystories";

    $body = elgg_list_entities_from_metadata($options);

    //add generic badge
    $badgeurl = elgg_normalize_url("_graphics/single.png");        
    $badgespacer = "<span class=\"badgespacer\">&nbsp;</span>";        
    $badgeholder = add_dropshadow($badgeurl, "badge");

    $slides[] = "<div class=\"slide contentslide\">"
        . $badgespacer
        . elgg_view_module('commentary', $moduletitle, $body)
        . $badgeholder
        . "</div>";

    unset($options['metadata_name_value_pairs']); 
    unset($options['full_view']); 
    unset($options['module_view']); 
    unset($options['class']); 
//DAILY STORIES

//rewind!
    $options = array(
        'type' => 'object',
        'subtype' => 'commentary',
        'full_view' => FALSE,
        'slide_view' => TRUE,
        'hot_comments' => FALSE,
        'normal_comments' => FALSE,
        'limit' => 1,
    );
 /* 
//MOST POPULAR
    $options['order_by_metadata'] = array('name' => 'popularity', 'direction' => 'DESC', 'as' => 'integer');
    $options['badge'] = "popularityGold";
    $moduletitle = elgg_echo("commentary:most_popular");
    $commentary = elgg_get_entities_from_metadata($options);
    if($commentary){
        $body = elgg_view_entity($commentary = $commentary[0], $options);
        $url = $commentary->getURL();
        $slides[] = "<a href=\"$url\" class=\"slide contentslide\">"
            . elgg_view_module('commentary', $moduletitle, $body)
            . "</a>";
    }
    unset($options['order_by_metadata'], $options['badge']); 
//MOST POPULAR
    
//MOST CONTROVERSIAL
    $options['order_by_metadata'] = array('name' => 'controversy', 'direction' => 'DESC', 'as' => 'integer');
    $options['badge'] = "controversyGold";
    $moduletitle = elgg_echo("commentary:most_controversial");
    $commentary = elgg_get_entities_from_metadata($options);
    if($commentary){
        $body = elgg_view_entity($commentary = $commentary[0], $options);
        $url = $commentary->getURL();
        $slides[] = "<a href=\"$url\" class=\"slide contentslide\">"
            . elgg_view_module('commentary', $moduletitle, $body)
            . "</a>";
    }
    unset($options['order_by_metadata'], $options['badge']); 
//MOST CONTROVERSIAL
    
//MOST DISCUSSED
    $options['annotation_names'] = array("generic_comment");
    $options['badge'] = "conversationGold";

    $moduletitle = elgg_echo("commentary:most_discussed");

    $commentary = elgg_get_entities_from_annotation_calculation($options);

    if($commentary){

        $body = elgg_view_entity($commentary = $commentary[0], $options);

        $url = $commentary->getURL();

        $slides[] = "<a href=\"$url\" class=\"slide contentslide\">"
            . elgg_view_module('commentary', $moduletitle, $body)
            . "</a>";

    }
    unset($options['annotation_names'], $options['badge']); 
//MOST DISCUSSED
    */
//FEATURED
    $moduletitle = elgg_echo("commentary:featured");

    $options['metadata_name_value_pairs'] = array('name' => 'status', 'value' => 'featured');
    $options['limit'] = 10;
    $commentaries = elgg_get_entities_from_metadata($options);
    foreach($commentaries as $commentary){
        $body = elgg_view_entity($commentary, $options);
        $url = $commentary->getURL();
        $slides[] = "<a href=\"$url\" class=\"slide contentslide\">"
            . elgg_view_module('commentary', $moduletitle, $body)
            . "</a>";
    }

    unset($options['metadata_name_value_pairs']); 
//FEATURED



//DISPLAY SLIDES
//$slides = array_merge($slides, $vars['slides']);

foreach($slides as $slide){
        echo "<div class=\"showcase-slide\">";
       // echo "<div class=\"showcase-content\">";
        echo "<div class=\"showcase-content-wrapper\">";        
        echo $slide;        
        echo "</div>";
       // echo "</div>";
        echo "</div>";
} 

?>
    </div>
        
<script>
    jQuery(window).load(function(){ 
        jQuery("#mainslider, #twitterbar").css({"position": "relative"}).animate({"opacity": 1}, 1000);        
    });
    jQuery(document).ready(function(){

        jQuery("#mainslider").data("nothovered", true);
        
        function mainsliderpreptimer(){
            return jQuery("#slider-timerbar").stop().width("100%");
        }

        function mainsliderhidetimer(){
            if(jQuery("#mainslider").data("nothovered")){
                mainsliderpreptimer().animate({width:1},6500);                
            }
        }
        
        mainsliderhidetimer();
        jQuery("#mainslider").awShowcase({
            content_width:            610,
            content_height:            294,
            fit_to_parent:            false,
            auto:                    true,
            interval:                6000,
            continuous:                true,
            loading:                true,
            //tooltip_width:            200,
            //tooltip_icon_width:        32,
            //tooltip_icon_height:    32,
            //tooltip_offsetx:        18,
            //tooltip_offsety:        0,
            arrows:                    true,
            buttons:                true,
            btn_numbers:            false,
            keybord_keys:            false,
            mousetrace:                false, /* Trace x and y coordinates for the mouse */
            pauseonover:            true,
            stoponclick:            false,
            transition:                'hslide', /* hslide/vslide/fade */
            transition_delay:        0,
            transition_speed:        1500,
            //show_caption:            'onload', /* onload/onhover/show */
            thumbnails:                false,
            //thumbnails_position:    'outside-last', /* outside-last/outside-first/inside-last/inside-first */
            //thumbnails_direction:    'vertical', /* vertical/horizontal */
            //thumbnails_slidex:        1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
            dynamic_height:            false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
            speed_change:            false, /* Set to true to prevent users from swithing more then one slide at once. */
            viewline:                false, /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
            //custom_function:        mainsliderhidetimer /* Define a custom function that runs on content change */
        });
        jQuery("#mainslider").hover(function(){
            jQuery(this).data("nothovered", false);
            jQuery("#mainslider > .showcase-arrow-next, #mainslider > .showcase-arrow-previous").show();
            //jQuery("#slider-timerbar").css("opacity",0);
            //mainsliderpreptimer();    
        }, function(){
            jQuery(this).data("nothovered", true);
            jQuery("#mainslider > .showcase-arrow-next, #mainslider > .showcase-arrow-previous").hide();
            //jQuery("#slider-timerbar").css("opacity",1);
            //mainsliderhidetimer();        
        });
                        
    });
</script>
<!--//*************************************************//
<!--//*********** END ** MAIN ** SLIDER ***************//
<!--//*************************************************//-->
<?
//echo "test5";
