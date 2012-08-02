<!--//*************************************************//
<!--//******BEGIN BECOME CRITIC MODULE 1***************//
<!--//*************************************************//-->
<style>
    #becomeacritic_02{
        height: 230px;
        color: #666;
        text-align:center;
        display:block;
/*        background-image: linear-gradient(bottom, rgb(77,77,77) 0%, rgb(51,51,51) 100%);
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
*/    }
    #becomeacritic_02 > img{
        margin-top:14px;
        width: 165px;
    }
    #becomeacritic_02 .message{
        margin-top: 6px;
        display: inline-block;
        font-size: 12px;
        line-height:18px;
        padding:6px 20px;
    }
    #becomeacritic_02:hover .message{
        text-shadow: 0px 0px 6px rgba(0, 0, 0, .4);
        -moz-text-shadow: 0px 0px 6px rgba(0, 0, 0, .4);
        -webkit-text-shadow: 0px 0px 6px rgba(0, 0, 0, .4);
    }

        
</style>

<? 
$id = "becomeacritic_02";
$href = $vars['url'];
$body = "<img src=\"" . elgg_normalize_url("_graphics/becomeacritic/becomeacritic_2.png") . "\"><br />";
$body .= ($vars['message']) ? "<span class=\"elgg-col-2of3 message\">" . $vars['message'] . "</span>" : "";
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