<?php

	/**
	 * Elgg blog CSS extender
	 * 
	 * @package ElggBlog
	 */

?>

#blogs .pagination {
	margin:5px 10px 0 10px;
	padding:5px;
	display:block;
}
#blogs #two_column_left_sidebar_maincontent {
	padding-bottom:10px;
}

.blog_post_icon {
	float:left;
	margin:3px 0 0 0;
	padding:0;
}

.blog_post h3 {
	font-size: 150%;
	margin:0 0 10px -3px;
	padding:3px;
}

.blog_post h3 a {
	text-decoration: none;
}

.singleview {
	margin: 0 0 0 5px;
	padding: 0 8px 0 8px;
	background: none;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px; 
}
.blog_post p {
	margin: 0 0 5px 0;
}

.blog_post .strapline,
.blog_index_listing .strapline{
	margin: 0 0 3px 35px;
	padding:0;
	line-height:1em;
}
.blog_post p.tags {
	background:transparent url(<?php echo $vars['url']; ?>_graphics/icon_tag.gif) no-repeat scroll left 2px;
	margin: 0px 0px 0px 35px;
	padding:0pt 0pt 0pt 16px;
	min-height:22px;
}

.blog_index_listing p.tags {
	background:transparent url(<?php echo $vars['url']; ?>_graphics/icon_tag.gif) no-repeat scroll left 2px;
	margin: 0px 0px 0px 44px;
	padding:0pt 0pt 0pt 16px;
	min-height:22px;
}

.blog_post .options {
	margin:0;
	padding:0;
}

.blog_post_body{
margin: 17px 0;
}

.blog_post_body img[align="left"] {
	margin: 10px 10px 10px 0;
	float:left;
}
.blog_post_body img[align="right"] {
	margin: 10px 0 10px 10px;
	float:right;
}
.blog_post_body img {
	margin: 10px !important;
}

.blog-comments h3 {
	font-size: 150%;
	margin-bottom: 10px;
}
.blog-comment {
	margin-top: 10px;
	margin-bottom:20px;
	border-bottom: 1px solid #aaaaaa;
}
.blog-comment img {
	float:left;
	margin: 0 10px 0 0;
}
.blog-comment-menu {
	margin:0;
}
.blog-comment-byline {
	background: #dddddd;
	height:22px;
	padding-top:3px;
	margin:0;
}
.blog-comment-text {
	margin:5px 0 5px 0;
}

/* New blog edit column */
#blog_edit_page {
	/* background: #bbdaf7; */
	margin-top:-10px;
}
#blog_edit_page #content_area_user_title h2 {
	background: none;
	border-top: none;
	margin:0 0 10px 0px;
	padding:0px 0 0 0;
}
#blog_edit_page #blog_edit_sidebar #content_area_user_title h2 {
	background:none;
	border-top:none;
	margin:inherit;
	padding:0 0 5px 5px;
	font-size:1.25em;
	line-height:1.2em;
}
#blog_edit_page #blog_edit_sidebar {
	margin:0px 0 22px 0;
	background: #dedede;
	padding:5px;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	border-bottom:1px solid #cccccc;
	border-right:1px solid #cccccc;
}
#blog_edit_page #two_column_left_sidebar_210 {
	width:210px;
	margin:0px 0 20px 0px;
	min-height:360px;
	float:left;
	padding:0;
}
#blog_edit_page #two_column_left_sidebar_maincontent {
	margin:0 0px 20px 20px;
	padding:10px 20px 20px 20px;
	width:670px;
	background: #bbdaf7;
}
/* unsaved blog post preview */
.blog_previewpane {
    border:1px solid #D3322A;
    background:#F7DAD8;
	padding:10px;
	margin:10px;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;	
}
.blog_previewpane p {
	margin:0;
}

#blog_edit_sidebar .publish_controls,
#blog_edit_sidebar .blog_access,
#blog_edit_sidebar .publish_options,
#blog_edit_sidebar .publish_blog,
#blog_edit_sidebar .allow_comments,
#blog_edit_sidebar .categories {
	margin:0 5px 5px 5px;
	border-top:1px solid #cccccc;
}
#blog_edit_page ul {
	padding-left:0px;
	margin:5px 0 5px 0;
	list-style: none;
}
#blog_edit_page p {
	margin:5px 0 5px 0;
}
#blog_edit_page #two_column_left_sidebar_maincontent p {
	margin:0 0 15px 0;
}
#blog_edit_page [type="submit"] {
	font-weight: bold;
	margin: 0px !important;
	padding: 4px;
	height:auto;
}
#blog_edit_page .preview_button a {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	background:white;
	border: 1px solid #cccccc;
	color:#999999;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	width: auto;
	height: auto;
	padding: 3px;
	margin:1px 1px 5px 10px;
	cursor: pointer;
	float:right;
}
#blog_edit_page .preview_button a:hover {
	background:#4690D6;
	color:white;
	text-decoration: none;
	border: 1px solid #4690D6;
}
#blog_edit_page .allow_comments label {
	font-size: 100%;
}

.blog_access .input-access,
.input-access,
.input_pulldown {
	width: 100%;
}
.featured_blog_spot {
	float:right;
	color: #000000;
}
.featured_blog_spot img{
	margin: 2px 0 0 5px;
	float: left;
	padding-right: 3px;
}
.blog_top_holder {
	margin-top: 15px;
	background: #EBE6E6;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
}
.dashbox4 {
	width: 310px;
	float: left;
	background: none;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	margin: 0 0 20px 0;
	padding: 0 0 0 0;
	height: 210px;
}
.dashbox3 {
	float: left;
	position: relative;
	background: none;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	margin: 0 0 20px 10px;
	padding: 0 0 0 0;
	height: auto;
}
.dashbox_content {
	overflow: hidden;
	width: 680px;
	margin: -10px 0 0 0;
	padding: 8px 0 0 0;
}
.dashbox_title_space {
	margin: 0 0 15px 0;
	padding: 2px 0 2px 2px;
	-moz-border-radius-topleft:4px;
	-moz-border-radius-topright:4px;
	-webkit-border-top-right-radius:4px;
	-webkit-border-top-left-radius:4px;
}
.jcarousel-skin-tango2 .jcarousel-container {
    background: none;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px; 
    border: none;
    margin-top: -10px;
}

.jcarousel-skin-tango2 .jcarousel-direction-rtl {
	direction: rtl;
}

.jcarousel-skin-tango2 .jcarousel-container-horizontal {
	width: 700px;
	height: 200px;
    padding: 0;
}

.jcarousel-skin-tango2 .jcarousel-container-vertical {
    width: 75px;
    height: 245px;
    padding: 40px 20px;
}

.jcarousel-skin-tango2 .jcarousel-clip-horizontal {
	width: 700px;
    height: 200px;
}

.jcarousel-skin-tango2 .jcarousel-clip-vertical {
    width:  75px;
    height: 245px;
}

.jcarousel-skin-tango2 .jcarousel-item {
    width: 700px;
    height: 200px;
    cursor:pointer;
}

.jcarousel-skin-tango2 .jcarousel-item-horizontal {
	margin-left: 0;
    margin-right: 5px;
}

.jcarousel-skin-tango2 .jcarousel-direction-rtl .jcarousel-item-horizontal {
	margin-left: 10px;
    margin-right: 0;
}

.jcarousel-skin-tango2 .jcarousel-item-vertical {
    margin-bottom: 10px;
}

.jcarousel-skin-tango2 .jcarousel-item-placeholder {
    background: #fff;
    color: #000;
}

.featured_holder {
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	background: none;
}
.featured_title {
	position: absolute;
	float:left;
	-webkit-transform: rotate(-3deg);
	-moz-transform: rotate(-3deg);
	-moz-box-shadow: 0px 2px 10px #000000;
	-webkit-box-shadow: 0px 2px 10px #000000;
	background: #F6F7C1;
	margin: 17px 0 0 5px;
}
.featured_title h3 {
	color: #698DFA;
	padding: 3px;
}
.featured_content {
	float:left;
	text-align: right;
	background: #FFFFFF;
	padding: 3px;
	min-width: 630px;
	min-height: 100px;
	width: 630px;
	margin: 46px 2px 0 30px;
}
.featured_image {
	float:left;
	-webkit-transform: rotate(-10deg);
	-moz-transform: rotate(-10deg);
	-moz-box-shadow: 0px 2px 15px #000000;
	-webkit-box-shadow: 0px 2px 15px #000000;
	margin: -60px 0 0 15px;
}
.featured_image img {
	width: 18px
	height: 18px;
}
.featured_writer {
	float:left;
	background: #F2F5C4;
	color: #000000;
	margin-left: 40px;
	padding: 5px;
}
.river_object_trackback_create {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_blog.gif) no-repeat left -1px;
}
.related_blogs {
	text-align: center;
	width: 160px;
	margin: 0px;
	padding: 4px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background: none;
}
.related_blogs:hover {
	background: #E8E8E8;
	cursor: hand;
	cursor: pointer;
}

.related_blogs a:hover{
text-decoration: none;
}

#blog_related_articles {
	margin: 20px 0 10px 0;
}

#blog_related_articles h3{
	background: #E8E8E8;
}

 #blog_edit_top_holder {
        float:left;
        margin: 10px 0 0 0;
        padding: 0;
}

.blog_edit {
padding: 5px;
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
border-radius: 8px;
background: #E8E8E8;
width: 220px;
}
#blog_edit_top_left {
margin-right: 10px;
        float:left;
        background: #E8E8E8;
	min-height: 140px;
}
#blog_edit_top_middle {
margin-right: 10px;
        float:left;
	min-height: 140px;
}
#blog_edit_top_middle2 {
margin-right: 9px;
        float:left;
        min-height: 140px;
}
#blog_edit_top_right {
        float:right;
        min-height: 140px;
}
#blog_edit_middle_holder {
        width: 100%;
        float:left;
        margin: 0 0 10px 0;
        padding: 0;
}
#blog_edit_post_box {
        float:left;
        width: 72%;
        padding: 5px 5px 5px 5px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        background: #E8E8E8;
        margin-right: 10px;
        min-height: 420px;
}
#blog_edit_post_preview {
        display:none;
        width:72%;
        float:left;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        background: #E8E8E8;
        padding: 5px 5px 5px 5px;
        min-height: 420px;
}
#blog_edit_categories_box {
        float:left;
        padding: 5px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        background: #E8E8E8;
        width: 220px;
        margin-right: 14px;
        min-height: 420px;
}
#blog_edit_post_box1 {
        float:left;
        width: 99%;
        padding: 5px 5px 5px 5px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        background: #E8E8E8;
        margin-right: 10px;
        min-height: 420px;
}
#blog_edit_post_preview1 {
        display:none;
        width:100%;
        float:left;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        background: #E8E8E8;
        padding: 5px 5px 5px 5px;
        min-height: 420px;
}

#top_blogger_side_icon {
padding-right: 5px;
padding-bottom: 3px;
}

#top_blogger_sidebar {
margin-left: 19px;
}

#top_blogger_sidebar h4{
margin-bottom: 8px;
}

.dashbox_title_space img {
padding-right: 3px;
}

.blog_index_listing,
.singleview  {
padding: 10px 10px;
border-bottom: 1px solid #E8E8E8;
}

.blog_index_listing h3 {
padding-bottom: 7px;
}

#blog_menu_list {
margin: 10px 0;
}

.listing_icon {
float: left;
 margin-right:5px;"
}