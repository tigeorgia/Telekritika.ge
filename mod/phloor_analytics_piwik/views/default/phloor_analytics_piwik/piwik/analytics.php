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

// get site entity
$site = elgg_get_site_entity();

// prepare variables
$params = phloor_analytics_piwik_prepare_vars($site);
$params['piwik_php'] = $params['path_to_piwik'] . 'piwik.php';

$content = '';

// only show if piwik is enabled
if($params['enable_tracking'] == "true") {
	$content = <<<HTML
<!-- Piwik --> 
<script type="text/javascript">
	try {
		var piwikTracker = Piwik.getTracker("{$params['piwik_php']}", {$params['site_guid']});
		piwikTracker.trackPageView();
		piwikTracker.enableLinkTracking();
	} catch( err ) {}
</script>
<noscript>
 <!-- <p><img src="{$params['piwik_php']}?idsite={$params['site_guid']}" style="border:0" alt="" /></p> -->
</noscript>
<!-- End Piwik Tracking Code -->
HTML;
}

// display content
echo $content;