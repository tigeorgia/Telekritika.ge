<?php 
/*****************************************************************************
 * Phloor Analytics Piwik                                                    *
 *                                                                           *
 * Copyright (C) 2011 Alois Leitner                                          *
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
 * Default attributes
 * 
 * @return array with default values
 */
function phloor_analytics_piwik_default_vars() {
	$defaults = array(
		'enable_tracking' => 'false',
		'path_to_piwik'   => elgg_get_site_url(),
		'site_guid'       => 1, // NOT THE ELGG SITE GUID!
	);
	
	return $defaults;
}

/**
 * Load vars from post or get requests and returns them as array
 * 
 * @return array with values from the request
 */
function phloor_analytics_piwik_get_input_vars() {
	$input_var_prefix = 'phloor_analytics_piwik_';
	
	// get default values
	$defaults = phloor_analytics_piwik_default_vars();
	
	$params = array();
	foreach($defaults as $key => $default_value) {
		$var_name = $input_var_prefix . $key;
		$params[$key] = get_input($var_name, $default_value);
	}
	
	return $params;
}

/**
 * Load vars from given site into and returns them as array
 * 
 * @return array with stored values
 */
function phloor_analytics_piwik_prepare_vars(ElggSite $site) {
	// get default values
	$defaults = phloor_analytics_piwik_default_vars();

	$params = array();
	// decode settings if existing
	if(isset($site->phloor_analytics_piwik_settings)) {
		$params = json_decode($site->phloor_analytics_piwik_settings, true);
	}
	// merge default with given params
	$vars = array_merge($defaults,  $params);
	
	return $vars;
}

/**
 * Load vars from given site into and returns them as array
 * 
 * @return array with stored values
 */
function phloor_analytics_piwik_save_vars($site, $params = array()) {
	// get default values
	$defaults = phloor_analytics_piwik_default_vars();
	// merge with params	
	$vars = array_merge($defaults, $params);
	
	if(!phloor_analytics_piwik_check_vars($vars)) {
		return false;
	}
	// store as an  json encoded attribute of the site entity
	$site->phloor_analytics_piwik_settings = json_encode($vars);
	// save site and return status
	return $site->save();
}

/**
 * 
 * @param unknown_type $params
 */
function phloor_analytics_piwik_check_vars(&$params) {
    // if 'path_to_piwik' doesnt start with 'http://' ...
	if(!(strpos($params['path_to_piwik'], 'http://') === 0)) {
		$params['path_to_piwik'] = 'http://' . $params['path_to_piwik']; // ..add it
	}
	// or does not end with '/'...
	if(!(strpos(strrev($params['path_to_piwik']), '/') === 0)) {
		$params['path_to_piwik'] .= '/'; // ..add it
	}
	
	// try opening the specified file
	$handle = fopen("{$params['path_to_piwik']}piwik.js", "r");
	if (!$handle) {
		register_error(elgg_echo('phloor_analytics_piwik:couldnotopenpiwikjavascript', 
			array($params['path_to_piwik'])
		));
		return false;
	} else {
		fclose($handle);
	}
	
	if(!is_numeric($params['site_guid']) || $params['site_guid'] < 1) {
		register_error(elgg_echo('phloor_analytics_piwik:invalidsiteguid'));
		return false;
	}
	
	return true;
}

