<?php
/**
 * Count of who has disliked something
 *
 *  @uses $vars['entity']
 */


$list = '';
$num_of_dislikes = count($vars['comment_info']['dislikes']);
$guid = $vars['theguid'];

if ($num_of_dislikes) {
	// display the number of dislikes
	if ($num_of_dislikes == 1) {
		$dislikes_string = elgg_echo('dislikes:userdislikedthis', array($num_of_dislikes));
	} else {
		$dislikes_string = elgg_echo('dislikes:usersdislikedthis', array($num_of_dislikes));
	}
echo $dislikes_string;
//	$params = array(
//		'text' => $dislikes_string,
//		'title' => elgg_echo('dislikes:see'),
//		'rel' => 'popup',
//		'href' => "#dislikes-$guid"
//	);
//	$list = elgg_view('output/url', $params);
//	$list .= "<div class='elgg-module elgg-module-popup elgg-dislikes-list hidden clearfix' id='dislikes-$guid'>";
//	$list .= elgg_list_annotations_for_comment(array('guid' => $guid, 'annotation_name' => 'dislikes_for_comment', 'limit' => 99));
//	$list .= "</div>";
//	echo $list;
}
