<?php
/**
 * Custom Index CSS
 *
 */
?>

h3, h2{
    color: #333;
}

#mainslider h3{
color: #c32524;
}

a{
    color: #333;
}

a, a:hover{
text-decoration: none;
}


/*
 * CSS Styles that are needed by jScrollPane for it to operate correctly.
 *
 * Include this stylesheet in your site or copy and paste the styles below into your stylesheet - jScrollPane
 * may not operate correctly without them.
 */

.jspContainer
{
    overflow: hidden;
    position: relative;
}

.jspPane
{
    position: absolute;
}

.cv-segment-comments .jspContainer > .jspPane{
    *padding-top:14px !important;
}

.segments_type{
    padding:4px;
}

.jspVerticalBar
{
    position: absolute;
    top: 0;
    right: 0;
    width: 16px;
    height: 100%;
width: 6px;
*    background: red;
}


.jspHorizontalBar
{
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 16px;
    background: red;
}

.jspVerticalBar *,
.jspHorizontalBar *
{
    margin: 0;
    padding: 0;
}

.jspCap
{
    display: none;
}

.jspHorizontalBar .jspCap
{
    float: left;
}

.jspTrack
{
    background: transparent;
    position: relative;
}

.jspDrag
{
background: #72000D;
position: relative;
top: 0;
left: 0;
cursor: pointer;
opacity: .6;
border-radius: 2px;
display: none;
}

.returned_segments > div > div.jspVerticalBar .jspDrag,
.cv_read_module > div > div.jspVerticalBar .jspDrag,
.jspDrag{
display: block;
}

.jspHorizontalBar .jspTrack,
.jspHorizontalBar .jspDrag
{
    float: left;
    height: 100%;
}

.jspArrow
{
    background: #50506d;
    text-indent: -20000px;
    display: block;
    cursor: pointer;
}

.jspArrow.jspDisabled
{
    cursor: default;
    background: #80808d;
}

.jspVerticalBar .jspArrow
{
    height: 16px;
}

.jspHorizontalBar .jspArrow
{
    width: 16px;
    float: left;
    height: 100%;
}

.jspVerticalBar .jspArrow:focus
{
    outline: none;
}

.jspCorner
{
    background: #eeeef4;
    float: left;
    height: 100%;
}

/* Yuk! CSS Hack for IE6 3 pixel bug :( */
* html .jspCorner
{
    margin: 0 -3px 0 0;
}








/*******************************
	Custom Index
********************************/
.custom-index {
    padding: 0 0 10px;
}
.tk-main-module > .elgg-body{
*min-height: 400px;
}
.custom-index .elgg-module-featured:hover {
	-webkit-box-shadow: 1px 1px 6px #AAA;
	-moz-box-shadow: 1px 1px 6px #AAA;
	box-shadow: 1px 1px 6px #AAA;
}

::-webkit-input-placeholder {color: #999;}
:-moz-placeholder {color: #999;}
.placeholder { color: #999; }

/*
 * jQuery UI CSS Framework 1.8.16
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Theming/API
 */

/* Layout helpers
----------------------------------*/
.ui-helper-hidden { display: none; }
.ui-helper-hidden-accessible { position: absolute !important; clip: rect(1px 1px 1px 1px); clip: rect(1px,1px,1px,1px); }
.ui-helper-reset { margin: 0; padding: 0; border: 0; outline: 0; line-height: 1.3; text-decoration: none; font-size: 100%; list-style: none; }
.ui-helper-clearfix:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }
.ui-helper-clearfix { display: inline-block; }
/* required comment for clearfix to work in Opera \*/
* html .ui-helper-clearfix { height:1%; }
.ui-helper-clearfix { display:block; }
/* end clearfix */
.ui-helper-zfix { width: 100%; height: 100%; top: 0; left: 0; position: absolute; opacity: 0; filter:Alpha(Opacity=0); }


/* Interaction Cues
----------------------------------*/
.ui-state-disabled { cursor: default !important; }


/*  
----------------------------------*/

/* states and images */
.ui-icon { display: block; text-indent: -99999px; overflow: hidden; background-repeat: no-repeat; }


/* Misc visuals
----------------------------------*/

/* Overlays */
.ui-widget-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }






/*
 * jQuery UI Autocomplete 1.8.16
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Autocomplete#theming
 */
.ui-autocomplete { position: absolute; cursor: default; }    

/* workarounds */
* html .ui-autocomplete { width:1px; } /* without this, the menu expands to 100% in IE6 */

/*
 * jQuery UI Menu 1.8.16
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Menu#theming
 */
.ui-menu {
    list-style:none;
    padding: 2px;
    margin: 0;
    display:block;
    float: left;
}
.ui-menu .ui-menu {
    margin-top: -3px;
}
.ui-menu .ui-menu-item {
    margin:0;
    padding: 0;
    zoom: 1;
    float: left;
    clear: left;
    width: 100%;
}
.ui-menu .ui-menu-item a {
    text-decoration:none;
    display:block;
    padding:.2em .4em;
    line-height:1.5;
    zoom:1;
}
.ui-menu .ui-menu-item a.ui-state-hover,
.ui-menu .ui-menu-item a.ui-state-active {
    font-weight: normal;
    margin: -1px;
}



/*
 * jQuery UI CSS Framework 1.8.16
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Theming/API
 *
 * To view and modify this theme, visit http://jqueryui.com/themeroller/
 */


/* Component containers
----------------------------------*/
.ui-widget { font-family: Verdana,Arial,sans-serif/*{ffDefault}*/; font-size: 1.1em/*{fsDefault}*/; }
.ui-widget .ui-widget { font-size: 1em; }
.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button { font-family: Verdana,Arial,sans-serif/*{ffDefault}*/; font-size: 1em; }
.ui-widget-content { border: 1px solid #aaaaaa/*{borderColorContent}*/; background: #ffffff/*{bgColorContent}*/ url(images/ui-bg_flat_75_ffffff_40x100.png)/*{bgImgUrlContent}*/ 50%/*{bgContentXPos}*/ 50%/*{bgContentYPos}*/ repeat-x/*{bgContentRepeat}*/; color: #222222/*{fcContent}*/; }
.ui-widget-content a { color: #222222/*{fcContent}*/; }
.ui-widget-header { border: 1px solid #aaaaaa/*{borderColorHeader}*/; background: #cccccc/*{bgColorHeader}*/ url(images/ui-bg_highlight-soft_75_cccccc_1x100.png)/*{bgImgUrlHeader}*/ 50%/*{bgHeaderXPos}*/ 50%/*{bgHeaderYPos}*/ repeat-x/*{bgHeaderRepeat}*/; color: #222222/*{fcHeader}*/; font-weight: bold; }
.ui-widget-header a { color: #222222/*{fcHeader}*/; }

/* Interaction states
----------------------------------*/
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border: 1px solid #d3d3d3/*{borderColorDefault}*/; background: #e6e6e6/*{bgColorDefault}*/ url(images/ui-bg_glass_75_e6e6e6_1x400.png)/*{bgImgUrlDefault}*/ 50%/*{bgDefaultXPos}*/ 50%/*{bgDefaultYPos}*/ repeat-x/*{bgDefaultRepeat}*/; font-weight: normal/*{fwDefault}*/; color: #555555/*{fcDefault}*/; }
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited { color: #555555/*{fcDefault}*/; text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 1px solid #999999/*{borderColorHover}*/; background: #dadada/*{bgColorHover}*/ url(images/ui-bg_glass_75_dadada_1x400.png)/*{bgImgUrlHover}*/ 50%/*{bgHoverXPos}*/ 50%/*{bgHoverYPos}*/ repeat-x/*{bgHoverRepeat}*/; font-weight: normal/*{fwDefault}*/; color: #212121/*{fcHover}*/; }
.ui-state-hover a, .ui-state-hover a:hover { color: #212121/*{fcHover}*/; text-decoration: none; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active { border: 1px solid #aaaaaa/*{borderColorActive}*/; background: #ffffff/*{bgColorActive}*/ url(images/ui-bg_glass_65_ffffff_1x400.png)/*{bgImgUrlActive}*/ 50%/*{bgActiveXPos}*/ 50%/*{bgActiveYPos}*/ repeat-x/*{bgActiveRepeat}*/; font-weight: normal/*{fwDefault}*/; color: #212121/*{fcActive}*/; }
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: #212121/*{fcActive}*/; text-decoration: none; }
.ui-widget :active { outline: none; }

/* Interaction Cues
----------------------------------*/
.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight  {border: 1px solid #fcefa1/*{borderColorHighlight}*/; background: #fbf9ee/*{bgColorHighlight}*/ url(images/ui-bg_glass_55_fbf9ee_1x400.png)/*{bgImgUrlHighlight}*/ 50%/*{bgHighlightXPos}*/ 50%/*{bgHighlightYPos}*/ repeat-x/*{bgHighlightRepeat}*/; color: #363636/*{fcHighlight}*/; }
.ui-state-highlight a, .ui-widget-content .ui-state-highlight a,.ui-widget-header .ui-state-highlight a { color: #363636/*{fcHighlight}*/; }
.ui-state-error, .ui-widget-content .ui-state-error, .ui-widget-header .ui-state-error {border: 1px solid #cd0a0a/*{borderColorError}*/; background: #fef1ec/*{bgColorError}*/ url(images/ui-bg_glass_95_fef1ec_1x400.png)/*{bgImgUrlError}*/ 50%/*{bgErrorXPos}*/ 50%/*{bgErrorYPos}*/ repeat-x/*{bgErrorRepeat}*/; color: #cd0a0a/*{fcError}*/; }
.ui-state-error a, .ui-widget-content .ui-state-error a, .ui-widget-header .ui-state-error a { color: #cd0a0a/*{fcError}*/; }
.ui-state-error-text, .ui-widget-content .ui-state-error-text, .ui-widget-header .ui-state-error-text { color: #cd0a0a/*{fcError}*/; }
.ui-priority-primary, .ui-widget-content .ui-priority-primary, .ui-widget-header .ui-priority-primary { font-weight: bold; }
.ui-priority-secondary, .ui-widget-content .ui-priority-secondary,  .ui-widget-header .ui-priority-secondary { opacity: .7; filter:Alpha(Opacity=70); font-weight: normal; }
.ui-state-disabled, .ui-widget-content .ui-state-disabled, .ui-widget-header .ui-state-disabled { opacity: .35; filter:Alpha(Opacity=35); background-image: none; }

/* Icons
----------------------------------*/
    
/* states and images */
.ui-icon { width: 16px; height: 16px; background-image: url(<?php echo elgg_get_site_url(); ?>_graphics/ui-icons_222222_256x240.png)/*{iconsContent}*/; }
.ui-widget-content .ui-icon {background-image: url(<?php echo elgg_get_site_url(); ?>_graphics/ui-icons_222222_256x240.png)/*{iconsContent}*/; }
.ui-widget-header .ui-icon {background-image: url(<?php echo elgg_get_site_url(); ?>_graphics/ui-icons_222222_256x240.png)/*{iconsHeader}*/; }
.ui-state-default .ui-icon { background-image: url(<?php echo elgg_get_site_url(); ?>_graphics/ui-icons_888888_256x240.png)/*{iconsDefault}*/; }
.ui-state-hover .ui-icon, .ui-state-focus .ui-icon {background-image: url(<?php echo elgg_get_site_url(); ?>_graphics/ui-icons_454545_256x240.png)/*{iconsHover}*/; }
.ui-state-active .ui-icon {background-image: url(<?php echo elgg_get_site_url(); ?>_graphics/ui-icons_454545_256x240.png)/*{iconsActive}*/; }
.ui-state-highlight .ui-icon {background-image: url(<?php echo elgg_get_site_url(); ?>_graphics/ui-icons_2e83ff_256x240.png)/*{iconsHighlight}*/; }
.ui-state-error .ui-icon, .ui-state-error-text .ui-icon {background-image: url(<?php echo elgg_get_site_url(); ?>_graphics/ui-icons_cd0a0a_256x240.png)/*{iconsError}*/; }

/* positioning */
.ui-icon-carat-1-n { background-position: 0 0; }
.ui-icon-carat-1-ne { background-position: -16px 0; }
.ui-icon-carat-1-e { background-position: -32px 0; }
.ui-icon-carat-1-se { background-position: -48px 0; }
.ui-icon-carat-1-s { background-position: -64px 0; }
.ui-icon-carat-1-sw { background-position: -80px 0; }
.ui-icon-carat-1-w { background-position: -96px 0; }
.ui-icon-carat-1-nw { background-position: -112px 0; }
.ui-icon-carat-2-n-s { background-position: -128px 0; }
.ui-icon-carat-2-e-w { background-position: -144px 0; }
.ui-icon-triangle-1-n { background-position: 0 -16px; }
.ui-icon-triangle-1-ne { background-position: -16px -16px; }
.ui-icon-triangle-1-e { background-position: -32px -16px; }
.ui-icon-triangle-1-se { background-position: -48px -16px; }
.ui-icon-triangle-1-s { background-position: -64px -16px; }
.ui-icon-triangle-1-sw { background-position: -80px -16px; }
.ui-icon-triangle-1-w { background-position: -96px -16px; }
.ui-icon-triangle-1-nw { background-position: -112px -16px; }
.ui-icon-triangle-2-n-s { background-position: -128px -16px; }
.ui-icon-triangle-2-e-w { background-position: -144px -16px; }
.ui-icon-arrow-1-n { background-position: 0 -32px; }
.ui-icon-arrow-1-ne { background-position: -16px -32px; }
.ui-icon-arrow-1-e { background-position: -32px -32px; }
.ui-icon-arrow-1-se { background-position: -48px -32px; }
.ui-icon-arrow-1-s { background-position: -64px -32px; }
.ui-icon-arrow-1-sw { background-position: -80px -32px; }
.ui-icon-arrow-1-w { background-position: -96px -32px; }
.ui-icon-arrow-1-nw { background-position: -112px -32px; }
.ui-icon-arrow-2-n-s { background-position: -128px -32px; }
.ui-icon-arrow-2-ne-sw { background-position: -144px -32px; }
.ui-icon-arrow-2-e-w { background-position: -160px -32px; }
.ui-icon-arrow-2-se-nw { background-position: -176px -32px; }
.ui-icon-arrowstop-1-n { background-position: -192px -32px; }
.ui-icon-arrowstop-1-e { background-position: -208px -32px; }
.ui-icon-arrowstop-1-s { background-position: -224px -32px; }
.ui-icon-arrowstop-1-w { background-position: -240px -32px; }
.ui-icon-arrowthick-1-n { background-position: 0 -48px; }
.ui-icon-arrowthick-1-ne { background-position: -16px -48px; }
.ui-icon-arrowthick-1-e { background-position: -32px -48px; }
.ui-icon-arrowthick-1-se { background-position: -48px -48px; }
.ui-icon-arrowthick-1-s { background-position: -64px -48px; }
.ui-icon-arrowthick-1-sw { background-position: -80px -48px; }
.ui-icon-arrowthick-1-w { background-position: -96px -48px; }
.ui-icon-arrowthick-1-nw { background-position: -112px -48px; }
.ui-icon-arrowthick-2-n-s { background-position: -128px -48px; }
.ui-icon-arrowthick-2-ne-sw { background-position: -144px -48px; }
.ui-icon-arrowthick-2-e-w { background-position: -160px -48px; }
.ui-icon-arrowthick-2-se-nw { background-position: -176px -48px; }
.ui-icon-arrowthickstop-1-n { background-position: -192px -48px; }
.ui-icon-arrowthickstop-1-e { background-position: -208px -48px; }
.ui-icon-arrowthickstop-1-s { background-position: -224px -48px; }
.ui-icon-arrowthickstop-1-w { background-position: -240px -48px; }
.ui-icon-arrowreturnthick-1-w { background-position: 0 -64px; }
.ui-icon-arrowreturnthick-1-n { background-position: -16px -64px; }
.ui-icon-arrowreturnthick-1-e { background-position: -32px -64px; }
.ui-icon-arrowreturnthick-1-s { background-position: -48px -64px; }
.ui-icon-arrowreturn-1-w { background-position: -64px -64px; }
.ui-icon-arrowreturn-1-n { background-position: -80px -64px; }
.ui-icon-arrowreturn-1-e { background-position: -96px -64px; }
.ui-icon-arrowreturn-1-s { background-position: -112px -64px; }
.ui-icon-arrowrefresh-1-w { background-position: -128px -64px; }
.ui-icon-arrowrefresh-1-n { background-position: -144px -64px; }
.ui-icon-arrowrefresh-1-e { background-position: -160px -64px; }
.ui-icon-arrowrefresh-1-s { background-position: -176px -64px; }
.ui-icon-arrow-4 { background-position: 0 -80px; }
.ui-icon-arrow-4-diag { background-position: -16px -80px; }
.ui-icon-extlink { background-position: -32px -80px; }
.ui-icon-newwin { background-position: -48px -80px; }
.ui-icon-refresh { background-position: -64px -80px; }
.ui-icon-shuffle { background-position: -80px -80px; }
.ui-icon-transfer-e-w { background-position: -96px -80px; }
.ui-icon-transferthick-e-w { background-position: -112px -80px; }
.ui-icon-folder-collapsed { background-position: 0 -96px; }
.ui-icon-folder-open { background-position: -16px -96px; }
.ui-icon-document { background-position: -32px -96px; }
.ui-icon-document-b { background-position: -48px -96px; }
.ui-icon-note { background-position: -64px -96px; }
.ui-icon-mail-closed { background-position: -80px -96px; }
.ui-icon-mail-open { background-position: -96px -96px; }
.ui-icon-suitcase { background-position: -112px -96px; }
.ui-icon-comment { background-position: -128px -96px; }
.ui-icon-person { background-position: -144px -96px; }
.ui-icon-print { background-position: -160px -96px; }
.ui-icon-trash { background-position: -176px -96px; }
.ui-icon-locked { background-position: -192px -96px; }
.ui-icon-unlocked { background-position: -208px -96px; }
.ui-icon-bookmark { background-position: -224px -96px; }
.ui-icon-tag { background-position: -240px -96px; }
.ui-icon-home { background-position: 0 -112px; }
.ui-icon-flag { background-position: -16px -112px; }
.ui-icon-calendar { background-position: -32px -112px; }
.ui-icon-cart { background-position: -48px -112px; }
.ui-icon-pencil { background-position: -64px -112px; }
.ui-icon-clock { background-position: -80px -112px; }
.ui-icon-disk { background-position: -96px -112px; }
.ui-icon-calculator { background-position: -112px -112px; }
.ui-icon-zoomin { background-position: -128px -112px; }
.ui-icon-zoomout { background-position: -144px -112px; }
.ui-icon-search { background-position: -160px -112px; }
.ui-icon-wrench { background-position: -176px -112px; }
.ui-icon-gear { background-position: -192px -112px; }
.ui-icon-heart { background-position: -208px -112px; }
.ui-icon-star { background-position: -224px -112px; }
.ui-icon-link { background-position: -240px -112px; }
.ui-icon-cancel { background-position: 0 -128px; }
.ui-icon-plus { background-position: -16px -128px; }
.ui-icon-plusthick { background-position: -32px -128px; }
.ui-icon-minus { background-position: -48px -128px; }
.ui-icon-minusthick { background-position: -64px -128px; }
.ui-icon-close { background-position: -80px -128px; }
.ui-icon-closethick { background-position: -96px -128px; }
.ui-icon-key { background-position: -112px -128px; }
.ui-icon-lightbulb { background-position: -128px -128px; }
.ui-icon-scissors { background-position: -144px -128px; }
.ui-icon-clipboard { background-position: -160px -128px; }
.ui-icon-copy { background-position: -176px -128px; }
.ui-icon-contact { background-position: -192px -128px; }
.ui-icon-image { background-position: -208px -128px; }
.ui-icon-video { background-position: -224px -128px; }
.ui-icon-script { background-position: -240px -128px; }
.ui-icon-alert { background-position: 0 -144px; }
.ui-icon-info { background-position: -16px -144px; }
.ui-icon-notice { background-position: -32px -144px; }
.ui-icon-help { background-position: -48px -144px; }
.ui-icon-check { background-position: -64px -144px; }
.ui-icon-bullet { background-position: -80px -144px; }
.ui-icon-radio-off { background-position: -96px -144px; }
.ui-icon-radio-on { background-position: -112px -144px; }
.ui-icon-pin-w { background-position: -128px -144px; }
.ui-icon-pin-s { background-position: -144px -144px; }
.ui-icon-play { background-position: 0 -160px; }
.ui-icon-pause { background-position: -16px -160px; }
.ui-icon-seek-next { background-position: -32px -160px; }
.ui-icon-seek-prev { background-position: -48px -160px; }
.ui-icon-seek-end { background-position: -64px -160px; }
.ui-icon-seek-start { background-position: -80px -160px; }
/* ui-icon-seek-first is deprecated, use ui-icon-seek-start instead */
.ui-icon-seek-first { background-position: -80px -160px; }
.ui-icon-stop { background-position: -96px -160px; }
.ui-icon-eject { background-position: -112px -160px; }
.ui-icon-volume-off { background-position: -128px -160px; }
.ui-icon-volume-on { background-position: -144px -160px; }
.ui-icon-power { background-position: 0 -176px; }
.ui-icon-signal-diag { background-position: -16px -176px; }
.ui-icon-signal { background-position: -32px -176px; }
.ui-icon-battery-0 { background-position: -48px -176px; }
.ui-icon-battery-1 { background-position: -64px -176px; }
.ui-icon-battery-2 { background-position: -80px -176px; }
.ui-icon-battery-3 { background-position: -96px -176px; }
.ui-icon-circle-plus { background-position: 0 -192px; }
.ui-icon-circle-minus { background-position: -16px -192px; }
.ui-icon-circle-close { background-position: -32px -192px; }
.ui-icon-circle-triangle-e { background-position: -48px -192px; }
.ui-icon-circle-triangle-s { background-position: -64px -192px; }
.ui-icon-circle-triangle-w { background-position: -80px -192px; }
.ui-icon-circle-triangle-n { background-position: -96px -192px; }
.ui-icon-circle-arrow-e { background-position: -112px -192px; }
.ui-icon-circle-arrow-s { background-position: -128px -192px; }
.ui-icon-circle-arrow-w { background-position: -144px -192px; }
.ui-icon-circle-arrow-n { background-position: -160px -192px; }
.ui-icon-circle-zoomin { background-position: -176px -192px; }
.ui-icon-circle-zoomout { background-position: -192px -192px; }
.ui-icon-circle-check { background-position: -208px -192px; }
.ui-icon-circlesmall-plus { background-position: 0 -208px; }
.ui-icon-circlesmall-minus { background-position: -16px -208px; }
.ui-icon-circlesmall-close { background-position: -32px -208px; }
.ui-icon-squaresmall-plus { background-position: -48px -208px; }
.ui-icon-squaresmall-minus { background-position: -64px -208px; }
.ui-icon-squaresmall-close { background-position: -80px -208px; }
.ui-icon-grip-dotted-vertical { background-position: 0 -224px; }
.ui-icon-grip-dotted-horizontal { background-position: -16px -224px; }
.ui-icon-grip-solid-vertical { background-position: -32px -224px; }
.ui-icon-grip-solid-horizontal { background-position: -48px -224px; }
.ui-icon-gripsmall-diagonal-se { background-position: -64px -224px; }
.ui-icon-grip-diagonal-se { background-position: -80px -224px; }


/* Misc visuals
----------------------------------*/

/* Corner radius */
.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl { -moz-border-radius-topleft: 4px/*{cornerRadius}*/; -webkit-border-top-left-radius: 4px/*{cornerRadius}*/; -khtml-border-top-left-radius: 4px/*{cornerRadius}*/; border-top-left-radius: 4px/*{cornerRadius}*/; }
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr { -moz-border-radius-topright: 4px/*{cornerRadius}*/; -webkit-border-top-right-radius: 4px/*{cornerRadius}*/; -khtml-border-top-right-radius: 4px/*{cornerRadius}*/; border-top-right-radius: 4px/*{cornerRadius}*/; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl { -moz-border-radius-bottomleft: 4px/*{cornerRadius}*/; -webkit-border-bottom-left-radius: 4px/*{cornerRadius}*/; -khtml-border-bottom-left-radius: 4px/*{cornerRadius}*/; border-bottom-left-radius: 4px/*{cornerRadius}*/; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br { -moz-border-radius-bottomright: 4px/*{cornerRadius}*/; -webkit-border-bottom-right-radius: 4px/*{cornerRadius}*/; -khtml-border-bottom-right-radius: 4px/*{cornerRadius}*/; border-bottom-right-radius: 4px/*{cornerRadius}*/; }

/* Overlays */
.ui-widget-overlay { background: #aaaaaa/*{bgColorOverlay}*/ url(images/ui-bg_flat_0_aaaaaa_40x100.png)/*{bgImgUrlOverlay}*/ 50%/*{bgOverlayXPos}*/ 50%/*{bgOverlayYPos}*/ repeat-x/*{bgOverlayRepeat}*/; opacity: .3;filter:Alpha(Opacity=30)/*{opacityOverlay}*/; }
.ui-widget-shadow { margin: -8px/*{offsetTopShadow}*/ 0 0 -8px/*{offsetLeftShadow}*/; padding: 8px/*{thicknessShadow}*/; background: #aaaaaa/*{bgColorShadow}*/ url(images/ui-bg_flat_0_aaaaaa_40x100.png)/*{bgImgUrlShadow}*/ 50%/*{bgShadowXPos}*/ 50%/*{bgShadowYPos}*/ repeat-x/*{bgShadowRepeat}*/; opacity: .3;filter:Alpha(Opacity=30)/*{opacityShadow}*/; -moz-border-radius: 8px/*{cornerRadiusShadow}*/; -khtml-border-radius: 8px/*{cornerRadiusShadow}*/; -webkit-border-radius: 8px/*{cornerRadiusShadow}*/; border-radius: 8px/*{cornerRadiusShadow}*/; }

.ui-accordion { width: 100%; }
.ui-accordion .ui-accordion-header { cursor: pointer; position: relative; margin-top: 1px; zoom: 1; }
.ui-accordion .ui-accordion-li-fix { display: inline; }
.ui-accordion .ui-accordion-header-active { border-bottom: 0 !important; }
.ui-accordion .ui-accordion-header a { display: block; font-size: 1em; padding: .5em .5em .5em .7em; }
.ui-accordion-icons .ui-accordion-header a { padding-left: 2.2em; }
.ui-accordion .ui-accordion-header .ui-icon { position: absolute; left: .5em; top: 50%; margin-top: -8px; display: none;}
.ui-accordion .ui-accordion-content { padding: 1em 2.2em; border-top: 0; margin-top: -2px; position: relative; top: 1px; margin-bottom: 2px; overflow: auto; display: none; zoom: 1; }
.ui-accordion .ui-accordion-content-active { display: block; }


.tk-module, .tk-secondary-module, .tk-river-module{
    padding: 14px;
    background-color: white;
    -webkit-box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);
    -moz-box-shadow:    0px 2px 8px rgba(0, 0, 0, 0.2);
    box-shadow:         0px 2px 8px rgba(0, 0, 0, 0.2);
*    border-top: solid 1px #E4E4E4;
}
.tk-module{
    padding:26px;
}
.tk-main-module{
    padding: 14px;
    background-color: rgba(200, 200, 200, .1);
    -webkit-box-shadow: 0px 0px 12px rgba(155, 155, 155, .7);
    -moz-box-shadow:    0px 0px 12px rgba(155, 155, 155, .7);
    box-shadow:         0px 0px 12px rgba(155, 155, 155, .7);
    padding-top: 18px;
}

.tk-top-module{
    margin-bottom: 8px;
    padding: 8px;
    padding-bottom: 0px;
    background-color: rgba(200, 200, 200, .1);
    -webkit-box-shadow: 0px 0px 12px rgba(155, 155, 155, .7);
    -moz-box-shadow:    0px 0px 12px rgba(155, 155, 155, .7);
    box-shadow:         0px 0px 12px rgba(155, 155, 155, .7);
}

.tk-main-module > .elgg-body,
.tk-secondary-module > .elgg-body,
.tk-module.tagcloudtabs .elgg-tagcloud{
    background-color: rgba(255, 255, 255, .5);
    width: 92%;
    margin: auto;
    padding: 20px;
    padding-top: 34px;
    padding-bottom: 18px;
    border-radius: 25px;
    -moz-border-radius: 25px;
    -webkit-border-radius: 25px;
    border-left: 2px solid rgba(255, 255, 255, .8);
    border-right: 2px solid rgba(255, 255, 255, .8);
}


.tk-secondary-module > .elgg-body,
.tk-module.tagcloudtabs .elgg-tagcloud{

    background-color: rgba(230, 230, 230, .1);
    border-left: 1px solid rgba(0, 0, 0, .1);
    border-right: 1px solid rgba(0, 0, 0, .1);
} 

.tk-module.tagcloudtabs .tabcontent{
    padding: 20px;
}
.tk-module.tagcloudtabs .elgg-tagcloud{
    width: auto;
    padding-top: 20px;
}

.tk-main-module > .elgg-head{
}

.tk-river-module{
    padding:0;
}
.elgg-col .tk-main-module{
    margin-right: 20px;
}

.toppest{
    padding-top: 0 !important;
    padding-right: 0  !important;
    margin-top: 0 !important
}

.tk-module.toppest{
}

.elgg-river img{
height: 40px;
}

.cv-hovermodule{
    display:none;
    z-index:200;
    overflow:visible;
    position:absolute;
}

.stickyhover{
    z-index:199;
}

.cv-hovermodule-segmentcomments{
    max-height:300px;
position: absolute;
    width: 350px;
*    right:-200px;
}


.cv-hovermodule-segmentcomments .segment_menu .elgg-menu-entity,
.cv-hovermodule-segmentcomments .segment_menu .elgg-menu-annotation{
    color: #666;
    float:none;
    width: 100%;
}

.spanspacer{
    float:right;
    width: 60px;
    height:30px;
}

.segments_wrapper{
*    position:relative;
*    background-color: #999;
}

.segment{
    display:block;
    overflow:visible;
    min-height: 30px;
    font-size: 12px;
    line-height:14px;
}

.segment input{
height: 12px;
}

.segment .segdescription{
margin-top:12px;
margin-bottom:6px;
padding-top:6px;
padding-bottom:6px;
display: block;
clear:both;
border-bottom: 1px dotted #CCC;
border-top: 1px dotted #CCC;
width:98%;
margin-left:auto;
margin-right:auto;
}

.segment .segtags{
font-size:10px;
width:90%;
}
a.segment .segtags > span:hover{
    cursor: "pointer";
    color: #CCC;
}

a.segment .smallholder{
    position:absolute;
    right: 3px;
    bottom: 3px;
    opacity: .8;

}
a.segment .smallholder .tv, a.segment .smallholder .tinylink{
    float:right;
    padding:1px;
}

a.segment .smallholder .tinylink img, a.segment .smallholder .tv img{
    width:16px;
    vertical-align: 0;
}
a.segment .smallholder .tinylink img{
    width: 18px;
}

.fblike{
border: none;
overflow: hidden;
width: 80px;
height: 35px;
position: absolute;
right: 78px;
top: 248px;
z-index: 3000;
}

.returned_segments > .jspContainer > .jspPane,
.cv_read_module > .jspContainer > .jspPane,
.jspPane{
    width: 100% !important;
    position:relative;
    z-index: inherit;
}

.returned_segments > .jspContainer > .jspVerticalBar,
.cv_read_module > .jspContainer > .jspVerticalBar,
.jspVerticalBar{
    z-index: 150;
*    width: 100% !important;
}

.cv-hovermodule_commentswrapper{
    padding: 5px;
    background-color: #999;
    position:absolute;
    width:80%;
    color: white;
    border-radius: 10px;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
}


.cv-hovermodule_commentswrapper.popleft{
    left: auto;
    right: 350px;         
    border-top-right-radius: 0;
    -moz-border-top-right-radius: 0;
    -webkit-border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    -moz-border-bottom-right-radius: 0;
    -webkit-border-bottom-right-radius: 0;
    box-shadow: -6px 13px 13px rgba(0,0,0,.6);
    -moz-box-shadow: -6px 13px 13px rgba(0,0,0,.6);
    -webkit-box-shadow: -6px 13px 13px rgba(0,0,0,.4);
}
.poopleft{
    border-top-right-radius: 0;
    -moz-border-top-right-radius: 0;
    -webkit-border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    -moz-border-bottom-right-radius: 0;
    -webkit-border-bottom-right-radius: 0;
    box-shadow: -6px 13px 13px rgba(0,0,0,.6);
    -moz-box-shadow: -6px 13px 13px rgba(0,0,0,.6);
    -webkit-box-shadow: -6px 13px 13px rgba(0,0,0,.4);
}

.cv-hovermodule_commentswrapper.popright{
    right: auto;
    left: 299px;         
    border-top-left-radius: 0;
    -moz-border-top-left-radius: 0;
    -webkit-border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    -moz-border-bottom-left-radius: 0;
    -webkit-border-bottom-left-radius: 0;
    box-shadow: 6px 13px 13px rgba(0,0,0,.6);
    -moz-box-shadow: 6px 13px 13px rgba(0,0,0,.6);
    -webkit-box-shadow: 6px 13px 13px rgba(0,0,0,.4);
}



.cv-hovermodule-segmentcomments .segment_menu ul{
    float:left;
    width:100%;    
}

.moduleselected .cv-segment-comments{
    background-color: rgba(255,255,255,.3) !important;
}

.selectasegment{
    display: block;
}
.moduleselected .selectasegment{
    display: none;
}

.cv-segment-comments{
    background-color: rgba(0,0,0,.1);
    *margin-top:10px;
}    

/*.elgg-comments.cv-segment-comments .elgg-annotation-list{*/
.cv-segment-comments{
    max-height:250px;
    padding: 0;
    border: 0;
    padding-left: 4px;
*    background-color: transparent;
*    width: 90%;
*    overflow-y:scroll;
}

.cv-hovermodule_commentswrapper h3{
height: 20px;
padding-top: 11px;
padding-left: 68px;
}
.cv-hovermodule-segmentcomments .cv-segment-hotcomments{
    height: 40px;
    overflow:auto;
}

.cv-hovermodule-segmentcomments .elgg-form-comments-add input,
.elgg-form-comments-add button, .cv-hovermodule-segmentcomments .elgg-form-comments-add button
{
    font-size:12px;
    width:50%;
    float:right;
    clear:none;
}
.cv-hovermodule-segmentcomments .elgg-form-comments-add{
padding-right: 6px;
*    position:absolute;
*    bottom: 0;
*    right:25px;
*    width:150px;
*    height:100px;
}

.elgg-form-comments-add textarea,
.cv-hovermodule-segmentcomments .elgg-form-comments-add textarea{
    width: 100%;
    height:63px;
    font-size: 10px;
}

.tk-main-module .elgg-head h3,
.tk-secondary-module .elgg-head h3{
color: #D23234;
font-weight: normal;
margin-bottom: -32px;
padding: 0;
margin-left: 24px;
font-size: 12px;
padding-top: 14px;
}
.tk-module .elgg-head h3{
    display:none;
}

.elgg-river > li {
border-bottom: 1px solid #CCC!important;
}

.elgg-list > li{
    border:0;
}

.elgg-list a, .elgg-list a:hover{
    text-decoration:none;
    color: #333;    
}

.elgg-list{
    color: #555;
    *color: #999;
}

.elgg-form-comments-add input,
.cv-hovermodule-segmentcomments .elgg-form-comments-add input
.elgg-form-comments-add button, .cv-hovermodule-segmentcomments .elgg-form-comments-add button
{
    width: 33% !important;
    float: right;
    vertical-align: top;
    clear: right;
}

.cv-hovermodule-segmentcomments .elgg-form-comments-add input
.elgg-form-comments-add button, .cv-hovermodule-segmentcomments .elgg-form-comments-add button
{
    width: 50% !important;
    clear: none;
}
#speak_freely_name_field{
    width:auto;
}

#recaptcha_widget_div{
    display: inline-block;
    position:absolute;
    display:none;
    z-index:205;
}

.elgg-layout-one-column h2{
display:inline-block;
float:left;
width:500px;
}

#cv_segmentselect_module_holder{
clear: both;
position:relative;
}
.title-image-block{
    float: left;
    display: inline-block;
    width:150px;
    clear: both;
}

.custom-index .elgg-body{
overflow: visible;
}
.elgg-module-river .elgg-body{
position:relative;

}

.elgg-head{
}


.elgg-button{
text-transform: uppercase;
}

.elgg-annotation-list .elgg-output{
    padding-left: 6px;
    padding-right: 10px;
    font-size: 12px;
    line-height: 14px;
    border-left: 2px solid #CCC;
    margin-top: 16px;
    margin-left: 4px;
}
.channelviewer_module .elgg-annotation-list .elgg-output{
    padding-left: 0;
    margin: 6px;
    padding-right: 3px;
    font-size: 10px;
    border:0;
    margin-bottom:2px;
    
}

.channelviewer_module .elgg-list{
    color: #FFF;
}

.channelviewer_module.moduleselected .elgg-list{
    color:#999;
}

.cv-modulefooter a{

}

.elgg-channelbar-item a > img, 
.elgg-channelbar-item a:active > img{
    margin-top:11px;
    margin-bottom:20px;
    width: 65px;
    margin-left:2px;
    margin-right:2px;
    vertical-align: bottom;        
}
.elgg-channelbar-item a:hover > img{
    margin-left:-9px;
    margin-right:-9px;
    margin-top:0px;
    margin-bottom:9px;
    width: 85px;
    box-shadow: 0px 3px 12px 0 rgba(0,0,0,.4)
    -moz-box-shadow: 0px 3px 12px 0 rgba(0,0,0,.4);
    -webkit-box-shadow: 0px 3px 12px 0 rgba(0,0,0,.4);
    border: 1px solid rgba(255,255,255,.4);
    //border: 1px solid rgba(0,0,0,.6);
}

fieldset > div#commentary_input_wrapper{
    margin-bottom: 0;
}

.elgg-form-commentary-savefromtemplate .elgg-foot,
.elgg-form-commentary-cvsave .elgg-foot{
    display:none;
}


.elgg-form-commentary-cvsave{
background: -moz-radial-gradient(center, ellipse cover,  rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 30%, rgba(0,0,0,0) 100%); /* FF3.6+ */
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,rgba(0,0,0,0.3)), color-stop(30%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0))); /* Chrome,Safari4+ */
background: -webkit-radial-gradient(center, ellipse cover,  rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 30%,rgba(0,0,0,0) 100%); /* Chrome10+,Safari5.1+ */
background: -o-radial-gradient(center, ellipse cover,  rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 30%,rgba(0,0,0,0) 100%); /* Opera 12+ */
background: -ms-radial-gradient(center, ellipse cover,  rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 30%,rgba(0,0,0,0) 100%); /* IE10+ */
background: radial-gradient(center, ellipse cover,  rgba(0,0,0,0.3) 0%,rgba(0,0,0,0) 30%,rgba(0,0,0,0) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4d000000', endColorstr='#00000000',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}

.elgg-form-commentary-cvsave textarea{
    background-color: rgba(255,255,255,.9);
}

.elgg-page-body{
    min-height:450px;
}



#commentary_description{
    margin-top: -16px;
    height: 120px !important;
    border-color: #666;
    color: #333;
    margin-bottom: 10px;
    
}

#higgen_segments{
    margin:0 !important;
}

#moresegs, #lesssegs{
    opacity: 0;
    position: absolute;
    top: -100px;
    right: 0;
    height: 40px;
    z-index: 1;
    background: url('<?php echo elgg_get_site_url(); ?>_graphics/arrowright.png');
    border: 0 solid black;
    border-top: 1px;
    border-bottom: 1px;
        
}

#lesssegs{
    top: -50px;
    background: url('<?php echo elgg_get_site_url(); ?>_graphics/arrowleft.png');
}

#cv_segmentselect_module_holder .channelviewer_module{
    background-color: #FDFDFD;
    padding:0;
    padding-top:10px;
    border: 1px solid #999;
    width: 299px;
    position:relative;
    display: inline-block;
    text-align: left;
    vertical-align: top;
    margin:5px;
}

.channelname{
    vertical-align:middle;
}

.cvmoduleheader{
    margin-top: 10px;
    padding-right: 4px;
    padding-left: 8px;
}

.cvmoduleheader input{
    clear: right;
    float: right;
    width: 100px !important;
    cursor: pointer;    
}

.cvmoduleheader .chzn-search input{
    float:none;
}

.ui-autocomplete{
    cursor: pointer !important;
}

.chzn-container {
    float:right;
    width: 35% !important;
    margin-right:2px;
}

.chzn-container > a{
*    width: 100%;
*    margin-right: 10px;
}
.search-choice-close{
    display:none;
}

.cvmoduleheader > img
{
    height: 62px;
    width: 62px;
}


.cvmoduleheader > img{
    float:left;
}

.cvmoduleheader > span{
    height: 56px;
    width: 82px;
    margin-top:1px;
    margin-left: 8px;
    border-top: 1px solid #999;
    padding-top: 6px;
    display: inline-block;
    float:left;
}


.returned_segments{
    clear:both;
    color: #666;
}

.segments_wrapper > a,
div.cvmodulefooter > a{
    display: block;
    padding: 4px 6px 8px;
    text-decoration:none;
    color: #666;    
}

div.cvmodulefooter > a{
    padding-top: 8px;
    text-align: center;
    border-top: 1px solid #999;
}

div.cvmodulefooter > a:hover{
    color: red !important;
    text-shadow: 0 0px 9px rgba(255, 105, 105, 1);
    -moz-text-shadow: 0 0px 9px rgba(255, 105, 105, 1);
    -webkit-text-shadow: 0 0px 9px rgba(255, 105, 105, 1);
}

div.cvmodulefooter > a{
    display:none;
}

.segments_wrapper > a:hover,
div.cvmodulefooter > a:hover,
.segments_wrapper a.segmenthover{
    background-color: #999;
    color: white;
    text-decoration:none;
}

.moduleselected .returned_segments a.selectedsegment{
    background-color: yellow;
}

.segments_wrapper a input{
    margin-left:4px;
        margin-top:8px;

    opacity:0;
}

.segments_wrapper a:hover input,
.segments_wrapper a.segmenthover input,
.moduleselected .returned_segments a.selectedsegment input{
    margin-left:4px;
    opacity:1;
}

.segments_wrapper > a > span{
    padding:2px;
    font-size:12px;
    display: inline-block;
    *width:10px;
}
 
.cv-hovermodule-segmentcomments .segment_menu{
    position: absolute;
    top: 4px;
    right: 6px;
}

.cv-hovermodule-segmentcomments .segment_menu .elgg-menu-hz{
    padding-top: 10px;
}
                                                                 
.elgg-menu-item-dislikes-count,
.elgg-menu-item-likes-count{
    margin-top: -10px;
    margin-left: 2px !important;
}

.segments_wrapper .elgg-menu-entity > li,
.segments_wrapper .elgg-menu-annotation > li{
    color: #EEE;
    *margin-left: 5px;
}
.moduleselected .segments_wrapper .elgg-menu-entity > li,
.moduleselected .segments_wrapper .elgg-menu-annotation > li{
    color: #666;
}
div.cvmodulefooter > a:hover,
a.segments_type:hover{
    background-color: #DDD;
    color: #666;
}
a.segments_type_broadcast{
    cursor: default;
    padding: 10px;
    background-color: #DDD;
}
a.segments_type_broadcast:hover{
    background-color: #DDD;

}

.segments_type_broadcast > span.sliderthumbs{
    margin-top: -7px;
}
.segments_wrapper > a{
    border-top: 1px solid #999;
    *padding: 10px;
}

div.bottom > div > div.elgg-body{
    overflow: visible;
    padding-bottom:40px;
}

.show_all_segments{
    display: none;
}
       
.moduleselected .show_all_segments{
    display: block;
}


.dontshowme{
    display: none !important;
}
.showme{
    display: block !important;
}

.moduleselected .cv-hovermodule_commentswrapper{
    background-color: yellow;
    color: #666;
}
                 

.moduleselected .returned_segments .segments_wrapper > a{
    display:none;
}
.returned_segments .segments_wrapper > a{
    position:relative;
}

.moduleselected .returned_segments a.selectedsegment{
    display:block;
    background-color: yellow;
    color: #666;
}

.segment{
    padding: 10px;
}
.segment p{
    display: inline;
}

.elgg-module{
    overflow: visible;
}

body a.translate-link{
    display:inline-block !important;
    background-color: #AAA !important;
}

.tabcontent{
    display:none;
}

.tabcontent.selected{
    display:block;
}
          .small-padding{
    padding: 0 !important;
    margin-bottom: 25px;
}
.tabheaderholder{
    display: table;
    width: 100%;
}
a.tabheader{
    display: table-cell;
    border-right: 1px solid rgba(0,0,0,.1);   
    padding: 10px;
    text-align:center;
    text-decoration: none;
    color: rgba(0,0,0,.2);   
    border-bottom: 1px solid rgba(0,0,0,.1);   
}
a.tabheader:last-child{
    border-right: 0;
}
a.tabheader:hover{
    color: #999;   
}
a.tabheader.selected, a.tabheader.selected:hover{
    color: #777;
    border-bottom: 0;   
}

.tabcontent{
    position:relative;
}

.tabcontent ul.elgg-list{
    border:0;
*    padding: 24px;
*    padding-top:12px;
padding:0;
    margin: 0;
}
.tabcontent ul.elgg-list > li{
    padding:0;
    margin: 0;
}
.tabcontent .tabitemtitle{
    font-size: 16px;
    color: #777;
    display: inline-block;
    font-weight: bold;
}

.tabcontent .tabdate{
    font-size: 10px;
    color: #AAA;
    display: inline-block;    
}

.tabcontent .tabmeta{
    font-size: 10px;
    color: #AAA;
    display: inline-block;
    float:right;
    margin-top:-3px;    
}

.tabcontent .excerpt{
    color: #777;
    display: block;    
    font-size: 12px;
}

.tk-module{
    margin-top:12px
}

.tabcontent span{
    padding-top:2px;
}
.tabcontent span:first-child{
    padding-top:0;

}

.tabcontent > ul > li > a{
    display: block;
    padding: 12px 20px 12px 24px;
}
.tabcontent > ul > li > a:hover{
    background-color: #FCFCFC;
}
              
.elgg-page-footer{
    margin-top:12px;
}              

.thumbs img, .comments img{
    width: 20px;
    padding-left: 3px;
}
.channelviewer_module .thumbs img, .channelviewer_module .comments img{
    width: 14px;
    padding-left: 2px;
    vertical-align: -80%;
}
.channelviewer_module .cv-segment-comments .thumbs img, .channelviewer_module .cv-segment-comments .comments img{
    width: 13px;
    vertical-align: -40%;
}
.cv-segment-comments .elgg-menu-annotation{
    margin-top: 6px;
}


.returned_segments .commentbubble{
    padding-right: 6px;
    margin-right:-6px;
}

/*hahaha*/
.pvm.nopvm{
    padding:0!important;
}

.toppestCV > div > .elgg-body{
padding-top: 8px !important;
padding-bottom: 0 !important;
}

.thumbs.tinythumb img, .comments.tinycomment img{
    width: 13px;
    vertical-align:-60%;
    padding: 3px;
    padding-left: 4px;
}

.elgg-annotation-list .thumbs img, 
.elgg-river .thumbs img, 
.elgg-river .comments img, 
.elgg-annotation-list .comments img{
    width:16px;
}

.cv-hovermodule_commentswrapper .thumbs img{
    width: 15px;
    padding-left: 0px;

}
         
h2 {
    font-size: 26px;
    padding-bottom: 12px;
    *border-bottom: 1px solid #999;
}

h2, h2 > a{
color: #666;
text-shadow: 0px 1px 2px rgba(0, 0, 0, .6);
}
h2 > a:hover{
color: #DEDDED;

}
              
#cv_content-wrapper{
    margin-top: -15px;
}              
              
              
.cv_read_module .cvmoduleheader > span{
    height: auto;
}              
              
.cv_read_module .cvmoduleheader > img{
    height: 30px;
    width: auto;
}
.cv_read_module .cvmoduleheader{
    padding-bottom: 38px;
}
.cv_read_module{
    margin:10px;
    border: 1px solid #999;
    padding: 0px;
}
.cv_videolink{
    position: absolute;
    top: 0;
    right: 10px;
}

.elgg-menu-entity,.elgg-menu-annotation{
height:auto;
}
              
              
a.riverblock:hover .elgg-image-block{
    *background-color: white;
    background-color: #FCFCFC;
}

#ui-datepicker-div,.ui-autocomplete{
    z-index: 3000 !important;
}

.elgg-annotation-list.elgg-list  {
background-color: rgba(210, 210, 210, .1);
padding: 10px;
border: 1px solid #999;
}

.cv-segment-comments.elgg-annotation-list.elgg-list  {
background-color: rgba(55, 55, 55, .1);
padding: 2px;
border: 0px solid #999;
}

.cv-hovermodule_commentswrapper .elgg-annotation-list.elgg-list  {
padding:0;
}

.search-list.elgg-list {
background-color: rgba(180, 180, 180, .1);
padding: 10px;
border: 1px solid #777;
}

.elgg-list.elgg-river {
*border: 1px solid #777;
background-color: #FAFAFA;
margin:0;
padding:0;
}


.elgg-river.elgg-list a, .elgg-river.elgg-list a:hover{
color: #555;
}

.tabcontent .elgg-tagcloud, .tabcontent .elgg-eventcloud{
display: block;
padding: 12px 20px 12px 24px;
}


#profile-owner-block{
    background: transparent;
    border:0;
    margin:0;
    padding:0;
    float:none;
}
#profile-owner-block .elgg-avatar{
    float:right;
}

.profile_commentaries{
    margin-right:40px;
}
.profile_commentaries ul{
    text-align: right;
}
.profile_commentaries a:hover{
    color: #999;
}

.profiledetails{
    float:right;
*    min-height:400px;
    width: 60%;
}

.profileownerblock{
    text-align:center;
*    min-height:400px;
    width:30%;
    float:left;
    display:block;
}

.elgg-module-userprofile{
    overflow:auto;
    position:relative;
}

.elgg-module-userprofile .elgg-body{
    overflow:auto !important;
}

.profilebadge{
    margin-right:10px;
    display: inline-block;
    float:right;
    margin-top: -50px;
}

.elgg-module-userprofile h2{
width: 38%;
text-align: right;
}

.profilebadge:last-child{
    margin-left:0;

}

.badgeswrapper{
    text-align:right;
    width:200px;
    float:right;
}

.profilebadge img{
    width: 90px;
}
              
.ranks{
    text-align: left;
    font-size: 10px;
}

.ranks > span {
display: block;
margin-top: -6px;
}

              
.addshadow{
    text-align: center;
    display:inline-block;
    position:relative;
}

.addshadow .imgtodrop{
    max-width: 200px;
    max-height: 200px;
    margin-bottom: 12%;
}

.addshadow .icondrop{
    z-index: 1;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
}

.icondrop{
    height: 30%;
    opacity: .2;    
}





.jqplot-target{position:relative;color:#666;font-family:"Trebuchet MS",Arial,Helvetica,sans-serif;font-size:1em;}.jqplot-axis{font-size:.75em;}.jqplot-xaxis{margin-top:10px;}.jqplot-x2axis{margin-bottom:10px;}.jqplot-yaxis{margin-right:10px;}.jqplot-y2axis,.jqplot-y3axis,.jqplot-y4axis,.jqplot-y5axis,.jqplot-y6axis,.jqplot-y7axis,.jqplot-y8axis,.jqplot-y9axis,.jqplot-yMidAxis{margin-left:10px;margin-right:10px;}.jqplot-axis-tick,.jqplot-xaxis-tick,.jqplot-yaxis-tick,.jqplot-x2axis-tick,.jqplot-y2axis-tick,.jqplot-y3axis-tick,.jqplot-y4axis-tick,.jqplot-y5axis-tick,.jqplot-y6axis-tick,.jqplot-y7axis-tick,.jqplot-y8axis-tick,.jqplot-y9axis-tick,.jqplot-yMidAxis-tick{position:absolute;white-space:pre;}.jqplot-xaxis-tick{top:0;left:15px;vertical-align:top;}.jqplot-x2axis-tick{bottom:0;left:15px;vertical-align:bottom;}.jqplot-yaxis-tick{right:0;top:15px;text-align:right;}.jqplot-yaxis-tick.jqplot-breakTick{right:-20px;margin-right:0;padding:1px 5px 1px 5px;z-index:2;font-size:1.5em;}.jqplot-y2axis-tick,.jqplot-y3axis-tick,.jqplot-y4axis-tick,.jqplot-y5axis-tick,.jqplot-y6axis-tick,.jqplot-y7axis-tick,.jqplot-y8axis-tick,.jqplot-y9axis-tick{left:0;top:15px;text-align:left;}.jqplot-yMidAxis-tick{text-align:center;white-space:nowrap;}.jqplot-xaxis-label{margin-top:10px;font-size:11pt;position:absolute;}.jqplot-x2axis-label{margin-bottom:10px;font-size:11pt;position:absolute;}.jqplot-yaxis-label{margin-right:10px;font-size:11pt;position:absolute;}.jqplot-yMidAxis-label{font-size:11pt;position:absolute;}.jqplot-y2axis-label,.jqplot-y3axis-label,.jqplot-y4axis-label,.jqplot-y5axis-label,.jqplot-y6axis-label,.jqplot-y7axis-label,.jqplot-y8axis-label,.jqplot-y9axis-label{font-size:11pt;margin-left:10px;position:absolute;}.jqplot-meterGauge-tick{font-size:.75em;color:#999;}.jqplot-meterGauge-label{font-size:1em;color:#999;}table.jqplot-table-legend{margin-top:12px;margin-bottom:12px;margin-left:12px;margin-right:12px;}table.jqplot-table-legend,table.jqplot-cursor-legend{background-color:rgba(255,255,255,0.6);border:1px solid #ccc;position:absolute;font-size:.75em;}td.jqplot-table-legend{vertical-align:middle;}td.jqplot-seriesToggle:hover,td.jqplot-seriesToggle:active{cursor:pointer;}.jqplot-table-legend .jqplot-series-hidden{text-decoration:line-through;}div.jqplot-table-legend-swatch-outline{border:1px solid #ccc;padding:1px;}div.jqplot-table-legend-swatch{width:0;height:0;border-top-width:5px;border-bottom-width:5px;border-left-width:6px;border-right-width:6px;border-top-style:solid;border-bottom-style:solid;border-left-style:solid;border-right-style:solid;}.jqplot-title{top:0;left:0;padding-bottom:.5em;font-size:1.2em;}table.jqplot-cursor-tooltip{border:1px solid #ccc;font-size:.75em;}.jqplot-cursor-tooltip{border:1px solid #ccc;font-size:.75em;white-space:nowrap;background:rgba(208,208,208,0.5);padding:1px;}.jqplot-highlighter-tooltip,.jqplot-canvasOverlay-tooltip{border:1px solid #ccc;font-size:.75em;white-space:nowrap;background:rgba(208,208,208,0.5);padding:1px;}.jqplot-point-label{font-size:.75em;z-index:2;}td.jqplot-cursor-legend-swatch{vertical-align:middle;text-align:center;}div.jqplot-cursor-legend-swatch{width:1.2em;height:.7em;}.jqplot-error{text-align:center;}.jqplot-error-message{position:relative;top:46%;display:inline-block;}div.jqplot-bubble-label{font-size:.8em;padding-left:2px;padding-right:2px;color:rgb(20%,20%,20%);}div.jqplot-bubble-label.jqplot-bubble-label-highlight{background:rgba(90%,90%,90%,0.7);}div.jqplot-noData-container{text-align:center;background-color:rgba(96%,96%,96%,0.3);}


.jqplot-highlighter-tooltip{
    *position: absolute;
}


#chart1 {
  cursor: pointer;
}


#chart1 .jqplot-point-label {
  border: 1.5px solid #aaaaaa;
  padding: 0;
  background-color: #eeccdd;
  width: 20px;
  height: 20px;
  border-radius: 10px;
  text-align:center;
}

/* force tinymce input height for a more useful editing / segment creation area */
form#segment-post-edit #description_parent #description_ifr {
    height:400px !important;
}

.admin_comments{
    margin-top: 0;
    padding: 4px;
}  

.admin_comments_holder{
    border: 1px solid red;
    width: 80%;
}
.admin_comments_holder.outstanding{
    background-color: yellow;
    border: 1px solid red;
}

.admin_comments_holder input{
    width: 66% !important;
}

.speak_freely_warning {
    width: 300px;
    float: right;
    margin: 15px;
    padding: 10px;
    border: 2px solid red;
    background-color: #EFACAC;
    color: black;
    font-weight: bold"    
}

#speak_freely_name_field {
    width: 200px;    
}

#commentary_input_wrapper a.cv_generate_link{
    position: absolute;
    right: 0;
    top: 240px;
    opacity: .6;
}

#commentary_input_wrapper a.cv_generate_link:hover{
    opacity: 1;
}


#commentary_input_wrapper a.cv_generate_link img{
    height: 80px;
    vertical-align: bottom;
}

.copyme{
    display: inline-block;
    text-align: right;
    font-size: 10px;
}

.rankings_badge{
    width:80px;
}

a.ratingslink{
    opacity: .6;
    margin:10px;
}
a.ratingslink.selected, a.ratingslink:hover{
    opacity: 1;
}

a.ratingslink .icondrop, a.ratingslink .icondrop{
opacity: 0;
}
a.ratingslink.selected .icondrop, a.ratingslink:hover .icondrop{
opacity: .4;
}


#leftranks_holder, #rightranks_holder{
    margin: 20px;
    margin-top:-20px;
    margin-bottom: -20px;
    border: 1px solid #666;
    padding: 10px 20px;
    display: inline-block;
    font-color: #666;
}

#leftranks_holder legend{
font-color: #666;
}

#rightranks_holder{
    float:right;
}

#rightranks_holder legend{
    text-align:right;
font-color: #666;
}

.returned_segments .sliderthumbs{
    float:right;
}

.returned_segments{
    max-height:300px;
}

.cv_read_module{
    max-height:500px;
}

@media (max-height: 500px) {
    .returned_segments{
        max-height:300px;
    }
    .cv_read_module{
        max-height:500px;
    }
}
@media (min-height: 501px) and (max-height: 700px) {
    .returned_segments{
        max-height:400px;
    }
    .cv_read_module{
        max-height:600px;
    }
}
@media (min-height: 701px) and (max-height: 900px) {
    .returned_segments{
        max-height:600px;
    }
    .cv_read_module{
        max-height:800px;
    }
}

@media (min-height: 901px) and (max-height: 1300px) {
    .returned_segments{
        max-height:800px;
    }
    .cv_read_module{
        max-height:1000px;
    }
}
@media (min-height: 1301px) {
    .returned_segments, .cv_read_module{
        max-height:1200px;
    }
}


/* @group Base */
.chzn-container {
  font-size: 13px;
  position: relative;
  display: inline-block;
  zoom: 1;
  *display: inline;
}
.chzn-container .chzn-drop {
  background: #fff;
  border: 1px solid #aaa;
  border-top: 0;
  position: absolute;
  top: 29px;
  left: 0;
  -webkit-box-shadow: 0 4px 5px rgba(0,0,0,.15);
  -moz-box-shadow   : 0 4px 5px rgba(0,0,0,.15);
  -o-box-shadow     : 0 4px 5px rgba(0,0,0,.15);
  box-shadow        : 0 4px 5px rgba(0,0,0,.15);
  z-index: 1010;
}
/* @end */

/* @group Single Chosen */
.chzn-container-single .chzn-single {
  background-color: #ffffff;
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#eeeeee', GradientType=0 );   
  background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(20%, #ffffff), color-stop(50%, #f6f6f6), color-stop(52%, #eeeeee), color-stop(100%, #f4f4f4));
  background-image: -webkit-linear-gradient(top, #ffffff 20%, #f6f6f6 50%, #eeeeee 52%, #f4f4f4 100%);
  background-image: -moz-linear-gradient(top, #ffffff 20%, #f6f6f6 50%, #eeeeee 52%, #f4f4f4 100%);
  background-image: -o-linear-gradient(top, #ffffff 20%, #f6f6f6 50%, #eeeeee 52%, #f4f4f4 100%);
  background-image: -ms-linear-gradient(top, #ffffff 20%, #f6f6f6 50%, #eeeeee 52%, #f4f4f4 100%);
  background-image: linear-gradient(top, #ffffff 20%, #f6f6f6 50%, #eeeeee 52%, #f4f4f4 100%); 
  -webkit-border-radius: 5px;
  -moz-border-radius   : 5px;
  border-radius        : 5px;
  -moz-background-clip   : padding;
  -webkit-background-clip: padding-box;
  background-clip        : padding-box;
  border: 1px solid #aaaaaa;
  -webkit-box-shadow: 0 0 3px #ffffff inset, 0 1px 1px rgba(0,0,0,0.1);
  -moz-box-shadow   : 0 0 3px #ffffff inset, 0 1px 1px rgba(0,0,0,0.1);
  box-shadow        : 0 0 3px #ffffff inset, 0 1px 1px rgba(0,0,0,0.1);
  display: block;
  overflow: hidden;
  white-space: nowrap;
  position: relative;
  height: 23px;
  line-height: 24px;
  padding: 0 0 0 8px;
  color: #444444;
  text-decoration: none;
}
.chzn-container-single .chzn-default {
  color: #999;
}
.chzn-container-single .chzn-single span {
  margin-right: 26px;
  display: block;
  overflow: hidden;
  white-space: nowrap;
  -o-text-overflow: ellipsis;
  -ms-text-overflow: ellipsis;
  text-overflow: ellipsis;
}
.chzn-container-single .chzn-single abbr {
  display: block;
  position: absolute;
  right: 26px;
  top: 6px;
  width: 12px;
  height: 13px;
  font-size: 1px;
  background: url('chosen-sprite.png') right top no-repeat;
}
.chzn-container-single .chzn-single abbr:hover {
  background-position: right -11px;
}
.chzn-container-single.chzn-disabled .chzn-single abbr:hover {
  background-position: right top;
}
.chzn-container-single .chzn-single div {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  height: 100%;
  width: 18px;
}
.chzn-container-single .chzn-single div b {
  background: url('chosen-sprite.png') no-repeat 0 0;
  display: block;
  width: 100%;
  height: 100%;
}
.chzn-container-single .chzn-search {
  padding: 3px 4px;
  position: relative;
  margin: 0;
  white-space: nowrap;
  z-index: 1010;
}
.chzn-container-single .chzn-search input {
  background: #fff url('chosen-sprite.png') no-repeat 100% -22px;
  background: url('chosen-sprite.png') no-repeat 100% -22px, -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(1%, #eeeeee), color-stop(15%, #ffffff));
  background: url('chosen-sprite.png') no-repeat 100% -22px, -webkit-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background: url('chosen-sprite.png') no-repeat 100% -22px, -moz-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background: url('chosen-sprite.png') no-repeat 100% -22px, -o-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background: url('chosen-sprite.png') no-repeat 100% -22px, -ms-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background: url('chosen-sprite.png') no-repeat 100% -22px, linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  margin: 1px 0;
  padding: 4px 20px 4px 5px;
  outline: 0;
  border: 1px solid #aaa;
  font-family: sans-serif;
  font-size: 1em;
}
.chzn-container-single .chzn-drop {
  -webkit-border-radius: 0 0 4px 4px;
  -moz-border-radius   : 0 0 4px 4px;
  border-radius        : 0 0 4px 4px;
  -moz-background-clip   : padding;
  -webkit-background-clip: padding-box;
  background-clip        : padding-box;
}
/* @end */

.chzn-container-single-nosearch .chzn-search input {
  position: absolute;
  left: -9000px;
}

/* @group Multi Chosen */
.chzn-container-multi .chzn-choices {
  background-color: #fff;
  background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(1%, #eeeeee), color-stop(15%, #ffffff));
  background-image: -webkit-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background-image: -moz-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background-image: -o-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background-image: -ms-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background-image: linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  border: 1px solid #aaa;
  margin: 0;
  padding: 0;
  cursor: text;
  overflow: hidden;
  height: auto !important;
  height: 1%;
  position: relative;
}
.chzn-container-multi .chzn-choices li {
  float: left;
  list-style: none;
}
.chzn-container-multi .chzn-choices .search-field {
  white-space: nowrap;
  margin: 0;
  padding: 0;
}
.chzn-container-multi .chzn-choices .search-field input {
  color: #666;
  background: transparent !important;
  border: 0 !important;
  font-family: sans-serif;
  font-size: 100%;
  height: 15px;
  padding: 5px;
  margin: 1px 0;
  outline: 0;
  -webkit-box-shadow: none;
  -moz-box-shadow   : none;
  -o-box-shadow     : none;
  box-shadow        : none;
}
.chzn-container-multi .chzn-choices .search-field .default {
  color: #999;
}
.chzn-container-multi .chzn-choices .search-choice {
  -webkit-border-radius: 3px;
  -moz-border-radius   : 3px;
  border-radius        : 3px;
  -moz-background-clip   : padding;
  -webkit-background-clip: padding-box;
  background-clip        : padding-box;
  background-color: #e4e4e4;
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f4f4f4', endColorstr='#eeeeee', GradientType=0 ); 
  background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), color-stop(100%, #eeeeee));
  background-image: -webkit-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eeeeee 100%);
  background-image: -moz-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eeeeee 100%);
  background-image: -o-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eeeeee 100%);
  background-image: -ms-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eeeeee 100%);
  background-image: linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eeeeee 100%); 
  -webkit-box-shadow: 0 0 2px #ffffff inset, 0 1px 0 rgba(0,0,0,0.05);
  -moz-box-shadow   : 0 0 2px #ffffff inset, 0 1px 0 rgba(0,0,0,0.05);
  box-shadow        : 0 0 2px #ffffff inset, 0 1px 0 rgba(0,0,0,0.05);
  color: #333;
  border: 1px solid #aaaaaa;
  line-height: 13px;
  padding: 3px 20px 3px 5px;
  margin: 3px 0 3px 5px;
  position: relative;
  cursor: default;
}
.chzn-container-multi .chzn-choices .search-choice-focus {
  background: #d4d4d4;
}
.chzn-container-multi .chzn-choices .search-choice .search-choice-close {
  display: block;
  position: absolute;
  right: 3px;
  top: 4px;
  width: 12px;
  height: 13px;
  font-size: 1px;
  background: url('chosen-sprite.png') right top no-repeat;
}
.chzn-container-multi .chzn-choices .search-choice .search-choice-close:hover {
  background-position: right -11px;
}
.chzn-container-multi .chzn-choices .search-choice-focus .search-choice-close {
  background-position: right -11px;
}
/* @end */

/* @group Results */
.chzn-container .chzn-results {
  margin: 0 4px 4px 0;
  max-height: 240px;
  padding: 0 0 0 4px;
  position: relative;
  overflow-x: hidden;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
}
.chzn-container-multi .chzn-results {
  margin: -1px 0 0;
  padding: 0;
}
.chzn-container .chzn-results li {
  display: none;
  line-height: 15px;
  padding: 5px 6px;
  margin: 0;
  list-style: none;
}
.chzn-container .chzn-results .active-result {
  cursor: pointer;
  display: list-item;
}
.chzn-container .chzn-results .highlighted {
  background-color: #3875d7;
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3875d7', endColorstr='#2a62bc', GradientType=0 );  
  background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(20%, #3875d7), color-stop(90%, #2a62bc));
  background-image: -webkit-linear-gradient(top, #3875d7 20%, #2a62bc 90%);
  background-image: -moz-linear-gradient(top, #3875d7 20%, #2a62bc 90%);
  background-image: -o-linear-gradient(top, #3875d7 20%, #2a62bc 90%);
  background-image: -ms-linear-gradient(top, #3875d7 20%, #2a62bc 90%);
  background-image: linear-gradient(top, #3875d7 20%, #2a62bc 90%);
  color: #fff;
}
.chzn-container .chzn-results li em {
  background: #feffde;
  font-style: normal;
}
.chzn-container .chzn-results .highlighted em {
  background: transparent;
}
.chzn-container .chzn-results .no-results {
  background: #f4f4f4;
  display: list-item;
}
.chzn-container .chzn-results .group-result {
  cursor: default;
  color: #999;
  font-weight: bold;
}
.chzn-container .chzn-results .group-option {
  padding-left: 15px;
}
.chzn-container-multi .chzn-drop .result-selected {
  display: none;
}
.chzn-container .chzn-results-scroll {
  background: white;
  margin: 0 4px;
  position: absolute;
  text-align: center;
  width: 321px; /* This should by dynamic with js */
  z-index: 1;
}
.chzn-container .chzn-results-scroll span {
  display: inline-block;
  height: 17px;
  text-indent: -5000px;
  width: 9px;
}
.chzn-container .chzn-results-scroll-down {
  bottom: 0;
}
.chzn-container .chzn-results-scroll-down span {
  background: url('chosen-sprite.png') no-repeat -4px -3px;
}
.chzn-container .chzn-results-scroll-up span {
  background: url('chosen-sprite.png') no-repeat -22px -3px;
}
/* @end */

/* @group Active  */
.chzn-container-active .chzn-single {
  -webkit-box-shadow: 0 0 5px rgba(0,0,0,.3);
  -moz-box-shadow   : 0 0 5px rgba(0,0,0,.3);
  -o-box-shadow     : 0 0 5px rgba(0,0,0,.3);
  box-shadow        : 0 0 5px rgba(0,0,0,.3);
  border: 1px solid #5897fb;
}
.chzn-container-active .chzn-single-with-drop {
  border: 1px solid #aaa;
  -webkit-box-shadow: 0 1px 0 #fff inset;
  -moz-box-shadow   : 0 1px 0 #fff inset;
  -o-box-shadow     : 0 1px 0 #fff inset;
  box-shadow        : 0 1px 0 #fff inset;
  background-color: #eee;
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#ffffff', GradientType=0 );
  background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(20%, #eeeeee), color-stop(80%, #ffffff));
  background-image: -webkit-linear-gradient(top, #eeeeee 20%, #ffffff 80%);
  background-image: -moz-linear-gradient(top, #eeeeee 20%, #ffffff 80%);
  background-image: -o-linear-gradient(top, #eeeeee 20%, #ffffff 80%);
  background-image: -ms-linear-gradient(top, #eeeeee 20%, #ffffff 80%);
  background-image: linear-gradient(top, #eeeeee 20%, #ffffff 80%);
  -webkit-border-bottom-left-radius : 0;
  -webkit-border-bottom-right-radius: 0;
  -moz-border-radius-bottomleft : 0;
  -moz-border-radius-bottomright: 0;
  border-bottom-left-radius : 0;
  border-bottom-right-radius: 0;
}
.chzn-container-active .chzn-single-with-drop div {
  background: transparent;
  border-left: none;
}
.chzn-container-active .chzn-single-with-drop div b {
  background-position: -18px 1px;
}
.chzn-container-active .chzn-choices {
  -webkit-box-shadow: 0 0 5px rgba(0,0,0,.3);
  -moz-box-shadow   : 0 0 5px rgba(0,0,0,.3);
  -o-box-shadow     : 0 0 5px rgba(0,0,0,.3);
  box-shadow        : 0 0 5px rgba(0,0,0,.3);
  border: 1px solid #5897fb;
}
.chzn-container-active .chzn-choices .search-field input {
  color: #111 !important;
}
/* @end */

/* @group Disabled Support */
.chzn-disabled {
  cursor: default;
  opacity:0.5 !important;
}
.chzn-disabled .chzn-single {
  cursor: default;
}
.chzn-disabled .chzn-choices .search-choice .search-choice-close {
  cursor: default;
}

/* @group Right to Left */
.chzn-rtl { text-align: right; }
.chzn-rtl .chzn-single { padding: 0 8px 0 0; overflow: visible; }
.chzn-rtl .chzn-single span { margin-left: 26px; margin-right: 0; direction: rtl; }

.chzn-rtl .chzn-single div { left: 3px; right: auto; }
.chzn-rtl .chzn-single abbr {
  left: 26px;
  right: auto;
}
.chzn-rtl .chzn-choices .search-field input { direction: rtl; }
.chzn-rtl .chzn-choices li { float: right; }
.chzn-rtl .chzn-choices .search-choice { padding: 3px 5px 3px 19px; margin: 3px 5px 3px 0; }
.chzn-rtl .chzn-choices .search-choice .search-choice-close { left: 4px; right: auto; background-position: right top;}
.chzn-rtl.chzn-container-single .chzn-results { margin: 0 0 4px 4px; padding: 0 4px 0 0; }
.chzn-rtl .chzn-results .group-option { padding-left: 0; padding-right: 15px; }
.chzn-rtl.chzn-container-active .chzn-single-with-drop div { border-right: none; }
.chzn-rtl .chzn-search input {
  background: #fff url('chosen-sprite.png') no-repeat -38px -22px;
  background: url('chosen-sprite.png') no-repeat -38px -22px, -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(1%, #eeeeee), color-stop(15%, #ffffff));
  background: url('chosen-sprite.png') no-repeat -38px -22px, -webkit-linear-gradient(top, #eeeeee 1%, #ffffff 15%);  
  background: url('chosen-sprite.png') no-repeat -38px -22px, -moz-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background: url('chosen-sprite.png') no-repeat -38px -22px, -o-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background: url('chosen-sprite.png') no-repeat -38px -22px, -ms-linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  background: url('chosen-sprite.png') no-repeat -38px -22px, linear-gradient(top, #eeeeee 1%, #ffffff 15%);
  padding: 4px 5px 4px 20px;
  direction: rtl;
}
/* @end */

<? 
