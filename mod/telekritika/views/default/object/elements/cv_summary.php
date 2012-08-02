<?php
/**
 * Object summary
 *
 * Sample output
 * <ul class="elgg-menu elgg-menu-entity"><li>Public</li><li>Like this</li></ul>
 * <h3><a href="">Title</a></h3>
 * <p class="elgg-subtext">Posted 3 hours ago by George</p>
 * <p class="elgg-tags"><a href="">one</a>, <a href="">two</a></p>
 * <div class="elgg-content">Excerpt text</div>
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity menu and metadata (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (optional)
 * @uses $vars['content']   HTML for the entity content (optional)
 */

$entity = $vars['entity'];

$metadata = elgg_extract('metadata', $vars, '');
$subtitle = elgg_extract('subtitle', $vars, '');
$content = elgg_extract('content', $vars, '');

$tags = elgg_extract('tags', $vars, '');
if ($tags !== false && is_array($tags)) {
    $tags = elgg_view('output/tags', array('tags' => $entity->tags));
}

$events = elgg_extract('events', $vars, '');
if ($events !== false && is_array($events)) {
    $events = elgg_view('output/events', array('events' => $entity->events));
}

if ($metadata) {
	echo $metadata;
}
//$html .= "<h3>$title_link</h3>";
//$html .= "<div class=\"elgg-subtext\">$subtitle</div>";
//echo $tags;
//echo $events;
if ($content) {
//	$html .= "<div class=\"elgg-content\">$content</div>";
}




//$menu = elgg_view('navigation/menu/metadata', $segment);
$html.= "<a class=\"segment segment_broadcast\" href=\"#\"><input type=\"radio\" />" . $segment->title . "<span class=\"segment_menu\">$menu</span></a>";

echo $html;