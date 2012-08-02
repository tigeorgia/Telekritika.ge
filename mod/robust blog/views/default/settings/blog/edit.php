<?php
 if ($vars['entity']) {
        if (!$vars['entity']->trackback) {$vars['entity']->trackback = "no";}
        if (!$vars['entity']->featured) {$vars['entity']->featured = "no";}
        if (!$vars['entity']->featuredmine) {$vars['entity']->featuredmine = "no";}
        if (!$vars['entity']->featuredfriend) {$vars['entity']->featuredfriend = "no";}
        if (!$vars['entity']->featuredcentral) {$vars['entity']->featuredcentral = "no";}
        if (!$vars['entity']->watch) {$vars['entity']->watch = "no";}
        if (!$vars['entity']->top) {$vars['entity']->top = "no";}
        if (!$vars['entity']->related) {$vars['entity']->related = "no";}
        if (!$vars['entity']->groupcontents) {$vars['entity']->groupcontents = "no";}
        if (!$vars['entity']->iconoverwrite) {$vars['entity']->iconoverwrite = "no";}

    }
?>


<p>	
<?php 
	echo elgg_echo('blog:settings:trackback:activate') . "<br>";
	echo elgg_echo('blog:settings:trackback:help') . "<br>";
?>
<select name="params[trackback]">
  <option value="no" <?php if($vars['entity']->trackback == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->trackback != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select> 
</p>
<br>
<p>	
<?php 
	echo elgg_echo('blog:settings:featured:activate') . "<br>";
	echo elgg_echo('blog:settings:featured:help') . "<br>";
?>
<select name="params[featured]">
  <option value="no" <?php if($vars['entity']->featured == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->featured != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select> 
</p>
<br>
<?php
$feature = get_plugin_setting('featured','blog');
if ($feature != 'no'){
?>
<p>	
<?php
	echo elgg_echo('blog:settings:featured:title') . "<br>";
	echo elgg_echo('blog:settings:featured:mine') . "<br>";
?>
<select name="params[featuredmine]">
  <option value="no" <?php if($vars['entity']->featuredmine == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->featuredmine != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select> 
<br>	
<?php 
	echo elgg_echo('blog:settings:featured:friend') . "<br>";
?>
<select name="params[featuredfriend]">
  <option value="no" <?php if($vars['entity']->featuredfriend == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->featuredfriend != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select> 
<br>
<?php 
	echo elgg_echo('blog:settings:featured:central') . "<br>";
?>
<select name="params[featuredcentral]">
  <option value="no" <?php if($vars['entity']->featuredcentral == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->featuredcentral != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select> 
</p>
<br><hr>
<?php } ?>


<p>	
<?php 
	echo elgg_echo('blog:settings:watch:activate') . "<br>";
	echo elgg_echo('blog:settings:watch:help') . "<br>";
?>
<select name="params[watch]">
  <option value="no" <?php if($vars['entity']->watch == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->watch != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select> 
</p>

<p>	

<?php
$watch = get_plugin_setting('watch','blog');
		if ($watch != 'no'){ 
	echo elgg_echo('blog:settings:top:activate') . "<br>";
	echo elgg_echo('blog:settings:top:help') . "<br>";
?>
<select name="params[top]">
  <option value="no" <?php if($vars['entity']->top == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->top != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select>
</p>
<br>
<hr>
<?php } ?>

<p>	
<?php 
	echo elgg_echo('blog:settings:related:activate') . "<br>";
	echo elgg_echo('blog:settings:related:help') . "<br>";
?>
<select name="params[related]">
  <option value="no" <?php if($vars['entity']->related == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->related != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select> 
</p>

<p>	
<?php 
	echo elgg_echo('blog:settings:group_contents:activate') . "<br>";
	echo elgg_echo('blog:settings:group_contents:help') . "<br>";
?>
<select name="params[groupcontents]">
  <option value="no" <?php if($vars['entity']->groupcontents == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->groupcontents != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select> 
</p>

<p>	
<?php 
	echo elgg_echo('blog:settings:iconoverwrite:activate') . "<br>";
	echo elgg_echo('blog:settings:iconoverwrite:help') . "<br>";
?>
<select name="params[iconoverwrite]">
  <option value="no" <?php if($vars['entity']->iconoverwrite == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
  <option value="yes" <?php if($vars['entity']->iconoverwrite != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
</select> 
</p>