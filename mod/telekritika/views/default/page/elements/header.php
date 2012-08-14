<?
/**
 * Elgg page header
 * In the default theme, the header lives between the topbar and main content area.
 */

// link back to main site.

if($CONFIG->slideIndex == true && false){     
?>
<style>
.elgg-page-body, .elgg-page-footer{
    display:none;
}
</style>    
<script>
jQuery(window).load(function(){
   jQuery(".elgg-page-body").show("slide", { direction: "up" }, <?=$CONFIG->slideDownTime?>, function(){jQuery(".elgg-page-footer").show();});
});
</script>
<? } ?>
<div style="float:right;" class="fb-like" data-href="https://telekritika.ge" data-send="false" data-layout="box_count" data-width="150" data-show-faces="true" data-font="arial"></div>
  <?
echo elgg_view('core/account/login_dropdown');
echo !elgg_is_logged_in() ? elgg_view('elgg_social_login/login') : "";
        
//echo elgg_view('language_selector/default');

echo "<div id=\"google_translate_element\"></div>";

echo elgg_view('page/elements/header_logo', $vars);

?>

<div style="float:right; padding: 10px; background: #4E4E4E; color: #ffffff; font-weight: bold; position:relative; margin-right: 25px;"><a style="color:#ffffff;" target="_blank" href="mailto:telekritika@transparency.ge">რას ფიქრობთ telekritika.ge-ზე?</a></div>


<?

if(elgg_is_admin_logged_in() && false){ ?>

<style>.ui-tooltip,.qtip{position:absolute;left:-28000px;top:-28000px;display:none;max-width:280px;min-width:50px;font-size:10.5px;line-height:12px;z-index:15000;}.ui-tooltip-fluid{display:block;visibility:hidden;position:static!important;float:left!important;}.ui-tooltip-content{position:relative;padding:5px 9px;overflow:hidden;border-width:1px;border-style:solid;text-align:left;word-wrap:break-word;overflow:hidden;}.ui-tooltip-titlebar{position:relative;min-height:14px;padding:5px 35px 5px 10px;overflow:hidden;border-width:1px 1px 0;border-style:solid;font-weight:bold;}.ui-tooltip-titlebar+.ui-tooltip-content{border-top-width:0!important;}/*!Default close button class */ .ui-tooltip-titlebar .ui-state-default{position:absolute;right:4px;top:50%;margin-top:-9px;cursor:pointer;outline:medium none;border-width:1px;border-style:solid;}* html .ui-tooltip-titlebar .ui-state-default{top:16px;}.ui-tooltip-titlebar .ui-icon,.ui-tooltip-icon .ui-icon{display:block;text-indent:-1000em;}.ui-tooltip-icon,.ui-tooltip-icon .ui-icon{-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;}.ui-tooltip-icon .ui-icon{width:18px;height:14px;text-align:center;text-indent:0;font:normal bold 10px/13px Tahoma,sans-serif;color:inherit;background:transparent none no-repeat -100em -100em;}/*!Default tooltip style */ .ui-tooltip-default .ui-tooltip-titlebar,.ui-tooltip-default .ui-tooltip-content{border-color:#F1D031;background-color:#FFFFA3;color:#555;}.ui-tooltip-default .ui-tooltip-titlebar{background-color:#FFEF93;}.ui-tooltip-default .ui-tooltip-icon{border-color:#CCC;background:#F1F1F1;color:#777;}.ui-tooltip-default .ui-tooltip-titlebar .ui-state-hover{border-color:#AAA;color:#111;}</style>

<? } ?>
  
<style>
#menubar{
    background-color: #1a1a1a;
    padding: 10px;
    position: relative;
    height: 20px;
    border-top: 3px solid #f5f5f5;
    border-bottom: 3px solid #f5f5f5;
    font-size:14px;
    color:white;
}

#menubar:before, #menubar:after{
     content: " ";
    display: block;
    height: 63px;
    left: -15px;
    position: absolute;
    top: -3px;
    width: 15px;
    background: url('<?=elgg_normalize_url("_graphics/tk-leftcorner.jpg")?>') no-repeat;
}

#menubar:after{
    left: auto;
    right: -15px;
    background: url('<?=elgg_normalize_url("_graphics/tk-rightcorner.jpg")?>') no-repeat;
}


#menubar .elgg-menu-site li{
    
}
#menubar .elgg-menu-site li:after{
    display: inline-block;
    position: absolute;
    content: "/";
    font-weight:bold;
    font-size: 26px;
    color: #666;
    top:2px;
    right:-10px;
    margin-right: 6px;
}

#menubar .elgg-menu-site li:last-child:after{
    display: none;
}


#menubar a, .elgg-page-footer .elgg-menu-footer > li > a{
    color:white;
}
#menubar a:hover, .elgg-page-footer .elgg-menu-footer > li > a:hover{
    color:#999;
}

.elgg-page-footer .elgg-menu-footer > li{
    float: left;
    margin-right: 1px;
} 


.elgg-page-footer .elgg-menu-footer > li:after{
    display: inline-block;
    position: absolute;
    content: "/";
    font-weight: bold;
    font-size: 26px;
    color: #666;
    top: 2px;
    right: -10px;
    margin-right: 6px;
}

.elgg-page-footer .elgg-menu-footer > li:last-child:after{
    display:none;
}

.elgg-page-footer .elgg-menu-hz{
    padding-top:0;
}

.elgg-page-footer .elgg-menu-footer > li > a{
    
font-weight: bold;
padding: 3px 13px 0px 13px;
height: 20px;
    
}

.elgg-menu-site{
    width: 660px;
    float: left;
}


.elgg-page-header .elgg-search input[type="text"],
.elgg-page-header .elgg-search input[type="text"]:active,
.elgg-page-header .elgg-search input[type="text"]:focus{
    box-shadow: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    display:inline-block;
    border: 1px solid #999999;
    -moz-border-radius: 0;
    border-radius: 0;
    -webkit-border-radius: 0;
    color: #999999;
    height: 25px;
    margin-top: -3px;
    padding-left: 4px;
    vertical-align: top;
    width: 200px;
    font-size:14px;
    margin-right: 20px;
    background: url('<?=elgg_normalize_url("_graphics/tk-searchglass.png")?>') 100% no-repeat transparent; 
    float:right;
}

.elgg-page-header .elgg-search input[type="text"]:active,
.elgg-page-header .elgg-search input[type="text"]:focus{
    color: black;
    background: #F2F2F2; 
    *border-color: white;
    *background: url('<?=elgg_normalize_url("_graphics/tk-searchglass-bright.png")?>') 100% no-repeat ; 
}

.search-submit-button{
    *width:25px;
    *height:25px;
    display:none;
}

#google_translate_element{
    float:right;
    clear: right;
    margin-top: 8px;
    margin-right: -13px;    
}

</style>  
  
<!-- <script src="https://www.gmodules.com/ig/ifr?url=https://www.google.com/ig/modules/translatemypage.xml&amp;up_source_language=en&amp;synd=open&amp;w=160&amp;h=60&amp;title=Google+Translate+My+Page&amp;lang=en&amp;country=ALL&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>  
     -->
     
<script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'ka',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<div id="menubar">
<?
// insert site-wide navigation
echo elgg_view_menu('site', array('sort_by' => 'priority'));
echo elgg_view('search/search_box');
?>
</div>
<?
//echo '<script src="http://www.gmodules.com/ig/ifr?url=http://www.google.com/ig/modules/translatemypage.xml&amp;up_source_language=en&amp;synd=open&amp;w=160&amp;h=60&amp;title=Google+Translate+My+Page&amp;lang=en&amp;country=ALL&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>';
