<?php
/**
 * Body of river item
 *
 * @uses $vars['item']        ElggRiverItem
 * @uses $vars['summary']     Alternate summary (the short text summary of action)
 * @uses $vars['message']     Optional message (usually excerpt of text)
 * @uses $vars['attachments'] Optional attachments (displaying icons or other non-text data)
 * @uses $vars['responses']   Alternate respones (comments, replies, etc.)
 */

$item = $vars['item'];
$object = $item->getObjectEntity();
$container = $object->getContainerEntity();
$vars['guid'] = $object->getGUID();

$summary = elgg_extract('summary', $vars, elgg_view('river/elements/summary', array('item' => $vars['item'])));
if ($summary === false) {
	$subject = $item->getSubjectEntity();
	$summary = $subject->name;
}

$message = elgg_extract('message', $vars, false);
if ($message !== false) {
	$message = "<div class=\"elgg-river-message\">$message</div>";
}

$attachments = elgg_extract('attachments', $vars, false);
if ($attachments !== false) {
	$attachments = "<div class=\"elgg-river-attachments clearfix\">$attachments</div>";
}

echo <<<RIVER
<div class="elgg-river-summary">$summary $group_string</div>
$message
$attachments
$responses
RIVER;
