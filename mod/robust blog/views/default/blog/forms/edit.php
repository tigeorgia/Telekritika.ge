

<?php
     /**
 	 * Robust Blog add/edit blogpost page
 	 *
	 * Elgg blog edit/add page
	 *
	 * @package ElggBlog
	 *
	 * @uses $vars['object'] Optionally, the blog post to edit
	 */

$blog_context = get_context();

// Set title, form destination
if (isset($vars['entity'])) {

    $title = sprintf(elgg_echo("blog:editpost"),$object->title);
    $action = "blog/edit";
    $title = $vars['entity']->title;
    $body = $vars['entity']->description;
    $tags = $vars['entity']->tags;
    if ($vars['entity']->comments_on == 'Off') {
        $comments_on = false;
    } else {
        $comments_on = true;
    }
    $access_id = $vars['entity']->access_id;
} else  {
    $title = elgg_echo("blog:addpost");
    $action = "blog/add";
    $tags = "";
    $title = "";
	$body = "";
    $comments_on = true;
    $description = "";
    if (defined('ACCESS_DEFAULT'))
    $access_id = ACCESS_DEFAULT;
    else
    $access_id = 0;

    $container = $vars['container_guid'] ? elgg_view('input/hidden', array('internalname' => 'container_guid', 'value' => $vars['container_guid'])) : "";
}

	// Just in case we have some cached details
		if ((isset($vars['entity']) && $vars['user']->blogguid == $vars['entity']->guid)
		|| $vars['user']->blogguid == 0 && empty($body)) {
			$body = $vars['user']->blogbody;
			$title = $vars['user']->blogtitle;
			$tags = $vars['user']->blogtags;
		}

	// set the required variables

				$title_label = elgg_echo('title');
				$title_textbox = elgg_view('input/text', array('internalname' => 'blogtitle', 'value' => $title));
				$text_label = elgg_echo('blog:text');
				$text_textarea = elgg_view('input/longtext', array('internalname' => 'blogbody', 'value' => $body));
				$tag_label = elgg_echo('tags');
				$tag_input = elgg_view('input/tags', array('internalname' => 'blogtags', 'value' => $tags));
				$access_label = elgg_echo('access');

		//$comments_select = elgg_view('input/checkboxes', array('internalname' => 'comments_on', 'value' => ''));
		if($comments_on)
			$comments_on_switch = "checked=\"checked\"";
		else
			$comment_on_switch = "";

		$access_input = elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
		$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('publish')));
		$conversation = elgg_echo('blog:conversation');
		$publish = elgg_echo('publish');
		$cat = elgg_echo('categories');
		$preview = elgg_echo('blog:preview');
		$privacy = elgg_echo('access');
		$savedraft = elgg_echo('blog:draft:save');
		$draftsaved = elgg_echo('blog:draft:saved');
		$never = elgg_echo('blog:never');
		$allowcomments = elgg_echo('blog:comments:allow');
// INSERT EXTRAS HERE
$extras = elgg_view('categories',$vars);

?>
<div id="contentWrapper">
<form action="<?php echo $vars['url']; ?>action/<?php echo $action; ?>" enctype="multipart/form-data" method="post" name="blogPostForm">
<?php echo elgg_view('input/securitytoken') ?>

	<div id="blog_edit_top_holder">
		
		<div class="blog_edit" id="blog_edit_top_left">
			<div id="content_area_user_title"><h3><?php echo elgg_echo('publish'); ?></h3></div>
			<p>
				<a style="cursor:pointer;" onclick="javascript:saveDraft(false);return false;"><?php echo elgg_echo('blog:draft:save'); ?></a><br>
				<?php echo elgg_echo('blog:draft:saved') . ": " . "<span id='draftSavedCounter'>" . elgg_echo('blog:never') . "</span>"; ?>
			</p>
			<p>
				<?php 
					echo elgg_echo('access') . ": "; 
					echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
				?>
			</p>
			<p>
				<input type="submit" name="submit" value="<?php echo elgg_echo('publish'); ?>" />
			</p>
		</div>
		
		<div class="blog_edit" id="blog_edit_top_middle">
			<div id="content_area_user_title"><h3><?php echo elgg_echo('Conversation'); ?></h3></div>
			<p><label>
					<input type="checkbox" name="comments_select" <?php  echo $comments_on_switch; ?> /> 
				</label>	
			<?php echo elgg_echo('blog:comments:allow'); ?>
			</p><br>
			
			<?php echo elgg_view('groups/groupselector'); ?>
		</div>
		<!--
		<div  class="blog_edit" id="blog_edit_top_middle2">
			<div id="content_area_user_title"><h3><?php echo elgg_echo('Images'); ?></h3></div>
			
		</div>
		
		<div class="blog_edit" id="blog_edit_top_right">
			<div id="content_area_user_title"><h3><?php echo elgg_echo('Extras'); ?></h3></div>
		</div> -->
		<div id="clearfloat">&nbsp;</div>
	</div>

	<div id="blog_edit_middle_holder">
		
		<?php
			if (isset($vars['entity'])) {
			    $entity_hidden = elgg_view('input/hidden', array('internalname' => 'blogpost', 'value' => $vars['entity']->getGUID()));
			} else { 
				$entity_hidden = ''; 
			}
		if (empty($extras)){
		?>	
		<div id="blog_edit_post_box1">
			<p> <label>
				<?php 
					echo elgg_echo('title') . "</br>";
					echo elgg_view('input/text', array('internalname' => 'blogtitle', 'value' => $title)); 
				?>
    		</label></p><br>
			<p><label>
				<?php 
					echo elgg_echo('blog:text') . "</br>";
					echo elgg_view('input/longtext', array('internalname' => 'blogbody', 'value' => $body));
				?>
			</label></p><br>
			<p><label>
    			<?php 
					echo elgg_echo('tags') . "</br>";
    				echo elgg_view("input/tags", array("internalname" => "blogtags","value" => $tags)); 
    				?>
			</label></p>	
		</div>
		<div id="blog_edit_post_preview1">
		
		</div>
		<?php }else{ ?>
		<div id="blog_edit_categories_box">
			<?php echo $extras; ?>
		</div>
		<div id="blog_edit_post_box">
			<p> <label>
				<?php 
					echo elgg_echo('title') . "</br>";
					echo elgg_view('input/text', array('internalname' => 'blogtitle', 'value' => $title)); 
				?>
    		</label></p><br>
			<p><label>
				<?php 
					echo elgg_echo('blog:text') . "</br>";
					echo elgg_view('input/longtext', array('internalname' => 'blogbody', 'value' => $body));
				?>
			</label></p><br>
			<p><label>
    			<?php 
					echo elgg_echo('tags') . "</br>";
    				echo elgg_view("input/tags", array("internalname" => "blogtags","value" => $tags)); 
    				?>
			</label></p>	
		</div>
		<div id="blog_edit_post_preview">
		
		</div>
		
			<!-- $submit_input -->
		<?php } echo $entity_hidden; ?>
	</div>

</div>
<script type="text/javascript">
	setInterval( "saveDraft(false)", 120000);
	function saveDraft(preview) {
		temppreview = preview;

		if (typeof(tinyMCE) != 'undefined') {
			tinyMCE.triggerSave();
		}

		var drafturl = "<?php echo $vars['url']; ?>mod/blog/savedraft.php";
		var temptitle = $("input[name='blogtitle']").val();
		var tempbody = $("textarea[name='blogbody']").val();
		var temptags = $("input[name='blogtags']").val();
		var tempguid = $("input[name='blogpost']").val() || 0;

//FIXME add support to draft extended values

		var postdata = { blogtitle: temptitle, blogbody: tempbody, blogtags: temptags, blogpost: tempguid };

		$.post(drafturl, postdata, function() {
			var d = new Date();
			var mins = d.getMinutes() + '';
			if (mins.length == 1) mins = '0' + mins;
			$("span#draftSavedCounter").html(d.getHours() + ":" + mins);
			if (temppreview == true) {
				$("form#blogPostForm").attr("action","<?php echo $vars['url']; ?>mod/blog/preview.php");
				$("input[name='submit']").click();
				//$("form#blogPostForm").submit();
				//document.blogPostForm.submit();
			}
		});

	}

</script>
