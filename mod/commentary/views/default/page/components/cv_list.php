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

    foreach($vars['broadcast_types'] as $broadcast_type){
        foreach($items as $key => $segment){
            $x=0;
            if($vars['broadcast_types'][$segment->broadcast_type] == $broadcast_type){
                $x++;                  
                $html.= ($x==1)?"<ul><li class=\"broadcast\">$broadcast_type</li>":"";
                $html.= "<li>seg:". $segment->title . "</li>";
                unset($items[$key]);
                if(empty($items))break;
            }
        }
        $html.= ($x>0)?"</ul>":"";      
        if(empty($items))break;
    }        

    echo $html;
//smail("itmcv", $html);
}

