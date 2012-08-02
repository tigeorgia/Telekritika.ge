<?php
/**
 * Editorial English language file.
 *
 */

$english = array(
	'editorial' => 'Editorials',
	'editorial:editorials' => 'Editorials',
	'editorial:revisions' => 'Revisions',
	'editorial:archives' => 'Archives',
	'editorial:editorial' => 'Editorial',
	'item:object:editorial' => 'Editorials',

	'editorial:title:user_editorials' => '%s\'s editorials',
	'editorial:title:all_editorials' => 'All site editorials',
	'editorial:title:friends' => 'Friends\' editorials',

	'editorial:group' => 'Group editorial',
	'editorial:enableeditorial' => 'Enable group editorial',
	'editorial:write' => 'Write a editorial post',

	// Editing
	'editorial:add' => 'Add editorial post',
	'editorial:edit' => 'Edit editorial post',
	'editorial:excerpt' => 'Excerpt',
	'editorial:body' => 'Body',
	'editorial:save_status' => 'Last saved: ',
	'editorial:never' => 'Never',

	// Statuses
	'editorial:status' => 'Status',
	'editorial:status:draft' => 'Draft',
	'editorial:status:published' => 'Published',
	'editorial:status:unsaved_draft' => 'Unsaved Draft',

	'editorial:revision' => 'Revision',
	'editorial:auto_saved_revision' => 'Auto Saved Revision',

	// messages
	'editorial:message:saved' => 'Editorial post saved.',
	'editorial:error:cannot_save' => 'Cannot save editorial post.',
	'editorial:error:cannot_write_to_container' => 'Insufficient access to save editorial to group.',
	'editorial:error:post_not_found' => 'This post has been removed, is invalid, or you do not have permission to view it.',
	'editorial:messages:warning:draft' => 'There is an unsaved draft of this post!',
	'editorial:edit_revision_notice' => '(Old version)',
	'editorial:message:deleted_post' => 'Editorial post deleted.',
	'editorial:error:cannot_delete_post' => 'Cannot delete editorial post.',
	'editorial:none' => 'No editorial posts',
	'editorial:error:missing:title' => 'Please enter a editorial title!',
	'editorial:error:missing:description' => 'Please enter the body of your editorial!',
	'editorial:error:cannot_edit_post' => 'This post may not exist or you may not have permissions to edit it.',
	'editorial:error:revision_not_found' => 'Cannot find this revision.',

	// river
	'river:create:object:editorial' => '%s published a editorial post %s',
	'river:comment:object:editorial' => '%s commented on the editorial %s',

	// notifications
	'editorial:newpost' => 'A new editorial post',

	// widget
	'editorial:widget:description' => 'Display your latest editorial posts',
	'editorial:moreeditorials' => 'More editorial posts',
	'editorial:numbertodisplay' => 'Number of editorial posts to display',
	'editorial:noeditorials' => 'No editorial posts'
);

add_translation('en', $english);
