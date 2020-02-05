<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../config.php')) die('include/[typing.php] config.php not exist');
require_once '../config.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !isset($_SESSION['jrc_userid'])) die("Nothing to see here");

if (isset($_POST['conv']) && is_numeric($_POST['conv'])) {

if (isset($_POST['status']) && $_POST['status'] == 1) {
	$result = $jakdb->update("checkstatus", ["typec" => 1], ["convid" => $_POST['conv']]);
} else {
	$result = $jakdb->update("checkstatus", ["typec" => 0], ["convid" => $_POST['conv']]);
}

if ($result) {
	die(json_encode(array('tid' => 1)));
}

} else {
	die(json_encode(array('tid' => 0)));
}
?>