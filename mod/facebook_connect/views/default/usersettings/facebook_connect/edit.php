<?php
/**
 * 
*/

$user_id = elgg_get_logged_in_user_guid();
$facebook_id = elgg_get_plugin_user_setting('uid', $user_id, 'facebook_connect');
$access_token = elgg_get_plugin_user_setting('access_token', $user_id, 'facebook_connect');

$site_name = elgg_get_site_entity()->name;
echo '<div>' . elgg_echo('facebook_connect:usersettings:description', array($site_name)) . '</div>';

if (!$facebook_id || !$access_token) 
{
	// send user off to validate account
	$callback = elgg_get_site_url() . 'facebook_connect/authorize' ;
	$request_link = facebook_connect_get_authorize_url($callback);
	echo '<div>' . elgg_echo('facebook_connect:usersettings:request', array($request_link, $site_name)) . '</div>';
} 
else 
{
	elgg_load_library('facebook');

	$facebook = facebookservice_api();
	$user = $facebook->api('/me', 'GET', array('access_token' => $access_token));
	echo '<p>' . sprintf(elgg_echo('facebook_connect:usersettings:authorized'), $user['name'], $user['link']) . '</p>';

	$url = elgg_get_site_url() . "facebook_connect/revoke";
	echo '<div>' . sprintf(elgg_echo('facebook_connect:usersettings:revoke'), $url) . '</div>';
}
