<?php
/**
 * Commentary helper functions
 *
 * @package Commentary
 */


/**
 * Get page components to view a commentary post.
 *
 * @param int $guid GUID of a commentary entity.
 * @return array
 */
function commentary_get_page_content_read($guid = NULL) {

//    system_message("!");
//    elgg_extend_view('js/elgg', 'js/commentary_js');    
    elgg_load_js('elgg.commentary');
	$return = array();
	$entity = get_entity($guid);

	if (elgg_instanceof($entity, 'object', 'commentary')) {
        $commentary = $entity;    
    }elseif(elgg_instanceof($entity, 'object', 'segment')){        
        return commentary_get_channel_content_add(array($guid));
    }else{
        $return['content'] = elgg_echo('commentary:error:post_not_found');
        return $return;        
    }

    //MAIN MODULE//
        //get commentary, full view
        $options = array(
            'full_view' => TRUE,
            'hot_comments' => TRUE,
            'normal_comments' => TRUE,
        );
        
        $return['title'] = htmlspecialchars($commentary->title);
        $body = elgg_view_entity($commentary, $options);
        $moduletitle = elgg_is_admin_user($commentary->owner_guid) ? elgg_echo("commentary:editor_created") : "";
        $modulecontent = elgg_view_module('commentary', $moduletitle, $body, array('class' => 'tk-main-module nopvm'));
        $module = array('body' => $modulecontent, 'class' => 'toppest nopvm toppest' );
        $return['content']['main'][] = $module;     
    //MAIN MODULE//

    //SIDE MODULE//
        $addyourown = elgg_view("page/components/becomeacritic_2", 
            array("message" => elgg_echo("becomeacritic:makeyourown"), 
                "url" => "{$CONFIG->wwwroot}channels/{$guid}"
            ));    
        $return['content']['side'][] = $addyourown;     
    //SIDE MODULE//
        
    //SIDE MODULE//
        $linked_segments = $commentary->getEntitiesFromRelationship("linked_segment");
        foreach($linked_segments as $key => $segment){
            $options['selectedsegment'] = $segment;    
            $options['bare'] = true;    
            $options['full_view'] = false;    
            $options['medium_view'] = true;    
            $collected .= view_segmentselect_module($options);    
        }
        $module['body'] = $collected;
        $module['class'] = "cv_read_module";
        $return['content']['side'][] = $module;
    //SIDE MODULE//
            
    //FB OBJECTIFY
        $return['FBmeta'] = generic_FBobjectify($commentary);
    //FB OBJECTIFY
    
	return $return;
}

/**
 * Get page components to list a user's or all commentaries.
 *
 * @param int $owner_guid The GUID of the page owner or NULL for all commentaries
 * @return array
 */
function commentary_get_page_content_list($container_guid = NULL) {

	$return = array();

	$return['filter_context'] = $container_guid ? 'mine' : 'all';

	$options = array(
		'type' => 'object',
        'subtype' => 'commentary',
	);
    $options['metadata_name_value_pairs'][] = array('name' => 'status', 'value' => array('dailystory', 'featured', 'draft'));

    if(elgg_is_admin_logged_in()){
//        elgg_register_title_button();        
    }

    
	$loggedin_userid = elgg_get_logged_in_user_guid();
	if ($container_guid) {
		$options['container_guid'] = $container_guid;
		$container = get_entity($container_guid);
		if (!$container) {

		}
		$return['title'] = elgg_echo('commentary:title:user_commentaries', array($container->name));

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
		$return['title'] = elgg_echo('commentary:title:all_commentaries');
		elgg_pop_breadcrumb();
		elgg_push_breadcrumb(elgg_echo('commentary:commentaries'));
	}
        
               
	$return['content'] = view_all_commentaries($options);
    $return['filter'] = false;        

	return $return;
}

/**
 * Get page components to list of the user's friends' posts.
 *
 * @param int $user_guid
 * @return array
 */
function commentary_get_page_content_friends($user_guid) {

	$user = get_user($user_guid);

	$return = array();

	$return['filter_context'] = 'friends';
	$return['title'] = elgg_echo('commentary:title:friends');

	$crumbs_title = $user->name;
	elgg_push_breadcrumb($crumbs_title, "commentary/owner/{$user->username}");
	elgg_push_breadcrumb(elgg_echo('friends'));

	elgg_register_title_button();

	if (!$friends = get_user_friends($user_guid, ELGG_ENTITIES_ANY_VALUE, 0)) {
		$return['content'] .= elgg_echo('friends:none:you');
		return $return;
	} else {
		$options = array(
			'type' => 'object',
			'subtype' => 'commentary',
			'full_view' => FALSE,
		);

		foreach ($friends as $friend) {
			$options['container_guids'][] = $friend->getGUID();
		}

		// admin / owners can see any posts
		// everyone else can only see published posts
		if (!(elgg_is_admin_logged_in() || (elgg_is_logged_in() && $owner_guid == elgg_get_logged_in_user_guid()))) {
			if ($upper > $now) {
				$upper = $now;
			}

			$options['metadata_name_value_pairs'][] = array(
                array('name' => 'status', 'value' => array('published', 'featured')),
//				array('name' => 'status', 'value' => 'featured'),
			);
//            $options['metadata_name_value_pairs_operator'] = "OR";
		}

		$list = elgg_list_entities_from_metadata($options);
		if (!$list) {
			$return['content'] = elgg_echo('commentary:none');
		} else {
			$return['content'] = $list;
		}
	}

	return $return;
}

/**
 * Get page components to show commentaries with publish dates between $lower and $upper
 *
 * @param int $owner_guid The GUID of the owner of this page
 * @param int $lower      Unix timestamp
 * @param int $upper      Unix timestamp
 * @return array
 */
function commentary_get_page_content_archive($owner_guid, $lower = 0, $upper = 0) {

	$now = time();

	$user = get_user($owner_guid);
	elgg_set_page_owner_guid($owner_guid);

	$crumbs_title = $user->name;
	elgg_push_breadcrumb($crumbs_title, "commentary/owner/{$user->username}");
	elgg_push_breadcrumb(elgg_echo('commentary:archives'));

	if ($lower) {
		$lower = (int)$lower;
	}

	if ($upper) {
		$upper = (int)$upper;
	}

	$options = array(
		'type' => 'object',
		'subtype' => 'commentary',
		'full_view' => FALSE,
	);

	if ($owner_guid) {
		$options['owner_guid'] = $owner_guid;
	}

	// admin / owners can see any posts
	// everyone else can only see published posts
	if (!(elgg_is_admin_logged_in() || (elgg_is_logged_in() && $owner_guid == elgg_get_logged_in_user_guid()))) {
		if ($upper > $now) {
			$upper = $now;
		}

		$options['metadata_name_value_pairs'] = array(
			array('name' => 'status', 'value' => array('published', 'featured'))
		);
	}

	if ($lower) {
		$options['created_time_lower'] = $lower;
	}

	if ($upper) {
		$options['created_time_upper'] = $upper;
	}

	$list = elgg_list_entities_from_metadata($options);
	if (!$list) {
		$content .= elgg_echo('commentary:none');
	} else {
		$content .= $list;
	}

	$title = elgg_echo('date:month:' . date('m', $lower), array(date('Y', $lower)));

	return array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
}

/**
 * Get page components to edit/create a commentary post.
 *
 * @param string  $page     'edit' or 'new'
 * @param int     $guid     GUID of commentary post or container
 * @param int     $revision Annotation id for revision to edit (optional)
 * @return array
 */
function commentary_get_page_content_edit($guid = 0, $revision = NULL) {
    
    $return = array(
        'filter' => '',
    );

    $vars = array();
    $vars['id'] = 'commentary-post-edit';
    $vars['name'] = 'commentary_post';
    $vars['class'] = 'elgg-form-alt';
    $vars['guid'] = $guid;

    $commentary = get_entity($guid);
    $vars['entity'] = $commentary;

    $title = elgg_echo('commentary:edit');

    if (elgg_instanceof($commentary, 'object', 'commentary') && $commentary->canEdit()) {

        $title .= ": \"$commentary->title\"";

        if ($revision) {
            $revision = elgg_get_annotation_from_id((int)$revision);
            $vars['revision'] = $revision;
            $title .= ' ' . elgg_echo('commentary:edit_revision_notice');

            if (!$revision || !($revision->entity_guid == $guid)) {
                $content = elgg_echo('commentary:error:revision_not_found');
                $return['content'] = $content;
                $return['title'] = $title;
                return $return;
            }
        }

        $body_vars = commentary_prepare_form_vars($commentary, $revision);

        elgg_push_breadcrumb($commentary->title, $commentary->getURL());
        elgg_push_breadcrumb(elgg_echo('edit'));
        
        elgg_load_js('elgg.commentary');

        $content = "";
        //$content = get_channelbar();
        $content .= elgg_view_form('commentary/save', $vars, $body_vars);
                
    } else {
        $content = elgg_echo('commentary:error:cannot_edit_post');
    } 

    $return['content'] = $content;
    $return['title'] = $title;
    $return['sidebar'] = $sidebar;
    return $return;    
}


/**
 * Get page components to edit/create a commentary post.
 *
 * @param string  $page     'edit' or 'new'
 * @param int     $guid     GUID of commentary post or container
 * @param int     $revision Annotation id for revision to edit (optional)
 * @return array
 */
function commentary_get_channel_content_add($page) {
       
       $vars['page'] = $page;

    //elgg_extend_view('js/elgg', 'js/commentary_js');    
    elgg_load_js('scroll');
    elgg_load_js('elgg.commentary');
	elgg_push_breadcrumb(elgg_echo('commentary:add'));

	$title = elgg_echo('commentary:add');

    $body_vars = commentary_prepare_form_vars();        

    //MAIN MODULE//
        $body = elgg_view_form((count($page) == 1 && $page[0] == "add") ? 'commentary/cvsave' : 'commentary/savefromtemplate', $vars, $body_vars);
        $modulecontent = elgg_view_module('cv_save', $moduletitle, $body, array('class' => 'tk-main-module nopvm'));
        $module = array('body' => $modulecontent,
                        'class' => 'toppest nopvm toppestCV'            
                        );
        $return['content']['main'][] = $module;     
    //MAIN MODULE//
    
    //SELECTCHANS MODULE//
        $body = elgg_view('commentary/cv_segment_modules', $vars);        
        $modulecontent = elgg_view_module('cv_save', $moduletitle, $body, array('class' => ''));
        $module = array('body' => $modulecontent,
                        'class' => 'bottom'            
                        );
        $return['content']['main'][] = $module;     
    //SELECTCHANS MODULE//
    
	$return['title'] = $title;
	return $return;	
}


/**
 * Get page components to list a user's or all articles.
 *
 * @param int $owner_guid The GUID of the page owner or NULL for all articles
 * @return array
 */
function story_get_page_content_all($container_guid = NULL, $single = false) {

    $return = array();
    $return['title'] = elgg_echo('commentary:dailystory');

    //get latest article, full view
    $options = array(
        'type' => 'object',
        'subtype' => 'commentary',
        //'pagination' => FALSE,
        'full_story_view' => TRUE,
        'full_view' => FALSE,
        'hot_comments' => FALSE,
        'normal_comments' => TRUE,
        'limit' => 1,
        'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'dailystory')
    );

    $articles = elgg_get_entities_from_metadata($options);
    $article = $articles[0];
    $body = elgg_view_entity($article, $options);
    $moduletitle = elgg_echo("commentaries:dailystory:latest");
    $modulecontent = elgg_view_module('dailystory', $moduletitle, $body, array('class' => !$single ? 'tk-main-module' : 'tk-secondary-module'));
    if($single)return $modulecontent;
    $module = array('body' => $modulecontent,
                    'class' => 'toppest'            
                    );
    $return['content']['main'][] = $module;     
    
    //get more articles, but just summary views
    $options = array(
        'type' => 'object',
        'subtype' => 'commentary',
        'paginate' => FALSE,
        'full_story_view' => TRUE,
        'hot_comments' => FALSE,
        'normal_comments' => FALSE,
        'limit' => 4,
        'offset' => 1,
        'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'dailystory')
    );

    $articles = elgg_get_entities_from_metadata($options);
    foreach($articles as $article){
        $body = elgg_view_entity($article, $options);
        $return['content']['main'][] = elgg_view_module('dailystory', null, $body
                ,array('class' => 'tk-secondary-module')
            );    
    }
        
    return $return;
}



/**
 * Pull together commentary variables for the save form
 *
 * @param ElggCommentary       $post
 * @param ElggAnnotation $revision
 * @return array
 */
function commentary_prepare_form_vars($post = NULL, $revision = NULL) {

	// input names => defaults
	$values = array(
		'title' => NULL,
		'description' => NULL,
		'status' => 'published',
		'access_id' => ACCESS_PUBLIC,
		'comments_on' => 'On',
		'excerpt' => NULL,
        'tags' => NULL,
		'events' => NULL,
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

	if (elgg_is_sticky_form('commentary')) {
		$sticky_values = elgg_get_sticky_values('commentary');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}
	
	elgg_clear_sticky_form('commentary');

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
	if ($auto_save_annotations = $post->getAnnotations('commentary_auto_save', 1)) {
		$auto_save = $auto_save_annotations[0];
	} else {
		$auto_save == FALSE;
	}

	if ($auto_save && $auto_save->id != $revision->id) {
		$values['draft_warning'] = elgg_echo('commentary:messages:warning:draft');
	}

	return $values;
}

