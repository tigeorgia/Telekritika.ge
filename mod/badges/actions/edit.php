<?php

    global $CONFIG;

    admin_gatekeeper();
    action_gatekeeper();

    $guid = (int)get_input('guid');

    $badge = get_entity($guid);

    if (is_array($_FILES['badge'])) {
        $filename    = $_FILES['badge']['name'];
        $mime        = $_FILES['badge']['type'];

        system_message($mime.$filename);
        
        $prefix = 'image/badges/';

        $filestorename = strtolower(time().$filename);

        $badge->setFilename($prefix.$filestorename);
        $badge->setMimeType($mime);
        $badge->originalfilename = $filename;
        system_message($badge->originalfilename);
        $badge->subtype = 'badge';
        $badge->access_id = 2;
        $badge->open("write");
        $badge->write(get_uploaded_file('badge'));
        $badge->close();
    }

    $badge->title = get_input('name');
    $badge->description = get_input('description');
    $badge->save();    

    $badge->badges_name = get_input('name');
    $badge->badges_userpoints = get_input('points');

    if (get_input('url') != '') {
        $url = get_input('url');
        if (preg_match('/^http/i', $url)) {
            $badge->badges_url = $url;
        } else {
            $badge->badges_url = $CONFIG->wwwroot . $url;
        }
    }

    system_message(elgg_echo("badges:saved"));

    forward("mod/badges/admin.php?tab=list");
?>
