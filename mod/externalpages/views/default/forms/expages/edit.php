<?php
/**
 * Edit form body for external pages
 * 
 * @uses $vars['type']
 * 
 */

$type = $vars['type'];

//grab the required entity
$page_contents = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => $type,
	'limit' => 1,
));

if ($page_contents) {
	$description = $page_contents[0]->description;
	$guid = $page_contents[0]->guid;
    $contents_array = unserialize($description);
} else {
	$description = "";
	$guid = 0;
}


foreach($CONFIG->translations as $key => $val){
    // set the required form variables
    $input_area .= 
    "<p>&nbsp;</p><h2>"
    .elgg_echo("translation_editor:{$key}")
    ."<h2>"
    .elgg_view('input/longtext', array(
        'name' => "expagescontent[{$key}]",
        'value' => $contents_array[$key],
    ));        
}

$submit_input = elgg_view('input/submit', array(
	'name' => 'submit',
	'value' => elgg_echo('save'),
));
$hidden_type = elgg_view('input/hidden', array(
	'name' => 'content_type',
	'value' => $type,
));
$hidden_guid = elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $guid,
));

$external_page_title = elgg_echo("expages:$type");

//construct the form
echo <<<EOT
<div class="mtm">
	<label>$external_page_title</label>
	$input_area
</div>
<div class="elgg-foot">
$hidden_value
$hidden_type
$submit_input
<div>
EOT;

