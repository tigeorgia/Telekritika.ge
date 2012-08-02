<?php 
echo '<div class="blog_index_listing">';
echo '<span class="listing_icon">';
			echo elgg_view('profile/icon',array('entity' => $vars['entity'], 'size' => 'small', 'override' => 'false'));
			echo "</span><h3><a href=\"" . $vars['entity']->getURL() . "\">" . $vars['entity']->name . "</a></h3>";
			$ts = time();
			$token = generate_action_token($ts);
			if (($vars['entity']->guid != page_owner()) &&(isloggedin())){
			echo "<a href='{$vars['url']}action/blog/watch?owner_guid={$vars['entity']->guid}&__elgg_token=$token&__elgg_ts=$ts'>(". elgg_echo('blog:watch:delete') . ")</a>";
			}
			$blogs = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog', 'owner_guid' => $vars['entity']->guid,'limit' => '1'));
			if ((isset($blogs))&&(is_array($blogs))){
			foreach($blogs as $blog){
			$description = elgg_get_excerpt($blog->description, 500);
						// add a "read more" link if cropped.
						if (elgg_substr($description, -3, 3) == '...') {
							$description .= " <a href=\"{$blog->getURL()}\">" . elgg_echo('blog:read_more') . '</a>';
						}	
			echo '<br/><br/>' . elgg_echo('blog:watcher:latest:title') . " <a href='{$blog->getURL()}'>" . $blog->title . "</a><br/><br/>";
			echo $description;
			}}
echo '</div>';
?>