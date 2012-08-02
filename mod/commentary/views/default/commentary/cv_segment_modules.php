<?

$page = $vars['page'];

//$page = array_values(array_unique(array_filter($page)));
$nomore = array();

for($y=0,$x=0,$count=count($page);$x<$count && $y < $CONFIG->maxChannelsInChannelViewer; $x++){
    $thispage = $page[$x];
    if($thispage == "lastnight"){
        $template = $thispage;        
    }elseif(is_numeric($thispage)){
        $entity = get_entity($thispage);
        if(!in_array($thispage, $nomore) && $entity){
            if(elgg_instanceof($entity, "object", "segment")){
                $template = "segment";
                $segment = $entity;
            }elseif(elgg_instanceof($entity, "object", "commentary")){
                $template = "commentary";                
                $commentary = $entity;
            }
            array_push($nomore,$thispage);
        }        
    }else{
        $testchannels = get_groups_by_name($thispage);
        if($testchannels && count($testchannels) == 1){
            $channel = $testchannels[0];
            $template = "date";
            $date = date("Y-m-d", strtotime("yesterday"));
            if($x < $count-1){
                $xx = x+1;
                $that = $page[$xx];
                if(substr_count($that, "-") == 2){
                    if(is_numeric(str_replace("-", "", $that)) && strlen($that) == 10){
                        //is date
                        $date = $that;                        
                        if($xx < $count-1){
                            $xxx = $xx+1;
                            $that2 = $page[$xxx];
                            if(in_array($that2, $CONFIG->broadcast_types)){
                                $template = "broadcast";
                                $broadcast = $that2;
                            }
                        }
                    }
                }elseif(in_array($that, get_all_tags())){
                    $template = "keyword";
                    $keyword = $that;
                }   
            }
        }        
    }
    switch($template){
        case "lastnight":
            $channels = elgg_get_entities(
                array(
                    'type' => 'group',
                    'full_view' => false,
                    'subtype' => 'channel'
                )
            );   

            foreach($channels as $key => $channel){
                $options['guid'] = $channel->guid;    
                $options['date'] = date("Y-m-d", strtotime("yesterday"));    
                $collected .= view_segmentselect_module($options);    
                $y++;
            }
            unset($channels);
        break;

        case "broadcast":
            $options['broadcast_type'] = strtolower($broadcast);    
        case "date":
            $options['guid'] = $channel->guid;    
            $options['date'] = $date;    
            $collected .= view_segmentselect_module($options);    
            $y++;
            unset($date);
        break;

        case "keyword":
            $options['guid'] = $channel->guid;    
            $options['keyword'] = $keyword;    
            $collected .= view_segmentselect_module($options);    
            $y++;
            unset($keyword);
        break;

        case "commentary":
            $linked_segments = $commentary->getEntitiesFromRelationship("linked_segment");
            foreach($linked_segments as $key => $segment){
                $options['selectedsegment'] = $segment;    
                $collected .= view_segmentselect_module($options);    
                $y++;
            }        
            unset($linked_segments);
        break;
        
        case "segment":    
            $options['selectedsegment'] = $segment;    
            $collected .= view_segmentselect_module($options);    
            $y++;
            unset($segment);
        break;
        
    }    
    unset($options);
    unset($template);
    unset($channel);
}

echo <<<HTML
<div id="cv_segmentselect_module_holder" data-sub="|cv.addmodule|" data-add="view_segmentselect_module" data-postjs="|create_module|">
    $collected
</div>
                                
HTML;
