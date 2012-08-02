<?
  
//AJAX SYSTEM REWORK

function grab_pubsub_vars($vars){
    foreach($vars as $key => $val){
        if(strpos($key, "data-") !== false)continue;
        unset($vars[$key]);        
    }
    return $vars;
}

                                     
function ajax_action_sorter($obj_a, $obj_b) {
    if($obj_a['type'] == "action") { return -1; }else{ return 1; };
    return 0;
}

function ajax_forward_hook_mod($hook, $type, $reason, $params) {
    global $ajaxAct;
    if (elgg_is_xhr() && 
        ($ajaxAct !== "sub" || isset($_SESSION['msg']["error"]) || !empty($_SESSION['msg']["error"]))
        ) {
        // always pass the full structure to avoid boilerplate JS code.
        $params = array(
            'output' => '',
            'status' => 0,
            'system_messages' => array(
                'error' => array(),
                'success' => array()
            ),
            'extra' => $_SESSION['extra_objects'],
        );
        
        //grab any data echo'd in the action
        $output = ob_get_clean();

        //Avoid double-encoding in case data is json
        $json = json_decode($output);
        if (isset($json)) {
            $params['output'] = $json;
        } else {
            $params['output'] = $output;
        }

        //Grab any system messages so we can inject them via ajax too
        $system_messages = system_messages(NULL, "");

        if (isset($system_messages['success'])) {
            $params['system_messages']['success'] = $system_messages['success'];
        }

        if (isset($system_messages['error'])) {
            $params['system_messages']['error'] = $system_messages['error'];
            $params['status'] = -1;
        }

        // Check the requester can accept JSON responses, if not fall back to
        // returning JSON in a plain-text response.  Some libraries request
        // JSON in an invisible iframe which they then read from the iframe,
        // however some browsers will not accept the JSON MIME type.
        if (stripos($_SERVER['HTTP_ACCEPT'], 'application/json') === FALSE) {
            header("Content-type: text/plain");
        }
        else {
            header("Content-type: application/json");
        }

        echo json_encode($params);

        exit;
    }elseif(elgg_is_xhr() && $ajaxAct === "sub"){
        return false;        
    }
}

function ajax_action_hook_mod() {
    global $ajaxAct;
    if (elgg_is_xhr() && $ajaxAct !== "sub") {
        ob_start();
    }
}

function prep_pubsub_string($vars){
    $string = "";
 
    foreach($vars as $key => $val){
        if(strpos($key, "data-") !== false){
            switch($key){
                case "data-pub":            
                case "data-sub":            
                case "data-prejs":            
                case "data-postjs":            
                case "data-onlyjs":            
                case "data-hoverjs":            
                    if($val && is_array($val)){
                        $string .= " {$key}=\"|";
                        $string .= implode("|", $val);
                        $string .= "|\"";        
                    }elseif($val){
                        $string .= " {$key}=\"|{$val}|\"";        
                    }
                break;
                default:
                    if($val && is_array($val)){
                        $string .= " {$key}=\"|";
                        $string .= implode("|", $val);
                        $string .= "|\"";        
                    }elseif($val){
                        $string .= " {$key}=\"{$val}\"";        
                    }
                break;
            }             
        }
    }     
    return $string;
}

function prep_pipe_string($pubstrings){
    $string = "";
    if($pubstrings && is_array($pubstrings)){
        $string .= "|";
        $string .= implode("|", $pubstrings);
        $string .= "|";        
    }elseif($pubstrings){
        $string .= "|{$pubstrings}|";        
    }    
    return $string;
}

function add_extra_obj($array){
    if(!$_SESSION['extra_objects']){
        $_SESSION['extra_objects'] = array();    
    }
    if (!is_array($array) && ($json = json_decode($array, TRUE))) {
        $_SESSION['extra_objects'] = array_merge($_SESSION['extra_objects'], $json);
    } else {
        $_SESSION['extra_objects'] = array_merge($_SESSION['extra_objects'], $array);
    }    
}
