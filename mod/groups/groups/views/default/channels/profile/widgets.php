<?php
/**
* Profile widgets/tools
* 
* @package ElggGroups
*/ 
	
// tools widget area
echo '<div id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';
	
// enable tools to extend this area
echo elgg_view("channels/tool_latest", $vars);

// backward compatibility
$right = elgg_view('channels/right_column', $vars);
$left = elgg_view('channels/left_column', $vars);
if ($right || $left) {
	elgg_deprecated_notice('The views groups/right_column and groups/left_column have been replaced by groups/tool_latest', 1.8);
	echo $left;
	echo $right;
}

echo "</div>";		 

