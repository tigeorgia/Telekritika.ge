<?php
/**
 * Edit commentary form
 *
 * @package Commentary
 */

if($vars['original_guid']){
    $origcommentary = get_entity($vars['original_guid']);        
}elseif($vars['guid']){
    $commentary = get_entity($vars['guid']);
    $vars['entity'] = $commentary;    
}

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="message warning">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

/*if ($vars['guid'] && elgg_is_admin_logged_in()) {
	// add a delete button if editing
	$delete_url = "action/commentary/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/confirmlink', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete elgg-state-disabled float-alt'
	));
} */

    $save_button = elgg_view('input/submit', array(
        'value' => elgg_echo('save'),
        'name' => 'save',
        'data-pub' => prep_pipe_string("cv.savecommentary"),
    ));    

$action_buttons = $save_button . $preview_button . $delete_link;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
    'name' => 'title',
    'id' => 'commentary_title',
    'value' => $vars['title']
));    
   /*
$excerpt_label = elgg_echo('commentary:excerpt');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'commentary_excerpt',
	'value' => html_entity_decode($vars['excerpt'], ENT_COMPAT, 'UTF-8')
));*/

$body_input = elgg_view('input/longtextnomce', array(
	'name' => 'description',
	'id' => 'commentary_description',
	'value' => $vars['description'],
//    'placeholder' => elgg_echo('becomeacritic')
));

$save_status = elgg_echo('commentary:save_status');
if ($vars['guid']) {
	$entity = get_entity($vars['guid']);
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('commentary:never');
}
$status_label = elgg_echo('commentary:status');
$status_input = elgg_view('input/dropdown', array(
    'name' => 'status',
    'id' => 'commentary_status',
    'value' => $vars['status'],
    'options_values' => array(
        'draft' => elgg_echo('commentary:status:draft'),
        'published' => elgg_echo('commentary:status:published'),
        'featured' => elgg_echo('commentary:status:featured'),
        'dailystory' => elgg_echo('commentary:status:dailystory'),
    )
));

$channels = elgg_get_entities(
    array(
        'type' => 'group',
        'full_view' => false,
        'subtype' => 'channel'
    )
);   

foreach($channels as $key => $channelitem){
    $options['guid'] = $channelitem->guid;    
    $lastnight .= view_segmentselect_module($options);    
}


// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
//$status_input = elgg_view('input/hidden', array('name' => 'status','value' => 'published'));

$channelbar = get_channelbar();

//JS stuff
$available_tags = "elgg.autocomplete_cv.url = " . json_encode(get_all_tags($options)) . ";"; //"['". implode("', '", get_all_tags($options)) . "']";
$linked_segments = get_linked_segments_guids($vars['entity']);
foreach($linked_segments  as $val){
    $linked[$val] = get_entity($val)->title;
}

$linked_segments_label = elgg_echo('linked_segments');
$linked_segments_input = elgg_view('input/dropdownmulti', array(
    'size' => 5,
    'name' => 'linked_segments[]',
    'id' => 'linked_segment_status',
    'value' => $linked_segments,
    'options_values' => $linked
));
    
echo <<<HTML

<div id="commentary_input_wrapper">
    $body_input <br />
    $title_label $title_input        <br>
    $action_buttons <br>
</div>

<div>
    $linked_segments_label
    $linked_segments_input
</div>
<div>
    $status_label
    $status_input
</div>
<div>
    $save_status
    $saved
</div>
<div class="elgg-foot">
    $guid_input
    $container_guid_input                  
</div>                                           

<div id="hidden_segments"></div>

                                
HTML;
