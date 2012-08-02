<?php
/**
 * Group edit form
 * 
 * @package ElggGroups
 */

// new groups default to open membership
if (isset($vars['entity'])) {
	$membership = $vars['entity']->membership;
	$access = $vars['entity']->access_id;
	if ($access != ACCESS_PUBLIC && $access != ACCESS_LOGGED_IN) {
		// group only - this is done to handle access not created when group is created
		$access = ACCESS_PRIVATE;
	}
} else {
	$membership = ACCESS_PUBLIC;
	$access = ACCESS_PUBLIC;
}

$subtype = $vars['subtype'];

?>
<div>
	<label><?php echo elgg_echo("{$subtype}s:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>
<div>
	<label><?php echo elgg_echo("{$subtype}s:name"); ?></label><br />
	<?php echo elgg_view("input/text", array(
		'name' => 'name',
		'value' => $vars['entity']->name,
	));
	?>
</div>
<?php
$group_profile_fields = elgg_get_config('group');
if ($group_profile_fields > 0) {
	foreach ($group_profile_fields as $shortname => $valtype) {
        if($valtype != "tags"){
		    $line_break = '<br />';
		    if ($valtype == 'longtext') {
			    $line_break = '';
		    }
		    echo '<div><label>';
		    echo elgg_echo("{$subtype}s:{$shortname}");
		    echo "</label>$line_break";
		    echo elgg_view("input/{$valtype}", array(
			    'name' => $shortname,
			    'value' => $vars['entity']->$shortname,
		    ));
		    echo '</div>';
        }
	}
}


?>
<div>
    <label><?php echo elgg_echo("channels:autourl_root"); ?></label><br />
    <?php 
    
    $autourl_root = (isset($vars['entity']->autourl_root)) ? $vars['entity']->autourl_root : $CONFIG->myvideo_autourl_root;

    echo elgg_view("input/text", array(
        'name' => 'autourl_root',
        'value' => $autourl_root,
    ));
    ?>
</div>
<?
 
echo elgg_view('input/hidden', array(
    'name' => 'vis',
    'value' => $access,
));

 
if (elgg_get_plugin_setting('hidden_groups', 'groups') == 'yes') {
	$this_owner = $vars['entity']->owner_guid;
	if (!$this_owner) {
		$this_owner = elgg_get_logged_in_user_guid();
	}
	$access_options = array(
		ACCESS_PRIVATE => elgg_echo($subtype.'s:access:group'),
		ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
		ACCESS_PUBLIC => elgg_echo("PUBLIC")
	);
?>

			<?php echo elgg_echo($subtype.'s:visibility'); ?><br />
			<?php echo elgg_view('input/access', array(
				'name' => 'vis',
				'value' =>  $access,
				'options_values' => $access_options,
			));
            

			?>

<?php 	
}

$tools = elgg_get_config($subtype.'_tool_options');
if ($tools) {
	usort($tools, create_function('$a,$b', 'return strcmp($a->label,$b->label);'));
	foreach ($tools as $group_option) {
		$group_option_toggle_name = $group_option->name . "_enable";
		if ($group_option->default_on) {
			$group_option_default_value = 'yes';
		} else {
			$group_option_default_value = 'no';
		}
		$value = $vars['entity']->$group_option_toggle_name ? $vars['entity']->$group_option_toggle_name : $group_option_default_value;
?>	
		<?php echo elgg_view("input/hidden", array(
			"name" => $group_option_toggle_name,
			"value" => $group_option_default_value,			
		));
		?>
<?php
	}
}
?>
<div class="elgg-foot">
<?php

if (isset($vars['entity'])) {
	echo elgg_view('input/hidden', array(
		'name' => 'group_guid',
		'value' => $vars['entity']->getGUID(),
	));
}

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

if (isset($vars['entity'])) {
	$delete_url = 'action/groups/delete?guid=' . $vars['entity']->getGUID();
	echo elgg_view('output/confirmlink', array(
		'text' => elgg_echo($subtype.'s:delete'),
		'href' => $delete_url,
		'confirm' => elgg_echo($subtype.'s:deletewarning'),
		'class' => 'elgg-button elgg-button-delete float-alt',
	));
}
?>
</div>
