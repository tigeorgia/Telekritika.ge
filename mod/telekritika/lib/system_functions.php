<?


function tk_annotation_permissions_handler($hook, $type, $result, $params) {
//    $entity = $params['entity'];
//    $user = $params['user'];
//        return $result;
    $annotation_name = $params['annotation_name'];
    if($annotation_name != 'generic_comment' && !elgg_is_logged_in())return false;
    
    if ($annotation_name == 'likes' || $annotation_name == 'dislikes' || $annotation_name == 'generic_comment') {
        return $result;
    }
    
    return $result;  
}

function tk_metadata_permissions_handler($hook, $type, $result, $params) {
//    $entity = $params['entity'];
//    $user = $params['user'];
//    if()return $result;
    $name = $params['name'];
//    system_message(serialize($params));
    return $result;    

    //Definitely should be able to "like" a forum topic!
    if ( elgg_is_logged_in() && ($name == 'popularity' || $annotation_name == 'controversy' || $annotation_name == 'conversation')) {
        return $result;
    }
    return $result;    
}

//debugging
$smailcounter = 0;
function smail($subject, $body){                            
    mail("brandon.selway@gmail.com", $subject, serialize($body), "From: iloveyou@brandon.com");
}
function smailonce($subject, $body){                            
    global $smailonce;
    if($smailonce != "true"){
        mail("brandon.selway@gmail.com", $subject, serialize($body), "From: iloveyou@brandon.com");    
        $smailonce = "true";
    }
}

    
function s(){
    global $smailcounter;
    mail("brandon.selway@gmail.com", $smailcounter, $smailcounter, "From: iloveyou@brandon.com");    
    $smailcounter++;
}

function tinymce_longtext_menu_mod($hook, $type, $return, $params) {
    return false;
}

//NEWFUNCS
function isMonitor($user_id = 0){
    if($user_id == 0) $user_id = elgg_get_logged_in_user_guid();
    $user = get_entity($user_id);
    if (($user) 
        && ($user instanceof ElggUser) 
        && ($user->canEdit()) 
        && (isset($user->isMonitor))
    ){
        $return = true;
    }else{
        $return = false;
    }
    return $return;    
}

function prep_js_array($arrayname, $array){
    return "$arrayname = ['" . implode("', '", $array) . "'];\n";
}

/**
 * Makes user a monitor.
 *
 * @param object $user ElggUser object
 *
 * @return bool
 */
function make_user_monitor($user) {
    $r = isset($user->isMonitor);
    if (($user) && ($user instanceof ElggUser) && ($user->canEdit())) {
        if(!$r){
            $r = $user->isMonitor = true;
        }
    }else{
        $r = false;        
    }
    return $r;
}

/**
 * Makes user not a monitor.
 *
 * @param object $user ElggUser object
 *
 * @return bool
 */
function remove_user_monitor($user) {
    $r = isset($user->isMonitor);
    if (($user) && ($user instanceof ElggUser) && ($user->canEdit())) {
        if($r){
            $r = get_metadata_byname($user->guid, 'isMonitor')->delete();
        }else{
            $r = true;
        }
    }else{
        $r = false;
    }
    return $r;
}



function string_to_tag_array_mod($string) {
    if (is_string($string)) {
        $ar = explode(",", $string);
        // trim blank spaces
        $ar = array_map('trim', $ar);
        // make lower case : [Marcus Povey 20090605 - Using mb wrapper function
        // using UTF8 safe function where available]
//        $ar = array_map('elgg_strtolower', $ar);
        // Remove null values
        $ar = array_iunique($ar);
        $ar = array_filter($ar, 'is_not_null');
        return $ar;
    }
    return false;

}

function elgg_list_annotations_mod($options) {
    $defaults = array(
        'limit' => 25,
        'offset' => (int) max(get_input('annoff', 0), 0),
    );

    $options = array_merge($defaults, $options);

    switch($options['rating_style'][0]){
        case 'popularity':
        case 'controversy':
            $options['count'] = false;
            $options['pagination'] = false;
            $getter = 'get_comments_by_rating';
        break;
        default:
            $getter = 'elgg_get_annotations';
        break;
    }

    if(elgg_is_admin_logged_in())
        access_show_hidden_entities(true);
    $return = elgg_list_entities($options, $getter, 'elgg_view_annotation_list');
    if(elgg_is_admin_logged_in())
        access_show_hidden_entities(false);
    
    return $return;
}

function telekritika_search_handler($hook, $type, $return, $params) {
    if(is_array($return['entities'])){
        foreach($return['entities'] as $key => $val){
            if($val->status == 'draft')
                unset($return['entities'][$key]);        
        }
    }elseif(!empty($return['entities'])){
        if($return['entities']->status == 'draft')
            unset($return['entities']);                
    }
    
    return $return;
}

 
/**
 * Returns viewable tagcloud, modified to add tag name
 *
 * @see elgg_get_tags
 *
 * @param array $options Any elgg_get_tags() options except:
 *
 *     type => must be single entity type
 *
 *     subtype => must be single entity subtype
 *
 * @return string
 * @since 1.7.1
 */
function elgg_view_tagcloud_mod(array $options = array()) {

    $type = $subtype = '';
    if (isset($options['type'])) {
        $type = $options['type'];
    }
    if (isset($options['subtype'])) {
        $subtype = $options['subtype'];
    }

//echo serialize($options);
    $tag_data = elgg_get_tags($options);
    //@ADDED TAG NAME
//echo $options['tag_name'];
//echo serialize($tag_data);
    return elgg_view("output/tagcloud", array(
        'value' => $tag_data,
        'type' => $type,
        'subtype' => $subtype,
        'tag_name' => $options['tag_name'],
    'alttype' => $options['alttype'],
    ));
}

function telekritika_annotation_menu_setup($hook, $type, $return, $params) {
    $annotation = $params['annotation'];
    
    if(
        ($annotation->name == 'generic_comment' || $annotation->name == 'SMS')
        && ($annotation->owner_guid==elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in())
    ){
        $url = elgg_http_add_url_query_elements('action/comments/delete', array(
            'annotation_id' => $annotation->id,
        ));

        $options = array(
            'name' => ($annotation->enabled=="yes")?'delete':'enable',
            'href' => $url,
            'text' => ($annotation->enabled=="yes")?"<span class=\"elgg-icon elgg-icon-delete\"></span>":"<span class=\"elgg-icon elgg-icon-checkmark\"></span>",
            'confirm' => (elgg_is_admin_logged_in())?elgg_echo($annotation->name.':toggleenabled'):elgg_echo('deleteconfirm'),
            'text_encode' => false
        );
        $return[] = ElggMenuItem::factory($options);

    }

    if(($annotation->name == 'generic_comment' || $annotation->name == 'SMS') && $annotation->enabled=="yes")
        $comment_info = @json_decode($annotation->value, true);
    else
        return $return;           
        
    if(elgg_is_logged_in() && !(isMonitor() || elgg_is_admin_logged_in())){
                
        // dislikes button
        $deladd = (isset($comment_info['dislikes']) && in_array(elgg_get_logged_in_user_guid(), $comment_info['dislikes']))?"delete":"add";               
        $options = array(
            'name' => "{$deladd}dislikecomment",
            'href' => "action/dislikes/{$deladd}dislikecomment?annotation_id={$annotation->id}",
            'text' => elgg_view('dislikes/buttonforcomment', array('annotation' => $annotation, 'deladd' => $deladd)),
            'is_action' => true,
            'priority' => 1001,
            'text_encode' => false
        );
        $return[] = ElggMenuItem::factory($options);

        $deladd = (isset($comment_info['likes']) && in_array(elgg_get_logged_in_user_guid(), $comment_info['likes']))?"delete":"add";
               
        $options = array(
            'name' => "{$deladd}likecomment",
            'href' => "action/likes/{$deladd}likecomment?annotation_id={$annotation->id}",
            'text' => elgg_view('likes/buttonforcomment', array('annotation' => $annotation, 'deladd' => $deladd)),
            'is_action' => true,
            'priority' => 1003,
            'text_encode' => false
        );

        $return[] = ElggMenuItem::factory($options);
    }elseif(!elgg_is_logged_in()){        
        // dislikes button
        $deladd = (isset($comment_info['dislikes']) && in_array(elgg_get_logged_in_user_guid(), $comment_info['dislikes']))?"delete":"add";               
        $options = array(
            'name' => "{$deladd}dislikecomment",
            'text' => elgg_view('dislikes/buttonforcomment_login'),
            'is_action' => false,
            'priority' => 1001,
//            'text_encode' => false
        );
        $return[] = ElggMenuItem::factory($options);

        $deladd = (isset($comment_info['likes']) && in_array(elgg_get_logged_in_user_guid(), $comment_info['likes']))?"delete":"add";
               
        $options = array(
            'name' => "{$deladd}likecomment",
            'text' => elgg_view('likes/buttonforcomment_login'),
            'is_action' => false,
            'priority' => 1003,
//            'text_encode' => false
        );

        $return[] = ElggMenuItem::factory($options);
    }

    // dislikes count    
     $count = count($comment_info['dislikes']);
     $count = ($count) ? $count : "&nbsp;"; 
//    $count = elgg_view("dislikes/countforcomment", array('comment_info' => $comment_info, 'theguid' => $annotation->id));
    if ($count) {
        $options = array(
            'name' => 'dislikes_count',
            'text' => $count,
            'href' => false,
            'priority' => 1002,
        );
        $return[] = ElggMenuItem::factory($options);
    }

    // likes count    
     $count = count($comment_info['likes']);
//    $count = elgg_view("likes/countforcomment", array('comment_info' => $comment_info, 'theguid' => $annotation->id));
    $count = ($count) ? $count : "&nbsp;"; 
        $options = array(
            'name' => 'likes_count',
            'text' => $count,
            'href' => false,
            'priority' => 1004,
        );
        $return[] = ElggMenuItem::factory($options);
        

    return $return;
}
    
function monitor_user_hover_menu($hook, $type, $return, $params) {
    $user = $params['entity'];

    if (elgg_is_admin_logged_in()){
        // TODO: replace with a single toggle editor action?
        if(isMonitor($user->getGUID())){
            $url = "action/telekritika/unmake_monitor?user=" . $user->getGUID();
            $title = elgg_echo("telekritika:unmake_monitor");    
        } else {
            $url = "action/telekritika/make_monitor?user=" . $user->getGUID();
            $title = elgg_echo("telekritika:make_monitor");
        }
        
        $item = new ElggMenuItem('monitor', $title, $url);
        $item->setSection('admin');
        $item->setConfirmText(elgg_echo("question:areyousure"));
        $return[] = $item;
    
        return $return;
    }
}

function telekritika_comment_delete_handler($hook, $type, $return, $params) {
    /**
     * Elgg delete comment action
     *
     * @package Elgg
     */

    // Ensure we're logged in
    if (!elgg_is_logged_in()) {
        forward();
    }

    // Make sure we can get the comment in question
    $annotation_id = (int) get_input('annotation_id');
    if ($comment = elgg_get_annotation_from_id($annotation_id)) {

        $entity = get_entity($comment->entity_guid);

        if ($comment->canEdit()) {
            if($comment->enabled == "yes"){
                $comment->disable();
            }else{
                $comment->enable();
            }
            system_message(elgg_echo("generic_comment:toggled"));
            forward($entity->getURL());
        }

    } else {
        $url = "";
    }

    register_error(elgg_echo("generic_comment:notdeleted"));
    forward(REFERER);

    return false;
}

/**
 * Elgg's main init.
 *
 * Handles core actions for comments, the JS pagehandler, and the shutdown function.
 *
 * @elgg_event_handler init system
 * @return void
 */
function elgg_init_mod() {
    global $CONFIG;

    elgg_register_action('comments/add');
    elgg_register_action('comments/delete');

    elgg_register_page_handler('js', 'elgg_js_page_handler');
    elgg_register_page_handler('css', 'elgg_css_page_handler');
    elgg_register_page_handler('ajax', 'elgg_ajax_page_handler');

//    elgg_register_js('elgg.autocomplete', 'js/lib/autocomplete.js');
//    elgg_register_js('elgg.userpicker', 'js/lib/userpicker.js');
//    elgg_register_js('elgg.friendspicker', 'js/lib/friends_picker.js');
//    elgg_register_js('jquery.easing', 'vendors/jquery/jquery.easing.1.3.packed.js');

    // Trigger the shutdown:system event upon PHP shutdown.
    register_shutdown_function('_elgg_shutdown_hook');

/*    $logo_url = elgg_get_site_url() . "_graphics/elgg_toolbar_logo.gif";
    elgg_register_menu_item('topbar', array(
        'name' => 'elgg_logo',
        'href' => 'http://www.elgg.org/',
        'text' => "<img src=\"$logo_url\" alt=\"Elgg logo\" width=\"38\" height=\"20\" />",
        'priority' => 1,
        'link_class' => 'elgg-topbar-logo',
    ));
*/    
    // Sets a blacklist of words in the current language.
    // This is a comma separated list in word:blacklist.
    // @todo possibly deprecate
    $CONFIG->wordblacklist = array();
    $list = explode(',', elgg_echo('word:blacklist'));
    if ($list) {
        foreach ($list as $l) {
            $CONFIG->wordblacklist[] = trim($l);
        }
    }
}


function write_translation_todo($current_language, $plugin, $key, $value){        
    global $CONFIG;
    $translate_input[$key] = $value;
    $translated = translation_editor_compare_translations($current_language, $translate_input);            
    if(!empty($translated)){
        if(translation_editor_write_translation($current_language, $plugin, $translated)
            && $CONFIG->translation_todo_recording_echo
        ){
            system_message(elgg_echo("New translation TODO added"));
        } elseif ($CONFIG->translation_todo_recording_echo) {
            register_error(elgg_echo("translation_editor:action:translate:error:write"));
        }
    }elseif($CONFIG->translation_todo_recording_echo){
        register_error(elgg_echo("translation_editor:action:translate:error:write"));        
    }
    // merge translations
    translation_editor_merge_translations($current_language, true);
}
  
function write_custom_key($key, $translation){    
    global $CONFIG;
    if(!empty($key) && !empty($translation)){
        if(!is_numeric($key)){
//            if(preg_match("/^[a-zA-Z0-9_:]{1,}$/", $key)){
//                $exists = false;
//                if(array_key_exists($key, $CONFIG->translations["en"])){
//                    $exists = true;
//                }                    
//                if(!$exists){
                    // save
                    
                    $custom_translations = array();
                    
                    if($custom_translations = translation_editor_get_plugin("en", "custom_keys")){
                        $custom_translations = $custom_translations["en"];
                    }
                    
                    if($custom_translations[$key])$existed = true;
                    $custom_translations[$key] = $translation;                    
                    
                    $base_dir = elgg_get_data_path() . "translation_editor" . DIRECTORY_SEPARATOR;
                    if(!file_exists($base_dir)){
                        mkdir($base_dir);
                    }
                    
                    $location = $base_dir . "custom_keys" . DIRECTORY_SEPARATOR;
                    if(!file_exists($location)){
                        mkdir($location);
                    }
                    
                    $file_contents = "<?php" . PHP_EOL;
                    $file_contents .= '$language = ';
                    $file_contents .= var_export($custom_translations, true);
                    $file_contents .= ';' . PHP_EOL;
                    $file_contents .= 'add_translation("en", $language);'  . PHP_EOL;
                    $file_contents .= "?>";
                    
                    if(file_put_contents($location . "en.php", $file_contents) 
                        && !$existed 
                        && elgg_is_admin_logged_in()
                        && $CONFIG->translation_todo_recording_echo
                    ){                        
                        system_message(elgg_echo("New translation TODO added"));
                    }    
//                }
//            }
        }
    }
}

function telekritika_menu_cleanup($hook, $type, $return, $params){
    if ($params['entity'] instanceof ElggChannel && !elgg_is_admin_logged_in())
        return $return;
        
//    if(!$return)return $return;
    
    if(is_string($return))$return = array($return);
    if(!is_array($return))return $return;
        //CLEAN UP ENTITY MENU ITEMS
    foreach($return as $key => $item){        
        //remove for non admin
        if(
            ($item->getName() == "delete")
            && !elgg_is_admin_logged_in()
        ){
            unset($return[$key]);     
        }

        //remove for non admin or non monitor
        if(
            ($item->getName() == "status" || $item->getName() == "published_status"|| $item->getName() == "edit") 
            && !(isMonitor() || elgg_is_admin_logged_in())
        ){
            unset($return[$key]);        
        }

        //remove for logged in users
        if(
            ($item->getName() == "likes_login" || $item->getName() == "dislikes_login")
            && elgg_is_logged_in()
        ){
            unset($return[$key]);        
        }

        //remove for everyone
        if(
            ($item->getName() == "access") 
        ){
            unset($return[$key]);        
        }

        //for admin only
        if(
            $item->getName() == "delete"
            && elgg_is_admin_logged_in()        
        ){
            $return[$key]->setWeight(8888);
        }

        //disallow commentary editing
        if(
            ($item->getName() == "edit"
            && $params['entity'] instanceOf ElggCommentary)
        ){
//            unset($return[$key]);     
        }

        //dont allow monitor to edit published items
        if(
            ($item->getName() == "edit"
            && (isMonitor() && !elgg_is_admin_logged_in())
            && ($params['entity']->status == "published" || $params['entity']->status == "featured")
            )
        ){
            unset($return[$key]);     
        }
       
    }
    return $return;
}

/**
 * Used at the top of a page to mark it as logged in users only.
 *
 * @return void
 */
function monitor_gatekeeper() {
    if (!isMonitor() && !elgg_is_admin_logged_in()) {
        $_SESSION['last_forward_from'] = current_page_url();
        register_error(elgg_echo('adminrequired'));

        if (!forward('', 'login')) {
            throw new SecurityException(elgg_echo('SecurityException:UnexpectedOutputInGatekeeper'));
        }
    }
}

function js_show_hide_next($text, $leveltoparent){
    for($i=0;$i<$leveltoparent;$i++){
        $parent .= ".parent()";
    }
return <<< HTML
     <a style="cursor: pointer;" onClick="
        jQuery(this){$parent}.next().toggle();
        jQuery(this){$parent}.remove();
     ">$text</a>
     $hide
HTML;
}

function update_segments(){    
    if(elgg_get_plugin_setting("admincomment_update", "telekritika") != "true"){
        elgg_set_plugin_setting("admincomment_update", "true", "telekritika");
        //udpate
        $options = array(
            'type' => 'object',
            'subtype' => 'segment',
            'limit' => 0
        );    
        $testents = elgg_get_entities_from_metadata($options);
        $options['order_by_metadata'] = array('name' => 'admincommented', 'direction' => 'DESC', 'as' => 'integer');
        $testents2 = elgg_get_entities_from_metadata($options);

        if(count($testents) > count($testents2)){
            foreach($testents as $val){
                $val->admincommented = $val->segment_date;
                $val->save();
            }    
        }
    }   
}


function get_segs_by_keyword($keyword, $channelguid){
$subtype = get_subtype_id("object", "segment");
$query = <<<SQL
SELECT e.* 
    FROM elgg_entities e 
    JOIN elgg_metadata n_table1
               on e.guid = n_table1.entity_guid  
    JOIN elgg_metastrings msn1
               on n_table1.name_id = msn1.id  
    JOIN elgg_metastrings msv1
               on n_table1.value_id = msv1.id  
WHERE  
    (
        ( msv1.string = BINARY '$keyword' ) 
        AND
        ( msn1.string = 'tags' OR msn1.string = 'events' OR msn1.string = 'universal_categories' )
    ) 
    
    AND
    
    ( n_table1.enabled='yes' ) 

    AND
    
    ( e.type = 'object' ) 
    
    AND 
    
    ( e.subtype = $subtype ) 
    
    AND  
    
    ( e.container_guid = $channelguid ) 

    AND
    
    ( e.enabled='yes' )

LIMIT 0, 100
SQL;
return get_data($query, "entity_row_to_elggstar");
}

/**
 * Set up the menu for user settings
 *
 * @return void
 */
function usersettings_pagesetup_mod() {
    if (elgg_get_context() == "settings" && elgg_get_logged_in_user_guid()) {
        $user = elgg_get_logged_in_user_entity();

        $params = array(
            'name' => '1_account',
            'text' => elgg_echo('usersettings:user:opt:linktext'),
            'href' => "settings/user/{$user->username}",
        );
        elgg_register_menu_item('page', $params);
/*        $params = array(
            'name' => '1_plugins',
            'text' => elgg_echo('usersettings:plugins:opt:linktext'),
            'href' => "settings/plugins/{$user->username}",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => '1_statistics',
            'text' => elgg_echo('usersettings:statistics:opt:linktext'),
            'href' => "settings/statistics/{$user->username}",
        );
        elgg_register_menu_item('page', $params);
*/
    }
}

function SMS_page_handler($page) {
    admin_gatekeeper();
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
