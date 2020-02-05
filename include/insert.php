<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1980 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.6.2                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 jakweb All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../config.php')) die('ajax/[available.php] config.php not exist');
require_once '../config.php';

// include the PHP library (if not autoloaded)
require('../class/class.emoji.php');

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !isset($_SESSION['jrc_userid'])) die("Nothing to see here");

// Language file
$lang = JAK_LANG;
if (isset($_SESSION['widgetlang']) && !empty($_SESSION['widgetlang'])) $lang = $_SESSION['widgetlang'];

// Import the language file
if ($lang && file_exists(APP_PATH.'lang/'.strtolower($lang).'.php')) {
	include_once(APP_PATH.'lang/'.strtolower($lang).'.php');
} else {
	include_once(APP_PATH.'lang/'.JAK_LANG.'.php');
}

if (!$_POST['msg']) die(json_encode(array("status" => 0, "html" => $jkl['e2'])));

// Now check the button id
$cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$_SESSION['widgetid'].'.php';
if (file_exists($cachewidget)) include_once $cachewidget;

// Get the absolute url for the image
$ava_url = str_replace('include/', '', BASE_URL);

// Set the load chat design var to true
$lcd = true;
$styleconfig = APP_PATH.'package/'.$jakwidget['template'].'/config.php';

if (is_numeric($_POST['conv'])) {

$row = $jakdb->get("checkstatus", ["convid", "depid", "operatorid", "operator", "pusho", "hide", "statuso", "initiated"], ["convid" => $_SESSION['convid']]);

if (isset($row) && !empty($row)) {
		
		$message = html_entity_decode($_POST['msg']);
		$message = strip_tags($message);
		$message = filter_var($message, FILTER_SANITIZE_STRING);
		$message = trim($message);
		
		if (isset($message) && !empty($message) && !$row['hide']) {

			// Remove the file from the cache directory
			$livepreviewfile = APP_PATH.JAK_CACHE_DIRECTORY.'/livepreview'.$row['convid'].'.txt';

			if (file_exists($livepreviewfile)) {
				// Finally remove the file and start fresh
				unlink($livepreviewfile);
			}

			// Convert urls
			$messagedisp = nl2br(replace_urls($message));

			// Convert emotji
			$messagedisp = Emojione\Emojione::toImage($messagedisp);

			// Check for duplicate messages
			$duplmsg = '';
			if (isset($_SESSION["lastmsg"]) && $_SESSION["lastmsg"] == $message) {

				if (file_exists($styleconfig)) include $styleconfig;

				$duplmsg = $jakgraphix["chatdublic"];

				// unset the combine session
				unset($_SESSION["msgsmin"]);

				die(json_encode(array("status" => 1, "html" => $duplmsg)));

			}

			// the last message in a session
			$_SESSION["lastmsg"] = $message;

			$jakdb->insert("transcript", [ 
				"name" => $_SESSION['jrc_name'],
				"message" => $message,
				"user" => $_SESSION['jrc_userid'],
				"convid" => $row['convid'],
				"sentstatus" => 1,
				"class" => "user",
				"time" => $jakdb->raw("NOW()")]);

			$lastid = $jakdb->id();
			$_SESSION["lastid"] = $lastid;

			$jakdb->update("checkstatus", ["newo" => 1, "typec" => 0], ["convid" => $row['convid']]);

			// New Bot, if no one is chatting, bot message available, department match and message the same as question
			$botanswer = $answer = $answerdisp = '';
			if (empty($row["operator"]) && !empty($JAK_BOT_ANSWER)) {
				
				foreach ($JAK_BOT_ANSWER as $v) {

					if (($v['widgetids'] == 0 || in_array($_SESSION['widgetid'], explode(",", $v['widgetids']))) && ($v["depid"] == 0 || $v["depid"] == $row["depid"]) && $v["lang"] == $lang) {

						$question = strtolower($v["question"]);

						if (strpos($question, ",") !== false ) {
							$question = explode(",", $question);

							// We do not have to type the exact word, it will pick the correct word in the string
							if (isset($question) && is_array($question)) foreach ($question as $q) {

								if (strtolower($message) == $q) {
									$answer = strip_tags($v["answer"]);
									break;
								}
							}

						} else {

							// Check if we have a word only
							if (strtolower($message) == $question) {

								$answer = strip_tags($v["answer"]);
							}

						}

					}

				}

				// Fix for wildcard bot answer
				if (empty($answer)) foreach ($JAK_BOT_ANSWER as $v) {

					if (($v['widgetids'] == 0 || in_array($_SESSION['widgetid'], explode(",", $v['widgetids']))) && ($v["depid"] == 0 || $v["depid"] == $row["depid"]) && $v["lang"] == $lang) {

						$question = strtolower($v["question"]);

						// Check if we have a wildcard
						if (empty($answer) && $question == "*") {

							$answer = strip_tags($v["answer"]);

						}

					}

				}

				// Proceed with displaying the bot answer
				if (!empty($answer)) {

					$answer = filter_var($answer, FILTER_SANITIZE_STRING);

					// Place holder converters
					$phold = array("%client%","%email%");
					$replace   = array($_SESSION['jrc_name'], JAK_EMAIL);
					$answer = str_replace($phold, $replace, $answer);

					// Url converter
					$answerdisp = nl2br(replace_urls($answer));

					// Convert emotji
					$answerdisp = Emojione\Emojione::toImage($answerdisp);

					$jakdb->insert("transcript", [ 
						"name" => $jkl["g74"],
						"message" => $answer,
						"convid" => $row['convid'],
						"class" => "bot",
						"time" => $jakdb->raw("NOW()")]);

					$lastid = $jakdb->id();
					$_SESSION["lastid"] = $lastid;

					if (file_exists($styleconfig)) include $styleconfig;

					// Load the style from the package config file
					$botanswer = $jakgraphix["chatbot"];

				}

			}

			// Time now
			$timenow = time();
			// Nice format
			$nicetime = date('H:i:s', floor($timenow/60)*60);
			$chatmsg = '';
			if (file_exists($styleconfig)) include $styleconfig;

			// Now let's check if we have a message within the same minute.
			if (isset($_SESSION["msgsmin"]) && $_SESSION["msgsmin"] == $nicetime && !empty($row["operator"])) {

				// Now display the message
				$chatmsg = $jakgraphix["chatinsertsingle"];

				$selfmsg = true;

			} else {
			
				// Now display the message
				$chatmsg = $jakgraphix["chatinsert"];

				$selfmsg = false;

			}

			// The last time
			if (!isset($_SESSION["msgsmin"]) || (isset($_SESSION["msgsmin"]) && $_SESSION["msgsmin"] != $nicetime)) $_SESSION["msgsmin"] = $nicetime;

			// Finally let's inform the operator if set and time is older then the set minutes
			if ($row['pusho'] && (time() - $row['statuso']) > JAK_PUSH_REMINDER) {

				$jakdb->update("checkstatus", ["statuso" => time()], ["convid" => $row['convid']]);
				$pushorow = $jakdb->get("user", ["pusho_tok", "pusho_key", "push_notifications"], ["id" => $row['operatorid']]);

				// Let's send some notifications
				if ($pushorow["push_notifications"]) {

					$url = JAK_rewrite::jakParseurl(JAK_OPERATOR_LOC, 'live', $row['convid']);

					jak_send_notifications($row["operatorid"], $row['convid'], JAK_TITLE.' '.$jkl['g22'], $messagedisp, $url, $pushorow["push_notifications"], 0, "", $pushorow["pusho_tok"], $pushorow["pusho_key"], "");
				}
			}
			
			die(json_encode(array("status" => 1, "html" => $chatmsg, "selfmsg" => $selfmsg, 'lastid' => $lastid)));
		
		// Chat is hidden, no more messages and end the session
		} elseif ($row['hide']) {
		
			$message = '';
		
			if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
				
				if ($v["msgtype"] == 4 && $v["lang"] == $lang) {
				
					$phold = array("%operator%","%client%","%email%");
					$replace   = array($row['operator'], $_SESSION['jrc_name'], JAK_EMAIL);
					$message = str_replace($phold, $replace, $v["message"]);

					$jakdb->insert("transcript", [ 
						"name" => $jkl["g56"],
						"message" => $message,
						"convid" => $row['convid'],
						"class" => "notice",
						"time" => $jakdb->raw("NOW()")]);

					$lastid = $jakdb->id();
					$_SESSION["lastid"] = $lastid;
					
				}
					
			}

			$jakdb->update("sessions", ["ended" => 0, "status" => 1], ["id" => $row['convid']]);
			$jakdb->update("checkstatus", ["newo" => 1, "typec" => 0], ["convid" => $row['convid']]);

			if (file_exists($styleconfig)) include $styleconfig;
			
			// Load the style from the package config file
			$chatmsg = $jakgraphix["chatinsertended"];

			
			die(json_encode(array("status" => 1, "html" => $chatmsg, 'lastid' => $lastid)));
			
		} else {
		
			die(json_encode(array("status" => 0, "html" => "")));
		}
		
		
	}
}
?>