<?php
/**
 * Article sidebar menu showing revisions
 *
 * @package Article
 */

//If editing a post, show the previous revisions and drafts.
$article = elgg_extract('entity', $vars, FALSE);

if (elgg_instanceof($article, 'object', 'article') && $article->canEdit()) {
	$owner = $article->getOwnerEntity();
	$revisions = array();

	$auto_save_annotations = $article->getAnnotations('article_auto_save', 1);
	if ($auto_save_annotations) {
		$revisions[] = $auto_save_annotations[0];
	}

	// count(FALSE) == 1!  AHHH!!!
	$saved_revisions = $article->getAnnotations('article_revision', 10, 0, 'time_created DESC');
	if ($saved_revisions) {
		$revision_count = count($saved_revisions);
	} else {
		$revision_count = 0;
	}

	$revisions = array_merge($revisions, $saved_revisions);

	if ($revisions) {
		$title = elgg_echo('article:revisions');

		$n = count($revisions);
		$body = '<ul class="article-revisions">';

		$load_base_url = "article/edit/{$article->getGUID()}";

		// show the "published revision"
		if ($article->status == 'published') {
			$load = elgg_view('output/url', array(
				'href' => $load_base_url,
				'text' => elgg_echo('article:status:published')
			));

			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($article->time_created) . "</span>";

			$body .= "<li>$load : $time</li>";
		}

		foreach ($revisions as $revision) {
			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($revision->time_created) . "</span>";

			if ($revision->name == 'article_auto_save') {
				$revision_lang = elgg_echo('article:auto_saved_revision');
			} else {
				$revision_lang = elgg_echo('article:revision') . " $n";
			}
			$load = elgg_view('output/url', array(
				'href' => "$load_base_url/$revision->id",
				'text' => $revision_lang
			));

			$text = "$load: $time";
			$class = 'class="auto-saved"';

			$n--;

			$body .= "<li $class>$text</li>";
		}

		$body .= '</ul>';

		echo elgg_view_module('aside', $title, $body);
	}
}