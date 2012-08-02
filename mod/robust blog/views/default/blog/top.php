<?php
/**
 * language_courses
 *
 * @author Callum
 */
 
?>
<script type="text/javascript" src="<?php echo $vars['url'];?>mod/blog/js/jquery.jcarousel.js"></script>
<script type="text/javascript">
	function mycarousel_initCallback(carousel)
	{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        auto: 2,
        wrap: 'last',
        initCallback: mycarousel_initCallback
    });
});
		$(document).ready(function(){	
					$("#mycarousel li").click(function() {
					get(this.id);
		    		$("#carousel_content li (id)").fadeIn("slow");
					});
		});

</script>
<?php
$feature = get_plugin_setting('feature','blog');
if ($feature != 'no'){
$featured_blogs = elgg_get_entities_from_metadata(array('metadata_name' => 'featured_blog','metadata_value' => 'yes','types' => 'object','offset' => 0,'limit' => 5));
if ($featured_blogs){
?>
<div class="blog_top_holder">
	<div class="dashbox3">
		<div class="dashbox_title_space"><h3><img src="<?php echo $vars['url'];?>mod/blog/graphics/star.png"><?php echo elgg_echo('blog:featured'); ?></h3></div>
		<div class="dashbox_content">
			<ul id="mycarousel" class="jcarousel-skin-tango2">
			<?php
				if($featured_blogs)
				{
					foreach($featured_blogs as $feat_blog)
					{
						$owner_guid = $feat_blog->owner_guid;
						$owner = get_entity($owner_guid);
						echo "<li class='featured_holder'>";
						echo "<span class='featured_title'><h3><a href='{$feat_blog->getURL()}'>{$feat_blog->title}</a></h3></span>";
						$body = elgg_get_excerpt($feat_blog->description, 400);
						// add a "read more" link if cropped.
						if (elgg_substr($body, -3, 3) == '...') {
							$body .= "<a href='{$feat_blog->getURL()}'>" . elgg_echo('blog:read_more') . '</a>';
						}
						echo "<span class='featured_content'>" . elgg_view('output/longtext', array('value' => $body)) . "</span>";
						echo "<span class='featured_image'>" . elgg_view('profile/icon',array('entity' => $owner, 'size' => 'medium', 'override' => 'true')) . "</span>";
						echo "<span class='featured_writer'>" . elgg_echo('blog:featured:written') . $owner->name . "</span>";
						echo "</li>";
					}
				}
			?>
			</ul>
			
		</div>
	
	</div>
	
</div>
<?php }} ?>
<div class="clearfloat"></div>