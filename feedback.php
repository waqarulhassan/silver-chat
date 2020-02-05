<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8.1                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_PREVENT_ACCESS')) die('You cannot access this file directly.');

// buffer flush
ob_start();

if (isset($_SESSION['jrc_userid']) && isset($_SESSION['convid'])) {

	// check to see if conversation is to be stored
	$row = $jakdb->get("checkstatus", ["convid", "depid", "operator", "hide"], ["convid" => $_SESSION['convid']]);
	
	if (isset($row) && !empty($row)) {
		
		if ($row['hide'] == 0) {

			// Close the chat
			$jakdb->update("sessions", ["status" => 0, "ended" => time()], ["id" => $row['convid']]);
			$jakdb->update("checkstatus", ["hide" => 1], ["convid" => $row['convid']]);

			// Get the client name
			$clientname = $jakdb->get("sessions", "name", ["id" => $row['convid']]);
			
			if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
				
				if ($v["msgtype"] == 6 && $v["lang"] == $BT_LANGUAGE) {
				
					$phold = array("%operator%","%client%","%email%");
					$replace   = array($row['operator'], $clientname, JAK_EMAIL);
					$message = str_replace($phold, $replace, $v["message"]);

					$jakdb->insert("transcript", [ 
						"name" => $_SESSION['jrc_name'],
						"message" => $message,
						"user" => $_SESSION['jrc_userid'],
						"convid" => $row['convid'],
						"class" => "ended",
						"time" => $jakdb->raw("NOW()")]);
					
				}
					
			}
		
		}
		
		$_SESSION['fbdata'] = $_SESSION['convid'].':fb:'.$_SESSION['jrc_userid'];
		
		unset($_SESSION['convid']);
		unset($_SESSION['jrc_userid']);
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

if (isset($_SESSION['fbdata'])) {

$fb = explode(":fb:", $_SESSION['fbdata']);

// Get the latest position
$widgetstyle = jak_html_widget_css($jakwidget['floatpopup'], $jakwidget['floatcss'], $jakwidget['floatcsschat']);

// Errors in Array
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_feedback']) && is_numeric($_POST['convid'])) {
		$jkp = $_POST;
		
		if (isset($jkp['send_email']) && !filter_var($jkp['email'], FILTER_VALIDATE_EMAIL)) {
		    $errors['email'] = $jkl['e1'];
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
		
			if ($fb[0] == $jkp['convid']) {
				
				// Send the transcript
				if (JAK_SEND_TSCRIPT == 1 && isset($jkp['send_email']) && !empty($jkp['email']) && filter_var($jkp['email'], FILTER_VALIDATE_EMAIL)) {

					$result = $jakdb->select("transcript", "*", ["AND" => ["convid" => $fb[0], "plevel" => 1]]);
			
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
					
					// update session table to new email address:
					$jakdb->update("sessions", ["email" => $jkp['email']], ["id" => $jkp['convid']]);

					$jakdb->insert("transcript", [ 
						"name" => $jkp['name'],
						"message" => $jkl['g54'],
						"user" => $fb[1],
						"convid" => $jkp['convid'],
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
						
					}

					$mail->SetFrom(JAK_EMAIL);
					$mail->AddAddress($jkp['email'], $jkp['name']);

					$body = str_ireplace("[\]", "", $email_body);
					$mail->Subject = $jkl['g44'].' - '.JAK_TITLE;
					$mail->AltBody = $jkl['g45'];
					$mail->MsgHTML($body);
					$mail->Send();
					
					}
				
				}
				
				// update session table to new name:
				$jakdb->update("sessions", ["name" => jak_input_filter($jkp['name'])], ["id" => $fb[0]]);
				
				$email = filter_var($jkp['email'], FILTER_SANITIZE_EMAIL);
				$message = filter_var($jkp['message'], FILTER_SANITIZE_STRING);
				
				// Now get the support time
				$row2 = $jakdb->get("sessions", ["department", "name", "initiated", "ended", "operatorid"], ["id" => $fb[0]]);
			
				$total_supporttime = $row2['ended'] - $row2['initiated'];

				if (!JAK_CRATING) $jkp["fbvote"] = 0;

				$jakdb->insert("user_stats", [ 
					"userid" => $row2["operatorid"],
					"vote" => $jkp["fbvote"],
					"name" => $row2['name'],
					"email" => $email,
					"comment" => $message,
					"support_time" => $total_supporttime,
					"time" => $jakdb->raw("NOW()")]);
		
				$listform = $jkl["g27"].': '.$jkp['name'].'<br />';
				if ($jkp['message']) {
					$listform .= $jkl["g24"].': '.$message.'<br />';
				} else {
					$listform .= $jkl["g24"].': '.$jkl["g12"].'<br />';
				}
				$listform .= $jkl["g29"].': '.$jkp['fbvote'].'/5';
				
				// Get the department for the contact form if set
				$op_email = JAK_EMAIL;
				if (is_numeric($row2["department"]) && $row2["department"] != 0) {
					
					if (isset($LC_DEPARTMENTS)) foreach ($LC_DEPARTMENTS as $d) {
					    if (in_array($row2["department"], $d)) {
					        if ($d['email']) $op_email = $d['email'];
					    }
					}
					
				}
			
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
				
				if ($email) {
					$mail->AddReplyTo($email);
				}
				$mail->AddAddress($op_email);
				$mail->Subject = $jkl["g24"];
				$mail->MsgHTML($listform);
				
				if ($mail->Send()) {
				
					unset($_SESSION['fbdata']);
					unset($_SESSION['jrc_email']);
					$_SESSION['jrc_stopped'] = 1;
					$_SESSION["slidestatus"] = "closed";
					
					// Ajax Request
					if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
						
						header('Cache-Control: no-cache');
						die(json_encode(array('status' => 1, 'html' => $jkl["g68"], 'widgetstyle' => $widgetstyle, 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url), 'link' => $chatcloseurl)));
						
					} else {
				        jak_redirect($_SERVER['HTTP_REFERER']);
				    }
				}
		}
	}
}

} else {
	jak_redirect(JAK_rewrite::jakParseurl('start', $_SESSION["setchatstyle"]));
}

$headermsg = '';
if (isset($row["depid"]) && !empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
	
	if ($v["msgtype"] == 9 && $v["lang"] == $BT_LANGUAGE && $row["depid"] == $v["department"]) {
	
		$phold = array("%operator%","%client%","%email%");
		$replace   = array("", $_SESSION['jrc_name'], JAK_EMAIL);
		$headermsg = str_replace($phold, $replace, $v["message"]);
		
	}
	
}

// Now we don't have a message for the department only
if (empty($headermsg)) {
	if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
		
		if ($v["msgtype"] == 9 && $v["lang"] == $BT_LANGUAGE && $v["department"] == 0) {
		
			$phold = array("%operator%","%client%","%email%");
			$replace   = array("", $_SESSION['jrc_name'], JAK_EMAIL);
			$headermsg = str_replace($phold, $replace, $v["message"]);
			
		}
		
	}
}
?>
<!DOCTYPE html>
<html lang="<?php echo $BT_LANGUAGE;?>">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Live Chat PHP">
	<title><?php echo $jkl["g24"];?> - <?php echo JAK_TITLE;?></title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo BASE_URL;?>css/compress.css.php" media="screen">

	<!-- Custom Styles -->
	<?php include_once('package/'.$jakwidget['template'].'/style.php');?>

	<?php if ($jkl["rtlsupport"]) { ?>
  	<!-- RTL Support -->
  	<link rel="stylesheet" href="<?php echo BASE_URL;?>css/style-rtl.css?=<?php echo JAK_UPDATED;?>" type="text/css" media="screen">
  	<!-- End RTL Support -->
  	<?php } ?>
		
	<!--[if lt IE 9]>
	<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	 <![endif]-->
	 
</head>
<body>

<?php if (isset($page1) && $page1 == 1) { include_once('package/'.$jakwidget['template'].'/slide_up/feedback.php'); } else { include_once('package/'.$jakwidget['template'].'/pop_up/feedback.php'); } ?>

<script type="text/javascript" src="<?php echo BASE_URL;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/contact.js"></script>
<?php if (isset($page1) && $page1 == 1) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/resizer.js?=<?php echo JAK_UPDATED;?>"></script>
<?php } if (JAK_CRATING) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/rating.js"></script>
<?php } ?>
<script type="text/javascript">
	$("#name").focus();
	cross_url = '<?php echo (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : BASE_URL);?>';
	apply_animation = '<?php echo $jakwidget['chat_animation'];?>';
	ls.main_url = "<?php echo BASE_URL;?>";
	ls.lsrequest_uri = "<?php echo JAK_PARSE_REQUEST;?>";
	ls.ls_submit = "<?php echo $jkl['g25'];?>";
	ls.ls_submitwait = "<?php echo $jkl['g8'];?>";
	<?php if (isset($page1) && $page1 == 1) { ?>
	iframe_resize($('#lcjframesize').width(), $('#lcjframesize').height(), "<?php echo jak_html_widget_css($jakwidget['floatpopup'], $jakwidget['floatcss'], $jakwidget['floatcsschat']);?>", cross_url);
	<?php } ?>
</script>
<?php if ($jakgraphix["startjs"]) echo '<script type="text/javascript" src="'.BASE_URL.'package/'.$jakwidget['template'].'/'.$jakgraphix["startjs"].'"></script>';?>
</body>
</html>

<?php ob_flush(); ?>