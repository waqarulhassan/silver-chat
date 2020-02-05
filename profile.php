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

// start buffer
ob_start();

if (empty($_SESSION['jrc_userid']) || empty($_SESSION['convid']) || JAK_base::jakCheckSession($_SESSION['jrc_userid'], $_SESSION['convid'])) {
	
	// Destroy Session
	unset($_SESSION['convid']);
	unset($_SESSION['jrc_userid']);
	unset($_SESSION['jrc_email']);
	unset($_SESSION['jrc_phone']);
	unset($_SESSION['chat_wait']);
	
	jak_redirect(JAK_rewrite::jakParseurl('btn', $_SESSION["setchatstyle"]));
}

if ($jakwidget['feedback']) {
	$parseurl = JAK_rewrite::jakParseurl('feedback', $_SESSION["setchatstyle"]);
} else {
	$parseurl = JAK_rewrite::jakParseurl('stop', $_SESSION["setchatstyle"]);
}

// Reset vars
$errors = $op_phones = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_profile'])) {
	$jkp = $_POST;

	if (empty($jkp['name']) || strlen(trim($jkp['name'])) <= 2) {
		$errors['name'] = $jkl['e'];
	}
		
	if (JAK_EMAIL_BLOCK && ($jakwidget['client_email'] || !empty($jkp['email']))) {
		$blockede = explode(',', JAK_EMAIL_BLOCK);
		if (in_array($jkp['email'], $blockede) || in_array(strrchr($jkp['email'], "@"), $blockede)) {
			$errors['email'] = $jkl['e10'];
		}
	}
		
	if (($jakwidget['client_email'] || !empty($jkp['email'])) && !filter_var($jkp['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = $jkl['e1'];
	}
		
	if ($jakwidget['client_phone'] && !preg_match('^((\+)?(\d{2})[-])?(([\(])?((\d){3,5})([\)])?[-])|(\d{3,5})(\d{5,8}){1}?$^', $jkp['phone'])) {
		$errors['phone'] = $jkl['e14'];
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

		// Get the avatar
		$avatar = "";
		if (isset($jkp['avatar']) && isset($_SESSION['jrc_avatar']) && $jkp['avatar'] != $_SESSION['jrc_avatar']) {
			$avatar = $jkp['avatar'];
		} else {
			$avatar = $_SESSION['jrc_avatar'];
		}

		// Update the tables
		$jakdb->update("transcript", ["name" => $jkp['name']], ["AND" => ["convid" => $_SESSION['convid'], "class" => "user"]]);
		$jakdb->update("sessions", ["name" => $jkp['name'], "email" => $jkp['email'], "phone" => $jkp['phone'], "usr_avatar" => $avatar], ["id" => $_SESSION['convid']]);

		// Get the vars into a session
		$_SESSION['jrc_name'] = $jkp['name'];
		$_SESSION['jrc_email'] = $jkp['email'];
		$_SESSION['jrc_phone'] = $jkp['phone'];
		$_SESSION['jrc_avatar'] = $avatar;

		// Redirect page
		$gochat = JAK_rewrite::jakParseurl('chat', $_SESSION["setchatstyle"]);
			
		/* Outputtng the error messages */
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			
			header('Cache-Control: no-cache');
			die(json_encode(array('login' => 1, 'link' => $gochat)));
					
		}

		jak_redirect($gochat);

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

<?php if (isset($page1) && $page1 == 1) { include_once('package/'.$jakwidget['template'].'/slide_up/profile.php'); } else { include_once('package/'.$jakwidget['template'].'/pop_up/profile.php'); } ?>

<script type="text/javascript" src="<?php echo BASE_URL;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/functions.js"></script>
<?php if (isset($page1) && $page1 == 1) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/resizer.js?=<?php echo JAK_UPDATED;?>"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/howler.js?=<?php echo JAK_UPDATED;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/contact.js"></script>
<?php if (!empty($jakgraphix["btnjs"])) echo '<script type="text/javascript" src="'.BASE_URL.'package/'.$jakwidget['template'].'/'.$jakgraphix["btnjs"].'"></script>';?>
<script type="text/javascript">
	// The Widget ID
	lcjakwidgetid = <?php echo $_SESSION['widgetid'];?>;
	// The Base Url
	base_url = '<?php echo BASE_URL;?>';
	cross_url = '<?php echo (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : BASE_URL);?>';
	apply_animation = '<?php echo $jakwidget['chat_animation'];?>';
	<?php if (isset($page1) && $page1 == 1) { ?>
	// The Iframe Height/Width
	var btncont = document.getElementById('lcjframesize');
	var width = btncont.offsetWidth;
	var height = btncont.offsetHeight;
	iframe_resize(width, height, "<?php echo jak_html_widget_css($jakwidget['floatpopup'], $jakwidget['floatcss'], $jakwidget['floatcsschat']);?>", cross_url);
	<?php } ?>
	ls.main_url = "<?php echo BASE_URL;?>";
	ls.lsrequest_uri = "<?php echo JAK_PARSE_REQUEST;?>";
	ls.ls_submit = "<?php echo $jkl['g86'];?>";
	ls.ls_submitwait = "<?php echo $jkl['g8'];?>";
</script>
</body>
</html>
<?php ob_flush(); ?>