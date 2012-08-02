<?php
	/**
	 * Badges CSS
	 */
    /* margin: 5px 0 0; */
?>

.badges_profile{
    font-weight: bold;
}

.badges_profile_description {
    font-family: sans-serif;
    font-style: normal;
    font-variant: normal;
    font-weight: lighter;
    font-size: smaller;
    line-height: 100%;
    text-decoration: none;
    text-transform: none;
    text-align: left;
    text-indent: 0ex;
}

.badges_settings_info {
    font-family: sans-serif;
    font-style: normal;
    font-variant: normal;
    font-weight: lighter;
    font-size: smaller;
    line-height: 100%;
    text-decoration: none;
    text-transform: none;
    text-align: left;
    text-indent: 0ex;
}

<?php $badgeURL =  elgg_add_action_tokens_to_url($vars['url'] . "_graphics/river_icons/river_icon_profile.gif"); ?>

.river_object_badge_update {
    background: url(<?php echo $badgeURL; ?>) no-repeat left -1px;
}
