<?php

	/**
	 * Badge viewer
	 */

	action_gatekeeper();
	 
	$file_guid = (int) get_input("file_guid");
	$file = get_entity($file_guid);
	
	if ($file) {
		$filename = $file->originalfilename;
		$mime = $file->mimetype;
		
        header("Content-type: $mime");
        header("Content-Disposition: inline; filename=\"$filename\"");
		
		$readfile = new ElggFile($file_guid);
		$readfile->owner_guid = $file->owner_guid;

        $contents = $readfile->grabFile();
		
        echo $contents;
		
		exit;
	}

?>
