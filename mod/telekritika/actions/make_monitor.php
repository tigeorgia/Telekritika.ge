<?php 
    
    admin_gatekeeper();
    
    $result = false;
    
    $user = get_input("user");
    
    $user = get_entity($user);
    
    $result = make_user_monitor($user);
    
    if(!$result){
        register_error(elgg_echo("telekritika:action:make_monitor:error"));
    } else {
        system_message(elgg_echo("telekritika:action:make_monitor:success"));
    }
    
    forward(REFERER);