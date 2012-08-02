<?php

	/**
	 * Elgg blog index page
	 * 
	 * @package ElggBlog
	 */

	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	// access check for closed groups
	group_gatekeeper();
		$callback = get_input('callback');
		$offset = get_input('offset');
	// Get the current page's owner
		$page_owner = page_owner_entity();
 		if (($page_owner == FALSE) || (is_null($page_owner))) {
			if (empty($callback)) {	
			// guess that logged in user is the owner - if no logged in send to all blogs page
			if (!isloggedin()) {
				forward('pg/blog/all/');
			}}
			
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}

	//set blog title
		if ($page_owner == $_SESSION['user']) {
			$area2 = elgg_view_title(elgg_echo('blog:your'));
		} else {
			if ($page_owner instanceof ElggGroup)
			{
			$area2 = elgg_view_title(sprintf(elgg_echo('blog:group'),$page_owner->name));
			}
			else
			{
			$area2 = elgg_view_title(sprintf(elgg_echo('blog:user'),$page_owner->name));
			}
		}

		$offset = (int)get_input('offset', 0);
		
		$context = get_context();
		
		if ($page_owner instanceof ElggGroup)
		  {
		    $search_param = 'container_guid';
		  }
		else
		{
		    $search_param = 'owner_guid';
		}		
		
		set_context('blogsearch');
		$blog_objects .= elgg_list_entities(array('type' => 'object', 'subtype' => 'blog', $search_param => page_owner(), 'limit' => 10, 'offset' => $offset, 'full_view' => FALSE, 'view_type_toggle' => FALSE));
		set_context($context);
		if (empty($callback)) {	
		if ($blog_objects) {
		$area2 .= '<div id="blog_listing_box">';
		$area2 .= $blog_objects;
		$area2 .= '</div>';
		}
		else
		{			
		$area2 .= elgg_echo ('blog:none');
		}
	// Get blog tags

		// Get categories, if they're installed
		global $CONFIG;
		$area3 = elgg_view('blog/categorylist', array(
			'baseurl' => $CONFIG->wwwroot . 'pg/categories/list/?subtype=blog&owner_guid='.$page_owner->guid.'&category=',
			'subtype' => 'blog', 
			'owner_guid' => $page_owner->guid));
		
			$top = get_plugin_setting('top','blog');
			if ($top != 'no'){ 
			if (get_context() == 'blog'){
			elgg_extend_view('page_elements/owner_block','blog/top_blogger');
			 }
			//$area3 .= elgg_view('blog/top_blogger');		
			}
		
	// Display them in the page
        $body = elgg_view_layout("two_column_left_sidebar", '', $area2, $area3);
		
	// Display page
		page_draw(sprintf(elgg_echo('blog:user'),$page_owner->name),$body);
}
else
{
	if ($blog_objects) {
	// ajax callback
	header("Content-type: text/html; charset=UTF-8");
	echo $blog_objects;
}
}		
?>
