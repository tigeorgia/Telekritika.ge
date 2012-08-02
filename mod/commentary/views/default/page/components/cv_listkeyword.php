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
    $lastdate = $x = 0;
    $count = count($items);
    $vars['by'] = "broadcast";
    $options['full_view'] = false;    
    $vars['module_view'] = true;
    $js = prep_pipe_string(array("togglesegmenttype"));
    //$js3 = prep_pipe_string(array("togglejsppopup3"));
    usort($items, "segment_date_sorter");
    $done = array();
    foreach($items as $key => $segment){
        if(in_array($segment->guid, $done) || $segment->status != "published" )continue;
        if($segment->segment_date != $lastdate){
            $lastdate = $segment->segment_date;
            $html.=($x>0)?"</div>":"";
            $x++; 
            $html.= "<div class=\"segments_wrapper segments_wrapper_keyword\"><a href=\"#\" data-onlyjs=\"$js\" class=\"segments_type segments_type_keyword\"><span>-</span>$lastdate</a>";
//            $html.= "<div class=\"segments_wrapper segments_wrapper_keyword\">";
        }        
        $html.= elgg_view_list_item($segment, $vars);
        array_push($done, $segment->guid);
//        $html.= "<a class=\"segment segment_keyword\" href=\"#\"><input type=\"radio\" />" . $segment->title . "</a>";
    }
    $html.="</div>";
    
    echo $html;
//smail("itmcv", $html);
}

