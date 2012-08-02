<?php
/**
 * Friendly time
 * Translates an epoch time into a human-readable time.
 * 
 * @uses string $vars['time'] Unix-style epoch timestamp
 */

$friendly_time = elgg_get_friendly_time($vars['time']);
$timestamp = htmlspecialchars( elgg_echo('date:month:' . date("m", $vars['time']), array(date("j", $vars['time'])) ) . " " . date("Y", $vars['time']));

echo "<acronym title=\"$timestamp\">$timestamp</acronym>";
