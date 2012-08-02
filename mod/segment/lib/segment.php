<?php
/**
 * segment helper functions
 *
 * @package Segment
 */

 /**
 * Get page components to view a segment post.
 *
 * @param int $guid GUID of a segment entity.
 * @return array
 */
function segment_get_page_content_read($guid = NULL) {

	$return = array();

	$segment = get_entity($guid);

	// no header or tabs for viewing an individual segment
	$return['filter'] = '';
	$return['header'] = '';

	if (!elgg_instanceof($segment, 'object', 'segment')) {
		$return['content'] = elgg_echo('segment:error:post_not_found');
		return $return;
	}

	$return['title'] = htmlspecialchars($segment->title);

	$container = $segment->getContainerEntity();
	$crumbs_title = $container->name;
	if (elgg_instanceof($container, 'group')) {
		elgg_push_breadcrumb($crumbs_title, "segment/group/$container->guid/all");
	} else {
		elgg_push_breadcrumb($crumbs_title, "segment/owner/$container->guid");
	}

	elgg_push_breadcrumb($segment->title);
	$return['content'] = elgg_view_entity($segment, array('full_view' => true));
	//check to see if comment are on
	if ($segment->comments_on != 'Off') {
		$return['content'] .= elgg_view_comments($segment);
	}

    $return['FBmeta'] = generic_FBobjectify($segment);
    
	return $return;
}

/**
 * Get page components to list a user's or all segments.
 *
 * @param int $owner_guid The GUID of the page owner or NULL for all segments
 * @return array
 */
function segment_get_page_content_list($container_guid = NULL) {

    $return = array();

    $return['filter_context'] = $container_guid ? 'mine' : 'all';

    $options = array(
        'type' => 'object',
        'subtype' => 'segment',
        'full_view' => FALSE,
    );

    $loggedin_userid = elgg_get_logged_in_user_guid();
    if ($container_guid) {
        $options['container_guid'] = $container_guid;
        //$options['container_guid'] = $container_guid;
        $container = get_entity($container_guid);
        if (!$container) {

        }
        $return['title'] = elgg_echo('segment:title:user_segments', array($container->name));

        $crumbs_title = $container->name;
        elgg_push_breadcrumb($crumbs_title);

        if ($container_guid == $loggedin_userid) {
            $return['filter_context'] = 'mine';
        } else if (elgg_instanceof($container, 'group')) {
            $return['filter'] = false;
        } else {
            // do not show button or select a tab when viewing someone else's posts
            $return['filter_context'] = 'none';
        }
    } else {
        $return['filter_context'] = 'all';
        $return['title'] = elgg_echo('segment:title:all_segments');
        elgg_pop_breadcrumb();
        elgg_push_breadcrumb(elgg_echo('segment:segments'));
    }

    elgg_register_segment_title_button($container_guid);

    // show all posts for admin or users looking at their own segments
    // show only published posts for other users.
    if (!(elgg_is_admin_logged_in() || (elgg_is_logged_in() && $container_guid == $loggedin_userid))) {
//        $options['metadata_name_value_pairs'] = array(
//            array('name' => 'status', 'value' => 'published'),
//        );
    }

/*    $list = elgg_list_entities_from_metadata($options);
    if (!$list) {
        $return['content'] = elgg_echo('segment:none');
    } else {
        $return['content'] = $list;
    }
 */
 
    $return['content'] = view_all_segments($options);

    return $return;
}

/**
 * Get page components to list a user's or all segments.
 *
 * @param int $owner_guid The GUID of the page owner or NULL for all segments
 * @return array
 */
function segment_get_page_owned_list($container_guid = NULL) {

    $return = array();

    $return['filter_context'] = $container_guid ? 'mine' : 'all';

    $options = array(
        'type' => 'object',
        'subtype' => 'segment',
        'full_view' => FALSE,
    );

    $loggedin_userid = elgg_get_logged_in_user_guid();
    if ($container_guid) {
        $options['owner_guid'] = $container_guid;
//        $options['container_guid'] = $container_guid;
        $container = get_entity($container_guid);
        if (!$container) {

        }
        $return['title'] = elgg_echo('segment:title:user_segments', array($container->name));

        $crumbs_title = $container->name;
        elgg_push_breadcrumb($crumbs_title);

        if ($container_guid == $loggedin_userid) {
            $return['filter_context'] = 'mine';
        } else if (elgg_instanceof($container, 'group')) {
            $return['filter'] = false;
        } else {
            // do not show button or select a tab when viewing someone else's posts
            $return['filter_context'] = 'none';
        }
    } else {
        $return['filter_context'] = 'all';
        $return['title'] = elgg_echo('segment:title:all_segments');
        elgg_pop_breadcrumb();
        elgg_push_breadcrumb(elgg_echo('segment:segments'));
    }

    elgg_register_segment_title_button($container_guid);

    // show all posts for admin or users looking at their own segments
    // show only published posts for other users.
    if (!(elgg_is_admin_logged_in() || (elgg_is_logged_in() && $container_guid == $loggedin_userid))) {
        $options['metadata_name_value_pairs'] = array(
            array('name' => 'status', 'value' => 'published'),
        );
    }else{
        $options['order_by_metadata'] = array('name' => 'admincommented', 'direction' => 'DESC', 'as' => 'integer');
    }

    $list = elgg_list_entities_from_metadata($options);
    if (!$list) {
        $return['content'] = elgg_echo('segment:none');
    } else {
        $return['content'] = $list;
    }

    return $return;
}

/**
 * Get page components to list a user's or all segments.
 *
 * @param int $owner_guid The GUID of the page owner or NULL for all segments
 * @return array
 */
function segment_get_page_pending_list() {
	$return = array();

    $return['filter'] = false;
	$return['filter_context'] = 'all';
	$return['title'] = elgg_echo('segment:title:draft_segments');
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo('segment:segments'));

    elgg_register_menu_item('title', array(
        'name' => "approve_all",
        'href' => "#",
        'text' => elgg_echo("segment:approveall"),
        'link_class' => 'elgg-button elgg-button-action',
        'data-multipub' => "segment.approve",
    ));
    
    $option['status'] = "draft";
	$return['content'] = view_all_segments($option);

	return $return;
}

function segment_get_page_content_edit($page, $guid = 0, $revision = NULL) {
    global $actionbuttons;

	elgg_load_js('elgg.segment');

	$return = array(
		'filter' => '',
	);

	$vars = array();
	$vars['id'] = 'segment-post-edit';
	$vars['name'] = 'segment_post';
	$vars['class'] = 'elgg-form-alt';
	if ($page == 'edit') {
		$segment = get_entity((int)$guid);

		$title = elgg_echo('segment:edit');

		if (elgg_instanceof($segment, 'object', 'segment') && $segment->canEdit()) {
			$vars['entity'] = $segment;

			$title .= ": \"$segment->title\"";

			if ($revision) {
				$revision = elgg_get_annotation_from_id((int)$revision);
				$vars['revision'] = $revision;
				$title .= ' ' . elgg_echo('segment:edit_revision_notice');

				if (!$revision || !($revision->entity_guid == $guid)) {
					$content = elgg_echo('segment:error:revision_not_found');
					$return['content'] = $content;
					$return['title'] = $title;
					return $return;
				}
			}

			$body_vars = segment_prepare_form_vars($segment, $revision);

			elgg_push_breadcrumb($segment->title, $segment->getURL());
            elgg_push_breadcrumb(elgg_echo('edit'));
			
			elgg_load_js('elgg.segment');

			$content = elgg_view_form('segment/save', $vars, $body_vars);
            $content .= elgg_view_comments($segment, false);            
            $sidebar = $actionbuttons;
        //    jQuery("input[name=save]").click(function(e){jQuery("form[name=segment_post]").submit();});
            $sidebar.='<script>jQuery(document).ready(function(){
                jQuery("input[name=save],button[name=save]").click(function(e){e.preventDefault();jQuery("form.elgg-form").submit();}); 
                    jQuery("body").bind("keypress", function(e){
                    var datarg = jQuery(e.target);
                    if(!datarg.is("textarea") && !datarg.is("select") && !datarg.is("input[name=q]")){
                    var code = (e.keyCode ? e.keyCode : e.which);
                     if(code == 13) { //Enter keycode
                        var conf = confirm("'.elgg_echo('js:ready_to_save').'");
                       if(conf)jQuery("form.elgg-form").submit();
                     }
                    }         
                });
           
            });
            </script>';

			$sidebar .= elgg_view('segment/sidebar/revisions', $vars);

            
		} else {
			$content = elgg_echo('segment:error:cannot_edit_post');
		}
	} else {
		if ($guid == 0) {
			$container = elgg_get_logged_in_user_entity();
		} else {
			$container = get_entity($guid);
		}

		elgg_push_breadcrumb(elgg_echo('segment:add'));
		$body_vars = segment_prepare_form_vars($segment);

		$title = elgg_echo('segment:add');
		$content = elgg_view_form('segment/save', $vars, $body_vars);
		
		$segment_js = elgg_get_simplecache_url('js', 'segment/save_draft');
		elgg_register_js('elgg.segment', $segment_js);

            $sidebar = $actionbuttons;
        //    jQuery("input[name=save]").click(function(e){jQuery("form[name=segment_post]").submit();});
            $sidebar.='<script>jQuery(document).ready(function(){
                jQuery("input[name=\'save\'], button[name=\'save\']").click(function(e){e.preventDefault();jQuery("form.elgg-form").submit();}); 
                    jQuery("body").bind("keypress", function(e){
    
                    var datarg = jQuery(e.target);
                    if(!datarg.is("textarea") && !datarg.is("select") && !datarg.is("input[name=q]")){
                    var code = (e.keyCode ? e.keyCode : e.which);
                     if(code == 13) { //Enter keycode
                        var conf = confirm("'.elgg_echo('js:ready_to_save').'");
                       if(conf)jQuery("form.elgg-form").submit();
                     }
                    }         
                });
           
            });
            </script>';
             
	}

	$return['title'] = $title;
	$return['content'] = $content;
    $return['sidebar'] = $sidebar;
	return $return;	
}

/**
 * Pull together segment variables for the save form
 *
 * @param ElggSegment       $post
 * @param ElggAnnotation $revision
 * @return array
 */
function segment_prepare_form_vars($post = NULL, $revision = NULL) {

	// input names => defaults
	$values = array(
		'title' => NULL,
		'description' => NULL,
		'status' => 'published',
		'access_id' => ACCESS_DEFAULT,
		'comments_on' => 'On',
		'excerpt' => NULL,
        'events' => NULL,
		'tags' => NULL,
		'container_guid' => NULL,
		'guid' => NULL,
		'draft_warning' => '',
	);

	if ($post) {
		foreach (array_keys($values) as $field) {
			if (isset($post->$field)) {
				$values[$field] = $post->$field;
			}
		}
	}

	if (elgg_is_sticky_form('segment')) {
		$sticky_values = elgg_get_sticky_values('segment');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}
	
	elgg_clear_sticky_form('segment');

	if (!$post) {
		return $values;
	}

	// load the revision annotation if requested
	if ($revision instanceof ElggAnnotation && $revision->entity_guid == $post->getGUID()) {
		$values['revision'] = $revision;
		$values['description'] = $revision->value;
	}

	// display a notice if there's an autosaved annotation
	// and we're not editing it.
	if ($auto_save_annotations = $post->getAnnotations('segment_auto_save', 1)) {
		$auto_save = $auto_save_annotations[0];
	} else {
		$auto_save == FALSE;
	}

	if ($auto_save && $auto_save->id != $revision->id) {
		$values['draft_warning'] = elgg_echo('segment:messages:warning:draft');
	}

	return $values;
}

