<?php
/**
 * Plugin for creating web pages for your footer
 */

elgg_register_event_handler('init', 'system', 'expages_init');

function expages_init() {

	// Register a page handler, so we can have nice URLs
    elgg_register_page_handler('about', 'expages_page_handler');
	elgg_register_page_handler('faq', 'expages_page_handler');
	elgg_register_page_handler('terms', 'expages_page_handler');
	elgg_register_page_handler('privacy', 'expages_page_handler');
	elgg_register_page_handler('expages', 'expages_page_handler');

	// add a menu item for the admin edit page
	elgg_register_admin_menu_item('configure', 'expages', 'appearance');

	// add footer links
//	expages_setup_footer_menu();

	// add a site navigation item
	elgg_register_menu_item('site', array(
            'name' => 'faq',
            'href' => 'faq',
            'text' => elgg_echo('expages:faq'),
            'priority' => 6,
            'link_class' => 'faq-menu',
        ));
		
	// add a site navigation item
	elgg_register_menu_item('site', array(
            'name' => 'about',
            'href' => 'about',
            'text' => elgg_echo('expages:about'),
            'priority' => 7,
            'link_class' => 'about-menu',
        ));


    // add a footer navigation item
    $item = new ElggMenuItem('terms', 
    //elgg_echo('blog:blogs'), 
    elgg_echo('expages:terms'), 
//    'Terms',
    'terms');
    elgg_register_menu_item('footer', $item);

    // add a footer navigation item
    $item = new ElggMenuItem('privacy', 
    //elgg_echo('blog:blogs'), 
    elgg_echo('expages:privacy'), 
//    'Privacy',
    'privacy');
    elgg_register_menu_item('footer', $item);


	// register action
	$actions_base = elgg_get_plugins_path() . 'externalpages/actions';
	elgg_register_action("expages/edit", "$actions_base/edit.php", 'admin');
}


/**
 * Setup the links to footer pages
 */
/* function expages_setup_footer_menu() {
	$pages = array('about', 'terms', 'privacy');
	foreach ($pages as $page) {
		$url = "$page";
		$item = new ElggMenuItem($page, elgg_echo("expages:$page"), $url);
		elgg_register_menu_item('footer', $item);
	}
}
*/
/**
 * External pages page handler
 *
 * @param array  $page    URL segements
 * @param string $handler Handler identifier
 */
function expages_page_handler($page, $handler) {
	if ($handler == 'expages') {
		expages_url_forwarder($page[1]);
	}
	$type = strtolower($handler);

	$title = elgg_echo("expages:$type");
	$content = elgg_view_title($title);

	$object = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => $type,
		'limit' => 1,
	));
	if ($object) {
        $contents = unserialize($object[0]->description);        
		$content .= elgg_view('output/longtext', array('value' => $contents[get_current_language()]));
	} else {
		$content .= elgg_echo("expages:notset");
	}

    $params['content']['main'][] = 
        array(
            "body" => elgg_view_module("expage", null, $content, array("class" => "tk-main-module")), 
            "class" => "toppest"
        );
    
    add_template_modules($params, "default");

	$body = elgg_view_layout("custom_index", $params);
	echo elgg_view_page($title, $body);
}

/**
 * Forward to the new style of URLs
 *
 * @param string $page
 */
function expages_url_forwarder($page) {
	global $CONFIG;
	$url = "{$CONFIG->wwwroot}{$page}";
	forward($url);
}
