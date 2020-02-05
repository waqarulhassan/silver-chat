<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.4                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!jak_get_access("maintenance", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) jak_redirect(BASE_URL);

// Flag to select step
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jkp = $_POST;
    
if (isset($jkp['delCache'])) {
	
	// Now let us delete the all the cache file
	$cacheallfiles = APP_PATH.JAK_CACHE_DIRECTORY.'/';
	$msfi = glob($cacheallfiles."*.php");
	if ($msfi) foreach ($msfi as $filen) {
	    if (file_exists($filen)) unlink($filen);
	}

	// Delete the live typing review files
	$msfipr = glob($cacheallfiles."livepreview*.txt");
	if ($msfipr) foreach ($msfipr as $fileprev) {
	    if (file_exists($fileprev)) unlink($fileprev);
	}
	
	// Delete the chat file
	if (file_exists($cacheallfiles.'chats.txt')) unlink($cacheallfiles.'chats.txt');
	
	$_SESSION["successmsg"] = $jkl['g14'];
    jak_redirect($_SESSION['LCRedirect']);

}

if (isset($jkp['delTokens'])) {

	$result = $jakdb->query('TRUNCATE '.JAKDB_PREFIX.'push_notification_devices');
   		
	if (!$result) {
		$_SESSION["infomsg"] = $jkl['i'];
		jak_redirect($_SESSION['LCRedirect']);
	} else {
	    $_SESSION["successmsg"] = $jkl['g14'];
		jak_redirect($_SESSION['LCRedirect']);
	}

}

if (isset($jkp['optimize'])) {
	
	$tables = $jakdb->query('SHOW TABLES')->fetchAll();

    foreach ($tables as $db => $tablename) { 
        $jakdb->query('OPTIMIZE TABLE '.$tablename); 
    }

    $_SESSION["successmsg"] = $jkl['g14'];
    jak_redirect($_SESSION['LCRedirect']);

}

}

// Title and Description
$SECTION_TITLE = $jkl["m19"];
$SECTION_DESC = "";

// Call the template
$template = 'maintenance.php';

?>