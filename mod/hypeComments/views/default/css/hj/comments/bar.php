<?php
$base_url = elgg_get_site_url();
$graphics_url = $base_url . 'mod/hypeComments/graphics/';
?>

.hj-comments-bar {
min-height:16px;
vertical-align:middle;
font-size:0.8em;
color:#808080;
margin:5px 0;
}

.hj-comments-bar a {
}

.hj-comments-bar a:hover {
text-decoration:underline;
}

.hj-comments-item-time {
padding-top:2px;
padding-left:18px;
background:transparent url(<?php echo $graphics_url ?>clock.png) no-repeat 0 2px;
height:16px;
line-height:16px;
}

.hj-comments-item-like {
padding-top:2px;
margin-left:10px;
height:16px;
line-height:16px;
}

.hj-comments-bar .like {
padding-left:18px;
background:transparent url(<?php echo $graphics_url ?>like.png) no-repeat 0 2px;
}

.hj-comments-bar .unlike {
padding-left:18px;
background:transparent url(<?php echo $graphics_url ?>unlike.png) no-repeat 0 2px;
}

.hj-comments-containers {
margin-top:10px;
width:90%;
}

.hj-comments-item-like-bar {
padding:5px 5px 5px 24px;
background:#f4f4f4 url(<?php echo $graphics_url ?>like.png) no-repeat 5px 5px;
min-height:16px;
line-height:16px;
margin:0 0 2px;
width:100%;
}

.hj-comments-item-comments-bar {
padding:5px 5px 5px 24px;
background:#f4f4f4 url(<?php echo $graphics_url ?>comments.png) no-repeat 5px 5px;
min-height:16px;
line-height:16px;
margin:0 0 2px;
width:100%;
}

.hj-comments-item-comments {
padding-top:2px;
margin-left:10px;
padding-left:18px;
background:transparent url(<?php echo $graphics_url ?>comments.png) no-repeat 0 2px;
height:16px;
line-height:16px;
}

.hj-comments-item-comments-container {

}

.hj-comments-item-comment {
padding:5px 24px 5px 5px;
background:#f4f4f4;
min-height:16px;
line-height:16px;
margin:0 0 2px;
width:100%;
}

.hj-comments-item-comment-content {
max-width:85%;
}

.hj-comments-item-comment-icon {
padding:3px 10px 3px 3px;
}

.hj-comments-item-comment-value {
color:#333333;
font-size:1.1em;
}

.hj-comments-item-comment-owner {
padding-right:8px;
font-size:1.1em;
font-weight:bold;
}

.comment-delete {
margin-left:15px;
}

.following-icon {
width:20px;
height:40px;
margin:0 2px 0 2px;
background: url(<?php echo $vars['url']; ?>mod/hj/comments/graphics/follow_icon.png) no-repeat left top;
}

.hj-comments-small-button {
font-size:.9em;
color:#666666;
font-weight:bold;
}