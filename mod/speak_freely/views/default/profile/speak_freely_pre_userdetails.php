<?php

/**
This view gets called before the default profile/details view
It checks to see if we are looking at the anonymous user profile
If we are looking at the profile and are not an admin, it registers an error and
sends them back to the page they came from.
 */
global $CONFIG;

$anon_guid = get_plugin_setting('anon_guid','speak_freely');
$user = get_user($anon_guid);

// 1.8 changed things, no $vars['entity'] anymore so we're parsing the URL
//if they're not admin and trying view anon_user, register error and send them away
if (strpos($_SERVER['REQUEST_URI'], "profile/$user->username") && !isadminloggedin()){
	register_error(elgg_echo('speak_freely:profile_view'));
	forward(REFERRER);
}


// they are admin and viewing anon_user - show warning about deletion
if (isadminloggedin() && $speakfreelywarningcount != 1 && strpos($_SERVER['REQUEST_URI'], "profile/$user->name")){
	//counter to prevent more than one display of this view - have to track down that bug
	$speakfreelywarningcount = 1;
?>
<div class="speak_freely_warning">
<?php echo elgg_echo('speak_freely:profile:warning'); ?>
</div>
<?php
}