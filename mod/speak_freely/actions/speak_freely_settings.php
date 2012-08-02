<?php

/**
 * 
 * This script saves the settings of the plugin
 */
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

// only allow admins to post
admin_gatekeeper();

global $CONFIG;

// get the ID of our anonymous user
$user_guid = get_plugin_setting('anon_guid','speak_freely');

// get the full user info
$user = get_user($user_guid);

// the new name of our user
$name = get_input('name');

//quick sanity check - name cannot be empty, if it is send them back to the form
if(empty($name)){
	register_error('speak_freely:empty_name');
	forward($CONFIG->wwwroot . "speak_freely/edit.php");
}

if($user){
	// we have a valid user, save the name
	$user->name = $name;
	$user->save();

	//create new images for anon-user
	if(is_uploaded_file($_FILES['upload']['tmp_name'])){
		$icon = array();
		$icon['topbar'] = get_resized_image_from_uploaded_file('upload',16,16, true,true);
		$icon['tiny'] = get_resized_image_from_uploaded_file('upload',25,25, true,true);;
		$icon['small'] = get_resized_image_from_uploaded_file('upload',40,40, true,true);
		$icon['medium'] = get_resized_image_from_uploaded_file('upload',100,100, true,true);
		$icon['large'] = get_resized_image_from_uploaded_file('upload',200,200, true,true);
		$icon['master'] = get_resized_image_from_uploaded_file('upload',550,550, true,true);

		$filehandler = new ElggFile();
		$filehandler->owner_guid = $user_guid;
		$filehandler->setFilename("profile/" . $user_guid . "large.jpg");
		$filehandler->open("write");
		$filehandler->write($icon['large']);
		$filehandler->close();
		$filehandler->setFilename("profile/" . $user_guid . "medium.jpg");
		$filehandler->open("write");
		$filehandler->write($icon['medium']);
		$filehandler->close();
		$filehandler->setFilename("profile/" . $user_guid . "small.jpg");
		$filehandler->open("write");
		$filehandler->write($icon['small']);
		$filehandler->close();
		$filehandler->setFilename("profile/" . $user_guid . "tiny.jpg");
		$filehandler->open("write");
		$filehandler->write($icon['tiny']);
		$filehandler->close();
		$filehandler->setFilename("profile/" . $user_guid . "topbar.jpg");
		$filehandler->open("write");
		$filehandler->write($icon['topbar']);
		$filehandler->close();
		$filehandler->setFilename("profile/" . $user_guid . "master.jpg");
		$filehandler->open("write");
		$filehandler->write($icon['master']);
		$filehandler->close();

		$user->icontime = time();

			system_message(elgg_echo("speak_freely:avatar:success"));

	}
	
	//save whether or not to use recaptcha
	$recaptcha = get_input('recaptcha');
	set_plugin_setting('recaptcha', $recaptcha, 'speak_freely');
	
	//save recaptcha style
	$recaptcha_style = get_input('recaptcha_style');
	set_plugin_setting('recaptcha_style', $recaptcha_style, 'speak_freely');
	
	//save public key
	$public_key = get_input('public_key');
	set_plugin_setting('public_key', $public_key, 'speak_freely');
	
	//save private key
	$private_key = get_input('private_key');
	set_plugin_setting('private_key', $private_key, 'speak_freely');

	system_message(elgg_echo('speak_freely:settings_saved'));
}
else{
	register_error(elgg_echo('speak_freely:no_user'));
}

forward($CONFIG->wwwroot . "pg/speak_freely/edit.php");
?>