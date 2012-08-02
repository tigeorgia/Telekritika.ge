<?php

$english = array(
    /**
     *  Admin menu elements
     */
    'admin:hj' => 'Manage hJ',
    'admin:hj:approve' => 'Approve',
    'admin:hj:categories' => 'Categories',
    'admin:hj:comments' => 'Comments',
    'admin:hj:companies' => 'Companies',
    'admin:hj:connections' => 'Connections',
    'admin:hj:formbuilder' => 'FormBuilder',
    'admin:hj:framework' => 'Framework',
    'admin:hj:jobs' => 'Jobs',
    'admin:hj:linkedinservice' => 'LinkedInService',
    'admin:hj:livesearch' => 'LiveSearch',
    'admin:hj:portfolio' => 'Portfolio',
    'admin:hj:styler' => 'Styler',
    /**
     * Subtype names
     */
    'item:object:hjform' => 'hJ Form',
    'item:object:hjfield' => 'hJ Field',
    'item:object:hjformsubmission' => 'hJ Form Submission',
    'item:object:hjfile' => 'hJ File',
    'item:object:hjportfolio' => 'hJ Portfolio',
    'item:object:hjexperience' => 'hJ Work Experience',
    'item:object:hjeducation' => 'hJ Education',
    'item:object:hjskill' => 'hJ Skill',
    'item:object:hjlanguage' => 'hJ Language',
    /**
     * River Items
     */
    'river:create:object:hjfile' => '%s added new file %s',
    'river:update:object:hjfile' => '%s updated file %s',
    /**
     * Form Builder Actions
     */
    'hj:formbuilder:form:savesuccess' => 'Your form was successfully saved',
    'hj:formbuilder:form:saveerror' => 'Your form could not be saved',
    'hj:formbuilder:form:delete:success' => 'Form was successfully deleted',
    'hj:formbuilder:form:delete:error' => 'Form could not be deleted',
    'hf:formcheck:fieldmissing' => 'One or more of the mandatory fields is missing',
    'hj:formbuilder:field:savesuccess' => 'Field was successfully saved',
    'hj:formbuilder:field:delete:success' => 'Field was successfully deleted',
    'hj:formbuilder:field:delete:error' => 'There was a problem deleting this form',
    'hj:formbuilder:field:save:success' => 'Field was successfully saved',
    'hj:formbuilder:field:save:error' => 'This field can not be saved',
    'hj:formbuilder:submit:success' => 'Changes submitted',
    'hj:formbuilder:submit:error' => 'This form could not be submitted',
    'hj:formbuilder:formsubmission:subject' => 'New form submission: %s',
    'hj:formbuilder:formsubmission:body' => 'The submission contained the following details: <br /><br /> %s <br /><br />View all submissions for this form at: %s',
    'hj:formbuilder:field:protected' => 'This field is protected and can not be deleted',
    'hj:framework:formcheck:fieldmissing' => 'At least one mandatory field is missing. Please complete all the required fields marked with a red star',
    /**
     * AJAX interface
     */
    'hj:framework:denied' => 'Access Denied',
    'hj:framework:ajax:noentity' => 'There is currently nothing to show',
    /**
     * Actions
     */
    'hj:framework:entity:delete:success' => 'Successfully completed',
    'hj:framework:entity:delete:error' => 'There was an error deleting this instance',
    'hj:framework:widget:add:success' => 'Section added. Please update section settings',
    'hj:framework:widget:add:error' => "We couldn't add the section",
    
    /**
     * UI
     */
    'hj:framework:fullview' => 'See more',
    'hj:framework:download' => 'Download',
    'hj:framework:addnew' => 'Add',
    'hj:framework:refresh' => 'Refresh',
    'hj:framework:gallery' => 'Gallery View',
    'hj:framework:gallerytitle' => "Details for %s",
    'hj:framework:addwidget' => 'Add Section',
    'hj:framework:download' => 'Download',
    'hj:framework:edit' => 'Edit',
    'hj:framework:delete' => 'Delete',
    'hj:framework:email' => 'Send by email',
    'hj:framework:print' => 'Printer-friendly version',
    'hj:framework:pdf' => 'Save as PDF',
    /**
     * Page Handlers
     */
    'hj:framework:denied' => 'Sorry, we can\'t show you this page',
    'hj:framework:print:title' => 'Print: %s',
    'hj:framework:pdf:title' => 'PDF export of %s',
    /**
     * Files
     */
    'hj:framework:newfolder' => 'New Folder',
    'hj:framework:filefolder' => '<b>Folder:</b> %s',
    'hj:framework:filename' => '<b>Filename:</b>  %s',
    'hj:framework:simpletype' => '<b>Type:</b> %s',
    'hj:framework:filesize' => '<b>Size:</b> %s',
);


add_translation("en", $english);
?>