<?php
/*
 *  This function will check to see if there is a user already created by the plugin (possibly from a 
 *  previous installation).  If so, it will get the ID of that user and save it for the plugin to use.
 *  If there is no user created already, it will create a fake user and save the ID for the plugin.
 *  A piece of metadata ($user->speak_freely = true) is set to differentiate just in case someone decided
 *  to take our username.
 */
function set_anonymous_user(){
	global $CONFIG;

	//start out with no user
	$anon_guid = 0;

	//first see if a user has been created previously
	$users = elgg_get_entities_from_metadata(array('name' => 'speak_freely', 'value' => TRUE, 'types' => 'user'));
	
	if(count($users) == 0 || !$users || !($user instanceof ElggUser)){ //no previous user - create a new one
		//find available username
		$i = 1;
		$username = "speak_freely_user1";
		$basename = "speak_freely_user";
		while(get_user_by_username($username)){
			$i++;
			$username = $basename.$i;
		}
		
				//let's make a user
				$user = new ElggUser();
				$user->username = $username;
				$user->email = "speak_freely_user".$i . "@example.com";
				$user->name = elgg_echo('speak_freely:display_name');
				$user->access_id = 2;
				$user->salt = substr(md5(time()), 0, 5); // Note salt generated before password!
				$user->password = md5(substr(md5(microtime()), 0, 8));
				$user->owner_guid = 0; // Users aren't owned by anyone, even if they are admin created.
				$user->container_guid = 0; // Users aren't contained by anyone, even if they are admin created.
				$user->save();

				// save the user ID
				$anon_guid = $user->guid;
				
				// set the plugin-identifiable metadata
				$user->speak_freely = TRUE;	
	}
	else{ // we found our user through metadata
		$anon_guid = $users[0]->guid;
	}
	
	return $anon_guid;
}


// called by menu:user_hover plugin hook
// $params['entity'] is the user
// $params['name'] is the menu name = "user_hover"
// $return is an array of items that are already registered to the menu
function speak_freely_hover_menu($hook, $type, $return, $params) {
	global $CONFIG;
	$user = $params['entity'];
	
	$anon_guid = get_plugin_setting('anon_guid', 'speak_freely');
	
	if($user->guid == $anon_guid){
		unset($return);
		
		return array();	
	}
}