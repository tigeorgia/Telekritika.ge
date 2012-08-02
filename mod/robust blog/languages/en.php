<?php

	$english = array(
	
		/**
		 * Menu items and titles
		 */
	
			'blog' => "Blog",
			'blogs' => "Blogs",
			'blog:user' => "%s's blog",
			'blog:user:friends' => "%s's friends' blogs",
			'blog:your' => "Your Blog",
			'blog:posttitle' => "%s's blog: %s",
			'blog:friends' => "Friends' Blogs",
			'blog:yourfriends' => "Your friends' latest blogs",
			'blog:everyone' => "Blog Central",
			'blog:newpost' => "New Blog Post",
			'blog:via' => "via blog",
			'blog:read' => "Read blog",
			'blog:featured:written' => "<em>written by </em>",
			'blog:top:blogger' => "Most Followed",
			'blog:stats:blogview' => "  Views ",
			'blog:latestposts' => "Latest Posts",
			'blog:hotbloggers' => "Hot Blogs",
			'blog:hotposts' => "Hot Posts",
			'blog:related:title' => "Related Posts",
			'blog:created:by' => "written by ",
			'blog:none' => "No posts have been written here yet",
			'blog:bloggers:none' => "No one is being followed yet",
			'blog:addpost' => "Write A Blog Post",
			'blog:editpost' => "Edit blog post",
			'blog:ingroup' => "in group:",
	
			'blog:text' => "Blog text",
	
			'blog:strapline' => "%s",
			
			'item:object:blog' => 'Blog posts',
	
			'blog:never' => 'never',
			'blog:preview' => 'Preview',
	
			'blog:draft:save' => 'Save draft',
			'blog:draft:saved' => 'Draft last saved',
			'blog:comments:allow' => 'Allow comments',
	
			'blog:preview:description' => 'This is an unsaved preview of your blog post.',
			'blog:preview:description:link' => 'To continue editing or save your post, click here.',
	
			'groups:enableblog' => 'Enable group blog',
			'blog:group' => 'Group blog',
			'blog:nogroup' => 'This group does not have any blog posts yet',
			'blog:more' => 'More blog posts',
	
			'blog:read_more' => ' (more)',

		/**
		 * Blog widget
		 */
		'blog:widget:description' => 'This widget displays your latest blog entries.',
		'blog:moreblogs' => 'More blog posts',
		'blog:numbertodisplay' => 'Number of blog posts to display',
		
         /**
	     * Blog river
	     **/
	        
	        //generic terms to use
	        'blog:river:created' => "%s wrote",
	        'blog:river:updated' => "%s updated",
	        'blog:river:posted' => "%s posted",
	        
	        //these get inserted into the river links to take the user to the entity
	        'blog:river:create' => "a new blog post titled",
	        'blog:river:update' => "a blog post titled",
	        'blog:river:annotate' => "a comment on this blog post",
			
	
		/**
		 * Status messages
		 */
	
			'blog:posted' => "Your blog post was successfully posted.",
			'blog:deleted' => "Your blog post was successfully deleted.",
	
		/**
		 * Error messages
		 */
	
			'blog:error' => 'Something went wrong. Please try again.',
			'blog:save:failure' => "Your blog post could not be saved. Please try again.",
			'blog:blank' => "Sorry. you need to fill in both the title and body before you can make a post.",
			'blog:notfound' => "Sorry. we could not find the specified blog post.",
			'blog:notdeleted' => "Sorry. we could not delete this blog post.",
			
		/**
		 * Learning Page Block
		 */
		
		   'blog:learning_box:content' => "Want to practice your writing skills? Use our powerful blogging feature to do it! Write as many blog posts as you want whenever you want.",
		   'blog:mine:total:count' => "My Blog Posts: ",
		   'blog:mine:total:rank' => "My Blog Rank: ",
		   'blog:learning_box:content1' => "<em>Save drafts of your blog posts before you publish them </em>",
		   '' => "",
		   
		  /**
		   * Trackback
		   */    
		  	'trackback:wrote' => "%s wrote a new blog post entitled %s on their blog %s",
			'trackback:instructions' => "To use a trackback from your external blog to add to the Activity stream, you must use this url:",
			'item:object:trackback' => 'External Blog posts',
		
		  /**
		   * Blog Watching
		   */ 
		    'blog:watch:add' => "Follow Blogger",
		    'blog:watch:delete' => "Unfollow Blogger",
		    'blog:watching' => "Following",
		    'blog:watch:notify:message' => "Login to read it.",
		    'blog:watch:notify:subject' => " wrote a new blog post",
		    'blog:watch:top_blogger:none' => "No one is being followed at the moment",
		    'blog:watch:followers' => "Followers: ",
		    'blog:watcher:latest:title' => "Latest Blog:",
		    'blog:watch:delete:success' => "You've stopped following",
   		    'blog:watch:add:success' => "You've started following",
   		    'blog:watching:none' => "You aren't following any bloggers at the moment",
   		    'blog:top_blogger:post_count' => "Posts: ",
   		    'blog:top_blogger:followers' => "Followers: ",
		  
   		 /**
		   * Featured
		   */
   		 	'blog:featured' => "Featured Posts",
			'blog:feature' => "Feature",
			'blog:unfeature' => "Unfeature",
			'blog:featured:yes' => "Featured",
			'blog:featuredon' => "The blog was successfully featured",
			'blog:unfeatured' => "The blog was successfully unfeatured",
			'blog:featured:none' => "No posts are currently featured",
   		 
   		             
   		 /**
		   * Related Posts
		   */
		  'blog:related:title' => "Related Posts",
		   
		 /**
		   * Blog Extended Language
		   */  
		  'group:contents'=>"Contents",
		  'group:contents:empty'=>"There are contents published in this group",
		  'content:owner'=>"Assign to",
		  'my:profile'=>"My profile",
 		       
		 /**
		  * Admin Settings
		  */  
		   'blog:settings:trackback:activate' => "<strong>Allow Trackbacks</strong>",
		   'blog:settings:trackback:help' => "<em>This will allow users to sync their external blog and update your site river each time they post to that blog</em>",
		   'blog:settings:watch:activate' => "<br><strong>Allow Blog Watching</strong>",
		   'blog:settings:watch:help' => "<em>This will allow users to follow other users blogs and receive notification on new blog posts.</em><br>WARNING:This can severely slow your server down, without cron.",
   		   'blog:settings:top:activate' => "<br><strong>Activate Top Blogger Panel</strong>",
   		   'blog:settings:top:help' => "<em>This will show the most watched blogger under the owner's box</em>",
		   'blog:settings:featured:activate' => "<strong>Turn On Featuring</strong>",
		   'blog:settings:featured:help' => "<em>This will allow you the admin to feature blogs that you think are good.</em>",
		   'blog:settings:featured:title' => "<strong>Show featured blog slideshow on:</strong>",
		   'blog:settings:featured:mine' => "User's Blog Page",
		   'blog:settings:featured:friend' => "Friends's Blog Page",
		   'blog:settings:featured:central' => "Blog Central Page",
		   'blog:settings:related:activate' => "<br><strong>Show Related Posts</strong>",
		   'blog:settings:related:help' => "<em>This will show related posts based on tags in each blog full view (currently set to all tags)</em>",
		   'blog:settings:group_contents:activate' => "<strong>Allow Post Assigning</strong>",
		   'blog:settings:group_contents:help' => "<em>This will allow users to assign a post to one of their groups</em>",
		   'blog:settings:iconoverwrite:activate' => "<strong>Allow Icon Overwriting</strong>",
		   'blog:settings:iconoverwrite:help' => "<em>This will overwrite the icons of posts assigned to groups with the group icon</em>"
		   
	);
					
	add_translation("en",$english);

?>