<?
function generic_FBobjectify($object){
    global $CONFIG;
    $FBappId = get_plugin_setting('ha_settings_Facebook_app_id','elgg_social_login');
    $FBtitle = $object->title;
    $FBdesc = addslashes(elgg_get_excerpt($object->description, 150));
    $subtype = get_subtype_from_id($object->subtype);
    
    return array(
        'prefix' => "prefix=\"og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# telekritika: http://ogp.me/ns/fb/telekritika#\"",
        'headers' => "
              <meta property=\"fb:app_id\" content=\"$FBappId\" /> 
              <meta property=\"og:type\" content=\"telekritika:$subtype\" /> 
              <meta property=\"og:title\" content=\"$FBtitle\" /> 
              <meta property=\"og:image\" content=\"{$CONFIG->mainlogosrc}\" /> 
              <meta property=\"og:description\" content=\"$FBdesc\" /> 
              <meta property=\"og:url\" content=\"{$object->getURL()}\" />
        ",
    );             
}


function publish_to_facebook_hook($event, $object_type, $object){
    //@todo test if user allows us to post to FB?    
//    system_message("test");
    return true;
    if(!($object->enabled == "yes" && ($object->status == "published" || $object->status == "featured" || $object_type == "annotation")))return true;
//    system_message("test2");
    if($object->subtype)$object_type = $object->getSubtype();
    if($object_type == "annotation")$object_type = $object->name;
//    system_message("test3".$object_type);
    switch($object_type){
        case "commentary":
            $theobject = $object_type;
            $theaction = "publish";
            $entity = $object;
            $userid = $object->owner_guid;
        break;        
        case "generic_comment":
        case "likes":
        case "dislikes":        
            $entity = get_entity($object->entity_guid);
            $theobject = $entity->subtype;
            if(!($theobject == "article" || $theobject == "commentary" || $theobject == "segment"))return true;
            $theaction = ($object_type == "likes" || $object_type == "dislikes") ? "rate" : "discuss";
            $userid = $object->owner_guid;
        break;
        default:
            return true;
        break;        
    }
    $theurl = $entity->getURL();
    post_to_FB($userid, $theaction, $theobject, $theurl);
    return true;
}

function post_to_FB($userid, $theaction, $theobject, $theurl){
    global $CONFIG;
    include_once($CONFIG->path."mod/elgg_social_login/vendors/hybridauth/Hybrid/thirdparty/Facebook/base_facebook.php");
    include_once($CONFIG->path."mod/elgg_social_login/vendors/hybridauth/Hybrid/thirdparty/Facebook/facebook.php");
    
    $uid = get_plugin_usersetting("uid",$userid,"elgg_social_login");
    if(empty($uid))return true;

    // parse out Facebook_985540: split"_"  FBid = [1]
    $FBid = ($FBid = explode("_", $uid)) ? $FBid[1] : false ;
    if(empty($FBid))return true;
    
    $FBtoken = get_plugin_usersetting("FBtoken",$userid,"elgg_social_login");    
    if(empty($FBtoken))return true;

    $FBappId = get_plugin_setting('ha_settings_Facebook_app_id','elgg_social_login');
    if(empty($FBappId))return true;
    $FBappSecret = get_plugin_setting('ha_settings_Facebook_app_secret','elgg_social_login');
    if(empty($FBappSecret))return true;

    $facebook = new Facebook(array(
      'appId'  => $FBappId,
      'secret' => $FBappSecret,
    ));
    
    $appAccessQ = "https://graph.facebook.com/oauth/access_token?client_id=$FBappId&client_secret=$FBappSecret&grant_type=client_credentials";
    if($appToken = curl_data($appAccessQ)){
        $postTo = "/$FBid/telekritika:$theaction?$theobject=$theurl&access_token=$appToken";
        if($return = $facebook->api($postTo, 'post')){
            //echo "<p>2WORKED: ".serialize($return);
            //return true;            
        }
    }
    return true;
}
