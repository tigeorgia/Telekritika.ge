<?php
/**
 * List comments with optional add form
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['show_add_form'] Display add form or not
 * @uses $vars['id']            Optional id for the div
 * @uses $vars['class']         Optional additional class for the div
 */

$show_add_form = elgg_extract('show_add_form', $vars, false);

$id = '';
if (isset($vars['id'])) {
	$id = "id =\"{$vars['id']}\"";
}

$class = 'elgg-comments';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// work around for deprecation code in elgg_view()
unset($vars['internalid']);

//$vars['data-pub'] = $vars['entity']->getType().".postcomment";
$extra = prep_pubsub_string($vars);

$options = array(
	'guid' => $vars['entity']->getGUID(),
	'annotation_name' => 'generic_comment',
//    'show_add_form' => false,

);

$vars = array_merge($options, $vars);
$html = elgg_list_annotations_mod($vars);

if($show_add_form !== false && !$html){
    echo "<div $id class=\"$class\" $extra>";
    echo elgg_echo("comments:bethefirst");    
    echo '</div>';
}elseif ( $html ) {
    //echo "<div $id class=\"$class\" $extra>";
	echo $vars['paginate'] || $vars['entity'] instanceOf ElggSegment ? '' : '<h3>'. elgg_echo($options['rating_style'][0]) . ' ' . elgg_echo($options['annotation_name']) . '</h3>';
    echo $html;
    //echo '</div>';
}

if ($show_add_form !== false && elgg_is_logged_in()) {
    $form_vars = array('name' => 'elgg_add_comment');
    echo elgg_view_form('comments/add', $form_vars, $vars);
}
