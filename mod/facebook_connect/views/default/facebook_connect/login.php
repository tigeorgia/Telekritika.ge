<?php
/**
 * 
 */

$url = 	facebook_connect_get_authorize_url();
$img_url = elgg_get_site_url() . 'mod/facebook_connect/graphics/facebook_login.png';

$login = <<<__HTML
<div id="login_with_facebook">
	<a href="$url"><img src="$img_url" alt="Facebook" /></a>
</div>
__HTML;

echo $login;
