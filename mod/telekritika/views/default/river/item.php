<?php
/**
 * Layout of a river item
 *
 * @uses $vars['item'] ElggRiverItem
 */

$item = $vars['item'];
$subject = $item->getObjectEntity();
global $lasttimestamp;
$timestamp = elgg_get_friendly_time($vars['item']->getPostedTime());
if($timestamp != $lasttimestamp){
    $lasttimestamp = $timestamp;
    $timestamp = "<div class=\"elgg-river-timestamp\">$timestamp</div> ";
}else{
    unset($timestamp);
} 
echo $timestamp . "<a class=\"riverblock\" href=\"{$subject->getURL()}\">";
$vars['nourl'] = true;
echo elgg_view('page/components/image_block', array(
	'image' => elgg_view('river/elements/image', $vars),
	'body' => elgg_view('river/elements/body', $vars),
	'class' => 'elgg-river-item',
    'nourl' => true,
));
echo "</a>";