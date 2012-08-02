<?php                              
// newest users
$users = show_all_users();

?>

<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<h3><?php echo elgg_echo('admin:users:newest'); ?></h3>
	</div>
	<div class="elgg-body">
		<?php echo $users; ?>
	</div>
</div>
