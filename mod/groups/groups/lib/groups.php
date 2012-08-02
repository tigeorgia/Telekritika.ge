<?php
/**
 * Groups function library
 */

/**
 * Groups function library
 */

/**
 * List all groups
 */
function groups_handle_all_page($subtype = "group") {

	// all groups doesn't get link to self
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo($subtype));
    
    if(elgg_is_admin_logged_in()){
    	elgg_register_title_button();
    }
	$selected_tab = get_input('filter', 'newest');

	switch ($selected_tab) {
		case 'popular':
			$content = elgg_list_entities_from_relationship_count(array(
				'type' => 'group',
				'relationship' => 'member',
				'inverse_relationship' => false,
				'full_view' => false,
                'subtype' => ($subtype != 'group')
                    ? $subtype
                    : null,
			));

			break;
		case 'discussion':
			$content = elgg_list_entities(array(
				'type' => 'object',
				'subtype' => 'groupforumtopic',
				'order_by' => 'e.last_action desc',
				'limit' => 40,
				'full_view' => false,
			));
			break;
		case 'newest':
		default:
			$content = elgg_list_entities(array(
				'type' => 'group',
				'full_view' => false,
                'subtype' => ($subtype != 'group')
                    ? $subtype
                    : null,
			));
			break;
	}

	$filter = elgg_view("{$subtype}s/{$subtype}_sort_menu", array('selected' => $selected_tab));
	
	$sidebar = elgg_view("{$subtype}s/sidebar/find");
	$sidebar .= elgg_view("{$subtype}s/sidebar/featured"); 

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => $filter,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page(elgg_echo("{$subtype}'s:all"), $body);
}

function groups_search_page($subtype = "group") {
	elgg_push_breadcrumb(elgg_echo('search'));

	$tag = get_input("tag");
	$title = elgg_echo("{$subtype}s:search:title", array($tag));

	// groups plugin saves tags as "interests" - see groups_fields_setup() in start.php
	$params = array(
		'metadata_name' => 'interests',
		'metadata_value' => $tag,
		'types' => 'group',
		'full_view' => FALSE,
        'subtypes' => ($subtype != 'group')
            ? $subtype
            : null,
	);
	$content = elgg_list_entities_from_metadata($params);
	if (!$content) {
		$content = elgg_echo("{$subtype}:search:none");
	}

	$sidebar = elgg_view("{$subtype}/sidebar/find");
	$sidebar .= elgg_view("{$subtype}/sidebar/featured");

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => false,
		'title' => $title,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * List owned groups
 */
function groups_handle_owned_page($userid, $subtype = "group") {

//	$page_owner = elgg_get_page_owner_entity();

//    $page_owner = get_entity(35);

	$title = elgg_echo("{$subtype}:owned");
	elgg_push_breadcrumb($title);
    if(elgg_is_admin_logged_in()){
    	elgg_register_title_button();
    }
	$content = elgg_list_entities(array(
		'type' => 'group',
		'owner_guid' => $userid,
		'full_view' => false,
        'subtype' => $subtype
	));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * List groups the user is memober of
 */
function groups_handle_mine_page($subtype = "group") {

	$page_owner = elgg_get_page_owner_entity();

	$title = elgg_echo("{$subtype}s:yours");
	elgg_push_breadcrumb($title);

    if(elgg_is_admin_logged_in()){
	    elgg_register_title_button();
    }

	$content = elgg_list_entities_from_relationship_count(array(
		'type' => 'group',
		'relationship' => 'member',
		'relationship_guid' => elgg_get_page_owner_guid(),
		'inverse_relationship' => false,
		'full_view' => false,
        'subtype' => ($subtype != 'group')
            ? $subtype
            : null,
	));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Create or edit a group
 *
 * @param string $page
 * @param int $guid
 */
function groups_handle_edit_page($page, $guid = 0, $subtype = "group") {
	gatekeeper();
        $params['subtype'] = $subtype;
	if ($page == 'add') {
		elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
		$title = elgg_echo($subtype.'s:add');
		elgg_push_breadcrumb($title);
//        $content = elgg_view($subtype.'s/edit');
		$content = elgg_view('groups/edit', $params);
	} else {
		$title = elgg_echo($subtype."s:edit");
		$group = get_entity($guid);

		if ($group && $group->canEdit()) {
			elgg_set_page_owner_guid($group->getGUID());
			elgg_push_breadcrumb($group->name, $group->getURL());
			elgg_push_breadcrumb($title);
//            $content = elgg_view($subtype."s/edit", array('entity' => $group));
			$content = elgg_view("groups/edit", array('entity' => $group, 'subtype' => $params['subtype']));
		} else {
			$content = elgg_echo($subtype.'s:noaccess');
		}
	}
	
	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group invitations for a user
 */
function groups_handle_invitations_page($subtype = "group") {
	gatekeeper();

	$user = elgg_get_page_owner_entity();

	$title = elgg_echo('groups:invitations');
	elgg_push_breadcrumb($title);

	// @todo temporary workaround for exts #287.
	$invitations = groups_get_invited_groups(elgg_get_logged_in_user_guid());
	$content = elgg_view('groups/invitationrequests', array('invitations' => $invitations));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group profile page
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_profile_page($guid, $subtype = "group") {
	elgg_set_page_owner_guid($guid);

	// turn this into a core function
	global $autofeed;
	$autofeed = true;

	$group = get_entity($guid);
	if (!$group) {
		forward("{$subtype}s/all");
	}

	elgg_push_breadcrumb($group->name);

	$content = elgg_view("{$subtype}s/profile/layout", array('entity' => $group));
	if (group_gatekeeper(false)) {
		$sidebar = elgg_view("{$subtype}s/sidebar/members", array('entity' => $group));
	} else {
		$sidebar = '';
	}

	groups_register_profile_buttons($group, $subtype);

    if($subtype == "channel")groups_unregister_profile_buttons($subtype);
    
	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'title' => $group->name,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);
/**
 * Main content area layout
 *
 * @uses $vars['content']        HTML of main content area
 * @uses $vars['sidebar']        HTML of the sidebar
 * @uses $vars['header']         HTML of the content area header (override)
 * @uses $vars['nav']            HTML of the content area nav (override)
 * @uses $vars['footer']         HTML of the content area footer
 * @uses $vars['filter']         HTML of the content area filter (override)
 * @uses $vars['title']          Title text (override)
 * @uses $vars['context']        Page context (override)
 * @uses $vars['filter_context'] Filter context: everyone, friends, mine
 * @uses $vars['class']          Additional class to apply to layout
 */

    
    
	echo elgg_view_page($group->name, $body);
}

function groups_unregister_profile_buttons($subtype){
    elgg_unregister_menu_item('title', $subtype.'s:join');
    elgg_unregister_menu_item('title', $subtype.'s:joinrequest');
    elgg_unregister_menu_item('title', $subtype.'s:leave');
    elgg_unregister_menu_item('title', $subtype.'s:invite');
}

/**
 * Group activity page
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_activity_page($guid, $subtype = "group") {

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);
	if (!$group || !elgg_instanceof($group, 'group')) {
		forward();
	}

	group_gatekeeper();

	$title = elgg_echo("{$subtype}s:activity");

	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb($title);

	$db_prefix = elgg_get_config('dbprefix');

	$content = elgg_list_river(array(
		'joins' => array("JOIN {$db_prefix}entities e ON e.guid = rv.object_guid"),
		'wheres' => array("e.container_guid = $guid")
	));
	if (!$content) {
		$content = '<p>' . elgg_echo("{$subtype}:activity:none") . '</p>';
	}
	
	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group members page
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_members_page($guid, $subtype = "group") {

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);
	if (!$group || !elgg_instanceof($group, 'group')) {
		forward();
	}

	group_gatekeeper();

	$title = elgg_echo('groups:members:title', array($group->name));

	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb(elgg_echo('groups:members'));

	$content = elgg_list_entities_from_relationship(array(
		'relationship' => 'member',
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'types' => 'user',
		'limit' => 20,
	));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Invite users to a group
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_invite_page($guid, $subtype = "group") {
	gatekeeper();

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);

	$title = elgg_echo('groups:invite:title');

	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb(elgg_echo('groups:invite'));

	if ($group && $group->canEdit()) {
		$content = elgg_view_form('groups/invite', array(
			'id' => 'invite_to_group',
			'class' => 'elgg-form-alt mtm',
		), array(
			'entity' => $group,
		));
	} else {
		$content .= elgg_echo('groups:noaccess');
	}

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Manage requests to join a group
 * 
 * @param int $guid Group entity GUID
 */
function groups_handle_requests_page($guid, $subtype = "group") {

	gatekeeper();

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);

	$title = elgg_echo('groups:membershiprequests');

	if ($group && $group->canEdit()) {
		elgg_push_breadcrumb($group->name, $group->getURL());
		elgg_push_breadcrumb($title);
		
		$requests = elgg_get_entities_from_relationship(array(
			'relationship' => 'membership_request',
			'relationship_guid' => $guid,
			'inverse_relationship' => true,
		));
		$content = elgg_view('groups/membershiprequests', array(
			'requests' => $requests,
			'entity' => $group,
		));

	} else {
		$content = elgg_echo("groups:noaccess");
	}

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Registers the buttons for title area of the group profile page
 *
 * @param ElggGroup $group
 */
function groups_register_profile_buttons($group, $subtype = "group") {

	$actions = array();

	// group owners
	if ($group->canEdit()) {
		// edit and invite
		$url = elgg_get_site_url() . "{$subtype}s/edit/{$group->getGUID()}";
		$actions[$url] = $subtype.'s:edit';
		$url = elgg_get_site_url() . "{$subtype}s/invite/{$group->getGUID()}";
		$actions[$url] = $subtype.'s:invite';
	}

	// group members
	if ($group->isMember($user)) {
		// leave
		$url = elgg_get_site_url() . "action/groups/leave?group_guid={$group->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		$actions[$url] = $subtype.'s:leave';
	} else {
		// join - admins can always join.
		$url = elgg_get_site_url() . "action/groups/join?group_guid={$group->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		if ($group->isPublicMembership() || $group->canEdit()) {
			$actions[$url] = $subtype.'s:join';
		} else {
			// request membership
			$actions[$url] = $subtype.'s:joinrequest';
		}
	}

	if ($actions) {
		foreach ($actions as $url => $text) {
			elgg_register_menu_item('title', array(
				'name' => $text,
				'href' => $url,
				'text' => elgg_echo($text),
				'link_class' => 'elgg-button elgg-button-action',
			));
		}
	}
}