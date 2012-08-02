<?php

/**
	 * Elgg view all blog posts from all users page
	 * 
	 * @package ElggBlog
	 */

	// Load Elgg engine
		define('everyoneblog','true');
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		$callback = get_input('callback');
		set_page_owner(get_loggedin_userid());

		$offset = (int)get_input('offset', 0);
		if (empty($callback)) {	
		
		$area2 = elgg_view_title(elgg_echo('blog:everyone'));

		$feature = get_plugin_setting('featuredcentral','blog');
		if ($feature != 'no'){ 
				$area2 .= elgg_view('blog/top');
		}
		$area2 .= '<div id="blog_menu_box">';
		$area2 .= elgg_view('blog/everyone');
		$area2 .= '</div>';

		// get tagcloud
		// $area3 = "This will be a tagcloud for all blog posts";

		// Get categories, if they're installed
		global $CONFIG;
		
		$area3 = elgg_view('blog/categorylist', array(
			'baseurl' => $CONFIG->wwwroot . 'pg/categories/list/?subtype=blog&owner_guid='.$page_owner->guid.'&category=',
			'subtype' => 'blog'
		));
		$top = get_plugin_setting('top','blog');
			if ($top != 'no'){ 
			$area3 .= elgg_view('blog/top_blogger');
			}

		$body = elgg_view_layout("two_column_left_sidebar", '', $area2, $area3);
		
	// Display page
		page_draw(elgg_echo('blog:everyone'),$body);
}
else
{
	$content .= elgg_view('blog/everyone');
	// ajax callback
	header("Content-type: text/html; charset=UTF-8");
	echo $content;

}
		
?>
