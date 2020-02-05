<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.3.1                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Found on http://maxmorgandesign.com/simple_php_auto_update_system/ modified for Live Chat

// If not super admin...
if (!JAK_SUPERADMINACCESS) die();

$found = $updated = false;

if (isset($page1) && $page1 == "check") {

ini_set('max_execution_time',60);

function file_get_contents_curl($url) {
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_URL, $url);
	
	$data = curl_exec($ch);
	curl_close($ch);
	
	return $data;
}

// Check For An Update first with php
$getVersions = @file_get_contents('https://up5.jakweb.ch/lc3/lr.php');
// PHP does not work, let's try with cUrl
if (!$getVersions && extension_loaded('curl')) $getVersions = file_get_contents_curl('https://up5.jakweb.ch/lc3/lr.php');
// Update is impossible to get, abort.
if (!$getVersions) die('<div class="alert alert-danger">Cannot access the release file. Make sure either file_get_contents() or cUrl is available.</div>');

if ($getVersions != '') {
	echo '<p>Reading Current Releases List</p>';
	$versionList = explode("\n", $getVersions);
	
	foreach ($versionList as $aV) {
	
		if ($aV > JAK_VERSION) {
			echo '<p>Found new update: '.$aV.'</p>';
			$found = true;
			
			$dlpackage = str_replace(".", "_", $aV);
			
			// Download the file if we have to
			if (!is_file(APP_PATH.JAK_FILES_DIRECTORY.'/updates/upd3_'.$dlpackage.'.zip' )) {
				echo '<p>Downloading New Update</p>';
				$newUpdate = @file_get_contents('https://up5.jakweb.ch/lc3/upd3_'.$dlpackage.'.zip');
				// PHP does not work, let's try with cUrl
				if (!$newUpdate && extension_loaded('curl')) $getVersions = file_get_contents_curl('https://up5.jakweb.ch/lc3/upd3_'.$dlpackage.'.zip');
				// Update is impossible to get, abort.
				if (!$newUpdate) die('<div class="alert alert-danger">Cannot access the latest update.</div>');
				if (!is_dir(APP_PATH.JAK_FILES_DIRECTORY.'/updates/')) mkdir(APP_PATH.JAK_FILES_DIRECTORY.'/updates/');
				$dlHandler = fopen(APP_PATH.JAK_FILES_DIRECTORY.'/updates/upd3_'.$dlpackage.'.zip', 'w');
				if (!fwrite($dlHandler, $newUpdate)) die('<div class="alert alert-danger">Cannot save the new update. Operation aborted.</div>');
				fclose($dlHandler);
				echo '<p>Update downloaded and saved</p>';
			} else {
				echo '<p>Update already downloaded.</p>';
			}
			
			if (isset($page2) && $page2 == "run") {
				// Open The File And Do Stuff
				$zipHandle = zip_open(APP_PATH.JAK_FILES_DIRECTORY.'/updates/upd3_'.$dlpackage.'.zip');
				echo '<ul>';
				while ($aF = zip_read($zipHandle)) {
				
					$thisFileName = zip_entry_name($aF);
					$thisFileDir = dirname($thisFileName);
					
					// Continue if its not a file
					if (substr($thisFileName,-1,1) == '/') continue;
	
					// Make the directory if we need to...
					if (!is_dir(APP_PATH.$thisFileDir)) {
						 mkdir(APP_PATH.$thisFileDir, 0755, true);
						 echo '<li>Created Directory '.$thisFileDir.'</li>';
					}
					
					// Overwrite the file
					if (!is_dir(APP_PATH.$thisFileName)) {
						echo '<li>'.$thisFileName.'...........';
						$contents = zip_entry_read($aF, zip_entry_filesize($aF));
						$contents = str_replace("\r\n", "\n", $contents);
						$updateThis = '';
						
						// If we need to run commands, then do it.
						if ($thisFileName == 'update.php') {
							$upgradeExec = fopen('update.php','w');
							fwrite($upgradeExec, $contents);
							fclose($upgradeExec);
							include('update.php');
							unlink('update.php');
							echo' Database updated</li>';
						} else {
							$updateThis = fopen(APP_PATH.$thisFileName, 'w');
							fwrite($updateThis, $contents);
							fclose($updateThis);
							unset($contents);
							echo' Updated</li>';
						}
					}
				}
				echo '</ul>';
				$updated = true;
				unlink(APP_PATH.JAK_FILES_DIRECTORY.'/updates/upd3_'.$dlpackage.'.zip');
			} else {
				echo '<p>Update ready. <a href="'.str_replace('include/', '', JAK_rewrite::jakParseurl('maintenance', 'check', 'run')).'">&raquo; Install Now?</a></p>';
			}
			break;
		}
	}
	
	if ($updated == true) {
		echo '<p class="success">&raquo; Live Chat 3 updated to '.$aV.'</p>';
	} elseif ($found != true) {
		echo '<p>&raquo; There is no update available at this moment.</p>';
	}
	
} else {
	echo '<p>Could not find latest releases.</p>';
}

} else {
	echo '<a href="'.str_replace('include/', '', JAK_rewrite::jakParseurl('maintenance', 'check')).'" class="btn btn-default">'.$jkl["g235"].'</a>';
}
?>