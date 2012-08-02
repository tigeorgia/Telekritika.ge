<?php

	//extend the learning_tools plugin index page
	$user_id = get_loggedin_userid();
	$myblog_count = elgg_get_entities(array('types' => 'object','subtypes' => 'blog', 'owner_guid' => $user_id, 'count' => TRUE));
	$blog_rank = $user_id->getAnnotations("blogrank");
	if(!$blog_rank){
			$blog_rank = 0;
			} else {
			$blog_rank = $blog_rank[0]->value;
			}
?>

<div class="learning_index_box">
	<h3><a href="<?php echo $vars ['url'];?>pg/blog/<?php echo  $_SESSION['user']->username; ?>"><?php echo elgg_echo('blog'); ?></a><img src="<?php echo $CONFIG->wwwroot; ?>mod/custom_index/graphics/slider/Paper-pencil.png"></h3>
	
		<?php echo elgg_echo('blog:learning_box:content'); ?>
		
		<hr>
		
		<div class="learning_box_stats" style="width:120px; float:left; margin-right:20px;">
		<?php
			echo elgg_echo('blog:mine:total:count') . $myblog_count. "<br>";
			echo elgg_echo('blog:mine:total:rank') . $blog_rank. "<br>";
				?>
		</div>
		<div class="learning_box_stats" style="width:140px; float:left;">
			<?php echo elgg_echo('blog:learning_box:content1'); ?>
		</div>
</div>