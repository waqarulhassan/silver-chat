<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.7                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get the data per array for page,newsletter with limit
function jak_get_page_info($table,$limit = "") 
{
	global $jakdb;
	if (!empty($limit)) {
    	$datatable = $jakdb->select($table, "*", ["ORDER" => ["id" => "DESC"], "LIMIT" => $limit]);
    } else {
    	$datatable = $jakdb->select($table, "*", ["ORDER" => ["id" => "DESC"]]);
    }
        
    if (!empty($datatable)) return $datatable;
}

// Search for lang files in the admin folder, only choose .ini files.
function jak_get_lang_files() {

	// Get the language folder
	$langdir = '../lang/';
	
	if ($handle = opendir($langdir)) {
	
	    /* This is the correct way to loop over the directory. */
	    while (false !== ($file = readdir($handle))) {
	    $showlang = substr($file, strrpos($file, '.'));
	    if ($file != '.' && $file != '..' && $showlang == '.php') {
	    
	    	$getlang[] = substr($file, 0, -4);
	    
	    }
	    }
		return $getlang;
	    closedir($handle);
	}
}

// Search for lang files in the admin folder, only choose .ini files.
function jak_get_chat_packages() {

	// Get the language folder
	$packdir = '../'.'package/';

	return array_diff(scandir($packdir), array('..', '.', 'index.html', '.DS_Store'));
}

// Search for lang files in the admin folder, only choose .ini files.
function jak_get_sound_files() {

	$getsound = array();

	global $jakdb;
	// Get the sounds from the installed packages
	$packsound = $jakdb->select("chatwidget", "template", ["GROUP" => "template"]);

    if (isset($packsound) && !empty($packsound)) {

        foreach ($packsound as $v) {

        	$packagef = 'package/'.$v.'/';
			if (file_exists('../'.$packagef.'config.php')) {

				include_once '../'.$packagef.'config.php';

	        	if (isset($jakgraphix["sound"]) && !empty($jakgraphix["sound"])) {

	        		// Get the general sounds
					$dynsound = '../'.$packagef.$jakgraphix["sound"];

					if ($dynhandle = opendir($dynsound)) {
					
					    /* This is the correct way to loop over the directory. */
					    while (false !== ($dynfile = readdir($dynhandle))) {
					    	$dynshowsound = substr($dynfile, strrpos($dynfile, '.'));
						    if ($dynfile != '.' && $dynfile != '..' && $dynshowsound == '.mp3') {
						    
						    	$getsound[] = $packagef.$jakgraphix["sound"].substr($dynfile, 0, -4);
						    
						    }
					    }
					    closedir($dynhandle);
					}
	        	}
	        }
        }
    }
	
	// Get the general sounds
	$soundir = '../sound/';

	if ($handle = opendir($soundir)) {
	
	    /* This is the correct way to loop over the directory. */
	    while (false !== ($file = readdir($handle))) {
		    $showsound = substr($file, strrpos($file, '.'));
		    if ($file != '.' && $file != '..' && $showsound == '.mp3') {
		    
		    	$getsound[] = 'sound/'.substr($file, 0, -4);
		    
		    }
	    }
	    closedir($handle);
		return $getsound;
	    
	}
}

// Get all user out the database limited with the paginator
function jak_get_user_all($table, $userid, $supero) {

	global $jakdb;
	if ($userid && $supero) {
		$datausr = $jakdb->select($table, "*", ["OR" => ["id" => $userid, "id[!]" => $supero]]);
	} elseif ($userid) {
		$datausr = $jakdb->select($table, "*", ["id" => $userid]);
	} elseif ($supero) {
		$datausr = $jakdb->select($table, "*", ["id[!]" => $supero]);
	} else {
		$datausr = $jakdb->select($table, "*");
	}
	
    return $datausr;
}

// Check if user exist and it is possible to delete ## (config.php)
function jak_user_exist_deletable($id) {
	$useridarray = explode(',', JAK_SUPERADMIN);
	// check if userid is protected in the config.php
	if (in_array($id, $useridarray)) {
	    return false;
	} else {
		global $jakdb;
	    if ($jakdb->has("user", ["id" => $id])) return true;
	}
	return false;
}

// Check if row exist with id
function jak_field_not_exist_id($lsvar,$id,$table,$lsvar3)
{
		global $jakdb;
        if ($jakdb->has($table, ["AND" => ["id[!]" => $id, $lsvar3 => $lsvar]])) {
        return true;
}
}

// Get files
function jak_get_files($directory,$exempt = array('.','..','.ds_store','.svn','js','css','img','_cache','index.html'),&$files = array()) { 
	
	if ($handle = opendir($directory)) {
		$getlang = array();
	    /* This is the correct way to loop over the directory. */
	    while (false !== ($file = readdir($handle))) {
	    if (!in_array($file, $exempt)) {
	    
	    	$getlang[] = $file;
	    
	    }
	    }
		if (!empty($getlang)) return $getlang;
	    closedir($handle);
	}
}

function secondsToTime($seconds,$time) {
	$singletime = explode(",", $time);
	if (is_numeric($seconds)) {
    	$dtF = new DateTime("@0");
    	$dtT = new DateTime("@$seconds");
    	return $dtF->diff($dtT)->format('%a '.$singletime[0].', %h '.$singletime[1].', %i '.$singletime[2].' '.$singletime[4].' %s '.$singletime[3]);
    } else {
    	return '0 '.$singletime[0].', 0 '.$singletime[1].', 0 '.$singletime[2].' '.$singletime[4].' 0 '.$singletime[3];
    }
}
?>