<?php
/**
 * View for article objects
 *
 * @package Article
 */

$switch = (elgg_extract('full_view', $vars, FALSE) && !$switch) ? "full" : $switch;
$switch = (elgg_extract('medium_view', $vars, FALSE) && !$switch) ? "medium" : $switch;
$switch = (elgg_extract('module_view', $vars, FALSE) && !$switch) ? "module" : $switch;
//$switch = (elgg_extract('full_view', $vars, FALSE) && !$switch) ? "full" : $switch;
$switch = (!$switch) ? "brief" : $switch;

$article = elgg_extract('entity', $vars, FALSE);

if (!$article) {
	return TRUE;
}

$owner = $article->getOwnerEntity();
$container = $article->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $article->excerpt;

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => $owner->getURL(),
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));
$tags = elgg_view('output/tags', array('tags' => $article->tags));
$date = elgg_view_friendly_time($article->time_created);

// The "on" status changes for comments, so best to check for !Off
if ($article->comments_on != 'Off') {
	$comments_count = $article->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments:thismany", array((string)$comments_count));
		$comments_link = elgg_view('output/url', array(
			'href' => $article->getURL() . '#article-comments',
			'text' => $text,
		));
	} else {
        $text = elgg_echo("comments:bethefirstlink", $comments_count);
        $comments_link = elgg_view('output/url', array(
            'href' => $article->getURL() . '#article-comments',
            'text' => $text,
        ));
	}
} else {
	$comments_link = '';
}

$metadata = view_object_menu($vars);

$subtitle = "<p>$author_text<br />$date</p>";
//$subtitle = "<p>$author_text $date $comments_link</p>";
//$subtitle .= $categories;
//$subtitle .= $channels;

switch($switch){
    
    case "full":
    case "medium":

 	    $header = $switch == "full" ? 
            "<h2>" . elgg_view("output/url", array(
                'href' => $article->getURL(),
                'text' => $article->title . "<br />"
            )) . "</h2>"
            //elgg_view_title($article->title) . "<br />"
            : "<h3>" . elgg_view("output/url", array(
                'href' => $article->getURL(),
                'text' => $article->title . "<br />"
            )) . "</h3>"; 

	    $params = array(
		    'entity' => $article,
		    'title' => false,
    //		'metadata' => $metadata,
		    'subtitle' => $subtitle,
    //		'tags' => $tags,
	    );
	    $params = $params + $vars;
	    $list_body = elgg_view('object/elements/summary', $params);

        $tvar['class'] = 'title-image-block';
	    $article_info = elgg_view_image_block($owner_icon, $list_body, $tvar);
        $body = $metadata . $header . $article_info;
        $body .= elgg_view('output/longtext', array(
            'value' => $switch == "full"  
                ? str_replace("http:", "https:", $article->description)
                : str_replace("http:", "https:", elgg_get_excerpt($article->description, $CONFIG->excerptLength)),
            'class' => 'article-post',
        ));
        
        //check to see if comment are on
        if ($article->comments_on != 'Off') {
            $hotcomments = $vars['hot_comments'] ? elgg_view_comments($article, false, 
                array(
                    'rating_style'=> array("controversy"),
                    'pagination'=> FALSE,
                    'limit'=> 2,
                    'entity_guid' => $article->guid,
                    'minimum' => $CONFIG->minimumControversyScore,
                    'class' => 'cv-article-comments cv-article-hotcomments',
                )
            ) : "";
            $comments = $vars['normal_comments'] ? view_all_comments(array(
                    'guid' => $article->guid,
                    'show_add_form' => true,
                    'limit'=> 6,
                )
            ) : $comments_link;
        }
        
echo <<<HTML
    <div>
    $body
    </div>
    $hotcomments
    $comments

HTML;
    
    break;
    case "brief":
    case "module":
        // brief view

        $params = array(
            'entity' => $article,
            'metadata' => $metadata,
            'subtitle' => $subtitle,
            'tags' => $tags,
            'content' => $excerpt,
        );
        $params = $params + $vars;
        $list_body = elgg_view('object/elements/summary', $params);

        echo elgg_view_image_block($owner_icon, $list_body);
    break;
}
