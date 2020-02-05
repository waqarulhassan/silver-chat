<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!jak_get_access("logs", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$errors = array();
$jaktable = 'loginlog';

$totalAll = $jakdb->count($jaktable, "id");
 
if ($totalAll != 0) {

	// Paginator
	$logs = new JAK_Paginator;
	$logs->items_total = $totalAll;
	$logs->mid_range = 10;
	$logs->items_per_page = 20;
	$logs->jak_get_page = $page1;
	$logs->jak_where = JAK_rewrite::jakParseurl('logs');
	$logs->paginate();
	$JAK_PAGINATE = $logs->display_pages();
	
	// Ouput all logs, well with paginate of course	
	$JAK_LOGINLOG_ALL = jak_get_page_info($jaktable, $logs->limit);
}
 
 switch ($page1) {
    case 'delete':
        
		$result = $jakdb->delete($jaktable, ["id" => $page2]);

		if (!$result) {
	    	$_SESSION["infomsg"] = $jkl['i'];
			jak_redirect($_SESSION['LCRedirect']);
		} else {
	        $_SESSION["successmsg"] = $jkl['g14'];
		    jak_redirect($_SESSION['LCRedirect']);
	    }
	    
   	break;
   	case 'truncate':
   	    
   	    $result = $jakdb->query('TRUNCATE '.JAKDB_PREFIX.$jaktable);
   		
	   	if (!$result) {
	    	$_SESSION["infomsg"] = $jkl['i'];
			jak_redirect($_SESSION['LCRedirect']);
		} else {
	        $_SESSION["successmsg"] = $jkl['g14'];
		    jak_redirect($_SESSION['LCRedirect']);
	    }
	   	
   	break;
	default:

		// Let's go on with the script
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$jkp = $_POST;

			if (isset($jkp['action']) && $jkp['action'] == "delete") {

				if (isset($jkp['jak_delete_all'])) {
			    
				    $lockuser = $jkp['jak_delete_all'];
				
				    for ($i = 0; $i < count($lockuser); $i++) {
				        $locked = $lockuser[$i];
				       	$result = $jakdb->delete($jaktable, ["id" => $locked]);
				    }
				        
				    $_SESSION["successmsg"] = $jkl['g14'];
					jak_redirect($_SESSION['LCRedirect']);
				        
				}
				    
				$_SESSION["infomsg"] = $jkl['i'];
				jak_redirect($_SESSION['LCRedirect']);

			}

			$_SESSION["infomsg"] = $jkl['i'];
			jak_redirect($_SESSION['LCRedirect']);
		    
		 }
	
		// Title and Description
		$SECTION_TITLE = $jkl["m6"];
		$SECTION_DESC = "";
		
		// Include the javascript file for results
		$js_file_footer = 'js_pages.php';
		
		// Call the template
		$template = 'logs.php';
	}
?>