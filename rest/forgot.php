<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1998 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('config.php')) die('rest_api config.php not exist');
require_once 'config.php';

$email = "";
// Get the email
if (isset($_REQUEST['email']) && !empty($_REQUEST['email']) && filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);

if (!empty($email)) {

	$fwhen = time();

	// Check if this user exist
	$user_check = $jakuserlogin->jakForgotpassword($email, $fwhen);

	if ($user_check == true) {

		// Include the mail library
		include_once APP_PATH.'class/PHPMailerAutoload.php';

		// Import the language file
		include_once(APP_PATH.JAK_OPERATOR_LOC.'/lang/'.JAK_LANG.'.php');
    
	    // Send email to client
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
	         		
	    } else {
	        $mail->SetFrom(JAK_EMAIL, JAK_TITLE);
	    }

	    // Get user details
	    $oname = $jakdb->get("user", "name", ["AND" => ["email" => $email, "access" => 1]]);
	         	
	    $mail->AddAddress($email);
	         	
	    $mail->Subject = JAK_TITLE.' - '.$jkl['l13'];
	    $body = sprintf($jkl['l14'], $oname, '<a href="'.JAK_rewrite::jakParseurl('forgot-password', $fwhen).'">'.JAK_rewrite::jakParseurl('forgot-password', $fwhen).'</a>', JAK_TITLE);
	         	
	    $mail->MsgHTML($body);
	    $mail->AltBody = strip_tags($body);
	         	
	    if ($mail->Send()) {
	        die(json_encode(array('status' => true)));
	    }
 	} else {
 		die(json_encode(array('status' => false, 'errorcode' => 6)));
 	}
}

die(json_encode(array('status' => false, 'errorcode' => 5)));
?>