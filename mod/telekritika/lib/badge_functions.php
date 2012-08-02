<?

function badge_url_handler($entity){
    return "badge/{$entity->guid}";
}

function make_badge_FB_page($page, array &$vars = array()){
    if($page && !is_array($page) && ($badge = get_entity($page)) instanceOf BadgesBadge){
        $badge_url = $CONFIG->wwwroot . 'critics/' . $badge->guid;
        $badge_src = $badge->getURL();
        $FBappId = get_plugin_setting('ha_settings_Facebook_app_id','elgg_social_login');
        $FBtitle = $badge->title;
        $FBdesc = $badge->description;

        $vars['FBmeta'] = array(
            'prefix' => "prefix=\"og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# telekritika: http://ogp.me/ns/fb/telekritika#\"",
            'headers' => "
                  <meta property=\"fb:app_id\" content=\"$FBappId\" /> 
                  <meta property=\"og:type\" content=\"telekritika:award\" /> 
                  <meta property=\"og:title\" content=\"$FBtitle\" /> 
                  <meta property=\"og:image\" content=\"$badge_src\" /> 
                  <meta property=\"og:description\" content=\"$FBdesc\" /> 
                  <meta property=\"og:url\" content=\"$badge_url\" />
            ",
        );             
    }elseif ($page && is_array($page)){
        elgg_set_ignore_access(true);
        $awardType = $page[0];
        $awardTime = (int)$page[1];
        if($awardTime){
            $year = (string)date("Y", $awardTime);
            $monthnumber = date("m", $awardTime);
            $prefix = "{$year}_{$monthnumber}_";
        }
        if($awardType){
            $options['metadata_name_value_pair'] = array(
                                            'value' => $prefix.$awardType,
                                            'name' => 'badges_name',
                                            'operand' => '=',
                                            'case_sensitive' => FALSE
                                            );
            $badge = elgg_get_entities_from_metadata($options);
            if(($badge = $badge[0]) instanceof BadgesBadge){
                if($awardTime){
                    $dateadd = "/" . $awardTime;
                }            
                $badge_url = $CONFIG->wwwroot . 'critics/' . $awardType . $dateadd;
                $badge_src = $badge->getURL();
                $monthYear = elgg_echo("date:month:".$monthnumber, array($year));

                $FBappId = get_plugin_setting('ha_settings_Facebook_app_id','elgg_social_login');
                $FBtitle = elgg_echo("$awardType:FBtitle", array($monthYear));
                $FBdesc = elgg_echo("$awardType:FBdescription", array($monthYear));

                $vars['FBmeta'] = array(
                    'prefix' => "prefix=\"og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# telekritika: http://ogp.me/ns/fb/telekritika#\"",
                    'headers' => "
                          <meta property=\"fb:app_id\" content=\"$FBappId\" /> 
                          <meta property=\"og:type\" content=\"telekritika:award\" /> 
                          <meta property=\"og:title\" content=\"$FBtitle\" /> 
                          <meta property=\"og:image\" content=\"$badge_src\" /> 
                          <meta property=\"og:description\" content=\"$FBdesc\" /> 
                          <meta property=\"og:url\" content=\"$badge_url\" />
                    ",
                );             

    //echo "<p>".serialize($vars['FBmeta']);
            }
        }
    }
    $vars['badge'] = $badge ? $badge : false;
    return $vars;    
}

function view_badge_page_handler($page){    
    elgg_set_ignore_access(true);
    $file_guid = (int) $page[0];
    $file = get_entity($file_guid);
    
    if ($file instanceof BadgesBadge) {
        $filename = $file->originalfilename;
        $mime = $file->mimetype;
                
        header("Content-type: $mime");
        header("Content-Disposition: inline; filename=\"$filename\"");
        
        $readfile = new ElggFile($file_guid);
        $readfile->owner_guid = $file->owner_guid;

        $contents = $readfile->grabFile();
        
        echo $contents;
        
        exit;
    }    
}

function publish_badge_to_facebook($userid,$badge){
    global $CONFIG;
    //@todo test if user allows us to post to FB?    
    if(!$badge instanceof BadgesBadge)return true;
    $theurl = ($generic = $badge->generic_name)
        ? $CONFIG->wwwroot . 'critics/' . $generic . '/' . $badge->awardTime
        : $CONFIG->wwwroot . 'critics/' . $badge->guid;    
//    if(post_to_FB($userid, "win", "award", $theurl))return true;
    if(post_to_FB($userid, "win", "award", $theurl))return true;
//    return false;
}
                                                                                        

function apply_user_of_the_month($hook, $entity_type, $returnvalue, $params){
    global $CONFIG;
    elgg_set_ignore_access(TRUE);
    if($CONFIG->userOfMonthEnabled == true){        
        reset_monthTotal();
        date_default_timezone_set('UTC');
        $d = new DateTime("now");
        $d->modify( '+2 days' );
        $d->modify( 'first day of -1 month' );
        $timelower = get_input("preview") ? 0 : $d->format("U");
        echo "timelower:".date("Y m", $timelower)."<br />";
        $d->modify( 'first day of +1 month' );
        $timeupper = get_input("preview") ? strtotime("+1 month") : $d->format("U");
        echo "timeupper:".date("Y m", $timeupper);
        
        $users = get_active_users_since($timelower);
        echo "<p>active users:".json_encode($users)."</p>";
        //        smail("users", json_encode($users));

        for($index = 0, $count = count($users); $index < $count; $index++){
            $users[$index]->popularityTotal = $users[$index]->controversyTotal = $users[$index]->conversationTotal = 0;        
            $user_guid = $users[$index]->guid;
            $options = array(
                'rating_style' => 'all',
                'owner_guid' => $user_guid,
                'subtypes' => array('commentary'),
        //        'subtypes' => array('article'),
                'timeupper' => $timeupper,
                'timelower' => $timelower,
                'limit' => 500,
            );
            //$options['subtype'] = get_input('preview') ? false : "commentary";
            //$options['type'] = "object";
            $all_user_objects = get_objects_by_rating($options);
        echo "<p>user $user_guid objs:<font size=\"1\"><code>".htmlspecialchars(serialize($all_user_objects))."</code></font></p>";
            foreach($all_user_objects as $obj){
                $users[$index]->popularityTotal = $users[$index]->popularityTotal + $obj->popularity;
                $users[$index]->controversyTotal = $users[$index]->controversyTotal + $obj->controversy;
                $users[$index]->conversationTotal = $users[$index]->conversationTotal + $obj->conversation;
           }
//        smail("objs", json_encode($all_user_objects));            
            unset($options['subtype']);
            $all_user_comments = get_comments_by_rating($options);
        echo "<p>user $user_guid coms:<font size=\"1\"><code>".htmlspecialchars(serialize($all_user_comments))."</code></font></p>";
            foreach($all_user_comments as $com){
                $users[$index]->popularityTotal = $users[$index]->popularityTotal + ($com->popularity * $CONFIG->commentValueRatio);
                $users[$index]->controversyTotal = $users[$index]->controversyTotal + ($com->controversy * $CONFIG->commentValueRatio);
            }                                   
//        smail("comments", json_encode($all_user_comments));
        }
                              
        usort($users, "popularity_sorter");
        echo "<p>pop:".json_encode($users)."</p>";
        $last = false; 
        $i = 0;
        foreach($users as $key => $user){
            if($last !== false && $last != $user->popularityTotal) $i++;                
            if($i>=3 || $user->popularityTotal <= 0)break;
            $awardName = interpretAward($i);
            $awards['popularity'][$awardName][] = $user->guid;
            $last = $user->popularityTotal;
        }
                               
        usort($users, "controversy_sorter");
        echo "<p>cont:".json_encode($users)."</p>";
        $last = false; 
        $i = 0;
        foreach($users as $key => $user){
            if($last !== false && $last != $user->controversyTotal) $i++;                
            if($i>=3 || $user->controversyTotal <= 0)break;
            $awardName = interpretAward($i);
            $awards['controversy'][$awardName][] = $user->guid;
            $last = $user->controversyTotal;
        }
                                
        usort($users, "conversation_sorter");
        echo "<p>conv:".json_encode($users)."</p>";
        $last = false; 
        $i = 0;
        foreach($users as $key => $user){
            if($last !== false && $last != $user->conversationTotal) $i++;                
            if($i>=3 || $user->conversationTotal <= 0)break;
            $awardName = interpretAward($i);
            $awards['conversation'][$awardName][] = $user->guid;
            $last = $user->conversationTotal;
        }

        echo json_encode($awards);
        $d->modify( '-15 days' );
        //$awardTime = $d->getTimestamp();
        $awardTime = $d->format('U');
        foreach($awards as $awardType => $val){
            foreach($val as $awardRank => $users){
                foreach($users as $key => $userid){
                    $award = getCreateAward($awardType, $awardRank, $awardTime);
                    assignAward($userid, $award);                    
                }
            }
        }
    }
}

function interpretAward ($i){
    switch($i){
        case 0:
            return "gold";
        break;
        case 1:
            return "silver";
        break;
        case 2:
            return "bronze";
        break;
        default:
            return "error";
        break;
    }
}

function assignAward($userid, $award){
    $user = get_user($userid);
    echo "username: {$userid} <br />userid: {$user->name} <br />";
    //    elgg_set_ignore_access(true);
//    $userbadges = $user->badges_badges;
//    $userbadgesRel = $user->getEntitiesFromRelationship("badges");
    //if already assigned
/*    if(in_array($award->guid, $userbadges)){
        echo "{$award->title} already assigned to {$user->name}<br />";        
        return false;
    }

    //else normalize badges array and create if does not exist
    if($userbadges && is_array($userbadges)){
        $userbadges[] = $award->guid;
    }elseif($userbadges && is_string($userbadges)){
        $userbadges = array($userbadges);
        $userbadges[] = $award->guid;        
    }else{
        $userbadges = array($award->guid);        
    }
    $user->badges_badges = $userbadges;   
  */
  if(!get_input("preview")){
    // add users relationship to the badge
    $user->addRelationship($award->guid, "hasbadge");

    //add points for this badge
    elggx_userpoints_annotate_create(null, null, $award, $userid);        

    // Anounce it on the river
    add_to_river('river/object/badge/awardMonth', 'update', $user->guid, $award->guid);      
  }
  publish_badge_to_facebook($user->guid, $award);  
}

function getCreateAward($awardType, $awardRank, $awardTime){
    $generic = $awardType.ucfirst($awardRank);
    /*determine these*/
    $awardYear = date("Y", $awardTime);
    $awardMonth = date("m", $awardTime);
    $title = "{$awardYear}_{$awardMonth}_$generic";
    $options['metadata_name_value_pair'] = array(
                                            'value' => $title,
                                            'name' => 'badges_name',
                                            'operand' => '=',
                                            'case_sensitive' => FALSE
                                            );
    //if badge already created return it
    if($badge = elgg_get_entities_from_metadata($options)){
        echo "NOT AN ERROR: badge exists $title <br />";
        return $badge[0];
    }
                               
    //else create new badge using generic
    $options['metadata_name_value_pair'] = array(
                                            'value' => $generic,
                                            'name' => 'badges_name',
                                            'operand' => '=',
                                            'case_sensitive' => FALSE
                                            );
    $badge = elgg_get_entities_from_metadata($options);
    if($badge){
        $badge = $badge[0];
        $newbadge = new BadgesBadge();
    }else{
        echo "badge error, generic doesnt exist: {$generic} date: {$awardYear}:{$awardMonth} <br />";
        return false;
    }
    
    $newbadge->set("owner_guid",$badge->getOwnerGUID());
    $newbadge->setFilename($badge->filename);
    $newbadge->setMimeType($badge->mimetype);
    $newbadge->originalfilename = $badge->originalfilename;
    $newbadge->subtype = 'badge';
    $newbadge->access_id = 1;
    $newbadge->title = $title;
    $newbadge->description = $title;
    if(!$newbadge->save()){
        echo "error saving badge: {$newbadge->title} from generic: {$generic}<br />";
        return false;
    }
    /* Add the name as metadata. This is a hack to 
     * allow sorting the admin list view by name 
     * using a custom get_entities_by_metadata method.
     */
    $newbadge->badges_name = $title;
    $newbadge->generic_name = $generic;
    $newbadge->awardType = $awardType;
    $newbadge->awardRank = $awardRank;
    $newbadge->awardTime = $awardTime;
    return $newbadge;    
}

                                                                                        

                                                                                        
?>