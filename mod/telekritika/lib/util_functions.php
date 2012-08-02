<?

function add_dropshadow($url, $class){
    $item = "<img class=\"{$class} imgtodrop\" src=\"{$url}\" />";
    $shadow = "<img class=\"icondrop\" src=\"" . elgg_normalize_url("_graphics/icondrop.png") . "\" />";
    return "<span class=\"{$class}holder addshadow\">$item$shadow</span>";        
};

function time_created_sorter($obj_a, $obj_b){
    if($obj_a->time_created == $obj_b->time_created) return 0;
    return ($obj_a->time_created > $obj_b->time_created) ? -1 : 1;
}

function segment_date_sorter($obj_a, $obj_b){
    if((string)$obj_a->segment_date == (string)$obj_b->segment_date) return 0;
    return ((string)$obj_a->segment_date > (string)$obj_b->segment_date) ? -1 : 1;
}

function curl_data($url){
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,$url);
  if(strpos($url, "https:") !== false)curl_setopt($ch,CURLOPT_PORT,443);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

function random_string($length){
  $random= "";
  srand((double)microtime()*1000000);
  $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $char_list .= "abcdefghijklmnopqrstuvwxyz";
  $char_list .= "1234567890";
  // Add the special characters to $char_list if needed

  for($i = 0; $i < $length; $i++)  
  {    
     $random .= substr($char_list,(rand()%(strlen($char_list))), 1);  
  }  
  return $random;
} 


function array_iunique($array) {
    return array_intersect_key($array,array_unique(
                 array_map(strtolower,$array)));
}


/**
 *  UrlLinker - facilitates turning plain text URLs into HTML links.
 *
 *  Author: Søren Løvborg
 *
 *  To the extent possible under law, Søren Løvborg has waived all copyright
 *  and related or neighboring rights to UrlLinker.
 *  http://creativecommons.org/publicdomain/zero/1.0/
 */

function htmlEscapeAndLinkUrls($text)
{
    $rexProtocol  = '(https?://)?';
    $rexDomain    = '(?:[-a-zA-Z0-9]{1,63}\.)+[a-zA-Z][-a-zA-Z0-9]{1,62}';
    $rexIp        = '(?:[1-9][0-9]{0,2}\.|0\.){3}(?:[1-9][0-9]{0,2}|0)';
    $rexPort      = '(:[0-9]{1,5})?';
    $rexPath      = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
    $rexQuery     = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
    $rexFragment  = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
    $rexUsername  = '[^]\\\\\x00-\x20\"(),:-<>[\x7f-\xff]{1,64}';
    $rexPassword  = $rexUsername; // allow the same characters as in the username
    $rexUrl       = "$rexProtocol(?:($rexUsername)(:$rexPassword)?@)?($rexDomain|$rexIp)($rexPort$rexPath$rexQuery$rexFragment)";
    $rexUrlLinker = "{\\b$rexUrl(?=[?.!,;:\"]?(\s|$))}";
    $validTlds = array_fill_keys(explode(" ", ".ac .ad .ae .aero .af .ag .ai .al .am .an .ao .aq .ar .arpa .as .asia .at .au .aw .ax .az .ba .bb .bd .be .bf .bg .bh .bi .biz .bj .bm .bn .bo .br .bs .bt .bv .bw .by .bz .ca .cat .cc .cd .cf .cg .ch .ci .ck .cl .cm .cn .co .com .coop .cr .cu .cv .cx .cy .cz .de .dj .dk .dm .do .dz .ec .edu .ee .eg .er .es .et .eu .fi .fj .fk .fm .fo .fr .ga .gb .gd .ge .gf .gg .gh .gi .gl .gm .gn .gov .gp .gq .gr .gs .gt .gu .gw .gy .hk .hm .hn .hr .ht .hu .id .ie .il .im .in .info .int .io .iq .ir .is .it .je .jm .jo .jobs .jp .ke .kg .kh .ki .km .kn .kp .kr .kw .ky .kz .la .lb .lc .li .lk .lr .ls .lt .lu .lv .ly .ma .mc .md .me .mg .mh .mil .mk .ml .mm .mn .mo .mobi .mp .mq .mr .ms .mt .mu .museum .mv .mw .mx .my .mz .na .name .nc .ne .net .nf .ng .ni .nl .no .np .nr .nu .nz .om .org .pa .pe .pf .pg .ph .pk .pl .pm .pn .pr .pro .ps .pt .pw .py .qa .re .ro .rs .ru .rw .sa .sb .sc .sd .se .sg .sh .si .sj .sk .sl .sm .sn .so .sr .st .su .sv .sy .sz .tc .td .tel .tf .tg .th .tj .tk .tl .tm .tn .to .tp .tr .travel .tt .tv .tw .tz .ua .ug .uk .us .uy .uz .va .vc .ve .vg .vi .vn .vu .wf .ws .xn--0zwm56d .xn--11b5bs3a9aj6g .xn--3e0b707e .xn--45brj9c .xn--80akhbyknj4f .xn--90a3ac .xn--9t4b11yi5a .xn--clchc0ea0b2g2a9gcd .xn--deba0ad .xn--fiqs8s .xn--fiqz9s .xn--fpcrj9c3d .xn--fzc2c9e2c .xn--g6w251d .xn--gecrj9c .xn--h2brj9c .xn--hgbk6aj7f53bba .xn--hlcj6aya9esc7a .xn--j6w193g .xn--jxalpdlp .xn--kgbechtv .xn--kprw13d .xn--kpry57d .xn--lgbbat1ad8j .xn--mgbaam7a8h .xn--mgbayh7gpa .xn--mgbbh1a71e .xn--mgbc0a9azcg .xn--mgberp4a5d4ar .xn--o3cw4h .xn--ogbpf8fl .xn--p1ai .xn--pgbs0dh .xn--s9brj9c .xn--wgbh1c .xn--wgbl6a .xn--xkc2al3hye2a .xn--xkc2dl3a5ee0h .xn--yfro4i67o .xn--ygbi2ammx .xn--zckzah .xxx .ye .yt .za .zm .zw"), true);

    $html = '';

    $position = 0;
    while (preg_match($rexUrlLinker, $text, $match, PREG_OFFSET_CAPTURE, $position))
    {
        list($url, $urlPosition) = $match[0];

        // Add the text leading up to the URL.
        $html .= htmlspecialchars(substr($text, $position, $urlPosition - $position));

        $protocol    = $match[1][0];
        $username    = $match[2][0];
        $password    = $match[3][0];
        $domain      = $match[4][0];
        $afterDomain = $match[5][0]; // everything following the domain
        $port        = $match[6][0];
        $path        = $match[7][0];

        // Check that the TLD is valid or that $domain is an IP address.
        $tld = strtolower(strrchr($domain, '.'));
        if (preg_match('{^\.[0-9]{1,3}$}', $tld) || isset($validTlds[$tld]))
        {
            // Do not permit implicit protocol if a password is specified, as
            // this causes too many errors (e.g. "my email:foo@example.org").
            if (!$protocol && $password)
            {
                $html .= htmlspecialchars($username);
                
                // Continue text parsing at the ':' following the "username".
                $position = $urlPosition + strlen($username);
                continue;
            }
            
            if (!$protocol && $username && !$password && !$afterDomain)
            {
                // Looks like an email address.
                $completeUrl = "mailto:$url";
                $linkText = $url;
            }
            else
            {
                // Prepend http:// if no protocol specified
                $completeUrl = $protocol ? $url : "http://$url";
                $linkText = "$domain$port$path";
            }
            
            $linkHtml = '<a target="_blank" href="' . htmlspecialchars($completeUrl) . '">'
                . htmlspecialchars($linkText)
                . '</a>';

            // Cheap e-mail obfuscation to trick the dumbest mail harvesters.
            $linkHtml = str_replace('@', '&#64;', $linkHtml);
            
            // Add the hyperlink.
            $html .= $linkHtml;
        }
        else
        {
            // Not a valid URL.
            $html .= htmlspecialchars($url);
        }

        // Continue text parsing from after the URL.
        $position = $urlPosition + strlen($url);
    }

    // Add the remainder of the text.
    $html .= htmlspecialchars(substr($text, $position));
    return $html;
}


/**
 * Return all groups with a name
 *
 * @param string $name The name of the groups
 *
 * @return array|false Depending on success
 * @since 1.8.3
 */
function get_groups_by_name($name) {
  global $CONFIG;

  $name = sanitise_string($name);
  $access = get_access_sql_suffix('e');

  $query = "SELECT e.* from {$CONFIG->dbprefix}groups_entity u join {$CONFIG->dbprefix}entities e on e.guid=u.guid where u.name='$name' and $access ";

  $groups = get_data($query, 'entity_row_to_elggstar');

  return $groups;
}

                                                                                   
?>