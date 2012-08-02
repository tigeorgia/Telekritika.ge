<?php
/**
 * List comments with optional add form
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['show_add_form'] Display add form or not
 * @uses $vars['id']            Optional id for the div
 * @uses $vars['class']         Optional additional class for the div
 */

$vars['class'] = "admin_comments";
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
	'annotation_name' => 'admin_comment',
    'limit' => 25,
    'offset' => (int) max(get_input('annoff', 0), 0),
);

$vars = array_merge($options, $vars);
$html = "";
$admin_comments = elgg_get_annotations($options);


foreach($admin_comments as $val){
    $commenter = get_user($val->owner_guid);
    $html .= $commenter->name . " - " . $val->value . "<br />";
}
/*
if($show_add_form !== false && !$html){
//    echo "<div $id class=\"$class\" $extra>";
//    echo '</div>';
}elseif ( $html ) {
    echo "<div $id class=\"$class\">";
	//echo $vars['paginate'] ? '' : '<h3>'. elgg_echo($options['rating_style'][0]) . ' ' . elgg_echo($options['annotation_name']) . '</h3>';
    echo $html;
    echo '</div>';
}
*/

if ($show_add_form !== false && elgg_is_logged_in()) {
    $form_vars = array('name' => 'elgg_add_comment');
    $html .= elgg_view_form('comments/add', $form_vars, $vars);
}

if($admin_comments > 0){
    if($admin_comments[count($admin_comments)-1]->owner_guid != elgg_get_logged_in_user_guid()){
        $html = "<div class=\"admin_comments_holder outstanding\">" . $html . "</div>";                                
    }else{
        $html = "<div class=\"admin_comments_holder\">" . $html . "</div>";                    
    }
}else{
    $html = "<div class=\"admin_comments_holder\">" . js_show_hide_next(elgg_echo("Comment?"), 1) . "</div>";
    $html = "<div class=\"admin_comments_holder\" style=\"display: none;\">" . $html . "</div>";            
}

echo $html;
