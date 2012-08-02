<?

function view_commentaries_by_rating($vars){
    global $CONFIG;    
    $newvars = array(
        'subtype' => "commentary",
        'limit' => $CONFIG->module_entries_limit,
        'timelower' => time() - $CONFIG->time_until_expired,
    );
    $vars['full_view'] = !$vars['medium_view'] && !$vars['module_view'] ? $vars['full_view'] : FALSE;
    $vars = array_merge($vars, $newvars);
    $items = get_objects_by_rating($vars);
    return elgg_view_entity_list($items, $vars);
}

/**
 * Produces linked segment guids
 *
 * @param object $entity An entity.         
 *          
*/
function get_linked_segments_guids($entity){
   // smail("return",serialize($return));
    if(elgg_instanceof($entity,'object','commentary')){
        $relateds = $entity->getEntitiesFromRelationship("linked_segment");
        $return = array();
        foreach($relateds as $related){
            $return[] = $related->guid;
        }
        return $return;
    }
    return false;
}

function get_segments_keyval(){    
    $options = array(
        'type' => 'object',
        'subtype' => 'segment',
    );
    $segments = elgg_get_entities($options);
    foreach($segments as $segment){
        $return[(string)$segment->guid] = $segment->title;
    }
    return $return;
}

function return_broadcast_type_keyval(){
    global $CONFIG;
    return $CONFIG->broadcast_types;
}

function return_channels_keyval(){
    $options = array(
        'type' => 'group',
        'subtype' => 'channel',
    );
    $channels = elgg_get_entities($options);
    foreach($channels as $channel){
        $dropdown[(string)$channel->guid] = $channel->name;
    }
    return $dropdown;
}

function return_channels_autourl_keyval(){
    $options = array(
        'type' => 'group',
        'subtype' => 'channel',
    );
    $channels = elgg_get_entities($options);
    foreach($channels as $channel){
        $dropdown[(string)$channel->guid] = $channel->autourl_root;
    }
    return $dropdown;
}

function return_24hours_keyval(){
    for($i=0;$i<24;$i++){
        $int = sprintf("%02d", $i);
        $return[(string)$int] = (string)$int;
//        $return[$i] = (string)$i;
    }
    return $return;
}

function return_60minutes_keyval(){
    for($i=0;$i<60;$i++){
        $int = sprintf("%02d", $i);
        $return[(string)$int] = (string)$int;
//        $return[$i] = (string)$i;
    }
    return $return;    
}

function return_sequence_positions_keyval($number){
    for($i=1;$i<=$number;$i++){
        $seq = elgg_echo('sequence:'.$i);
        $int = sprintf("%02d", $i);
        $return[(string)$int] = $seq;
    }
    return $return;
}

function return_duration_in_minutes($start_hour = 0, $start_minute = 0, $end_hour = 0, $end_minute = 0){
    $end = ($end_hour * 60) + $end_minute;
    $start = ($start_hour * 60) + $start_minute;
    $output = $end - $start;
    return $output;
}

function return_duration_in_seconds($start_hour = 0, $start_minute = 0, $start_second = 0, $end_hour = 0, $end_minute = 0, $end_second = 0){
    $end = ($end_hour * 3600) + ($end_minute * 60) + $end_second;
    $start = ($start_hour * 3600) + ($start_minute * 60) + $start_second;
    $output = $end - $start;
    //echo $output . "!!<br/>";
    return $output;
}

function return_duration_in_time($seconds){
    //$seconds = return_duration_in_seconds((int)$segment->segment_start_hour, (int)$segment->segment_start_minute, (int)$segment->segment_start_second, (int)$segment->segment_end_hour, (int)$segment->segment_end_minute, (int)$segment->segment_end_second);
    //echo $segment->segment_end_second . $segment->segment_end_minute . $seconds . "!";
    $hour = $seconds > 3600 ? floor($seconds / 3600) : 0;
    $seconds = $seconds - ($hour*3600);
    $minute = $seconds > 60 ? floor($seconds / 60) : 0;
    $seconds = $seconds - ($minute*60);
    $return = ""; 
    $return .= $hour != 0 ? sprintf("%02d", $hour) . ":" : "";
    $return .= sprintf("%02d", $minute) . ":";
    $return .= sprintf("%02d", $seconds);
    return $return;
}
function return_duration_second($seconds){
    //$seconds = return_duration_in_seconds((int)$segment->segment_start_hour, (int)$segment->segment_start_minute, (int)$segment->segment_start_second, (int)$segment->segment_end_hour, (int)$segment->segment_end_minute, (int)$segment->segment_end_second);
    //echo $segment->segment_end_second . $segment->segment_end_minute . $seconds . "!";
    $hour = $seconds > 3600 ? floor($seconds / 3600) : 0;
    $seconds = $seconds - ($hour*3600);
    $minute = $seconds > 60 ? floor($seconds / 60) : 0;
    $seconds = $seconds - ($minute*60);
    $return = ""; 
    $return .= $hour != 0 ? sprintf("%02d", $hour) . ":" : "";
    return sprintf("%02d", $seconds);
}

function return_duration_minute($seconds){
    //$seconds = return_duration_in_seconds((int)$segment->segment_start_hour, (int)$segment->segment_start_minute, (int)$segment->segment_start_second, (int)$segment->segment_end_hour, (int)$segment->segment_end_minute, (int)$segment->segment_end_second);
    //echo $segment->segment_end_second . $segment->segment_end_minute . $seconds . "!";
    $hour = $seconds > 3600 ? floor($seconds / 3600) : 0;
    $seconds = $seconds - ($hour*3600);
    $minute = $seconds > 60 ? floor($seconds / 60) : 0;
    $seconds = $seconds - ($minute*60);
    $return = ""; 
    $return .= $hour != 0 ? sprintf("%02d", $hour) . ":" : "";
    return sprintf("%02d", $minute);
}
  
function is_duplicate_commentary($linked_segments_guids = array(), $owner_guid = false, $simpletest = false){
    $count = count($linked_segments_guids);
    $and = "";
    $userjoin = ($owner_guid)?  "   elgg_users_entity user_t
                                    JOIN elgg_entities comment_t
                                    ON comment_t.owner_guid = user_t.guid "
                                :
                                "   elgg_entities comment_t ";     
    $ownerand = ($owner_guid)?  "   AND (user_t.guid = $owner_guid)":"";

    foreach($linked_segments_guids as $segment_guid){
        $and.=($and == "")?"relate_b.guid_two = $segment_guid ":" OR relate_b.guid_two = $segment_guid ";
    }
    $query = "    
        SELECT comment_t.*, COUNT(DISTINCT relate_a.guid_two) as totalRelations, COUNT(DISTINCT relate_b.guid_two) as matchingRelations
        FROM
                $userjoin
               JOIN elgg_entity_relationships relate_a 
                 ON relate_a.guid_one = comment_t.guid
               JOIN elgg_entity_relationships relate_b 
                 ON relate_b.guid_one = relate_a.guid_one

        WHERE (relate_a.relationship = 'linked_segment')
        $ownerand
        AND ($and)
        GROUP BY comment_t.guid
    ";
    $tested = get_data($query);
    
    $return = false;
    foreach($tested as $test){
        if($test->totalRelations == $test->matchingRelations && $test->totalRelations == $count && $test->matchingRelations == $count){
            if($simpletest){return true;}else{$return[] = $test;}
        }
    }
    return $return;
}

function get_all_tags(array $options = array()) {
    global $CONFIG;
    $options['limit'] = 100000;
    $options['threshold'] = 0;
    //$options['tag_names'] = array('tags', 'events', 'universal_categories');
    $tags = elgg_get_tags($options);
    foreach($tags as $tag){
        $return[] = $tag->tag;
    }
    return $return;
}

function get_channelbar($main = false){
     $channelbar = elgg_list_entities(array(
        'type' => 'group',
        'full_view' => false,
        'subtype' => 'channel',
        'main' => $main,
    ),'elgg_get_entities','elgg_view_channelbar');   
    return $channelbar;
}                                                                                           

function elgg_view_channelbar($entities, $vars = array()) {
    global $CONFIG;
    $low = array();
    $high = array();
    foreach($entities as $key => $val){
        if(in_array($val->name, $CONFIG->lowPriorityChannels)){
            $low[] = $val;
        } elseif (in_array($val->name, $CONFIG->highPriorityChannels)){
            $high[] = $val;
        } else {
            $middle[] = $val;
        }                    
    }

    $entities = array_merge($high, $middle, $low);

    array_push(array_values($entities), $low, $high);
    $defaults = array(
        'items' => $entities,
        'list_class' => 'elgg-list-channelbar',
    );
        
    $vars = array_merge($defaults, $vars);
    return elgg_view('page/components/channelbar', $vars);
}
