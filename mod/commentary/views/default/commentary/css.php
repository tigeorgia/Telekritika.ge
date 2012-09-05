<?php
/**
 * Commentary CSS
 *
 * @package Commentary
*/
?>

/* Commentary Plugin */

/* force tinymce input height for a more useful editing / commentary creation area */
form#commentary-post-edit #description_parent #description_ifr {
	height:400px !important;
}

.elgg-layout-one-sidebar{
    /*background: none;*/
}

.elgg-channelbar-item{
    margin: 5px;
    display: inline-block;
    background-color: transparent;
}

.elgg-channelbar-item img{
}


#commentary-post-edit input{
    width:80px;
}

#commentary-post-edit, #commentary-post-edit div{
    clear: both;
}

#main_channelbar{
    display:block;
    overflow: auto;
    text-align: center;
    position: relative;
}

/*#cv_segmentselect_module_holder .channelviewer_module{
    width: 32%;
    border: 1px dashed black;
    position:relative;
    display: inline-block;
    text-align: center;
    vertical-align: top;
    margin:2px;
    padding:2px;
}   */

#cv_segmentselect_module_holder a:hover.close_module, #cv_segmentselect_module_holder a:hover.solo_module{
    text-shadow: none;
    -moz-text-shadow: none;
    -webkit-text-shadow: none;    

}
#cv_segmentselect_module_holder a.close_module, #cv_segmentselect_module_holder a.solo_module{
    color:#999;
    margin-right:4px;
    margin-top:4px;
    position:absolute;
    top:0;
    right:0;
    text-decoration: none;
    text-shadow: 0px 1px 3px black;
    -moz-text-shadow: 0px 1px 3px black;
    -webkit-text-shadow: 0px 1px 3px black;
}

#cv_segmentselect_module_holder a.solo_module{
    position:absolute;
    top:0;
    right:12px;
}
.segment_accordion{
    position:relative;
    margin: auto;
}

#cv_segmentselect_module_holder{
/*    text-align: center;
    position:absolute;
    z-index:99999;*/
    width: 940px;
}

#cv_segmentselect_module_holder .cv_keyword{
    width: 60%;
}

#cv_segmentselect_module_holder .cv_datepicker{
    width: 35%;
}

#cv_content_wrapper{
    position:relative;
}
.ui-accordion div.cv_content:hover{
    cursor: auto;
    background: transparent;
}

.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
    border-bottom: 0;
}

h3.cv_header{
    font-size: 12px;
    height: 16px;
}

#cv_segmentselect_module_holder h3.cv_header a,
#cv_segmentselect_module_holder h3.ui-accordion-header a{
padding: 0 0.5em 0 0.7em;
}

div.cv_content, div.cv_content p{
    background: transparent;
    cursor: pointer;
    padding: 2px;
    font-size: 10px;
    text-align: left;
    line-height: 12px;    
}

.ui-accordion .ui-accordion-content, .accordion .ui-accordion-content  {
    border-top: 0 none;
    margin-bottom: 2px;
    margin-top: -2px;
    overflow: auto;
    padding: 1em 2.2em;
    position: relative;
    top: 1px;
}


div.cv_content:hover{
    background: lightgrey;
}
.returned_segments{
    *max-height: 300px;
    overflow: visible;
}

.returned_segments.jspScrollable .smallholder{
	display:none;
}

.accordion {
    font-family: Verdana,Arial,sans-serif;
    font-size: 1.1em;
}

#commentary_input_wrapper{
    text-align:center;
}
#commentary_description{
    height:100px;
    width:60%;
    display:inline-block;
}