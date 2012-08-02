<?
//SMS functions    
/*function SMS_page_handler($page) {
    elgg_set_ignore_access(true);
    $entity = $SMS = SMS_object(); 

    $vars['entity'] = $entity;
    $vars['show_add_form'] = false;
    $vars['class'] = elgg_extract('class', $vars, "sms-comments");
    $vars['limit'] = 5;
    $vars['order_by'] = 'n_table.id desc';
    $vars['annotation_name'] = 'SMS';

    $content = elgg_view_comments($SMS, false, $vars);
    
    $body = elgg_view_layout('content', array(
        'content' => $content,
        'title' => $title,
        'filter' => '',
        'header' => '',
    ));

    echo elgg_view_page($title, $body);
}

function SMS_url_handler(){
    return "SMS";
}
*/

function SMS_object(){
    $SMS_guid = get_plugin_setting('SMS_guid','telekritika');
    $object = get_entity($SMS_guid);
    if(!$object){
        $object = set_SMS_object();
        set_plugin_setting('SMS_guid', $object->guid, 'telekritika');
    }
    return $object;
}

function record_sms($data) {
    //$json_data = sanitise_string($json_data);
    $anon_guid = get_plugin_setting('anon_guid','speak_freely');
    $user = get_user($anon_guid);
    if(!$user)
        return "no user object for sms, please ensure plugin Speak Freely is enabled!";
    $SMSreceiver = SMS_object()->guid;
    $data = urldecode($data);
    $annotation = create_annotation($SMSreceiver,
                                'SMS',
                                $data,
                                "",
                                $user->guid,
                                2);
    if($annotation) 
        return "\" $data . \" created.";
    else
        return "annotation failed with supplied \" data \": $data";
}
                      
function set_SMS_object(){
    global $CONFIG;

    //first see if a object has been created previously
    $objects = elgg_get_entities_from_metadata(array('title' => 'SMSreceiver', 'value' => TRUE, 'types' => 'object'));

    if(count($objects) == 0 || !$objects || !($object instanceof ElggObject)){ //no previous object - create a new one
                $objectname = "SMSreceiver";    
        
                //let's make a object
                $object = new ElggObject();
                $object->title = $objectname;
                $object->subtype = $objectname;
                $object->access_id = 2;
                $object->owner_guid = elgg_get_site_entity()->guid;
                $object->container_guid = elgg_get_site_entity()->guid;
                $object->save();
                
                // set the plugin-identifiable metadata
                $object->telekritika = TRUE;    
    }else{ // we found our object through metadata
        $object = $objects[0];
    }
    
    return $object;
}

function get_tweets_to_annotations($hashtags, $rpp = 20){
    if($tweetarray = get_tweets($hashtags, $rpp)){
        foreach($tweetarray as $key => $tweet){
            $tweetarray2[$key] = new stdClass;
            $tweetarray2[$key]->type = "tweet";
            $tweetarray2[$key]->time_created = strtotime($tweet->created_at);
            $text = $tweet->text;
            $text = htmlEscapeAndLinkUrls($text);
            $text = str_replace("http:", "https:", $text);
            foreach($hashtags as $hashtag){
                $tag = substr($hashtag, 1);
                $text = str_ireplace($hashtag, "<a href=\"https://twitter.com/#!/search/realtime/%23$tag\" target=\"_blank\">$hashtag</a>", $text);
            }
            $tweetarray2[$key]->value = $text;
            $tweetarray2[$key]->author = $tweet->from_user;
            $tweetarray2[$key]->url = "https://twitter.com/{$tweet->from_user}/status/{$tweet->id_str}";
        }
        return $tweetarray2;    
    }
    return array();
}

function get_tweets($hashtags, $rpp){
    $hashstring = is_array($hashtags) ? urlencode( implode("+OR+", $hashtags) ) : urlencode( $hashtags );
    $url = "http://search.twitter.com/search.json?q=$hashstring-filter:retweets";  //&include_entities=1";
    if($rpp)$url.="&rpp=$rpp";
    $data = curl_data($url);
    if($tweets = @json_decode($data)){
        return $tweets->results;
    }
    return false;
}

