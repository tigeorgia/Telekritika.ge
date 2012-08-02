<?php

function hj_framework_entity_url_forwarder($entity) {
    return 'hj/';
}

function hj_framework_segment_url_forwarder($entity) {
    if (elgg_instanceof($entity, 'object', 'hjsegment')) {
        $container = $entity->getContainerEntity();
        return $container->getURL();
    }
    return 'hj/';
}

function hj_framework_page_handlers($page) {
    $plugin = 'hypeFramework';
    $shortcuts = hj_framework_path_shortcuts($plugin);
    $pages = dirname(dirname(dirname(__FILE__))) . '/pages/';

    switch ($page[0]) {
        case 'file' :
            if (!isset($page[1]))
                forward();


            switch ($page[1]) {
                case 'download':
                    set_input('e', $page[2]);
                    include $pages . 'file/download.php';
                    break;

                default :
                    forward();
                    break;
            }

        case 'print' :
            include $pages . 'print/print.php';
            break;

        case 'pdf' :
            include $pages . 'print/pdf.php';
            break;

        default :
            forward();
            break;
    }
}
