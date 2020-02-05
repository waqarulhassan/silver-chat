<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// prevent direct php access
define('JAK_ADMIN_PREVENT_ACCESS', 1);

if (!file_exists('config.php')) die('[index.php] config.php not found');
require_once 'config.php';

$page = ($tempp ? jak_url_input_filter($tempp) : '');
$page1 = ($tempp1 ? jak_url_input_filter($tempp1) : '');
$page2 = ($tempp2 ? jak_url_input_filter($tempp2) : '');
$page3 = ($tempp3 ? jak_url_input_filter($tempp3) : '');
$page4 = ($tempp4 ? jak_url_input_filter($tempp4) : '');
$page5 = ($tempp5 ? jak_url_input_filter($tempp5) : '');
$page6 = ($tempp6 ? jak_url_input_filter($tempp6) : '');

// Reset vars
$js_file_footer = $JAK_PAGINATE = false;
// Reset Title and Description
$SECTION_TITLE = $SECTION_DESC = '';
// We do not load the user online list
$JAK_UONLINE = 0;

// Only the SuperAdmin in the config file see everything
if ($jakuser->jakSuperadminaccess(JAK_USERID)) {
	define('JAK_SUPERADMINACCESS', true);
} else {
	define('JAK_SUPERADMINACCESS', false);
}

// Get the redirect into a sessions for better login handler
if ($page && $page != '404' && $page != 'js' && !in_array($page1, array("delete","deletef","deletefo","lock","truncate","stats"))) $_SESSION['LCRedirect'] = $_SERVER['REQUEST_URI'];

// Define for template the real request
$realrequest = substr($getURL->jakRealrequest(), 1);
define('JAK_PARSE_REQUEST', $realrequest);

// We need the template folder, title, author and lang as template variable
define('JAK_PAGINATE_ADMIN', 1);

// Get the language for the operator
$USER_LANGUAGE = JAK_LANG;
if (JAK_USERID && !empty($jakuser->getVar("language"))) $USER_LANGUAGE = strtolower($jakuser->getVar("language"));

// Import the language file
if ($USER_LANGUAGE && file_exists(APP_PATH.JAK_OPERATOR_LOC.'/lang/'.$USER_LANGUAGE.'.php')) {
    include_once(APP_PATH.JAK_OPERATOR_LOC.'/lang/'.$USER_LANGUAGE.'.php');
    $_SESSION['jak_lcp_lang'] = $USER_LANGUAGE;
} else {
    include_once(APP_PATH.JAK_OPERATOR_LOC.'/lang/'.JAK_LANG.'.php');
}

// First check if the user is logged in
if (JAK_USERID) {

define('JAK_ADMINACCESS', true);

// Get the name from the user for the welcome message
$JAK_WELCOME_NAME = $jakuser->getVar("name");
// Get the department(s)
$JAK_USR_DEPARTMENTS = $jakuser->getVar("departments");
$_SESSION['usr_department'] = $JAK_USR_DEPARTMENTS;

if ($JAK_USR_DEPARTMENTS == 0) { 
	$JAK_USR_DEPARTMENTS = $jkl['g105'];
} else {
	
	if (is_numeric($JAK_USR_DEPARTMENTS)) {
        $deplist = $jakdb->select("departments", "title", ["AND" => ["id" => $JAK_USR_DEPARTMENTS, "active" => 1], "ORDER" => ["dorder" => "ASC"]]);
	} else {
        $deplist = $jakdb->select("departments", "title", ["AND" => ["id" => [$JAK_USR_DEPARTMENTS], "active" => 1], "ORDER" => ["dorder" => "ASC"]]);
	}
	
	if (!empty($deplist)) {
		$JAK_USR_DEPARTMENTS = join(", ", $deplist);
	} else {
		$JAK_USR_DEPARTMENTS = $jkl['g105'];
	}
	
}

} else {
	define('JAK_ADMINACCESS', false);
}

// Finally sanitize all inputs
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

// When there is a post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // End the conversation if whish so
    if (isset($_POST['delete_conv'])) {

    	// check to see if conversation has to be stored
    	$row = $jakdb->get("sessions", ["id", "name", "email"], ["id" => $_POST['id']]);

        $jakdb->insert("transcript", [ 
            "name" => $jakuser->getVar("name"),
            "message" => $jkl['g63'],
            "user" => $jakuser->getVar("id").'::'.$jakuser->getVar("username"),
            "operatorid" => $jakuser->getVar("id"),
            "convid" => $row['id'],
            "class" => "notice",
            "time" => $jakdb->raw("NOW()")]);

        // Update the session table and sho the message to the user
        $jakdb->update("sessions", ["status" => 0, "ended" => time()], ["id" => $row['id']]);
        $jakdb->update("checkstatus", ["newc" => 1, "typeo" => 0, "newo" => 0, "hide" => 2, "statuso" => time()], ["convid" => $row['id']]);

        // Remove the file from the cache directory
        $livepreviewfile = APP_PATH.JAK_CACHE_DIRECTORY.'/livepreview'.$row['id'].'.txt';

        if (file_exists($livepreviewfile)) {
            // Finally remove the file and start fresh
            unlink($livepreviewfile);
        }
    	
    	jak_redirect(BASE_URL);
    }

    // transfer customer
    if (isset($_POST['transfer_customer']) && is_numeric($_POST['operator']) && is_numeric($_POST['cid'])) {

        if (isset($_POST['transfermsg']) && !empty($_POST['transfermsg'])) {

        	// check to see if conversation has to be stored
            $newop = $jakdb->get("user", ["id", "available", "username", "email", "name", "emailnot", "hours_array", "pusho_tok", "pusho_key", "phonenumber", "push_notifications"], ["AND" => ["id" => $_POST['operator'], "access" => 1]]);

        	$msg = strip_tags($_POST['transfermsg']);

            $jakdb->insert("transfer", ["convid" => $_POST['cid'], "fromoid" => $jakuser->getVar("id"), "fromname" => $jakuser->getVar("name"), "tooid" => $_POST['operator'], "toname" => $newop["name"], "message" => $msg, "created" => $jakdb->raw("NOW()")]);

            $lastid = $jakdb->id();
        	
        	if ($lastid) {
                $jakdb->update("checkstatus", ["transferoid" => $_POST['operator'], "transferid" => $lastid], ["convid" => $_POST['cid']]);

                // Finally inform the operator when he is only reachable by notifications.
                if ($newop["available"] == 0) {

                    $url = JAK_rewrite::jakParseurl(JAK_OPERATOR_LOC, 'live', $_POST['cid']);
                    
                    if (JAK_base::jakAvailableHours($newop["hours_array"], date('Y-m-d H:i:s'))) {
                        jak_send_notifications($newop["id"], $_POST['cid'], JAK_TITLE, sprintf($jkl['g110'], $jakuser->getVar("name")), $url, $newop["push_notifications"], $newop["emailnot"], $newop["email"], $newop["pusho_tok"], $newop["pusho_key"], $newop["phonenumber"]);
                    }
                }

                $_SESSION["successmsg"] = $jkl['g285'];
                jak_redirect(BASE_URL);
            }

        }

        $_SESSION["errormsg"] = $jkl['g116'];
        jak_redirect(BASE_URL);
    }

}

$checkp = 0;

if (!isset($_SERVER['HTTP_REFERER'])) {
    $_SERVER['HTTP_REFERER'] = '';
}

// home
    if ($page == '') {
        #show login page only if the admin is not logged in
        #else show homepage
        if (!JAK_USERID) {
            require_once 'login.php';
        } else {
            require_once 'dashboard.php';
            $JAK_PAGE_ACTIVE = 1;
            $checkp = 1;
        	$JAK_PAGE_ACTIVE = 1;
        }
        $checkp = 1;
       	}
   if ($page == 'logout') {
        $checkp = 1;
        if (JAK_USERID) {
            $jakuserlogin->jakLogout(JAK_USERID);
            $_SESSION["successmsg"] = $jkl['g14'];
        }
        jak_redirect(BASE_URL);
    }
    // forgot password
    if ($page == 'forgot-password') {
    
    	if (JAK_USERID || !is_numeric($page1) || !$jakuserlogin->jakForgotactive($page1)) jak_redirect(BASE_URL);
    	
    	// select user
        $row = $jakdb->get("user", ["id", "name", "email"], ["forgot" => $page1]);
    	
    	// create new password
    	$password = jak_password_creator();
    	$passcrypt = hash_hmac('sha256', $password, DB_PASS_HASH);
    	
    	// update table
        $result = $jakdb->update("user", ["password" => $passcrypt], ["id" => $row['id']]);
    	
    	if (!$result) {
    		
    		$_SESSION["errormsg"] = $jkl["i2"];
    		// redirect back to home
    		jak_redirect(BASE_URL);
    		   
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
    				$mail->SetFrom(JAK_EMAIL);
    				$mail->AddAddress($row["email"]);
    				
    			} else {
    			
    				$mail->SetFrom(JAK_EMAIL);
    				$mail->AddAddress($row["email"]);
    			
    			}
    	
    		$body = sprintf($jkl['l16'], $row["name"], $password, JAK_TITLE);
    		$mail->MsgHTML($body);
    		$mail->AltBody = strip_tags($body);
            $mail->Subject = JAK_TITLE.' - '.$jkl['l6'];
    		
    		if ($mail->Send()) {
    			$_SESSION["infomsg"] = $jkl["l17"];
    			jak_redirect(BASE_URL);  	
    		}
    		
    	}
    	
    	$_SESSION["errormsg"] = $jkl["sql"];
    	jak_redirect(BASE_URL);
    }
    if ($page == 'live') {
        require_once 'live.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == '404') {
        if (!JAK_USERID) jak_redirect(BASE_URL);
        // Go to the 404 Page
        $SECTION_TITLE = '404 / ' . JAK_TITLE;
        $SECTION_DESC = "";
        $template = '404.php';
        $checkp = 1;
    }
    if ($page == 'files') {
        require_once 'files.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'response') {
        require_once 'response.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'departments') {
        require_once 'departments.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'answers') {
        require_once 'answers.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'uonline') {
        require_once 'uonline.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'leads') {
        require_once 'leads.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'contacts') {
        require_once 'contacts.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'chat') {
        require_once 'chat.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'chats') {
        require_once 'chats.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'notes') {
        require_once 'notes.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'proactive') {
        require_once 'proactive.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'bot') {
        require_once 'bot.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'blacklist') {
        require_once 'blacklist.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'settings') {
        require_once 'setting.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'buttons') {
        require_once 'buttons.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'widget') {
        require_once 'widget.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'groupchat') {
        require_once 'groupchat.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'users') {
        require_once 'user.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'statistics') {
        require_once 'statistics.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'logs') {
        require_once 'logs.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'maintenance') {
        require_once 'maintenance.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'tickets') {
        require_once 'tickets.php';
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'ps') {
        
        if ($page1 == "success") {
            $_SESSION["successmsg"] = $jkl["g299"];
        } else {
            $_SESSION["errormsg"] = $jkl["g300"];
        }
        jak_redirect(BASE_URL);
    }
     
// if page not found
if ($checkp == 0) {
    jak_redirect(JAK_rewrite::jakParseurl('404'));
}

if (isset($template) && $template != '') {
	include_once APP_PATH.JAK_OPERATOR_LOC.'/template/'.$template;
}

// Reset success and errors session for next use
unset($_SESSION["successmsg"]);
unset($_SESSION["errormsg"]);
unset($_SESSION["infomsg"]);
?>