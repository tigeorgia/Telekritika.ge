<?php
/**
 * Blog owner selector view
 *
 * @package ElggBlogExtended
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Diego Andrés Ramírez Aragón <dramirezaragon@gmail.com>
 * @copyright Corporación Somos más - 2009; Diego Andrés Ramirez Aragón 2010
 * @link http://github.com/lowfill/blogextended
 */

if(get_plugin_setting("groupcontents","blog")=="yes"){

    $field_label = elgg_echo("content:owner");
    if(isset($vars["label"])){
        $field_label = $vars["label"];
    }

    $value = "";
    if(isset($vars["entity"])){
        $value = $vars["entity"]->content_owner;
    }

    $options_values = array(get_loggedin_userid()=>elgg_echo("my:profile"));

    $options['relationship'] = 'member';
    $options['relationship_guid'] = page_owner();
    $options['inverse_relationship'] = false;
    $options['types']=array('group');
    $options['subtypes']=array(ELGG_ENTITIES_NO_VALUE);

    $objects = elgg_get_entities_from_relationship($options);
    if(!empty($objects)){
        foreach($objects as $object){
            $options_values["{$object->guid}"]=$object->name;
        }
?>
<p><label><?php echo $field_label; ?></label><br />
    <?php echo elgg_view("input/pulldown",array("internalname"=>"container_guid",
    											"options_values"=>$options_values,
    											"value"=>$value)); ?>
</p>
<?php
    }
}
?>