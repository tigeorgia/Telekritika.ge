<!--//*************************************************//
<!--//******BEGIN BECOME CRITIC MODULE 1***************//
<!--//*************************************************//-->
<style>
    #becomeacritic_01{
        height: 330px;
        margin-top:5px;
        color: white;
        text-align:center;
        display:block;
        background-image: linear-gradient(bottom, rgb(77,77,77) 0%, rgb(51,51,51) 100%);
        background-image: -o-linear-gradient(bottom, rgb(77,77,77) 0%, rgb(51,51,51) 100%);
        background-image: -moz-linear-gradient(bottom, rgb(77,77,77) 0%, rgb(51,51,51) 100%);
        background-image: -webkit-linear-gradient(bottom, rgb(77,77,77) 0%, rgb(51,51,51) 100%);
        background-image: -ms-linear-gradient(bottom, rgb(77,77,77) 0%, rgb(51,51,51) 100%);

        background-image: -webkit-gradient(
            linear,
            left bottom,
            left top,
            color-stop(0, rgb(77,77,77)),
            color-stop(1, rgb(51,51,51))
        );
        *width:100%;
    }
    #becomeacritic_01 > img{
        margin-top:14px;
    }
    #becomeacritic_01 .whybecomeacritic{
        margin-top: 14px;
        display: inline-block;
        font-size: 14px;
    }
    #becomeacritic_01 .criticbutton{
        margin-top: 14px;
        display: inline-block;
        font-size: 16px;
        padding: 4px 6px;
        border: white solid 1px;
        font-weight: bold;
    }
    #becomeacritic_01:hover .criticbutton{
        background-color: #d1242a;
        border-color: #d1242a;
        color: white;
        text-shadow: 0px 0px 5px #000;
        border-radius:2px;
        -moz-border-radius:2px;
        -webkit-border-radius:2px;
        *color: #4c4c4c;
        *color: #d1242a;
    }
</style>

<? 
$id = "becomeacritic_01";
$href = "{$CONFIG->wwwroot}channels/lastnight";
$body = 
    "<img src=\"" . elgg_normalize_url("_graphics/becomeacritic/becomeacritic_1.png") . "\">
    <span class=\"whybecomeacritic elgg-col-2of3\">" . elgg_echo("becomeacritic:why") . "</span>
    <span class=\"criticbutton\">" . elgg_echo("becomeacritic:button") . "</span>";

echo elgg_view("output/url", array(
   'id' => $id,
   'href' => $href,
   'text' => $body,
));
    
?>

<!--//*************************************************//
<!--//********END BECOME CRITIC MODULE 1***************//
<!--//*************************************************//-->
<?