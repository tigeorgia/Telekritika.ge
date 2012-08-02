<?php

    $plugin = elgg_get_plugin_from_id('elggx_userpoints');

    $ts = time();
    $token = generate_action_token($ts);

?>


<div class="elggx_userpoints_actions">
  <form method="POST" action="<?php echo $vars['url']; ?>action/elggx_userpoints/settings">
      <?php echo elgg_view('input/hidden', array('name' => '__elgg_token', 'value' => $token)); ?>
      <?php echo elgg_view('input/hidden', array('name' => '__elgg_ts', 'value' => $ts)); ?>

  <table>

    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>

    <tr><td><h3><?php echo elgg_echo('userpoints_standard:activities'); ?></h3></td><td>&nbsp;</td></tr>
    <tr><td colspan="2"><hr /><br /></td></tr>

     <tr>
        <td width="40%"><label><?php echo elgg_echo('userpoints_standard:commentary'); ?></label></td>
        <td><?php echo elgg_view('input/text', array('name' => "params[commentary]", 'value' => $plugin->commentary)); ?></td>
    </tr>

    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>

    <tr>
        <td><label><?php echo elgg_echo('userpoints_standard:comment'); ?></label></td>
        <td><?php echo elgg_view('input/text', array('name' => "params[generic_comment]", 'value' => $plugin->generic_comment)); ?></td>
    </tr>

    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td><label><?php echo elgg_echo('userpoints_standard:likes'); ?></label></td>
        <td><?php echo elgg_view('input/text', array('name' => "params[likes]", 'value' => $plugin->likes)); ?></td>
    </tr>

    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td><label><?php echo elgg_echo('userpoints_standard:login'); ?></label></td>
        <td><?php echo elgg_view('input/text', array('name' => "params[login]", 'value' => $plugin->login)); ?></td>
    </tr>
 
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td><label><?php echo elgg_echo('userpoints_standard:gold'); ?></label></td>
        <td><?php echo elgg_view('input/text', array('name' => "params[gold]", 'value' => $plugin->gold)); ?></td>
    </tr>
 
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td><label><?php echo elgg_echo('userpoints_standard:silver'); ?></label></td>
        <td><?php echo elgg_view('input/text', array('name' => "params[silver]", 'value' => $plugin->silver)); ?></td>
    </tr>
 
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td><label><?php echo elgg_echo('userpoints_standard:bronze'); ?></label></td>
        <td><?php echo elgg_view('input/text', array('name' => "params[bronze]", 'value' => $plugin->bronze)); ?></td>
    </tr>
 

    <tr><td></td><td>&nbsp;</td></tr>
    <tr><td><h3><?php echo elgg_echo('userpoints_standard:misc'); ?></h3></td><td>&nbsp;</td></tr>
    <tr><td colspan="2"><hr /><br /></td></tr>

    <tr>
        <td><label><?php echo elgg_echo('userpoints_standard:delete'); ?></label></td>
        <td><?php echo elgg_view('input/dropdown', array(
                             'name' => 'params[delete]',
                             'options_values' => array('1' => 'Yes', '0' => 'No'),
                             'value' => $plugin->delete
                             )
                        );
            ?>
        </td>
    </tr>

  </table>
  </form>
</div>
