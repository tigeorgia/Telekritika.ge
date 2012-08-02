<?php
/**
 * View for commentary objects
 *
 * @package Commentary
 */

$switch = (!$switch && elgg_extract('full_view', $vars, FALSE)) ? "full" : $switch;
$switch = (!$switch && elgg_extract('full_story_view', $vars, FALSE)) ? "fullstory" : $switch;
$switch = (!$switch && elgg_extract('story_view', $vars, FALSE)) ? "story" : $switch;
$switch = (!$switch && elgg_extract('slide_view', $vars, FALSE)) ? "slide" : $switch;
$switch = (!$switch && elgg_extract('medium_view', $vars, FALSE)) ? "medium" : $switch;
$switch = (!$switch && elgg_extract('module_view', $vars, FALSE)) ? "module" : $switch;
$switch = (!$switch) ? "brief" : $switch;

$commentary = elgg_extract('entity', $vars, FALSE);

if (!$commentary) {
	return TRUE;
}

$owner = $commentary->getOwnerEntity();
$container = $commentary->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$channels = elgg_view('output/channels', $vars);
$excerpt = $commentary->excerpt;

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => $owner->getURL(),
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));
$tags = elgg_view('output/tags', array('tags' => $commentary->tags));
$date = elgg_view_friendly_time($commentary->time_created);

// The "on" status changes for comments, so best to check for !Off
if ($commentary->comments_on != 'Off') {
    $comments_count = $commentary->countComments();
    //only display if there are commments
    if ($comments_count != 0) {
        $commenttext = $switch != "module" ? elgg_echo("comments:thismany", array((string)$comments_count))
                                    : elgg_echo("comments:thismanybrief", array((string)$comments_count));
        $comments_link = elgg_view('output/url', array(
            'href' => $commentary->getURL() . '#commentary-comments',
            'text' => $commenttext,
        ));
    } else {
        $commenttext = $switch != "module" ? elgg_echo("comments:bethefirstlink", $comments_count)
                                    : elgg_echo("comments:thismanybrief", array((string)$comments_count));
        $comments_link = elgg_view('output/url', array(
            'href' => $commentary->getURL() . '#commentary-comments',
            'text' => $commenttext,
        ));
    }
} else {
    $comments_link = '';
}

$vars['handler'] = 'channels';
$metadata = view_object_menu($vars);


$subtitle = "<p>$author_text<br />$date</p>";
//$subtitle = "<p>$author_text $date $comments_link</p>";
//$subtitle .= $categories;
//$subtitle .= $channels;

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

switch($switch){
    case "full":
    case "medium":

    $header = $switch == "full" ? elgg_view_title($commentary->title)
        : "<h3>" . elgg_view("output/url", array(
            'href' => $commentary->getURL(),
            'text' => $commentary->title . "<br />"
        )) . "</h3>"; 

    $params = array(
        'entity' => $commentary,
        'title' => false,
//        'metadata' => $metadata,
        'subtitle' => $subtitle,
//        'tags' => $tags,
    );
    $params = $params + $vars;
    $list_body = elgg_view('object/elements/summary', $params);

    $tvar['class'] = 'title-image-block';
    $commentary_info = elgg_view_image_block($owner_icon, $list_body, $tvar);
    $body = $metadata . $header . $commentary_info;
    $body .= elgg_view('output/longtext', array(
        'value' => $switch == "full" ? $commentary->description : elgg_get_excerpt($commentary->description, $CONFIG->excerptLength),
        'class' => 'commentary-post',
    ));
        
    $tags = "<p>tags: ".implode(", ", $commentary->getTags(array("tags")));
    $events = "<p>evs: ".implode(", ", $commentary->getTags(array("events")));
    $categories = "<p>cats: ".$commentary->universal_categories;

    //check to see if comment are on
    if ($commentary->comments_on != 'Off') {
        $hotcomments = $vars['hot_comments'] ? elgg_view_comments($commentary, false, 
            array(
                'rating_style'=> array('controversy'),
                'limit' => 2,
                'entity_guid' => $commentary->guid,
                'minimum' => $CONFIG->minimumControversyScore,
                'class' => 'cv-commentary-comments cv-commentary-hotcomments',
                'title' => ""
            )
        ) : "";
        $comments = $vars['normal_comments'] ? view_all_comments(array(
            'guid' => $commentary->guid,
            'show_add_form' => true,
            'limit'=> 6,
        )) : $comments_link;
    }

echo <<<HTML

    <div>
    $body
    </div>
    $hotcomments
    $comments

HTML;
    break;
    case "fullstory":
    $header = elgg_view_title(elgg_view("output/url", array(
            'href' => $commentary->getURL(),
            'text' => $commentary->title . "<br />"
        ))); 

    $params = array(
        'entity' => $commentary,
        'title' => false,
//        'metadata' => $metadata,
        'subtitle' => $subtitle,
//        'tags' => $tags,
    );
    $params = $params + $vars;
    $list_body = elgg_view('object/elements/summary', $params);

    $tvar['class'] = 'title-image-block';
//    $commentary_info = elgg_view_image_block($owner_icon, $list_body, $tvar);
    $segs = $commentary->getEntitiesFromRelationship("linked_segment");
    $date = elgg_view_friendly_time(strtotime($segs[0]->segment_date));
    $body = $metadata . $header . $commentary_info;
    foreach($segs as $segment){
        $icons .= elgg_view_entity_icon(get_entity($segment->container_guid), "tiny", array("nourl" => true));
    }    
    $body .= $date . " - " . $icons;
    $body .= elgg_view('output/longtext', array(
        'value' => $switch == "full" ? $commentary->description : elgg_get_excerpt($commentary->description, $CONFIG->excerptLength),
        'class' => 'commentary-post',
    ));
        
    $tags = "<p>tags: ".implode(", ", $commentary->getTags(array("tags")));
    $events = "<p>evs: ".implode(", ", $commentary->getTags(array("events")));
    $categories = "<p>cats: ".$commentary->universal_categories;

    //check to see if comment are on
    if ($commentary->comments_on != 'Off') {
        $hotcomments = $vars['hot_comments'] ? elgg_view_comments($commentary, false, 
            array(
                'rating_style'=> array('controversy'),
                'limit' => 2,
                'entity_guid' => $commentary->guid,
                'minimum' => $CONFIG->minimumControversyScore,
                'class' => 'cv-commentary-comments cv-commentary-hotcomments',
                'title' => ""
            )
        ) : "";
        $comments = $vars['normal_comments'] ? view_all_comments(array(
            'guid' => $commentary->guid,
            'show_add_form' => true,
            'limit'=> 6,
        )) : $comments_link;
    }

    
echo <<<HTML

    <div>
    $body
    </div>
    $hotcomments
    $comments

HTML;
    break;
    case "slide":
        $header = elgg_view_title($commentary->title);
        $url = $commentary->getURL();
        if($vars['badge']){
            $ia = elgg_get_ignore_access();
            elgg_set_ignore_access(true);
            $badgeurl = get_badge_img( $vars['badge'] );
            elgg_set_ignore_access($ia);
        }else{
            $badgeurl = elgg_normalize_url("_graphics/single.png");        
        }
/*        $badge = "<img class=\"badge\" src=\"$badgeurl\" />";
        $shadow = "<img class=\"icondrop\" src=\"" . elgg_normalize_url("_graphics/icondrop.png") . "\" />";
        $badgeholder = "<span class=\"badgeholder addshadow\">$badge$shadow</span>";        
*/
        $badgespacer = "<span class=\"badgespacer\">&nbsp;</span>";        
        $badgeholder = add_dropshadow($badgeurl, "badge");
        
	    $params = array(
		    'entity' => $commentary,
		    'title' => false,
    //		'metadata' => $metadata,
		    'subtitle' => $subtitle,
    //		'tags' => $tags,
	    );
	    $params = $params + $vars;
	    $list_body = elgg_view('object/elements/summary', $params);

        $tvar['class'] = 'title-image-block';
        $commentary_info = elgg_view_image_block($owner_icon, $list_body, $tvar);
        $commentary_info = str_replace("<a", "<span", $commentary_info);
        $commentary_info = str_replace("</a", "</span", $commentary_info);
        
        $body = $badgespacer;        
        $body .= elgg_view('output/longtext', array(
            'value' =>  elgg_get_excerpt($commentary->description, $CONFIG->slideExcerptLength),
            'class' => 'slide-commentary-post',
        ));

        $doyoulike = "<h3 class=\"doyoulike\">" . elgg_echo("likes:doyoulike") . "</h3>";
        $metadata = view_main_slide_meta($vars);
            
echo <<<HTML
    $header
    $commentary_info    
    $body
    <div class="foot">            
        $doyoulike $metadata
    </div>
    $badgeholder
HTML;
    break;
    case "module":
        // module view

    $title = $commentary->title;
    $link = $commentary->getURL();
    $author = $owner->name;
    $excerpt = elgg_get_excerpt($commentary->description, 35);
    $dislikes = elgg_view('input/thumbs/down-right-normal', array("class"=>"tinythumb nohl")) . dislikes_count($commentary);
    $likes = elgg_view('input/thumbs/up-right-normal', array("class"=>"tinythumb nohl")) . likes_count($commentary);
    $comments = elgg_view('input/comments/comments-normal', array("class"=>"tinycomment")) . $comments_count;
        
echo <<< HTML
<a class="moduleitemlink" href="$link">
    <!--<span class="tabitemtitle">$title</span><br />-->
    <span class="excerpt">$excerpt</span>
    <span class="tabdate">$author - $date</span><span class="tabmeta">$comments $dislikes $likes</span>
</a>
HTML;
        
        //echo elgg_view_image_block($owner_icon, $list_body);
    break;
    case "story":
        // story view

    $title = $commentary->title;
    $link = $commentary->getURL();
    $segs = $commentary->getEntitiesFromRelationship("linked_segment");
    $date = elgg_view_friendly_time(strtotime($segs[0]->segment_date));
    foreach($segs as $segment){
        $icons .= elgg_view_entity_icon(get_entity($segment->container_guid), "tiny", array("nourl" => true));
    }
    $dislikes = elgg_view('input/thumbs/down-right-normal', array("class"=>"tinythumb nohl")) . dislikes_count($commentary);
    $likes = elgg_view('input/thumbs/up-right-normal', array("class"=>"tinythumb nohl")) . likes_count($commentary);
    $comments = elgg_view('input/comments/comments-normal', array("class"=>"tinycomment")) . $comments_count;
        
echo <<< HTML
<a class="moduleitemlink" href="$link">
    <span class="friendlydate">$date</span> - <span>$title</span><span class="tabmeta">$comments $dislikes $likes</span><span class="tinychans">$icons</span>
</a>
HTML;
        
        //echo elgg_view_image_block($owner_icon, $list_body);
    break;
    case "brief":

    $tags = "<p>tags: ".implode(", ", $commentary->getTags(array("tags")));
    $events = "<br />evs: ".implode(", ", $commentary->getTags(array("events")));
    $categories = "<br />cats: ".implode(", ", $commentary->universal_categories)."</p>";

	    // brief view

	    $params = array(
		    'entity' => $commentary,
		    'metadata' => $metadata,
		    'subtitle' => $subtitle,
//		    'tags' => $tags,
		    'content' => $excerpt,
	    );
	    $params = $params + $vars;
	    $list_body = elgg_view('object/elements/summary', $params);

	    echo elgg_view_image_block($owner_icon, $list_body);
        echo $tags;
        echo $events;
        echo $categories;
        
    break;
}