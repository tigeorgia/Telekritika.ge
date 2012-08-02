<?php
/**
 * Article helper functions
 *
 * @package Article
 */


/**
 * Get page components to view a article post.
 *
 * @param int $guid GUID of a article entity.
 * @return array
 */
function article_get_page_content_read($guid = NULL) {

	$return = array();

	$article = get_entity($guid);

	// no header or tabs for viewing an individual article
	$return['filter'] = '';
	$return['header'] = '';

	if (!elgg_instanceof($article, 'object', 'article')) {
		$return['content'] = elgg_echo('article:error:post_not_found');
		return $return;
	}

    //get latest article, full view
    $options = array(
        'type' => 'object',
        'subtype' => 'article',
        'paginate' => FALSE,
        'full_view' => TRUE,
        'hot_comments' => TRUE,
        'normal_comments' => TRUE,
        'limit' => 1,
        'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'published')
    );

    $articles = elgg_get_entities_from_metadata($options);
    $latestarticle = $articles[0];
    
    if($latestarticle->guid == $article->guid)$moduletitle = elgg_echo("article:latestarticle");
    
	$return['title'] = htmlspecialchars($article->title);
    $body = elgg_view_entity($article, $options);
    $modulecontent = elgg_view_module('article', $moduletitle, $body, array('class' => 'tk-main-module'));
    $module = array('body' => $modulecontent,
                    'class' => 'toppest'            
                    );
    $return['content']['main'][] = $module;     
    
    $return['FBmeta'] = generic_FBobjectify($article);
                
	return $return;
}

/**
 * Get page components to list a user's or all articles.
 *
 * @param int $owner_guid The GUID of the page owner or NULL for all articles
 * @return array
 */
function article_get_page_content_list($container_guid = NULL) {

    $return = array();

    $return['filter_context'] = $container_guid ? 'mine' : 'all';

    $options = array(
        'type' => 'object',
        'subtype' => 'article',
        'full_view' => FALSE,
    );

    $loggedin_userid = elgg_get_logged_in_user_guid();
    if ($container_guid) {
        $options['container_guid'] = $container_guid;
        $container = get_entity($container_guid);
        if (!$container) {

        }
        $return['title'] = elgg_echo('article:title:user_articles', array($container->name));

        $crumbs_title = $container->name;
        elgg_push_breadcrumb($crumbs_title);

        if ($container_guid == $loggedin_userid) {
            $return['filter_context'] = 'mine';
        } else if (elgg_instanceof($container, 'group')) {
            $return['filter'] = false;
        } else {
            // do not show button or select a tab when viewing someone else's posts
            $return['filter_context'] = 'none';
        }
    } else {
        $return['filter_context'] = 'all';
        $return['title'] = elgg_echo('article:title:all_articles');
        elgg_pop_breadcrumb();
        elgg_push_breadcrumb(elgg_echo('article:articles'));
    }

    if(elgg_is_admin_logged_in()){
        elgg_register_title_button();        
    }

    $list = elgg_list_entities_from_metadata($options);
    if (!$list) {
        $return['content'] = elgg_echo('article:none');
    } else {
        $return['content'] = $list;
    }

    $return['filter'] = false;        

    return $return;
}
                               
/**
 * Get page components to list a user's or all articles.
 *
 * @param int $owner_guid The GUID of the page owner or NULL for all articles
 * @return array
 */
function article_get_page_content_all($container_guid = NULL, $single = false) {

	$return = array();
    $return['title'] = elgg_echo('article:title:all_articles');
    elgg_pop_breadcrumb();
    elgg_push_breadcrumb(elgg_echo('article:articles'));

    //get latest article, full view
	$options = array(
		'type' => 'object',
		'subtype' => 'article',
        //'pagination' => FALSE,
        'full_view' => TRUE,
        'hot_comments' => TRUE,
		'normal_comments' => TRUE,
        'limit' => 1,
        'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'published')
	);

	$articles = elgg_get_entities_from_metadata($options);
    $article = $articles[0];
    $body = elgg_view_entity($article, $options);
    $moduletitle = elgg_echo("article:latestarticle");
    $modulecontent = elgg_view_module('article', $moduletitle, $body, array('class' => !$single ? 'tk-main-module' : 'tk-secondary-module'));
    if($single)return $modulecontent;
    $module = array('body' => $modulecontent,
                    'class' => 'toppest'            
                    );
    $return['content']['main'][] = $module;     
    
    //get more articles, but just summary views
    $options = array(
        'type' => 'object',
        'subtype' => 'article',
        'paginate' => FALSE,
        'medium_view' => TRUE,
        'hot_comments' => TRUE,
        'normal_comments' => FALSE,
        'limit' => 3,
        'offset' => 1,
        'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'published')
    );

    $articles = elgg_get_entities_from_metadata($options);
    foreach($articles as $article){
        $body = elgg_view_entity($article, $options);
        $return['content']['main'][] = elgg_view_module('article', null, $body
                ,array('class' => 'tk-secondary-module')
            );    
    }
        
	return $return;
}

                               
/**
 * Get page components to edit/create a article post.
 *
 * @param string  $page     'edit' or 'new'
 * @param int     $guid     GUID of article post or container
 * @param int     $revision Annotation id for revision to edit (optional)
 * @return array
 */
function article_get_page_content_edit($page, $guid = 0, $revision = NULL) {
            global $actionbuttons;

	elgg_load_js('elgg.article');

	$return = array(
		'filter' => '',
	);

	$vars = array();
	$vars['id'] = 'article-post-edit';
	$vars['name'] = 'article_post';
	$vars['class'] = 'elgg-form-alt';

	if ($page == 'edit') {
		$article = get_entity((int)$guid);

		$title = elgg_echo('article:edit');

		if (elgg_instanceof($article, 'object', 'article') && $article->canEdit()) {
			$vars['entity'] = $article;

			$title .= ": \"$article->title\"";

			if ($revision) {
				$revision = elgg_get_annotation_from_id((int)$revision);
				$vars['revision'] = $revision;
				$title .= ' ' . elgg_echo('article:edit_revision_notice');

				if (!$revision || !($revision->entity_guid == $guid)) {
					$content = elgg_echo('article:error:revision_not_found');
					$return['content'] = $content;
					$return['title'] = $title;
					return $return;
				}
			}

			$body_vars = article_prepare_form_vars($article, $revision);

			elgg_push_breadcrumb($article->title, $article->getURL());
			elgg_push_breadcrumb(elgg_echo('edit'));
			
			elgg_load_js('elgg.article');

			$content = elgg_view_form('article/save', $vars, $body_vars);
            $sidebar = $actionbuttons;
        //    jQuery("input[name=save]").click(function(e){jQuery("form[name=segment_post]").submit();});
            $sidebar.='<script>jQuery(document).ready(function(){
                jQuery("input[name=save],button[name=save]").click(function(e){e.preventDefault();jQuery("form.elgg-form").submit();}); 
                    jQuery("body").bind("keypress", function(e){
                    var datarg = jQuery(e.target);
                    if(!datarg.is("textarea") && !datarg.is("select") && !datarg.is("input[name=q]")){
                    var code = (e.keyCode ? e.keyCode : e.which);
                     if(code == 13) { //Enter keycode
                        var conf = confirm("'.elgg_echo('js:ready_to_save').'");
                       if(conf)jQuery("form.elgg-form").submit();
                     }
                    }         
                });           
            });
            </script>';
			$sidebar .= elgg_view('article/sidebar/revisions', $vars);
		} else {
			$content = elgg_echo('article:error:cannot_edit_post');
		}
	} else {
		if (!$guid) {
			$container = elgg_get_logged_in_user_entity();
		} else {
			$container = get_entity($guid);
		}

		elgg_push_breadcrumb(elgg_echo('article:add'));
		$body_vars = article_prepare_form_vars($article);

		$title = elgg_echo('article:add');
		$content = elgg_view_form('article/save', $vars, $body_vars);
		
		$article_js = elgg_get_simplecache_url('js', 'article/save_draft');
		elgg_register_js('elgg.article', $article_js);

            $sidebar = $actionbuttons;
        //    jQuery("input[name=save]").click(function(e){jQuery("form[name=segment_post]").submit();});
            $sidebar.='<script>jQuery(document).ready(function(){
                jQuery("input[name=save],button[name=save]").click(function(e){e.preventDefault();jQuery("form.elgg-form").submit();}); 
                    jQuery("body").bind("keypress", function(e){
                    var datarg = jQuery(e.target);
                    if(!datarg.is("textarea") && !datarg.is("select") && !datarg.is("input[name=q]")){
                    var code = (e.keyCode ? e.keyCode : e.which);
                     if(code == 13) { //Enter keycode
                        var conf = confirm("'.elgg_echo('js:ready_to_save').'");
                       if(conf)jQuery("form.elgg-form").submit();
                     }
                    }         
                });
           
            });
            </script>';
	}

	$return['title'] = $title;
	$return['content'] = $content;
	$return['sidebar'] = $sidebar;
	return $return;	
}

/**
 * Pull together article variables for the save form
 *
 * @param ElggArticle       $post
 * @param ElggAnnotation $revision
 * @return array
 */
function article_prepare_form_vars($post = NULL, $revision = NULL) {

	// input names => defaults
	$values = array(
		'title' => NULL,
		'description' => NULL,
		'status' => 'published',
		'access_id' => ACCESS_DEFAULT,
		'comments_on' => 'On',
		'excerpt' => NULL,
		'tags' => NULL,
		'container_guid' => NULL,
		'guid' => NULL,
		'draft_warning' => '',
	);

	if ($post) {
		foreach (array_keys($values) as $field) {
			if (isset($post->$field)) {
				$values[$field] = $post->$field;
			}
		}
	}

	if (elgg_is_sticky_form('article')) {
		$sticky_values = elgg_get_sticky_values('article');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}
	
	elgg_clear_sticky_form('article');

	if (!$post) {
		return $values;
	}

	// load the revision annotation if requested
	if ($revision instanceof ElggAnnotation && $revision->entity_guid == $post->getGUID()) {
		$values['revision'] = $revision;
		$values['description'] = $revision->value;
	}

	// display a notice if there's an autosaved annotation
	// and we're not editing it.
	if ($auto_save_annotations = $post->getAnnotations('article_auto_save', 1)) {
		$auto_save = $auto_save_annotations[0];
	} else {
		$auto_save == FALSE;
	}

	if ($auto_save && $auto_save->id != $revision->id) {
		$values['draft_warning'] = elgg_echo('article:messages:warning:draft');
	}

	return $values;
}
