<?php
/**
 * Save article entity
 *
 * @package Article
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('article');

// save or preview
$save = (bool)get_input('save');
$preview = (bool)get_input('preview');
 //system_message("save".$save);
// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();

// edit or create a new entity
$guid = get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'article') && $entity->canEdit()) {
		$article = $entity;
	} else {
		register_error(elgg_echo('article:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}

	// save some data for revisions once we save the new edit
	$revision_text = $article->description;
	$new_post = $article->new_post;
} else {
	$article = new ElggArticle();
	$article->subtype = 'article';
	$new_post = TRUE;
}

// set the previous status for the hooks to update the time_created and river entries
$old_status = $article->status;

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
		$error = elgg_echo("article:error:missing:$name");
	}

	if ($error) {
		break;
	}

	switch ($name) {
        case 'events':
		case 'tags':
			if ($value) {
				$values[$name] = string_to_tag_array_mod($value);
			} else {
                $values[$name] = array("");
                //				unset ($values[$name]);
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
					$error = elgg_echo("article:error:cannot_write_to_container");
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
 //system_message("status".$values['status']);

// if preview, force status to be draft
if ($preview == true) {
	$values['status'] = 'draft';
}

// assign values to the entity, stopping on error.
if (!$error) {
	foreach ($values as $name => $value) {
		if (FALSE === ($article->$name = $value)) {
			$error = elgg_echo('article:error:cannot_save' . "$name=$value");
			break;
		}
	}
}
 //system_message("status2".$article->status);

// only try to save base entity if no errors
if (!$error) {
	if ($article->save()) {
		// remove sticky form entries
		elgg_clear_sticky_form('article');

		// remove autosave draft if exists
		$article->clearAnnotations('article_auto_save');

		// no longer a brand new post.
		$article->clearMetadata('new_post');

		// if this was an edit, create a revision annotation
		if (!$new_post && $revision_text) {
			$article->annotate('article_revision', $revision_text);
		}

		system_message(elgg_echo('article:message:saved'));

		$status = $article->status;
		$db_prefix = elgg_get_config('dbprefix');

		// add to river if changing status or published, regardless of new post
		// because we remove it for drafts.
		if (($new_post || $old_status == 'draft') && $status == 'published') {
			add_to_river('river/object/article/create', 'create', elgg_get_logged_in_user_guid(), $article->getGUID());

			if ($guid) {
				$article->time_created = time();
				$article->save();
			}
		} elseif ($old_status == 'published' && $status == 'draft') {
			elgg_delete_river(array(
				'object_guid' => $article->guid,
				'action_type' => 'create',
			));
		}

		if ($article->status == 'published' || $save == false) {
			forward($article->getURL());
		} else {
			forward("article/edit/$article->guid");
		}
	} else {
		register_error(elgg_echo('article:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}