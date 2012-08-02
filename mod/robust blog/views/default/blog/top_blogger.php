<?php 	 $watch = get_plugin_setting('watch','blog');
if ($watch != 'no'){ 
$top_bloggers = get_entities_by_relationship_count('blogwatcher',$inverse_relationship = true,$type = "user",$subtype = "",$owner_guid = 0,$limit = 5,$fullview = false,$viewtypetoggle = false,$pagination = true);
if ($top_bloggers){
?>
<div id="top_blogger_sidebar">
<h4><?php echo elgg_echo('blog:top:blogger'); ?></h4>
<table cellspacing="0" cellpadding="0" border="0">
<?php
			
			foreach ($top_bloggers as $top_blogger){
			$blogger_count++;
			echo '<tr>';
			echo '<td id="top_blogger_side_icon"><a href="' . $vars['url'] . 'pg/blog/owner/' . $top_blogger->username . '/">' . elgg_view("profile/icon", array('entity' => $top_blogger,'size' => 'tiny')) . ' </a></td>';
			echo '<td id="top_blogger_side_name"><a href="' . $vars['url'] . 'pg/blog/owner/' . $top_blogger->username . '/">' . $blogger_count . '. ' . $top_blogger->name . '</a></td>';
			echo '</tr>';
			}
			
echo '</table></div>';
}}		?>