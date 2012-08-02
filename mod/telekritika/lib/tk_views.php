<?php
  /* NEW VIEW FUNCTIONS FOR AJAX */

function view_comment_menu($vars){
    $comment = ($vars['annotation'])?$vars['annotation']:get_annotation($vars['annotation_id']);
    $comment_menu = elgg_view_menu('annotation', array(
        'annotation' => $comment,
        'sort_by' => 'priority',
        'class' => 'elgg-menu-hz right',
        'data-sub' => 'likes.annotation.'.$comment->id,
        'data-refresh' => __FUNCTION__,
        'data-prejs' => array("blockNoOverlay"),
    ));
    return $comment_menu;    
}



function view_all_comments($vars){
    $entity = get_entity($vars['guid']);
    $defaults = array(
        'show_add_form' => false,
        'data-refresh' => __FUNCTION__,
        'data-sub' => "{$entity->getSubType()}.postcomment.{$vars['guid']}",
        'data-guid' => $vars['guid'],
        'data-prejs' => array("freeze"),
        'limit' => 10,
        'order_by'    =>    'n_table.time_created desc',  
    );
    $vars = array_merge($defaults, $vars);
    return elgg_view_comments($entity, $vars['show_add_form'], $vars);        
}

function view_all_commentaries($vars){    
    $options = array(
        'type' => 'object',
        'subtype' => 'commentary',
        'full_view' => FALSE,
        'data-module_view' => $vars['module_view'],
        'module_view' => $vars['module_view'],
//        'metadata_name_value_pairs' => array(
//            array('name' => 'status', 'value' => 'published')
//        ),
//        'data-sub' => 'commentary',
        'data-refresh' => __FUNCTION__,
        'data-prejs' => array("freeze"),
        'data-owner_guid' => $vars['owner_guid'],
        'owner_guid' => $vars['owner_guid'],
        'limit' => $vars['limit'],
        'paginate' => true,
    );

    $options = array_merge($options, $vars);
    
    $list = elgg_list_entities_from_metadata($options);
    
    if (!$list) {
        $return = elgg_echo('commentary:none');
    } else {
        $return = $list;
    }

    return $return;
}

function show_all_users(){
    admin_gatekeeper();
    return elgg_list_entities(array(
        'type' => 'user',
        'subtype'=> null,
        'full_view' => FALSE,
        'data-refresh' => __FUNCTION__,
        'data-paginate' => "true",
    ));    
}


function view_all_segments(array $vars = array()){    
    admin_gatekeeper();                
    unset($vars['guid']);

    update_segments();
    
    $options = array(
        'type' => 'object',
        'subtype' => 'segment',
        'full_view' => FALSE,
        'metadata_name_value_pairs' => $vars['status'] == "draft" ? array(
            array('name' => 'status', 'value' => 'draft')
        ) : false,
        'order_by_metadata' => array('name' => 'admincommented', 'direction' => 'DESC', 'as' => 'integer'),
        'data-status' => $vars['status'] == "draft" ? "draft" : false,
        'data-sub' => 'segment.approve',
        'data-refresh' => __FUNCTION__,
        'data-prejs' => array("freeze"),
        'paginate' => true,
    );
    $options = array_merge($options, $vars);
    //smail("count2", count($testents2));
    
    $list = elgg_list_entities_from_metadata($options);
    
    if (!$list) {
        $return = elgg_echo('segment:none');
    } else {
        $return = $list;
    }

    return $return;
}


function view_main_slide_meta($vars){
    $vars['entity'] = elgg_extract("entity", $vars, get_entity($vars['guid']));    
    $pubstrings = array("likes.{$vars['entity']->getSubType()}.{$vars['entity']->getGUID()}");
    $pubstring = prep_pipe_string($pubstrings);
    $refresh = __FUNCTION__;
    $vars['slide_view'] = TRUE;
    $vars['full_view'] = FALSE;
    $metadata = "<span class=\"sliderthumbs\" data-sub=\"$pubstring\" data-refresh=\"$refresh\">";
    $metadata .= elgg_is_logged_in() ? elgg_view("likes/button", $vars) : elgg_view("likes/button_login", $vars);
    $metadata .= "<span class=\"likescount\">" . (($count = elgg_view("likes/count", $vars)) == 0 ? "&nbsp;&nbsp;" : $count) . "</span>";
    $metadata .= elgg_is_logged_in() ? elgg_view("dislikes/button", $vars) : elgg_view("dislikes/button_login", $vars);    
    $metadata .= "<span class=\"likescount\">" . (($count = elgg_view("dislikes/count", $vars)) == 0 ? "&nbsp;&nbsp;" : $count) . "</span>";    
    $metadata .= "</span>";
    return $metadata;
}

function view_object_menu($vars){
    $vars['entity'] = ($vars['entity'])?$vars['entity']:get_entity($vars['guid']);
    $handler = $vars['handler'] ? $vars['handler'] : $vars['entity']->getSubType(); 
    $metadata = elgg_view_menu('entity', array(
        'entity' => $vars['entity'],
        'data-handler' => $handler,
        'handler' => $handler,
        'sort_by' => 'priority',
        'class' => 'elgg-menu-hz',
        'data-sub' => "likes.{$vars['entity']->getSubType()}.{$vars['entity']->getGUID()}",
        'data-refresh' => __FUNCTION__,
        'data-prejs' => array("blockNoOverlay"),
    ));
    return $metadata;    
}

function view_river(array $vars = array()){
    $defaults = array(
        "paginate" => __FUNCTION__,
        "data-paginate" => "true",
        "data-refresh" => __FUNCTION__,
        "data-prejs" => "freeze",
    //    "position" => "both",
    );
    $vars = array_merge($defaults, $vars);
    $river = elgg_list_river($vars);
    return $river;
}

function view_river_menu($vars){
    if(!$vars['item']){
        $options['object_guids'] = $vars['guid'];
        $options['limit'] = 1;
        $items = elgg_get_river($options);
        $vars['item'] = $items[0];
    }
    $guid = $vars['item']->getObjectEntity()->getGUID();
    $subtype = $vars['item']->getObjectEntity()->getSubType();
    $metadata = elgg_view_menu('river', array(
        'item' => $vars['item'],
        'sort_by' => 'priority',
        'class' => 'elgg-menu-hz',
        'data-sub' => "likes.$subtype.$guid",
        'data-refresh' => __FUNCTION__,
        'data-prejs' => array("blockNoOverlay"),
    ));    
    return $metadata;    
}

function view_segmentselect_module($vars){
    global $CONFIG;
    if(empty($vars['lastdate']))unset($vars['lastdate']);
    if(empty($vars['lastkeyword']))unset($vars['lastkeyword']);
    $vars['date'] = (!empty($vars['date'])) ? $vars['date'] : $vars['lastdate'];
    $vars['keyword'] = (!empty($vars['keyword'])) ? $vars['keyword'] : $vars['lastkeyword'];
    if(!$vars['date'] && !$vars['keyword'])$vars['date'] = date("Y-m-d", strtotime("yesterday"));
    
    $random = rand();
    $id = "cv$random";

    //if(!elgg_is_logged_in())$vars['bare'] = true;
    
    if($vars['selectedsegment']){
        $vars['selectedsegment'] = is_object($vars['selectedsegment']) ? $vars['selectedsegment'] : get_entity($vars['selectedsegment']);
        $vars['date'] = $vars['selectedsegment']->segment_date;
        $vars['guid'] = $vars['selectedsegment']->container_guid;
        $class = "moduleselected";
    }else{
        $founddate = 0;
        unset($es);
        unset($d);
        while($founddate < $CONFIG->dayspassed){
            unset($es);
            unset($d);
            $opts['metadata_name_value_pairs'] = array(
                array('name' => 'segment_date', 'value' => $vars['date']),    
                array('name' => 'status', 'value' => "published")    
            );
            $opts['container_guid'] = $vars['guid'];
            $opts['limit'] = 1;
            if($es = elgg_get_entities($opts)){
                break;
            }else{
                $founddate++;
                $d = new DateTime($vars['date']);
                $d->modify( '-1 day' );
                $vars['date'] = $d->format("Y-m-d");
            }
        }
        $vars['date'] = $es[0]->segment_date;
    }    

    
    //$channel_guid = get_input('channel_guid');
    $channel_guid = $vars['guid'];
    $channel = $vars['channel'] ? $vars['channel'] : get_entity($channel_guid);

    //$channel_logo = elgg_view_list_item($channel, $vars);
    $channel_logo = "<img src=\"".$channel->getIconURL("small")."\">";
    //$channel_logo = $channel->getIconURL();
    $channel_name = "<span class=\"channelname\">{$channel->name}</span>";

    if($vars['bare'] == true){
        $datepicker = "<span class=\"cv_datepicker\">{$vars['date']}</span>";    
    }else{        
        $datepicker = elgg_view('input/date', array(
        //    'value' => $vars['segment_date'],
            'name' => 'date',
            'class' => 'cv_datepicker',
            'placeholder' => elgg_echo('clickdate...'),
            'data-parentid' => $id,
            'data-guid' => $channel_guid,
            'data-pub' => prep_pipe_string(array("cv.datechange.cv$random")),
            'data-noForm' => "true",
            'value' => $vars['date']
        ));

        $keyworder = elgg_view('input/dropdown', array(
            'name' => 'keyword',
            'class' => 'cv_keyword elgg-input-autocomplete',
            'data-placeholder' => elgg_echo('enterkeyword...'),
            'match_owner' => 0,
            'data-parentid' => $id,
            'data-guid' => $channel_guid,
            'data-pub' => prep_pipe_string(array("cv.keywordchange.cv$random")),
            'data-noForm' => "true",
            'options' => array("") + get_all_tags(),
            'value' => $vars['keyword']
        ));
        $solo_module = '<a href="#" data-pub="|cv.solomodule|" class="solo_module">O</a>';
        $close_module = '<a href="#" data-pub="|cv.closemodule|" class="close_module">X</a>';
        $noresults = '<a class="noresults">'.elgg_echo('noresults').'</a>';
        $show_all = '<a href="#" class="show_all_segments">'.elgg_echo('showall').'</a>';
        $selectasegment = '<a class="selectasegment">'.elgg_echo('selectasegment').'</a>';
    }
        
    $vars['parentid'] = $id;
    $vars['data-sub'] = array("cv.datechange.cv$random", "cv.keywordchange.cv$random");
    $relevant_segments = view_segmentselect_segments($vars);    
    
    add_extra_obj(array("moduleSelector" => "#cv$random"));
    
return <<<___HTML
<div id="$id" class="channelviewer_module $class" data-guid="$channel_guid" data-date="{$vars['date']}" data-keyword="{$vars['keyword']}">
        $solo_module
        $close_module
    <div class="cvmoduleheader">
        $channel_logo
        $channel_name
        $datepicker
        $keyworder
    </div>
    $relevant_segments
    <div class="cvmodulefooter">
        $show_all
        $noresults
    </div>
</div>
___HTML;
            
}

function view_segmentselect_segments($vars){
    if(empty($vars['lastdate']))unset($vars['lastdate']);
    if(empty($vars['lastkeyword']))unset($vars['lastkeyword']);
    $vars['date'] = (!empty($vars['date'])) ? $vars['date'] : $vars['lastdate'];
    $vars['keyword'] = (!empty($vars['keyword'])) ? $vars['keyword'] : $vars['lastkeyword'];
    
    $options['container_guid'] = (int)$vars['guid'];
    unset($vars['guid']);
    $options['type'] = "object";
    $options['subtype'] = "segment";
    $options['limit'] = 100;

    if(!empty($vars['date'])){
        global $CONFIG;
        $options['metadata_name_value_pairs'] = array(
            array('name' => 'segment_date', 'value' => $vars['date']),    
            array('name' => 'status', 'value' => "published")    
        );
        $options['order_by_metadata'] = array('name' => 'sequence', 'direction' => 'ASC', 'as' => 'integer');
        
        $vars['items'] = elgg_get_entities_from_metadata($options);
        $vars['broadcast_type'] = elgg_echo('segment:broadcast_type:evening');
        $vars['broadcast_types'] = (!empty($vars['broadcast_type']) && in_array($vars['broadcast_type'], $CONFIG->broadcast_types)) ? array($vars['broadcast_type']) : $CONFIG->broadcast_types;
        $relevant_segments_body = elgg_view('page/components/cv_listdate', $vars);                  
    }elseif(!empty($vars['keyword'])){
/*        $options['order_by_metadata'] = array('name' => 'segment_date', 'direction' => 'DESC', 'as' => 'text');
        $options['metadata_name_value_pairs'][] =  array(
            'name' => 'tags',
            'value' => $vars['keyword']
        );    
        $options['metadata_name_value_pairs'][] =  array(
            'name' => 'events',
            'value' => $vars['keyword']
        );    
        $options['metadata_name_value_pairs'][] =  array(
            'name' => 'universal_categories',
            'value' => $vars['keyword']
        );    
        $options['metadata_name_value_pairs_operator'] = 'OR';
        $options['bilbo'] = true;
        $vars['items'] = elgg_get_entities_from_metadata($options);
        */
        $vars['items'] = get_segs_by_keyword($vars['keyword'], $options['container_guid']);
        $relevant_segments_body = elgg_view('page/components/cv_listkeyword', $vars);        
                          
    }

    $vars['data-sub'] = array("cv.datechange.{$vars['parentid']}", "cv.keywordchange.{$vars['parentid']}");
    $vars['data-noform'] = "true";
    $vars['data-refresh'] = __FUNCTION__;
    $vars['data-prejs'] = array("prep_segmentrefresh", "freeze");
    $vars['data-postjs'] = array("post_segmentrefresh");
    $vars['data-hoverjs'] = array("togglejsppopup3");
    $extra = prep_pubsub_string($vars);

    $html = "<div class=\"returned_segments\" $extra>";
    $html.= $relevant_segments_body;
    $html.= "</div>";                
    
    $results = $relevant_segments_body ? "true" : "false";

    add_extra_obj(array("results" => $results));    

//    json_encode($html);
    
    return $html;
    
}

function view_cv_segment_comments($vars){
    $guid = ($vars['entity_guid']) ? $vars['entity_guid'] : $vars['guid'];
//    $guid = $vars['entity_guid'];
    $segment = get_entity($guid);    
    $options = array(
        'limit' => 999999,
        'class' => 'cv-segment-comments',
        'data-sub' => "{$segment->getSubType()}.postcomment.$guid",
        'data-refresh' => __FUNCTION__,
        'data-postjs' => "refreshJSP",
        'noicon' => true,
        'order_by'    =>    'n_table.time_created desc',                    
    );

    $vars = array_merge($vars, $options);

    //if ajax dont return add comment
    return $vars['refresh'] == __FUNCTION__ ? elgg_view_comments($segment, false, $vars) : elgg_view_comments($segment, true, $vars);
}
