<?php
/**
 * Elgg add comment action
 *
 * @package Elgg.Core
 * @subpackage Comments
 */
 
action_gatekeeper();

global $CONFIG;

$entity_guid = (int) get_input('entity_guid');

$_SESSION['speak_freely'] = array();
$_SESSION['speak_freely']['generic_comment'] = $comment_text = get_input('generic_comment');
$_SESSION['speak_freely']['anon_name'] = $anon_name = get_input('anon_name');

// check if recaptcha was correct - only if recaptcha is turned on
if(get_plugin_setting('recaptcha','speak_freely') == "yes" && $CONFIG->captcha != "false"){
	require_once($CONFIG->pluginspath . 'speak_freely/lib/recaptchalib.php');
	$privatekey = get_plugin_setting('private_key', 'speak_freely');
	$resp = recaptcha_check_answer ($privatekey,
	$_SERVER["REMOTE_ADDR"],
	$_POST["recaptcha_challenge_field"],
	$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
		// What happens when the CAPTCHA was entered incorrectly
		register_error(elgg_echo('speak_freely:recaptcha_fail'));
		forward(REFERRER);
	}
}


// check if comment has content, if not send them back
if (empty($comment_text)) {
	register_error(elgg_echo("generic_comment:blank"));
	forward(REFERER);
}

// check if name was entered, if not send them back
if (empty($anon_name)) {
	register_error(elgg_echo("speak_freely:name_blank"));
	forward(REFERER);
}


// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
	register_error(elgg_echo("generic_comment:notfound"));
	forward(REFERER);
}

$comment_text = $comment_text . "<br>- " . $anon_name;


// get the guid of our anonymous user
$anon_guid = (int)get_plugin_setting('anon_guid','speak_freely');

$user = get_user($anon_guid);

$annotation = create_annotation($entity->guid,
								'generic_comment',
$comment_text,
								"",
$user->guid,
$entity->access_id);


  
//    register_error("1".elgg_echo("generic_comment:failure"));

// tell user annotation posted
if (!$annotation) {
	register_error(elgg_echo("generic_comment:failure"));
	forward(REFERER);
}

/*
if(!is_plugin_enabled("moderated_comments")){
	// notify if poster wasn't owner
	if ($entity->owner_guid != $user->guid) {

		notify_user($entity->owner_guid,
		$user->guid,
		elgg_echo('generic_comment:email:subject'),
		sprintf(
		elgg_echo('speak_freely:anon_comment:email:body'),
		$entity->title,
		$comment_text,
		$entity->getURL()
		)
		);
	}
}
else{	// special notification if moderated_comments plugin is enabled
	// notify if poster wasn't owner
	// Matt B: also only do default notification if entity is unmoderated
	if ($entity->owner_guid != $user->guid && !moderated_comments_is_moderated($entity_guid)) {
			
		notify_user($entity->owner_guid,
		$user->guid,
		elgg_echo('generic_comment:email:subject'),
		sprintf(
		elgg_echo('generic_comment:email:body'),
		$entity->title,
		$user->name,
		$comment_text,
		$entity->getURL(),
		$user->name,
		$user->getURL()
		)
		);
	}

	// Matt B: if entity is moderated use custom notification
	if($entity->owner_guid != $user->guid && moderated_comments_is_moderated($entity_guid)){
		global $CONFIG;

		$approveURL = $CONFIG->url . "mod/moderated_comments/actions/annotation/review.php?id=" . $annotation . "&method=approve";
		$deleteURL = $CONFIG->url . "mod/moderated_comments/actions/annotation/review.php?id=" . $annotation . "&method=delete";

		notify_user($entity->owner_guid,
		$user->guid,
		elgg_echo('moderated_comments:email:subject'),
		sprintf(
		elgg_echo('moderated_comments:email:body'),
		$entity->title,
		$user->name,
		$comment_text,
		$entity->getURL(),
		$user->name,
		$user->getURL(),
		$approveURL,
		$deleteURL
		)
		);
	}
} */


system_message(elgg_echo("generic_comment:posted"));

//add to river
//add_to_river('river/annotation/generic_comment/create', 'comment', $user->guid, $entity->guid, "", 0, $annotation);

unset($_SESSION['speak_freely']);

// Forward to the page the action occurred on
forward(REFERER);
