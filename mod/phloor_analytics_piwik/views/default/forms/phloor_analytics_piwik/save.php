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
 * 
 */
// get site entity
$site = elgg_get_site_entity();
// prepare variables
$vars = phloor_analytics_piwik_prepare_vars($site);

$action_buttons = '';

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'name' => 'save',
));

$action_buttons = $save_button ;

// form elements setup
$forms = array(
	'settings' => array(
		'enable_tracking' => elgg_view('phloor_analytics_piwik/input/enable_tracking', array(
			'id' => 'edit-phloor-analytics-piwik-enable-tracking',
			'name' => 'phloor_analytics_piwik_enable_tracking',
			'value' => $vars['enable_tracking'],
			'class' => "form-select",
		)),
		'path_to_piwik' => elgg_view('input/text', array(
			'id' => 'edit-phloor-analytics-piwik-path-to-piwik',
			'name' => 'phloor_analytics_piwik_path_to_piwik',
			'value' => $vars['path_to_piwik'],
			'class' => "form-text",
		)),
		'site_guid' => elgg_view('input/text', array(
			'id' => 'edit-phloor-analytics-piwik-site-guid',
			'name' => 'phloor_analytics_piwik_site_guid',
			'value' => $vars['site_guid'],
		)),
	),
	
);

$content = '';
// view each section
foreach($forms as $section_name => $section) {
	// display section title
	$content .= elgg_view_title(elgg_echo('phloor_analytics_piwik:form:section:'.$section_name));
	// view each form of a section
	foreach($section as $key => $view) {
		$label = elgg_echo('phloor_analytics_piwik:'.$key.':label');
		$description = elgg_echo('phloor_analytics_piwik:'.$key.':description');
		$content .= <<<____HTML
<div class="form-item">
 <label>{$label}</label> {$view}
 <div class="description">{$description}</div>
</div>
____HTML;
	}
}

// display action buttons
$content .= <<<____HTML
<div class="elgg-foot">
	$action_buttons
</div>

____HTML;

// display content
echo $content;
