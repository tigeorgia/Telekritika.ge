<?php

    $badge = get_entity((int)get_input('guid'));

    $ts = time();
    $token = generate_action_token($ts);
?>

<div class="contentWrapper">
    <div id="badges_upload_form">
        <form action="<?php echo $vars['url']; ?>action/badges/edit" method="post" enctype="multipart/form-data">
        <p>

            <?php echo elgg_view('input/hidden', array('internalname' => '__elgg_token', 'value' => $token)); ?>
            <?php echo elgg_view('input/hidden', array('internalname' => '__elgg_ts', 'value' => $ts)); ?>
            <?php echo elgg_view("input/hidden",array('internalname' => 'guid', 'value' => $badge->guid)); ?><br />

            <b><?php echo elgg_echo("badges:image"); ?>:<font color="red">*</font></b><br />
            <?php echo elgg_view("input/file",array('internalname' => 'badge')); echo $badge->originalfilename; ?>
            <br /><br />

            <b><?php echo elgg_echo("badges:name"); ?>:</b><br />
            <?php echo elgg_view("input/text",array('internalname' => 'name', 'value' => $badge->title)); ?><br />
            <?php echo elgg_echo("badges:name:info"); ?>
            <br /><br />

            <b><?php echo elgg_echo("badges:description"); ?>:</b><br />
            <?php echo elgg_view("input/text",array('internalname' => 'description', 'value' => $badge->description)); ?><br />
            <?php echo elgg_echo("badges:description:info"); ?>
            <br /><br />

            <b><?php echo elgg_echo("badges:description:url"); ?>:</b><br />
            <?php echo elgg_view("input/text",array('internalname' => 'url', 'value' => $badge->badges_url)); ?><br />
            <?php echo elgg_echo("badges:description:url:info"); ?>
            <br /><br />

            <b><?php echo elgg_echo("badges:points"); ?>:</b><br />
            <?php echo elgg_view("input/text",array('internalname' => 'points', 'value' => $badge->badges_userpoints)); ?><br />
            <?php echo elgg_echo("badges:points:info"); ?>
            <br />

            <br /><input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" />
        </p>
        </form>
    </div>
</div>
