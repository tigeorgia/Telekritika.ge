<?php
/**
 * segment sidebar menu showing revisions
 *
 * @package Segment
 */

//If editing a post, show the previous revisions and drafts.
$segment = elgg_extract('entity', $vars, FALSE);

if (elgg_instanceof($segment, 'object', 'segment') && $segment->canEdit()) {
	$owner = $segment->getOwnerEntity();
	$revisions = array();

	$auto_save_annotations = $segment->getAnnotations('segment_auto_save', 1);
	if ($auto_save_annotations) {
		$revisions[] = $auto_save_annotations[0];
	}

	// count(FALSE) == 1!  AHHH!!!
	$saved_revisions = $segment->getAnnotations('segment_revision', 10, 0, 'time_created DESC');
	if ($saved_revisions) {
		$revision_count = count($saved_revisions);
	} else {
		$revision_count = 0;
	}

	$revisions = array_merge($revisions, $saved_revisions);

	if ($revisions) {
		$title = elgg_echo('segment:revisions');

		$n = count($revisions);
		$body = '<ul class="segment-revisions">';

		$load_base_url = "segment/edit/{$segment->getGUID()}";

		// show the "published revision"
		if ($segment->status == 'published') {
			$load = elgg_view('output/url', array(
				'href' => $load_base_url,
				'text' => elgg_echo('segment:status:published')
			));

			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($segment->time_created) . "</span>";

			$body .= "<li>$load : $time</li>";
		}
        
        $x=0;
		foreach ($revisions as $revision) {
            if($x<$CONFIG->displayRevisions){
			    $time = "<span class='elgg-subtext'>"
				    . elgg_view_friendly_time($revision->time_created) . "</span>";

			    if ($revision->name == 'segment_auto_save') {
				    $revision_lang = elgg_echo('segment:auto_saved_revision');
			    } else {
				    $revision_lang = elgg_echo('segment:revision') . " $n";
			    }
			    $load = elgg_view('output/url', array(
				    'href' => "$load_base_url/$revision->id",
				    'text' => $revision_lang
			    ));

			    $text = "$load: $time";
			    $class = 'class="auto-saved"';

			    $n--;
                $x++;
                
			    $body .= "<li $class>$text</li>";
            }else{
                break;
            }
		}

		$body .= '</ul>';

		echo elgg_view_module('aside', $title, $body);
	}
}