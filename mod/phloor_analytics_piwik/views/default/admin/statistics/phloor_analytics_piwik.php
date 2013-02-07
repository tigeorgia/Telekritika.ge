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

// only admins are allowed to see the page
admin_gatekeeper();

// get site entity
$site = elgg_get_site_entity();
// prepare vars
$params = phloor_analytics_piwik_prepare_vars($site);

$content = '';
// show a link to piwik if tracking is enabled
if($params['enable_tracking'] == 'true') {
	$piwik_link = elgg_view('output/url', array(
		'href' => $params['path_to_piwik'],
		'text' => elgg_echo('phloor_analytics_piwik:path_to_piwik:link'),
		'target' => '_blank',
	));
	$title = elgg_view_title($piwik_link);
	
	$content .= <<<HTML
	<div style="width:100%; padding:10px 0 10px 0; float:left; clear:both;">
		{$title}
	</div>
HTML;
}

// get the edit form
$form = elgg_view_form('phloor_analytics_piwik/save', array());

// SETTINGS
$content .= <<<HTML
	<div id="phloor-analytics-piwik-form" style="width:100%; padding:10px 0 10px 0; float:left; clear:both;">
		{$form}
	</div>
HTML;

// display content
echo $content;

