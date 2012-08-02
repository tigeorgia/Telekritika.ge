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
$html = "";
//smail("items2", serialize($items));
if (is_array($items) && count($items) > 0) {
	foreach ($items as $item) {
        $likes = likes_count($item);
        $dislikes = dislikes_count($item);
        $html .= "<h3 data-segmentguid=\"{$item->guid}\" class=\"cv_header ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top\"><a href=\"#\">{$item->guid} - {$item->title} {$likes} likes, {$dislikes} dislikes</a></h3>";
		$html .= "<div class=\"cv_content ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active\">";
        $html .= $item->description;
        $html .= (!empty($item->videolink) && $item->videolink != "http://" && $item->videolink != "http:///")?"<br /><a target=\"_blank\" class=\"videolink\" href='{$item->videolink}'>VideoLink</a>":"";
        $html .= "</div>";
	}
}
echo $html;