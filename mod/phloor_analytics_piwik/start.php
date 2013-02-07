<?php 
/*****************************************************************************
 * Phloor Analytics Piwik                                                    *
 *                                                                           *
 * Copyright (C) 2012 Alois Leitner                                          *
 *                                                                           *
 * This program is free software: you can redistribute it and/or modify      *
 * it under the terms of the GNU General Public License as published by      *
 * the Free Software Foundation, either version 2 of the License, or         *
 * (at your option) any later version.                                       *
 *                                                                           *
 * This program is distributed in the hope that it will be useful,           *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 * GNU General Public License for more details.                              *
 *                                                                           *
 * You should have received a copy of the GNU General Public License         *
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.     *
 *                                                                           *
 * "When code and comments disagree both are probably wrong." (Norm Schryer) *
 *****************************************************************************/ 
?>
<?php

/**
 * 
 */
elgg_register_event_handler('init', 'system', 'phloor_analytics_piwik_init');

/**
 * init
 */
function phloor_analytics_piwik_init() {
	/**
	 * LIBRARY
	 * register a library of helper functions
	 */
	$lib_path = elgg_get_plugins_path() . 'phloor_analytics_piwik/lib/';
	elgg_register_library('phloor-analytics-piwik-lib', $lib_path . 'phloor_analytics_piwik.lib.php');
	elgg_load_library('phloor-analytics-piwik-lib');		
	
	$site = elgg_get_site_entity();
	$params = phloor_analytics_piwik_prepare_vars($site);
		
	/**
	 * JS
	 */
	$js_url = "{$params['path_to_piwik']}piwik.js";
	elgg_register_js('phloor-piwik-lib', $js_url, 'footer', 500);	
		
	/**
	 * Admin Menu
	 */	
	elgg_register_admin_menu_item('administer', 'phloor_analytics_piwik', 'statistics');
		
	/**
	 * Actions
	 */
	$base = elgg_get_plugins_path() . 'phloor_analytics_piwik/actions/phloor_analytics_piwik';
	elgg_register_action('phloor_analytics_piwik/save', "$base/save.php", 'admin');
			
	/**
	 * LOAD TRACKING SCRIPT
	 */
	if($params['enable_tracking'] == 'true') {				
		elgg_load_js('phloor-piwik-lib'); // load piwik script
		//elgg_extend_view('footer/analytics', 'phloor_analytics_piwik/piwik/analytics', 501);
		elgg_extend_view('page/elements/foot', 'phloor_analytics_piwik/piwik/analytics', 501);
	}
}
