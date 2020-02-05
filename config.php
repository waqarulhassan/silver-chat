<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8.6                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2019 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Error reporting:
error_reporting(E_ALL^E_NOTICE);

// The DB connections data
require_once 'include/db.php';

// Do not go any further if install folder still exists
if (is_dir('install')) die('Please delete or rename install folder.');

if (!JAK_CACHE_DIRECTORY) die('Please define a cache directory in the db.php.');

// Start the session
session_start();

// Absolute Path
define('APP_PATH', dirname(__file__) . DIRECTORY_SEPARATOR);

if (isset($_SERVER['SCRIPT_NAME'])) {

    # on Windows _APP_MAIN_DIR becomes \ and abs url would look something like HTTP_HOST\/restOfUrl, so \ should be trimed too
    # @modified Chis Florinel <chis.florinel@candoo.ro>
    $app_main_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    define('_APP_MAIN_DIR', $app_main_dir);
} else {
    die('[config.php] Cannot determine APP_MAIN_DIR, please set manual and comment this line');
}

// Get the DB class
require_once 'class/class.db.php';

// Change for 3.0.3
use JAKWEB\JAKsql;

// Database connection
$jakdb = new JAKsql([
    // required
    'database_type' => JAKDB_DBTYPE,
    'database_name' => JAKDB_NAME,
    'server' => JAKDB_HOST,
    'username' => JAKDB_USER,
    'password' => JAKDB_PASS,
    'charset' => 'utf8',
    'port' => JAKDB_PORT,
    'prefix' => JAKDB_PREFIX,
 
    // [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
    'option' => [PDO::ATTR_CASE => PDO::CASE_NATURAL]
    ]);

// All important files
include_once 'include/functions.php';
include_once 'class/class.browser.php';
include_once 'class/class.jakbase.php';
include_once 'class/PHPMailerAutoload.php';
include_once 'class/class.userlogin.php';
include_once 'class/class.user.php';

// Windows Fix if !isset REQUEST_URI
if (!isset($_SERVER['REQUEST_URI']))
{
	$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
	if (isset($_SERVER['QUERY_STRING'])) { $_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING']; }
}

// Now launch the rewrite class, depending on the settings in db.
$_SERVER['REQUEST_URI'] = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES);
$getURL = New JAK_rewrite($_SERVER['REQUEST_URI']);

// We are not using apache so take the ugly urls
$tempp = $getURL->jakGetseg(0);
$tempp1 = $getURL->jakGetseg(1);
$tempp2 = $getURL->jakGetseg(2);
$tempp3 = $getURL->jakGetseg(3);
$tempp4 = $getURL->jakGetseg(4);
$tempp5 = $getURL->jakGetseg(5);
$tempp6 = $getURL->jakGetseg(6);
$tempp7 = $getURL->jakGetseg(7);

// Check if we want caching
if (!is_dir(APP_PATH.JAK_CACHE_DIRECTORY)) mkdir(APP_PATH.JAK_CACHE_DIRECTORY, 0755);

// define file better for caching
$cachedefinefile = APP_PATH.JAK_CACHE_DIRECTORY.'/define.php';

if (!file_exists($cachedefinefile)) {

$allsettings = "<?php\n";

// Get the general settings out the database
$datasett = $jakdb->select("settings",["varname", "used_value"]);
foreach ($datasett as $row) {
    // Now check if sting contains html and do something about it!
    if (strlen($row['used_value']) != strlen(filter_var($row['used_value'], FILTER_SANITIZE_STRING))) {
    	$defvar  = 'htmlspecialchars_decode("'.htmlspecialchars($row['used_value']).'")';
    } else {
    	$defvar = "'".$row["used_value"]."'";
    }
    	
    $allsettings .= "define('JAK_".strtoupper($row['varname'])."', ".$defvar.");\n";
}
    
$allsettings .= "?>";
        
JAK_base::jakWriteinCache($cachedefinefile, $allsettings, '');

}

// Now include the created definefile
include_once $cachedefinefile;

// define file better for caching
$cachestufffile = APP_PATH.JAK_CACHE_DIRECTORY.'/stuff.php';

if (!file_exists($cachestufffile)) {

// empty vars
$filesgrid = $answergrid = $responsegrid = $departmentgrid = $autoproactivegrid = array();

$allstuff = "<?php\n";

// Get the general settings out the database
$datafiles = $jakdb->select("files",["id", "path", "name"]);
if (isset($datafiles) && !empty($datafiles)) foreach ($datafiles as $rowf) {
    $filesgrid[] = $rowf;
}
    
// Get the answers out the database
$dataansw = $jakdb->select("answers", ["id", "department", "lang", "message", "fireup", "msgtype"]);
if (isset($dataansw) && !empty($dataansw)) foreach ($dataansw as $rowa) {
    $answergrid[] = $rowa;
}

// Get the url black list
$databl = $jakdb->select("urlblacklist", "path");
if (isset($databl) && !empty($databl)) foreach ($databl as $rowb) {
    $blacklistgrid[] = $rowb;
}
    
// Get the responses settings out the database
$datares = $jakdb->select("responses", ["id", "department", "title", "message"]);
if (isset($datares) && !empty($datares)) foreach ($datares as $rowr) {
    $responsegrid[] = $rowr;
}

// Get the chat bot out of the database
$databot = $jakdb->select("bot_question", ["id", "widgetids", "depid", "lang", "question", "answer"], ["active" => 1]);
if (isset($databot) && !empty($databot)) foreach ($databot as $rowba) {
    $botgrid[] = $rowba;
}
    
// Get the departments
$datadep = $jakdb->select("departments", ["id", "title", "email", "faq_url"], ["active" => 1, "ORDER" => ["dorder" => "ASC"]]);
if (isset($datadep) && !empty($datadep)) foreach ($datadep as $rowd) {
    $departmentgrid[] = $rowd;
}
    
// Get the auto proactive out the database
$dataproact = $jakdb->select("autoproactive", ["path", "title", "imgpath", "message", "btn_confirm", "btn_cancel", "showalert", "soundalert", "timeonsite", "visitedsites"]);
if (isset($dataproact) && !empty($dataproact)) foreach ($dataproact as $rowap) {
    $autoproactivegrid[] = $rowap;
}
    
if (!empty($answergrid)) $allstuff .= "\$answergserialize = '".base64_encode(gzcompress(serialize($answergrid)))."';\n\n\$LC_ANSWERS = unserialize(gzuncompress(base64_decode(\$answergserialize)));\n\n";

if (!empty($blacklistgrid)) $allstuff .= "\$blacklistserialize = '".base64_encode(gzcompress(serialize($blacklistgrid)))."';\n\n\$LC_BLACKLIST = unserialize(gzuncompress(base64_decode(\$blacklistserialize)));\n\n";
    
if (!empty($responsegrid)) $allstuff .= "\$responsegserialize = '".base64_encode(gzcompress(serialize($responsegrid)))."';\n\n\$LC_RESPONSES = unserialize(gzuncompress(base64_decode(\$responsegserialize)));\n\n";

if (!empty($botgrid)) $allstuff .= "\$botserialize = '".base64_encode(gzcompress(serialize($botgrid)))."';\n\n\$JAK_BOT_ANSWER = unserialize(gzuncompress(base64_decode(\$botserialize)));\n\n";
    
if (!empty($filesgrid)) $allstuff .= "\$filesgserialize = '".base64_encode(gzcompress(serialize($filesgrid)))."';\n\n\$LC_FILES = unserialize(gzuncompress(base64_decode(\$filesgserialize)));\n\n";

$allstuff .= "\$departmentgserialize = '".base64_encode(gzcompress(serialize($departmentgrid)))."';\n\n\$LC_DEPARTMENTS = unserialize(gzuncompress(base64_decode(\$departmentgserialize)));\n\n";

if (!empty($autoproactivegrid)) $allstuff .= "\$autoproactiveserialize = '".base64_encode(gzcompress(serialize($autoproactivegrid)))."';\n\n\$LC_PROACTIVE = unserialize(gzuncompress(base64_decode(\$autoproactiveserialize)));\n\n";
    
$allstuff .= "?>";
        
JAK_base::jakWriteinCache($cachestufffile, $allstuff, '');

}

// Now include the created definefile
include_once $cachestufffile;

// Chat widget caching
$cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget1.php';

if (!file_exists($cachewidget)) {

    // Get the general settings out the database
    $reswidg = $jakdb->select("chatwidget", "*");
    if (isset($reswidg) && !empty($reswidg)) {

        foreach ($reswidg as $row) {

            // Now let us delete the widget cache file
            $cachewidgetdel = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$row['id'].'.php';
            if (file_exists($cachewidgetdel)) {
                unlink($cachewidgetdel);
            }

            $allwidget = "<?php\n\$jakwidget = array();\n";

            $allwidget .= "\$jakwidget['id'] = '".$row['id']."';\n\$jakwidget['title'] = '".addslashes($row['title'])."';\n\$jakwidget['whatsapp_message'] = '".addslashes($row['whatsapp_message'])."';\n\$jakwidget['depid'] = '".$row['depid']."';\n\$jakwidget['opid'] = ".$row['opid'].";\n\$jakwidget['lang'] = '".stripcslashes($row['lang'])."';\n\$jakwidget['widget'] = ".$row['widget'].";\n\$jakwidget['hideoff'] = ".$row['hideoff'].";\n\$jakwidget['buttonimg'] = '".stripcslashes($row['buttonimg'])."';\n\$jakwidget['mobilebuttonimg'] = '".stripcslashes($row['mobilebuttonimg'])."';\n\$jakwidget['slideimg'] = '".stripcslashes($row['slideimg'])."';\n\$jakwidget['floatpopup'] = ".$row['floatpopup'].";\n\$jakwidget['chat_direct'] = ".$row['chat_direct'].";\n\$jakwidget['whatsapp_online'] = ".$row['whatsapp_online'].";\n\$jakwidget['whatsapp_offline'] = ".$row['whatsapp_offline'].";\n\$jakwidget['client_email'] = ".$row['client_email'].";\n\$jakwidget['client_semail'] = ".$row['client_semail'].";\n\$jakwidget['client_phone'] = ".$row['client_phone'].";\n\$jakwidget['client_sphone'] = ".$row['client_sphone'].";\n\$jakwidget['client_question'] = ".$row['client_question'].";\n\$jakwidget['client_squestion'] = ".$row['client_squestion'].";\n\$jakwidget['show_avatar'] = ".$row['show_avatar'].";\n\$jakwidget['floatcss'] = '".stripcslashes($row['floatcss'])."';\n\$jakwidget['floatcsschat'] = '".stripcslashes($row['floatcsschat'])."';\n\$jakwidget['engagecss'] = '".stripcslashes($row['engagecss'])."';\n\$jakwidget['btn_animation'] = '".stripcslashes($row['btn_animation'])."';\n\$jakwidget['chat_animation'] = '".stripcslashes($row['chat_animation'])."';\n\$jakwidget['engage_animation'] = '".stripcslashes($row['engage_animation'])."';\n\$jakwidget['dsgvo'] = '".stripcslashes($row['dsgvo'])."';\n\$jakwidget['redirect_url'] = '".stripcslashes($row['redirect_url'])."';\n\$jakwidget['redirect_active'] = '".$row['redirect_active']."';\n\$jakwidget['redirect_after'] = '".$row['redirect_after']."';\n\$jakwidget['feedback'] = '".$row['feedback']."';\n\$jakwidget['sucolor'] = '".stripcslashes($row['sucolor'])."';\n\$jakwidget['sutcolor'] = '".stripcslashes($row['sutcolor'])."';\n\$jakwidget['template'] = '".stripcslashes($row['template'])."';\n\$jakwidget['theme_colour'] = '".stripcslashes($row['theme_colour'])."';\n\$jakwidget['body_colour'] = '".$row['body_colour']."';\n\$jakwidget['h_colour'] = '".$row['h_colour']."';\n\$jakwidget['c_colour'] = '".$row['c_colour']."';\n\$jakwidget['time_colour'] = '".$row['time_colour']."';\n\$jakwidget['link_colour'] = '".$row['link_colour']."';\n\$jakwidget['sidebar_colour'] = '".$row['sidebar_colour']."';\n\$jakwidget['t_font'] = '".stripcslashes($row['t_font'])."';\n\$jakwidget['h_font'] = '".stripcslashes($row['h_font'])."';\n\$jakwidget['c_font'] = '".stripcslashes($row['c_font'])."';\n\$jakwidget['whitelist'] = '".stripcslashes($row['widget_whitelist'])."';\n";

            $allwidget .= "?>";
                
            JAK_base::jakWriteinCache($cachewidgetdel, $allwidget, '');
           
        }

    }
}

// Group Chat caching
$cachegroupchat = APP_PATH.JAK_CACHE_DIRECTORY.'/groupchat1.php';

if (!file_exists($cachegroupchat)) {

    // Get the general settings out the database
    $resgc = $jakdb->select("groupchat", "*", ["active" => 1]);
    if (isset($resgc) && !empty($resgc)) {

        foreach ($resgc as $row) {

            // Now let us delete the widget cache file
            $cachegroupchat = APP_PATH.JAK_CACHE_DIRECTORY.'/groupchat'.$row['id'].'.php';
            if (file_exists($cachegroupchat)) {
                unlink($cachegroupchat);
            }

            $groupchat = "<?php\n\$groupchat = array();\n";

            $groupchat .= "\$groupchat['id'] = '".$row['id']."';\n\$groupchat['password'] = '".stripcslashes($row['password'])."';\n\$groupchat['title'] = '".addslashes($row['title'])."';\n\$groupchat['description'] = '".stripcslashes($row['description'])."';\n\$groupchat['opids'] = '".stripcslashes($row['opids'])."';\n\$groupchat['maxclients'] = ".$row['maxclients'].";\n\$groupchat['lang'] = '".stripcslashes($row['lang'])."';\n\$groupchat['buttonimg'] = '".stripcslashes($row['buttonimg'])."';\n\$groupchat['floatpopup'] = ".$row['floatpopup'].";\n\$groupchat['floatcss'] = '".stripcslashes($row['floatcss'])."';\n\$groupchat['active'] = ".$row['active'].";\n";

            $groupchat .= "?>";
                
            JAK_base::jakWriteinCache($cachegroupchat, $groupchat, '');
           
        }

    }
}

// timezone from server
if (defined('JAK_TIMEZONESERVER')) date_default_timezone_set(JAK_TIMEZONESERVER);
$jakdb->query('SET time_zone = "'.date("P").'"');

// Check if https is activated
if (JAK_SITEHTTPS) {
    define('BASE_URL', 'https://' . FULL_SITE_DOMAIN . _APP_MAIN_DIR . '/');
} else {
    define('BASE_URL', 'http://' . FULL_SITE_DOMAIN . _APP_MAIN_DIR . '/');
}

// Get the copyright Link
define('JAK_COPYRIGHT_LINK', $jakhs['copyright']);

// Get the users ip address
$ipa = get_ip_address();
?>