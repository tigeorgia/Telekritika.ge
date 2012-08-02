<?php

    global $CONFIG;

	$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();

	$object = get_entity($vars['item']->object_guid);
/*    if($performed_by->badges_badge != $object->guid){
//        system_message("t".check_entity_relationship($performed_by->guid, "badges", $object->guid));
        $options['views'] = "river/object/badge/award";
        $options['subject_guids'] = $performed_by->guid;
        $options['object_guids'] = $object->guid;
    //    elgg_set_ignore_access(true);            
        elgg_delete_river($options);  
    }
*/
global $lasttimestamp;
$timestamp = elgg_get_friendly_time($vars['item']->getPostedTime());
if($timestamp != $lasttimestamp){
    $lasttimestamp = $timestamp;
    $timestamp = "<div class=\"elgg-river-timestamp\">$timestamp</div> ";
}else{
    unset($timestamp);
} 

    $url_string = "{$CONFIG->wwwroot}badge/{$object->guid}";
    $badge_view = "<img title=\"{$object->title}\" src=\"$url_string\">";
	$badgename = $object->title;
	$string = sprintf(elgg_echo("badges:river:awarded"), $performed_by->name, $badgename) . ' ' . $object->badges_userpoints . ' ' . get_plugin_setting('lowerplural', 'userpoints');

echo $timestamp . "<a href=\"{$performed_by->getURL()}\" class=\"riverblock\">";    
echo elgg_view('page/components/image_block', array(
    'image' => $badge_view,
    'body' => $string,
    'class' => 'elgg-river-item',
    'nourl' => true,
));
echo "</a>"; 

?>
