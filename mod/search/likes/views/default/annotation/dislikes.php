<?php
/**
 * Elgg show the users who liked the object
 *
 * @uses $vars['annotation']
 */

if (!isset($vars['annotation'])) {
	return true;
}

$dislike = $vars['annotation'];

$user = $dislike->getOwnerEntity();
if (!$user) {
	return true;
}

$user_icon = elgg_view_entity_icon($user, 'tiny');
$user_link = elgg_view('output/url', array(
	'href' => $user->getURL(),
	'text' => $user->name,
));

$dislikes_string = elgg_echo('dislikes:this');

$friendlytime = elgg_view_friendly_time($dislike->time_created);

/*if ($dislike->canEdit()) {
	$delete_button = elgg_view("output/confirmlink",array(
						'href' => "action/dislikes/delete?annotation_id={$dislike->id}",
						'text' => "<span class=\"elgg-icon elgg-icon-delete right\"></span>",
						'confirm' => elgg_echo('deleteconfirm'),
						'text_encode' => false,
					));
}*/

$body = <<<HTML
<p class="mbn">
	$user_link $dislikes_string
	<span class="elgg-subtext">
		$friendlytime
	</span>
</p>
HTML;

echo elgg_view_image_block($user_icon, $body);
