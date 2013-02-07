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
// restrict to admin
admin_gatekeeper();
// get site entity
$site = elgg_get_site_entity();

// load vars from post requests 
$params = phloor_analytics_piwik_get_input_vars();
// save vars and show succes message
if(phloor_analytics_piwik_save_vars($site, $params)) {
	system_message(elgg_echo('phloor_analytics_piwik:save:success'));
}
// .. or view error message on failure
else {
	register_error(elgg_echo('phloor_analytics_piwik:save:failure'));
}

// forward back
forward($_SERVER['HTTP_REFERER']);

