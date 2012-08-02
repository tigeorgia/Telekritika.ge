<?php
	global $CONFIG;
	global $HA_SOCIAL_LOGIN_PROVIDERS_CONFIG;

	require_once "{$CONFIG->pluginspath}elgg_social_login/settings.php"; 

	// display "Or connect with" message, or not.. ?
	echo "<div style='float:right;padding:10px;padding-top:0px;margin-top:5px;'><b>" . elgg_echo("FB:connectwith") . "</b>";

	// display provider icons
	foreach( $HA_SOCIAL_LOGIN_PROVIDERS_CONFIG AS $item ){
		$provider_id     = @ $item["provider_id"];
		$provider_name   = @ $item["provider_name"];

		$assets_base_url = "{$vars['url']}mod/elgg_social_login/graphics/";

		if( get_plugin_setting( 'ha_settings_' . $provider_id . '_enabled', 'elgg_social_login' ) ){
			?>
			<a href="javascript:void(0);" title="Connect with <?php echo $provider_name ?>" class="ha_connect_with_provider" provider="<?php echo $provider_id ?>">
				<img alt="<?php echo $provider_name ?>" title="<?php echo $provider_name ?>" src="<?php echo $assets_base_url . "32x32/" . strtolower( $provider_id ) . '.png' ?>" />
			</a>
			<?php
		} 
	} 

	// provide popup url for hybridauth callback
	?>
		<input id="ha_popup_base_url" type="hidden" value="<?php echo "{$vars['url']}mod/elgg_social_login/"; ?>authenticate.php?" />
	<?php

	// link attribution && privacy page 
/*	<p style="border-top:1px dotted #999;font-size: 10px;">
		Powered by <a href="http://hybridauth.sourceforge.net" target="_blank">HybridAuth</a>

		<?php
			if( get_plugin_setting( 'ha_settings_privacy_page', 'elgg_social_login' ) ){
		?> 
			| <a href="<?php echo get_plugin_setting( 'ha_settings_privacy_page', 'elgg_social_login' ) ?>" target="_blank">Privacy</a>
		<?php
			}
		?> 
	</p>
	*/
    echo "</div>";
?>
<script>
	$(function(){
		$(".ha_connect_with_provider").click(function(){
			popupurl = $("#ha_popup_base_url").val();
			provider = $(this).attr("provider");

			window.open(
				popupurl+"provider="+provider,
				"hybridauth_social_sing_on", 
				"location=1,status=0,scrollbars=0,width=800,height=570"
			); 
		});
	});  
</script> 
