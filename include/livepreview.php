<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1980 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.4                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2017 jakweb All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../config.php')) die('ajax/[available.php] config.php not exist');
require_once '../config.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !isset($_SESSION['jrc_userid'])) die("Nothing to see here");

if (isset($_POST['conv']) && is_numeric($_POST['conv'])) {

	// Insert the preview message into the text file
	$livepreviewfile = APP_PATH.JAK_CACHE_DIRECTORY.'/livepreview'.$_SESSION['convid'].'.txt';

	if (isset($_POST['text']) && empty($_POST['text'])) {

		if (file_exists($livepreviewfile)) {
			// Finally remove the file and start fresh
			unlink($livepreviewfile);
		}

		die(json_encode(array("status" => 0)));

	} else {

		// Filter the message
		$message = html_entity_decode($_POST['text']);
		$message = strip_tags($message);
		$message = filter_var($message, FILTER_SANITIZE_STRING);
		$message = trim($message);

		// Let's inform others that a new client has entered the chat
		file_put_contents($livepreviewfile, $message);

		die(json_encode(array("status" => 1)));

	}
}
die(json_encode(array("status" => 0)));
?>