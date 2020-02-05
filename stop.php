<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.6.2                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_PREVENT_ACCESS')) die('You cannot access this file directly.');

// buffer flush
ob_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['convid']) && is_numeric($_SESSION['convid'])) {

	// convert post into defaults
	$jkp = $_POST;

	// check to see if conversation is to be stored
	$row = $jakdb->get("checkstatus", ["convid", "depid", "operator", "hide"], ["convid" => $_SESSION['convid']]);
	
	if (isset($row) && !empty($row)) {
		
		if ($row['hide'] == 0) {

			$jakdb->update("sessions", ["status" => 0, "ended" => time()], ["id" => $row['convid']]);
			$jakdb->update("checkstatus", ["hide" => 1], ["convid" => $row['convid']]);
			$clientname = $jakdb->get("sessions", "name", ["id" => $row['convid']]);
			
			if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
				
				if ($v["msgtype"] == 6 && $v["lang"] == $lang) {
				
					$phold = array("%operator%","%client%","%email%");
					$replace   = array($row['operator'], $clientname, JAK_EMAIL);
					$message = str_replace($phold, $replace, $v["message"]);

					$jakdb->insert("transcript", [ 
					"name" => $_SESSION['jrc_name'],
					"message" => $message,
					"user" => $_SESSION['jrc_userid'],
					"convid" => $row['id'],
					"class" => "ended",
					"time" => $jakdb->raw("NOW()")]);
					
				}
					
			}
		
		}
		
		// Send the transcript
		if ($jkp['send_email'] && !empty($jkp['email']) && filter_var($jkp['email'], FILTER_VALIDATE_EMAIL)) {
		
			$result = $jakdb->get("transcript", "*", ["AND" => ["convid" => $row['id'], "plevel" => 1]]);
			
			if (isset($result) && !empty($result)) {
			
			$email_body = '<body style="margin:10px;">
			<div style="width:550px; font-family: \'Droid Serif\', Helvetica, Arial, sans-serif;">
			<table style="width:100%;margin:0;padding:0;font-size: 13px;" cellspacing="10" border="0">
			<tr>
			<td>
			<h1>'.JAK_TITLE.'</h1>
			<p>'.$jkl['g66'].'</p>
			<div style="margin: 10px 0 10px 10px;
			border:1px solid #A8B9CB;
			height: 500px;
			overflow:auto;
			letter-spacing: normal;
			line-height: 1.5em;
			-moz-border-radius: 9px;
			-webkit-border-radius: 9px;
			border-radius: 9px;"><ul style="list-style: none;margin:0;padding:0;">';
			
				foreach ($result as $rowt) {
				
					if ($rowt['class'] == "admin") {
						$css_chat = 'background-color:#effcff;
						padding:5px 5px 10px 5px;
						border-bottom:1px solid #c4dde1;';
					} elseif ($rowt['class'] == "download") {
						$css_chat = 'padding:10px 5px 10px 5px;
						background-color:#d0e5f9;
						background-image:url('.BASE_URL.'img/download.png);
						background-position:98% 50%;
						background-repeat:no-repeat;
						border-bottom:1px solid #c4dde1;';
					} elseif ($rowt['class'] == "notice") {
						$css_chat = 'padding:10px 5px 10px 5px;
						background-color:#d0e5f9;
						background-image:url('.BASE_URL.'img/notice.png);
						background-position:98% 50%;
						background-repeat:no-repeat;
						border-bottom:1px solid #c4dde1;';
					} else {
						$css_chat = 'background-color:#f4fdf1;
						padding:5px 5px 10px 5px;
						border-bottom:1px solid #c4dde1;';
					}
			
					$email_body .= '<li style="'.$css_chat.'"><span style="font-size:10px;color:#555;">'.date(JAK_DATEFORMAT.JAK_TIMEFORMAT, strtotime($rowt['time'])).' '.$rowt['name'].' '.$jkl['g14'].' :</span><br />'.stripcslashes($rowt['message']).'</li>';	
				}
				
			$email_body .= '</ul></div></td>
			</tr>
			</table>
			</div>
			</body>';
			
			$semail = filter_var($jkp['email'], FILTER_SANITIZE_EMAIL);
			$sname = filter_var(jak_input_filter($jkp['name']), FILTER_SANITIZE_STRING);
			
			// update session table to new email address:
			$jakdb->update("sessions", ["email" => $semail, "name" => $sname], ["id" => $row['id']]);

			$jakdb->insert("transcript", [ 
				"name" => $sname,
				"message" => $jkl['g54'],
				"user" => $_SESSION['jrc_userid'],
				"convid" => $row['id'],
				"class" => "notice",
				"time" => $jakdb->raw("NOW()")]);
			
			$mail = new PHPMailer(); // defaults to using php "mail()" or optional SMTP
			
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
				$mail->AddReplyTo(JAK_EMAIL, JAK_TITLE);
				$mail->AddAddress($jkp['email'], $jkp['name']);
				
			} else {
			
				$mail->SetFrom(JAK_EMAIL, JAK_TITLE);
				$mail->AddReplyTo(JAK_EMAIL, JAK_TITLE);
				$mail->AddAddress($jkp['email'], $jkp['name']);
			
			}
			
			$body = str_ireplace("[\]", "", $email_body);
			$mail->Subject = $jkl['g44'].' - '.JAK_TITLE;
			$mail->AltBody = $jkl['g45'];
			$mail->MsgHTML($body);
			$mail->Send();
			
			}
		
		}
		
		// Insert the rating
		if (JAK_CRATING) {
		
			// Now get the support time
			$row2 = $jakdb->get("sessions", ["initiated", "ended"], ["id" => $_SESSION['convid']]);
			
			$total_supporttime = $row2['ended'] - $row2['initiated'];

			$jakdb->insert("user_stats", [ 
				"userid" => $row["operatorid"],
				"vote" => $jkp["fbvote"],
				"name" => ($sname ? $sname : $_SESSION['jrc_name']),
				"email" => $row["email"],
				"support_time" => $total_supporttime,
				"time" => $jakdb->raw("NOW()")]);
		}

	unset($_SESSION['convid']);
	unset($_SESSION['jrc_userid']);
	unset($_SESSION['jrc_email']);
	unset($_SESSION['jrc_phone']);
	unset($_SESSION['jrc_captcha']);
	unset($_SESSION['jrc_avatar']);
	unset($_SESSION["redirecturl"]);
	unset($_SESSION["postid"]);
	unset($_SESSION['chat_wait']);
	unset($_SESSION['lastid']);
	unset($_SESSION["msgsmin"]);
	
	}
}

if ($page1 == 1 && isset($_SESSION['convid'])) {

	// check to see if conversation is to be stored
	$row = $jakdb->get("checkstatus", ["convid", "depid", "operator", "hide"], ["convid" => $_SESSION['convid']]);
	
	if (isset($row) && !empty($row)) {
		
		if (!$row['hide']) {
		
			$jakdb->update("sessions", ["status" => 0, "ended" => time()], ["id" => $row['convid']]);
			$jakdb->update("checkstatus", ["hide" => 1], ["convid" => $row['convid']]);
			
			if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
				
				if ($v["msgtype"] == 6 && $v["lang"] == $lang) {
				
					$phold = array("%operator%","%client%","%email%");
					$replace   = array($row['operatorname'], $row['name'], JAK_EMAIL);
					$message = str_replace($phold, $replace, $v["message"]);

					$jakdb->insert("transcript", [ 
					"name" => $_SESSION['jrc_name'],
					"message" => $message,
					"user" => $_SESSION['jrc_userid'],
					"convid" => $row['id'],
					"class" => "ended",
					"time" => $jakdb->raw("NOW()")]);
					
				}
					
			}
		
		}
		
		// Now get the support time
		$row2 = $jakdb->get("sessions", ["initiated", "ended"], ["id" => $row['convid']]);
			
		$total_supporttime = $row2['ended'] - $row2['initiated'];

		$jakdb->insert("user_stats", [ 
			"userid" => $row["operatorid"],
			"vote" => 0,
			"name" => $_SESSION['jrc_name'],
			"email" => $row["email"],
			"support_time" => $total_supporttime,
			"time" => $jakdb->raw("NOW()")]);
		
	}
	
	unset($_SESSION['convid']);
	unset($_SESSION['jrc_userid']);
	unset($_SESSION['jrc_email']);
	unset($_SESSION['jrc_captcha']);
	unset($_SESSION['chat_wait']);
	unset($_SESSION['jrc_avatar']);
	unset($_SESSION['slidestatus']);
	
	$_SESSION['jrc_stopped'] = 1;

	if (isset($page1) && $page1 == 1) {
		jak_redirect($chatcloseurl);
	} else {
		jak_redirect(JAK_rewrite::jakParseurl('start', $_SESSION["setchatstyle"]));
	}

}

ob_flush();

// Page is pop up, closed it.
if (isset($page1) && $page1 == 2) {

?>

<script type="text/javascript">
	window.close();
</script>

<?php } ?>