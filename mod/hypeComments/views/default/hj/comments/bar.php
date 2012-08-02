<?php
    /**
     * Load CSS and JS libraries
     */
    elgg_load_css('hj.comments.bar');
    elgg_load_js('hj.comments.base');
?>
<?php
if (elgg_is_logged_in()) {

    $object = elgg_extract('entity', $vars);
    ?>

    <?php
    if ($object instanceof ElggObject) {
        $page_owner = elgg_get_page_owner_entity();
        ?>
        <div id="<?php echo $object->guid ?>" class="hj-comments-bar">
            <div class="hj-comments-item-like hj-left"><a href="javascript:void(0)"></a></div>

            <?php if (!$page_owner instanceof ElggGroup || ($page_owner instanceof ElggGroup && $page_owner->isMember(elgg_get_logged_in_user_entity()))) {
                ?>
                <div class="hj-comments-item-comments hj-left"><a href="javascript:void(0)"><?php echo elgg_echo('hj:comments:commentsbutton') ?></a></div>
            <?php } ?>
            <!--
            <div class="hj-comments-item-share hj-left"><?php echo elgg_echo('hj:comments:sharebutton') ?></div>
            -->

            <div class="clearfloat"></div>
            <div class="hj-comments-containers">
                <div class="hj-comments-item-like-bar"></div>
                <div class="hj-comments-item-comments-bar"></div>
                <div class="hj-comments-item-comments-container" style="display:none"></div>
            </div>
            <div class="clearfloat"></div>
        </div>
        <?php
    }
}
?>
