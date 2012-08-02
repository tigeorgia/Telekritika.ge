<?php
/**
 * Article English language file.
 *
 */

$english = array(
	'article' => 'Articles',
	'article:articles' => 'Articles',
	'article:revisions' => 'Revisions',
	'article:archives' => 'Archives',
	'article:article' => 'Article',
	'item:object:article' => 'Articles',

	'article:title:user_articles' => '%s\'s articles',
	'article:title:all_articles' => 'All site articles',
	'article:title:friends' => 'Friends\' articles',

	'article:group' => 'Group article',
	'article:enablearticle' => 'Enable group article',
	'article:write' => 'Write a article post',

	// Editing
	'article:add' => 'Add article post',
	'article:edit' => 'Edit article post',
	'article:excerpt' => 'Excerpt',
	'article:body' => 'Body',
	'article:save_status' => 'Last saved: ',
	'article:never' => 'Never',

	// Statuses
	'article:status' => 'Status',
	'article:status:draft' => 'Draft',
	'article:status:published' => 'Published',
	'article:status:unsaved_draft' => 'Unsaved Draft',

	'article:revision' => 'Revision',
	'article:auto_saved_revision' => 'Auto Saved Revision',

	// messages
	'article:message:saved' => 'Article post saved.',
	'article:error:cannot_save' => 'Cannot save article post.',
	'article:error:cannot_write_to_container' => 'Insufficient access to save article to group.',
	'article:error:post_not_found' => 'This post has been removed, is invalid, or you do not have permission to view it.',
	'article:messages:warning:draft' => 'There is an unsaved draft of this post!',
	'article:edit_revision_notice' => '(Old version)',
	'article:message:deleted_post' => 'Article post deleted.',
	'article:error:cannot_delete_post' => 'Cannot delete article post.',
	'article:none' => 'No article posts',
	'article:error:missing:title' => 'Please enter a article title!',
	'article:error:missing:description' => 'Please enter the body of your article!',
	'article:error:cannot_edit_post' => 'This post may not exist or you may not have permissions to edit it.',
	'article:error:revision_not_found' => 'Cannot find this revision.',

	// river
	'river:create:object:article' => '%s published a article post %s',
	'river:comment:object:article' => '%s commented on the article %s',

	// notifications
	'article:newpost' => 'A new article post',

	// widget
	'article:widget:description' => 'Display your latest article posts',
	'article:morearticles' => 'More article posts',
	'article:numbertodisplay' => 'Number of article posts to display',
	'article:noarticles' => 'No article posts'
);

add_translation('en', $english);
