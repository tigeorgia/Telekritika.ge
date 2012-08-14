<?php

ini_set('memory_limit', '-1');

if($_COOKIE['beenawhile'] != "beenawhile"){
    $CONFIG->slideIndex = true;
    setcookie("beenawhile", "beenawhile");
}else{
    $CONFIG->slideIndex = false;
}

// Include some utility functions and view functions
$currentdir = dirname(__FILE__);
//smail($currentdir);

require_once $currentdir . "/lib/system_functions.php"; 
require_once $currentdir . "/lib/tk_views.php";
require_once $currentdir . "/lib/util_functions.php";
require_once $currentdir . "/lib/cv_functions.php";
require_once $currentdir . "/lib/badge_functions.php";
require_once $currentdir . "/lib/ranking_functions.php"; 
require_once $currentdir . "/lib/fb_functions.php";
require_once $currentdir . "/lib/ajax_functions.php";   
require_once $currentdir . "/lib/sms_functions.php";

elgg_unregister_event_handler('init', 'system', 'elgg_init');
elgg_register_event_handler('init', 'system', 'elgg_init_mod');

elgg_unregister_event_handler('pagesetup', 'system', 'users_pagesetup');
elgg_register_event_handler('pagesetup', 'system', 'users_pagesetup_mod', 0);

elgg_unregister_event_handler('pagesetup', 'system', 'usersettings_pagesetup');
elgg_register_event_handler('pagesetup', 'system', 'usersettings_pagesetup_mod', 0);

elgg_register_event_handler('init', 'system', 'telekritika_init');

function telekritika_init() {
    $currentdir = dirname(__FILE__);
    //configuration settings
    require_once (elgg_get_plugins_path() . 'telekritika/lib/config.php');

    //Replace the default index page
    elgg_register_plugin_hook_handler('index', 'system', 'telekritika');
    
    // register actions
    $action_path = elgg_get_plugins_path() . 'telekritika/actions';
    elgg_register_action('login', "$action_path/login.php", 'public');
    elgg_register_action('unmake_monitor', "$action_path/unmake_monitor.php", 'public');
    elgg_register_action('make_monitor', "$action_path/make_monitor.php", 'public');
    elgg_register_action('useradd', "$action_path/useradd.php", 'public');
    elgg_register_action('comments/add', "$action_path/comments/add.php", 'public');
    elgg_register_action('parseAJAX', "$action_path/parseAJAX.php", 'public');
    elgg_register_action('notify_error', "$action_path/notify_error.php", 'public');
    // Admin only actions
    elgg_register_action("telekritika/make_monitor", $currentdir . "/actions/make_monitor.php", "admin");
    elgg_register_action("telekritika/unmake_monitor", $currentdir . "/actions/unmake_monitor.php", "admin");
        
    //elgg_register_event_handler('create','annotation','publish_to_facebook_hook');
    elgg_register_event_handler('create','object','publish_to_facebook_hook');
    //elgg_register_event_handler('update','object','publish_to_facebook_hook');    
    //update popularity, controversy, conversation metadata when comment like or dislike is entered
    elgg_register_event_handler('create','annotation','update_rating_style');
    elgg_register_event_handler('delete','annotation','update_rating_style');

    //ajax system fixes
    elgg_unregister_plugin_hook_handler('forward', 'all', 'ajax_forward_hook');
    elgg_register_plugin_hook_handler('forward', 'all', 'ajax_forward_hook_mod');
    elgg_unregister_plugin_hook_handler('forward', 'all', 'ajax_action_hook');
    elgg_register_plugin_hook_handler('forward', 'all', 'ajax_action_hook_mod');
    //register daily cron job to recallibrate users points!
    elgg_register_plugin_hook_handler('cron', 'daily', 'calibrate_points_month', 999);
    elgg_register_plugin_hook_handler('cron', 'weekly', 'calibrate_points_total', 999);
    //register monthly cron job to award users of the month!
    elgg_register_plugin_hook_handler('cron', 'monthly', 'apply_user_of_the_month', 999);        
    //like dislike and comment permission handler (require login otherwise allow)
    elgg_register_plugin_hook_handler('permissions_check:annotate', 'all', 'tk_annotation_permissions_handler');
    elgg_register_plugin_hook_handler('permissions_check:metadata', 'all', 'tk_metadata_permissions_handler');
    //menucleanup
    elgg_unregister_plugin_hook_handler('register', 'menu:annotation', 'elgg_annotation_menu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:annotation', 'telekritika_annotation_menu_setup');      
    elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'monitor_user_hover_menu');   
    elgg_register_plugin_hook_handler('register', 'menu:longtext', 'tinymce_longtext_menu_mod', 999); 
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'telekritika_menu_cleanup', 999999);
    elgg_register_plugin_hook_handler('register', 'menu:river', 'telekritika_menu_cleanup', 999999);
    elgg_register_plugin_hook_handler('register', 'menu:annotation', 'telekritika_menu_cleanup', 999999);    
    //disable comments delete, force comments DISABLE instead
    elgg_unregister_plugin_hook_handler('action', 'comments/delete', 'comments/delete');
    elgg_register_plugin_hook_handler('action', 'comments/delete', 'telekritika_comment_delete_handler');
    //new search handler
    elgg_register_plugin_hook_handler('search', 'all', 'telekritika_search_handler');
    
    elgg_register_page_handler('SMS', 'SMS_page_handler');
    elgg_register_entity_url_handler('object', 'SMSreceiver', 'SMS_url_handler');
    elgg_register_page_handler('critics', 'tk_critics_page_handler');            
    elgg_register_page_handler('badge', 'view_badge_page_handler');                
    
    //custom searchable tags
    //elgg_register_tag_metadata_name('tags');    
    elgg_register_tag_metadata_name('events');    
    elgg_register_tag_metadata_name('universal_categories');    

    // xtend JavaScript
    elgg_extend_view('js/elgg', 'js/universal/placeholder');
    elgg_extend_view('js/elgg', 'js/universal/slider');
    elgg_extend_view('js/elgg', 'js/universal/pubsub');
    elgg_extend_view('js/elgg', 'js/universal/scroll');
    // Extend system CSS with our own styles
    elgg_extend_view('css/elgg', 'telekritika/css');
    elgg_extend_view('css/elgg', 'telekritika/slider');

    //expose sms function
    expose_function("SMS.receiver", 
                "record_sms", 
                 array("data" => array('type' => 'string', 'required' => true)),
                 'SMS receiver.',
                 'GET',
                //    null,
                 true,
                 false
           );        
}


//custom index page
function telekritika($hook, $type, $return, $params) {
    if ($return == true) {
        // another hook has already replaced the front page
        return $return;
    }
    if (!include_once(dirname(__FILE__) . "/index.php")) {
        return false;
    }
    // return true to signify that we have handled the front page
    return true;
}


function add_template_modules(array &$params = array(), $template = null){
    global $CONFIG;
    //main become a critic module block
    $params['content']['side'][] = elgg_view('page/components/becomeacritic_1');
    //main become a critic module block

    //most controversial popular discussed tabs
    $listbytabs['body'][] = array(
        'content' => view_commentaries_by_rating(array('rating_style' => 'controversy', 'module_view' => TRUE, 'pagination' => FALSE)),
        'title' => elgg_echo("controversy"),
        //'title' => "controversy",
    );
    $listbytabs['body'][] = array(
        'content' => view_commentaries_by_rating(array('rating_style' => 'popularity', 'module_view' => TRUE, 'pagination' => FALSE)),
        'title' => elgg_echo("popularity"),
        //'title' => "popularity",
    );
    $listbytabs['body'][] = array(
        'content' => view_commentaries_by_rating(array('rating_style' => 'conversation', 'module_view' => TRUE, 'pagination' => FALSE)),
        'title' => elgg_echo("conversation"),
        //'title' => "conversation",
    );
    $listbytabs['class'] = "listbytabs automatedtabs";
    $params['content']['side'][] = $listbytabs;
    //most controversial popular discussed tabs

    $options = array(
        'type' => 'object',
//        'subtype' => 'commentary',
        'threshold' => 0,
        'limit' => 25,
        'tag_name' => 'tags',
    );
    $options['modified_time_lower'] = time() - $CONFIG->time_until_expired;
    $listbytabss['body'][] = array(
        'content' => elgg_view("output/tagcloud", array(
                'value' => elgg_get_tags($options),
            )),
        'title' => elgg_echo("tagcloud"),
    );
    $options['tag_name'] = 'events';
   // $options['created_time_upper'] = time();
    $listbytabss['body'][] = array(
        'content' => elgg_view("output/tagcloud", array(
                'value' => elgg_get_tags($options),
                'tag_name' => 'events',
            )),
        'title' => elgg_echo("eventcloud"),
    );
    $listbytabss['class'] = "tagcloudtabs";
    $params['content']['side'][] = $listbytabss;

/*    
    $addyourown['body'] = elgg_view("page/components/becomeacritic_2", 
        array("message" => elgg_echo("becomeacritic:why"), 
            "url" => "{$CONFIG->wwwroot}channels/add"
        )
    );                
    $addyourown['class'] = "tk-module";
    $params['content']['side'][] = $addyourown;             
*/
$addyourown['class'] = "tk-module small-padding";
$visitFB = elgg_echo("FB:visitpage");
$visitFBurl = $CONFIG->FBpageURL;
$addyourown['body'] = <<<HTML
    <iframe style="padding:20px; height:100px; width:280px;" src="//www.facebook.com/plugins/like.php?href=https://www.facebook.com/pages/%E1%83%A2%E1%83%94%E1%83%9A%E1%83%94%E1%83%99%E1%83%A0%E1%83%98%E1%83%A2%E1%83%98%E1%83%99%E1%83%90-Telekritikage/454193961267056&show_faces=true&width=280&height=100&header=false&colorscheme=light&locale=ka_GE&send=false" scrolling="no" frameborder="0" allowTransparency="false"></iframe>
<!--    <iframe style="padding:20px; height:100px;" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Ftelekritika.ge&show_faces=false&width=258&height=100&header=false&colorscheme=light&locale=ka_GE&send=false" scrolling="no" frameborder="0" allowTransparency="false"></iframe> -->
<!--    <iframe style="margin-top:-60px; width:310px; height:250px;" src="//www.facebook.com/plugins/activity.php?site=telekritika.ge&border_color=white&width=310&height=250&header=false&colorscheme=light&locale=ka_GE&send=false" scrolling="no" frameborder="0" allowTransparency="false"></iframe>
-->

<style>.visitfb{margin:20px;text-align:center;width:280px;display: inline-block;font-size: 18px;}</style>
<a class="visitfb" href="$visitFBurl">$visitFB</a>

<!--    <iframe class="tk-module" src="http://www.facebook.com/plugins/like.php?  
       site=https://telekritika.ge&width=310&height=300&header=  
       true&colorscheme=light&locale=ka_GE"   
       scrolling="no" frameborder="0" allowTransparency="false">
    </iframe> 
    <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Ftelekritika.ge&amp;locale=ka_GE&amp;send=false&amp;layout=standard&amp;width=258&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=200" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:258px; height:200px;" allowTransparency="true"></iframe>
-->
HTML;
$params['content']['side'][] = $addyourown;
    switch($template){
        case "article":
        
            $articles = elgg_get_entities(array(
                "type" => "object",
                "subtype" => "article",
                //'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'published'),
                'offset' => 1,
                'limit' => 10 )
            );                  
            $output = "<ul class=\"elgg-list\">";
            foreach($articles as $article){
                $date = elgg_view_friendly_time($article->time_created);
                $output .= "<li><a href=\"{$article->getURL()}\">$date - {$article->title}</a></li>";                                
            }
            $output .= "</ul>";        
            $params['content']['side'][0] = array("body" =>
            
                elgg_view_module(
                    "articlearchive",
                    elgg_echo("<span class='elgg-echo-string' data-key='article:archive'>არქივი</span>"),
                    $output
                ),
                "class" => "toppest"
            );
                            
        break;
        case "stories":
        
            $articles = elgg_get_entities_from_metadata(array(
                "type" => "object",
                "subtype" => "commentary",
                'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'dailystory'),
                'offset' => 5,
                'limit' => 10 )
            );                  
            $output = "<ul class=\"elgg-list\">";
            foreach($articles as $article){
                $date = elgg_view_friendly_time($article->time_created);
                $output .= "<li><a href=\"{$article->getURL()}\">$date - {$article->title}</a></li>";                                
            }
            $output .= "</ul>";        
            $params['content']['side'][0] = array("body" =>
            
                elgg_view_module(
                    "storiesarchive",
                    elgg_echo("commentary:dailystories:archive"),
                    $output
                ),
                "class" => "toppest"
            );
                            
        break;
    }
}
      
/**
 * Sets up user-related menu items
 *
 * @return void
 */
function users_pagesetup_mod() {

  /*  if (elgg_get_page_owner_guid()) {
        $params = array(
            'name' => 'friends',
            'text' => elgg_echo('friends'),
            'href' => 'friends/' . elgg_get_page_owner_entity()->username,
            'contexts' => array('friends')
        );
        elgg_register_menu_item('page', $params);

        $params = array(
            'name' => 'friends:of',
            'text' => elgg_echo('friends:of'),
            'href' => 'friendsof/' . elgg_get_page_owner_entity()->username,
            'contexts' => array('friends')
        );
        elgg_register_menu_item('page', $params);
    }
    */
    // topbar
    $user = elgg_get_logged_in_user_entity();
    if ($user) {
/*        elgg_register_menu_item('site', array(
            'name' => 'edit_avatar',
            'href' => "avatar/edit/{$user->username}",
            'text' => elgg_echo('avatar:edit'),
            'contexts' => array('profile_edit'),
        ));
        elgg_register_menu_item('site', array(
            'name' => 'edit_profile',
            'href' => "profile/{$user->username}/edit",
            'text' => elgg_echo('profile:edit'),
            'contexts' => array('profile_edit'),
        ));
*/

        $icon_url = $user->getIconURL('topbar');
        $class = 'elgg-border-plain elgg-transition';
        $title = elgg_echo('profile');
//        elgg_register_menu_item('topbar', array(
        elgg_register_menu_item('site', array(
            'name' => 'profile',
            'href' =>  $user->getURL(),
            'text' => "<img src=\"$icon_url\" alt=\"$user->name\" title=\"$title\" class=\"$class\" />",
            'priority' => 1,
            'link_class' => 'elgg-topbar-avatar',
        ));
    	
        



/*        elgg_register_menu_item('topbar', array(
            'name' => 'friends',
            'href' => "friends/{$user->username}",
            'text' => elgg_view_icon('users'),
            'title' => elgg_echo('friends'),
            'priority' => 300,
        ));
*/

/*        elgg_register_menu_item('topbar', array(
        elgg_register_menu_item('site', array(
            'name' => 'logout',
            'href' => "action/logout",
            'text' => elgg_echo('logout'),
            'is_action' => TRUE,
            'priority' => 1000,
            //'section' => 'alt',
        ));   */

    }

            // add a site navigation item
        $item = new ElggMenuItem('critics', elgg_echo('topcritics'), 'critics');
        elgg_register_menu_item('site', $item);

    
//      Set up the main menu
//      $item = new ElggMenuItem('SMS', elgg_echo('SMS'), 'SMS');
//      elgg_register_menu_item('site', $item);    
    if(elgg_is_admin_logged_in()){
        elgg_register_menu_item('topbar', array(
            'name' => 'articleadd',
            'href' => "article/add",
            'text' => elgg_echo("article:add"),
        ));
        elgg_register_menu_item('topbar', array(
            'name' => 'commentaryall',
            'href' => "channels/all",
            'text' => elgg_echo("commentaries:admin"),
        ));
        elgg_register_menu_item('topbar', array(
            'name' => 'SMSmanager',
            'href' => "SMS",
            'text' => elgg_echo("SMS manager"),
        ));
    }
}
      
                              
?>
