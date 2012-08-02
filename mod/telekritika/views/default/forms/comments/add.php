<?php
/**
 * Elgg comments add form
 *
 * @package Elgg
 *
 * @uses ElggEntity $vars['entity'] The entity to comment on
 * @uses bool       $vars['inline'] Show a single line version of the form?
 */


if (isset($vars['entity']) && elgg_is_logged_in()) {
	
	$inline = elgg_extract('inline', $vars, false);
	
	if ($inline) {
		echo elgg_view('input/text', array('name' => $vars['admin_comment'] ? 'admin_comment' : 'generic_comment'));
		echo elgg_view('input/submit', array('value' => elgg_echo('comment')));
	} else {

/*        $pub = $vars['entity'] instanceOf ElggSegment ? 
                    prep_pipe_string(array("cv.addcomment.{$vars['entity']->guid}", "{$vars['entity']->getType()}.postcomment.{$vars['entity']->guid}")),
                    prep_pipe_string(array("cv.addcomment.{$vars['entity']->guid}", "{$vars['entity']->getType()}.postcomment.{$vars['entity']->guid}")),
*/
        $pub = prep_pipe_string("{$vars['entity']->getSubType()}.postcomment.{$vars['entity']->guid}");

		echo elgg_view('input/submit', 
        array(
                'value' => elgg_echo("generic_comments:post"),
                'data-pub' => $pub,
                'placeholder' => elgg_echo("generic_comments:add")
            )            
        );

        echo elgg_view('input/longtextnomce', array('name' => $vars['admin_comment'] ? 'admin_comment' : 'generic_comment'));
 
	}
	
	echo elgg_view('input/hidden', array(
		'name' => 'entity_guid',
		'value' => $vars['entity']->getGUID()
	));
}
