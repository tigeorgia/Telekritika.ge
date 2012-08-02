<?php
/**
 * Edit commentary form
 *
 * @package Commentary
 */

$requested_date = get_input('requested_date');
//$requested_date = str_replace("-", "", get_input('requested_date'));
$keyword = get_input('keyword');
$channel_guid = get_input('channel_guid');
$channel = get_entity($channel_guid);

$channel_logo = elgg_view_list_item($channel, $vars);

$options['container_guid'] = $channel_guid;
$options['tags'] = $keyword;
$options['type'] = "object";
$options['subtype'] = "segment";
$options['limit'] = 100;
$options['metadata_names'] = array('broadcast_type', 'sequence')
$options['metadata_name_value_pairs'][] = array(
    array('segment_date' => $requested_date)    
);
$options['metadata_values'] = array(
    $keyword    
);
//$options['order_by_metadata'] = array('name' => 'broadcast_type', 'direction' => 'ASC', 'as' => 'text');

$relevant_segments = elgg_list_entities_from_metadata($options);

//elgg_get_entities()

echo <<<___HTML

<div class="channelviewer_module" data-channelguid="$channel_guid">
    <div>
    $channel_logo
    </div>

    <div class="returned_segments>
        $relevant_segments
    </div>
</div>
___HTML;
