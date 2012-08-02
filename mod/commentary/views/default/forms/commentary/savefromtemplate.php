<?php
/**
 * Edit commentary form
 *
 * @package Commentary
 */

$commentary = get_entity($vars['guid']);

$channelbar = get_channelbar();

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="message warning">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

if(elgg_is_logged_in()){
    $save_button = elgg_view('input/submit', array(
        'value' => elgg_echo('save'),
        'name' => 'save',
//        'data-pub' => prep_pipe_string("cv.savecommentary"),
        'data-onlyjs' => prep_pipe_string("update_forwarder_submit"),
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

$status_input = elgg_view('input/dropdown', array(
    'name' => 'status',
    'id' => 'commentary_status',
    'value' => 'dailystory',
    'options_values' => array(
        'draft' => elgg_echo('commentary:status:draft'),
        'published' => elgg_echo('commentary:status:published'),
        'featured' => elgg_echo('commentary:status:featured'),
        'dailystory' => elgg_echo('commentary:status:dailystory'),
    )
));

    
/*    $excerpt_label = elgg_echo('commentary:excerpt');
    $excerpt_input = elgg_view('input/text', array(
	    'name' => 'excerpt',
	    'id' => 'commentary_excerpt',
	    'value' => html_entity_decode($vars['excerpt'], ENT_COMPAT, 'UTF-8')
    ));
*/
}else{
    $status_input = elgg_view('input/hidden', array('name' => 'status','value' => 'published'));

}

$body_input = elgg_view('input/longtextnomce', array(
	'name' => 'description',
	'id' => 'commentary_description',
	'value' => $vars['description'],
    'placeholder' => elgg_echo('becomeacritic')
));

/*$save_status = elgg_echo('commentary:save_status');
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
        'published' => elgg_echo('commentary:status:published')
    )
));
   */
    
//}

$generate_link_button = elgg_view('output/url', array(
    'href' => "#",
    'text' => "<img src=\"".elgg_normalize_url("_graphics/link.png")."\">",
    'target' => "_blank",
    'is_action' => false,
    'class' => "cv_generate_link",
    'data-onlyjs' => prep_pipe_string("cv_generate_link"),
));

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_logged_in_user_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => ""));
$forward = elgg_view('input/hidden', array('name' => 'forward', 'value' => ""));

//JS stuff
$available_tags = "elgg.autocomplete_cv.url = " . json_encode(get_all_tags($options)) . ";"; //"['". implode("', '", get_all_tags($options)) . "']";
//elgg_load_js('elgg.autocomplete_cv');
    
        
echo <<<HTML

$channelbar

<div id="commentary_input_wrapper">
    $body_input <br />
    $title_label $title_input
    $status_input        <br>
    $action_buttons
    $generate_link_button
</div>

<div class="elgg-foot">
    $guid_input
    $container_guid_input
    $forward    
</div>                                           

<div id="hidden_segments"></div>

<script type="text/javascript">
    elgg.provide('elgg.autocomplete_cv');
    $available_tags
</script>

HTML;
