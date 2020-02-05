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
	$titlefont = $backgroundc = $theme = $slideimg = "";
	if (isset($jakwidget['t_font']) && !empty($jakwidget['t_font'])) $titlefont = 'font-family:'.$jakwidget['t_font'].';';
	if (isset($jakwidget['sucolor']) && !empty($jakwidget['sucolor'])) $backgroundc = 'background:'.$jakwidget['sucolor'].';';
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

		$slideimg = '<div class="lcj-slide-img" style="height:'.$height.'px;"><img src="'.str_replace('include/', '', BASE_URL).JAK_FILES_DIRECTORY.'/slideimg/'.$slideimg.'" width="'.$width.'" height="'.$height.'" alt="live chat"></div>';

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

		// Get the width of the button and add 50px for the hover
		$btnwidthdiv = 'style="width:'.($btnwidth+130).'px;"';

		$btnimg = '<img src="'.str_replace('include/', '', BASE_URL).JAK_FILES_DIRECTORY.'/buttons/'.$buttonimg.'" width="'.$btnwidth.'" height="'.$btnheight.'" alt="live chat">';

	}

	// Check if an operator is online and not blocked
	if ($online_op) {

		// Set the pop up url once, save some code
		$thepoup = '<a href="'.$chatstarturl.'" class="btn-circle"><i class="fa fa-plus"></i></a> <a href="javascript:void(0)" class="btn-circle" onclick="if(navigator.userAgent.toLowerCase().indexOf(\'opera\') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open(\''.$chatstarturlpop.'\', \'livechat3_popup_window\', \'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1\');this.newWindow.focus();this.newWindow.opener=window;return false;">%s</a>';

		// We have a SlideUp
		if ($jakwidget['widget'] == 1 && !isset($_SESSION["clientismobile"])) {

			$widgethtml = '<div id="lcjframesize" class="live-chat-slideup-container '.$jakwidget['theme_colour'].' animated"><div id="lcj-proactive"><p></p><span class="yes" onclick="lcjak_engageOpen();return false;"></span><span class="no" onclick="lcjak_engageClose();return false;"></span></div><div id="lcj-lastmessage"><p></p></div><a href="'.$chatstarturl.'">'.$slideimg.'<div class="lcj-chat-header" style="'.$titlefont.$backgroundc.'color:'.$jakwidget["sutcolor"].'">'.$jakwidget['title'].'</div></a> '.(isset($_SESSION['jrc_userid']) && isset($_SESSION['convid']) ? sprintf($thepoup, '<i class="fa fa-window-maximize"></i>').' <a href="'.$chatendurl.'" class="btn-circle btn-red btn-confirm" data-title="'.addslashes($jkl["g15"]).'" data-text="'.addslashes($jkl["g40"]).'" data-type="" data-okbtn="'.addslashes($jkl["g72"]).'" data-cbtn="'.addslashes($jkl["g73"]).'"><i class="fa fa-power-off"></i></a>' : sprintf($thepoup, '<i class="fa fa-window-maximize"></i>')).'</div>';

			// Set session to slide up
			$_SESSION["setchatstyle"] = 1;

		// We have Button to SlideUp
		} elseif ($jakwidget['widget'] == 2 && !isset($_SESSION["clientismobile"])) {

			$widgethtml = '<div id="lcjframesize" class="live-chat-button-container animated"'.$btnwidthdiv.'><div id="lcj-proactive"><p></p><span class="yes" onclick="lcjak_engageOpen();return false;"></span><span class="no" onclick="lcjak_engageClose();return false;"></span></div><div id="lcj-lastmessage"><p></p></div><a href="'.$chatstarturl.'"><div class="tooltip">'.$jakwidget['title'].'</div>'.$btnimg.'</a></div>';

			// Set session to slide up
			$_SESSION["setchatstyle"] = 1;

		} elseif ($jakwidget['widget'] == 3 && !isset($_SESSION["clientismobile"])) {

			$widgethtml = '<div id="lcjframesize" class="live-chat-button-container animated"><a href="'.$chatstarturl.'"><div id="lcj-proactive"><p></p><span class="yes" onclick="lcjak_engageOpen();return false;"></span><span class="no" onclick="lcjak_engageClose();return false;"></span></div><div id="lcj-lastmessage"><p></p></div>'.$btnimg.'</a></div>';

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
			$thepoup = '<a href="'.$chatcontacturl.'" class="btn-circle"><i class="fa fa-plus"></i></a> <a href="javascript:void(0)" class="btn-circle" onclick="if(navigator.userAgent.toLowerCase().indexOf(\'opera\') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open(\''.$chatcontacturlpop.'\', \'livechat3_popup_window\', \'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1\');this.newWindow.focus();this.newWindow.opener=window;return false;">%s</a>';

			// We have a SlideUp
			if ($jakwidget['widget'] == 1 && !isset($_SESSION["clientismobile"])) {

				$widgethtml = '<div id="lcjframesize" class="live-chat-slideup-container '.$jakwidget['theme_colour'].' animated"><a href="'.$chatcontacturl.'">'.$slideimg.'<div class="lcj-chat-header" style="'.$titlefont.$backgroundc.'color:'.$jakwidget["sutcolor"].'">'.$jakwidget['title'].'</div></a> '.(isset($_SESSION['jrc_userid']) && isset($_SESSION['convid']) ? '<a href="javascript:void(0)" class="btn-circle" id="soundoff" onclick="soundOff();"><i class="fa fa-volume-up"></i></a> '.sprintf($thepoup, '<i class="fa fa-window-maximize"></i>').' <a href="'.$chatcloseurl.'" class="btn-circle"><i class="fa fa-times"></i></a> <a href="'.$chatendurl.'" class="btn-circle btn-red" data-title="'.addslashes($jkl["g15"]).'" data-text="'.addslashes($jkl["g40"]).'" data-type="" data-okbtn="'.addslashes($jkl["g72"]).'" data-cbtn="'.addslashes($jkl["g73"]).'"><i class="fa fa-power-off"></i></a>' : sprintf($thepoup, '<i class="fa fa-window-maximize"></i>')).'</div>';

				// Set session to slide up
				$_SESSION["setchatstyle"] = 1;

			// We have Button to SlideUp
			} elseif ($jakwidget['widget'] == 2 && !isset($_SESSION["clientismobile"])) {

				$widgethtml = '<div id="lcjframesize" class="live-chat-button-container animated"'.$btnwidthdiv.'><a href="'.$chatcontacturl.'"><div class="tooltip">'.$jakwidget['title'].'</div>'.$btnimg.'</a></div>';

				// Set session to slide up
				$_SESSION["setchatstyle"] = 1;

			} elseif ($jakwidget['widget'] == 3 && !isset($_SESSION["clientismobile"])) {

				$widgethtml = '<div id="lcjframesize" class="live-chat-button-container animated"><a href="'.$chatcontacturl.'">'.$btnimg.'</a></div>';

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