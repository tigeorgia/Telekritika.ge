<?php
/**
 * Save commentary entity
 *
 * @package Commentary
 */
 
$linked_segments = get_input('linked_segments');
$linked_segments = array_unique($linked_segments);
// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;

if(!$linked_segments){
    register_error(elgg_echo('commentary:error:nosegmentsselected'));
    forward(get_input('forward', REFERER));
}

$user = elgg_get_logged_in_user_entity();
 
// start a new sticky form session in case of failure
elgg_make_sticky_form('commentary');

// save or preview
$save = (bool)get_input('save');

// edit or create a new entity
$guid = get_input('guid');

if ($guid) {

	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'commentary') && elgg_is_admin_logged_in()) {
		$commentary = $entity;
	} else {
		register_error(elgg_echo('commentary:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}

	// save some data for revisions once we save the new edit
	$revision_text = $commentary->description;
	$new_post = $commentary->new_post;
} else {
    if(get_duplicate_commentaries($linked_segments, $user->guid, true)){
        $error = elgg_echo("commentary:error:duplicate");
    }

	$commentary = new ElggCommentary();
	$commentary->subtype = 'commentary';
	$new_post = TRUE;
}

// set the previous status for the hooks to update the time_created and river entries
$old_status = $commentary->status;

$implodedsegments = implode(",", $linked_segments);
// set defaults and required values.
$values = array(
	'title' => "{$user->guid}:($implodedsegments)",
	'description' => '',
	'status' => 'published',
	'access_id' => ACCESS_PUBLIC,
	'comments_on' => 'Off',
//  'tags' => '',
//	'events' => '',
    'linked_segments' => array()
);

// fail if a required entity isn't set
//$required = array('title', 'description');
$required = array('description');

// load from POST and do sanity and access checking
foreach ($values as $name => $default) {
	$value = get_input($name, $default);

	if (in_array($name, $required) && empty($value)) {
		$error = elgg_echo("commentary:error:missing:$name");
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
				unset ($values[$name]);
			}
			break;

		case 'container_guid':
			// this can't be empty or saving the base entity fails
			if (!empty($value)) {
				if (can_write_to_container($user->getGUID(), $value)) {
					$values[$name] = $value;
				} else {
					$error = elgg_echo("commentary:error:cannot_write_to_container");
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
        if ($name == "linked_segments"){            
            if(is_array($value)){
                foreach($value as $segment_guid){
                    $linked_segments[] = $segment_guid;
//                    $commentary->addRelationship($segment_guid, "linked_segment");
                }                                
            }else{
                $linked_segments = array($segment_guid);
//                $commentary->addRelationship($segment_guid, "linked_segment");
            }
        }else{
            if (FALSE === ($commentary->$name = $value)) {
                $error = elgg_echo('commentary:error:cannot_save' . "$name=$value");
                break;
            }            
        }
	}
}

// only try to save base entity if no errors
if (!$error) {
	if ($commentary->save()) {
		// remove sticky form entries
		elgg_clear_sticky_form('commentary');

		// remove autosave draft if exists
		$commentary->clearAnnotations('commentary_auto_save');

		// no longer a brand new post.
		$commentary->clearMetadata('new_post');

		// if this was an edit, create a revision annotation
		if (!$new_post && $revision_text) {
			$commentary->annotate('commentary_revision', $revision_text);
		}

        $commentary->clearRelationships();
        foreach($linked_segments as $segment_guid){
            $commentary->addRelationship($segment_guid, "linked_segment");            
        }
        
		system_message(elgg_echo('commentary:message:saved'));

		$status = $commentary->status;
		$db_prefix = elgg_get_config('dbprefix');

		// add to river if changing status or published, regardless of new post
		// because we remove it for drafts.
		if (($new_post || $old_status == 'draft') && $status == 'published') {
			add_to_river('river/object/commentary/create', 'create', elgg_get_logged_in_user_guid(), $commentary->getGUID());

			if ($guid) {
				$commentary->time_created = time();
				$commentary->save();
			}
		} elseif ($old_status == 'published' && $status == 'draft') {
			elgg_delete_river(array(
				'object_guid' => $commentary->guid,
				'action_type' => 'create',
			));
		}

		if ($commentary->status == 'published' || $save == false) {
			forward($commentary->getURL());
		} else {
			forward("commentary/edit/$commentary->guid");
		}
	} else {
		register_error(elgg_echo('commentary:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}