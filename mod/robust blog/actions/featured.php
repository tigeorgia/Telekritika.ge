<?php
	
	/**
	 * Feature a blog
	 * 
	 * @package ElggGroups
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2010
	 * @link http://elgg.com/
	 */

	// Load configuration
	global $CONFIG;
	
	admin_gatekeeper();
	
	$blog_guid = get_input('blogguid');
	$action = get_input('action_type');
	
	$blog = get_entity($blog_guid);
	
	if($blog){
		
		//get the action, is it to feature or unfeature
		if($action == "feature"){
		
			$blog->featured_blog = "yes";
			system_message(elgg_echo('blog:featuredon'));
			
		}
		
		if($action == "unfeature"){
			
			$blog->featured_blog = "no";
			system_message(elgg_echo('blog:unfeatured'));
			
		}
		
	}
	
	forward("mod/blog/everyone.php");
	
?>