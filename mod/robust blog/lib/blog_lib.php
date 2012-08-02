<?php
  
function in_arrayi($needle, $haystack)
{
    for($h = 0 ; $h < count($haystack) ; $h++)
    {
        $haystack[$h] = strtolower($haystack[$h]);
    }
    return in_array(strtolower($needle),$haystack);
}

function trim_array(array $array,$int){
    $newArray = array();
    for($i=0; $i<$int; $i++){
	array_push($newArray,$array[$i]);
    }
    return (array)$newArray;
}


function subval_sort($a,$subkey,$sort) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	$sort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}

function blog_view_count($blog, $page_owner)
{
      $wait = 5;
      if (isset($_SESSION['last_blog_viewed'])){
      $last_viewed = $_SESSION['last_blog_viewed'];
      $last_viewed_time = $_SESSION['last_blog_viewed_time'];
    /*  echo 'last viewed: ' . $last_viewed;
      echo '<br>last viewed time: ' .  $last_viewed_time;*/	
      }
      $current_view_time = gettimeofday(true);
//       echo '<br> current view time - ' . $wait . ' = ' . ($current_view_time - $wait);
//       echo '<br> current view time = ' . $current_view_time;
//       echo '<br> difference between last viewed and current time = ' . ($current_view_time - $last_viewed_time);
  
//       if ($last_viewed == $blog->guid)
// 	echo '<br>* last viewed blog == blog->guid *';
// 
//       if ($last_viewed_time < ($current_view_time-$wait))
// 	echo '<br>* last viewed time < current view time - ' . $wait . '*';

      if (($last_viewed != $blog->guid) || (($last_viewed == $blog->guid) && ($last_viewed_time < ($current_view_time-$wait))) || (is_null($last_viewed)))
      {
      $current_count = $blog->getAnnotations("blogview");
      if($current_count)
      {
	$updateable = TRUE;
	if(isloggedin())
	{
	  if(get_loggedin_user()->getGUID() == $page_owner->getGUID())
	  {
	      // dont count own blog views
	      $updateable = FALSE;
	  }
	}
	if($updateable == TRUE)
	{
	  $new_val = ($current_count[0]->value +1);
	  update_annotation($current_count[0]->id,  "blogview", $new_val, $current_count[0]->value_type,$current_count[0]->owner_guid, $current_count[0]->access_id); 
	}
      }
      else
      {
       $blog->annotate('blogview', 1, 2);
      }
      
     }
      $_SESSION['last_blog_viewed'] = $blog->guid;
      $_SESSION['last_blog_viewed_time'] = $current_view_time;
}

function related_blogs($thisblog){
	  $related = get_plugin_setting('related','blog');
	  if ($related != 'no')
	  { 
	    $this_blogs_tags = $thisblog->tags;
	    if (is_array($this_blogs_tags)){
	    $this_blogs_tags = array_unique($this_blogs_tags);
	    }
	    $blogs = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog', 'owner_guid' => '','limit' => ''));
	    $related_blogs = array();
	    $total_related = 0;
	    $max_related_blogs = 8; // TO DO : set this in admin settings
	    $rows_per_line = 4;
	    foreach($blogs as $blog)
	    {
		$blogtags =  array_unique($blog->tags);
		if (count($blogtags) > 0) // if this currently examined blog has tags
		{
		    $hitcount = 0;
		    foreach($blogtags as $blogtag)
		    {
		      if (in_arrayi($blogtag, $this_blogs_tags))
		      {
			$hitcount++;
		      }
		    }
		  if ($hitcount > 0)
		    {
		      if ($thisblog->guid != $blog->guid) // check that this retrieved blog is not the displayed blog
		      {
		      $related_blogs[] = array('similarity' => $hitcount, 'blog' => $blog);
		      }
		    }
		}

	    } // end loop of examining blogs
	    if(count($related_blogs)> 0)
	    {
	      $related_blogs = subval_sort($related_blogs,'similarity',arsort);
	      $related_blogs = trim_array($related_blogs, $max_related_blogs);
	      $grid_count = 0;
	      echo "<div id='blog_related_articles'>";
	      echo "<h3>" . elgg_echo('blog:related:title') . "</h3>";
	      echo '<table cellspacing="0" cellpadding="0" border="0">';
	      foreach ($related_blogs as $related_blog)
	      {
		
//		echo 'name = ' . $thisblog->title . '; guid = ' . $thisblog->guid . '; ';
	
		if ($grid_count == 0)
		{
		  echo '<tr>';
		}
		$thisblog = $related_blog['blog'];
		if ($thisblog instanceof ElggObject)
		{
		
		$owner = $thisblog->getOwnerEntity();
		$friendlytime = elgg_view_friendly_time($thisblog->time_created);
		echo '<td><div class="related_blogs" onclick="window.location.href=\''. $thisblog->getURL() . '\';">';
		echo "<h4><a href='{$thisblog->getURL()}'>" . $thisblog->title . "</a></h4>";
		echo $friendlytime . "<br>" . $owner->name;
		echo "</div></td>";
		$grid_count++;
		}
		if ($grid_count == $rows_per_line)
		{
		  echo '</tr>';
		  $grid_count = 0;
		}
	    
	      
	      
	      }
	      echo '</table>';
	      echo "</div>";
	    }
	  } // end - if related blogs view is active 
}
?>