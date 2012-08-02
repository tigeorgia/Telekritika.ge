<?php

    global $CONFIG;

	$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();

	$object = get_entity($vars['item']->object_guid);
//    if(!is_object($object) || !in_array($object->entity_guid, $performed_by->badges_badges))return false;
/*	if(!check_entity_relationship($performed_by->guid, "badges", $object->guid)){
//        system_message("t".check_entity_relationship($performed_by->guid, "badges", $object->guid));
        $options['views'] = "river/object/badge/awardMonth";
        $options['subject_guids'] = $performed_by->guid;
        $options['object_guids'] = $object->guid;
    //    elgg_set_ignore_access(true);            
        elgg_delete_river($options);  
    }   */
    $badge_url = $object->badges_url;

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
    
    //$object->badges_url   
    $year = date("Y", $object->awardTime);
    $month = date("m", $object->awardTime);
	$thedate = elgg_echo("date:month:$month", array(elgg_echo("of"))) . " " . $year;
    
    $type = elgg_echo("badges:river:awardType:".$object->awardType);
    

    $badge_view = "<img title=\"{$object->title}\" src=\"$url_string\">";
    $badgename = $object->title;
    $string = sprintf(elgg_echo("badges:river:awardedMonth"), $performed_by->name, $badge_view, $type, $thedate) . ' ' . $object->badges_userpoints . ' ' . get_plugin_setting('lowerplural', 'userpoints') . "</a>";
	
echo $timestamp . "<a href=\"{$performed_by->getURL()}\" class=\"riverblock\">";    
echo elgg_view('page/components/image_block', array(
    'image' => $badge_view,
    'body' => $string,
    'class' => 'elgg-river-item',
    'nourl' => true,
));
echo "</a>"; 
