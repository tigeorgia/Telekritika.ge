<?php
/**
 * Count of who has liked something
 *
 *  @uses $vars['entity']
 */


$list = '';
$num_of_likes = count($vars['comment_info']['likes']);
$guid = $vars['theguid'];

if ($num_of_likes) {
	// display the number of likes
	if ($num_of_likes == 1) {
		$likes_string = elgg_echo('likes:userlikedthis', array($num_of_likes));
	} else {
		$likes_string = elgg_echo('likes:userslikedthis', array($num_of_likes));
	}
    echo $likes_string;
//	$params = array(
//		'text' => $likes_string,
//		'title' => elgg_echo('likes:see'),
//		'rel' => 'popup',
//		'href' => "#likes-$guid"
//	);
//	$list = elgg_view('output/url', $params);
//	$list .= "<div class='elgg-module elgg-module-popup elgg-likes-list hidden clearfix' id='likes-$guid'>";
 //   $list .= elgg_list_annotations_for_comment(array('guid' => $guid, 'annotation_name' => 'likes_for_comment', 'limit' => 99));
//	$list .= "</div>";
//	echo $list;
}
