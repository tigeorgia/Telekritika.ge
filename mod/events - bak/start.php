<?php
/**
 * Elgg events plugin
 *
 * @package ElggEvents
 */

elgg_register_event_handler('init', 'system', 'events_init');

/**
 * Initialise events plugin
 *
 */
function events_init() {

	elgg_extend_view('css/elgg', 'events/css');

	elgg_register_page_handler('events', 'events_page_handler');

	elgg_register_event_handler('update', 'all', 'events_save');
	elgg_register_event_handler('create', 'all', 'events_save');

	// To keep the event plugins in the settings area and because we have to do special stuff,
	// handle saving ourself.
	elgg_register_plugin_hook_handler('action', 'plugins/settings/save', 'events_save_site_events');
}

/**
 * Page handler
 *
 */
function events_page_handler() {
	include(dirname(__FILE__) . "/listing.php");
	return TRUE;
}

/**
 * Save events to object upon save / edit
 *
 */
function events_save($event, $object_type, $object) {
	if ($object instanceof ElggEntity) {
		$marker = get_input('universal_event_marker');

		if ($marker == 'on') {
			$events = get_input('universal_events_list');

			if (empty($events)) {
				$events = array();
			}

			$object->universal_events = $events;
		}
	}
	return TRUE;
}

/**
 * Saves the site events.
 *
 * @param type $hook
 * @param type $type
 * @param type $value
 * @param type $params
 */
function events_save_site_events($hook, $type, $value, $params) {
	$plugin_id = get_input('plugin_id');
	if ($plugin_id != 'events') {
		return $value;
	}

	$events = get_input('events');
	$events = string_to_tag_array_mod($events);

	$site = elgg_get_site_entity();
	$site->events = $events;
	system_message(elgg_echo("events:save:success"));

	elgg_delete_admin_notice('events_admin_notice_no_events');

	forward(REFERER);
}


