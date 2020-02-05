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
if (!jak_get_access("ochat", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$errors = array();
$jaktable = 'operatorchat';

switch ($page1) {
	case 'delete':
	
		if (!jak_get_access("ochat_all", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) jak_redirect(BASE_URL);
   		
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
  	
  		if (!JAK_USERID || !JAK_SUPERADMINACCESS) jak_redirect(BASE_URL);
  	
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
		    
		    if (!jak_get_access("ochat_all", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) jak_redirect(BASE_URL);
		    
			    if (isset($jkp['delete'])) {
			    
				    if (isset($jkp['ls_delete_chats'])) {
				    	
				    	$lockuser = $jkp['ls_delete_chats'];
				
				        for ($i = 0; $i < count($lockuser); $i++) {
				            $locked = $lockuser[$i];
				            $result = $jakdb->delete($jaktable, ["id" => $locked]);
				        }
				        
				        $_SESSION["successmsg"] = $jkl['g14'];
		    			jak_redirect($_SESSION['LCRedirect']);
				        
				    }
		   		}

		   	$_SESSION["infomsg"] = $jkl['i'];
		    jak_redirect($_SESSION['LCRedirect']);
		}
		
		// Chat history

		if (jak_get_access("ochat_all", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) {
  	 		$totalAll = $jakdb->count($jaktable);
  	 	} else {
  	 		$totalAll = $jakdb->count($jaktable, ["OR" => ["fromid" => JAK_USERID, "toid" => JAK_USERID]]);
  	 	}
  	 	 
  	 	if ($totalAll != 0) {
  	 	
  	 		// Paginator
  	 		$chats = new JAK_Paginator;
  	 		$chats->items_total = $totalAll;
  	 		$chats->mid_range = 10;
  	 		$chats->items_per_page = 20;
  	 		$chats->jak_get_page = $page1;
  	 		$chats->jak_where = JAK_rewrite::jakParseurl('chats');
  	 		$chats->paginate();
  	 		$JAK_PAGINATE = $chats->display_pages();
  	 	}

  	 	$CHATS_ALLC = $jakdb->select("operatorchat", ["[>]user" => ["fromid" => "id"], "[>]user(to)" => ["toid" => "id"]], ["operatorchat.id", "operatorchat.fromid", "operatorchat.toid", "operatorchat.message", "operatorchat.sent", "user.username", "to.username(touser)"], ["LIMIT" => $chats->limit]);
		
		// Title and Description
		$SECTION_TITLE = $jkl["m14"];
		$SECTION_DESC = "";
		
		// Include the javascript file for results
		$js_file_footer = 'js_pages.php';
		
		// Call the template
		$template = 'chats.php';
}
?>