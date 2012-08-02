<?php
/**
 * Wrap a content section with a unique id for ajax actions
 */

$body = elgg_extract('body', $vars, '');
$section = elgg_extract('subtype', $vars, 'main');

$html = <<<HTML
    <div id="hj-section">
        <div id="hj-section-{$section}">
                $body
        </div>
        <div id="hj-section-{$section}-temp"><span class="hj-append-after"></span></div>
        <div id="hj-section-{$section}-add"></div>
    </div>
HTML;

echo $html;