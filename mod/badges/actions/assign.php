<?php

    global $CONFIG;

    admin_gatekeeper();
    action_gatekeeper();

    $user = get_user_by_username(get_input('username'));

    if ($user) {
        $user->badges_badge = (int)get_input('badge');
        $user->badges_locked = (int)get_input('locked');
        system_message(elgg_echo("badges:assign:success"));
    } else {
        system_message(elgg_echo("badges:assign:nouser"));
    }

    forward($CONFIG->wwwroot . 'mod/badges/admin.php?tab=list');

?>
