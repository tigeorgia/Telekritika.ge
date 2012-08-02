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

	$return = array();

	$commentary = get_entity($guid);

	// no header or tabs for viewing an individual commentary
	$return['filter'] = '';
	$return['header'] = '';

	if (!elgg_instanceof($commentary, 'object', 'commentary')) {
		$return['content'] = elgg_echo('commentary:error:post_not_found');
		return $return;
	}

	$return['title'] = htmlspecialchars($commentary->title);

	$container = $commentary->getContainerEntity();
	$crumbs_title = $container->name;
	if (elgg_instanceof($container, 'group')) {
		elgg_push_breadcrumb($crumbs_title, "commentary/group/$container->guid/all");
	} else {
		elgg_push_breadcrumb($crumbs_title, "commentary/owner/$container->username");
	}

	elgg_push_breadcrumb($commentary->title);
	$return['content'] = elgg_view_entity($commentary, array('full_view' => true));
	//check to see if comment are on
	if ($commentary->comments_on != 'Off') {
		$return['content'] .= elgg_view_comments($commentary);
	}

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
		'full_view' => FALSE,
	);

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

    if(elgg_is_admin_logged_in()){
    	elgg_register_title_button();
    }
        
	// show all posts for admin or users looking at their own commentaries
	// show only published posts for other users.
	if (!(elgg_is_admin_logged_in() || (elgg_is_logged_in() && $container_guid == $loggedin_userid))) {
		$options['metadata_name_value_pairs'] = array(
			array('name' => 'status', 'value' => 'published'),
		);
	}

	$list = elgg_list_entities_from_metadata($options);
	if (!$list) {
		$return['content'] = elgg_echo('commentary:none');
	} else {
		$return['content'] = $list;
	}

    if(!isMonitor() && !elgg_is_admin_logged_in()){
        $return['filter'] = false;        
    }
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
				array('name' => 'status', 'value' => 'published')
			);
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
			array('name' => 'status', 'value' => 'published')
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
function commentary_get_page_content_edit($page, $guid = 0, $revision = NULL) {

	elgg_load_js('elgg.commentary');

	$return = array(
		'filter' => '',
	);

	$vars = array();
	$vars['id'] = 'commentary-post-edit';
	$vars['name'] = 'commentary_post';
	$vars['class'] = 'elgg-form-alt';

	if ($page == 'edit' || $guid) {
		$commentary = get_entity((int)$guid);

		$title = elgg_echo('commentary:edit');

//		if (elgg_instanceof($commentary, 'object', 'commentary') && $commentary->canEdit()) {
			$vars['entity'] = $commentary;

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

            $content = get_channelbar();
            $content .= elgg_view_form('commentary/save', $vars, $body_vars);
            
            $commentary_js = elgg_get_simplecache_url('js', 'commentary/save_draft');
            elgg_register_js('elgg.commentary', $commentary_js);
		
        /*} else {
			$content = elgg_echo('commentary:error:cannot_edit_post');
		} */
	} else {
	    $container = elgg_get_logged_in_user_entity();

		elgg_push_breadcrumb(elgg_echo('commentary:add'));
		$body_vars = commentary_prepare_form_vars($commentary);

		$title = elgg_echo('commentary:add');

        $content = get_channelbar();
		$content .= elgg_view_form('commentary/save', $vars, $body_vars);
		
		$commentary_js = elgg_get_simplecache_url('js', 'commentary/save_draft');
		elgg_register_js('elgg.commentary', $commentary_js);
	}

	$return['title'] = $title;
	$return['content'] = $content;
	$return['sidebar'] = $sidebar;
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

/**
 * Forward to the new style of URLs
 *
 * @param string $page
 */
/*function commentary_url_forwarder($page) {
	global $CONFIG;

	// group usernames
	if (substr_count($page[0], 'group:')) {
		preg_match('/group\:([0-9]+)/i', $page[0], $matches);
		$guid = $matches[1];
		$entity = get_entity($guid);
		if ($entity) {
			$url = "{$CONFIG->wwwroot}commentary/group/$guid/all";
			register_error(elgg_echo("changebookmark"));
			forward($url);
		}
	}

	// user usernames
	$user = get_user_by_username($page[0]);
	if (!$user) {
		return;
	}

	if (!isset($page[1])) {
		$page[1] = 'owner';
	}

	switch ($page[1]) {
		case "read":
            //$url = "{$CONFIG->wwwroot}commentary/view/{$page[2]}/{$page[3]}";
			$url = "{$CONFIG->wwwroot}commentary/view/{$page[2]}";
			break;
		case "archive":
           // $url = "{$CONFIG->wwwroot}commentary/archive/{$page[0]}/{$page[2]}/{$page[3]}";
			$url = "{$CONFIG->wwwroot}commentary/archive/{$page[0]}/{$page[2]}";
			break;
		case "friends":
			$url = "{$CONFIG->wwwroot}commentary/friends/{$page[0]}";
			break;
		case "new":
			$url = "{$CONFIG->wwwroot}commentary/add/$user->guid";
			break;
		case "owner":
			$url = "{$CONFIG->wwwroot}commentary/owner/{$page[0]}";
			break;
	}

	register_error(elgg_echo("changebookmark"));
	forward($url);
}
*/

/*
function channelviewer_page($page) {

    // all groups doesn't get link to self
//    elgg_pop_breadcrumb();
//    elgg_push_breadcrumb(elgg_echo($subtype));
    
//    if(elgg_is_admin_logged_in()){
//        elgg_register_title_button();
//    }
//    $selected_tab = get_input('filter', 'newest');

    $content = elgg_list_entities(array(
        'type' => 'group',
        'full_view' => false,
        'subtype' => 'channel'
    ),'elgg_get_entities','elgg_view_channelbar');

//    $filter = elgg_view("{$subtype}s/{$subtype}_sort_menu", array('selected' => $selected_tab));
//    $sidebar = elgg_view("{$subtype}s/sidebar/find");
//    $sidebar .= elgg_view("{$subtype}s/sidebar/featured"); 
$sidebar = "";
$filter = "";

    $params = array(
        'content' => $content,
        'sidebar' => $sidebar,
        'filter' => $filter,
    );
//    $body = elgg_view_layout('content', $params);
    return $params;
//    echo elgg_view_page(elgg_echo("channelviewer:all"), $body);
}
*/


