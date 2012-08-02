<?php 

?>
<p>
	<?php echo elgg_echo("language_selector:admin:settings:min_completeness"); ?><br />
	<input type="text" name="params[min_completeness]" value="<?php echo $vars['entity']->min_completeness; ?>" size="5" />
	<br />
	
	<?php echo elgg_echo('language_selector:admin:settings:show_in_header'); ?>
	<select name="params[show_in_header]">
		<option value="yes" <?php if ($vars['entity']->show_in_header == 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
		<option value="no" <?php if ($vars['entity']->show_in_header != 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
	</select>
	<br />
	
	<?php echo elgg_echo('language_selector:admin:settings:autodetect'); ?>
	<select name="params[autodetect]">
		<option value="yes" <?php if ($vars['entity']->autodetect == 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
		<option value="no" <?php if ($vars['entity']->autodetect != 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
	</select>
	<br />
	
	<?php echo elgg_echo('language_selector:admin:settings:show_images'); ?>
	<select name="params[show_images]">
		<option value="yes" <?php if ($vars['entity']->show_images == 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
		<option value="no" <?php if ($vars['entity']->show_images != 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
	</select>
	<br />
</p>	