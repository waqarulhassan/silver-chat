<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8.1                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// prevent direct php access
define('JAK_PREVENT_ACCESS', 1);

if (!file_exists('config.php')) die('[index.php] config.php not exist');
require_once 'config.php';

$page = ($tempp ? jak_url_input_filter($tempp) : '');
$page1 = ($tempp1 ? jak_url_input_filter($tempp1) : '');
$page2 = ($tempp2 ? jak_url_input_filter($tempp2) : '');
$page3 = ($tempp3 ? jak_url_input_filter($tempp3) : '');
$page4 = ($tempp4 ? jak_url_input_filter($tempp4) : '');
$page5 = ($tempp5 ? jak_url_input_filter($tempp5) : '');
$page6 = ($tempp6 ? jak_url_input_filter($tempp6) : '');
$page7 = ($tempp7 ? jak_url_input_filter($tempp7) : '');

// Ok we have a link, set the sessions.
if ($page == 'link') {
	// Write the chat widget id into a session
	$_SESSION['widgetid'] = 1;
	if (isset($page1) && is_numeric($page1)) $_SESSION['widgetid'] = $page1;
	// Write the chat language
	$_SESSION['widgetlang'] = JAK_LANG;
	if (isset($page2) && !empty($page2)) $_SESSION['widgetlang'] = $page2;
}

// Now we don't have a widget id session, set one
if (!isset($_SESSION['widgetid'])) $_SESSION['widgetid'] = 1;

if (isset($_SESSION['widgetid'])) {
	$cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$_SESSION['widgetid'].'.php';
	if (file_exists($cachewidget)) include_once $cachewidget;
	$styleconfig = APP_PATH.'package/'.$jakwidget['template'].'/config.php';
	if (file_exists($styleconfig)) include_once $styleconfig;
}

// Get the language file if different from settings
$BT_LANGUAGE = JAK_LANG;
if (isset($_SESSION['widgetlang']) && $_SESSION['widgetlang'] != JAK_LANG) $BT_LANGUAGE = $_SESSION['widgetlang'];

// Import the language file
if ($BT_LANGUAGE && file_exists(APP_PATH.'lang/'.strtolower($BT_LANGUAGE).'.php')) {
    include_once(APP_PATH.'lang/'.strtolower($BT_LANGUAGE).'.php');
} else {
    include_once(APP_PATH.'lang/'.JAK_LANG.'.php');
}

// If Referer Zero go to the session url
if (!isset($_SERVER['HTTP_REFERER'])) {
	if (isset($_SESSION['jaklastURL'])) {
    	$_SERVER['HTTP_REFERER'] = $_SESSION['jaklastURL'];
    } else {
    	$_SERVER['HTTP_REFERER'] = BASE_URL;
    }
}

// Lang and pages file for template
define('JAK_SITELANG', JAK_LANG);

// Assign Pages to template
define('JAK_PAGINATE_ADMIN', 0);

// Define the avatarpath in the settings
define('JAK_FILEPATH_BASE', BASE_URL.JAK_FILES_DIRECTORY);

// Define the real request
$realrequest = substr($getURL->jakRealrequest(), 1);
define('JAK_PARSE_REQUEST', $realrequest);

// Set the chatstyle
if (isset($_SESSION["setchatstyle"]) && $page1 != $_SESSION["setchatstyle"]) $_SESSION["setchatstyle"] = $page1;
// We set the URL, so it is always the same
if ($jakwidget['chat_direct']) {
	$chatstarturl = JAK_rewrite::jakParseurl('start', '1');
	$chatstarturlpop = JAK_rewrite::jakParseurl('start', '2');
} else {
	$chatstarturl = JAK_rewrite::jakParseurl('quickstart', '1');
	$chatstarturlpop = JAK_rewrite::jakParseurl('quickstart', '2');
}
// We are in a chat session, set the link to the chat
if (isset($_SESSION['jrc_userid']) && isset($_SESSION['convid'])) {
	$chatstarturl = JAK_rewrite::jakParseurl('chat', '1');
	$chatstarturlpop = JAK_rewrite::jakParseurl('chat', '2');
}
// Set the contact url
$chatcontacturl = JAK_rewrite::jakParseurl('contact', '1');
$chatcontacturlpop = JAK_rewrite::jakParseurl('contact', '2');
// Set the end url
if ($jakwidget['feedback']) {
	$chatendurl = JAK_rewrite::jakParseurl('feedback', '1');
	$chatendurlpop = JAK_rewrite::jakParseurl('feedback', '2');
} else {
	$chatendurl = JAK_rewrite::jakParseurl('stop', '1');
	$chatendurlpop = JAK_rewrite::jakParseurl('stop', '2');
}
// Edit Chat session details.
$chatdetails = JAK_rewrite::jakParseurl('profile', '1');
$chatdetailspop = JAK_rewrite::jakParseurl('profile', '2');
// Close the chat and unset the session
$chatcloseurl = JAK_rewrite::jakParseurl('closechat');
// Back to Button
$backtobtn = JAK_rewrite::jakParseurl('btn');
// Go to Engage
$gotoengage = JAK_rewrite::jakParseurl('engage');

// Check if the ip or range is blocked, if so redirect to offline page with a message
$USR_IP_BLOCKED = false;
if (JAK_IP_BLOCK) {
	$blockedips = explode(',', JAK_IP_BLOCK);
	// Do we have a range
	if (is_array($blockedips)) foreach ($blockedips as $bip) {
		$blockedrange = explode(':', $bip);
		
		if (is_array($blockedrange)) {
		
			$network=ip2long($blockedrange[0]);
			$mask=ip2long($blockedrange[1]);
			$remote=ip2long($ipa);
			
			if (($remote & $mask) == $network) {
			    $USR_IP_BLOCKED = $jkl['e11'];
			}	
		}
	}
	// Now let's check if we have another match
	if (in_array($ipa, $blockedips)) {
		$USR_IP_BLOCKED = $jkl['e11'];
	}
}

// Now get the available departments
$online_op = false;
if (JAK_HOLIDAY_MODE != 0) {
	$online_op = false;
	$_SESSION['lastopstatus'] = false;
} else {
	 if (isset($_SESSION['widgetid'])) $online_op = online_operators($LC_DEPARTMENTS, $jakwidget['depid'], $jakwidget['opid']);
	$_SESSION['lastopstatus'] = (!empty($online_op) ? true : false);
}

// Finally get the captcha if wish so
if (JAK_CAPTCHA) {
	
	if (isset($_SESSION['jrc_captcha'])) {
		
		$human_captcha = explode(':#:', $_SESSION['jrc_captcha']);
		
		$random_name = $human_captcha[0];
		$random_value = $human_captcha[1];

	} else {
		
		$random_name = rand();
		$random_value = rand();
		
		$_SESSION['jrc_captcha'] = $random_name.':#:'.$random_value;
		
	}

}

// Set the check page to 0
$JAK_CHECK_PAGE = 0;
	
	// let's do the dirty work
	if ($page == 'btn') {
		require_once 'btn.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// let's engage the customer
	if ($page == 'engage') {
		require_once 'engage.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// Start the chat
	if ($page == 'start') {
		require_once 'start.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// Start the quickchat
	if ($page == 'quickstart') {
		require_once 'quickstart.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// Link we need a redirect
	if ($page == 'link') {
		if ($online_op) {
			jak_redirect($chatstarturlpop);
		} else {
			jak_redirect($chatcontacturlpop);
		}
	}
	// Use the chat
	if ($page == 'chat') {
		require_once 'chat.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// Use the chat
	if ($page == 'profile') {
		require_once 'profile.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// Stop and Feedback the chat
	if ($page == 'feedback') {
		require_once 'feedback.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// Stop the chat
	if ($page == 'stop') {
		require_once 'stop.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// Close the chat
	if ($page == 'closechat') {
		$_SESSION['newmsgid'] = 0;
		$_SESSION["slidestatus"] = "closed";
		jak_redirect($backtobtn);
	}
	// Contact form
	if ($page == 'contact') {
		require_once 'contact.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// Group Chat
	if ($page == 'groupchat') {
		require_once 'groupchat.php';
		$JAK_CHECK_PAGE = 1;
		$PAGE_SHOWTITLE = 1;
	}
	// Cookie and session fix
	if ($page == 'cookiefix') {
		$JAK_CHECK_PAGE = 1;
		setcookie("activation", "visited", time() + JAK_COOKIE_TIME, JAK_COOKIE_PATH);
		if (isset($page1) && !empty($page1) && filter_var(base64_decode($page1), FILTER_VALIDATE_URL)) {
			jak_redirect(base64_decode($page1));
		} else {
			jak_redirect(BASE_URL);
		}
	}
	// Get the lic page
   	if ($page == 'check') {
   	    $PAGE_TITLE = 'Live Chat 3 Check';
   	    $mycheck = "lc3";
   	    require_once 'check.php';
   	    $JAK_CHECK_PAGE = 1;
   	    $PAGE_SHOWTITLE = 1;
   	}
    // Get the 404 page
   	if ($page == '404') {
   	    $PAGE_TITLE = '404 ';
   	    require_once '404.php';
   	    $JAK_CHECK_PAGE = 1;
   	    $PAGE_SHOWTITLE = 1;
   	}

// if page not found
if ($JAK_CHECK_PAGE == 0) jak_redirect(BASE_URL.JAK_OPERATOR_LOC);
?>