<?

//DO NOT DISRUPT THE ORDER
global $CONFIG;

//turn captcha on or off, comment out to turn on...  PS this doesnt fully activate the captcha you need to uncomment the captcha related javascript functions also!
$CONFIG->captcha = "false";

//turning this on records all missing translations and takes overhead!
$CONFIG->translation_todo_shortcut = true;
$CONFIG->translation_todo_recording = false;
$CONFIG->translation_todo_recording_echo = false;

$CONFIG->adminLabelForPublic = "რედაქტორი";
$CONFIG->dayspassed = 3;
$CONFIG->lowPriorityChannels = array("ტელეარხი 25", "თრიალეთი");
$CONFIG->highPriorityChannels = array("Channel 8", "Channel 9", "Channel 10");
$CONFIG->FBpageURL = "https://www.facebook.com/Telekritikage";

//how many letters for auto shortened preview version
$CONFIG->slideExcerptLength = 1000;
$CONFIG->excerptLength = 500;
//minimum controversy score for a comment to show up in hot comments
$CONFIG->minimumControversyScore = 1;

//homepage twitter slider
$CONFIG->slideDownTime = 1000;
$CONFIG->SMSphonenumber = "304-404040";
//$CONFIG->mainhashtag = "#TIGeorgia";
$CONFIG->TWITTERhashtags = array("#TIGeorgia", "#telekritika", "#transparency");
//max tweets to show,  and also max sms to show, on homepage
$CONFIG->maxtweetsmsonhomepage = 10;

/*************************************************/
/****************USERS OF THE MONTH***************/
/*************************************************/
$CONFIG->userOfMonthEnabled = true; //set to false to turn off
$CONFIG->commentValueRatio = .1; //comment weighting for comment controversy calc (ie a 1 like : 1 dislike post with no comments is LESS controversial than a 1 like : 1 dislike post WITH comments

    //point values awarded for monthly awards, please note in the badges setup you mUST have uploaded badges with the 
    //corresponding names: controversyGold, controversySilver, etc etc!!!  AND within the badges admin, leave point value BLANK
$CONFIG->awards = array(
    "controversyGold" => 100,
    "controversySilver" => 40,
    "controversyBronze" => 10,

    "popularityGold" => 100,
    "popularitySilver" => 40,
    "popularityBronze" => 10,

    "conversationGold" => 100,
    "conversationSilver" => 40,
    "conversationBronze" => 10,
);

/*************************************************/
/****************VARIOUS UI VARS******************/
/*************************************************/
$CONFIG->module_entries_limit = 5; //max entries per page of a module
$CONFIG->displayRevisions = 5; //how many of last revisions to show for article etc sidebar when editing
                            //days * hours * minutes * seconds
$CONFIG->time_until_expired = 300 * (24 * 60 * 60);    //how far back in time to show events in tag cloud etc  days 
$CONFIG->mainlogosrc = $CONFIG->wwwroot . "_graphics/tk-logo.jpg"; //main logo

/*************************************************/
/****************CHANNELVIEWER VARS***************/
/*************************************************/
$CONFIG->maxChannelsInChannelViewer = 9;
$CONFIG->broadcast_type_on = true;

//root for autochannelview, if changed will only affect new channels
$CONFIG->myvideo_autourl_root = 'http://www.myvideo.ge/?act=dvr&chan=';  

$CONFIG->broadcast_types = array();
$CONFIG->broadcast_types[] = elgg_echo('segment:broadcast_type:evening');
$CONFIG->broadcast_types[] = elgg_echo('segment:broadcast_type:noon');
$CONFIG->broadcast_types[] = elgg_echo('segment:broadcast_type:morning');
$CONFIG->broadcast_types[] = elgg_echo('segment:broadcast_type:special');

/*************************************************/
/****************SEARCH VARS**********************/
/*************************************************/
    //searchtypes to specifically disallow
$CONFIG->noSearchTypes = array();
$CONFIG->noSearchTypes[] = 'groupforumtopic';
$CONFIG->noSearchTypes[] = 'file';
$CONFIG->noSearchTypes[] = 'user';
$CONFIG->noSearchTypes[] = 'group';
$CONFIG->noSearchTypes[] = 'userpoint';
$CONFIG->noSearchTypes[] = 'badge';

    //searchtypes to specifically allow
$CONFIG->allowedSearchObjectSubtypes = array();
$CONFIG->allowedSearchObjectSubtypes[] = 'segment';
$CONFIG->allowedSearchObjectSubtypes[] = 'commentary';
$CONFIG->allowedSearchObjectSubtypes[] = 'article';
//    $CONFIG->allowedSearchObjectSubtypes[] = 'editorial';
