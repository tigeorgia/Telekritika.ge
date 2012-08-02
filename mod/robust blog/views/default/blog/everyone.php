<?php
/**
	 * Elgg view all blog posts from all users page
	 * 
	 * @package ElggBlog
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2010
	 * @link http://elgg.com/
	 */

	global $CONFIG;
	
	 $filter = $vars['filter'];
	 $filter = get_input("filter");
	 $offset = get_input("offset");
	if (!$filter) {
		// active discussions is the default
		$filter = "latestposts";
	}
	 $user_id = get_loggedin_userid();
	 $user = get_entity($user_id);
	 //url
	 $url = $vars['url'] . "mod/blog/everyone.php";
	 $featured_blogs = get_entities_from_metadata ('featured_blog', $meta_value="yes", $entity_type="object", $entity_subtype="blog", $owner_guid=0, $limit='', $offset=0, $order_by="", $site_guid=0, $count=TRUE, $case_sensitive=FALSE);
	 $my_following = get_entities_from_relationship('blogwatcher',$_SESSION['user']->guid,$inverse_relationship = false); 
	 if (!$my_following)
	  {
	   $following = 0;
	  }
	  else
	  {
	    $following = count($my_following);
	  }
?>
<br>
<div id="elgg_horizontal_tabbed_nav">
<ul>
<?php if (!isloggedin){ ?>
	<li <?php if($filter == "latestposts") echo "class='selected'"; ?>><a onclick="javascript:$('#blog_menu_box').load('<?php echo $vars['url']; ?>pg/blog/all?filter=latestposts&amp;callback=true'); return false;" href="?filter=latestposts"><?php echo elgg_echo('blog:latestposts'); ?></a></li>
<?php 
	$watch = get_plugin_setting('watch','blog');
	if ($watch != 'no'){ ?>
	<li <?php if($filter == "hotbloggers") echo "class='selected'"; ?>><a onclick="javascript:$('#blog_menu_box').load('<?php echo $vars['url']; ?>pg/blog/all?filter=hotbloggers&amp;callback=true'); return false;" href="?filter=hotbloggers"><?php echo elgg_echo('blog:hotbloggers'); ?></a></li>
<?php } ?>
	<li <?php if($filter == "hotposts") echo "class='selected'"; ?>><a onclick="javascript:$('#blog_menu_box').load('<?php echo $vars['url']; ?>pg/blog/all?filter=hotposts&amp;callback=true'); return false;" href="?filter=hotposts"><?php echo elgg_echo('blog:hotposts'); ?></a></li>
<?php
	$featured = get_plugin_setting('featured','blog');
	if ($featured != 'no'){ ?>
	<li <?php if($filter == "featured") echo "class='selected'"; ?>><a onclick="javascript:$('#blog_menu_box').load('<?php echo $vars['url']; ?>pg/blog/all?filter=featured&amp;callback=true'); return false;" href="?filter=featured"><?php echo elgg_echo('blog:featured') . " (" . $featured_blogs . ")"; ?></a></li>

<?php }}else{?>
	<li <?php if($filter == "latestposts") echo "class='selected'"; ?>><a onclick="javascript:$('#blog_menu_box').load('<?php echo $vars['url']; ?>pg/blog/all?filter=latestposts&amp;callback=true'); return false;" href="?filter=latestposts"><?php echo elgg_echo('blog:latestposts'); ?></a></li>
<?php $watch = get_plugin_setting('watch','blog');
		if ($watch != 'no'){ ?>
	<li <?php if($filter == "hotbloggers") echo "class='selected'"; ?>><a onclick="javascript:$('#blog_menu_box').load('<?php echo $vars['url']; ?>pg/blog/all?filter=hotbloggers&amp;callback=true'); return false;" href="?filter=hotbloggers"><?php echo elgg_echo('blog:hotbloggers'); ?></a></li>
<?php } ?>
	<li <?php if($filter == "hotposts") echo "class='selected'"; ?>><a onclick="javascript:$('#blog_menu_box').load('<?php echo $vars['url']; ?>pg/blog/all?filter=hotposts&amp;callback=true'); return false;" href="?filter=hotposts"><?php echo elgg_echo('blog:hotposts'); ?></a></li>
<?php
	$featured = get_plugin_setting('featured','blog');
	if ($featured != 'no'){ ?>
	<li <?php if($filter == "featured") echo "class='selected'"; ?>><a onclick="javascript:$('#blog_menu_box').load('<?php echo $vars['url']; ?>pg/blog/all?filter=featured&amp;callback=true'); return false;" href="?filter=featured"><?php echo elgg_echo('blog:featured') . " (" . $featured_blogs . ")"; ?></a></li>
	<?php
		}
		$watch = get_plugin_setting('watch','blog');
		if (($watch != 'no') && (isloggedin())){ ?>
	<li <?php if($filter == "watching") echo "class='selected'"; ?>><a onclick="javascript:$('#blog_menu_box').load('<?php echo $vars['url']; ?>pg/blog/all?filter=watching&amp;callback=true'); return false;" href="?filter=watching"><?php echo elgg_echo('blog:watching') . " (" . $following . ")";  ?></a></li>
	<?php }} ?>
</ul>
</div>
<div id="blog_menu_list">
<?php

	
	
	// Get objects
	$context = get_context();
	
	set_context('blogcentral');
	
		switch($filter){
			case 'default':
			case "latestposts":
			$objects = elgg_list_entities(array('type' => 'object', 'subtype' => 'blog', 'limit' => 10,  'full_view' => FALSE));
			if (!$objects){
			echo elgg_echo('blog:none');
			}else{
			echo $objects;
			}
			break;
			
			case "hotbloggers":
			$objects = get_entities_by_relationship_count('blogwatcher',$inverse_relationship = true,$type = "user",$subtype = "",$owner_guid = 0,$limit = 10,$offset = 0);
			if (!$objects){
			echo elgg_echo('blog:bloggers:none') . '</div>';
			}else{
			foreach($objects as $object){
			  echo elgg_view('blog/blogger_listing', array('entity' => $object));
			  }
			}
			break;
			
			case "hotposts":
			$objects = list_entities_from_annotation_count ($entity_type="object", $entity_subtype="blog", $name="blogview", $limit=10, $owner_guid=0, $group_guid=0, $asc=false, $fullview=false, $listtypetoggle=false, $orderdir= 'desc');
			if (!$objects){
			echo elgg_echo('blog:none');
			}else{
			echo $objects;
			}
			break;
			
			case "featured":
			$objects = list_entities_from_metadata ('featured_blog', "yes", $entity_type="object", $entity_subtype="blog", $owner_guid = 0, $limit = 10, $fullview = false, $listtypetoggle = false, $pagination = true, $case_sensitive = false);
			if (!$objects){
			echo elgg_echo('blog:featured:none');
			}else{
			echo $objects;
			}
			break;
			
			case "watching":
			$watchers = get_entities_from_relationship('blogwatcher',$_SESSION['user']->guid,$inverse_relationship = false);
			if (!$watchers){
			echo elgg_echo('blog:watching:none') . '</div>';
			}else{
			foreach($watchers as $watcher){
			echo elgg_view('blog/blogger_listing', array('entity' => $watcher));
			}
			}
			break;	
		}
	set_context('blog');
?>
</div>