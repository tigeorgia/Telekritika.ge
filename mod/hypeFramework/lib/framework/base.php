<?php
/**
 * hypeFramework helper functions
 */

/**
 * Register hypeJunction Framework Libraries
 * 
 * @return void
 */
function hj_framework_register_libraries() {
    $shortcuts = hj_framework_path_shortcuts('hypeFramework');

    /**
     * Core Libraries
     */
    // Setup functions
    elgg_register_library('hj:framework:setup', $shortcuts['lib'] . 'framework/setup.php');
    // A pool of useful recyclable information (dropdowns, arrays etc)
    elgg_register_library('hj:framework:knowledge', $shortcuts['lib'] . 'framework/knowledge.php');
    // Menu Builder
    elgg_register_library('hj:framework:menu', $shortcuts['lib'] . 'framework/menu.php');
    // URL and Page Handler Functions
    elgg_register_library('hj:framework:pagehandler', $shortcuts['lib'] . 'framework/pagehandler.php');
    // Plugin and event hooks Functions
    elgg_register_library('hj:framework:hooks', $shortcuts['lib'] . 'framework/hooks.php');
    // Entity related helpers
    elgg_register_library('hj:framework:entities', $shortcuts['lib'] . 'framework/entities.php');
    // File Management
    elgg_register_library('hj:framework:files', $shortcuts['lib'] . 'framework/files.php');
    // Form Management
    elgg_register_library('hj:framework:forms', $shortcuts['lib'] . 'framework/forms.php');

    //FirePHP
    //elgg_register_library('hj:framework:firephp', $shortcuts['lib'] . 'firephp/fb.php');
    //elgg_load_library('hj:framework:firephp');
    
    // DomPDF
    elgg_register_library('hj:framework:dompdf', $shortcuts['lib'] . 'dompdf/dompdf_config.inc.php');
    
    //
    /**
     * Load Libraries
     */
    elgg_load_library('hj:framework:knowledge');
    elgg_load_library('hj:framework:menu');
    elgg_load_library('hj:framework:pagehandler');
    elgg_load_library('hj:framework:hooks');
    elgg_load_library('hj:framework:entities');
    elgg_load_library('hj:framework:files');

    return true;
}

/**
 * Register hypeJunction Javascript Libraries
 * 
 * @return void
 */
function hj_framework_register_js() {
    $hj_js_ajax = elgg_get_simplecache_url('js', 'hj/framework/ajax');
    elgg_register_js('hj.framework.ajax', $hj_js_ajax);
    //elgg_load_js('hj.framework.ajax');
    
    $hj_js_tabs = elgg_get_simplecache_url('js', 'hj/framework/tabs');
    elgg_register_js('hj.framework.tabs', $hj_js_tabs);

    $hj_js_sortable_tabs = elgg_get_simplecache_url('js', 'hj/framework/tabs.sortable');
    elgg_register_js('hj.framework.tabs.sortable', $hj_js_sortable_tabs);

    $hj_js_sortable_list = elgg_get_simplecache_url('js', 'hj/framework/list.sortable');
    elgg_register_js('hj.framework.list.sortable', $hj_js_sortable_list);

    // JS to check mandatory fields
    $hj_js_fieldcheck = elgg_get_simplecache_url('js', 'hj/framework/fieldcheck');
    elgg_register_js('hj.framework.fieldcheck', $hj_js_fieldcheck);
    
    return true;
}

/**
 * Register hypeJunction CSS Libraries
 * 
 * @return void
 */
function hj_framework_register_css() {
    // Load the CSS Framework
    elgg_extend_view('css/elgg', 'css/hj/framework/base');
    elgg_extend_view('css/admin', 'css/hj/framework/base');

    // Load the 960 Grid
    elgg_extend_view('css/elgg', 'css/hj/framework/grid');
    elgg_extend_view('css/admin', 'css/hj/framework/grid');

    return true;
}

/**
 * Register entity URL and page_handlers
 * @return void
 */
function hj_framework_register_page_handlers() {
    /**
     * URL handlers
     */
    // we need to protect certain entities from being viewed, as they do not have page handlers yet
    // these will be overriden within individual plugins
    elgg_register_entity_url_handler('object', 'hjform', 'hj_framework_entity_url_forwarder');
    elgg_register_entity_url_handler('object', 'hjfield', 'hj_framework_entity_url_forwarder');
    elgg_register_entity_url_handler('object', 'hjfile', 'hj_framework_entity_url_forwarder');
    elgg_register_entity_url_handler('object', 'hjfilefolder', 'hj_framework_entity_url_forwarder');
    
    elgg_register_entity_url_handler('object', 'hjsegment', 'hj_framework_segment_url_forwarder');
    
    elgg_register_page_handler('hj', 'hj_framework_page_handlers');
}

/**
 *  Register plugin and even hooks
 * 
 * @return void
 */
function hj_framework_register_hooks() {
    // Create new AJAXed menus
    elgg_register_plugin_hook_handler('register', 'menu:hjentityhead', 'hj_framework_entity_head_menu');
    elgg_register_plugin_hook_handler('register', 'menu:hjentityfoot', 'hj_framework_entity_foot_menu');
    elgg_register_plugin_hook_handler('register', 'menu:hjsegmenthead', 'hj_framework_segment_head_menu');
    elgg_register_plugin_hook_handler('register', 'menu:hjsectionfoot', 'hj_framework_section_foot_menu');

    // hjFile Icons
    elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'hj_framework_object_icons');
    
    // Add Widgets
    elgg_register_plugin_hook_handler('hj:framework:form:process', 'all', 'hj_framework_setup_segment_widgets');

}

/**
 * Register necessary actions
 * 
 * @return void
 */
function hj_framework_register_actions() {
    $shortcuts = hj_framework_path_shortcuts('hypeFramework');
    
    // View an object or a list of objects via AJAX
    elgg_register_action('framework/entities/view', $shortcuts['actions'] . 'hj/framework/view.php', 'public');
    // Get an hjForm of an object
    elgg_register_action('framework/entities/edit', $shortcuts['actions'] . 'hj/framework/edit.php', 'public');
    // Process an hjForm on submit
    elgg_register_action('framework/entities/save', $shortcuts['actions'] . 'hj/framework/submit.php', 'public');
    // Delete an entity by guid
    elgg_register_action('framework/entities/delete', $shortcuts['actions'] . 'hj/framework/delete.php', 'public');
    // Reset priority attribute of an object
    elgg_register_action('framework/entities/move', $shortcuts['actions'] . 'hj/framework/move.php');
    // E-mail form details
    elgg_register_action('framework/form/email', $shortcuts['actions'] . 'hj/framework/email.php');
    // Add widget
    elgg_register_action('framework/widget/add', $shortcuts['actions'] . 'hj/framework/addwidget.php');
    // Add widget
    elgg_register_action('framework/widget/load', $shortcuts['actions'] . 'hj/framework/loadwidget.php');
    // Download file
    elgg_register_action('framework/file/download', $shortcuts['actions'] . 'hj/framework/download.php', 'public');
}

/**
 * Get plugin tree shortcut urls
 *
 * @param string  $plugin     Plugin name string
 * @return array
 */
function hj_framework_path_shortcuts($plugin) {
    $path = elgg_get_plugins_path();
    $plugin_path = $path . $plugin . '/';

    return $structure = array(
        "actions" => "{$plugin_path}actions/",
        "classes" => "{$plugin_path}classes/",
        "graphics" => "{$plugin_path}graphics/",
        "languages" => "{$plugin_path}languages/",
        "lib" => "{$plugin_path}lib/",
        "pages" => "{$plugin_path}pages/",
        "vendors" => "{$plugin_path}vendors/"
    );
}

/**
 * Register subtypes with stdClasses
 */
run_function_once('hj_framework_add_subtypes');

function hj_framework_add_subtypes() {
    add_subtype('object', 'hjform', 'hjForm');
    add_subtype('object', 'hjfield', 'hjField');
    add_subtype('object', 'hjfile', 'hjFile');
    add_subtype('object', 'hjfilefolder', 'hjFileFolder');
    add_subtype('object', 'hjsegment', 'hjSegment');
    
}