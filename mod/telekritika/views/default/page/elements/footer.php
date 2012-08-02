<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 */

echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

/*$powered_url = elgg_get_site_url() . "_graphics/powered_by_elgg_badge_drk_bckgnd.gif";

echo '<div class="mts clearfloat right">';
echo elgg_view('output/url', array(
	'href' => 'https://elgg.org',
	'text' => "<img src=\"$powered_url\" alt=\"Powered by Elgg\" width=\"106\" height=\"15\" />",
	'class' => '',
));
echo '</div>';    */

?>
<style>
.donorfooter{
    display: table;
    clear: both;
    color: #333;
    padding: 30px;
    font-size: 12px;
}    

.donorimg img {
    max-height: 80px;
}

.donorfooter span {
    display: table-cell;
    width: 35%;
    padding: 0;
    margin: 0;
    vertical-align: top;
    text-align: center;
}

</style>



<div class="donorfooter">
    <span class="donorimg"><a href="https://georgia.usaid.gov/"><img src="<?=elgg_normalize_url("_graphics/donors/USAIDLogo.gif"); ?>"></a></span>               
    <span class="donornotice"><a href="https://irex.ge/programs/media/gmedia">პროგრამა G-MEDIA</a> <a href="https://georgia.usaid.gov/">USAID–ის</a> მეშვეობით გადმოცემული ამერიკელი ხალხის დახმარებით ხორციელდება. ანგარიშის შინაარსი და მასში გამოთქმული მოსაზრებები „საერთაშორისო გამჭვირვალობა – საქართველოს“ ეკუთვნის და ა.შ.შ.–ის მთავრობის, USAID–ის ან IREX–ის პოზიციას არ გამოხატავს.</a></span>
    <span class="donorimg"><a href="https://irex.ge/programs/media/gmedia"><img src="<?=elgg_normalize_url("_graphics/donors/IREXLogo.jpg"); ?>"></a></span>               
</div>


<?