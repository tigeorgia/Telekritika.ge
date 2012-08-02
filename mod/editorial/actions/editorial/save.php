<?php
/**
 * Save editorial entity
 *
 * @package Blog
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('editorial');

// save or preview
$save = (bool)get_input('save');

// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();

// edit or create a new entity
$guid = get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'editorial') && $entity->canEdit()) {
		$editorial = $entity;
	} else {
		register_error(elgg_echo('editorial:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}

	// save some data for revisions once we save the new edit
	$revision_text = $editorial->description;
	$new_post = $editorial->new_post;
} else {
	$editorial = new ElggBlog();
	$editorial->subtype = 'editorial';
	$new_post = TRUE;
}

// set the previous status for the hooks to update the time_created and river entries
$old_status = $editorial->status;

// set defaults and required values.
$values = array(
	'title' => '',
	'description' => '',
	'status' => 'draft',
	'access_id' => ACCESS_DEFAULT,
	'comments_on' => 'On',
	'excerpt' => '',
	'tags' => '',
	'container_guid' => (int)get_input('container_guid'),
);

// fail if a required entity isn't set
$required = array('title', 'description');

// load from POST and do sanity and access checking
foreach ($values as $name => $default) {
	$value = get_input($name, $default);

	if (in_array($name, $required) && empty($value)) {
		$error = elgg_echo("editorial:error:missing:$name");
	}

	if ($error) {
		break;
	}

	switch ($name) {
		case 'tags':
			if ($value) {
				$values[$name] = string_to_tag_array($value);
			} else {
				unset ($values[$name]);
			}
			break;

		case 'excerpt':
			if ($value) {
				$value = elgg_get_excerpt($value);
			} else {
				$value = elgg_get_excerpt($values['description']);
			}
			$values[$name] = $value;
			break;

		case 'container_guid':
			// this can't be empty or saving the base entity fails
			if (!empty($value)) {
				if (can_write_to_container($user->getGUID(), $value)) {
					$values[$name] = $value;
				} else {
					$error = elgg_echo("editorial:error:cannot_write_to_container");
				}
			} else {
				unset($values[$name]);
			}
			break;

		// don't try to set the guid
		case 'guid':
			unset($values['guid']);
			break;

		default:
			$values[$name] = $value;
			break;
	}
}

// if preview, force status to be draft
if ($save == false) {
	$values['status'] = 'draft';
}

// assign values to the entity, stopping on error.
if (!$error) {
	foreach ($values as $name => $value) {
		if (FALSE === ($editorial->$name = $value)) {
			$error = elgg_echo('editorial:error:cannot_save' . "$name=$value");
			break;
		}
	}
}

// only try to save base entity if no errors
if (!$error) {
	if ($editorial->save()) {
		// remove sticky form entries
		elgg_clear_sticky_form('editorial');

		// remove autosave draft if exists
		$editorial->clearAnnotations('editorial_auto_save');

		// no longer a brand new post.
		$editorial->clearMetadata('new_post');

		// if this was an edit, create a revision annotation
		if (!$new_post && $revision_text) {
			$editorial->annotate('editorial_revision', $revision_text);
		}

		system_message(elgg_echo('editorial:message:saved'));

		$status = $editorial->status;
		$db_prefix = elgg_get_config('dbprefix');

		// add to river if changing status or published, regardless of new post
		// because we remove it for drafts.
		if (($new_post || $old_status == 'draft') && $status == 'published') {
			add_to_river('river/object/editorial/create', 'create', elgg_get_logged_in_user_guid(), $editorial->getGUID());

			if ($guid) {
				$editorial->time_created = time();
				$editorial->save();
			}
		} elseif ($old_status == 'published' && $status == 'draft') {
			elgg_delete_river(array(
				'object_guid' => $editorial->guid,
				'action_type' => 'create',
			));
		}

		if ($editorial->status == 'published' || $save == false) {
			forward($editorial->getURL());
		} else {
			forward("editorial/edit/$editorial->guid");
		}
	} else {
		register_error(elgg_echo('editorial:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}