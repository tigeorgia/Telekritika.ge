<?php
/**
 * View a list of items
 *
 * @package Elgg
 *
 * @uses $vars['items']       Array of ElggEntity or ElggAnnotation objects
 * @uses $vars['offset']      Index of the first list item in complete list
 * @uses $vars['limit']       Number of items per page
 * @uses $vars['count']       Number of items in the complete list
 * @uses $vars['base_url']    Base URL of list (optional)
 * @uses $vars['pagination']  Show pagination? (default: true)
 * @uses $vars['position']    Position of the pagination: before, after, or both
 * @uses $vars['full_view']   Show the full view of the items (default: false)
 * @uses $vars['list_class']  Additional CSS class for the <ul> element
 * @uses $vars['item_class']  Additional CSS class for the <li> elements
 */

$items = $vars['items'];
//smail("items", $items);

$html = "";
if (is_array($items) && count($items) > 0) {
//smail("breoadcast",$vars['broadcast_types']);

    $vars['by'] = "broadcast";
    $options['full_view'] = false;    
    $vars['module_view'] = true;

    if($vars['bare'] && $vars['selectedsegment']){
        $html.= "<div class=\"segments_wrapper segments_wrapper_broadcast\">";
            foreach($items as $key => $segment){
                if($segment->guid == $vars['selectedsegment']->guid){
                    $html.= elgg_view_list_item($segment, $vars);
                }
            }
        $html.= "</div>";                              
    }else{        
        $js = prep_pipe_string(array("togglesegmenttype"));
        //$js3 = prep_pipe_string(array("togglejsppopup3"));

        global $countcomments;
        global $countlikes;
        global $countdislikes;
        $countcomments = 0;
        $countlikes = 0;
        $countdislikes = 0;
        $back = $items;
        $end = count($items);
        foreach($vars['broadcast_types'] as $broadcast_type){
            $x=0;
            $duration=0;
            foreach($items as $key => $segment){
                if($vars['broadcast_types'][$segment->broadcast_type] == $broadcast_type){
                    if($x==0){
                        $html.="<div class=\"segments_wrapper segments_wrapper_broadcast\">";     
                        $html.="!!!SHIV!!!";
                        $broadcast_date = $segment->segment_date;
                        $starttime = $segment->segment_start_hour . ":" . $segment->segment_start_minute . ":" . $segment->segment_start_second;
                    }
                    $duration += (int)$segment->duration;
//                    $html.= ($x==0)?"<div class=\"segments_wrapper segments_wrapper_broadcast\"><a href=\"#\" data-onlyjs=\"$js\" class=\"segments_type segments_type_broadcast\"><span>-</span>$broadcast_type</a>":"";
                    $html.= elgg_view_list_item($segment, $vars);
                    $x++;                  
                    $final = $key;
                    unset($items[$key]);
                    if(empty($items))break;
                }
            }
            $html.= ($x>0)?"</div>":"";      
            if(empty($items))break;
        }
        $segment = $back[$final];
        $endtime = $segment->segment_end_hour . ":" . $segment->segment_end_minute . ":" . $segment->segment_end_second;
        if($endtime == "00:00:00" || $endtime == "00:00:"){unset($starttime, $endtime);}
        $starttime = strlen($starttime) == 6 ? $starttime."00" : $startime;
        $endtime = strlen($endtime) == 6 ? $endtime."00" : $endtime;
        $duration = return_duration_in_time($duration);
        $replacer = "<a href=\"#\" data-onlyjs=\"$js\" class=\"segments_type segments_type_broadcast\">";
        $replacer .= $starttime ? "$starttime - $endtime ($duration)" : " ($duration)";
        $replacer .= "<span class=\"sliderthumbs\">"; 
        $replacer .= elgg_view('input/thumbs/up-left-normal', array("class"=>"tinythumb nohl")) . $countlikes;
        $replacer .= elgg_view('input/thumbs/down-right-normal', array("class"=>"tinythumb nohl")) . $countdislikes;
        $replacer .= elgg_view('input/comments/comments-normal', array("class"=>"tinycomment")) . $countcomments;
        $replacer .= "</span></a>";
        $html = str_replace("!!!SHIV!!!", $replacer, $html);           
    }
    echo $html;
}

