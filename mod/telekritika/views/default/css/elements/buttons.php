<?php
/**
 * CSS buttons
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>
/* **************************
	BUTTONS
************************** */

/* Base */
.elgg-button {
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    outline: none;
    border: 0;
    color: #DDD;
background: #2d2d2d; /* Old browsers */
background: -moz-linear-gradient(left,  #2d2d2d 70%, #0a0a0a 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(70%,#2d2d2d), color-stop(100%,#0a0a0a)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(left,  #2d2d2d 70%,#0a0a0a 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(left,  #2d2d2d 70%,#0a0a0a 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(left,  #2d2d2d 70%,#0a0a0a 100%); /* IE10+ */
background: linear-gradient(left,  #2d2d2d 70%,#0a0a0a 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2d2d2d', endColorstr='#0a0a0a',GradientType=1 ); /* IE6-9 */

    
}
a.elgg-button {
	padding: 3px 6px;
}

/* Submit: This button should convey, "you're about to take some definitive action" */
.elgg-button-submit {
/*	color: white;
	text-shadow: 1px 1px 0px black;
	text-decoration: none;
	border: 1px solid #4690d6;
	background: #4690d6 url(<?php echo elgg_get_site_url(); ?>_graphics/button_graduation.png) repeat-x left 10px;
*/
box-shadow: none;
}

.elgg-button-submit:hover {
    text-decoration: none;
    color: white;
    *border-color: #0054a7;
    *background: #0054a7 url(<?php echo elgg_get_site_url(); ?>_graphics/button_graduation.png) repeat-x left 10px;
}

.elgg-button-submit.elgg-state-disabled {
	background: #999;
	border-color: #999;
	cursor: default;
}

/* Cancel: This button should convey a negative but easily reversible action (e.g., turning off a plugin) */
.elgg-button-cancel {
	color: #333;
	background: #ddd url(<?php echo elgg_get_site_url(); ?>_graphics/button_graduation.png) repeat-x left 10px;
	border: 1px solid #999;
}
.elgg-button-cancel:hover {
	color: #444;
	background-color: #999;
	background-position: left 10px;
	text-decoration: none;
}

/* Action: This button should convey a normal, inconsequential action, such as clicking a link */
.elgg-button-action {
	background: #ccc url(<?php echo elgg_get_site_url(); ?>_graphics/button_background.gif) repeat-x 0 0;
	border:1px solid #999;
	color: #333;
	padding: 2px 15px;
	text-align: center;
	font-weight: bold;
	text-decoration: none;
	text-shadow: 0 1px 0 white;
	cursor: pointer;
	
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
}

.elgg-button-action:hover,
.elgg-button-action:focus {
	background: #ccc url(<?php echo elgg_get_site_url(); ?>_graphics/button_background.gif) repeat-x 0 -15px;
	color: #111;
	text-decoration: none;
	border: 1px solid #999;
}

/* Delete: This button should convey "be careful before you click me" */
.elgg-button-delete {
	color: #bbb;
	text-decoration: none;
	border: 1px solid #333;
	background: #555 url(<?php echo elgg_get_site_url(); ?>_graphics/button_graduation.png) repeat-x left 10px;
	text-shadow: 1px 1px 0px black;
}
.elgg-button-delete:hover {
	color: #999;
	background-color: #333;
	background-position: left 10px;
	text-decoration: none;
}

.elgg-button-nondropdown, .elgg-button-dropdown {
	padding:3px 6px;
	text-decoration:none;
	display:block;
	font-weight:bold;
	position:relative;
	margin-left:0;
	color: #999;
	border:1px solid #999;
	
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	
	-webkit-box-shadow: 0 0 0;
	-moz-box-shadow: 0 0 0;
	box-shadow: 0 0 0;
	
	/*background-image:url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png);
	background-position:-150px -51px;
	background-repeat:no-repeat;*/
}

.elgg-button-dropdown:after {
    content: " \25BC ";
    font-size:smaller;
}

.elgg-button-nondropdown:after {
	content: " ";
	font-size:smaller;
}

.elgg-button-nondropdown:hover, .elgg-button-dropdown:hover {
	background-color:#F2F2F2;
	text-decoration:none;
}

.elgg-button-dropdown.elgg-state-active {
	background: #ccc;
	outline: none;
	color: #333;
	border:1px solid #ccc;
	
	-webkit-border-radius:4px 4px 0 0;
	-moz-border-radius:4px 4px 0 0;
	border-radius:4px 4px 0 0;
}

.elgg-button {
    color: white;
}

.elgg-button:hover {
    text-decoration: none;
    color: #999;
    *border-color: #0054a7;
    *background: #0054a7 url(<?php echo elgg_get_site_url(); ?>_graphics/button_graduation.png) repeat-x left 10px;
}
