<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Language file goes global
global $jkl;

/* Leave a var empty if not in use or set to false */
$jakgraphix = array();

/* Avatars */
$jakgraphix["avatar"] = "avatar/standard.jpg";
$jakgraphix["av1"] = "avatar/1.jpg";
$jakgraphix["av2"] = "avatar/2.jpg";
$jakgraphix["av3"] = "avatar/3.jpg";
$jakgraphix["av4"] = "avatar/4.jpg";
$jakgraphix["av5"] = "avatar/5.jpg";
$jakgraphix["system"] = "avatar/system.jpg";

/* Live Chat Slide Up Template */
$jakgraphix["slideup"] = "slide_up/";

/* Live Chat Slide Up Template */
$jakgraphix["popup"] = "pop_up/";

/* Extra Sounds if any */
$jakgraphix["sound"] = "sound/";

/* Preview Chat */
if (isset($page) && $page == "widget") {

/* Button options in a array in combination with your template/btn.php file  */
$jakgraphix["buttonoptions"] = array("1" => $jkl["g178"], "2" => $jkl["bw10"].' => '.$jkl["g178"], "3" => $jkl["bw10"].' => '.$jkl["g178"].' (no hover)', "4" => $jkl["g179"]);

/* Colours in a array */
$jakgraphix["themes"] = array("standard","red","blue","orange","yellow","green");

}

/* CSS General */
$jakgraphix["cssgeneral"] = "css/style.css";

/* CSS Preview */
$jakgraphix["csspreview"] = "css/preview.css";

/* Extra JS to use for the start, feedback and contact form */
$jakgraphix["startjs"] = "js/start.js";

/* Extra JS to use for the btn template */
$jakgraphix["btnjs"] = "js/btn.js";

/* Extra JS to use for the chat template */
$jakgraphix["chatjs"] = "js/chat.js";

/* Include Bootstrap 4 Stylesheet 1 = Yes, 0 = No */
$jakgraphix["cssbs4"] = 1;

/* Include FontAwesome Stylesheet 1 = Yes, 0 = No */
$jakgraphix["cssfa"] = 1;

/* Include Animate Stylesheet 1 = Yes, 0 = No */
$jakgraphix["cssanim"] = 1;

/* Include Emoji Stylesheet for Smilies 1 = Yes, 0 = No */
$jakgraphix["cssemoj"] = 1;

/* Include Dropzone Stylesheet for Uploading files 1 = Yes, 0 = No */
$jakgraphix["cssdz"] = 1;

/* Header and Font Style */
$jakgraphix["headfont"] = true;

/* SlideUp image available */
$jakgraphix["slideimg"] = true;

/* Connect with operator message / short = 1, long = 2 */
$jakgraphix["connected"] = 1;

/* Load chat designs for the client */
if (isset($lcdnm) && $lcdnm === true) {

global $row;

/* Chat Design General */
$jakgraphix["chatdesign"] = '<div class="direct-chat-msg'.(isset($chatclass) && $chatclass != "user" ? " right" : "").'" id="postid_'.$row['id'].'">
					<img class="direct-chat-img" src="'.$oimage.'" alt="'.$row['name'].'">
					<div class="direct-chat-text"><div class="direct-chat-info">
					<span class="direct-chat-name">'.$row['name'].'</span>
					<span class="chat-timestamp">'.JAK_base::jakTimesince($row['time'], "", JAK_TIMEFORMAT).'</span>
					<span id="edited_'.$row['id'].'">'.($row['editoid'] ? ' | <i class="fa fa-edit"></i> '.JAK_base::jakTimesince($row['edited'], "", JAK_TIMEFORMAT) : '').'</span>
					</div>'.($row['quoted'] ? '<blockquote class="blockquote"><i class="fa fa-reply"></i> '.$quotemsg.'</blockquote>' : '').'<span id="msg'.$row['id'].'">'.stripcslashes($message).'</span></div></div>';

/* Chat Design Single */
$jakgraphix["chatsingle"] = '<div class="direct-chat-text animated slideInUp" id="msg'.$row['id'].'">'.($row['quoted'] ? '<blockquote class="blockquote"><i class="fa fa-reply"></i> '.$quotemsg.'</blockquote>' : '').stripcslashes($message).'</div>';

}

/* Load chat designs for the client */
if (isset($lcd) && $lcd === true) {

/* Chat Design dublicate */
$jakgraphix["chatdublic"] = '<div class="direct-chat-msg right animated jello"><img class="direct-chat-img" src="'.$ava_url.'package/smooth/avatar/system.jpg" alt="'.$jkl["g74"].'"><div class="direct-chat-text"><div class="direct-chat-info"><span class="direct-chat-name">'.$jkl["g74"].'</span> <span class="chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></div>'.stripcslashes($jkl['g75']).'</div></div>';

/* Chat Design bot */
$jakgraphix["chatbot"] = '<div class="direct-chat-msg right animated jello"><img class="direct-chat-img" src="'.$ava_url.'package/smooth/avatar/system.jpg" alt="'.$jkl["g74"].'"><div class="direct-chat-text"><div class="direct-chat-info"><span class="direct-chat-name">'.$jkl["g74"].'</span> <span class="chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></div>'.(isset($answerdisp) ? stripcslashes($answerdisp) : '').'</div></div>';

/* Chat Design Insert */
$jakgraphix["chatinsert"] = '<div class="direct-chat-msg animated jello" id="postid_'.(isset($lastid) ? $lastid : 0).'"><img class="direct-chat-img" src="'.$ava_url.$_SESSION['jrc_avatar'].'" alt="'.$_SESSION['jrc_name'].'"><div class="direct-chat-text" id="groupmsg'.(isset($lastid) ? $lastid : 0).'"><div class="direct-chat-info"><span class="direct-chat-name">'.(isset($_POST['name']) ? $_POST['name'] : '').'</span> <span class="chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></div><span id="msg'.(isset($lastid) ? $lastid : 0).'">'.(isset($messagedisp) ? stripcslashes($messagedisp) : '').'</span></div></div>'.$botanswer;

/* Chat Design Insert single */
$jakgraphix["chatinsertsingle"] = '<div class="direct-chat-text animated slideInUp" id="groupmsg'.(isset($lastid) ? $lastid : 0).'">'.(isset($messagedisp) ? stripcslashes($messagedisp) : '').'</div>';

/* Chat Design Insert ended */
$jakgraphix["chatinsertended"] = '<div class="direct-chat-msg animated slideInUp" id="postid_'.(isset($lastid) ? $lastid : 0).'"><img class="direct-chat-img" src="'.$ava_url.'package/smooth/avatar/system.jpg" alt="'.$jkl["g56"].'"><div class="direct-chat-text"><div class="direct-chat-info"><span class="direct-chat-name">'.$jkl["g56"].'</span> <span class="chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></div><span id="msg'.(isset($lastid) ? $lastid : 0).'">'.(isset($message) ? stripcslashes($message) : '').'</span></div></div>';

}

/* Preview Chat */
if (isset($page) && $page == "widget") {

/* Widget Preview */
if ($JAK_FORM_DATA["widget"] == 1) {
	// Slide up design
	$jakgraphix["widgetpreview"] = '<div id="lcjframesize" class="live-chat-slideup-container">'.($JAK_FORM_DATA["slideimg"] ? '<div class="slideimg"><img src="'.BASE_URL_ORIG.JAK_FILES_DIRECTORY.'/slideimg/'.$JAK_FORM_DATA["slideimg"].'" alt="live chat"></div>' : '<div class="slideimg"></div>' ).'<div class="lcj-chat-header" style="background:'.$JAK_FORM_DATA["sucolor"].';color:'.$JAK_FORM_DATA["sutcolor"].'">'.$JAK_FORM_DATA["title"].'</div><a href="javascript:void(0)" class="btn-circle"><i class="fa fa-plus"></i></a> <a href="javascript:void(0)" class="btn-circle" ><i class="fa fa-window-maximize"></i></a></div>';
} else {
	// Button in terms of an image
	$jakgraphix["widgetpreview"] = '<div id="chat_preview_button"><img src="'.BASE_URL_ORIG.JAK_FILES_DIRECTORY.'/buttons/'.$JAK_FORM_DATA["buttonimg"].'" alt="button"></div>';
}

/* Chat Preview */
$jakgraphix["previewchat"] = '<div id="smooth-preview" class="jrc_chat_form_slide direct-chat-'.$JAK_FORM_DATA["theme_colour"].'">
		  				
		  			<!--- Chat output -->
		  			<div class="direct-chat-messages-preview">
		  				<div class="direct-chat-msg">
		  					<div class="direct-chat-info clearfix">
		  						<span class="direct-chat-name pull-left h4-preview">System</span>
		  						<span class="direct-chat-timestamp pull-right">1 minute ago</span>
		  					</div>
		  					<img class="direct-chat-img" src="'.BASE_URL_ORIG.'package/smooth/avatar/system.jpg" alt="System">
		  					<div class="direct-chat-text">This is a system message.</div>
		  				</div>
		  				<div class="direct-chat-msg right">
			  				<div class="direct-chat-info clearfix">
			  					<span class="direct-chat-name pull-left h4-preview">Operator</span>
			  					<span class="direct-chat-timestamp pull-right">2 minute ago</span>
			  				</div>
		  					<img class="direct-chat-img" src="'.BASE_URL_ORIG.'package/smooth/avatar/1.jpg" alt="operator">
		  					<div class="direct-chat-text">This is a operator message.</div>
		  				</div>
		  				<div class="direct-chat-msg">
		  					<div class="direct-chat-info clearfix">
		  						<span class="direct-chat-name pull-left h4-preview">Client</span>
		  						<span class="direct-chat-timestamp pull-right">3 minute ago</span>
		  					</div>
		  					<img class="direct-chat-img" src="'.BASE_URL_ORIG.'package/smooth/avatar/3.jpg" alt="client">
		  					<div class="direct-chat-text">This is a client message.</div>
		  				</div>
		  				<div class="direct-chat-msg right">
		  					<div class="direct-chat-info clearfix">
		  						<span class="direct-chat-name pull-left h4-preview">Operator</span>
		  						<span class="direct-chat-timestamp pull-right">4 minute ago</span>
		  					</div>
		  					<img class="direct-chat-img" src="'.BASE_URL_ORIG.'package/smooth/avatar/1.jpg" alt="operator">
		  					<div class="direct-chat-text">This is a operator message.</div>
		  				</div>
		  				<div class="direct-chat-msg">
		  					<div class="direct-chat-info clearfix">
		  						<span class="direct-chat-name pull-left h4-preview">Client</span>
		  						<span class="direct-chat-timestamp pull-right">5 minute ago</span>
		  					</div>
		  					<img class="direct-chat-img" src="'.BASE_URL_ORIG.'package/smooth/avatar/3.jpg" alt="client">
		  					<div class="direct-chat-text">This is a client message with a <a href="javascript:void(0)" class="chat-link-preview">Link</a>.</div>
		  				</div>
		  			</div>
		  			
		  		</div>';

/* Preview Contact Form */
$jakgraphix["previewcontact"] = '<div class="row">
	  				<div class="col-sm-6">
	  					<div class="form-group">
	  					    <label class="control-label classic-text-preview" for="name">'.$jkl["u"].'</label>
	  						<input type="text" name="name" id="name" class="form-control" placeholder="'.$jkl["u"].'">
	  					</div>
	  				</div>
	  				<div class="col-sm-6">
	  					<div class="form-group">
	  					    <label class="control-label classic-text-preview" for="email">'.$jkl["u1"].'</label>
	  						<input type="text" name="email" id="email" class="form-control" placeholder="'.$jkl["u1"].'">
	  					</div>
	  				</div>
	  			</div>
	  			<div class="form-group">
	  			    <label class="control-label classic-text-preview" for="phone">'.$jkl["u14"].'</label>
	  				<input type="text" name="phone" id="phone" class="form-control" placeholder="'.$jkl["u14"].'">
	  			</div>
	  			<div class="form-group">
	  			    <label class="control-label classic-text-preview" for="message">'.$jkl["g146"].'</label>
	  			    <textarea name="message" id="message" rows="5" class="form-control"></textarea>
	  			</div>
	  		</div>';
}
?>