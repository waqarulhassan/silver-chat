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

if (isset($page) && $page == "widget") {

/* Button options in a array in combination with your template/btn.php file  */
$jakgraphix["buttonoptions"] = array("1" => $jkl["g178"], "2" => $jkl["g178"].' ('.$jkl['bw6'].')' , "3" => $jkl["bw10"].' => '.$jkl["g178"], "4" => $jkl["bw10"].' => '.$jkl["g178"].' (no hover)', "5" => $jkl["g179"]);

}

/* Colours an array */
$jakgraphix["themes"] = array("standard","black","white","bluelight","green","red","sand");

/* CSS General */
$jakgraphix["cssgeneral"] = "css/style.css";

/* CSS Preview */
$jakgraphix["csspreview"] = "css/preview.css";

/* Extra JS to use for the start, feedback and contact form */
$jakgraphix["startjs"] = "js/start.js";

/* Extra JS to use for the btn template */
$jakgraphix["btnjs"] = "js/btn.js";

/* Extra JS to use for the chat template */
$jakgraphix["chatjs"] = "js/start.js";

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

/* Header and Font Style */
$jakgraphix["headfont"] = true;

/* SlideUp image available */
$jakgraphix["slideimg"] = true;

/* Connect with operator message / short = 1, long = 2 */
$jakgraphix["connected"] = 2;

/* Load chat designs for the client */
if (isset($lcdnm) && $lcdnm === true) {

global $row;

/* Chat Design General */
$jakgraphix["chatdesign"] = (isset($chatclass) && $chatclass != "user" ? '<div class="media '.$jakwidget['theme_colour'].'" id="postid_'.$row['id'].'"><div class="media-space"><div class="media-content"><a class="media-left" href="javascript:void(0)"><img class="media-object rounded" src="'.$oimage.'" width="53" alt="'.$row['name'].'"></a>
						    <div class="media-body">
						    	<h4>'.$row['name'].' <small class="chat-timestamp">'.JAK_base::jakTimesince($row['time'], "", JAK_TIMEFORMAT).'<span id="edited_'.$row['id'].'">'.($row['editoid'] ? ' | <i class="fa fa-edit"></i> '.JAK_base::jakTimesince($row['edited'], "", JAK_TIMEFORMAT) : '').'</span></small></h4>
						        <p class="media-text" id="msg'.$row['id'].'">'.($row['quoted'] ? '<blockquote class="blockquote"><i class="fa fa-reply"></i> '.$quotemsg.'</blockquote>' : '').stripcslashes($message).'</p>
						    </div>
						    </div>
						    </div>
						</div>' : '<div class="media" id="postid_'.$row['id'].'"><div class="media-space"><div class="media-content"><div class="media-body right">
						    	<h4>'.$row['name'].' <small class="chat-timestamp">'.JAK_base::jakTimesince($row['time'], "", JAK_TIMEFORMAT).'<span id="edited_'.$row['id'].'">'.($row['editoid'] ? ' | <i class="fa fa-edit"></i> '.JAK_base::jakTimesince($row['edited'], "", JAK_TIMEFORMAT) : '').'</span></small></h4>
						        <p class="media-text" id="msg'.$row['id'].'">'.($row['quoted'] ? '<blockquote class="blockquote"><i class="fa fa-reply"></i> '.$quotemsg.'</blockquote>' : '').stripcslashes($message).'</p>
						    </div>
						    <a class="media-right" href="javascript:void(0)"><img class="media-object rounded" src="'.$oimage.'" width="53" alt="'.$row['name'].'"></a>
						    </div>
						    </div>
						</div>');

/* Chat Design Single */
$jakgraphix["chatsingle"] = '<p class="media-text" id="msg'.$row['id'].'">'.($row['quoted'] ? '<blockquote class="blockquote"><i class="fa fa-reply"></i> '.$quotemsg.'</blockquote>' : '').stripcslashes($message).'</p>';

}

/* Load chat designs for the client */
if (isset($lcd) && $lcd === true) {

/* Chat Design dublicate */
$jakgraphix["chatdublic"] = '<div class="media '.$jakwidget['theme_colour'].'"><div class="media-space"><div class="media-content"><a class="media-left" href="javascript:void(0)"><img class="media-object rounded" src="'.$ava_url.'package/standard/avatar/system.jpg" width="53" alt="'.$jkl["g74"].'"></a><div class="media-body"><h4 class="media-heading">'.$jkl["g74"].'<span class="small pull-right chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></h4><p class="media-text">'.stripcslashes($jkl['g75']).'</p></div></div></div></div>';

/* Chat Design bot */
$jakgraphix["chatbot"] = '<div class="media '.$jakwidget['theme_colour'].'" id="postid_'.(isset($lastid) ? $lastid : 0).'"><div class="media-space"><div class="media-content"><a class="media-left" href="javascript:void(0)"><img class="media-object rounded" src="'.$ava_url.'package/standard/avatar/system.jpg" width="53" alt="'.$jkl["g74"].'"></a><div class="media-body"><h4 class="media-heading">'.$jkl["g74"].'<span class="small pull-right chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></h4><p class="media-text" id="msg'.(isset($lastid) ? $lastid : 0).'">'.(isset($answerdisp) ? stripcslashes($answerdisp) : '').'</p></div></div></div></div>';

/* Chat Design Insert */
$jakgraphix["chatinsert"] = '<div class="media" id="postid_'.(isset($lastid) ? $lastid : 0).'"><div class="media-space"><div class="media-content"><div class="media-body right"><h4>'.$_POST['name'].' <small class="chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</small></h4><p class="media-text" id="groupmsg'.(isset($lastid) ? $lastid : 0).'"><span id="msg'.(isset($lastid) ? $lastid : 0).'">'.(isset($messagedisp) ? stripcslashes($messagedisp) : '').'</span></div><a class="media-right" href="javascript:void(0)"><img class="media-object rounded" src="'.$ava_url.$_SESSION['jrc_avatar'].'" width="53" alt="'.$_POST['name'].'"></a></div></div></div>'.$botanswer;

/* Chat Design Insert single */
$jakgraphix["chatinsertsingle"] = '<p class="media-text" id="groupmsg'.(isset($lastid) ? $lastid : 0).'">'.stripcslashes($messagedisp).'</p>';

/* Chat Design Insert ended */
$jakgraphix["chatinsertended"] = '<div class="media '.$jakwidget['theme_colour'].'" id="postid_'.(isset($lastid) ? $lastid : 0).'"><div class="media-space"><div class="media-content"><a class="media-left" href="javascript:void(0)"><img class="media-object rounded" src="'.$ava_url.'package/standard/avatar/system.jpg" width="53" alt="'.$jkl["g56"].'"></a><div class="media-body"><h4 class="media-heading">'.$jkl["g56"].'<span class="small pull-right chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></h4><p class="media-text" id="msg'.(isset($lastid) ? $lastid : 0).'">'.(isset($message) ? stripcslashes($message) : '').'</p></div></div></div></div>';

}

/* Preview Chat */
if (isset($page) && $page == "widget") {

/* Widget Preview */
if ($JAK_FORM_DATA["widget"] == 1 || $JAK_FORM_DATA["widget"] == 2) {
	// Slide up design
	$jakgraphix["widgetpreview"] = '<div id="lcj-chat-main" class="lcpoppreview"><div class="lcj-chat-header" style="background:'.$JAK_FORM_DATA["sucolor"].';color:'.$JAK_FORM_DATA["sutcolor"].'"><span class="lcj-sprite lcj-sprite-logo"></span><div class="lcj-title">'.$JAK_FORM_DATA["title"].'</div><div class="slideimg">'.($JAK_FORM_DATA["slideimg"] ? '<img src="'.BASE_URL_ORIG.JAK_FILES_DIRECTORY.'/slideimg/'.$JAK_FORM_DATA["slideimg"].'" alt="live chat">' : '<div class="slideimg"></div>').'</div><a href="javascript:void(0)" class="lcj-sprite lcj-sprite-popup"></a><a href="javascript:void(0)" class="lcj-sprite lcj-sprite-close"></a></div></div>';
} else {
	// Button in terms of an image
	$jakgraphix["widgetpreview"] = '<div id="chat_preview_button"><img src="'.BASE_URL_ORIG.JAK_FILES_DIRECTORY.'/buttons/'.$JAK_FORM_DATA["buttonimg"].'" alt="button"></div>';
}

/* Chat Preview */
$jakgraphix["previewchat"] = '<div id="classic-preview" class="direct-chat-messages-preview">
		  		
			  		<div class="media">
			  			<img class="d-flex mr-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/standard/avatar/system.jpg" alt="system" width="53">
			  		    <div class="media-body">
			  		    	<h4 class="media-heading h4-preview">System <small class="direct-chat-timestamp">1 minute ago</small></h4>
			  		        <span class="classic-text-preview">This is a system message.</span>
			  		    </div>
			  		</div>
			  		<hr>
			  		<div class="media">
			  		      <img class="d-flex mr-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/standard/avatar/1.jpg" width="53" alt="operator">
			  		      <div class="media-body">
			  		          <h4 class="media-heading h4-preview">Operator <small class="direct-chat-timestamp">2 minute ago</small>
			  		          </h4>
			  		          <span class="classic-text-preview">This is a operator message.</span>
			  		      </div>
			  		  </div>
			  		<hr>
			  		<div class="media">
			  		      <div class="media-body text-right">
			  		          <h4 class="media-heading h4-preview">Client <small class="direct-chat-timestamp">3 minute ago</small>
			  		          </h4>
			  		          <span class="classic-text-preview">This is a client message.</span>
			  		      </div>
			  		      <img class="d-flex ml-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/standard/avatar/3.jpg" width="53" alt="client">
			  		  </div>
			  		<hr>
			  		<div class="media">
			  		      <img class="d-flex mr-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/standard/avatar/1.jpg" width="53" alt="operator">
			  		      <div class="media-body">
			  		          <h4 class="media-heading h4-preview">Operator <small class="direct-chat-timestamp">4 minute ago</small>
			  		          </h4>
			  		          <span class="classic-text-preview">This is a operator message.</span>
			  		      </div>
			  		</div>
			  		<hr>
			  		<div class="media">
			  		      <div class="media-body text-right">
			  		          <h4 class="media-heading h4-preview">Client <small class="direct-chat-timestamp">5 minute ago</small>
			  		          </h4>
			  		          <span class="classic-text-preview">This is a client message with a <a href="javascript:void(0)" class="chat-link-preview">Link</a>.</span>
			  		      </div>
			  		       <img class="d-flex ml-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/standard/avatar/3.jpg" width="53" alt="client">
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