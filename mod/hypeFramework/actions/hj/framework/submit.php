<?php

/**
 * Action to perform on hjForm submit
 * Saves an entity of a given type and subtype (@see hjForm::$subject_entity_type, hjForm::$subject_entity_subtype)
 * 
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category AJAX
 * @category User Interface
 * @category Forms
 * 
 * @uses int hjForm::$guid NULL|INT GUID of an hjForm containing hjField
 * @params int $subject_entity_guid
 * @params int $subject_container_guid
 * @params int $owner_entity_guid
 * @params string $context
 * 
 * @return json
 */
?><?php

// In case we want to prevent from saving the new entity
if (!elgg_trigger_event('beforeSubmit', 'object')) {
    return true;
}

// Hack to allow non-logged in users to submit their forms
$access = elgg_get_ignore_access();
if (!elgg_is_logged_in()) {
    elgg_set_ignore_access(true);
}

$extract = hj_framework_extract_params_from_url();
$params = elgg_extract('params', $extract, array());
$subject = $params['subject'];
$container = $params['container'];
$owner = $params['owner'];
$form = $params['form'];
$fields = $params['fields'];
$widget = $params['widget'];
$context = $params['context'];
$viewtype = $params['viewtype'];

if ($subject->guid) {
    $event = 'update';
} else {
    $event = 'create';
}

if (is_array($fields)) {
    switch ($form->subject_entity_type) {
        case 'object' :
        default :
            $formSubmission = new ElggObject($subject->guid);
            break;
        case 'user' :
            $formSubmission = new ElggUser($subject->guid);
            break;
        case 'group' :
            $formSubmission = new ElggGroup($subject->guid);
            break;
    }

    $formSubmission->subtype = $form->subject_entity_subtype;
    $formSubmission->title = get_input('title');
    $formSubmission->description = get_input('description');
    $formSubmission->owner_guid = $owner->guid;
    $formSubmission->container_guid = $container->guid;
    $formSubmission->access_id = get_input('access_id');
    $formSubmission->data_pattern = $form->guid;
    $formSubmission->widget = $widget->guid;
    $formSubmission->handler = $form->handler;
    $formSubmission->notify_admins = $form->notify_admins;
    $formSubmission->add_to_river = $form->add_to_river;
    $formSubmission->comments_on = $form->comments_on;
    $saved = $formSubmission->save();
}

if ($saved && is_array($fields)) {
    hj_framework_set_entity_priority($formSubmission);
    foreach ($fields as $field) {
        if ((!elgg_is_logged_in() && $field->access_id == ACCESS_PUBLIC) || (elgg_is_logged_in())) {
            $field_name = $field->name;
            $field_value = get_input($field_name);

            switch ($field->input_type) {
                default :
                    $formSubmission->$field_name = $field_value;
                    // Do we need to treat the field in a special way?
                    elgg_trigger_plugin_hook('hj:framework:field:process', 'all', array('entity' => $field), true);
                    break;

                case 'tags' :
                    $tags = explode(",", $field_value);
                    $formSubmission->$field_name = $tags;

                case 'file' :
                    if (elgg_is_logged_in()) {
                        global $_FILES;
                        $file = $_FILES[$field_name];

                        // Maybe someone doesn't want us to save the file in this particular way
                        if (isset($file['name']) && !trigger_plugin_hook('hj:framework:form:fileupload', 'all', array('entity' => $file), false)) {
                            $newfilefolder = get_input('newfilefolder');
                            $filefolder = get_input('filefolder');

                            if ((int) $filefolder > 0) {
                                $filefolder = get_entity(get_input('filefolder'));
                            } else {
                                if (!$newfilfolder)
                                    $newfilfolder = 'Default';

                                $filefolder = new ElggObject();
                                $filefolder->title = $newfilefolder;
                                $filefolder->subtype = 'hjfilefolder';
                                $filefolder->datatype = 'default';
                                $filefolder->data_pattern = hj_framework_get_data_pattern('object', 'hjfilefolder');
                                $filefolder->owner_guid = $owner->guid;
                                $filefolder->container_guid = $formSubmission->getGUID();
                                $filefolder->access_id = $formSubmission->access_id;
                                $filefolder->save();

                                hj_framework_set_entity_priority($filefolder);
                            }

                            // Just in case we want to upload a newer version of the file in the future
                            if ($file_guid = get_input("{$field_name}_guid")) {
                                $existing_file = true;
                                $file_guid = (int) $file_guid;
                            } else {
                                $existing_file = false;
                                $file_guid = null;
                            }

                            if (!$file_title = get_input("{$field_name}_title")) {
                                $file_title = get_input('title');
                            }
                            if (!$file_description = get_input("{$field_name}_description")) {
                                $file_description = get_input('description');
                            }
                            if (!$file_tags = get_input("{$field_name}_tags")) {
                                $file_tags = get_input('tags');
                                $file_tags = explode(',', $file_tags);
                            }

                            $filehandler = new hjFile($file_guid);
                            $filehandler->owner_guid = elgg_get_logged_in_user_guid();
                            $filehandler->container_guid = $filefolder->getGUID();
                            $filehandler->access_id = $filefolder->access_id;
                            $filehandler->data_pattern = hj_framework_get_data_pattern('object', 'hjfile');
                            $filehandler->title = $file_title;
                            $filehandler->description = $file_description;
                            $filehandler->tags = $file_tags;

                            $prefix = "hjfile/{$filefolder->getGUID()}/";

                            if ($existing_file) {
                                $filename = $filehandler->getFilenameOnFilestore();
                                if (file_exists($filename)) {
                                    unlink($filename);
                                }
                                $filestorename = $filehandler->getFilename();
                                $filestorename = elgg_substr($filestorename, elgg_strlen($prefix));
                            } else {
                                $filestorename = elgg_strtolower($file['name']);
                            }

                            $filehandler->setFilename($prefix . $filestorename);
                            $filehandler->setMimeType($file['type']);
                            $filehandler->originalfilename = $file['name'];
                            $filehandler->simpletype = file_get_simple_type($file['type']);
                            $filehandler->filesize = round($file['size'] / (1024 * 1024), 2) . "Mb";

                            $filehandler->open("write");
                            $filehandler->close();
                            move_uploaded_file($file['tmp_name'], $filehandler->getFilenameOnFilestore());

                            $file_guid = $filehandler->save();

                            hj_framework_set_entity_priority($filehandler);
                            elgg_trigger_plugin_hook('hj:framework:file:process', 'object', array('entity' => $filehandler));

                            if ($file_guid) {
                                $formSubmission->$field_name = $filehandler->getGUID();
                            } else {
                                $formSubmission->$field_name = $filehandler->getFilenameOnFilestore();
                            }

                            if ($file_guid && $filehandler->simpletype == "image") {

                                $thumb_sizes = array(
                                    'tiny' => 16,
                                    'small' => 25,
                                    'medium' => 40,
                                    'large' => 100,
                                    'preview' => 250,
                                    'master' => 600,
                                    'full' => 1024,
                                );

                                foreach ($thumb_sizes as $thumb_type => $thumb_size) {
                                    $thumbnail = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), $thumb_size, $thumb_size, false, 0, 0, 0, 0, true);
                                    if ($thumbnail) {
                                        $thumb = new ElggFile();
                                        $thumb->setMimeType($file['type']);

                                        $thumb->setFilename("{$prefix}thumb{$thumb_type}_{$filestorename}");
                                        $thumb->open("write");
                                        $thumb->write($thumbnail);
                                        $thumb->close();

                                        $thumb_meta = "{$thumb_type}thumb";
                                        $filehandler->$thumb_meta = $thumb->getFilename();
                                        unset($thumbnail);
                                    }
                                }
                            }
                        }
                    }
                    break;
            }
        }
    }
}
if ($saved) {
    // In case we want to manipulate received data
    if (elgg_trigger_plugin_hook('hj:framework:form:process', 'all', array('guid' => $formSubmission->getGUID(), 'event' => $event, 'context' => $context, 'params' => $params), true)) {
        
        if ($formSubmission->notify_admins) {
            $admins = elgg_get_admins();
            foreach ($admins as $admin) {
                $to[] = $admin->guid;
            }
            $from = elgg_get_config('site')->guid;
            $subject = sprintf(elgg_echo('hj:formbuilder:formsubmission:subject'), $form->title);
            elgg_set_context('admin');
            $submissions_url = elgg_normalize_url('hjform/submissions/' . $form->guid);
            $message = sprintf(elgg_echo('hj:formbuilder:formsubmission:body'), elgg_view_entity($formSubmission), $submissions_url);
            notify_user($to, $from, $subject, $message);
        }
        if ($formSubmission->add_to_river) {
            $view = "river/$formSubmission->type/$formSubmission->subtype/$event";
            if (!elgg_view_exists($view)) {
                $view = "river/object/hjformsubmission/create";
            }
            add_to_river($view, "$event", elgg_get_logged_in_user_guid(), $formSubmission->guid);
        }
        system_message(elgg_echo('hj:formbuilder:submit:success'));

        if (elgg_is_xhr()) {
            $newFormSubmission = get_entity($formSubmission->guid);
            $output['data'] = elgg_view_entity($newFormSubmission, array('full_view' => true, 'viewtype' => $viewtype));
            elgg_set_ignore_access($access);
            print(json_encode($output));
            die();
        }
        if ($form->subject_entity_subtype == 'hjsegment') {
            $url = "{$container->getURL()}&sg={$formSubmission->guid}";
        } else {
            $url = $formSubmission->getURL();
        }
        forward($url);
    }
}

elgg_set_ignore_access($access);
register_error(elgg_echo('hj:formbuilder:submit:error'));
forward(REFERER);
