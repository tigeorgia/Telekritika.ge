<?php
    global $CONFIG;
    if (isadminloggedin()) {
            echo "<a href=\"". $CONFIG->wwwroot . "mod/badges/admin.php?tab=assign&user_guid=" . $vars['entity']->guid ."\">" . elgg_echo('badges:assign_badge') . "</a>";
    }
?>
