<?php
/**
 * Blog sidebar menu showing revisions
 *
 * @package Blog
 */

//If editing a post, show the previous revisions and drafts.
$editorial = elgg_extract('entity', $vars, FALSE);

if (elgg_instanceof($editorial, 'object', 'editorial') && $editorial->canEdit()) {
	$owner = $editorial->getOwnerEntity();
	$revisions = array();

	$auto_save_annotations = $editorial->getAnnotations('editorial_auto_save', 1);
	if ($auto_save_annotations) {
		$revisions[] = $auto_save_annotations[0];
	}

	// count(FALSE) == 1!  AHHH!!!
	$saved_revisions = $editorial->getAnnotations('editorial_revision', 10, 0, 'time_created DESC');
	if ($saved_revisions) {
		$revision_count = count($saved_revisions);
	} else {
		$revision_count = 0;
	}

	$revisions = array_merge($revisions, $saved_revisions);

	if ($revisions) {
		$title = elgg_echo('editorial:revisions');

		$n = count($revisions);
		$body = '<ul class="editorial-revisions">';

		$load_base_url = "editorial/edit/{$editorial->getGUID()}";

		// show the "published revision"
		if ($editorial->status == 'published') {
			$load = elgg_view('output/url', array(
				'href' => $load_base_url,
				'text' => elgg_echo('editorial:status:published')
			));

			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($editorial->time_created) . "</span>";

			$body .= "<li>$load : $time</li>";
		}

		foreach ($revisions as $revision) {
			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($revision->time_created) . "</span>";

			if ($revision->name == 'editorial_auto_save') {
				$revision_lang = elgg_echo('editorial:auto_saved_revision');
			} else {
				$revision_lang = elgg_echo('editorial:revision') . " $n";
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