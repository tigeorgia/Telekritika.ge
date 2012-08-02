<!--//*************************************************//
<!--//******BEGIN TWITTER SMS ETC SLIDER***************//
<!--//*************************************************//-->

<style>
#twitterbar{
    color: #004d7a;
    background-color: #d2dcde;
    height: 70px;
    position:relative;
}

#twitterbar .showcase-load
{
    height: 70px; /* Same as showcase javascript option */
    overflow: hidden;
}

#twitterbar .tweetbox{
    position:absolute;
    top:10px;
    left:88px;
    width:80%;
*    height:70px;
}

#twitterbar .tweetbox a:hover{
    text-decoration: underline;   
}

#twitterbar .showcase-content-wrapper{
    height:70px;
    text-align: left;
}

#twitterbar .showcase-content-container > div.showcase-content{
    left:0px;
    background-color: transparent;
}

#twitterbar .showcase-content-container{
    background-color: transparent;
}

#twitterbar #timerbar{
    position:absolute;
    bottom:0;
    right:0;
    background-color: #999;
    height: 100%;
    width: 3px;
    opacity: .4;
    *height: 1px;
    *width:570px;
}

#twitterbar .tweetvalue{
    font-size:12px;
    text-shadow: 0px 0px 2px #FFF;
    font-size:16px;
}

#twitterbar .tweetauthor{
    position: absolute;    
    bottom:8px;
    right:40px;
    font-size:13px;
    *font-weight: bold;
}


#twitterbar > .showcase-arrow-next, #twitterbar > .showcase-arrow-previous{
    display:none;
}
/*
#twitterbar:hover > .showcase-arrow-next, #twitterbar:hover > .showcase-arrow-previous{
    display:initial;
}
*/

#twitterbar a, #twitterbar a:hover{
    border: 0;
    color: black;
}

#twitterbar .showcase-arrow-previous, #twitterbar .showcase-arrow-next{
    position: absolute;
    background: url('<?=elgg_normalize_url('_graphics/twitterbar/arrows-small.png')?>');
    width: 17px;
    height: 17px;
    left: auto;
    right: 0;
    cursor: pointer;
    z-index:999999;
    opacity: .2;
}

#twitterbar .showcase-arrow-previous{
    top: 0px;
    background-position: 0px -51px;
}

#twitterbar .showcase-arrow-previous:hover{
    background-position: 17px -51px;
    opacity: .4;
}

#twitterbar .showcase-arrow-next{
    top: 53px;
    background-position: 0 -34px;
}

#twitterbar .showcase-arrow-next:hover{
    background-position: 17px -34px;
    opacity: .4;
}

</style>

<?php
  
$options['entity'] = SMS_object();
$options['show_add_form'] = false;
$options['class'] = elgg_extract('class', $options, "sms-comments");
$options['limit'] = $CONFIG->maxtweetsmsonhomepage/2;
$options['order_by'] = 'n_table.id desc';
$options['annotation_name'] = 'SMS';

$rawsmses = elgg_get_annotations($options);
$smses = array();
foreach($rawsmses as $key => $smsobj){
    $smses[] = new stdClass();
    $smses[$key]->type = "sms";
    $smses[$key]->time_created = $smsobj->getTimeCreated();
        $comment_info = @json_decode($smsobj->value, true);    
        $thecomment = (is_array($comment_info))?$comment_info['originalvalue']:$smsobj->value;
    $smses[$key]->value = $thecomment;
    //author               
}

$tweets = get_tweets_to_annotations($CONFIG->TWITTERhashtags, $CONFIG->maxtweetsmsonhomepage/2);
//print_r($tweets);

$items = array_merge($smses, $tweets);

usort($items, "time_created_sorter");

$pTweet = new stdClass;
$pTweet->type = "tweet";
$pTweet->url = "https://twitter.com/#!/search/realtime/" . urlencode(implode("+OR+", $CONFIG->TWITTERhashtags));
$pTweet->value = elgg_echo("twitter:sendtothishash", array(implode(", ", $CONFIG->TWITTERhashtags)));

foreach($CONFIG->TWITTERhashtags as $hashtag){
    $tag = substr($hashtag, 1);
    $pTweet->value = str_ireplace($hashtag, "<a href=\"https://twitter.com/#!/search/realtime/%23$tag\" target=\"_blank\">$hashtag</a>", $pTweet->value);
}

$pSMS = new stdClass;
$pSMS->type = "sms";
$pSMS->value = elgg_echo("SMS:sendtothisnumber", array($CONFIG->SMSphonenumber));;

foreach($CONFIG->TWITTERhashtags as $hashtag){
    $tag = substr($hashtag, 1);
    $pSMS->value = str_ireplace($hashtag, "<a href=\"https://twitter.com/#!/search/realtime/%23$tag\" target=\"_blank\">$hashtag</a>", $pSMS->value);
}

$finalitems = array($pTweet, $pSMS);
$items = array_merge($finalitems, $items);

$tweeterurl = "_graphics/twitterbar/tweeter.jpg";
$tweeterurl = elgg_normalize_url($tweeterurl);

$SMSerurl = "_graphics/twitterbar/SMSer.jpg";
$SMSerurl = elgg_normalize_url($SMSerurl);

?>
        <div id="twitterbar">
<? 
foreach($items as $key => $item){
        $imgurl = ($item->type == "tweet") ? $tweeterurl : $SMSerurl;
        echo "<div class=\"showcase-slide\">";
       // echo "<div class=\"showcase-content\">";
        echo "<div class=\"showcase-content-wrapper\">";

        //echo $item->url ? "<a href='{$item->url}' target='_blank'>" : "<a href=\"#\">";
        echo "<img src=\"$imgurl\">";
        //echo "</a>";
        echo $item->url ? "<span class=\"tweetbox\" href='{$item->url}' target='_blank'>" : "<span class=\"tweetbox\" href=\"#\">";
        echo "<span class=\"tweetvalue\">{$item->value}</span>";
        echo "</span>";
        echo $item->author ? "<span class=\"tweetauthor\"><a href=\"https://twitter.com/#!/{$item->author}\" target=\"_blank\">{$item->author}</a></span>" : "<span class=\"tweetauthor\">&nbsp;</span>";            

        echo "</div>";
       // echo "</div>";
        echo "</div>";
} 
?>
        <div id="timerbar">&nbsp;</div>
        </div>
        
<script>
    jQuery(document).ready(function(){

    //    jQuery(window).load(function(){
            jQuery("#twitterbar").data("nothovered", true);
            
            function preptimer(){
                return jQuery("#timerbar").stop().height("100%");
            }

            function hidetimer(){
                if(jQuery("#twitterbar").data("nothovered")){
                    preptimer().animate({height:0},8500);                
                }
            }
            
            hidetimer();
            jQuery("#twitterbar").awShowcase({
                content_width:            "100%",
                content_height:            70,
                fit_to_parent:            false,
                auto:                    true,
                interval:                8000,
                continuous:                true,
                loading:                true,
                //tooltip_width:            200,
                //tooltip_icon_width:        32,
                //tooltip_icon_height:    32,
                //tooltip_offsetx:        18,
                //tooltip_offsety:        0,
                arrows:                    true,
                buttons:                false,
                btn_numbers:            false,
                keybord_keys:            false,
                mousetrace:                false, /* Trace x and y coordinates for the mouse */
                pauseonover:            true,
                stoponclick:            false,
                transition:                'vslide', /* hslide/vslide/fade */
                transition_delay:        0,
                transition_speed:        1000,
                //show_caption:            'onload', /* onload/onhover/show */
                thumbnails:                false,
                //thumbnails_position:    'outside-last', /* outside-last/outside-first/inside-last/inside-first */
                //thumbnails_direction:    'vertical', /* vertical/horizontal */
                //thumbnails_slidex:        1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
                dynamic_height:            false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
                speed_change:            false, /* Set to true to prevent users from swithing more then one slide at once. */
                viewline:                false, /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
                custom_function:        hidetimer /* Define a custom function that runs on content change */
            });
            jQuery("#twitterbar").hover(function(){
                jQuery(this).data("nothovered", false);
                jQuery("#twitterbar > .showcase-arrow-next, #twitterbar > .showcase-arrow-previous").show();
                jQuery("#timerbar").hide();
                preptimer();    
            }, function(){
                jQuery(this).data("nothovered", true);
                jQuery("#twitterbar > .showcase-arrow-next, #twitterbar > .showcase-arrow-previous").hide();
                jQuery("#timerbar").show();
                hidetimer();        
            });
                
            
  //      });
    });
</script>
<!--//*************************************************//
<!--//********END TWITTER SMS ETC SLIDER***************//
<!--//*************************************************//-->
<?
