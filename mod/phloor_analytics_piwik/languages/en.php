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

$english = array(
	"admin:plugins:category:PHLOOR" => "PHLOOR Plugins",

	'phloor_analytics_piwik' => "Phloor Analytics Piwik",
	'phloor_analytics_piwik:path_to_piwik:link' => 'Open Piwik',

	'admin:statistics:phloor_analytics_piwik' => 'Piwik',
	'phloor_analytics_piwik:form:section:settings' => 'Settings',

	'phloor_analytics_piwik:save:success' => 'Settings successfully saved. ',
	'phloor_analytics_piwik:save:failure' => 'Settings could not be saved. ',

	'phloor_analytics_piwik:couldnotopenpiwikjavascript' => "Could not find the file piwik.js in the specified path '%s'. ",
	'phloor_analytics_piwik:invalidsiteguid' => "Site id must be a positiv integer (insert 1 if not sure) ",

	'phloor_analytics_piwik:enable_tracking:label' => "Enable tracking? ",
	'phloor_analytics_piwik:enable_tracking:description' => "If this option is enabled Piwik starts tracking. ",

	'phloor_analytics_piwik:path_to_piwik:label' => "Path to Piwik installation ",
	'phloor_analytics_piwik:path_to_piwik:description' => "Path to the Piwik installation on a server. Please make sure that it starts with 'http://' and ends with '/'.. e.g. 'http://www.example.com/piwik/' ",

	'phloor_analytics_piwik:site_guid:label' => "Site Tracking ID",
	'phloor_analytics_piwik:site_guid:description' => "This positive integer number is needed when a user does not have javascript enabled. ",

);

add_translation("en", $english);
