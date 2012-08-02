<?php
	function language_selector_plugins_boot(){
		if(!isloggedin()){
			$new_lang_id = $_COOKIE['client_language'];
			global $CONFIG;
			if(!empty($new_lang_id)){
				$CONFIG->language = $new_lang_id; 
			} else {
				
				$browserlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
				
				if(!empty($browserlang)){
					if(get_plugin_setting("autodetect") == "yes"){
						$CONFIG->language = $browserlang;
					}
				}
			}
			reload_all_translations();
		}
	}
	
	function language_selector_init(){
		if(get_plugin_setting("show_in_header") == "yes"){
			//elgg_extend_view("page/elements/header", "language_selector/default");
		}
	}
	
	function get_allowed_translations(){
		$allowed = get_installed_translations();
		
		$min_completeness = (int)get_plugin_setting("min_completeness");
		if((int)$min_completeness > 0){		
			foreach($allowed as $lang_id => $lang_description){
	
				if($lang_id != "en"){
					if(get_language_completeness($lang_id) < $min_completeness){
						unset($allowed[$lang_id]);
					}
				}
			} 
		}		
		return $allowed;
	}
	
	// Default event handlers for plugin functionality
	register_elgg_event_handler('plugins_boot', 'system', 'language_selector_plugins_boot');
	register_elgg_event_handler('init', 'system', 'language_selector_init');
	
	// actions
	register_action('language_selector/change', false, $CONFIG->pluginspath . 'language_selector/actions/change.php');
?>
