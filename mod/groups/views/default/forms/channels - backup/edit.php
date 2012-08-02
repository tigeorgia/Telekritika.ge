<?php
/**
 * Channel edit form
 * 
 * @package ElggChannels
 */

// new channels default to open membership
if (isset($vars['entity'])) {
	$membership = $vars['entity']->membership;
	$access = $vars['entity']->access_id;
	if ($access != ACCESS_PUBLIC && $access != ACCESS_LOGGED_IN) {
		// channel only - this is done to handle access not created when channel is created
		$access = ACCESS_PRIVATE;
	}
} else {
	$membership = ACCESS_PUBLIC;
	$access = ACCESS_PUBLIC;
}

?>
<div>
	<label><?php echo elgg_echo("channels:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>
<div>
	<label><?php echo elgg_echo("channels:name"); ?></label><br />
	<?php echo elgg_view("input/text", array(
		'name' => 'name',
		'value' => $vars['entity']->name,
	));
	?>
</div>
<?php

$channel_profile_fields = elgg_get_config('channel');
if ($channel_profile_fields > 0) {
	foreach ($channel_profile_fields as $shortname => $valtype) {
		$line_break = '<br />';
		if ($valtype == 'longtext') {
			$line_break = '';
		}
		echo '<div><label>';
		echo elgg_echo("channels:{$shortname}");
		echo "</label>$line_break";
		echo elgg_view("input/{$valtype}", array(
			'name' => $shortname,
			'value' => $vars['entity']->$shortname,
		));
		echo '</div>';
	}
}
?>

<div>
	<label>
		<?php echo elgg_echo('channels:membership'); ?><br />
		<?php echo elgg_view('input/access', array(
			'name' => 'membership',
			'value' => $membership,
			'options_values' => array(
				ACCESS_PRIVATE => elgg_echo('channels:access:private'),
				ACCESS_PUBLIC => elgg_echo('channels:access:public')
			)
		));
		?>
	</label>
</div>
	
<?php

if (elgg_get_plugin_setting('hidden_channels', 'channels') == 'yes') {
	$this_owner = $vars['entity']->owner_guid;
	if (!$this_owner) {
		$this_owner = elgg_get_logged_in_user_guid();
	}
	$access_options = array(
		ACCESS_PRIVATE => elgg_echo('channels:access:channel'),
		ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
		ACCESS_PUBLIC => elgg_echo("PUBLIC")
	);
?>

<div>
	<label>
			<?php echo elgg_echo('channels:visibility'); ?><br />
			<?php echo elgg_view('input/access', array(
				'name' => 'vis',
				'value' =>  $access,
				'options_values' => $access_options,
			));
			?>
	</label>
</div>

<?php 	
}

$tools = elgg_get_config('channel_tool_options');
if ($tools) {
	usort($tools, create_function('$a,$b', 'return strcmp($a->label,$b->label);'));
	foreach ($tools as $channel_option) {
		$channel_option_toggle_name = $channel_option->name . "_enable";
		if ($channel_option->default_on) {
			$channel_option_default_value = 'yes';
		} else {
			$channel_option_default_value = 'no';
		}
		$value = $vars['entity']->$channel_option_toggle_name ? $vars['entity']->$channel_option_toggle_name : $channel_option_default_value;
?>	
<div>
	<label>
		<?php echo $channel_option->label; ?><br />
	</label>
		<?php echo elgg_view("input/radio", array(
			"name" => $channel_option_toggle_name,
			"value" => $value,
			'options' => array(
				elgg_echo('channels:yes') => 'yes',
				elgg_echo('channels:no') => 'no',
			),
		));
		?>
</div>
<?php
	}
}
?>
<div class="elgg-foot">
<?php

if (isset($vars['entity'])) {
	echo elgg_view('input/hidden', array(
		'name' => 'channel_guid',
		'value' => $vars['entity']->getGUID(),
	));
}

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

if (isset($vars['entity'])) {
	$delete_url = 'action/channels/delete?guid=' . $vars['entity']->getGUID();
	echo elgg_view('output/confirmlink', array(
		'text' => elgg_echo('channels:delete'),
		'href' => $delete_url,
		'confirm' => elgg_echo('channels:deletewarning'),
		'class' => 'elgg-button elgg-button-delete float-alt',
	));
}
?>
</div>
