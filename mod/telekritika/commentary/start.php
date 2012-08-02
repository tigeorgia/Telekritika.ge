<?php
/**
 * Commentaries
 *
 * @package Commentary
 *
 * @todo
 * - Either drop support for "publish date" or duplicate more entity getter
 * functions to work with a non-standard time_created.
 * - Pingbacks
 * - Notifications
 * - River entry for posts saved as drafts and later published
 */
elgg_register_event_handler('init', 'system', 'commentary_init');

/**
 * Init commentary plugin.
 */
function commentary_init() {

	elgg_register_library('elgg:commentary', elgg_get_plugins_path() . 'commentary/lib/commentary.php');

	// add a site navigation item
	$item = new ElggMenuItem('commentary', elgg_echo('commentary:commentaries'), 'channels');
	elgg_register_menu_item('site', $item);

	elgg_register_event_handler('upgrade', 'upgrade', 'commentary_run_upgrades');

	// add to the main css
	elgg_extend_view('css/elgg', 'commentary/css');

    // register the commentary's JavaScript
    $commentary_js = elgg_get_simplecache_url('js', 'commentary/save_draft');
    elgg_register_js('elgg.commentary', $commentary_js);

    // register the autocomplete's JavaScript
    $autocomplete_cv = elgg_get_simplecache_url('js', 'commentary/autocomplete_cv');
    elgg_register_js('elgg.autocomplete_cv', $autocomplete_cv);

	// routing of urls
    elgg_register_page_handler('channels', 'commentary_page_handler');
//	elgg_register_page_handler('channels', 'commentary_page_handler');

	// override the default url to view a commentary object
	elgg_register_entity_url_handler('object', 'commentary', 'commentary_url_handler');

	// notifications
	register_notification_object('object', 'commentary', elgg_echo('commentary:newpost'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'commentary_notify_message');

	// add commentary link to
	//elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'commentary_owner_block_menu');

	// pingbacks
	//elgg_register_event_handler('create', 'object', 'commentary_incoming_ping');
	//elgg_register_plugin_hook_handler('pingback:object:subtypes', 'object', 'commentary_pingback_subtypes');

	// Register for search.
	elgg_register_entity_type('object', 'commentary');

	// Add group option
//    add_group_tool_option('commentary', elgg_echo('commentary:enablecommentary'), true);
//    add_channel_tool_option('commentary', elgg_echo('commentary:enablecommentary'), false);
//	elgg_extend_view('groups/tool_latest', 'commentary/group_module');

	// add a commentary widget
//	elgg_register_widget_type('commentary', elgg_echo('commentary'), elgg_echo('commentary:widget:description'), 'profile');

	// register actions
	$action_path = elgg_get_plugins_path() . 'commentary/actions/commentary';
	elgg_register_action('commentary/save', "$action_path/save.php");
	elgg_register_action('commentary/auto_save_revision', "$action_path/auto_save_revision.php");
    elgg_register_action('commentary/delete', "$action_path/delete.php");

    elgg_register_action('cv_segmentselect_module', "$action_path/cv_segmentselect_module.php");
	elgg_register_action('cv_return_segments', "$action_path/cv_return_segments.php");

	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'commentary_entity_menu_setup');

	// ecml
//	elgg_register_plugin_hook_handler('get_views', 'ecml', 'commentary_ecml_views_hook');
}

/**
 * Dispatches commentary pages.
 * URLs take the form of
 *  All commentaries:       commentary/all
 *  User's commentaries:    commentary/owner/<username>
 *  Friends' commentary:   commentary/friends/<username>
 *  User's archives: commentary/archives/<username>/<time_start>/<time_stop>
 *  Commentary post:       commentary/view/<guid>/<title>
 *  New post:        commentary/add/<guid>
 *  Edit post:       commentary/edit/<guid>/<revision>
 *  Preview post:    commentary/preview/<guid>
 *  Group commentary:      commentary/group/<guid>/all
 *
 * Title is ignored
 *
 * @todo no archives for all commentaries or friends
 *
 * @param array $page
 * @return NULL
 */
function commentary_page_handler($page) {

	elgg_load_library('elgg:commentary');

	// @todo remove the forwarder in 1.9
	// forward to correct URL for bookmarks pre-1.7.5
//	commentary_url_forwarder($page);

	// push all commentaries breadcrumb
//	elgg_push_breadcrumb(elgg_echo('commentary:commentaries'), "commentary/all");

    $layout = "content";
	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			$user = get_user_by_username($page[1]);
			$params = commentary_get_page_content_list($user->guid);
			break;
		case 'friends':
			$user = get_user_by_username($page[1]);
			$params = commentary_get_page_content_friends($user->guid);
			break;
		case 'view':
			$params = commentary_get_page_content_read($page[1]);
			break;
		case 'add':
			gatekeeper();
			$params = commentary_get_page_content_edit($page_type, $page[1]);
			break;
		case 'edit':
			admin_gatekeeper();
			$params = commentary_get_page_content_edit($page_type, $page[1], $page[2]);
			break;
		case 'all':
            admin_gatekeeper();
            $params = commentary_get_page_content_list();
		break;
        default:
            $params = commentary_get_page_content_edit("add", $page[0]);                                
            $layout = 'content_cv';
        break;
	}

	$params['sidebar'] .= elgg_view('commentary/sidebar', array('page' => $page_type));

	$body = elgg_view_layout($layout, $params);

	echo elgg_view_page($params['title'], $body);
}

/**
 * Format and return the URL for commentaries.
 *
 * @param ElggObject $entity Commentary object
 * @return string URL of commentary.
 */
function commentary_url_handler($entity) {
	if (!$entity->getOwnerEntity()) {
		// default to a standard view if no owner.
		return FALSE;
	}

	$friendly_title = elgg_get_friendly_title($entity->title);

	return "channels/{$entity->guid}/$friendly_title";
}

/**
 * Add a menu item to an ownerblock
 */
function commentary_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "commentary/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('commentary', elgg_echo('commentary'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->commentary_enable != "no") {
			$url = "commentary/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('commentary', elgg_echo('commentary:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add particular commentary links/info to entity menu
 */
function commentary_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'commentary') {
		return $return;
	}

	if ($entity->canEdit() && $entity->status != 'published') {
		$status_text = elgg_echo("commentary:status:{$entity->status}");
		$options = array(
			'name' => 'published_status',
			'text' => "<span>$status_text</span>",
			'href' => false,
			'priority' => 150,
		);
		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}

/**
 * Register commentaries with ECML.
 */
function commentary_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['object/commentary'] = elgg_echo('commentary:commentaries');

	return $return_value;
}

/**
 * Upgrade from 1.7 to 1.8.
 */
function commentary_run_upgrades($event, $type, $details) {
	$commentary_upgrade_version = get_plugin_setting('upgrade_version', 'commentaries');

	if (!$commentary_upgrade_version) {
		 // When upgrading, check if the ElggCommentary class has been registered as this
		 // was added in Elgg 1.8
		if (!update_subtype('object', 'commentary', 'ElggCommentary')) {
			add_subtype('object', 'commentary', 'ElggCommentary');
		}

		// only run this on the first migration to 1.8
		// add excerpt to all commentaries that don't have it.
		$ia = elgg_set_ignore_access(true);
		$options = array(
			'type' => 'object',
			'subtype' => 'commentary'
		);

		$commentaries = new ElggBatch('elgg_get_entities', $options);
		foreach ($commentaries as $commentary) {
			if (!$commentary->excerpt) {
				$commentary->excerpt = elgg_get_excerpt($commentary->description);
			}
		}

		elgg_set_ignore_access($ia);

		elgg_set_plugin_setting('upgrade_version', 1, 'commentaries');
	}
}
