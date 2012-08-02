<?php

    include dirname(__FILE__) . "/lib/badge.php";

    function badges_init() {

        elgg_extend_view('css', 'badges/css');
        elgg_extend_view('profile/menu/adminlinks','badges/menu/badges_adminlinks');
        elgg_extend_view('profile/icon','badges/icon');

        register_plugin_hook('userpoints:update', 'all', 'badges_userpoints');

        //$user = get_user_by_username($_SESSION['user']->username);
        //$user->badges_badge = 332;
        //delete_entity(333);

        // add the class files for the badge
        add_subtype("object", "badge", "BadgesBadge");
    }

    /**
     * Sets up the badges admin menu.
     */
    function badges_adminmenu() {
        global $CONFIG;
        if (get_context() == 'admin' && isadminloggedin()) {
            add_submenu_item(elgg_echo('badges:badges'), $CONFIG->url . "mod/badges/admin.php");
        }
    }

    /**
     * This method is called when a users points are updated.
     * We check to see what the users current balance is and 
     * assign the appropriate badge.
     */
    function badges_userpoints($hook, $type, $return, $params) {
//        system_message("badges_userpoints called");
    
        if ($params['entity']->badges_locked) {
            return(true);
        }

        $points = $params['entity']->userpoints_points;
        $badge = get_entity($params['entity']->badges_badge);
        $bpoints = $badge->badges_userpoints;
//        system_message("badges_userpoints called:$points : $badge : $bpoints");
        //if( empty($bpoints) || $bpoints == 0 )return(true);        
        if( empty($bpoints) )$bpoints = 1;        

        $meta_array = array(
        
                array('name' => 'badges_userpoints', 'operand' => '<=', 'value' => $points)
        
        );
        $entities = badges_get_entities_from_metadata_by_value($meta_array, 'object', 'badge', false, 0, 0, 9999999, 0, 'v1.string + 0 DESC');

/*        if ((int)get_plugin_setting('lock_high')) {
//            system_message("locked high");
            if ($badge->badges_userpoints > $entities[0]->badges_userpoints) {
                return(true);
            }
        }
*/
        if ($badge->guid != $entities[0]->guid && !empty($entities[0]->badges_userpoints) && $entities[0]->badges_userpoints > 0) {
//            system_message("assign badge");
            $params['entity']->badges_badge = $entities[0]->guid;
            if (!trigger_plugin_hook('badges:update', 'object', array('entity' => $user), true)) {
                $params['entity']->badges_badge = $badge->guid;
                return(true);
            }   

            // Anounce it on the river
            add_to_river('river/object/badge/award', 'update', $_SESSION['user']->guid, $entities[0]->guid);
            // Announce to user
            system_message(elgg_echo("badges:youwon", array($entities[0]->title)));
            //publish to facebook
            $fbstatus = publish_badge_to_facebook($_SESSION['user']->guid, $entities[0]);
        
        }

        return(true);
    }

function badge_sorter($obj_a, $obj_b) {
    if($obj_a->badges_userpoints === $obj_b->badges_userpoints) return 0;
    return ($obj_a->badges_userpoints > $obj_b->badges_userpoints) ? -1 : 1;
}

    
    
    /**
     * This very cool method was contributed by Alivin79 to the Goolge Elgg Development group
     * http://groups.google.com/group/elgg-development/browse_thread/thread/30259601808493f1/b66ce5aa2f48b921
     *
     * @global Array $CONFIG
     * @param Array $meta_array Is a multidimensional array with the list of metadata to filter.
     * For each metadata you have to provide 3 values:
     * - name of metadata
     * - value of metadata
     * - operand ( <, >, <=, >=, =, like)
     * For example
     *      $meta_array = array(
     *              array(
     *                  'name'=>'my_metadatum',
     *                  'operand'=>'>=',
     *                  'value'=>'my value'
     *              )
     *      )
     * @param String $entity_type
     * @param String $entity_subtype
     * @param Boolean $count
     * @param Integer $owner_guid
     * @param Integer $container_guid
     * @param Integer $limit
     * @param Integer $offset
     * @param String $order_by "Order by" SQL string. If you want to sort by metadata string,
     * possible values are vN.string, where N is the first index of $meta_array,
     * hence our example is $order by = 'v1.string ASC'
     * @param Integer $site_guid
     * @return Mixed Array of entities or false
     *
     */
    function badges_get_entities_from_metadata_by_value($meta_array, $entity_type="", $entity_subtype="", $count=false, $owner_guid=0, $container_guid=0, $limit=10, $offset=0, $order_by="", $site_guid=0) {

        global $CONFIG;

        // ORDER BY
        if ($order_by == "") $order_by = "e.time_created desc";
        $order_by = sanitise_string($order_by);

        $where = array();

        // Filetr by metadata
        $mindex = 1; // Starting index of joined metadata/metastring tables
        $join_meta = "";
        $query_access = "";
        foreach($meta_array as $meta) {
            $join_meta .= "JOIN {$CONFIG->dbprefix}metadata m{$mindex} on e.guid = m{$mindex}.entity_guid ";
            $join_meta .= "JOIN {$CONFIG->dbprefix}metastrings v{$mindex} on v{$mindex}.id = m{$mindex}.value_id ";

            $meta_n = get_metastring_id($meta['name']);
            $where[] = "m{$mindex}.name_id='$meta_n'";

            if (strtolower($meta['operand']) == "like"){
                // "LIKE" search
                $where[] = "v{$mindex}.string LIKE ('".$meta['value']."') ";
            }elseif(strtolower($meta['operand']) == "in"){
                // TO DO - "IN" search
            }else{
                // Simple operand search
                $where[] = "v{$mindex}.string".$meta['operand']."'".$meta['value']."' + 0";
            }

            $query_access .= ' and ' . get_access_sql_suffix("m{$mindex}"); // Add access controls

            $mindex++;
        }

        $limit = (int)$limit;
        $offset = (int)$offset;

        if ((is_array($owner_guid) && (count($owner_guid)))) {
            foreach($owner_guid as $key => $guid) {
                $owner_guid[$key] = (int) $guid;
            }
        } else {
            $owner_guid = (int) $owner_guid;
        }

        if ((is_array($container_guid) && (count($container_guid)))) {
            foreach($container_guid as $key => $guid) {
                $container_guid[$key] = (int) $guid;
            }
        } else {
            $container_guid = (int) $container_guid;
        }

        $site_guid = (int) $site_guid;
        if ($site_guid == 0)
            $site_guid = $CONFIG->site_guid;

        $entity_type = sanitise_string($entity_type);
        if ($entity_type!="")
            $where[] = "e.type='$entity_type'";

        $entity_subtype = get_subtype_id($entity_type, $entity_subtype);
        if ($entity_subtype)
            $where[] = "e.subtype=$entity_subtype";

        if ($site_guid > 0)
            $where[] = "e.site_guid = {$site_guid}";

        if (is_array($owner_guid)) {
            $where[] = "e.owner_guid in (".implode(",",$owner_guid).")";
        } else if ($owner_guid > 0) {
            $where[] = "e.owner_guid = {$owner_guid}";
        }

        if (is_array($container_guid)) {
            $where[] = "e.container_guid in (".implode(",",$container_guid).")";
        } else if ($container_guid > 0)
            $where[] = "e.container_guid = {$container_guid}";
        if (!$count) {
            $query = "SELECT distinct e.* ";
        } else {
            $query = "SELECT count(distinct e.guid) as total ";
        }

        $query .= "FROM {$CONFIG->dbprefix}entities e ";
        $query .= $join_meta;

        $query .= "  WHERE ";
        foreach ($where as $w)
            $query .= " $w and ";
        $query .= get_access_sql_suffix("e"); // Add access controls
        $query .= $query_access;

        if (!$count) {
            $query .= " order by $order_by limit $offset, $limit"; // Add order and limit
            return get_data($query, "entity_row_to_elggstar");
        } else {
            $row = get_data_row($query);
            if ($row)
                return $row->total;
        }
        return false;
    } 



    register_elgg_event_handler('init','system','badges_init');
    register_elgg_event_handler('pagesetup','system','badges_adminmenu');
    
    register_action("badges/upload", false, $CONFIG->pluginspath . "badges/actions/upload.php", true);
    register_action("badges/edit", false, $CONFIG->pluginspath . "badges/actions/edit.php", true);
    register_action("badges/assign", false, $CONFIG->pluginspath . "badges/actions/assign.php", true);
    register_action("badges/view", false, $CONFIG->pluginspath . "badges/actions/view.php");
    register_action("badges/delete", false, $CONFIG->pluginspath . "badges/actions/delete.php", true);

    elgg_register_entity_url_handler('object', 'badge', 'badge_url_handler');    
    
?>