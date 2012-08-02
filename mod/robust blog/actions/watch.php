<?php
	
	$owner_guid = (int) get_input('owner_guid');
	$my_guid = $_SESSION['user']->guid;
	$owner= get_entity($owner_guid);
	$already_watching = check_entity_relationship($my_guid, 'blogwatcher', $owner_guid);
	if($already_watching != FALSE){
		remove_entity_relationship($my_guid, 'blogwatcher', $owner_guid);
		system_message(elgg_echo('blog:watch:delete:success') . ' ' . $owner->name);
	}else{
		add_entity_relationship($my_guid, 'blogwatcher', $owner_guid);
		system_message(elgg_echo('blog:watch:add:success') . ' ' . $owner->name);
	}
	forward($_SERVER['HTTP_REFERER']);
?>