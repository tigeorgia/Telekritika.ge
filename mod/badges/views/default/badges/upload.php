<?php

    $ts = time();
    $token = generate_action_token($ts);
?>

<br>
<div id="badges_upload_form">
    <form action="<?php echo $vars['url']; ?>action/badges/upload" method="post" enctype="multipart/form-data">
    <p>
        <?php echo elgg_view('input/hidden', array('internalname' => '__elgg_token', 'value' => $token)); ?>
        <?php echo elgg_view('input/hidden', array('internalname' => '__elgg_ts', 'value' => $ts)); ?>

        <b><?php echo elgg_echo("badges:image"); ?>:<font color="red">*</font></b><br />
        <?php echo elgg_view("input/file",array('internalname' => 'badge')); ?>
        <br /><br />

        <b><?php echo elgg_echo("badges:name"); ?>:<font color="red">*</font></b><br />
        <?php echo elgg_view("input/text",array('internalname' => 'name')); ?><br />
        <?php echo elgg_echo("badges:name:info"); ?>
        <br /><br />

        <b><?php echo elgg_echo("badges:description"); ?>:</b><br />
        <?php echo elgg_view("input/text",array('internalname' => 'description')); ?><br />
        <?php echo elgg_echo("badges:description:info"); ?>
        <br /><br />

        <b><?php echo elgg_echo("badges:description:url"); ?>:</b><br />
        <?php echo elgg_view("input/text",array('internalname' => 'url')); ?><br />
        <?php echo elgg_echo("badges:description:url:info"); ?>
        <br /><br />

        <b><?php echo elgg_echo("badges:points"); ?>:</b><br />
        <?php echo elgg_view("input/text",array('internalname' => 'points')); ?><br />
        <?php echo elgg_echo("badges:points:info"); ?>
        <br />

        <br /><input type="submit" class="submit_button" value="<?php echo elgg_echo("upload"); ?>" />
    </p>
    </form>
</div>

