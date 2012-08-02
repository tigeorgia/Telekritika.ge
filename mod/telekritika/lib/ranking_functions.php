<?
  
/**
 * Page hander for awards (fb requires these)
 *
 * @param array $page Page array
 *
 * @return void
 */
function tk_critics_page_handler($page) {
    global $CONFIG;

    $params = tk_critics_ranking_page($page);
    $layout = 'custom_index';

    //Make badges facebook pages!
    if(is_array($page)) make_badge_FB_page($page, $params);

    $body = elgg_view_layout($layout, $params);
    echo elgg_view_page($params['title'], $body, "default", $params);

}

function tk_critics_ranking_page($page){
    
    $chart_js = elgg_get_simplecache_url('js', 'topcritics/chart');
    elgg_register_js('elgg.chart', $chart_js);
    elgg_load_js('elgg.chart');
    
    $return = array();

    //MAIN MODULE//
        $return['title'] = "rankings page";
        $options['rating_style'] = "conversationTotal";
        $options['limit'] = 5;
        $body .= view_users_for_chart($options);  
//        $moduletitle = "rankings page";
        $modulecontent = elgg_view_module('rankings page', $moduletitle, $body, array('class' => 'tk-main-module nopvm'));
        $module = array('body' => $modulecontent, 'class' => 'toppest nopvm toppest' );
        $return['content']['main'][] = $module;     
    //MAIN MODULE//

//    add_template_modules($return);
                
    return $return;    
}

function view_users_for_chart($options){
    $defaults = array(
        'limit' => 10,
        'pagination' => true,
        'data-sub' => __FUNCTION__,
        'data-refresh' => __FUNCTION__,
//        'data-rating_style' => $options['rating_style'],
        'data-postjs' => "userchartrefresh",
        'data-prejs' => "fadechart",
    );         
    $options = array_merge($defaults, $options);              
    return elgg_list_entities(
        $options, 
        "get_users_by_rank", 
        "list_users_for_chart"
     );    
}

function get_users_by_rank($vars){
    return elgg_get_entities_from_metadata(array(
        "type" => "user",
        "count" => $vars['count'],        
        "metadata_names" => array($vars['rating_style']),
        "order_by_metadata" => array("name" => $vars['rating_style'], 'direction' => 'DESC', 'as' => $vars['rating_style'] == "controversyTotal" || $vars['rating_style'] == "controversyMonthTotal" ? 'float' : 'integer'),
        "offset" => $vars['offset'],        
        "limit" => $vars['limit'],        
        )
    );
}

function get_badge_img($badgename){ 
    global $CONFIG;
    $badgeopts['metadata_name_value_pair'] = array(
                                    'value' => $badgename,
                                    'name' => 'badges_name',
                                    'operand' => '=',
                                    'case_sensitive' => FALSE
                                    );                
    $badge = elgg_get_entities_from_metadata($badgeopts);
    return $CONFIG->wwwroot . "badge/" . $badge[0]->guid;
}

function list_users_for_chart($users, $vars){
    $currentuserpage = floor((int)get_user_rating(elgg_get_logged_in_user_entity(), $vars['rating_style']) / $vars['limit']);

    $ratingstyles = array("popularity", "controversy", "conversation");
    $nav = "<fieldset data-sub=\"|view_users_for_chart|\" data-onlyjs=\"|freeze|\" id=\"leftranks_holder\"><legend>".elgg_echo("ranksbytotal")."</legend>";
    foreach($ratingstyles as $style){
        $badgeurl = get_badge_img($style . "Gold");        
        $badgeholder = add_dropshadow($badgeurl, ($vars['rating_style'] == ($style . "Total")) ? "selected rankings_badge" : "rankings_badge" );
        $nav .= elgg_view("output/url", array(
            "href" => "#",
            "text" => $badgeholder,
            "data-pub" => prep_pipe_string("view_users_for_chart"),
            "data-limit" => $vars['limit'],
            "data-rating_style" => $style . "Total",
            "class" => ($vars['rating_style'] == ($style . "Total")) ? "selected ratingslink" : "ratingslink"
        ));
    }
    $nav.="</fieldset>";    
    $nav .= "<fieldset data-sub=\"|view_users_for_chart|\" data-onlyjs=\"|freeze|\" id=\"rightranks_holder\"><legend>".elgg_echo("ranksbymonthtotal")."</legend>";
    foreach($ratingstyles as $style){
        $badgeurl = get_badge_img($style . "Gold");        
        $badgeholder = add_dropshadow($badgeurl, ($vars['rating_style'] == ($style . "MonthTotal")) ? "selected rankings_badge" : "rankings_badge");
        $nav .= elgg_view("output/url", array(
            "href" => "#",
            "text" => $badgeholder,
            "data-pub" => prep_pipe_string("view_users_for_chart"),
            "data-limit" => $vars['limit'],
            "data-rating_style" => $style . "MonthTotal",
            "class" => ($vars['rating_style'] == ($style . "MonthTotal")) ? "selected ratingslink" : "ratingslink"
        ));
    }
    $nav.="</fieldset>";    
    
    $nav .= "<div id=\"chart1\" style=\"margin-top:20px; margin-left:20px; width:800px; height:400px;\"></div>";

    if ($vars['pagination'] && $vars['count']) {
        $nav .= elgg_view('navigation/pagination', array(
            'baseurl' => "#",
            'offset' => $vars['offset'],
            'count' => $vars['count'],
            'limit' => $vars['limit'],
            'offset_key' => "offset",
            'data-rating_style' => $vars['rating_style'],
            'data-pub' => prep_pipe_string($vars['data-sub']),
        ));
    }
    $nav .= elgg_is_logged_in() ? elgg_view("output/url", array(
            'href' => "#",
            'text' => elgg_echo("critics:findme"),
            'data-offset' => $currentuserpage * $vars['limit'],
            'data-limit' => $vars['limit'],
            'data-rating_style' => $vars['rating_style'],
            'data-pub' => prep_pipe_string($vars['data-sub']),
    )) : "";
    $extra = prep_pubsub_string($vars);
    $nav = "<div $extra>$nav</div>";

    $opts['metastring_type'] = "metadata";
    $opts['metastring_names'] = array($vars['rating_style']);
    $opts['order_by'] = 'v.string + 0 DESC';
    $opts['limit'] = 1;
    $maxret = elgg_get_metastring_based_objects($opts);
    $maxuserpoints = $maxret[0]->value;
    
    $data['users'] = array();   
    $data['ratings'] = array();
    $data['ranks'] = array();
    
    foreach($users as $user){
        if(!$x){
            $x = get_user_rating($user, $vars['rating_style'], array("rank" => true));
            $lastrating = $user->$vars['rating_style'];
        }
        if($user->$vars['rating_style'] != $lastrating){
            $x++;
            $lastrating = $user->$vars['rating_style'];
        }
        $data['users'][] = $user->name;   
        $data['ratings'][] = $lastrating;
        $data['ranks'][] = $x;
    }
    while(count($data['users']) < $vars['limit']){        
        array_push($data['ranks'], null);
        array_push($data['ratings'], null);
        array_push($data['users'], null);
    }
    $script .= prep_js_array("users", $data['users']);   
    $script .= prep_js_array("ratings", $data['ratings']);   
    $script .= prep_js_array("ranks", $data['ranks']);   
    $script .= "maxuserpoints = " . $maxuserpoints . ";";
    $script .= elgg_is_xhr() ? "reinitchart('chart1');" : "initchart('chart1');";
    
    $initscript = "currentuserPage = " . $currentuserpage . ";";
    $initscript .= "jQuery.jqplot.config.enablePlugins = true;";
        
    if(elgg_is_xhr())
        add_extra_obj(array("script" => $script));
    else
        $nav .= "<script>jQuery(document).ready(function(){ $initscript $script });</script>";
    return $nav;
}

function update_rating_style($event, $object_type, $annotation) {
    global $haltCalculation;
    if($haltCalculation !== "halt" && ($annotation->name == "generic_comment" || $annotation->name == "dislikes" || $annotation->name == "likes")){
        $object['entity'] = get_entity($annotation->entity_guid);
        $owner = get_user($object['entity']->owner_guid);

        $likes = $object['entity']->countAnnotations("likes");
        $dislikes = $object['entity']->countAnnotations("dislikes");
        $comments = $object['entity']->countAnnotations("generic_comment");

//        system_message("count:".$likes." ".$dislikes." ".$comments);
        
        $origPopularity = $object['entity']->popularity ? $object['entity']->popularity : 0;
        $origControversy = $object['entity']->controversy ? $object['entity']->controversy : 0;
        $origConversation = $object['entity']->conversation ? $object['entity']->conversation : 0;
        
        //system_message("original:".$origPopularity." ".$origControversy." ".$origConversation);

        
        $object['entity']->popularity = calc_popularity($likes, $dislikes, $comments);
        $object['entity']->controversy = calc_controversy($likes, $dislikes, $comments);
        $object['entity']->conversation = calc_conversation($likes, $dislikes, $comments);
        $object['entity']->save();

        $owner->popularityTotal = $owner->popularityTotal ? $owner->popularityTotal + ($object['entity']->popularity - $origPopularity) : ($object['entity']->popularity - $origPopularity);
        $owner->controversyTotal = $owner->controversyTotal ? $owner->controversyTotal + ($object['entity']->controversy - $origControversy) : ($object['entity']->controversy - $origControversy);
        $owner->conversationTotal = $owner->conversationTotal ? $owner->conversationTotal + ($object['entity']->conversation - $origConversation) : ($object['entity']->conversation - $origConversation);
        
        $owner->popularityMonthTotal = $owner->popularityMonthTotal ? $owner->popularityMonthTotal + ($object['entity']->popularity - $origPopularity) : ($object['entity']->popularity - $origPopularity);
        $owner->controversyMonthTotal = $owner->controversyMonthTotal ? $owner->controversyMonthTotal + ($object['entity']->controversy - $origControversy) : ($object['entity']->controversy - $origControversy);
        $owner->conversationMonthTotal = $owner->conversationMonthTotal ? $owner->conversationMonthTotal + ($object['entity']->conversation - $origConversation) : ($object['entity']->conversation - $origConversation);                
        $owner->save();
    }
    return(true);    
}


function calc_controversy($numberlikes, $numberdislikes, $comments){
    global $CONFIG;              
    $numberlikes = ($numberlikes == false || $numberlikes == 0) ? .25 : $numberlikes;
    $numberdislikes = ($numberdislikes == false || $numberdislikes == 0) ? .25 : $numberdislikes;
    if($numberdislikes == .25 && $numberlikes ==.25)return .001;
    $LplusD = $comments ? 
        ($numberlikes + $numberdislikes) + ($comments * $CONFIG->commentValueRatio)
        : ($numberlikes + $numberdislikes);
    $abs = abs($numberlikes - $numberdislikes);
    $LminusD = $abs == 0 ? 1 : $abs;
    $score = ($LplusD*$LplusD) / ($LminusD*10);
    return $score ? $score : 0;
}

function calc_popularity($numberlikes, $numberdislikes, $comments){
    $score = $numberlikes - $numberdislikes;
    return $score ? $score : 0;
}
    
function calc_conversation($numberlikes, $numberdislikes, $comments){
    $score = $comments;
    return $score ? $score : 0;
}  

function reset_monthTotal(){    
    elgg_set_ignore_access(true);
    $query = "SELECT id FROM elgg_metastrings WHERE string = 0";
    $dblink = get_db_link('read');
    $select = mysql_fetch_object(execute_query("$query", $dblink));
    $query = "UPDATE elgg_metadata n_table 
        JOIN elgg_metastrings n on n_table.name_id = n.id 
        JOIN elgg_metastrings v on n_table.value_id = v.id 
        JOIN elgg_metastrings msn on n_table.name_id = msn.id 
        SET n_table.value_id = {$select->id}
        WHERE msn.string 
            IN ('popularityMonthTotal', 'controversyMonthTotal', 'conversationMonthTotal')";
    $dblink = get_db_link('write');
    execute_query("$query", $dblink);

/*    $users = elgg_get_entities(array("type"=>"user"));
    foreach ($users as $user){
        $user->popularityMonthTotal = 0;
        $user->controversyMonthTotal = 0;
        $user->conversationMonthTotal = 0;
    }*/
}


function calibrate_points_total($hook, $entity_type, $returnvalue, $params){
    global $CONFIG;
    elgg_set_ignore_access(TRUE);
    date_default_timezone_set('UTC');
    $d = new DateTime("now");
    $d->modify( '-7 day' );
    $timelower = $d->format("U");
//    echo "timelower:".date("Y m", $timelower)."<br />";
//    echo "timeupper:".date("Y m", $timeupper);
    
    $users = get_active_users_since($timelower);
        
    for($index = 0, $count = count($users); $index < $count; $index++){
        $users[$index]->popularityTotal = $users[$index]->controversyTotal = $users[$index]->conversationTotal = 0;        
        $user_guid = $users[$index]->guid;
        $options = array(
            'rating_style' => 'all',
            'owner_guid' => $user_guid,
            'subtypes' => array('commentary'),
    //        'subtypes' => array('article'),
//            'timeupper' => $timeupper,
//            'timelower' => $timelower,
                'limit' => 5000,
        );
        //$options['subtype'] = get_input('preview') ? false : "commentary";
        //$options['type'] = "object";
        $all_user_objects = get_objects_by_rating($options);
//        echo "<p>user $user_guid objs:<font size=\"1\"><code>".htmlspecialchars(serialize($all_user_objects))."</code></font></p>";
        foreach($all_user_objects as $obj){
            $users[$index]->popularityTotal = $users[$index]->popularityTotal + $obj->popularity;
            $users[$index]->controversyTotal = $users[$index]->controversyTotal + $obj->controversy;
            $users[$index]->conversationTotal = $users[$index]->conversationTotal + $obj->conversation;
       }
//        smail("objs", json_encode($all_user_objects));            
        unset($options['subtype']);
        $all_user_comments = get_comments_by_rating($options);
//        echo "<p>user $user_guid coms:<font size=\"1\"><code>".htmlspecialchars(serialize($all_user_comments))."</code></font></p>";
        foreach($all_user_comments as $com){
            $users[$index]->popularityTotal = $users[$index]->popularityTotal + ($com->popularity * $CONFIG->commentValueRatio);
            $users[$index]->controversyTotal = $users[$index]->controversyTotal + ($com->controversy * $CONFIG->commentValueRatio);
        }                                   
//        smail("comments", json_encode($all_user_comments));
    }
}

function calibrate_points_month($hook, $entity_type, $returnvalue, $params){
    global $CONFIG;
    elgg_set_ignore_access(TRUE);
    date_default_timezone_set('UTC');
    $d = new DateTime("now");
    $d->modify( '-1 day' );
    $timelower = $d->format("U");
//    echo "timelower:".date("Y m", $timelower)."<br />";
//    echo "timeupper:".date("Y m", $timeupper);
    
    $users = get_active_users_since($timelower);

    $d = new DateTime("now");
//    $d->modify( '+2 days' );
    $timeupper = $d->format("U");
    $d->modify( 'first day of this month' );
    $timelower = $d->format("U");
    echo "timelower:".date("Y m", $timelower)."<br />";
        
    for($index = 0, $count = count($users); $index < $count; $index++){
        $users[$index]->popularityMonthTotal = $users[$index]->controversyMonthTotal = $users[$index]->conversationMonthTotal = 0;        
        $user_guid = $users[$index]->guid;
        $options = array(
            'rating_style' => 'all',
            'owner_guid' => $user_guid,
            'subtypes' => array('commentary'),
    //        'subtypes' => array('article'),
            'timeupper' => $timeupper,
            'timelower' => $timelower,
                'limit' => 5000,
        );
        //$options['subtype'] = get_input('preview') ? false : "commentary";
        //$options['type'] = "object";
        $all_user_objects = get_objects_by_rating($options);
//        echo "<p>user $user_guid objs:<font size=\"1\"><code>".htmlspecialchars(serialize($all_user_objects))."</code></font></p>";
        foreach($all_user_objects as $obj){
            $users[$index]->popularityMonthTotal = $users[$index]->popularityMonthTotal ? $users[$index]->popularityMonthTotal + $obj->popularity : $obj->popularity;
            $users[$index]->controversyMonthTotal = $users[$index]->controversyMonthTotal ? $users[$index]->controversyMonthTotal + $obj->controversy : $obj->controversy;
            $users[$index]->conversationMonthTotal = $users[$index]->conversationMonthTotal ? $users[$index]->conversationMonthTotal + $obj->conversation : $obj->conversation;
       }
//        smail("objs", json_encode($all_user_objects));            
        unset($options['subtype']);
        $all_user_comments = get_comments_by_rating($options);
//        echo "<p>user $user_guid coms:<font size=\"1\"><code>".htmlspecialchars(serialize($all_user_comments))."</code></font></p>";
        foreach($all_user_comments as $com){
            $users[$index]->popularityMonthTotal = $users[$index]->popularityMonthTotal ? $users[$index]->popularityMonthTotal + ($com->popularity * $CONFIG->commentValueRatio) : ($com->popularity * $CONFIG->commentValueRatio);
            $users[$index]->controversyMonthTotal = $users[$index]->controversyMonthTotal ? $users[$index]->controversyMonthTotal + ($com->controversy * $CONFIG->commentValueRatio) : ($com->controversy * $CONFIG->commentValueRatio);
        }                                   
//        smail("comments", json_encode($all_user_comments));
    }
}


function get_objects_by_rating($options){
    $defaults = array(
        'offset' => 0,
        'limit' => 10,
        'type' => 'object',
        'rating_style' => 'all',
        'timeupper' => time(),
    );

    if(is_array($options)){
        $options = array_merge($defaults, $options);        
    }else{
        $options = $defaults;
    }

    if($options['timelower']){
        $options['created_time_upper'] = $options['timeupper'];
        $options['created_time_lower'] = $options['timelower'];
    }
    
    switch($options['rating_style']){
        case 'popularity':
            $options['order_by_metadata'] = 
            array(
                array('name' => 'popularity', 'direction' => 'DESC', 'as' => 'integer')
            );
            $getter = "elgg_get_entities_from_metadata";
        break;
        case 'controversy':
            $options['order_by_metadata'] = array(
                array('name' => 'controversy', 'direction' => 'DESC', 'as' => 'decimal')
            );
            $getter = "elgg_get_entities_from_metadata";
        break;
        case 'conversation':
            $options['annotation_names'] = array("generic_comment");
            $options['calculation'] = "COUNT";
            $getter = "elgg_get_entities_from_annotation_calculation";            
        break;
        case 'all':
        break;    
    }
    return $getter($options);
}    
        

/**
 * Produces comments based on rating style (popularity, controversy)
 *
 * @param array $options An options array.         
 *       'offset' => 0,
 *       'owner_guid' => ,
 *      'limit' => 0,
 *      'type' => 'object',
 *      'subtype' => 'segment',
 *      'rating_style' => 'popularity',
*/
function get_comments_by_rating($options){
    $defaults = array(
        'offset' => 0,
        'limit' => 0,
        'rating_style' => 'all',
        'count' => false,
        'timeupper' => time(),
    );
    $options = array_merge($defaults, $options);
    
    $offset = $options['offset'];
    $limit = $options['limit'];
    $owner_guid = $options['owner_guid'];
    $entity_guid = $options['entity_guid'];
    $minimum = $options['minimum'];
    $timeupper = $options['timeupper'];
    $timelower = $options['timelower'];
    
    $builder = $order = "";
    if(is_string($options['rating_style'])){
        $rating_style = ($options['rating_style'] == "all") ? array("popularity", "controversy") : array($options['rating_style']);
    }else{
        $rating_style = $options['rating_style'];
    }
    if($options['count'] === TRUE){
        foreach($rating_style as $key => $val){
            if($key>0)unset($rating_style[$key]);
        }    
    }        
    foreach($rating_style as $key => $val){
        $builder.=",
                    @{$val}ratingstylepos:=LOCATE('{$val}\":', a_msv.string), 
                    @{$val}commapos:=LOCATE(',', a_msv.string, @{$val}ratingstylepos),
                    @{$val}bracketpos:=LOCATE('}', a_msv.string, @{$val}ratingstylepos),
                    @{$val}enddelimtest:=IF(@{$val}commapos < @{$val}bracketpos, @{$val}commapos, @{$val}bracketpos),
                    @{$val}endpos:=IF(@{$val}enddelimtest != 0, @{$val}commapos, @{$val}bracketpos),
                    @{$val}fullpos:=(".(strlen($val)+2)."+@{$val}ratingstylepos),
                    CONVERT((SUBSTRING(a_msv.string,@{$val}fullpos,(@{$val}endpos-@{$val}fullpos))), SIGNED) as {$val}
        ";
            $orderarray[] = $val;
    }
       
    if($timelower)$wheres[] = elgg_get_entity_time_where_sql('n_table', $timeupper, $timelower, null, null);    
    if($entity_guid)$wheres[] = "( n_table.entity_guid = $entity_guid )";
    if($owner_guid)$wheres[] = "( n_table.owner_guid = $owner_guid )";
    if(is_array($wheres))$where = implode(" AND ", $wheres) . " AND ";

    $order = implode(" DESC,",$orderarray) . " DESC"; 

    $limitstr = ($offset != 0 && $limit != 0) ? "LIMIT $offset, $limit" : "";

    $query = "
                SELECT SQL_CALC_FOUND_ROWS DISTINCT 
                        n_table.*, 
                        msn.string as name, 
                        a_msv.string as value"
                        .$builder.
                "FROM   elgg_annotations n_table 
                       JOIN elgg_metastrings a_msv 
                         ON n_table.value_id = a_msv.id 
                       JOIN elgg_metastrings msn 
                         ON n_table.name_id = msn.id 
                WHERE $where (msn.string = 'generic_comment'  AND n_table.enabled = 'yes')
                ORDER BY $order
                $limitstr
    ";


    $return = get_data($query, 'row_to_elggannotation'); 

    $query = "SELECT FOUND_ROWS()";
    $total = (int)get_data_row($query)->total;

    $cnt=count($return);
    
    for($i=0;$minimum && $i<$cnt;$i++){
        $check .= "rate".$return[$i]->$rating_style[0];
        if($return[$i]->$rating_style[0] < $minimum){
            $total--;
            unset($return[$i]);
        }
    }
//    smail("rating",$check);

    if($options['count'] === TRUE)
        return $total;
    return $return;

}    


function get_user_rating($user, $rating_style, $vars){
    elgg_set_ignore_access(true);
    $points = (float)$user->$rating_style; 
    $distinct = $vars['rank'] ? "DISTINCT" : "";
    $query="SELECT COUNT($distinct v.string) as calculation
        FROM elgg_metadata n_table
        JOIN elgg_entities e ON n_table.entity_guid = e.guid
        JOIN elgg_metastrings v ON n_table.value_id = v.id
        JOIN elgg_metastrings msn ON n_table.name_id = msn.id
        WHERE v.string > $points
        AND msn.string = '$rating_style'
        AND e.enabled =  'yes'";
    $return = get_data($query);
    return $vars['rank'] ? (int)$return[0]->calculation + 1 : (int)$return[0]->calculation;
}

function popularity_sorter($obj_a, $obj_b) {
    if($obj_a->popularityTotal === $obj_b->popularityTotal) return 0;
    return ($obj_a->popularityTotal > $obj_b->popularityTotal) ? -1 : 1;
}
function controversy_sorter($obj_a, $obj_b) {
    if($obj_a->controversyTotal === $obj_b->controversyTotal) return 0;
    return ($obj_a->controversyTotal > $obj_b->controversyTotal) ? -1 : 1;
}
function conversation_sorter($obj_a, $obj_b) {
    if($obj_a->conversationTotal === $obj_b->conversationTotal) return 0;
    return ($obj_a->conversationTotal > $obj_b->conversationTotal) ? -1 : 1;
}


function get_active_users_since($timelower){
    global $CONFIG;

    $query = "SELECT guid from {$CONFIG->dbprefix}users_entity 
        where last_action > $timelower";

    $return = get_data($query);

    return $return;
}
