<?php
/**
 * Edit commentary form
 *
 * @package Commentary
 */

$commentary = get_entity($vars['guid']);
$vars['entity'] = $commentary;    

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

if(elgg_is_logged_in()){
    $save_button = elgg_view('input/submit', array(
        'value' => elgg_echo('save'),
        'name' => 'save',
        'data-pub' => prep_pipe_string("cv.savecommentary"),
    ));    
}else{
    $save_button = elgg_view('input/submit', array(
        'value' => elgg_echo('save'),
        'name' => 'save',
        'data-onlyjs' => prep_pipe_string(array("mustlogin")),
    ));    
}

$action_buttons = $save_button . $preview_button . $delete_link;

if(elgg_is_admin_logged_in()){
    $title_label = elgg_echo('title');
    $title_input = elgg_view('input/text', array(
        'name' => 'title',
        'id' => 'commentary_title',
        'value' => $vars['title']
    ));    
}

$body_input = elgg_view('input/longtextnomce', array(
	'name' => 'description',
	'id' => 'commentary_description',
	'value' => $vars['description'],
    'placeholder' => elgg_echo('becomeacritic')
));



// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
$status_input = elgg_view('input/hidden', array('name' => 'status','value' => 'published'));

$channelbar = get_channelbar();

//JS stuff
$available_tags = "elgg.autocomplete_cv.url = " . json_encode(get_all_tags($options)) . ";"; //"['". implode("', '", get_all_tags($options)) . "']";

if (!elgg_is_logged_in()) {                             
    $captcha = captchacrap();
}    

    
echo <<<HTML

$channelbar

<div id="commentary_input_wrapper">
    $body_input <br />
    $action_buttons
    $title_label $title_input   
</div>
<div class="elgg-foot">
    $guid_input
    $container_guid_input
    $status_input
</div>                                           

<div id="hidden_segments"></div>


<script type="text/javascript">
    elgg.provide('elgg.autocomplete_cv');
    $available_tags
</script>


HTML;
