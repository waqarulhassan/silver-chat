<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1998 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8.2                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2019 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../config.php')) die('include/[clientinform.php] config.php not exist');
require_once '../config.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && isset($_POST['id']) && !is_numeric($_POST['id'])) die(json_encode(array('status' => false, 'error' => "No valid ID.")));

// Language file
$lang = JAK_LANG;
if (isset($_SESSION['widgetlang']) && !empty($_SESSION['widgetlang'])) $lang = $_SESSION['widgetlang'];

// Import the language file
if ($lang && file_exists(APP_PATH.'lang/'.strtolower($lang).'.php')) {
    include_once(APP_PATH.'lang/'.strtolower($lang).'.php');
} else {
    include_once(APP_PATH.'lang/'.JAK_LANG.'.php');
    $lang = JAK_LANG;
}

// Get the current time
$currentime = time();

if (isset($_SESSION['widgetid'])) {
    $cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$_SESSION['widgetid'].'.php';
    if (file_exists($cachewidget)) include_once $cachewidget;
    // Load the config file
    $styleconfig = APP_PATH.'package/'.$jakwidget['template'].'/config.php';
    if (file_exists($styleconfig)) include_once $styleconfig;
} else {
    die(json_encode(array('status' => false, 'error' => "No valid ID.")));   
}

// Get the absolute url for the image
$base_url = str_replace('include/', '', BASE_URL);

// Get the latest position
$widgetstyle = jak_html_widget_css($jakwidget['floatpopup'], $jakwidget['floatcss'], $jakwidget['floatcsschat']);

// Live Status check
if (!isset($_SESSION['lastopcheck'])) $_SESSION['lastopcheck'] = $currentime;

if ($_GET['run'] == "check") {

    if (isset($_SESSION['convid']) && isset($_SESSION['jrc_userid'])) {

        if (isset($_SESSION["inactive"]) || (isset($_SESSION["slidestatus"]) && ($_SESSION["slidestatus"] == "closed"))) {

            // Get the current status
            $row = $jakdb->get("checkstatus", ["convid", "newc", "knockknock", "hide"], ["convid" => $_SESSION['convid']]);
            if (isset($row) && !empty($row)) {

                // Check if that sessions has not been ended by operator
                if ($row["hide"] != 2) {

                    // Set the new message session
                    $_SESSION['newmsgid'] = $row['newc'];

                    // We are in a chat session, set the link to the chat
                    $chatstarturl = JAK_rewrite::jakParseurl('chat', '1');
                    $chatstarturlpop = JAK_rewrite::jakParseurl('chat', '2');

                    // Update the status for better user handling
                    $jakdb->update("checkstatus", ["statusc" => $currentime, "newc" => 0, "knockknock" => 0, "hide" => 0], ["convid" => $row['convid']]);

                    // Get the new message sound and check if we have a page redirect.
                    if ((!isset($_SESSION['newmsgid']) && $row['newc']) || (isset($_SESSION['newmsgid']) && $_SESSION['newmsgid'] == 1)) {

                        $_SESSION['newmsgid'] = 0;

                        // Now we get the last message and show it in the proactive window.
                        $lastmessage = $jakdb->get("transcript", "message", ["AND" => ["convid" => $_SESSION['convid'], "class" => "admin"], "ORDER" => ["id" => "DESC"]]);

                        die(json_encode(array('status' => true, 'title' => $jakwidget['title'], 'newmessage' => true, 'ended' => false, 'soundalert' => JAK_CLIENT_SOUND, 'lastmessage' => $lastmessage, 'widgetstyle' => $widgetstyle, 'newmsgurl' => str_replace('include/', '', $chatstarturl), 'newmsgpopurl' => str_replace('include/', '', $chatstarturlpop), 'widgettype' => $jakwidget['widget'], 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url))));
                    }

                    // Get the knock knock
                    if ($row['knockknock']) {

                        die(json_encode(array('status' => true, 'knockknock' => $jkl["g22"], 'ended' => false, 'soundalert' => JAK_CLIENT_SOUND, 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url))));
                    }

                }

            }
        }

    } else {

        if (isset($_SESSION['jrc_stopped'])) {
            // unset stopped session
            unset($_SESSION['jrc_stopped']);
        
            die(json_encode(array('status' => true, 'ended' => true)));
        
        }

        // Now let's check every 30 seconds if we still have operators online (live status)
        if (isset($_SESSION['lastopcheck']) && $currentime > ($_SESSION['lastopcheck'] + 20)) {

            // Now update the online status
            if (isset($_SESSION['rlbid'])) $jakdb->update("buttonstats", ["lasttime" => $jakdb->raw("NOW()")], ["session" => $_SESSION['rlbid']]);

            if (JAK_LIVE_ONLINE_STATUS) {

                // Holiday Mode set to offline
                if (JAK_HOLIDAY_MODE > 0) {
                    $onoff = false;
                // Check if an operator is online
                } else {
                    $onoff = (online_operators($LC_DEPARTMENTS, $jakwidget['depid'], $jakwidget['opid']) ? true : false);
                }

                if (!isset($_SESSION['lastopstatus'])) $_SESSION['lastopstatus'] = $onoff;

                // The status has been changed since last time
                $widgethtml = false;
                if (isset($_SESSION['lastopstatus']) && $onoff != $_SESSION['lastopstatus']) {

                    // Update the sessions for the next call
                    $_SESSION['lastopcheck'] = $currentime;
                    $_SESSION['lastopstatus'] = $onoff;

                    die(json_encode(array('status' => true, 'widget' => true)));

                }

            }
        }

        // Let's check if the slide up is closed, so we need to run the engage
        if (isset($_SESSION['lastopstatus']) && $_SESSION['lastopstatus'] !== false) {

            // Check if we have an auto proactive
            if (!isset($_COOKIE['jkchatproact'])) {
                    
                if (!empty($LC_PROACTIVE)) {
                        
                    foreach ($LC_PROACTIVE as $v) {
                                
                        if (isset($_SESSION['jkchathits']) && isset($_SESSION['jkchatref']) && isset($_SESSION['jkchatontime']) && $_SESSION['jkchathits'] >= $v["visitedsites"] && $v["timeonsite"] <= ($currentime - $_SESSION['jkchatontime']) && ($v["path"] == $_SESSION['jkchatref'] || fnmatch($v["path"], $_SESSION['jkchatref']))) {
                                
                            setcookie("jkchatproact", 1, $currentime + (86400 * JAK_PROACTIVE_TIME), JAK_COOKIE_PATH);
                                    
                            $jakdb->update("buttonstats", ["proactive" => 999, "message" => $v['message'], "readtime" => 0], ["session" => $_SESSION['rlbid']]);
                                    
                            $imgurl = '';
                            if (filter_var($v['imgpath'], FILTER_VALIDATE_URL) && is_array(getimagesize($v['imgpath']))) $imgurl = $v['imgpath'];

                            // set the session so wie can reuse it
                            $_SESSION['engage'] = array('status' => true, 'offline' => false, 'title' => $v['title'], 'imgurl' => $imgurl, 'imgpath' => $v['imgpath'], 'message' => $v['message'], 'yesbtn' => $v["btn_confirm"], 'nobtn' => $v["btn_cancel"], 'showalert' => $v['showalert'], 'soundalert' => $v['soundalert'], 'ended' => false, 'widgetstyle' => $widgetstyle, 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url));
                                    
                            die(json_encode($_SESSION['engage']));
                                
                        }
                                
                    }
                        
                }
                        
            }

            // Check if we have an manual proactive
            if (!isset($_COOKIE['jkchatproactm'])) {
                
                // Manual Engage
                $proactivefile = APP_PATH.JAK_CACHE_DIRECTORY.'/proactive.php';
                        
                if (file_exists($proactivefile)) {
                    
                    // Now include the created definefile
                    include_once $proactivefile;
                            
                    if (is_array($LV_MPROACTIVE) && !empty($LV_MPROACTIVE)) foreach ($LV_MPROACTIVE as $v) {
                        
                        if (isset($_SESSION['rlbid']) && $v["session"] == $_SESSION['rlbid']) {

                            setcookie("jkchatproactm", 1, $currentime + 600 , JAK_COOKIE_PATH);

                            // set the session so wie can reuse it
                            $_SESSION['engage'] = array('status' => true, 'offline' => false, 'title' => $jkl['g10'], 'imgpath' => 'alarm_on', 'message' => $v['message'], 'yesbtn' => $jkl['g72'], 'nobtn' => $jkl['g73'], 'showalert' => JAK_PRO_ALERT, 'soundalert' => JAK_ENGAGE_SOUND, 'ended' => false, 'widgetstyle' => $widgetstyle, 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url));
                                    
                            die(json_encode($_SESSION['engage']));
                                
                        }
                    
                    }
                           
                }

            }

        } // Finish check slide out window
    }
}

if ($_GET['run'] == "windowopen") {

    if (isset($_SESSION['rlbid'])) {

        // Now check the button id
        $cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$_GET['id'].'.php';
        if (file_exists($cachewidget)) include_once $cachewidget;

        $result = $jakdb->update("buttonstats", ["readtime" => 2], ["AND" => ["session" => $_SESSION['rlbid'], "readtime" => 0]]);
            
        // Now let us delete and recreate the proactive cache file
        $proactivefile = APP_PATH.JAK_CACHE_DIRECTORY.'/proactive.php';
            
        if (file_exists($proactivefile)) {
            unlink($proactivefile);
        }

        $manualproactive = $jakdb->select("buttonstats", ["id", "session", "message"], ["AND" => ["proactive[>]" => 0, "proactive[!]" => 999, "readtime" => 0]]);
            
        if (isset($manualproactive) && !empty($manualproactive)) {
                
            $pafile = "<?php\n";
                
            $pafile .= "\$mproactiveserialize = '".base64_encode(gzcompress(serialize($manualproactive)))."';\n\n\$LV_MPROACTIVE = unserialize(gzuncompress(base64_decode(\$mproactiveserialize)));\n\n";
                
            $pafile .= "?>";
                
            JAK_base::jakWriteinCache($proactivefile, $pafile, '');
        }
            
        if ($result) {

            // Go to Engage
            $gotoengage = JAK_rewrite::jakParseurl('engage');

            die(json_encode(array('status' => true, 'url' => str_replace('include/', '', $gotoengage), 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url))));
        } else {
            die(json_encode(array('status' => false)));
        }

    } else {
        die(json_encode(array('status' => false)));
    }

}

if ($_GET['run'] == "open") {

    if (isset($_SESSION['rlbid'])) {

        // Now check the button id
        $cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$_GET['id'].'.php';
        if (file_exists($cachewidget)) include_once $cachewidget;

        $result = $jakdb->update("buttonstats", ["readtime" => 2], ["AND" => ["session" => $_SESSION['rlbid'], "readtime" => 0]]);
            
        // Now let us delete and recreate the proactive cache file
        $proactivefile = APP_PATH.JAK_CACHE_DIRECTORY.'/proactive.php';
            
        if (file_exists($proactivefile)) {
            unlink($proactivefile);
        }

        $manualproactive = $jakdb->select("buttonstats", ["id", "session", "message"], ["AND" => ["proactive[>]" => 0, "proactive[!]" => 999, "readtime" => 0]]);
            
        if (isset($manualproactive) && !empty($manualproactive)) {
                
            $pafile = "<?php\n";
                
            $pafile .= "\$mproactiveserialize = '".base64_encode(gzcompress(serialize($manualproactive)))."';\n\n\$LV_MPROACTIVE = unserialize(gzuncompress(base64_decode(\$mproactiveserialize)));\n\n";
                
            $pafile .= "?>";
                
            JAK_base::jakWriteinCache($proactivefile, $pafile, '');
        }
            
        if ($result) {

            // Is it mobile
            $widgettype = $_SESSION["setchatstyle"];
            if (isset($_SESSION["clientismobile"]) && $_SESSION["clientismobile"] == true) $widgettype = 2;

            if ($jakwidget['chat_direct']) {
                $chatstarturl = JAK_rewrite::jakParseurl('start', $widgettype);
            } else {
                $chatstarturl = JAK_rewrite::jakParseurl('quickstart', $widgettype);
            }

            $widget = $jakdb->get("chatwidget", ["depid", "opid", "widget"], ["id" => $_SESSION['widgetid']]);
            die(json_encode(array('status' => true, 'widget' => $widgettype, 'url' => str_replace('include/', '', $chatstarturl), 'widgetstyle' => $widgetstyle, 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url))));
        } else {
            die(json_encode(array('status' => false)));
        }

    } else {
        die(json_encode(array('status' => false)));
    }

}

if ($_GET['run'] == "close") {

    if (isset($_SESSION['rlbid'])) {

        $result = $jakdb->update("buttonstats", ["readtime" => 1], ["AND" => ["session" => $_SESSION['rlbid'], "readtime" => 0]]);
            
        // Now let us delete and recreate the proactive cache file
        $proactivefile = APP_PATH.JAK_CACHE_DIRECTORY.'/proactive.php';
            
        if (file_exists($proactivefile)) {
            unlink($proactivefile);
        }
            
        // Get the departments
        $manualproactive = $jakdb->select("buttonstats", ["id", "session", "message"], ["AND" => ["proactive[>]" => 0, "proactive[!]" => 999, "readtime" => 0]]);
            
        if (isset($manualproactive) && !empty($manualproactive)) {
                
            // Now create the file
            $pafile = "<?php\n";
                
            $pafile .= "\$mproactiveserialize = '".base64_encode(gzcompress(serialize($manualproactive)))."';\n\n\$LV_MPROACTIVE = unserialize(gzuncompress(base64_decode(\$mproactiveserialize)));\n\n";
                
            $pafile .= "?>";
                
            JAK_base::jakWriteinCache($proactivefile, $pafile, '');
        }
            
        if ($result) {
            die(json_encode(array('status' => true, 'widgetstyle' => $widgetstyle, 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url))));
        } else {
            die(json_encode(array('status' => false)));
        }
            
    } else {
        die(json_encode(array('status' => false)));
    }

}

die(json_encode(array('status' => false, 'error' => "Nothing to do here...")));
?>