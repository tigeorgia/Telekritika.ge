<?php
/**
 * View for segment objects
 *
 * @package Segment
 */

$switch = (elgg_extract('full_view', $vars, FALSE) && !$switch) ? "full" : $switch;
$switch = (elgg_extract('medium_view', $vars, FALSE) && !$switch) ? "medium" : $switch;
$switch = (elgg_extract('module_view', $vars, FALSE) && !$switch) ? "module" : $switch;
$switch = (!$switch) ? "brief" : $switch;

$segment = elgg_extract('entity', $vars, FALSE);
       
if (!$segment) {
	return TRUE;
}

$owner = $segment->getOwnerEntity();
//$container = $segment->getContainerEntity();
//$categories = elgg_view('output/categories', $vars);
//$channels = elgg_view('output/channels', $vars);
//$excerpt = $segment->excerpt;
$segdescription = $segment->description;
$segtitle = $segment->title;
if (empty($segtitle)) {
	$segdescriptiontmp = mb_substr($segdescription, 0,40);
    $segtitle = $segdescriptiontmp.="...";
}
if ($segtitle == "*") {
	$segdescriptiontmp = mb_substr($segdescription, 0,40);
    $segtitle = $segdescriptiontmp.="...";
}

//$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "segment/owner/$owner->guid",
	'text' => $owner->name,
));
//$author_text = elgg_echo('byline', array($owner_link));
//$tags = elgg_view('output/tags', array('tags' => $segment->tags));
//$events = elgg_view('output/events', array('events' => $segment->events));
$date = elgg_view_friendly_time($segment->time_created);

// The "on" status changes for comments, so best to check for !Off
if ($segment->comments_on != 'Off') {
	$comments_count = $segment->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $segment->getURL() . '#segment-comments',
			'text' => $text,
		));
	} else {
		$comments_link = '';
	}
    
    global $countcomments;
    if(is_numeric($countcomments)){
        $countcomments += $comments_count;
        global $countlikes;
        $countlikes += likes_count($segment);
        global $countdislikes;
        $countdislikes += dislikes_count($segment);
    }
    
} else {
	$comments_link = '';
}


  /*
$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'segment',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
    'data-sub' => 'likes.'.$segment->guid,
    'data-refreshmaster' => 'view_segment_menu',
));
*/
//smail($vars['entity']->getGUID(), "-1");
$metadata = view_object_menu($vars);

/*
    global $countcomments;
    if(is_numeric($countcomments)){
        $countcomments += $comments_count;
    }
*/

$subtitle = "<p>$author_text $date $comments_link</p>";
$subtitle .= $categories;
$subtitle .= $channels;

//if (empty($sequence{$segment->title}) {
    //$segment->title = $segment->description;
//}

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}
$html="";
switch($switch){
    case "medium":
    case "module":
        // brief view
/*        $params = array(
            'entity' => $segment,
            'metadata' => $metadata,
            'subtitle' => $subtitle,
            'tags' => $tags,
            'content' => $excerpt,
        );
        $params = $params + $vars;
        */
        $by = $vars['by'];
//        $js = prep_pipe_string("togglehoverpopup");
        $js = prep_pipe_string(array("togglehoverpopup"));
        $js2 = prep_pipe_string(array("togglejsppopup"));
        //$js3 = prep_pipe_string("togglejsppopup3");
        $random = rand();
        $dropdownid = $random."-dropdown-box";
        $dropdownselector = "#" . $dropdownid;
        $selectedsegment = ($vars['selectedsegment']->guid == $segment->guid) ? "selectedsegment" : "";
        $checked = "checked=\"checked\"";
        $sequence = $vars['date'] && !$vars['bare'] ? elgg_echo("sequence:{$segment->sequence}") . "" : "";
        //$videolink = ($link = $segment->videolink) ? "<a target=\"_blank\" class=\"cv_videolink\" href=\"$link\">".elgg_echo("watchthisnow")."</a>": "";
        $html.= "<a id=\"parent$random\" class=\"segment segment_$by $selectedsegment\" href=\"".$CONFIG->wwwroot."channels/".$segment->getGUID()."\" data-guid=\"{$segment->guid}\" data-dropdown=\"$dropdownselector\" >";

        $commentbubble = elgg_view('input/comments/comments-normal', array("class"=>"thumbs")) . $comments_count;
        
        $html.="<span data-onlyjs=\"|stickme|\" data-hoverjs=\"$js\" data-dropdown=\"$dropdownselector\" class=\"sliderthumbs commentbubble\">$commentbubble</span>";

        $html.=view_main_slide_meta(array("entity" => $segment));

        $html.="<input type=\"radio\" $checked/>";
        $html.="(".return_duration_in_time($segment->duration).")";
		$html.= "$sequence";
		$html.= "<span class=\"segtitle\">{$segtitle}</span>";
        $html.= "<span class=\"segdescription\" style=\"display:none;\">{$segdescription}</span>";
		$html.= "<span class=\"segtagspar\">";
        if(!empty($segment->events) || !empty($segment->tags) || !empty($segment->universal_categories)){
            $html .= "<span class=\"segtags\">";
            if(!empty($segment->events)){
                $segments = is_array($segment->events) ? $segment->events : array($segment->events);
                foreach($segments as $event){
                    $url = elgg_get_site_url() . 'search?q=' . urlencode($event) . "&search_type=events";
                    $events[]="<span href=\"$url\">$event</span>";
                }
                if(is_array($events)){
                    $html.= elgg_echo("events") . ": " . implode(", ", $events) . "<br>";
                }
            }            
            if(!empty($segment->tags)){
                $segments = is_array($segment->tags) ? $segment->tags : array($segment->tags);
                foreach($segments as $tag){
                    $url = elgg_get_site_url() . 'search?q=' . urlencode($tag) . "&search_type=tags";
                    $tags[]="<span href=\"$url\">$tag</span>";
                }
                if(is_array($tags)){
                    $html.= elgg_echo("tags") . ": " . implode(", ", $tags) . "<br>";
                }
            }
            if(!empty($segment->universal_categories)){
                $cats = is_array($segment->universal_categories) ? $segment->universal_categories : array($segment->universal_categories);
                foreach($cats as $category){
                    $url = elgg_get_site_url() . 'search?q=' . urlencode($category) . "&search_type=categories";
                    $categories[]="<span href=\"$url\">$category</span>";
                }
                if(is_array($categories)){
                    $html.= elgg_echo("categories") . ": " . implode(", ", $categories) . "<br>";
                }
            }
            $html .= "</span>";
        }
		$html .= "</span>";
        $html.="<span class=\"smallholder\">";
		$html.="<span class=\"selecttext\"><img class=\"selecttextb\" src=\"https://telekritika.ge/_graphics/comments/highlight.png\" title=\"ტექსტის მონიშნვა კოპირებისთვის\" \"/></span>";
        $linkimg = elgg_normalize_url("_graphics/link.png");
        $html.="<span class=\"tinylink\" href=\"".$CONFIG->wwwroot."channels/".$segment->getGUID()."\"><img src=\"$linkimg\" /></span>";
        if(!empty($segment->videolink)){
            $html.="<span class=\"tv\" href=\"{$segment->videolink}\">".elgg_view('input/comments/tv-normal', array("class"=>"thumbs"))."</span>";
        }            


        $html.="</span>";
        
        $html.="</a>";
        
        /*$hotcomments .= elgg_view_comments($segment, false, 
            array(
                'rating_style'=>array('controversy'),
                'limit'=>3,
                'entity_guid'=>$segment->guid,
                'minimum' => $CONFIG->minimumControversyScore,
                'class' => 'cv-segment-comments cv-segment-hotcomments'
            )
        );*/
        
        $comments .= view_cv_segment_comments(
        array(
            'entity_guid' => $segment->guid,
            )
        );
                
        $html.= "
<div id=\"$dropdownid\" data-parentid=\"parent$random\" data-hoverjs=\"$js\" data-dropdown=\"$dropdownselector\" class=\"hovermodule cv-hovermodule cv-hovermodule-segmentcomments\">
    <div data-hoverjs=\"$js2\" class=\"cv-hovermodule_commentswrapper\">
    $videolink 
    $hotcomments
    $comments
    </div>
</div>";
        echo $html;
    break;
    case "full":    
        $body = elgg_view('output/longtext', array(
            'value' => $segment->description,
            'class' => 'segment-post',
        ));

        $header = elgg_view_title($segment->title);

        $params = array(
            'entity' => $segment,
            'title' => false,
            'metadata' => $metadata,
            'subtitle' => $subtitle,
            'tags' => $tags,
            'events' => $events,
            'categories' => $categories,
        );
        $params = $params + $vars;
        $list_body = elgg_view('object/elements/cv_summary', $params);

        $segment_info = $list_body;
//        $segment_info = elgg_view_image_block($owner_icon, $list_body);

        echo <<<HTML
$header
$segment_info
$body
HTML;
    break;

    case "brief":
        // brief view
        echo "<hr />" . $metadata;        
        echo "<b>" . $owner_link . "</b><br>";        
        echo get_entity($segment->container_guid)->name . " - ";
        echo $segment->segment_date . " - ";
        echo $CONFIG->broadcast_types[(int)$segment->broadcast_type] . "<br />";
        echo $segment->segment_start_hour . ":" . $segment->segment_start_minute . ":" . $segment->segment_start_second . " - ";
        echo $segment->segment_end_hour . ":" . $segment->segment_end_minute . ":" . $segment->segment_end_second;
        echo " (" . return_duration_in_time((int)$segment->duration) . ") ";
        echo $segment->videolink ? "<a href=\"{$segment->videolink}\">videolink</a><br />" : "";
        echo "<br>" . $segment->description;
        if(!empty($segment->events) || !empty($segment->tags) || !empty($segment->universal_categories)){
            $html .= "<br><span style=\"cursor:pointer;\" class=\"segtags\">";
            if(!empty($segment->events)){
                $segments = is_array($segment->events) ? $segment->events : array($segment->events);
                foreach($segments as $event){
                    $url = elgg_get_site_url() . 'search?q=' . urlencode($event) . "&search_type=events";
                    $events[]="<span href=\"$url\">$event</span>";
                }
                if(is_array($events)){
                    $html.= elgg_echo("events") . ": " . implode(", ", $events) . "<br>";
                }
            }            
            if(!empty($segment->tags)){
                $segments = is_array($segment->tags) ? $segment->tags : array($segment->tags);
                foreach($segments as $tag){
                    $url = elgg_get_site_url() . 'search?q=' . urlencode($tag) . "&search_type=tags";
                    $tags[]="<span href=\"$url\">$tag</span>";
                }
                if(is_array($tags)){
                    $html.= elgg_echo("tags") . ": " . implode(", ", $tags) . "<br>";
                }
            }
            if(!empty($segment->universal_categories)){
                $cats = is_array($segment->universal_categories) ? $segment->universal_categories : array($segment->universal_categories);
                foreach($cats as $category){
                    $url = elgg_get_site_url() . 'search?q=' . urlencode($category) . "&search_type=categories";
                    $categories[]="<span href=\"$url\">$category</span>";
                }
                if(is_array($categories)){
                    $html.= elgg_echo("categories") . ": " . implode(", ", $categories) . "<br>";
                }
            }
            $html .= "</span>";
        }
        echo $html;        
        
        $option['admin_comment'] = true;
        $option['inline'] = true;
        echo elgg_view_comments($segment, true, $option);
                
        //echo elgg_view('object/elements/summary', $params);
        //$list_body = elgg_view('object/elements/summary', $params);

//        echo elgg_view_image_block($owner_icon, $list_body);
    break;
    case "full":    
        //echo "test";
    /*        $body = elgg_view('output/longtext', array(
            'value' => $segment->description,
            'class' => 'segment-post',
        ));

        $header = elgg_view_title($segment->title);
        $smallheader = "<h3>{$segment->title} - $author</h3>";

        $params = array(
            'entity' => $segment,
            'title' => false,
            'metadata' => $metadata,
            'subtitle' => $subtitle,
            'tags' => $tags,
            'events' => $events,
            'categories' => $categories,
        );
        $params = $params + $vars;
        $list_body = elgg_view('object/elements/summary', $params);

        $segment_info = $list_body;
        $segment_info = elgg_view_image_block($owner_icon, $list_body);

        echo <<<HTML
$smallheader
$segment_info
$body
HTML; */
    break;
}
