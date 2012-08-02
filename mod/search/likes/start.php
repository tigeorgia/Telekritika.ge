<?php
/**
 * Likes plugin
 *
 */

elgg_register_event_handler('init', 'system', 'likes_init');

function likes_init() {

    elgg_extend_view('css/elgg', 'likes/css');
    elgg_extend_view('js/elgg', 'likes/js');
	elgg_extend_view('css/elgg', 'dislikes/css');
	elgg_extend_view('js/elgg', 'dislikes/js');

	// registered with priority < 500 so other plugins can remove likes
	elgg_register_plugin_hook_handler('register', 'menu:river', 'likes_river_menu_setup', 400);
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'likes_entity_menu_setup', 400);

    $actions_base = elgg_get_plugins_path() . 'likes/actions/likes';
    elgg_register_action('likes/add', "$actions_base/add.php");
    elgg_register_action('likes/delete', "$actions_base/delete.php");
    elgg_register_action('likes/addlikecomment', "$actions_base/addlikecomment.php");
    elgg_register_action('likes/deletelikecomment', "$actions_base/deletelikecomment.php");

	$actions_base = elgg_get_plugins_path() . 'likes/actions/dislikes';
    elgg_register_action('dislikes/add', "$actions_base/add.php");
    elgg_register_action('dislikes/delete', "$actions_base/delete.php");
    elgg_register_action('dislikes/adddislikecomment', "$actions_base/adddislikecomment.php");
	elgg_register_action('dislikes/deletedislikecomment', "$actions_base/deletedislikecomment.php");
}

/**
 * Add likes to entity menu at end of the menu
 */
function likes_entity_menu_setup($hook, $type, $return, $params) {
    if (elgg_in_context('widgets')) {
		return $return;
	}
        $entity = $params['entity'];

    if(elgg_is_logged_in() && !(isMonitor() || elgg_is_admin_logged_in())){
        // dislikes button
        $options = array(
            'name' => 'dislikes',
            'text' => elgg_view("dislikes/button", array('entity' => $entity)),
            'priority' => 1001,
        );
        $return[] = ElggMenuItem::factory($options);        

        // likes button
        $options = array(
            'name' => 'likes',
            'text' => elgg_view("likes/button", array('entity' => $entity)),
            'priority' => 1003,
        );
        $return[] = ElggMenuItem::factory($options);        
    }
    if(!elgg_is_logged_in()){
        // dislikes button
        $options = array(
            'name' => 'dislikes_login',
            'text' => elgg_view("dislikes/button_login"),
            'priority' => 1001,
        );
        $return[] = ElggMenuItem::factory($options);        

        // likes button
        $options = array(
            'name' => 'likes_login',
            'text' => elgg_view("likes/button_login"),
            'priority' => 1003,
        );
        $return[] = ElggMenuItem::factory($options);                
    }
    
    // dislikes count    
    $count = elgg_view("dislikes/count", array('entity' => $entity));
    if ($count) {
        $options = array(
            'name' => 'dislikes_count',
            'text' => $count,
            'priority' => 1002,
            'href' => false
        );
        $return[] = ElggMenuItem::factory($options);
    }

	// likes count
	$count = elgg_view("likes/count", array('entity' => $entity));
	if ($count) {
		$options = array(
			'name' => 'likes_count',
			'text' => $count,
			'priority' => 1004,
            'href' => false
		);
		$return[] = ElggMenuItem::factory($options);
	}
    
	return $return;
}

/**
 * Add a like button to river actions
 */
function likes_river_menu_setup($hook, $type, $return, $params) {
	if (elgg_is_logged_in()) {
		$item = $params['item'];
		$object = $item->getObjectEntity();
        if (!elgg_in_context('widgets') && $item->annotation_id == 0) {
            if ($object->canAnnotate(0, 'dislikes')) {
                if(!(isMonitor() || elgg_is_admin_logged_in())){
                    // dislike button
                    $options = array(
                        'name' => 'dislikes',
                        'href' => false,
                        'text' => elgg_view('dislikes/button', array('entity' => $object)),
                        'is_action' => true,
                        'priority' => 100,
                    );
                    $return[] = ElggMenuItem::factory($options);
                }
                    
                // dislikes count
                $count = elgg_view('dislikes/count', array('entity' => $object));
                if ($count) {
                    $options = array(
                        'name' => 'dislikes_count',
                        'text' => $count,
                        'href' => false,
                        'priority' => 101,
                    );
                    $return[] = ElggMenuItem::factory($options);
                }
            }

            if ($object->canAnnotate(0, 'likes')) {
                if(!(isMonitor() || elgg_is_admin_logged_in())){
                    // like button
                    $options = array(
                        'name' => 'likes',
                        'href' => false,
                        'text' => elgg_view('likes/button', array('entity' => $object)),
                        'is_action' => true,
                        'priority' => 102,
                    );
                    $return[] = ElggMenuItem::factory($options);
                }

                // likes count
                $count = elgg_view('likes/count', array('entity' => $object));
                if ($count) {
                    $options = array(
                        'name' => 'likes_count',
                        'text' => $count,
                        'href' => false,
                        'priority' => 103,
                    );
                    $return[] = ElggMenuItem::factory($options);
                }
            }
		}
	}

	return $return;
}

/**
 * Count how many people have liked an entity.
 *
 * @param  ElggEntity $entity
 *
 * @return int Number of likes
 */
function likes_count($entity) {
    $type = $entity->getType();
    $params = array('entity' => $entity);
    $number = elgg_trigger_plugin_hook('likes:count', $type, $params, false);

    if ($number) {
        return $number;
    } else {
        return $entity->countAnnotations('likes');
    }
}
/**
 * Count how many people have liked an entity.
 *
 * @param  ElggEntity $entity
 *
 * @return int Number of dislikes
 */
function dislikes_count($entity) {
    $type = $entity->getType();
    $params = array('entity' => $entity);
    $number = elgg_trigger_plugin_hook('dislikes:count', $type, $params, false);

    if ($number) {
        return $number;
    } else {
        return $entity->countAnnotations('dislikes');
    }
}

/**
 * Notify $user that $liker liked his $entity.
 *
 * @param type $user
 * @param type $liker
 * @param type $entity 
 */
function likes_notify_user(ElggUser $user, ElggUser $liker, ElggEntity $entity, $likeOrDislike = "like") {
    
    if (!$user instanceof ElggUser) {
        return false;
    }
    
    if (!$liker instanceof ElggUser) {
        return false;
    }
    
    if (!$entity instanceof ElggEntity) {
        return false;
    }
    
    $title_str = $entity->title;
    if (!$title_str) {
        $title_str = elgg_get_excerpt($entity->description);
    }

    $site = get_config('site');

    $subject = elgg_echo($likeOrDislike.'s:notifications:subject', array(
                    $liker->name,
                    $title_str
                ));

    $body = elgg_echo($likeOrDislike.'s:notifications:body', array(
                    $user->name,
                    $liker->name,
                    $title_str,
                    $site->name,
                    $entity->getURL(),
                    $liker->getURL()
                ));

    notify_user($user->guid,
                $liker->guid,
                $subject,
                $body
            );
}