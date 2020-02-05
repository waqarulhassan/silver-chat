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

// Get the client browser
$ua = new Browser();

// We make the chat open
if (isset($page1) && $page1 == 1) $_SESSION["slidestatus"] = "open";

// Get the department
$dep_direct = 0;
if (isset($jakwidget['depid']) && is_numeric($jakwidget['depid']) && $jakwidget['depid'] != 0) {
	$dep_direct = $jakwidget['depid'];
}

// Get the latest position
$widgetstyle = jak_html_widget_css($jakwidget['floatpopup'], $jakwidget['floatcss'], $jakwidget['floatcsschat']);

// Errors in Array
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_email'])) {
		$jkp = $_POST;
		
		if (empty($jkp['name']) || strlen(trim($jkp['name'])) <= 2) {
		    $errors['name'] = $jkl['e'];
		}
		
		if (JAK_EMAIL_BLOCK) {
			$blockede = explode(',', JAK_EMAIL_BLOCK);
			if (in_array($jkp['email'], $blockede) || in_array(strrchr($jkp['email'], "@"), $blockede)) {
				$errors['email'] = $jkl['e10'];
			}
		}
		
		if ($jkp['email'] == '' || !filter_var($jkp['email'], FILTER_VALIDATE_EMAIL)) {
		    $errors['email'] = $jkl['e1'];
		}
		
		if ($jakwidget['client_phone'] && !preg_match('^((\+)?(\d{2})[-])?(([\(])?((\d){3,5})([\)])?[-])|(\d{3,5})(\d{5,8}){1}?$^', $jkp['phone'])) {
		    $errors['phone'] = $jkl['e14'];
		}
		
		if (empty($jkp['message']) || strlen(trim($jkp['message'])) <= 2) {
		    $errors['message'] = $jkl['e2'];
		}

		if (!empty($jakwidget['dsgvo']) && empty($jkp['dsgvo'])) {
			$errors['dsgvo'] = $jkl['e3'];
		}
		
		if (JAK_CAPTCHA) {
			
			$human_captcha = explode(':#:', $_SESSION['jrc_captcha']);
			
			if ($jkp[$human_captcha[0]] == '' || $jkp[$human_captcha[0]] != $human_captcha[1]) {
				$errors['human'] = $jkl['e12'];
			}
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
		
			// Country stuff
			$countryName = 'Disabled';
			$countryAbbrev = 'xx';
			$city = 'Disabled';
			$countryLong = $countryLat = '';
				
			// if ip is valid do the whole thing
			if ($ipa && !$ua->isRobot()) {
				
				if (isset($_COOKIE['WIOgeoData'])) {
					// A "geoData" cookie has been previously set by the script, so we will use it
							
					// Always escape any user input, including cookies:
					list($city, $countryName, $countryAbbrev, $countryLat, $countryLong) = explode('|', strip_tags(base64_decode($_COOKIE['WIOgeoData'])));
							
				}
					
			}
			
			// Get the referrer
			$rowref = '';
			if (!isset($_SESSION['rlbid'])) {
			
				if (isset($_COOKIE['rlbid'])){
				   $_SESSION['rlbid'] = $_COOKIE['rlbid'];
				} else {
					$salt = rand(100, 99999);
					$rlbid = $salt.time();
					setcookie("rlbid", $rlbid, time() + 31536000, JAK_COOKIE_PATH);
					$_SESSION['rlbid'] = $rlbid;
				}
				
			} else {
				$rowref = $jakdb->get("buttonstats", "referrer", ["session" => $_SESSION['rlbid']]);
			}
			
			// Get the department for the contact form if set
			if (is_numeric($jkp["department"]) && $jkp["department"] != 0) {
			
				$op_email = JAK_EMAIL;
				
				foreach ($LC_DEPARTMENTS as $d) {
				    if (in_array($jkp["department"], $d)) {
				        if ($d['email']) $op_email = $d['email'];
				    }
				}
				
				$depid = $jkp["department"];
				
			} else {
				$op_email = JAK_EMAIL;
				$depid = 0;
			}
			
			// Reset phone var
			$cphone = '';
			
			$listform = $jkl["g27"].': '.$jkp['name'].'<br>';
			$listform .= $jkl["g47"].': '.$jkp['email'].'<br>';
			if (isset($jkp['phone'])) {
				$listform .= $jkl["g50"].': '.$jkp['phone'].'<br>';
				$cphone = $jkp['phone'];
			}
			$listform .= 'Referrer: '.$rowref.'<br>';
			$listform .= 'IP: '.$ipa.'<br>';
			$listform .= $jkl["g28"].': '.$jkp['message'];
			
			// We save the data
			$jakdb->insert("contacts", [ 
			"depid" => $depid,
			"name" => $jkp['name'],
			"email" => $jkp['email'],
			"phone" => $cphone,
			"message" => $jkp['message'],
			"ip" => $ipa,
			"city" => $city,
			"country" => $countryName,
			"countrycode" => $countryAbbrev,
			"longitude" => $countryLong,
			"latitude" => $countryLat,
			"referrer" => $rowref,
			"sent" => $jakdb->raw("NOW()")]);
			
			// We send the email
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
			$mail->AddAddress($op_email);

			$mail->AddReplyTo($jkp['email'], $jkp['name']);

			if (defined(JAK_EMAILCC)) {
				$emailarray = explode(',', JAK_EMAILCC);
					
				if (is_array($emailarray)) foreach($emailarray as $ea) { $mail->AddCC(trim($ea)); } 
					
			}
			
			$mail->Subject = JAK_TITLE;
			$mail->AltBody = $jkl['g45'];
			$mail->MsgHTML($listform);
			
			if ($mail->Send()) {
			
				unset($_SESSION['jrc_captcha']);
				unset($_SESSION['chatbox_redirected']);
				
				// Ajax Request
				if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
				
					header('Cache-Control: no-cache');
					die(json_encode(array('status' => 1, 'html' => $jkl["g65"], 'widgetstyle' => $widgetstyle, 'baseurl' => (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : $base_url), 'link' => $chatcloseurl)));
					
				} else {
				
			        jak_redirect($_SERVER['HTTP_REFERER']);			    
			    }
			}
		}
}

$headermsg = '';
if ($dep_direct && !empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {

	if ($jakwidget["whatsapp_offline"] == 1) {
		$msgtype = 27;
	} else {
		$msgtype = 8;
	}
	
	if ($v["msgtype"] == $msgtype && $v["lang"] == $BT_LANGUAGE && $dep_direct == $v["department"]) {
	
		$phold = array("%operator%","%client%","%email%");
		$replace   = array("", "", JAK_EMAIL);
		$headermsg = str_replace($phold, $replace, $v["message"]);
		
	}
	
}

// Now we don't have a message for the department only
if (empty($headermsg)) {
	if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {

		if ($jakwidget["whatsapp_offline"] == 1) {
			$msgtype = 27;
		} else {
			$msgtype = 8;
		}
		
		if ($v["msgtype"] == $msgtype && $v["lang"] == $BT_LANGUAGE && $v["department"] == 0) {
		
			$phold = array("%operator%","%client%","%email%");
			$replace   = array("", "", JAK_EMAIL);
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
	<title><?php echo $jkl["g1"];?> - <?php echo JAK_TITLE;?></title>
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
	 
	 <!-- Le fav and touch icons -->
	 <link rel="shortcut icon" href="<?php echo BASE_URL;?>img/ico/favicon.ico">
	 
</head>
<body>

<?php if (isset($page1) && $page1 == 1) { include_once('package/'.$jakwidget['template'].'/slide_up/contact.php'); } else { include_once('package/'.$jakwidget['template'].'/pop_up/contact.php'); } ?>

<script type="text/javascript" src="<?php echo BASE_URL;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/contact.js"></script>
<?php if (isset($page1) && $page1 == 1) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/resizer.js?=<?php echo JAK_UPDATED;?>"></script>
<?php } ?>
<script type="text/javascript">
	cross_url = '<?php echo (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : BASE_URL);?>';
	apply_animation = '<?php echo $jakwidget['chat_animation'];?>';
	<?php if (JAK_CAPTCHA) { ?>
		$(document).ready(function()
		{
			 $(".jak-ajaxform").append('<input type="hidden" name="<?php echo $random_name;?>" value="<?php echo $random_value;?>" />');
		});
	<?php } ?>
	$(document).ready(function(){
		$("#name").focus();
		<?php if (isset($page1) && $page1 == 1) { ?>
		iframe_resize($('#lcjframesize').width(), $('#lcjframesize').height(), "<?php echo jak_html_widget_css($jakwidget['floatpopup'], $jakwidget['floatcss'], $jakwidget['floatcsschat']);?>", cross_url);
		<?php } ?>
	});
	ls.main_url = "<?php echo BASE_URL;?>";
	ls.lsrequest_uri = "<?php echo JAK_PARSE_REQUEST;?>";
	ls.ls_submit = "<?php echo $jkl['g7'];?>";
	ls.ls_submitwait = "<?php echo $jkl['g8'];?>";
</script>
<?php if (!empty($jakgraphix["startjs"])) echo '<script type="text/javascript" src="'.BASE_URL.'package/'.$jakwidget['template'].'/'.$jakgraphix["startjs"].'"></script>';?>
</body>
</html>