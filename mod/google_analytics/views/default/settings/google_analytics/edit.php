<?php
	$analytics = $vars['entity']->analytics;
?>
 
<br/>
  <p>
    <b><?php echo elgg_echo('google-analytics:lblID'); ?></b> <?php echo elgg_echo('google-analytics:lblExample'); ?><br /><br/>
	<?php
		echo elgg_view('input/text', array(
			'internalname' => 'params[analytics]',
			'value' => $analytics
		));
	?>
     <br/><br/> <i><?php echo elgg_echo('google-analytics:lblHelp'); ?> <a href="http://www.google.com/analytics/">Google Analytics</a></i>.
  </p>