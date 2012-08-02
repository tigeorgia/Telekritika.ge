<?php
/**
 * Layout of the groups profile page
 *
 * @uses $vars['entity']
 */

echo elgg_view('channels/profile/summary', $vars);
if (group_gatekeeper(false)) {
	echo elgg_view('channels/profile/widgets', $vars);
} else {
	echo elgg_view('channels/profile/closed_membership');
}
