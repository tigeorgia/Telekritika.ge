<?php      
global $ajaxAct;
$ajaxAct = "sub";
$actors = json_decode(get_input('json'), TRUE);

usort($actors, 'ajax_action_sorter');

foreach($actors as $index => $actor){
    $_REQUEST = array_merge($_REQUEST, $actor);
    $_POST = array_merge($_POST, $actor);
    switch($actor['type']){
        case "action":
            action($actor['action']);
        break;
        
        case "add":
            $vars = $actor;
            unset($vars['type']);
            $actors[$index]['data'] = $actor['add']($vars);            
        break;                

        case "refresh":
            $vars = $actor;
            unset($vars['type']);
            $actors[$index]['data'] = $actor['refresh']($vars);            
        break;        
    }
} 

$actors = array_values($actors);

$ajaxAct = "output";
/*$x=0;
foreach($actors as $actor){
    json_encode($actor);
    if($x != 0){
        smail($x,serialize($actor));    
    }
    $x++;           
};*/
echo json_encode($actors);
forward(REFERER);