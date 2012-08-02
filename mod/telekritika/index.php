<?php
/**
 * Elgg custom index page
 * 
 */
 
//elgg_push_context('front');

$params['content']['top'] = 
    elgg_view_module("channelbar", 
        null, 
        get_channelbar(true), 
        array("class" => "tk-top-module")
    );    

 
$params['content']['main'][] = 
    elgg_view_module("mainslider", 
        null, 
        elgg_view('page/components/mainslider'), 
        array("class" => "tk-main-slider")
    );    

$params['content']['main'][] = 
    elgg_view('page/components/twitterbar');
                               
if(elgg_is_logged_in() ){
    $params['content']['main'][] = 
        elgg_view_module("river", 
            null, 
            view_river(array("limit" => 10)), 
            array("class" => "tk-river-module")
        );    
}else{
    elgg_load_library('elgg:article');
    $params['content']['main'][] = 
        article_get_page_content_all(null,true);
}                               

add_template_modules(&$params, "front");
                               
$body = elgg_view_layout('custom_index', $params);

// no RSS feed with a "widget" front page
global $autofeed;
$autofeed = FALSE;
echo elgg_view_page('', $body);

?>