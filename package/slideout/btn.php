<?php
// This is the script to determine what we need to load in the iframe

/* Following URL to use
// $chatstarturl (can be quickstart or normal form) please provide both
// $chatcontacturl contact form
*/

// User is blocked, just show nothing
if ($USR_IP_BLOCKED) {
	$widgethtml = '<div id="lcjframesize"></div>';
} else {

	// Get the font for the title
	$titlefont = $backgroundc = $fontcolor = $theme = $slideimg = "";
	if (isset($jakwidget['t_font']) && !empty($jakwidget['t_font'])) $titlefont = 'font-family:'.$jakwidget['t_font'].';';
	if (isset($jakwidget['sucolor']) && !empty($jakwidget['sucolor'])) $backgroundc = 'background:'.$jakwidget['sucolor'].';';
	if (isset($jakwidget['sutcolor']) && !empty($jakwidget['sutcolor'])) $fontcolor = ' style="color:'.$jakwidget["sutcolor"].'"';
	if (isset($jakwidget['theme_colour']) && !empty($jakwidget['theme_colour'])) $theme = " ".$jakwidget['theme_colour'];

	// Set the slide image position
	if (isset($jakwidget['slideimg']) && !empty($jakwidget['slideimg'])) {

		// Get image size
		if ($online_op) {
			list($width, $height) = getimagesize(APP_PATH.JAK_FILES_DIRECTORY.'/slideimg/'.$jakwidget['slideimg']);
			$slideimg = $jakwidget['slideimg'];
		} else {
			list($width, $height) = getimagesize(APP_PATH.JAK_FILES_DIRECTORY.'/slideimg/'.str_replace("_on", "_off", $jakwidget['slideimg']));
			$slideimg = str_replace("_on", "_off", $jakwidget['slideimg']);
		}

		$slideimg = '<div class="lcj-slide-img" style="height:'.$height.'px;"><a href="'.($online_op ? $chatstarturl : $chatcontacturl).'"><img src="'.str_replace('include/', '', BASE_URL).JAK_FILES_DIRECTORY.'/slideimg/'.$slideimg.'" width="'.$width.'" height="'.$height.'" alt="live chat"></a></div>';

	}

	// Set the button image
	if (isset($jakwidget['buttonimg']) && !empty($jakwidget['buttonimg'])) {

		$btnimgmodify = $jakwidget['buttonimg'];
		if (isset($_SESSION["clientismobile"]) && isset($jakwidget['mobilebuttonimg']) && !empty($jakwidget['mobilebuttonimg'])) {
			$btnimgmodify = $jakwidget['mobilebuttonimg'];
		}

		// Get image size
		if ($online_op) {
			list($btnwidth, $btnheight) = getimagesize(APP_PATH.JAK_FILES_DIRECTORY.'/buttons/'.$btnimgmodify);
			$buttonimg = $btnimgmodify;
		} else {
			list($btnwidth, $btnheight) = getimagesize(APP_PATH.JAK_FILES_DIRECTORY.'/buttons/'.str_replace("_on", "_off", $btnimgmodify));
			$buttonimg = str_replace("_on", "_off", $btnimgmodify);
		}

		// Get the width of the button and add 130px for the hover
		$btnwidthdiv = 'style="width:'.($btnwidth+130).'px;"';

		$btnimg = '<img src="'.str_replace('include/', '', BASE_URL).JAK_FILES_DIRECTORY.'/buttons/'.$buttonimg.'" width="'.$btnwidth.'" height="'.$btnheight.'" alt="live chat">';

	}

	// Check if an operator is online and not blocked
	if ($online_op) {

		// Set the pop up url once, save some code
		$thepoup = '<a href="javascript:void(0)" class="lcj-sprite lcj-sprite-popup" onclick="if(navigator.userAgent.toLowerCase().indexOf(\'opera\') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open(\''.$chatstarturlpop.'\', \'livechat3_popup_window\', \'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=640,resizable=1\');this.newWindow.focus();this.newWindow.opener=window;return false;"></a>';

		// We have a SlideOut
		if ($jakwidget['widget'] == 1 || $jakwidget['widget'] == 3) {

			$widgethtml = '<div id="lcjframesize" class="live-chat-slideout-container animated"><div id="lcj-proactive"><p></p><span class="yes" onclick="lcjak_engageOpen();return false;"></span><span class="no" onclick="lcjak_engageClose();return false;"></span></div><div id="lcj-lastmessage"><p></p></div>'.$slideimg.'<div class="lcj-chat-header'.$theme.'" style="'.$titlefont.$backgroundc.'"><a href="'.$chatstarturl.'"><span class="lcj-sprite lcj-sprite-logo"></span><div class="lcj-title"'.$fontcolor.'>'.$jakwidget['title'].'</div></a>'.$thepoup.'</div>';

			// Set session to SlideOut
			$_SESSION["setchatstyle"] = 1;

		// We have Button to SlideUp
		} elseif ($jakwidget['widget'] == 2 || $jakwidget['widget'] == 4) {

			$widgethtml = '<div id="lcjframesize" class="live-chat-button-container animated"'.$btnwidthdiv.'><div id="lcj-proactive"><p></p><span class="yes" onclick="lcjak_engageOpen();return false;"></span><span class="no" onclick="lcjak_engageClose();return false;"></span></div><div id="lcj-lastmessage"><p></p></div><a href="'.$chatstarturl.'">'.$btnimg.'</a></div>';

			// Set session to slide up
			$_SESSION["setchatstyle"] = 1;

		// We have PopUp
		} else {
			
			$widgethtml = '<div id="lcjframesize" class="live-chat-button-container animated"><div id="lcj-proactive"><p></p><span class="yes" onclick="lcjak_engageOpen();return false;"></span><span class="no" onclick="lcjak_engageClose();return false;"></span></div><div id="lcj-lastmessage"><p></p></div><a href="'.$chatstarturlpop.'" onclick="if(navigator.userAgent.toLowerCase().indexOf(\'opera\') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open(\''.$chatstarturlpop.'\', \'livechat3_popup_window\', \'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1\');this.newWindow.focus();this.newWindow.opener=window;return false;">'.$btnimg.'</a></div>';

			// Set session to slide up
			$_SESSION["setchatstyle"] = 2;
		}


	// No operator is online or user is blocked
	} else {

		// We won't show a thing when offline
	    if ((JAK_HOLIDAY_MODE == 2) || isset($jakwidget['hideoff']) && $jakwidget['hideoff'] === 1) {
	        $widgethtml = '<div id="lcjframesize"></div>';

	    // We will show the contact form
	    } else {

	    	// Set the pop up url once, save some code
			$thepoup = '<a href="javascript:void(0)" class="lcj-sprite lcj-sprite-popup" onclick="if(navigator.userAgent.toLowerCase().indexOf(\'opera\') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open(\''.$chatcontacturlpop.'\', \'livechat3_popup_window\', \'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1\');this.newWindow.focus();this.newWindow.opener=window;return false;"></a>';

			// We have a SlideOut
			if ($jakwidget['widget'] == 1 || $jakwidget['widget'] == 3) {

				$widgethtml = '<div id="lcjframesize" class="live-chat-slideout-container animated"><div id="lcj-proactive"><p></p><span class="yes" onclick="lcjak_engageOpen();return false;"></span><span class="no" onclick="lcjak_engageClose();return false;"></span></div><div id="lcj-lastmessage"><p></p></div>'.$slideimg.'<div class="lcj-chat-header'.$theme.'" style="'.$titlefont.$backgroundc.'"><a href="'.$chatcontacturl.'"><span class="lcj-sprite lcj-sprite-logo"></span><div class="lcj-title"'.$fontcolor.'>'.$jakwidget['title'].'</div></a>'.$thepoup.'</div>';

				// Set session to slide up
				$_SESSION["setchatstyle"] = 1;

			// We have Button to SlideUp
			} elseif ($jakwidget['widget'] == 2 || $jakwidget['widget'] == 4) {

				$widgethtml = '<div id="lcjframesize" class="live-chat-button-container animated"'.$btnwidthdiv.'><a href="'.$chatcontacturl.'"><div class="tooltip">'.$jakwidget['title'].'</div>'.$btnimg.'</a></div>';

				// Set session to slide up
				$_SESSION["setchatstyle"] = 1;
					
			// We have PopUp
			} else {
				
				$widgethtml = '<div id="lcjframesize" class="live-chat-button-container animated"><a href="'.$chatcontacturlpop.'" onclick="if(navigator.userAgent.toLowerCase().indexOf(\'opera\') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open(\''.$chatcontacturlpop.'\', \'livechat3_popup_window\', \'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1\');this.newWindow.focus();this.newWindow.opener=window;return false;">'.$btnimg.'</a></div>';

				// Set session to slide up
				$_SESSION["setchatstyle"] = 2;
			}

		}

	}

}

// Finally output the code
echo $widgethtml;

?>