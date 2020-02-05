<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1980 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8.1                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../config.php')) die('ajax/[retrieve.php] config.php not exist');
require_once '../config.php';

// include the PHP library (if not autoloaded)
require('../class/class.emoji.php');

// Language file
$lang = JAK_LANG;
if (isset($_SESSION['widgetlang']) && !empty($_SESSION['widgetlang'])) $lang = $_SESSION['widgetlang'];

// Import the language file
if ($lang && file_exists(APP_PATH.'lang/'.strtolower($lang).'.php')) {
	include_once(APP_PATH.'lang/'.strtolower($lang).'.php');
} else {
	include_once(APP_PATH.'lang/'.JAK_LANG.'.php');
}

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !isset($_SESSION['jrc_userid'])) die(json_encode(array("status" => 0, "html" => "")));

// Now check the button id
$cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$_SESSION['widgetid'].'.php';
if (file_exists($cachewidget)) include_once $cachewidget;

$lcdnm = true;
$styleconfig = APP_PATH.'package/'.$jakwidget['template'].'/config.php';

// Get the absolute url for the image
$ava_url = str_replace('include/', '', BASE_URL);

if (isset($_GET['convid']) && is_numeric($_GET['convid']) && $_SESSION['convid'] == $_GET['convid'] && $_SESSION['jrc_userid'] == $_GET['userid']) {

	// Reset vars
	$chat = $botanswer = '';
	$lastid = 0;
	$loadsingle = false;

	if (isset($_GET['lastid']) && is_numeric($_GET['lastid']) && $_GET['lastid'] != 0) {
		if ($_GET['lastid'] != $_SESSION["lastid"]) {
			$lastid = $_GET['lastid'];
		} else {
			$lastid = $_SESSION["lastid"];
		}
		$loadsingle = true;
	}

	$result = $jakdb->select("transcript", ["[>]user" => ["operatorid" => "id"]], ["transcript.id", "transcript.name", "transcript.message", "transcript.operatorid", "transcript.editoid", "transcript.edited", "transcript.quoted", "transcript.time", "transcript.class", "user.picture"], ["OR #Extra clause" => [
		"AND #normal" => [
			"transcript.convid" => $_GET['convid'], 
			"transcript.id[>]" => $lastid,
			"transcript.plevel" => 1
		],
		"AND #not read" => [
			"transcript.convid" => $_GET['convid'],
			"transcript.sentstatus" => 0,
			"transcript.plevel" => 1
		]
	], "ORDER" => ["transcript.id" => "ASC"]]);

	if (isset($result) && !empty($result)) {

		foreach ($result as $row) {

			// On which class to show a system image
			$systemimg = array("bot", "notice", "url", "ended");

			// Get the current class
			$chatclass = $row["class"];
			
			$oimage = $ava_url.$_SESSION['jrc_avatar'];
			if ($row["picture"] && $row["operatorid"]) $oimage = $ava_url.JAK_FILES_DIRECTORY.$row["picture"];
			if (in_array($chatclass, $systemimg)) $oimage = $ava_url.'package/'.$jakwidget['template'].'/avatar/system.jpg';

			// We convert the br
			$message = nl2br($row['message'], false);

			// we have file
			if ($chatclass == "download" && file_exists(APP_PATH.JAK_FILES_DIRECTORY.$message)) {

				if ($row['operatorid'] == 0) $chatclass = "user";

				// We have an image
		    	if (getimagesize(APP_PATH.JAK_FILES_DIRECTORY.$message)) {
		    		$message = '<a href="'.$ava_url.JAK_FILES_DIRECTORY.$message.'" data-toggle="lightbox"><img src="'.$ava_url.JAK_FILES_DIRECTORY.$message.'" class="img-thumbnail img-fluid chat-img" alt="chat-img"></a>';
		    	} else {
		    		$message = '<a href="'.$ava_url.JAK_FILES_DIRECTORY.$message.'" target="_blank">'.basename($message).'</a>';
		    	}
			} else {
				// We convert the urls
				$message = replace_urls($message);
			}

			// Convert emotji
			$message = Emojione\Emojione::toImage($message);

			// Get the quote msg
			$quotemsg = '';
			if ($row['quoted']) {
				$quotemsg = $jakdb->get("transcript", "message", ["id" => $row["quoted"]]);
				// Convert urls
				$quotemsg = nl2br(replace_urls($quotemsg), false);

				// Convert emotji
				$quotemsg = Emojione\Emojione::toImage($quotemsg);

			}

			// Set the load chat design var to true
			if (file_exists($styleconfig)) include $styleconfig;

			// Now load the operator message
			$chat .= $jakgraphix["chatdesign"];
			
			// Set the session for the redirect
			$redirecturl = "";
			if ($row["class"] == "url") {
				// Update the url to visited
            	$jakdb->update("transcript", ["class" => "urlvisited", "plevel" => 2], ["id" => $row["id"]]);
				$redirecturl = $row['message'];
			}

			// finally update the entry to read
			$jakdb->update("transcript", ["sentstatus" => 1], ["id" => $row["id"]]);

			// Get the last id
			$lastid = $row["id"];
			$_SESSION["lastid"] = $lastid;

			// unset the combine session for the client
			unset($_SESSION["msgsmin"]);

		}
		
		die(json_encode(array("status" => 1, "html" => $chat, "lastid" => $lastid, "redirecturl" => $redirecturl, 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $ava_url))));
	}
}

die(json_encode(array("status" => 0)));
?>