<?php
/**
 * Commentary sidebar menu showing revisions
 *
 * @package Commentary
 */

//If editing a post, show the previous revisions and drafts.
$commentary = elgg_extract('entity', $vars, FALSE);

if (elgg_instanceof($commentary, 'object', 'commentary') && $commentary->canEdit()) {
	$owner = $commentary->getOwnerEntity();
	$revisions = array();

	$auto_save_annotations = $commentary->getAnnotations('commentary_auto_save', 1);
	if ($auto_save_annotations) {
		$revisions[] = $auto_save_annotations[0];
	}

	// count(FALSE) == 1!  AHHH!!!
	$saved_revisions = $commentary->getAnnotations('commentary_revision', 10, 0, 'time_created DESC');
	if ($saved_revisions) {
		$revision_count = count($saved_revisions);
	} else {
		$revision_count = 0;
	}

	$revisions = array_merge($revisions, $saved_revisions);

	if ($revisions) {
		$title = elgg_echo('commentary:revisions');

		$n = count($revisions);
		$body = '<ul class="commentary-revisions">';

		$load_base_url = "commentary/edit/{$commentary->getGUID()}";

		// show the "published revision"
		if ($commentary->status == 'published') {
			$load = elgg_view('output/url', array(
				'href' => $load_base_url,
				'text' => elgg_echo('commentary:status:published')
			));

			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($commentary->time_created) . "</span>";

			$body .= "<li>$load : $time</li>";
		}

		foreach ($revisions as $revision) {
			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($revision->time_created) . "</span>";

			if ($revision->name == 'commentary_auto_save') {
				$revision_lang = elgg_echo('commentary:auto_saved_revision');
			} else {
				$revision_lang = elgg_echo('commentary:revision') . " $n";
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