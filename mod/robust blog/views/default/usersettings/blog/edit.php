<p>
<?php 
	$hash = substr(md5(md5($vars['user']->username).get_site_secret()),5,9);

	echo elgg_echo('trackback:instructions');
	echo "<br /><br />";
	echo "{$vars['url']}pg/trackback/{$vars['user']->username}/{$hash}";
?>
</p>