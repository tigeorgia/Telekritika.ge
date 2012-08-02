<?php
/* ***********************************************************************
 * @author : Purusothaman Ramanujam
 * @link http://www.iYaffle.com/
 * ***********************************************************************/

	register_elgg_event_handler('init','system','disable_more_init');

	function disable_more_init() 
	{
           elgg_unregister_plugin_hook_handler('prepare', 'menu:site', 'elgg_site_menu_setup');
	}
?>