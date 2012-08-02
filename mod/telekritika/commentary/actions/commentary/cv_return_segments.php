<?php
/**
 * Edit commentary form
 *
 * @package Commentary
 */
                                     
//$requested_date = str_replace("-", "", get_input('requested_date'));
if($requested_date = get_input('requested_date'))
    $keyword = false;
        else
    $keyword = get_input('keyword');

//smail("date",$requested_date);  
$channel_guid = get_input('channel_guid');
    
$options['container_guid'] = $channel_guid;
$options['type'] = "object";
$options['subtype'] = "segment";
$options['limit'] = 100;
if($requested_date){
    $options['metadata_name_value_pairs'] = array(
        array('name' => 'segment_date', 'value' => $requested_date)    
    );
}elseif($keyword){
    
}

//$options['metadata_names'] = array('broadcast_type', 'sequence');
//$options['metadata_name_value_pairs'] = array();
$options['order_by_metadata'] = array('name' => 'broadcast_type', 'direction' => 'ASC', 'as' => 'text');

//$options['metadata_values'] = array(
//    $keyword    
//);
//                        elgg_get_entities()

//unset($vars);
$vars['items'] = elgg_get_entities_from_metadata($options);
$body = ($vars['items']) ? '<div class="accordion">' . elgg_view('page/components/accordion', $vars) . '</div>' : elgg_echo("noresults");
//$count = count($vars['items']);
echo $body;                                                     