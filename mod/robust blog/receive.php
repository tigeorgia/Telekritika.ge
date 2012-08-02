<?php

	/**
	 * trackback_response() - Respond with error or success XML message
	 *
	 * this function borrowed from WordPress
	 * 
	 * @param int|bool $error Whether there was an error or not
	 * @param string $error_message Error message if an error occurred
	 */
	 
$trackback = get_plugin_setting('trackback','blog');
if ($trackback != 'no'){
	 
	function trackback_response($error = 0, $error_message = '') {
		header('Content-Type: text/xml; charset=iso-8859-1' );
		if ($error) {
			echo '<?xml version="1.0" encoding="utf-8"?'.">\n";
			echo "<response>\n";
			echo "<error>1</error>\n";
			echo "<message>$error_message</message>\n";
			echo "</response>";
			exit();
		} else {
			echo '<?xml version="1.0" encoding="utf-8"?'.">\n";
			echo "<response>\n";
			echo "<error>0</error>\n";
			echo "</response>";
		}
	}


	$username = get_input("username");
	if (!$username)
		trackback_response(1, "this url does not support trackbacks");
	
	
	// get trackback parameters
	$url = get_input('url');
	$title = get_input('title');
	$blog_name = get_input('blog_name');
	$excerpt = get_input('excerpt');
	
	if (!$url) {
		trigger_error('Trackback warning: no url in the trackback', E_USER_WARNING);
		trackback_response(1, "no url");
	}
	
	
	
	// get user
	$user = get_user_by_username($username);
	if (!$user)
		trackback_response(1, "this url does not support trackbacks");
	
	// trackback looks good
	trackback_response();
	
	set_context('trackback');
	
	// create an object
	$object = new ElggObject;
	$object->subtype = "trackback";
	$object->owner_guid = $user->guid;
	$object->container_guid = $user->guid;
	$object->title = $title;
	$object->description = $excerpt;
	$access = ACCESS_PUBLIC;
	if ($CONFIG->allow_user_default_access) {
		$access = $user->getPrivateSetting('elgg_default_access');
		if (!$access)
			$access = ACCESS_PUBLIC;
	} 
	$object->access_id = $access;
	$object->blog_name = $blog_name;
	$object->url = $url;
	
	$object->save();

	// throw the river event
	if ($object->guid)
		add_to_river('river/object/trackback/create', 'create', $user->guid, $object->guid);
}
?>