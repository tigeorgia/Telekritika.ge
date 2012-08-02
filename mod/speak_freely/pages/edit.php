<?php

/*
 * 	This page contains the form for updating the plugin settings
 * 
 * Admin can save a new username for the fake user, upload an image to use for the profile pic,
 * and toggle recptcha off and on, and change recaptcha keys
 * 
 */


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

// only admins can see this page
admin_gatekeeper();

global $CONFIG;

//set the page title
$title  = elgg_view_title( elgg_echo('speak_freely:settings') );

//get our user object for anonymous user
$user = get_user(get_plugin_setting('anon_guid','speak_freely'));

// get the URL of our users profile pic
if($user){
$icon = $user->getIcon();
}

$user_guid = $user->guid;

// Current setting for recaptcha - "yes" or "no" - whether to use recaptcha or not
$recaptcha = get_plugin_setting('recaptcha','speak_freely');

// Current setting for recaptcha style - white/red/blackglass/clean - or nothing - defaults to red
$recaptcha_style = get_plugin_setting('recaptcha_style','speak_freely');

// Current public key
$public_key = get_plugin_setting('public_key', 'speak_freely');

// Current private key
$private_key = get_plugin_setting('private_key', 'speak_freely');

// start form
$form = "<div style=\"margin: 15px;\">";
// username text input
$form .= "<label>" . elgg_echo("speak_freely:name_description") . "</label>";
$form .= elgg_view('input/text', array('internalname' => 'name', 'value' => $user->name, 'disabled'=>$disabled));
$form .= "<br><br>";

//display current profile pic
$form .= "<label>" . elgg_echo("speak_freely:current_icon") . "</label><br>";
$form .= "<img src=\"$icon\" style=\"margin: 10px;\"><br>";

// file upload form for new profile pic
$form .= "<label>" . elgg_echo("speak_freely:change_icon") . "</label>";
$form .= elgg_view('input/file', array('internalname' => 'upload')) . "<br><br>";

// radio buttons - use recaptcha yes/no
$form .= "<label>" . elgg_echo("speak_freely:use_recaptcha") . "</label><br>";
$form .= "<input type=\"radio\" name=\"recaptcha\" value=\"yes\"";
if($recaptcha == "yes"){ $form .= " checked"; }
$form .= ">";
$form .= "<label>" . elgg_echo("speak_freely:yes") . "</label><br>";
$form .= "<input type=\"radio\" name=\"recaptcha\" value=\"no\"";
if($recaptcha == "no"){ $form .= " checked"; }
$form .= ">";
$form .= "<label>" . elgg_echo("speak_freely:no") . "</label><br>";
$form .= "<br><br>";

//radio buttons for recaptcha style
$form .= "<label>" . elgg_echo("speak_freely:recaptcha_style") . "</label><br>";
$form .= "<input type=\"radio\" name=\"recaptcha_style\" value=\"white\"";
if($recaptcha_style == "white"){ $form .= " checked"; }
$form .= ">";
$form .= "<label>" . elgg_echo("speak_freely:white") . "</label><br>";
$form .= "<input type=\"radio\" name=\"recaptcha_style\" value=\"red\"";
if($recaptcha_style == "red"){ $form .= " checked"; }
$form .= ">";
$form .= "<label>" . elgg_echo("speak_freely:red") . "</label><br>";
$form .= "<input type=\"radio\" name=\"recaptcha_style\" value=\"blackglass\"";
if($recaptcha_style == "blackglass"){ $form .= " checked"; }
$form .= ">";
$form .= "<label>" . elgg_echo("speak_freely:blackglass") . "</label><br>";
$form .= "<input type=\"radio\" name=\"recaptcha_style\" value=\"clean\"";
if($recaptcha_style == "clean"){ $form .= " checked"; }
$form .= ">";
$form .= "<label>" . elgg_echo("speak_freely:clean") . "</label><br>";
$form .= "<br><br>";

// text inputs for public and private keys for recaptcha
$form .= "<div>" . elgg_echo('speak_freely:recaptcha_key_instruction');
$form .= "<br><a href=\"https://www.google.com/recaptcha/admin/create\">https://www.google.com/recaptcha/admin/create</a>";
$form .= "</div>";
$form .= "<label>" . elgg_echo("speak_freely:public_key") . "</label>";
$form .= elgg_view('input/text', array('internalname' => 'public_key', 'value' => $public_key, 'disabled'=>$disabled));
$form .= "<br><br>";

$form .= "<label>" . elgg_echo("speak_freely:private_key") . "</label>";
$form .= elgg_view('input/text', array('internalname' => 'private_key', 'value' => $private_key, 'disabled'=>$disabled));
$form .= "<br><br>";


// submit button
$form .= elgg_view('input/submit', array('value' => elgg_echo("speak_freely:submit")));
$form .= "</div>";

// parameters for form generation - enctype must be 'multipart/form-data' for file uploads 
$form_vars = array();
$form_vars['body'] = $form;
$form_vars['name'] = 'update_speak_freely_settings';
$form_vars['enctype'] = 'multipart/form-data';
$form_vars['action'] = $CONFIG->url . 'mod/speak_freely/actions/speak_freely_settings.php';

// create the form
$area =  elgg_view('input/form', $form_vars);

// place the form into the elgg layout
$body = elgg_view_layout('two_column_left_sidebar', '', $title.$area);

// display the page
page_draw($title, $body);
?>
