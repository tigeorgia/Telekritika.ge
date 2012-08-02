<?php
/**
 * Elgg custom index layout
 * 
 * You can edit the layout of this page with your own layout and style. 
 * Whatever you put in this view will appear on the front page of your site.
 * 
 */
?>

<div class="custom-index elgg-main elgg-grid clearfix">

<?  

if($vars['content']['top']){ ?>
    <div class="elgg-col toppest pvm nopvm">
        <?=$vars['content']['top']?>    
    </div>    
<? }

if(is_array($vars['content']['side'])) $columns = true; 

echo $columns ? "<div class=\"elgg-col elgg-col-2of3\">" : "";
    foreach($vars['content']['main'] as $module){
        if(is_array($module)){
            if(is_array($module['body'])){
                $tabs = true;                                                                               
                foreach($module['body'] as $key => $tab){                            
                    $selected = $key == 0 ? "selected" : "";
                    $headerbody .= "<a href=\"#\" data-tab=\"{$module['class']}-tabcontent-$key\" class=\"tabheader {$module['class']}-tabheader tabheader-{$tab['title']} tabheader-{$tab['title']} $selected\">{$tab['title']}</a>";
                    $content .= "<div class=\"tabcontent {$module['class']}-tabcontent {$module['class']}-tabcontent-$key tabcontent-{$tab['title']} $selected\">";
                    $content .= $tab['content'];
                    $content .= "</div>";                                                             
                }
                $header = "<div class=\"tabheaderholder\">$headerbody</div>";                
                echo "<div class=\"elgg-inner pr1 small-padding {$module['class']}\"> $header  $content</div>";
            }else{
                echo "<div class=\"elgg-inner pvm prl {$module['class']}\">";
                echo $module['body'];
                echo "</div>";                                                             
            }
        }else{
            echo "<div class=\"elgg-inner pvm prl\">";
            echo $module;
            echo "</div>";                                     
        }                                                            
    }

if($columns){
    echo "</div><div class=\"elgg-col elgg-col-1of3\">";
    foreach($vars['content']['side'] as $module){
        if(is_array($module)){
            if(is_array($module['body'])){
                $tabs = true;
                $content = $headerbody = "";                                                                               
                foreach($module['body'] as $key => $tab){                            
                    $selected = $key == 0 ? "selected" : "";
                    $headerbody .= "<a href=\"#\" class=\"tabheader $selected\">{$tab['title']}</a>";
                    $content .= "<div class=\"tabcontent tabcontent-$key $selected\">";
                    $content .= $tab['content'];
                    $content .= "</div>";                                                             
                }
                $header = "<div class=\"tabheaderholder\">$headerbody</div>";                
                echo "<div class=\"elgg-inner tk-module small-padding {$module['class']}\"> $header  $content</div>";
                
            }else{
                echo "<div class=\"elgg-inner pvm {$module['class']}\">";
                echo $module['body'];
                echo "</div>";                                                             
            }
        }else{
            echo "<div class=\"elgg-inner pvm \">";
            echo $module;
            echo "</div>";                                     
        }                              
    }    
}

//echo "</div>";  

echo $tabs ? "<script>

    jQuery(document).ready(function(){
        jQuery('.tabheader').click(function(e){
            e.preventDefault();
            var self = jQuery(this);
            switchtab(self);
            self.closest('.automatedtabs').removeClass('automatedtabs');                        
        });
        startTimer();
    });
    stoptimer = false;                        
    function switchtab(self){
        var parent = self.closest('.elgg-inner');
        var alltabs = jQuery('.tabheader', parent).removeClass('selected');
        jQuery('.tabcontent', parent).removeClass('selected');
        jQuery('.tabcontent-'+alltabs.index(self), parent).add(self).addClass('selected');
    }
    function startTimer(){
        if(typeof timer != 'undefined' && timer == 'stop')return false;
        if(!jQuery('.automatedtabs .tabheader.selected').each(function(){
            if(jQuery(this).is('.tabheader:last-child')){
                switchtab(jQuery(this).parent().find('.tabheader:first'));            
            }else{
                switchtab(jQuery(this).next('.tabheader'));    
            }
        }).length){
            timer = 'stop';                    
        }
        timer = setTimeout(startTimer, 4000);
    }
    
    </script>" : "";                    

?>

</div>

<?