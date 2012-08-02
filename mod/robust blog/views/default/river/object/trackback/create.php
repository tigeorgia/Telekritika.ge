<?php

	$performed_by = get_entity($vars['item']->subject_guid);
	$object = get_entity($vars['item']->object_guid);
	
	$author_url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$post_url = "<a href=\"{$object->url}\">{$object->title}</a>";
	
	$string = sprintf(elgg_echo("trackback:wrote"), $author_url, $post_url, $object->blog_name);
	
	echo $string; 
?>