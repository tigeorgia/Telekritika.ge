<?php

    admin_gatekeeper();
    action_gatekeeper();

    $guid = (int)get_input('guid');

    $options['views'] = "river/object/badge/awardMonth";
    $options['object_guids'] = $guid;

    elgg_delete_river($options); 

    $file = get_entity($guid);
    $filename = $file->getFilenameOnFilestore();
                                  
    $results = $file->delete();
                                                                           
    
    if ($results != '') {
        system_message(elgg_echo("badges:delete_success"));
    } else {
        system_message(elgg_echo("badges:delete_fail") . ' ' . $filename);
    }
    
    forward($_SERVER['HTTP_REFERER']);

?>
