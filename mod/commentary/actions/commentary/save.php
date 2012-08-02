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
$error_forward_url = get_input('forward', REFERER);

// start a new sticky form session in case of failure
elgg_make_sticky_form('commentary');

if(!$linked_segments){
    register_error(elgg_echo('commentary:error:nosegmentsselected'));
    forward(get_input('forward', REFERER));
}

$user = elgg_get_logged_in_user_entity();
 
// assume we are saving (editing or new), currently no delete function for commentaries
$save = (bool)get_input('save', elgg_is_admin_logged_in() ? true : false);

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
    if(is_duplicate_commentary($linked_segments, $user->guid, true)){
        //$error = elgg_echo("commentary:error:duplicate");
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
	'title' => elgg_get_excerpt(get_input("description"), 40),
	'description' => '',
	'status' => 'published',
	'access_id' => ACCESS_PUBLIC,
	'comments_on' => 'On',
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

        case 'status':
            if(($value == "featured" || $value == "dailystory")  && !elgg_is_admin_logged_in()){
                $values[$name] = "published";
            }
            $values[$name] = $value;
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
                $linked_segments = array($value);
//                $commentary->addRelationship($segment_guid, "linked_segment");
            }
        }else{
            if (FALSE === ($commentary->$name = $value)) {
                $error = elgg_echo('commentary:error:cannot_save' . "$name=$value");
                break;
            }            
        }
	}
/*    if($name == "events" || $name == "tags"){            
                if ($value) {
                    $values[$name] = string_to_tag_array_mod($value);
                } else {
                    unset ($values[$name]);
                }                 
    }*/
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

        $tags = array();
        $events = array();
        $universal_categories = array();
        $commentary->clearRelationships();
        foreach($linked_segments as $segment_guid){
            $commentary->addRelationship($segment_guid, "linked_segment");            
            $linked_segment = get_entity($segment_guid);
            if($newtags = $linked_segment->tags)
                if(is_array($newtags)){ $tags = array_merge($tags, $newtags); }else{ $tags[] = $newtags; }       
            if($newevents = $linked_segment->events)
                if(is_array($newevents)){ $events = array_merge($events, $newevents); }else{ $events[] = $newevents; }       
            if($newuniversal_categories = $linked_segment->universal_categories)
                if(is_array($newuniversal_categories)){ $universal_categories = array_merge($universal_categories, $newuniversal_categories); }else{ $universal_categories[] = $newuniversal_categories; }       
        }
        if(!empty($tags))$commentary->tags = array_unique(array_filter($tags));
        if(!empty($events))$commentary->events = array_unique(array_filter($events));
        if(!empty($universal_categories))$commentary->universal_categories = array_unique(array_filter($universal_categories));
                //register_error("boop6664!");
        
		system_message(elgg_echo('commentary:message:saved'));

		$status = $commentary->status;
		$db_prefix = elgg_get_config('dbprefix');

		// add to river if changing status or published, regardless of new post
		// because we remove it for drafts.
		if (($new_post || $old_status == 'draft') && ($status == 'published' || $status == 'featured' )){
                //register_error("boop99!");

			add_to_river('river/object/commentary/create', 'create', elgg_get_logged_in_user_guid(), $commentary->getGUID(), 2);

			if ($guid) {
				$commentary->time_created = time();
                //register_error("boop99934!");
			}
		} elseif (($old_status == 'published' || $old_status == 'featured' ) && $status == 'draft') {
                //register_error("boop999!");
			elgg_delete_river(array(
				'object_guid' => $commentary->guid,
				'action_type' => 'create',
			));
		}

        $commentary->save();
        //register_error("boop10!");
		if ($commentary->status == 'published' || $commentary->status == 'featured'  || $commentary->status == 'dailystory' || $save == false) {
			forward($commentary->getURL());
		}
	} else {
		register_error(elgg_echo('commentary:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}
