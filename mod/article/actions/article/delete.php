<?php
/**
 * Delete article entity
 *
 * @package Article
 */

$article_guid = get_input('guid');
$article = get_entity($article_guid);

if (elgg_instanceof($article, 'object', 'article') && $article->canEdit()) {
	$container = get_entity($article->container_guid);
	if ($article->delete()) {
		system_message(elgg_echo('article:message:deleted_post'));
		if (elgg_instanceof($container, 'group')) {
			forward("article/group/$container->guid/all");
		} else {
			forward("article/owner/$container->username");
		}
	} else {
		register_error(elgg_echo('article:error:cannot_delete_post'));
	}
} else {
	register_error(elgg_echo('article:error:post_not_found'));
}

forward(REFERER);