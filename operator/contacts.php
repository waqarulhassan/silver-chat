<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.7.3                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!jak_get_access("off_all", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$errors = array();
$jaktable = 'contacts';
$jaktable1 = 'contactsreply';

$searchstatus = false;

switch ($page1) {
	case 'delete':
	
		if (!JAK_USERID || !JAK_SUPERADMINACCESS) jak_redirect(BASE_URL);

       	$jakdb->delete($jaktable1, ["contactid" => $page2]);
       	$result = $jakdb->delete($jaktable, ["id" => $page2]);
		
		if (!$result) {
   			$_SESSION["infomsg"] = $jkl['i'];
		    jak_redirect($_SESSION['LCRedirect']);
		} else {
       		$_SESSION["successmsg"] = $jkl['g14'];
		    jak_redirect($_SESSION['LCRedirect']);
   		} 
  	break;
  	case 'readmsg':
  	
  		if (is_numeric($page2)) {
  	
	  		$rowi = $jakdb->get($jaktable, ["name", "email", "phone", "message", "referrer", "ip"], ["id" => $page2]);
	  		
	  		// Let's go on with the script
	  		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_email'])) {
	  			$jkp = $_POST;
	  			
	  			// Errors in Array
	  			$errors = array();
	  			  
	  			if ($jkp['email'] == '' || !filter_var($jkp['email'], FILTER_VALIDATE_EMAIL)) {
		        	$errors['email'] = $jkl['e3'];
		    	}
	  			  
	  			if (empty($jkp['subject']) || strlen(trim($jkp['subject'])) <= 2) {
	  			    $errors['subject'] = $jkl['e17'];
	  			}
	  			  
	  			if (empty($jkp['message']) || strlen(trim($jkp['message'])) <= 2) {
	  			    $errors['message'] = $jkl['e1'];
	  			}
	  			  
	  			if (count($errors) > 0) {
	  			  
	  			  /* Outputtng the error messages */
	  			  	if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	  			  	
	  			  		header('Cache-Control: no-cache');
	  			  		die('{"status":0, "errors":'.json_encode($errors).'}');
	  			  		
	  			  	} else {
	  			  		$errors = $errors;
	  			  	}
	  			  	
	  			  } else {
	  			  	
	  			  	$mail = new PHPMailer(); // defaults to using php "mail()"
	  			  	
	  			  	if (JAK_SMTP_MAIL) {
	  			  	
	  			  		$mail->IsSMTP(); // telling the class to use SMTP
	  			  		$mail->Host = JAK_SMTPHOST;
	  			  		$mail->SMTPAuth = (JAK_SMTP_AUTH ? true : false); // enable SMTP authentication
	  			  		$mail->SMTPSecure = JAK_SMTP_PREFIX; // sets the prefix to the server
			        	$mail->SMTPAutoTLS = false;
	  			  		$mail->SMTPKeepAlive = (JAK_SMTP_ALIVE ? true : false); // SMTP connection will not close after each email sent
	  			  		$mail->Port = JAK_SMTPPORT; // set the SMTP port for the GMAIL server
	  			  		$mail->Username = JAK_SMTPUSERNAME; // SMTP account username
	  			  		$mail->Password = JAK_SMTPPASSWORD; // SMTP account password
	  			  		
	  			  	}

	  			  	$mail->SetFrom(JAK_EMAIL);
	  			  	$mail->AddAddress($rowi['email'], $rowi['name']);
	  			  	
	  			  	$mail->Subject = trim($jkp['subject']);
	  			  	$mail->MsgHTML(trim(nl2br($jkp['message'])));
	  			  	
	  			  if ($mail->Send()) {
	  			  
	  			  	// Insert the stuff into the database
	  			  	$jakdb->insert($jaktable1, [ 
	  			  	"contactid" => $page2,
	  			  	"operatorid" => JAK_USERID,
	  			  	"operatorname" => $jakuser->getVar("username"),
	  			  	"subject" => trim($jkp['subject']),
	  			  	"message" => trim($jkp['message']),
	  			  	"sent" => $jakdb->raw("NOW()")]);
	  			  	
	  			  	$jakdb->update($jaktable, ["reply" => 1, "answered" => $jakdb->raw("NOW()")], ["id" => $page2]);
	  			  	
	  			  	// Ajax Request
	  			  	if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	  			  	
	  			  		header('Cache-Control: no-cache');
	  			  		die(json_encode(array('status' => 1, 'html' => $jkl["g14"])));
	  			  		
	  			  	} else {
	  			  	
	  			          jak_redirect($_SERVER['HTTP_REFERER']);
	  			      
	  			      }
	  			  } 
	  			    
	  			}
	  		}
	  		
	  		// Get the messages that have been sent already
			$MESSAGES_ALL = $jakdb->select($jaktable1, ["id", "operatorname", "subject", "message", "sent"], ["contactid" => $page2]);

	  	}
  		
  	    // Call the template
  	    $template = 'readmsg.php';
  	    
  	break;
  	case 'location':
  	
  		if (is_numeric($page2)) {
  			$row = $jakdb->get($jaktable, ["name", "country", "city", "ip", "longitude", "latitude"], ["id" => $page2]);
  		}
  		
  		// Call the template
  		$template = 'location.php';
  	
  	break;
  	case 'truncate':
  	
  		if (!JAK_USERID || !JAK_SUPERADMINACCESS) jak_redirect(BASE_URL);
  		
  		$jakdb->query('TRUNCATE '.JAKDB_PREFIX.$jaktable1);
  	    $result = $jakdb->query('TRUNCATE '.JAKDB_PREFIX.$jaktable);
  	    
	  	if (!$result) {
	  		$_SESSION["infomsg"] = $jkl['i'];
		    jak_redirect(JAK_rewrite::jakParseurl('contacts'));
	  	} else {
	  	    $_SESSION["successmsg"] = $jkl['g14'];
		    jak_redirect(JAK_rewrite::jakParseurl('contacts'));
	  	}
	  	 
  	break;
	default:
		
		// Let's go on with the script
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $jkp = $_POST;
		    
		    if (isset($jkp['action']) && $jkp['action'] == "delete") {
		    
		    if (!JAK_USERID || !JAK_SUPERADMINACCESS) jak_redirect(BASE_URL);
		    
			    if (isset($jkp['jak_delete_contacts'])) {
			    	
			    	$lockuser = $jkp['jak_delete_contacts'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            
			            // Delete	
			            $jakdb->delete($jaktable1, ["contactid" => $locked]);
			            $jakdb->delete($jaktable, ["id" => $locked]);
			        	
			        }
			        
			        $_SESSION["successmsg"] = $jkl['g14'];
		    		jak_redirect($_SESSION['LCRedirect']);
			    }
			
				$_SESSION["errormsg"] = $jkl['i3'];
		    	jak_redirect($_SESSION['LCRedirect']);
		    
		    }
		}
		
		// Reset
		$totalAll = $totalAllc = $bounce_percentage = 0;
		
		// Get the totals
		$totalAll = $jakdb->count($jaktable);
		
		// Get the total again
		$totalAllc = $jakdb->count($jaktable, ["reply" => 1]);
		
		// Get percentage
		$bounce_percentage = 0;
		if ($totalAllc && $totalAll) $bounce_percentage = round($totalAllc / $totalAll * 100, 2, PHP_ROUND_HALF_UP);
		
		// Title and Description
		$SECTION_TITLE = $jkl["m22"];
		$SECTION_DESC = "";
		
		// Include the javascript file for results
		$js_file_footer = 'js_contacts.php';
		
		// Call the template
		$template = 'contacts.php';
}
?>