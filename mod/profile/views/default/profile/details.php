<?php
/**
 * Elgg user display (details)
 * @uses $vars['entity'] The user entity
 */

$user = elgg_get_page_owner_entity();


if($user->badges_badge){
    $basebadge = get_entity($user->badges_badge);
    if($basebadge instanceOf BadgesBadge){
        $badges[] = $basebadge;
        if($morebadges = $user->getEntitiesFromRelationship('hasbadge')){
            foreach($morebadges as $badge){
                if($badge instanceOf BadgesBadge){
                    array_push($badges, $badge);                
                }
            }
        }
        foreach($badges as $badge){
            $badgeholder = add_dropshadow("{$CONFIG->wwwroot}/badge/{$badge->guid}", "badge");
            $badgesoutput .= "<div class=\"profilebadge\">$badgeholder</div>";
        }
    }
}
 
$ranks['popularity']['total'] = ($s = get_user_rating($user, "popularityTotal", array("rank" => true))) ? $s : "?";
$ranks['popularity']['thismonth'] = ($s = get_user_rating($user, "popularityMonthTotal", array("rank" => true))) ? $s : "?";
$ranks['controversy']['total'] = ($s = get_user_rating($user, "controversyTotal", array("rank" => true))) ? $s : "?";
$ranks['controversy']['thismonth'] = ($s = get_user_rating($user, "controversyMonthTotal", array("rank" => true))) ? $s : "?";
$ranks['conversation']['total'] = ($s = get_user_rating($user, "conversationTotal", array("rank" => true))) ? $s : "?";
$ranks['conversation']['thismonth'] = ($s = get_user_rating($user, "conversationMonthTotal", array("rank" => true))) ? $s : "?";

$rankoutput = "<div class=\"ranks\">"; 
foreach($ranks as $type => $v){
    $rankoutput .= "<div>" . elgg_echo($type) . "</div>";
    foreach($v as $scope => $rank){
        $rankoutput .= " <span>" . elgg_echo($scope) . ": <span class=\"rank\">".elgg_echo("sequence:$rank")."</span></span>";
    }
}
$rankoutput .= "</div>";

echo <<<OUTPUT
<div class="badgeswrapper">       
$badgesoutput
</div>
$rankoutput

OUTPUT;
