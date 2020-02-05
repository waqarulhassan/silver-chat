<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1998 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.7                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../config.php')) die('ajax/[available.php] config.php not exist');
require_once '../config.php';

// Extensive test if that is the real user or not
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !isset($_SESSION['jrc_userid']) || !isset($_GET["uid"]) || $_SESSION['jrc_userid'] != $_GET["uid"]) die("Nothing to do here");

// Language file
$lang = JAK_LANG;
if (isset($_SESSION['widgetlang']) && !empty($_SESSION['widgetlang'])) $lang = $_SESSION['widgetlang'];

// Import the language file
if ($lang && file_exists(APP_PATH.'lang/'.strtolower($lang).'.php')) {
	include_once(APP_PATH.'lang/'.strtolower($lang).'.php');
} else {
	include_once(APP_PATH.'lang/'.JAK_LANG.'.php');
}

// Get the absolute url for the image
$base_url = str_replace('include/', '', BASE_URL);

// Reset some vars
$editedmsg = $showedit = $oimage = '';
$otyping = $knockknock = $inchat = $kk = false;
$opern = $jkl['g59'];

// Filter get vars
$getlang = jak_url_input_filter($_GET["lang"]);
$getslide = jak_url_input_filter($_GET["slide"]);

// Chat is not active run the inactive requests
if (isset($_SESSION["inactive"])) unset($_SESSION["inactive"]);
if (isset($_GET["active"]) && $_GET["active"] == "false") {
	$_SESSION["inactive"] = true;
}

// Get the current time stamp once
$currentime = time();

// We have an inactive window only the necessary things needs to be loaded
$row = $jakdb->get("checkstatus", ["convid", "depid", "operatorid", "operator", "newc", "files", "knockknock", "msgdel", "msgedit", "typeo", "denied", "hide", "datac", "initiated"], ["convid" => $_SESSION['convid']]);

if (isset($row) && !empty($row)) {

	// Now check the button id
	$cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$_SESSION['widgetid'].'.php';
	if (file_exists($cachewidget)) include_once $cachewidget;
	$styleconfig = APP_PATH.'package/'.$jakwidget['template'].'/config.php';
	if (file_exists($styleconfig)) include_once $styleconfig;
		
	// Get the knock knock
	if ($row['knockknock'] == 1) $kk = $jkl["g22"];
		
	// Update the status for better user handling
	$jakdb->update("checkstatus", ["statusc" => $currentime, "knockknock" => 0], ["convid" => $row['convid']]);
		
	if ($row['denied'] == 1) {
			
		$jakdb->insert("transcript", [ 
			"name" => $_SESSION['jrc_name'],
			"message" => $jkl['g57'],
			"convid" => $row['convid'],
			"class" => "ended",
			"time" => $jakdb->raw("NOW()")]);
			
		// Destroy the session so it can be opened again
		unset($_SESSION['convid']);
		unset($_SESSION['jrc_userid']);
		unset($_SESSION['jrc_email']);
		unset($_SESSION['chat_wait']);
			
		die(json_encode(array('redirect_c' => str_replace('include/', '', JAK_rewrite::jakParseurl('contact', $getslide, $getlang)))));
			
	}
		
	if ($row['hide'] == 1) {
		
		if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
				
			if ($v["msgtype"] == 4 && $v["lang"] == $lang) {
				
				$phold = array("%operator%","%client%","%email%");
				$replace   = array($row['username'], $_SESSION['jrc_name'], JAK_EMAIL);
				$message = str_replace($phold, $replace, $v["message"]);
					
				// Insert the ended message
				$jakdb->insert("transcript", [ 
					"name" => $_SESSION['jrc_name'],
					"message" => $message,
					"convid" => $row['convid'],
					"class" => "ended",
					"time" => $jakdb->raw("NOW()")]);
					
			}
					
		}
			
		// Redirect to feedback form
		die(json_encode(array('redirect_c' => str_replace('include/', '', JAK_rewrite::jakParseurl('feedback', $getslide, $getlang)))));
			
	}
		
	if (empty($row['operator'])) {
		
		if (isset($_SESSION['chat_wait'])) {
			$answid = $_SESSION['chat_wait'];
		} else {
			$answid = array();
			$_SESSION['chat_wait'] = $answid;
		}
		
		if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
				
			if ($v["msgtype"] == 1 && $v["lang"] == $lang && ($v["department"] == 0 || $v["department"] == $row["depid"]) && (isset($_SESSION['chat_wait']) && !in_array($v["id"], $_SESSION['chat_wait'])) && $row['initiated'] < ($currentime - $v["fireup"])) {
				
				$phold = array("%operator%","%client%","%email%");
				$replace   = array("", $_SESSION['jrc_name'], JAK_EMAIL);
				$message = str_replace($phold, $replace, $v["message"]);
						
				// Insert the ended message
				$jakdb->insert("transcript", [ 
					"name" => $jkl["g56"],
					"message" => $message,
					"convid" => $row['convid'],
					"class" => "notice",
					"time" => $jakdb->raw("NOW()")]);
					
				// Set the session to the id we have insert so we don't get it twice
				$answid[] = $v["id"];
				$_SESSION['chat_wait'] = $answid;
					
				$row['newc'] = 1;
					
			}	
		}
	}
		
	if ($jakwidget['redirect_active'] && (empty($row['operator']) && $row['initiated'] < ($currentime - ($jakwidget['redirect_after'] * 60)))) {
		
		$jakdb->update("sessions", ["status" => 0, "fcontact" => 1, "ended" => $currentime], ["id" => $row['convid']]);
		$jakdb->update("checkstatus", ["hide" => 1], ["convid" => $row['convid']]);
			
		// Insert the ended message
		$jakdb->insert("transcript", [ 
			"name" => $_SESSION['jrc_name'],
			"message" => $jkl['g57'],
			"convid" => $row['convid'],
			"class" => "ended",
			"time" => $jakdb->raw("NOW()")]);
			
		// Destroy the session so it can be opened again
		unset($_SESSION['convid']);
		unset($_SESSION['jrc_userid']);
		unset($_SESSION['jrc_email']);
		unset($_SESSION['chat_wait']);
			
		// leave the slide up open
		$_SESSION['chatbox_redirected'] = 1;
			
		if (filter_var($jakwidget['redirect_url'], FILTER_VALIDATE_URL)) {
			die(json_encode(array('redirect_cu' => $jakwidget['redirect_url'], 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url))));
		} else {
			die(json_encode(array('redirect_c' => str_replace('include/', '', JAK_rewrite::jakParseurl('contact', $getslide, $getlang)))));
		}
			
	}

	// We have an operator
	if (isset($row['operator']) && !empty($row['operator'])) {
		$inchat = true;
		if ($jakgraphix["connected"] == 1 || $getslide == 0) {
			$opern = $row['operator'];
			// Get the operator image
			$oimgdb = $jakdb->get("user", "picture", ["id" => $row['operatorid']]);
			$oimage = $base_url.JAK_FILES_DIRECTORY.$oimgdb;
		} else {
			$opern = sprintf($jkl['g52'], $row['operator']);
		}
	} else {
		// System Avatar
		$oimage = $base_url.'package/'.$jakwidget['template'].'/'.$jakgraphix["system"];
	}

	// We reset the new message alert
	if ($row['newc']) $jakdb->update("checkstatus", ["newc" => 0], ["convid" => $row['convid']]);

	// We reset the delete message
	if ($row['msgdel']) $jakdb->update("checkstatus", ["msgdel" => 0], ["convid" => $row['convid']]);

	// We change the edit message
	if ($row['msgedit']) {
		// include the PHP library (if not autoloaded)
		require('../class/class.emoji.php');
		$editedmsg = $jakdb->get("transcript", ["message", "edited"], ["id" => $row['msgedit']]);

		$showedit = ' | <i class="fa fa-edit"></i> '.JAK_base::jakTimesince($editedmsg["edited"], "", JAK_TIMEFORMAT);
		// Convert urls
		$editedmsg = nl2br(replace_urls($editedmsg["message"]), false);

		// Convert emotji
		$editedmsg = Emojione\Emojione::toImage($editedmsg);
		$jakdb->update("checkstatus", ["msgedit" => 0], ["convid" => $row['convid']]);
	}

	// We have a name/email change
	if ($row['datac']) {
		$rowc = $jakdb->get("sessions", ["name", "email"], ["id" => $row['convid']]);

		// Name change
		$_SESSION['jrc_name'] = $rowc['name'];

		if (filter_var($rowc['email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['jrc_email'] = filter_var($rowc['email'], FILTER_SANITIZE_EMAIL);
		} else {
			unset($_SESSION['jrc_email']);
		}

		$jakdb->update("checkstatus", ["datac" => 0], ["convid" => $row['convid']]);

	}

	// Typing
	$otyping = $oname = '';
	if ($getslide == 0) $oname = $row["operator"];
	if ($row['typeo']) $otyping = str_replace("%s", $oname, $jkl["g37"]);
		
	die(json_encode(array('redirect_c' => false, 'knockknock' => $kk, 'operator' => $opern, 'oimage' => $oimage, 'newmsg' => $row['newc'], 'newmsgtxt' => $jkl['g22'], 'delmsg' => $row['msgdel'], 'msgedit' => $row['msgedit'], 'editmsg' => $editedmsg, 'showedit' => $showedit, 'datac' => $row['datac'], 'files' => $row['files'], 'typing' => $otyping, 'inchat' => $inchat, 'pushnotify' => JAK_CLIENT_PUSH_NOT)));
} else {

	die(json_encode(array('redirect_c' => false, 'knockknock' => 0, 'operator' => 0, 'oimage' => false, 'newmsg' => 0, 'delmsg' => 0, 'msgedit' => 0, 'editmsg' => '', 'showedit' => '', 'datac' => 0, 'files' => 0, 'typing' => 0, 'inchat' => false, 'pushnotify' => JAK_CLIENT_PUSH_NOT)));
}

die("Nothing to do here");
?>