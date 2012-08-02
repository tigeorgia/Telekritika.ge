<?php
/**
 * Gallery view
 *
 * Implemented as an unorder list
 *
 * @uses $vars['items']         Array of ElggEntity or ElggAnnotation objects
 * @uses $vars['offset']        Index of the first list item in complete list
 * @uses $vars['limit']         Number of items per page
 * @uses $vars['count']         Number of items in the complete list
 * @uses $vars['pagination']    Show pagination? (default: true)
 * @uses $vars['position']      Position of the pagination: before, after, or both
 * @uses $vars['full_view']     Show the full view of the items (default: false)
 * @uses $vars['gallery_class'] Additional CSS class for the <ul> element
 * @uses $vars['item_class']    Additional CSS class for the <li> elements
 */

$items = $vars['items'];
if (!is_array($items) && sizeof($items) == 0) {
	return true;
}

elgg_push_context('channelbar');

//$offset = $vars['offset'];
//$limit = $vars['limit'];
//$count = $vars['count'];
//$pagination = elgg_extract('pagination', $vars, true);
//$offset_key = elgg_extract('offset_key', $vars, 'offset');
//$position = elgg_extract('position', $vars, 'after');

$gallery_class = 'elgg-channelbar';
if (isset($vars['gallery_class'])) {
	$gallery_class = "$gallery_class {$vars['gallery_class']}";
}

$item_class = 'elgg-channelbar-item';
if (isset($vars['item_class'])) {
	$item_class = "$item_class {$vars['item_class']}";
}

/*if ($pagination && $count) {
	$nav .= elgg_view('navigation/pagination', array(
		'offset' => $offset,
		'count' => $count,
		'limit' => $limit,
		'offset_key' => $offset_key,
	));

if ($position == 'before' || $position == 'both') {
	echo $nav;
}
}*/

?>
<div id="cv_content_wrapper">
    <ul id="main_channelbar" class="<?php echo $gallery_class; ?>">
	    <?php
        
            $vars['size'] = "medium";
        
		    foreach ($items as $item) {
                $vars['href'] = $vars['main'] ? $item->getURL() : "#";
			    if (elgg_instanceof($item)) {
                    $id = "elgg-{$item->getType()}-{$item->getGUID()}";
			    } else {
				    $id = "item-{$item->getType()}-{$item->id}";
			    }
			    echo "<li id=\"$id\" class=\"$item_class\">";
			    echo elgg_view_list_item($item, $vars);
			    echo "</li>";
		    }
	    ?>
    </ul>
</div>
<?php
elgg_pop_context();
