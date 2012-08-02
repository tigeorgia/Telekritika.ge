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
$channel = get_entity($channel_guid);

//$channel_logo = elgg_view_list_item($channel, $vars);
$channel_logo = "<img src=\"".$channel->getIconURL("medium")."\">";
//$channel_logo = $channel->getIconURL();
$channel_name = $channel->name;

$datepicker = elgg_view('input/date', array(
//    'value' => $vars['segment_date'],
    'class' => 'cv_datepicker',
    'placeholder' => elgg_echo('clickdate...'),
));

$keyword = elgg_view('input/autocomplete_cv', array(
    'class' => 'cv_keyword',
    'placeholder' => elgg_echo('enterkeyword...'),
    'match_owner' => 0
));

$show_all = '<a href="#" class="show_all_segments">'.elgg_echo('showall').'</a>';

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
//$options['order_by_metadata'] = array('name' => 'broadcast_type', 'direction' => 'ASC', 'as' => 'text');

//$options['metadata_values'] = array(
//    $keyword    
//);
//                        elgg_get_entities()

//unset($vars);
$vars['items'] = elgg_get_entities_from_metadata($options);
//$count = count($vars['items']);
$relevant_segments_body = elgg_view('page/components/accordion', $vars);                  

$relevant_segments = ($relevant_segments_body)?'<div class="accordion">'.$relevant_segments_body.'</div>':elgg_echo('noresults');

$close_module = '<a href="#" class="close_module">X</a>';

echo <<<___HTML
<div class="channelviewer_module" data-channelguid="$channel_guid">
    $close_module
    <div>
        $channel_logo<br />$channel_name
    </div>

    <div>
        $datepicker $keyword
    </div>

    <div>
        $show_all
    </div>
    
    <div class="returned_segments">
        $relevant_segments
    </div>
</div>
___HTML;
