<?php
/**
 * Elgg profile plugin
 *
 * @package ElggProfile
 */

elgg_register_event_handler('init', 'system', 'profile_init', 1);

// Metadata on users needs to be independent
// outside of init so it happens earlier in boot. See #3316
register_metadata_as_independent('user');

/**
 * Profile init function
 */
function profile_init() {

	// Register a URL handler for users - this means that profile_url()
	// will dictate the URL for all ElggUser objects
	elgg_register_entity_url_handler('user', 'all', 'profile_url');


	elgg_register_simplecache_view('icon/user/default/tiny');
	elgg_register_simplecache_view('icon/user/default/topbar');
	elgg_register_simplecache_view('icon/user/default/small');
	elgg_register_simplecache_view('icon/user/default/medium');
	elgg_register_simplecache_view('icon/user/default/large');
	elgg_register_simplecache_view('icon/user/default/master');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('profile', 'profile_page_handler');

	elgg_extend_view('page/elements/head', 'profile/metatags');
	elgg_extend_view('css/elgg', 'profile/css');
	elgg_extend_view('js/elgg', 'profile/js');

	// allow ECML in parts of the profile
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'profile_ecml_views_hook');

	// allow admins to set default widgets for users on profiles
	elgg_register_plugin_hook_handler('get_list', 'default_widgets', 'profile_default_widgets_hook');
}

/**
 * Profile page handler
 *
 * @param array $page Array of page elements, forwarded by the page handling mechanism
 */
function profile_page_handler($page) {

	if (isset($page[0])) {
		$username = $page[0];
		$user = get_user_by_username($username);
		elgg_set_page_owner_guid($user->guid);
	}

	// short circuit if invalid or banned username
	if (!$user || ($user->isBanned() && !elgg_is_admin_logged_in())) {
		register_error(elgg_echo('profile:notfound'));
		forward();
	}

	$action = NULL;
	if (isset($page[1])) {
		$action = $page[1];
	}

	if ($action == 'edit') {
		// use the core profile edit page
		$base_dir = elgg_get_root_path();
		require "{$base_dir}pages/profile/edit.php";
		return;
	}
    
$ownerblock = elgg_view('profile/owner_block');
$details = elgg_view('profile/details');
$name = "<h2>{$user->name}</h2>";

$content = <<<CONTENT
$name;

<div class="profiledetails">
    <div class="elgg-inner clearfix">
        $details
    </div>
</div>
<div class="profileownerblock">
    <div class="elgg-inner clearfix">
        $ownerblock
    </div>
</div>
CONTENT;
    
    $modulecontent = elgg_view_module('userprofile', null, $content, array('class' => 'tk-main-module'));
    $module = array('body' => $modulecontent,
                    'class' => 'toppest'            
                    );
    $return['content']['main'][] = $module;     



/*    $content = elgg_list_entities(array(
        "owner_guid" => elgg_get_page_owner_guid(),
        "type" => "object",
        "subtype" => "commentary",
        "full_view" => FALSE,
        "module_view" => TRUE,                
        "hot_comments" => FALSE,                
        "normal_comments" => FALSE,                
    ));
*/
$content = "<div class=\"profile_commentaries\">";
$content .= view_all_commentaries(array(
    "owner_guid" => elgg_get_page_owner_guid(),
    "type" => "object",
    "subtype" => "commentary",
    "full_view" => FALSE,
    "module_view" => TRUE,                
    "hot_comments" => FALSE,                
    "normal_comments" => FALSE,
    "limit" => 20,                
));    
$content .= "</div>";
    $modulecontent = elgg_view_module('commentaries', elgg_echo("commentaries"), $content, array('class' => 'tk-secondary-module'));
    $module = array('body' => $modulecontent,
                    'class' => ''            
                    );
    $return['content']['main'][] = $module;     


    add_template_modules($return);
    
	$body = elgg_view_layout('custom_index', $return);
	echo elgg_view_page($title, $body);
}

/**
 * Profile URL generator for $user->getUrl();
 *
 * @param ElggUser $user
 * @return string User URL
 */
function profile_url($user) {
	return elgg_get_site_url() . "profile/" . $user->username;
}

/**
 * Parse ECML on parts of the profile
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $return_value
 * @param unknown_type $params
 */
function profile_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['profile/profile_content'] = elgg_echo('profile');

	return $return_value;
}

/**
 * Register profile widgets with default widgets
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $return
 * @param unknown_type $params
 * @return array
 */
function profile_default_widgets_hook($hook, $type, $return, $params) {
	$return[] = array(
		'name' => elgg_echo('profile'),
		'widget_context' => 'profile',
		'widget_columns' => 3,

		'event' => 'create',
		'entity_type' => 'user',
		'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
	);

	return $return;
}
