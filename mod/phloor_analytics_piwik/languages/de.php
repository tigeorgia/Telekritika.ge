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

$german = array(
	"admin:plugins:category:PHLOOR" => "PHLOOR Plugins",

	'phloor_analytics_piwik' => "Phloor Analytics Piwik",
	'phloor_analytics_piwik:path_to_piwik:link' => 'Piwik öffnen',

	'admin:statistics:phloor_analytics_piwik' => 'Piwik',
	'phloor_analytics_piwik:form:section:settings' => 'Einstellungen',

	'phloor_analytics_piwik:save:success' => 'Einstellungen wurden erfolgreich gespeichert. ',
	'phloor_analytics_piwik:save:failure' => 'Eisntellungen konnten nicht gespeichert werden. ',

	'phloor_analytics_piwik:couldnotopenpiwikjavascript' => "Konnte die Datei piwik.js im angegebenen Pfrad '%s' nicht öffnen. ",
	'phloor_analytics_piwik:invalidsiteguid' => "Site ID muss eine positive, ganze Zahl sein (im Zweifelsfall '1') ",

	'phloor_analytics_piwik:enable_tracking:label' => "Tracking aktivieren? ",
	'phloor_analytics_piwik:enable_tracking:description' => "Diese Checkbox aktiviert das Aufzeichnen der Seitennutzung mit Piwik. ",

	'phloor_analytics_piwik:path_to_piwik:label' => "Pfad zur Piwik-Installation ",
	'phloor_analytics_piwik:path_to_piwik:description' => "Pfad zur Piwik-Installation auf Ihrem Server. Bitte vergewissern Sie sich, dass der Pfad mit 'http://' beginnt und mit '/' endet.. z.B.: 'http://www.example.com/piwik/' ",

	'phloor_analytics_piwik:site_guid:label' => "Site Tracking ID",
	'phloor_analytics_piwik:site_guid:description' => "This positive integer number is needed when a user does not have javascript enabled. ",

);

add_translation("de", $german);
