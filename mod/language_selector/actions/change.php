<?php 
	gatekeeper();
	$new_lang_id = get_input("lang_id");
	$installed = get_installed_translations();
	if($new_lang_id && array_key_exists($new_lang_id, $installed)){
		if($user = get_loggedin_user()){
			
			$user->language = $new_lang_id;
			$user->save();
			
			// let other plugins know we updated the language
			trigger_elgg_event("update", "language", $user);
		}	
	}
	forward($_SERVER['HTTP_REFERER']);
	
?>