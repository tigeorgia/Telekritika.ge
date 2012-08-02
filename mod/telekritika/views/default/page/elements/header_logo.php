<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();
?>

<style>
    .elgg-page-header > .elgg-inner, .elgg-page-body > .elgg-inner{
        width:940px !important;
    }
    #mainlogo{
        position: relative;
        margin-top:20px;
        margin-bottom:20px;
        display:inline-block;      
          height: 59px;
          width: 287px;
    }
    #mainlogo > a{
      display: block;
      width: 100%;
      height: 59px;
      width: 287px;
    }
</style>


<h1 id="mainlogo"><a class="elgg-heading-site" href="<?=$site_url?>"><img src="<?=elgg_normalize_url('_graphics/tk-logo.jpg');?>"></a></h1>
