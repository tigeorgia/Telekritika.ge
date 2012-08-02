<?php
/**
 * segments
 *
 * @package Segment
 *
 * @todo
 * - Either drop support for "publish date" or duplicate more entity getter
 * functions to work with a non-standard time_created.
 * - Pingbacks
 * - Notifications
 * - River entry for posts saved as drafts and later published
 */

elgg_register_event_handler('init', 'system', 'segment_init');

/**
 * Init segment plugin.
 */
function segment_init() {

	elgg_register_library('elgg:segment', elgg_get_plugins_path() . 'segment/lib/segment.php');

    if(isMonitor()){
        // add a site navigation item
        $item = new ElggMenuItem('segment', elgg_echo('segment:yoursegments'), 'segment/owner/'.elgg_get_logged_in_user_guid());
        elgg_register_menu_item('topbar', $item);
    }
    
    if(elgg_is_admin_logged_in()){
        // add a site navigation item
        $item2 = new ElggMenuItem('allsegments', elgg_echo('segment:allsegments'), 'segment/');
        elgg_register_menu_item('topbar', $item2);
        $item = new ElggMenuItem('pendingsegments', elgg_echo('segment:pendingsegments'), 'segment/pending/');
        elgg_register_menu_item('topbar', $item);
    }

    elgg_register_plugin_hook_handler("comments", "object", "segment_admin_comment_view");
                                                                                       
	// register the segment's JavaScript
	$segment_js = elgg_get_simplecache_url('js', 'segment/save_draft');
	elgg_register_js('elgg.segment', $segment_js);

	// routing of urls
	elgg_register_page_handler('segment', 'segment_page_handler');

	// override the default url to view a segment object
	elgg_register_entity_url_handler('object', 'segment', 'segment_url_handler');

	// notifications
	//register_notification_object('object', 'segment', elgg_echo('segment:newpost'));
	//elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'segment_notify_message');

	// add segment link to
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'segment_owner_block_menu');

	// pingbacks
	//elgg_register_event_handler('create', 'object', 'segment_incoming_ping');
	//elgg_register_plugin_hook_handler('pingback:object:subtypes', 'object', 'segment_pingback_subtypes');

	// Register for search.
	elgg_register_entity_type('object', 'segment');

	// Add group option
//    add_group_tool_option('segment', elgg_echo('segment:enablesegment'), false);
//	add_channel_tool_option('segment', elgg_echo('segment:enablesegment'), false);
//	elgg_extend_view('channels/tool_latest', 'segment/channel_module');

	// add a segment widget
//	elgg_register_widget_type('segment', elgg_echo('segment'), elgg_echo('segment:widget:description'), 'all');

	// register actions
	$action_path = elgg_get_plugins_path() . 'segment/actions/segment';
    elgg_register_action('segment/approve', "$action_path/approve.php");
	elgg_register_action('segment/save', "$action_path/save.php");
	elgg_register_action('segment/auto_save_revision', "$action_path/auto_save_revision.php");
	elgg_register_action('segment/delete', "$action_path/delete.php");

	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'segment_entity_menu_setup');

	// ecml
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'segment_ecml_views_hook');
    
}

/**
 * Dispatches segment pages.
 * URLs take the form of
 *  All segments:       segment/all
 *  User's segments:    segment/owner/<username>
 *  Friends' segment:   segment/friends/<username>
 *  User's archives: segment/archives/<username>/<time_start>/<time_stop>
 *  segment post:       segment/view/<guid>/<title>
 *  New post:        segment/add/<guid>
 *  Edit post:       segment/edit/<guid>/<revision>
 *  Preview post:    segment/preview/<guid>
 *  Group segment:      segment/group/<guid>/all
 *
 * Title is ignored
 *
 * @todo no archives for all segments or friends
 *
 * @param array $page
 * @return NULL
 */
function segment_page_handler($page) {

	elgg_load_library('elgg:segment');

	// push all segments breadcrumb
	elgg_push_breadcrumb(elgg_echo('segment:segments'), "segment/all");

	$page_type = $page[0];
	if(!$page_type){
        $page_type = "all";
    }
    switch ($page_type) {
        case 'owner':
            monitor_gatekeeper();
            $user = get_entity($page[1]);
            $params = segment_get_page_owned_list($user->guid);
            break;
		case 'pending':
			admin_gatekeeper();
            $params = segment_get_page_pending_list();
			break;
		case 'add':
            monitor_gatekeeper();
			$params = segment_get_page_content_edit($page_type, $page[1]);
            $params['sidebar'] .= elgg_view('segment/sidebar', array('page' => $page_type));
			break;
		case 'edit':
			monitor_gatekeeper();
			$params = segment_get_page_content_edit($page_type, $page[1], $page[2]);
            $params['sidebar'] .= elgg_view('segment/sidebar', array('page' => $page_type));
			break;
		case 'all':
		default:
            admin_gatekeeper();
			$title = elgg_echo('segment:title:all_segments');
			$params = segment_get_page_content_list();
//            $params = segment_get_page_content_read($page[0]);
			break;
	}
    //$params['filter_context'] = 'mine';
    $params['filter'] = false;
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($params['title'], $body, "default", $params);
}

/**
 * Format and return the URL for segments.
 *
 * @param ElggObject $entity segment object
 * @return string URL of segment.
 */
function segment_url_handler($entity) {

	$friendly_title = elgg_get_friendly_title($entity->title);

//    return "segment/view/{$entity->guid}/$friendly_title";
    if(elgg_is_admin_logged_in() 
        || (isMonitor() 
            && $entity->status != "published"
            && elgg_get_logged_in_user_guid() == $entity->owner_guid
            )
    ){
        return "segment/edit/{$entity->guid}";            
    }else{
        return "channels/{$entity->guid}";
    }
        
}

function segment_admin_comment_view($hook, $type, $return, $params){    
    if($params['entity'] instanceOf ElggSegment && $params['admin_comment']){
        return elgg_view('page/elements/admin_comments', $params);        
    }
    return false;        
}


/**
 * Add a menu item to an ownerblock
 */
function segment_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "segment/owner/{$params['entity']->guid}";
		$item = new ElggMenuItem('segment', elgg_echo('segment'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->segment_enable != "no") {
			$url = "segment/channel/{$params['entity']->guid}";
			$item = new ElggMenuItem('segment', elgg_echo('segment:channel'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add particular segment links/info to entity menu
 */
function segment_entity_menu_setup($hook, $type, $return, $params) {

	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'segment') {
		return $return;
	}

	if (elgg_is_admin_logged_in()
    //&& $entity->status != 'published'
    ) {
        // dislikes button
        $options = array(
            'name' => 'approve',
            'text' => elgg_view("segment/approve", array('entity'=> $params['entity'])),
            'priority' => 9999,
//            'is_action' => true,
        );
        $return[] = ElggMenuItem::factory($options);        
	}
    
	return $return;
}

/**
 * Register segments with ECML.
 */
function segment_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['object/segment'] = elgg_echo('segment:segments');

	return $return_value;
}


/**
 * Convenience function for registering a button to title menu
 *
 * The URL must be $handler/$name/$guid where $guid is the guid of the page owner.
 * The label of the button is "$handler:$name" so that must be defined in a
 * language file.
 *
 * This is used primarily to support adding an add content button
 *
 * @param string $handler The handler to use or null to autodetect from context
 * @param string $name    Name of the button
 * @return void
 * @since 1.8.0
 */
function elgg_register_segment_title_button($containerid, $handler = null, $name = 'add') {
    if (elgg_is_logged_in()) {

        if (!$handler) {
            $handler = elgg_get_context();
        }

        $owner = elgg_get_page_owner_entity();
        if (!$owner) {
            // no owns the page so this is probably an all site list page
            $owner = elgg_get_logged_in_user_entity();
        }
        if ($owner && $owner->canWriteToContainer()) {
//            $guid = $owner->getGUID();
            $guid = $containerid;
            elgg_register_menu_item('title', array(
                'name' => $name,
                'href' => "$handler/$name/$guid",
                'text' => elgg_echo("$handler:$name"),
                'link_class' => 'elgg-button elgg-button-action',
            ));
        }
    }
}

function river_contains_broadcast($broadcast_type, $segment_date, $channel_guid){
    $metaoptions = array(
        'types' => array('object'),
        'subtypes' => array('segment'),
        'metadata_name_value_pairs' =>  array(
                                            array (
                                             name => 'broadcast_type',
                                             value => $broadcast_type,
                                             'operand' => '=',
                                            ),
                                            array (
                                             name => 'segment_type',
                                             value => $segment_type,
                                             'operand' => '=',
                                            )
                                        ),
        'container_guids' => array($channel_guid),
    );

    if($entities = elgg_get_entities_from_metadata($metaoptions)){
        foreach($entities as $key => $val){
            $object_guids[] = $val->guid;
        }
    }else{
        return false;
    }

    $riveroptions = array(
        'subtypes' => "segment",
        'object_guids' => $object_guids       
    );
    if(elgg_get_river($riveroptions))
        return true;
        
    return false;
}
