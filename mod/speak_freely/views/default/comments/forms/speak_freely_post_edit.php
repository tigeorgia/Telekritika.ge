<?php

/**
 *
 * Presents a comment form to a non-logged in person
 */
	// there is some bug with the extended view where this will be called multiple times
	// use a token counter to make sure that form is only displayed the first time

if (isset($vars['entity']) && !elgg_is_logged_in() && $vars['show_add_form'] !== false) {
	
	if($speakfreelyformcounter != 1){  //first time, create the form..
		$speakfreelyformcounter = 1; // now this variable is set, so the form shouldn't replicate
		
//		require_once($CONFIG->pluginspath . 'speak_freely/lib/recaptchalib.php');
//		$publickey = get_plugin_setting('public_key', 'speak_freely'); // you got this from the signup page

//		$form_body = "<div class=\"contentWrapper\">";
//		$form_body .= "<div>";
        $form_body .= elgg_view('input/text', array('placeholder' => elgg_echo('comments:yourname'), 'name' => 'anon_name', 'value' => $_SESSION['speak_freely']['anon_name'], 'id' => 'speak_freely_name_field'));
		$form_body .= elgg_view('input/hidden', array('name' => 'entity_guid', 'value' => $vars['entity']->getGUID()));

        $form_body .= elgg_view('input/submit', 
            array(
                    'value' => elgg_echo("generic_comments:post"),
                    'data-prejs' => prep_pipe_string(array("grabcaptcha")),
                    'data-postjs' => prep_pipe_string(array("gotocaptcha", "refreshcaptcha")),
                    'data-pub' => prep_pipe_string("{$vars['entity']->getSubType()}.postcomment.{$vars['entity']->guid}")
                )            
            );
        $form_body .= elgg_view('input/longtextnomce',array('placeholder' => elgg_echo('comments:yourcomment'), 'name' => 'generic_comment', 'value' => $_SESSION['speak_freely']['generic_comment']));

/*        // if we have set recaptcha then display the output
        if(get_plugin_setting('recaptcha','speak_freely') == "yes" && !$_SESSION['alreadydone']){
            $recaptcha_style = get_plugin_setting('recaptcha_style','speak_freely');
            if(empty($recaptcha_style)){
                $recaptcha_style = "red"; // set default    
            } 
 
            $form_body .= "<script type=\"text/javascript\">";
            $form_body .= "var RecaptchaOptions = {";
            $form_body .= "theme : '$recaptcha_style'";
            $form_body .= "};";
            $form_body .= "</script>"; 
            
            $form_body .= recaptcha_get_html($publickey);
            $_SESSION['alreadydone'] = true;
        }
*/                       
//        $form_body .= "</div>";

		// output the form
		echo elgg_view('input/form', 
            array(
                'body' => $form_body,
                'action' => "{$vars['url']}action/comments/anon_add",
                'class' => "elgg-form-comments-add elgg-form-comments-anonadd",
            )
        );
//		unset($_SESSION['speak_freely']);
//	}
    }
}