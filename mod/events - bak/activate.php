<?php
/**
 * Prompt the user to add events after activating
 */

//events_admin_notice_no_events
$site = get_config('site');
if (!$site->events) {
	$message = elgg_echo('events:on_activate_reminder', array(elgg_normalize_url('admin/plugin_settings/events')));
	elgg_add_admin_notice('events_admin_notice_no_events', $message);
}