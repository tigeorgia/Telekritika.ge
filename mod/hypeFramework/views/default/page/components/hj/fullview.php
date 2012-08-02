<?php

$entity = elgg_extract('entity', $vars);
$content = elgg_extract('content', $vars);
$viewtype = elgg_extract('viewtype', $vars);
$handler = elgg_extract('handler', $vars);
$extras = elgg_extract('extras', $vars);

$params = hj_framework_extract_params_from_entity($entity);

$footer_menu = elgg_view_menu('hjentityfoot', array(
    'entity' => $entity,
    'viewtype' => $viewtype,
    'handler' => $handler,
    'class' => 'elgg-menu-hz hj-menu-hz',
    'sort_by' => 'priority',
    'params' => $params,
    'extras' => $extras,
        ));

$wrapped_content = <<<HTML
    <div class="hj-entity-footer hj-footer-menu">
        $footer_menu
    </div>
    <div id="hj-fullview-$entity->guid" class="hj-fullview" style="display:none">
        <div id="hj-gallery-$entity->guid" class="hj-gallery-view">
            $content
        </div>
    </div>
HTML;

$wrapped_content = elgg_trigger_plugin_hook('extend', 'hj:entity:fullview', array('current' => $wrapped_content), $wrapped_content);
echo $wrapped_content;
