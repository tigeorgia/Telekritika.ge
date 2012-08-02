<?php

	/**
	 * Elgg blog listing
	 * 
	 * @package ElggBlog
	 */
	 $feature = get_plugin_setting('feature','blog');
	if ($feature != 'no')
		{
	 	if(isadminloggedin())
		{
			if($vars['entity']->featured_blog == "yes"){
				$featured_url = elgg_add_action_tokens_to_url($vars['url'] . "action/blog/featured?blogguid=" . $vars['entity']->guid . "&action_type=unfeature");
				$wording = elgg_echo("blog:unfeature");
			}else{
				$featured_url = elgg_add_action_tokens_to_url($vars['url'] . "action/blog/featured?blogguid=" . $vars['entity']->guid . "&action_type=feature");
				$wording = elgg_echo("blog:feature");
			}
		  }
		}
						
		$tags = elgg_view('output/tags', array('tags' => $vars['entity']->tags));
		$canedit = $vars['entity']->canEdit();
		$owner = $vars['entity']->getOwnerEntity();
		$created_by =  elgg_echo('blog:created:by') . '<a href="' . $vars['url'] . 'pg/blog/owner/' . $owner->username . '">' . $owner->name . '</a>';
		$container = get_entity($vars['entity']->container_guid);
		if ($container instanceof ElggGroup){
		$created_by .= '<p class="strapline">' . elgg_echo('blog:ingroup') . ' <a href="' . $container->getURL() . '">' . $container->name . '</a></p>';
		}	
		$watch = get_plugin_setting('watch','blog');
	  $user_id = get_loggedin_userid();
	 $user = get_entity($user_id);
	  if (($watch != 'no') && ($owner != $user) && (isloggedin())){
		  $watching = check_entity_relationship($_SESSION['user']->guid, 'blogwatcher', $owner->guid);

		  if($watching != FALSE){
		    $watch1 = "(" . elgg_echo('blog:watch:delete') . ")";
		  }else{
		    $watch1 = "(" . elgg_echo('blog:watch:add') . ")";
		  }
		  $ts = time();
		  $token = generate_action_token($ts);
		  $follow_link = "<a href='{$vars['url']}action/blog/watch?owner_guid={$owner->guid}&__elgg_token=$token&__elgg_ts=$ts'>{$watch1}</a>";
		  }  
		$views = $vars['entity']->getAnnotations("blogview");
		if ($views != FALSE){
		$current_count = $views[0]->value;
		}
		else
		{
		  $current_count = 0;
		}
		$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
		$icon = elgg_view(
				"profile/icon", array(
										'entity' => $owner,
										'size' => 'small'
									  )
			);
		
		if($vars['entity'] instanceof ElggObject){
			        //get the number of comments
		$num_comments = elgg_count_comments($vars['entity']);
		if ($num_comments > 0)
		$comments = "<a href='{$vars['entity']->getURL()}/#top_comment'>" . sprintf(elgg_echo('comments')) . " (" . $num_comments . ")</a> " . $follow_link;
		}
		$edit = "<a href='{$vars['url']}mod/blog/edit.php?blogpost={$vars['entity']->getGUID()}'>" . elgg_echo('edit') . "</a>";
		$delete = elgg_view("output/confirmlink", array('href' => $vars['url'] . "action/blog/delete?blogpost=" . $vars['entity']->getGUID(),'text' => elgg_echo('delete'),'confirm' => elgg_echo('deleteconfirm'),));
		$description = elgg_get_excerpt($vars['entity']->description, 500);
						// add a "read more" link if cropped.
						if (elgg_substr($description, -3, 3) == '...') {
							$description .= " <a href=\"{$vars['entity']->getURL()}\">" . elgg_echo('blog:read_more') . '</a>';
						}	
		$star = $vars['url']."mod/blog/graphics/star.png";
			 		$featured_star = "<img src='$star'>";
			        $featured = "$featured_star";
			
		      if (get_context() == 'widget')
      {
	echo '<div class="search_listing">';
      }
		
		if ($_SESSION['user']->admin){

		  $info = "<div class='blog_index_listing'>";
		  $info .= "<h3><a href='{$vars['entity']->getURL()}'>{$vars['entity']->title}</a></h3>";
    	  $info .= "<div class='listing_content_left'><span style='float:left;margin-right:4px;'>" . $icon . "</span><p class=\"strapline\">" . $created_by . " " .  $friendlytime . " | " . elgg_echo('blog:stats:blogview') . "(" . $current_count . ")"; 
	  if ($num_comments > 0)
	   $info .= " | " . $comments;
	   $info .= "</p>";    	      	  
    	  if ($tags){
	  $info .= '<p class="tags">' . $tags . '</p>';
	  }
    	  if($vars['entity']->featured_blog == "yes"){
		  $info .= "<div class='featured_blog_spot'>" . $featured . elgg_echo('blog:featured:yes') .  "</div>";
	  	  }
		  $info .= "</div>";
    	  $info .= "<div class='listing_content_right'>";
  		  $info .= elgg_view('output/longtext', array('value' => $description));
  		  $info .= "</div>"; 
 		  $info .= "<div class='admin_block'>";
 		  if($canedit){
	 	  $info .= "(" . $edit . ")" . "  " . "(" . $delete . ")" . "  ";
		  }
 		  $info .= "(<a href='$featured_url'>$wording</a>)";
 		  $info .= "</div></div>";
		  echo $info;

	  }else{
		  
		  $info = "<div class='blog_index_listing'>";
		  $info .= "<h3><a href='{$vars['entity']->getURL()}'>{$vars['entity']->title}</a></h3>";
    	  $info .= "<div class='listing_content_left'><span style='float:left;margin-right:4px;'>" . $icon . "</span><p class=\"strapline\">" . $created_by . " " .  $friendlytime . " | " . elgg_echo('blog:stats:blogview') . "(" . $current_count . ")";
	  if ($num_comments > 0)
	   $info .= " | " . $comments;
	   $info .= "</p>";    	      	  
	  if ($tags){
	    $info .= '<p class="tags">' . $tags . '</p>';}
    	  if($vars['entity']->featured_blog == "yes"){
		  $info .= "<div class='featured_blog_spot'>" . $featured . elgg_echo('blog:featured:yes') .  "</div>";
	  	  }
    	  $info .= "</div>";
    	  $info .= "<div class='listing_content_right'>";
  		  $info .= elgg_view('output/longtext', array('value' => $description));
 		  $info .= "</div>";
 		  $info .= "<div class='listing_content' id='listing_content'>";
 		  if($canedit){
	 	  $info .= "(" . $edit . ")" . "  " . "(" . $delete . ")" . "  ";
		  }
 		  $info .= "</div></div>";
		  echo $info;
			

		}
      if (get_context() == 'widget')
      {
	echo '</div>';
      }
?>	
