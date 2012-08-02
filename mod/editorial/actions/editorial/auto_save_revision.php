<?php
/**
 * Action called by AJAX periodic auto saving when editing.
 *
 * @package Blog
 */

$guid = get_input('guid');
$user = elgg_get_logged_in_user_entity();
$title = get_input('title');
$description = get_input('description');
$excerpt = get_input('excerpt');

// because get_input() doesn't use the default if the input is ''
if (empty($excerpt)) {
	$excerpt = $description;
}

// store errors to pass along
$error = FALSE;

if ($title && $description) {

	if ($guid) {
		$entity = get_entity($guid);
		if (elgg_instanceof($entity, 'object', 'editorial') && $entity->canEdit()) {
			$editorial = $entity;
		} else {
			$error = elgg_echo('editorial:error:post_not_found');
		}
	} else {
		$editorial = new ElggBlog();
		$editorial->subtype = 'editorial';

		// force draft and private for autosaves.
		$editorial->status = 'unsaved_draft';
		$editorial->access_id = ACCESS_PRIVATE;
		$editorial->title = $title;
		$editorial->description = $description;
		$editorial->excerpt = elgg_get_excerpt($excerpt);

		// mark this as a brand new post so we can work out the
		// river / revision logic in the real save action.
		$editorial->new_post = TRUE;

		if (!$editorial->save()) {
			$error = elgg_echo('editorial:error:cannot_save');
		}
	}

	// creat draft annotation
	if (!$error) {
		// annotations don't have a "time_updated" so
		// we have to delete everything or the times are wrong.

		// don't save if nothing changed
		if ($auto_save_annotations = $editorial->getAnnotations('editorial_auto_save', 1)) {
			$auto_save = $auto_save_annotations[0];
		} else {
			$auto_save == FALSE;
		}

		if (!$auto_save) {
			$annotation_id = $editorial->annotate('editorial_auto_save', $description);
		} elseif ($auto_save instanceof ElggAnnotation && $auto_save->value != $description) {
			$editorial->clearAnnotations('editorial_auto_save');
			$annotation_id = $editorial->annotate('editorial_auto_save', $description);
		} elseif ($auto_save instanceof ElggAnnotation && $auto_save->value == $description) {
			// this isn't an error because we have an up to date annotation.
			$annotation_id = $auto_save->id;
		}

		if (!$annotation_id) {
			$error = elgg_echo('editorial:error:cannot_auto_save');
		}
	}
} else {
	$error = elgg_echo('editorial:error:missing:description');
}

if ($error) {
	$json = array('success' => FALSE, 'message' => $error);
	echo json_encode($json);
} else {
	$msg = elgg_echo('editorial:message:saved');
	$json = array('success' => TRUE, 'message' => $msg, 'guid' => $editorial->getGUID());
	echo json_encode($json);
}
exit;
