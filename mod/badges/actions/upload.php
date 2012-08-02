<?php

    global $CONFIG;

    admin_gatekeeper();
    action_gatekeeper();


    $filename    = $_FILES['badge']['name'];
    $mime        = $_FILES['badge']['type'];

    if (!is_array($_FILES['badge'])) {
        register_error(elgg_echo('badges:noimage'));
        forward($_SERVER['HTTP_REFERER']);
    }

    $prefix = 'image/badges/';

    $filestorename = strtolower(time().$filename);

    $file = new BadgesBadge();
    $file->setFilename($prefix.$filestorename);
    $file->setMimeType($mime);
    $file->originalfilename = $filename;
    $file->subtype = 'badge';
    $file->access_id = 2;
    $file->open("write");
    $file->write(get_uploaded_file('badge'));
    $file->close();

    $file->title = get_input('name');
    $file->description = get_input('description');
    $file->save();

    /* Add the name as metadata. This is a hack to 
     * allow sorting the admin list view by name 
     * using a custom get_entities_by_metadata method.
     */
    $file->badges_name = get_input('name');

    // Add the userpoints at which this badge will be awarded
    $file->badges_userpoints = get_input('points');

    if (get_input('url') != '') {
        $url = get_input('url');
        if (preg_match('/^http/i', $url)) {
            $file->badges_url = $url;
        } else {
            $file->badges_url = $CONFIG->wwwroot . $url;
        }
    }

    system_message(elgg_echo("badges:uploaded"));

    forward("mod/badges/admin.php?tab=list");
?>
