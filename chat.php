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
	unset($_SESSION['chat_wait']);
	
	if (isset($page1) && $page1 == 1) {
		jak_redirect($chatstarturl);
	} else {
		jak_redirect($chatstarturlpop);
	}
}

if ($jakwidget['feedback']) {
	$parseurl = JAK_rewrite::jakParseurl('feedback', $_SESSION["setchatstyle"]);
} else {
	$parseurl = JAK_rewrite::jakParseurl('stop', $_SESSION["setchatstyle"]);
}

// We make the chat open
if (isset($page1) && $page1 == 1) $_SESSION["slidestatus"] = "open";
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

<?php if (isset($page1) && $page1 == 1) { include_once('package/'.$jakwidget['template'].'/slide_up/chat.php'); } else { include_once('package/'.$jakwidget['template'].'/pop_up/chat.php'); } ?>

<script type="text/javascript" src="<?php echo BASE_URL;?>js/jquery.js?=<?php echo JAK_UPDATED;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/functions.js?=<?php echo JAK_UPDATED;?>"></script>
<?php if (isset($page1) && $page1 == 1) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/resizer.js?=<?php echo JAK_UPDATED;?>"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/clientchat.js?=<?php echo JAK_UPDATED;?>"></script>
<script src="<?php echo BASE_URL.JAK_OPERATOR_LOC;?>/js/emoji.js" type="text/javascript"></script>
<!-- Javascript Stuff necessary for Chat -->
<script type="text/javascript" src="<?php echo BASE_URL;?>js/dropzone.js?=<?php echo JAK_UPDATED;?>"></script>
<?php if (JAK_CRATING) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/rating.js"></script>
<?php } ?>
<script type="text/javascript">
	cross_url = '<?php echo (isset($_SESSION["crossurl"]) ? $_SESSION["crossurl"] : BASE_URL);?>';
	apply_animation = '<?php echo $jakwidget['chat_animation'];?>';
	ls.main_url = "<?php echo BASE_URL;?>";
	jrc_lang = "<?php echo $BT_LANGUAGE;?>";
	ls.files_url = "<?php echo BASE_URL.JAK_FILES_DIRECTORY;?>";
	ls.ls_sound = "<?php echo JAK_CLIENT_SOUND;?>";
	ls.ls_submit = "<?php echo $jkl['g22'];?>";
	ls.ls_slide = <?php echo ($page1 == 1 ? 1 : 0);?>;
	Dropzone.autoDiscover = false;
	$(function() {
  		// Now that the DOM is fully loaded, create the dropzone, and setup the
  		// event listeners
  		var myDropzone = new Dropzone("#cUploadDrop", {dictResponseError: "SERVER ERROR",
	    dictDefaultMessage: '<?php echo (isset($page1) && $page1 == 1 ? '' : '<i class="fa fa-upload"></i> '.addslashes($jkl['g46']));?>',
	    acceptedFiles: "<?php echo JAK_ALLOWED_FILES;?>",
	    url: "<?php echo BASE_URL;?>uploader/uploader.php"});
	    myDropzone.on("sending", function(file, xhr, formData) {
  			// Will send the filesize along with the file as POST data.
  			formData.append("convID", <?php echo $_SESSION['convid'];?>);
  			formData.append("base_url", "<?php echo BASE_URL;?>");
		});
  		myDropzone.on("complete", function(file) {
  			myDropzone.removeAllFiles();
  			loadchat = true;
	        scrollchat = true;
	        getInput();
		});
	});

	$(document).ready(function() {
		$("#emoji").emojioneArea();
		<?php if (isset($page1) && $page1 == 1) { ?>
		iframe_resize($('#lcjframesize').width(), $('#lcjframesize').height(), "<?php echo jak_html_widget_css($jakwidget['floatpopup'], $jakwidget['floatcss'], $jakwidget['floatcsschat']);?>", cross_url);
		<?php } ?>
	});
	
</script>
<?php if (!empty($jakgraphix["chatjs"])) echo '<script type="text/javascript" src="'.BASE_URL.'package/'.$jakwidget['template'].'/'.$jakgraphix["chatjs"].'"></script>';?>
</body>
</html>
<?php ob_flush(); ?>