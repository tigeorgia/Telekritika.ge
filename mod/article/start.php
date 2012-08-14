<?php
/**
 * Articles
 *
 * @package Article
 *
 * @todo
 * - Either drop support for "publish date" or duplicate more entity getter
 * functions to work with a non-standard time_created.
 * - Pingbacks
 * - Notifications
 * - River entry for posts saved as drafts and later published
 */

elgg_register_event_handler('init', 'system', 'article_init');

/**
 * Init article plugin.
 */
function article_init() {

	elgg_register_library('elgg:article', elgg_get_plugins_path() . 'article/lib/article.php');

	// add a site navigation item
	elgg_register_menu_item('site', array(
            'name' => 'article',
            'href' => 'article/all',
            'text' => elgg_echo('article:articles'),
            'priority' => 2,
            'link_class' => 'article-articles-menu',
        ));

	elgg_register_event_handler('upgrade', 'upgrade', 'article_run_upgrades');

	// add to the main css
	elgg_extend_view('css/elgg', 'article/css');

	// register the article's JavaScript
	$article_js = elgg_get_simplecache_url('js', 'article/save_draft');
	elgg_register_js('elgg.article', $article_js);

	// routing of urls
	elgg_register_page_handler('article', 'article_page_handler');

	// override the default url to view a article object
	elgg_register_entity_url_handler('object', 'article', 'article_url_handler');
//    elgg_register_entity_url_handler('group', 'channel', 'channels_url');

	// notifications
	//register_notification_object('object', 'article', elgg_echo('article:newpost'));
	//elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'article_notify_message');

	// add article link to
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'article_owner_block_menu');

	// pingbacks
	//elgg_register_event_handler('create', 'object', 'article_incoming_ping');
	//elgg_register_plugin_hook_handler('pingback:object:subtypes', 'object', 'article_pingback_subtypes');

	// Register for search.
	elgg_register_entity_type('object', 'article');
    add_subtype('object', 'article', 'ElggArticle');

	// Add group option
//    add_group_tool_option('article', elgg_echo('article:enablearticle'), true);
//    add_channel_tool_option('article', elgg_echo('article:enablearticle'), false);
//	elgg_extend_view('groups/tool_latest', 'article/group_module');

	// add a article widget
	elgg_register_widget_type('article', elgg_echo('article'), elgg_echo('article:widget:description'), 'profile');

	// register actions
	$action_path = elgg_get_plugins_path() . 'article/actions/article';
	elgg_register_action('article/save', "$action_path/save.php");
	elgg_register_action('article/auto_save_revision', "$action_path/auto_save_revision.php");
	elgg_register_action('article/delete', "$action_path/delete.php");

	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'article_entity_menu_setup');

	// ecml
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'article_ecml_views_hook');
}

/**
 * Dispatches article pages.
 * URLs take the form of
 *  All articles:       article/all
 *  User's articles:    article/owner/<username>
 *  Friends' article:   article/friends/<username>
 *  User's archives: article/archives/<username>/<time_start>/<time_stop>
 *  Article post:       article/view/<guid>/<title>
 *  New post:        article/add/<guid>
 *  Edit post:       article/edit/<guid>/<revision>
 *  Preview post:    article/preview/<guid>
 *  Group article:      article/group/<guid>/all
 *
 * Title is ignored
 *
 * @todo no archives for all articles or friends
 *
 * @param array $page
 * @return NULL
 */
function article_page_handler($page) {
    elgg_load_library('elgg:article');

	// @todo remove the forwarder in 1.9
	// forward to correct URL for bookmarks pre-1.7.5
//	article_url_forwarder($page);

	// push all articles breadcrumb
//	elgg_push_breadcrumb(elgg_echo('article:articles'), "article/all");

	$page_type = $page[0];
    if(!$page_type){
        $page_type = "all";
    }
    if($page_type == "all" && elgg_is_admin_logged_in()){
        $page_type = "list";
    }
    $layout = "content";
	switch ($page_type) {
        case 'all':
            $params = article_get_page_content_all();
//            $params['title'] = elgg_echo('article:title:all_articles');
            add_template_modules($params, "article");
            $layout = "custom_index";
            break;
		case 'add':
			admin_gatekeeper();
			$params = article_get_page_content_edit($page_type, $page[1]);
            $params['sidebar'] .= elgg_view('article/sidebar', array('page' => $page_type));
			break;
		case 'edit':
            admin_gatekeeper();
			$params = article_get_page_content_edit($page_type, $page[1], $page[2]);
            $params['sidebar'] .= elgg_view('article/sidebar', array('page' => $page_type));
			break;
		case 'list':
            admin_gatekeeper();
			$params = article_get_page_content_list();
            $params['sidebar'] .= elgg_view('article/sidebar', array('page' => $page_type));
//            $params['title'] = elgg_echo('article:title:all_articles');
            break;
        default:
            $params = article_get_page_content_read($page[0]);
            add_template_modules($params, "article");
            $layout = "custom_index";
        break;
    }

    $body = elgg_view_layout($layout, $params);
	echo elgg_view_page($params['title'], $body, "default", $params);
}

/**
 * Format and return the URL for articles.
 *
 * @param ElggObject $entity Article object
 * @return string URL of article.
 */
function article_url_handler($entity) {
	if (!$entity->getOwnerEntity()) {
		// default to a standard view if no owner.
		return FALSE;
	}

	$friendly_title = elgg_get_friendly_title($entity->title);

	return "article/{$entity->guid}/$friendly_title";
}

/**
 * Add a menu item to an ownerblock
 */
function article_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "article/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('article', elgg_echo('article'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->article_enable != "no") {
			$url = "article/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('article', elgg_echo('article:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add particular article links/info to entity menu
 */
function article_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'article') {
		return $return;
	}

/*	if ($entity->canEdit() && $entity->status != 'published') {
		$status_text = elgg_echo("article:status:{$entity->status}");
		$options = array(
			'name' => 'published_status',
			'text' => "<span>$status_text</span>",
			'href' => false,
			'priority' => 150,
		);
		$return[] = ElggMenuItem::factory($options);
	}
*/
	return $return;
}

/**
 * Register articles with ECML.
 */
function article_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['object/article'] = elgg_echo('article:articles');

	return $return_value;
}

/**
 * Upgrade from 1.7 to 1.8.
 */
function article_run_upgrades($event, $type, $details) {
	$article_upgrade_version = get_plugin_setting('upgrade_version', 'articles');

	if (!$article_upgrade_version) {
		 // When upgrading, check if the ElggArticle class has been registered as this
		 // was added in Elgg 1.8
		if (!update_subtype('object', 'article', 'ElggArticle')) {
			add_subtype('object', 'article', 'ElggArticle');
		}

		// only run this on the first migration to 1.8
		// add excerpt to all articles that don't have it.
		$ia = elgg_set_ignore_access(true);
		$options = array(
			'type' => 'object',
			'subtype' => 'article'
		);

		$articles = new ElggBatch('elgg_get_entities', $options);
		foreach ($articles as $article) {
			if (!$article->excerpt) {
				$article->excerpt = str_replace("http:", "https:", elgg_get_excerpt($article->description));
			}
		}

		elgg_set_ignore_access($ia);

		elgg_set_plugin_setting('upgrade_version', 1, 'articles');
	}
}
