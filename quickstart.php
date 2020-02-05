<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8.3                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2019 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_PREVENT_ACCESS')) die('You cannot access this file directly.');

// include the PHP library (if not autoloaded)
require('class/class.emoji.php');

// buffer flush
ob_start();

if (isset($_SESSION['jrc_userid']) && isset($_SESSION['convid'])) jak_redirect(JAK_rewrite::jakParseurl('chat', $page1, $page2));

// We make the chat open
if (isset($page1) && $page1 == 1) $_SESSION["slidestatus"] = "open";

// Get the department
$dep_direct = 0;
if (isset($jakwidget['depid']) && is_numeric($jakwidget['depid']) && $jakwidget['depid'] != 0) {
	$dep_direct = 1;
	foreach ($online_op as $d) {
	    if (in_array($jakwidget['depid'], $d)) {
	        $dep_direct = $jakwidget['depid'];
	    }
	}
}

// Operator ID if set.
$opdirect = 0;
if (isset($jakwidget['opid']) && is_numeric($jakwidget['opid']) && $jakwidget['opid'] != 0) $opdirect = $jakwidget['opid'];

// Get the PHP GET for quick login
$sendform = false;
if (isset($_SESSION['custom_vars']) && !empty($_SESSION['custom_vars'])) {
	$cvar = explode(":#:", $_SESSION['custom_vars']);
	// We convert the get into $jkp vars
	if (isset($cvar[0]) && !empty($cvar[0])) $jkp['name'] = $_REQUEST["name"] = $cvar[0];
	if (isset($cvar[1]) && !empty($cvar[1])) $jkp['email'] = $_REQUEST["email"] = $cvar[1];
	if (isset($cvar[2]) && !empty($cvar[2])) $jkp['question'] = $_REQUEST["question"] = $cvar[2];
	$sendform = true;
}

// Get the client browser
$ua = new Browser();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['start_chat'])) {
		if (!$sendform) $jkp = $_POST;
		
		// Errors in Array
		$errors = array();
		
		if (empty($jkp['message']) || strlen(trim($jkp['message'])) <= 2) {
		    $errors['message'] = $jkl['e2'];
		}
		
		if (JAK_CAPTCHA && !$sendform) {
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
			
			// Get the avatar
			$avatar = "/package/".$jakwidget['template']."/avatar/standard.jpg";
			
			// Get the avatar into a session
			$_SESSION['jrc_avatar'] = $avatar;
			
			// create the guest account
			$salt = rand(100, 1000000);
			$userid = $jkl['g51'].$ipa.$salt;
			$_SESSION['jrc_name'] = ($jkp['name'] ? $jkp['name'] : filter_var($jkl['g51'].'_'.$salt, FILTER_SANITIZE_STRING));
			$_SESSION['jrc_userid'] = $userid;
			$_SESSION['jrc_email'] = ($jkp['email'] ? $jkp['email'] : "");
			
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

			// add entry to sql
			$jakdb->insert("sessions", [ 
			"userid" => $userid,
			"department" => $dep_direct,
			"operatorid" => $opdirect,
			"template" => $jakwidget['template'],
			"usr_avatar" => $avatar,
			"name" => $_SESSION['jrc_name'],
			"email" => $_SESSION['jrc_email'],
			"city" => $city,
			"country" => $countryName,
			"countrycode" => $countryAbbrev,
			"longitude" => $countryLong,
			"latitude" => $countryLat,
			"initiated" => time(),
			"status" => 1,
			"session" => $_SESSION['rlbid']]);

			$cid = $jakdb->id();
						
			if ($cid) {

				// Start with the checkstatus table
				foreach ($LC_DEPARTMENTS as $d) {
				    if ($dep_direct == $d["id"]) {
				        if ($d['title']) $deptitle = $d['title'];
				    }
				}

				// Set the chat session status
				$jakdb->insert("checkstatus", ["convid" => $cid, "depid" => $dep_direct, "department" => $deptitle, "operatorid" => $opdirect, "files" => JAK_CHAT_UPLOAD_STANDARD, "initiated" => time()]);
				
				$_SESSION['convid'] = $cid;

				if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
					
					if ($v["msgtype"] == 5 && $v["lang"] == $BT_LANGUAGE) {
						
						$phold = array("%operator%","%client%","%email%");
						$replace   = array("", $_SESSION['jrc_name'], JAK_EMAIL);
						$messageaut = str_replace($phold, $replace, $v["message"]);

						$jakdb->insert("transcript", [ 
							"name" => $jkl["g56"],
							"message" => $messageaut,
							"convid" => $cid,
							"class" => "notice",
							"time" => $jakdb->raw("NOW()")]);
							
					}
							
				}

				// Clean message
				$message = strip_tags($_POST['message']);
				$message = filter_var($message, FILTER_SANITIZE_STRING);
				$message = trim($message);

				$jakdb->insert("transcript", [ 
					"name" => $_SESSION['jrc_name'],
					"message" => $message,
					"convid" => $cid,
					"class" => "user",
					"time" => $jakdb->raw("NOW()")]);

				// Now we pick the bot answer if one exists
				$botanswer = $answerdisp = '';
				if (!empty($JAK_BOT_ANSWER)) {
					
					foreach ($JAK_BOT_ANSWER as $v) {

						if (($v['widgetids'] == 0 || in_array($_SESSION['widgetid'], explode(",", $v['widgetids']))) && ($v["depid"] == 0 || $v["depid"] == $dep_direct) && $v["lang"] == $BT_LANGUAGE) {

							$bot_question = strtolower($v["question"]);

							if (strpos($bot_question, ",") !== false ) {
								$bot_question = explode(",", $bot_question);

								// We do not have to type the exact word, it will pick the correct word in the string
								if (isset($bot_question) && is_array($bot_question)) foreach ($bot_question as $q) {

									if (strtolower($message) == $q) {
										$botanswer = strip_tags($v["answer"]);
										break;
									}
								}

							} else {

								// Check if we have a word only
								if (strtolower($message) == $bot_question) {

									$botanswer = strip_tags($v["answer"]);
								}

							}

						}

					}

					// Fix for wildcard bot answer
					if (empty($botanswer)) foreach ($JAK_BOT_ANSWER as $v) {

						if (($v['widgetids'] == 0 || in_array($_SESSION['widgetid'], explode(",", $v['widgetids']))) && ($v["depid"] == 0 || $v["depid"] == $dep_direct) && $v["lang"] == $BT_LANGUAGE) {

							$bot_question = strtolower($v["question"]);

							// Check if we have a wildcard
							if ($bot_question == "*") {

								$botanswer = strip_tags($v["answer"]);

							}

						}

					}

					// Proceed with displaying the bot answer
					if (!empty($botanswer)) {

						$botanswer = filter_var($botanswer, FILTER_SANITIZE_STRING);

						// Place holder converters
						$phold = array("%client%","%email%");
						$replace   = array($_SESSION['jrc_name'], JAK_EMAIL);
						$botanswer = str_replace($phold, $replace, $botanswer);

						// Url converter
						$answerdisp = nl2br(replace_urls($botanswer));

						// Convert emotji
						$answerdisp = Emojione\Emojione::toImage($answerdisp);

						$jakdb->insert("transcript", [ 
							"name" => $jkl["g74"],
							"message" => $botanswer,
							"convid" => $cid,
							"class" => "bot",
							"time" => $jakdb->raw("NOW()")]);

					}
				}

				// Now send notifications if whish so
				$result = $jakdb->select("user", ["id", "username", "email", "alwaysnot", "emailnot", "hours_array", "pusho_tok", "pusho_key", "phonenumber", "push_notifications"], ["AND" => ["OR" => ["available" => 0, "alwaysnot" => 1], "departments" => [0, $dep_direct], "access" => 1]]);
						
				if (isset($result) && !empty($result)) foreach ($result as $row) {

					if (JAK_base::jakAvailableHours($row["hours_array"], date('Y-m-d H:i:s')) || $row["alwaysnot"] == 1) {

						$url = JAK_rewrite::jakParseurl(JAK_OPERATOR_LOC, 'live', $cid);
						jak_send_notifications($row["id"], $cid, JAK_TITLE, JAK_TW_MSG, $url, $row["push_notifications"], $row["emailnot"], $row["email"], $row["pusho_tok"], $row["pusho_key"], $row["phonenumber"]);
					}
				}
			}
			
			// Redirect page
			$gochat = JAK_rewrite::jakParseurl('chat', $_POST['slide_chat'], $_POST['lang'], '', '');
			
			/* Outputtng the error messages */
			if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			
				header('Cache-Control: no-cache');
				die(json_encode(array('login' => 1, 'link' => $gochat)));
				
			}
			jak_redirect($gochat);
			
		}
}

// Get the message from the proactive
$proactivemsg = '';
$proactivemsg = $jakdb->get("buttonstats", "message", ["AND" => ["session" => $_SESSION['rlbid'], "message[!]" => ""]]);

$headermsg = '';
if ($dep_direct && !empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
	
	if ($v["msgtype"] == 10 && $v["lang"] == $BT_LANGUAGE && $dep_direct == $v["department"]) {
	
		$phold = array("%operator%","%client%","%email%");
		$replace   = array("", "", JAK_EMAIL);
		$headermsg = str_replace($phold, $replace, $v["message"]);
		
	}
	
}

// Now we don't have a message for the department only
if (empty($headermsg)) {
	if (!empty($LC_ANSWERS) && is_array($LC_ANSWERS)) foreach ($LC_ANSWERS as $v) {
		
		if ($v["msgtype"] == 10 && $v["lang"] == $BT_LANGUAGE && $v["department"] == 0) {
		
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
	<title><?php echo $jkl["g"];?> - <?php echo JAK_TITLE;?></title>
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

<?php if (isset($page1) && $page1 == 1) { include_once('package/'.$jakwidget['template'].'/slide_up/quickstart.php'); } else { include_once('package/'.$jakwidget['template'].'/pop_up/quickstart.php'); } ?>

<script type="text/javascript" src="<?php echo BASE_URL;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/functions.js"></script>
<?php if (isset($page1) && $page1 == 1) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/resizer.js?=<?php echo JAK_UPDATED;?>"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/contact.js"></script>
<script src="<?php echo BASE_URL.JAK_OPERATOR_LOC;?>/js/emoji.js" type="text/javascript"></script>
<script type="text/javascript">
	cross_url = '<?php echo (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : BASE_URL);?>';
	apply_animation = '<?php echo $jakwidget['chat_animation'];?>';
	<?php if (JAK_CAPTCHA) { ?>
		$(document).ready(function() {
			$(".jak-ajaxform").append('<input type="hidden" name="<?php echo $random_name;?>" value="<?php echo $random_value;?>" />');
		});
	<?php } ?>
	$(document).ready(function() {
		$("#message").fadeIn().focus();
		$('#message').keypress(function (e) {
		  if (e.which == 13) {
		    $('form.jak-ajaxform').submit();
		  }
		});
		$("#emoji").emojioneArea();
		<?php if (isset($page1) && $page1 == 1) { ?>
		iframe_resize($('#lcjframesize').width(), $('#lcjframesize').height(), "<?php echo jak_html_widget_css($jakwidget['floatpopup'], $jakwidget['floatcss'], $jakwidget['floatcsschat']);?>", cross_url);
		<?php } ?>
	});
	ls.main_url = "<?php echo BASE_URL;?>";
	ls.lsrequest_uri = "<?php echo JAK_PARSE_REQUEST;?>";
	ls.ls_submit = "<?php echo $jkl['g10'];?>";
	ls.ls_submitwait = "<?php echo $jkl['g8'];?>";
</script>
<?php if (!empty($jakgraphix["startjs"])) echo '<script type="text/javascript" src="'.BASE_URL.'package/'.$jakwidget['template'].'/'.$jakgraphix["startjs"].'"></script>';?>
</body>
</html>
<?php ob_flush(); ?>