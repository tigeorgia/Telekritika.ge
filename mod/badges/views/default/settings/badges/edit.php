<?php
?>

<p>
    <?php echo elgg_echo('badges:lock_high'); ?>
    <?php echo elgg_view('input/pulldown', array(
                             'internalname' => 'params[lock_high]',
                             'options_values' => array('1' => 'Yes', '0' => 'No'),
                             'value' => $vars['entity']->lock_high
                             )
                        );
    ?>
    <br />
    <div class="badges_settings_info"><?php echo elgg_echo('badges:lock_high:info'); ?></div>
    <br /><br />

    <?php echo elgg_echo('badges:show_description'); ?>
    <?php echo elgg_view('input/pulldown', array(
                             'internalname' => 'params[show_description]',
                             'options_values' => array('1' => 'Yes', '0' => 'No'),
                             'value' => $vars['entity']->show_description
                             )
                        );
    ?>
</p>
