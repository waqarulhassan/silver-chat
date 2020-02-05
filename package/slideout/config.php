<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2017 JAKWEB All Rights Reserved # ||
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
$jakgraphix["buttonoptions"] = array("1" => $jkl["bw7"], "2" => $jkl["bw10"].' => '.$jkl["bw7"], "3" => $jkl["bw7"].' ('.$jkl['g134'].')', "4" => $jkl["bw10"].' => '.$jkl["bw7"].' ('.$jkl['g134'].')', "5" => $jkl["g179"]);

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
$jakgraphix["chatdesign"] = (isset($chatclass) && $chatclass != "user" ? '<div class="media '.$jakwidget['theme_colour'].'" id="postid_'.$row['id'].'"><div class="media-space"><div class="media-content"><a class="media-left" href="javascript:void(0)"><img class="media-object rounded" src="'.$oimage.'" width="45" alt="'.$row['name'].'"></a>
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
						    <a class="media-right" href="javascript:void(0)"><img class="media-object rounded" src="'.$oimage.'" width="45" alt="'.$row['name'].'"></a>
						    </div>
						    </div>
						</div>');

/* Chat Design Single */
$jakgraphix["chatsingle"] = '<p class="media-text" id="msg'.$row['id'].'">'.($row['quoted'] ? '<blockquote class="blockquote"><i class="fa fa-reply"></i> '.$quotemsg.'</blockquote>' : '').stripcslashes($message).'</p>';

}

/* Load chat designs for the client */
if (isset($lcd) && $lcd === true) {

/* Chat Design dublicate */
$jakgraphix["chatdublic"] = '<div class="media '.$jakwidget['theme_colour'].'"><div class="media-space"><div class="media-content"><a class="media-left" href="javascript:void(0)"><img class="media-object rounded" src="'.$ava_url.'package/slideout/avatar/system.jpg" width="45" alt="'.$jkl["g74"].'"></a><div class="media-body"><h4 class="media-heading">'.$jkl["g74"].'<span class="small pull-right chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></h4><p class="media-text">'.stripcslashes($jkl['g75']).'</p></div></div></div></div>';

/* Chat Design bot */
$jakgraphix["chatbot"] = '<div class="media '.$jakwidget['theme_colour'].'" id="postid_'.(isset($lastid) ? $lastid : 0).'"><div class="media-space"><div class="media-content"><a class="media-left" href="javascript:void(0)"><img class="media-object rounded" src="'.$ava_url.'package/slideout/avatar/system.jpg" width="45" alt="'.$jkl["g74"].'"></a><div class="media-body"><h4 class="media-heading">'.$jkl["g74"].'<span class="small pull-right chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></h4><p class="media-text" id="msg'.(isset($lastid) ? $lastid : 0).'">'.(isset($answerdisp) ? stripcslashes($answerdisp) : '').'</p></div></div></div></div>';

/* Chat Design Insert */
$jakgraphix["chatinsert"] = '<div class="media" id="postid_'.(isset($lastid) ? $lastid : 0).'"><div class="media-space"><div class="media-content"><div class="media-body right"><h4>'.$_POST['name'].' <small class="chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</small></h4><p class="media-text" id="groupmsg'.(isset($lastid) ? $lastid : 0).'"><span id="msg'.(isset($lastid) ? $lastid : 0).'">'.(isset($messagedisp) ? stripcslashes($messagedisp) : '').'</span></div><a class="media-right" href="javascript:void(0)"><img class="media-object rounded" src="'.$ava_url.$_SESSION['jrc_avatar'].'" width="45" alt="'.$_POST['name'].'"></a></div></div></div>'.$botanswer;

/* Chat Design Insert single */
$jakgraphix["chatinsertsingle"] = '<p class="media-text" id="groupmsg'.(isset($lastid) ? $lastid : 0).'">'.stripcslashes($messagedisp).'</p>';

/* Chat Design Insert ended */
$jakgraphix["chatinsertended"] = '<div class="media '.$jakwidget['theme_colour'].'" id="postid_'.(isset($lastid) ? $lastid : 0).'"><div class="media-space"><div class="media-content"><a class="media-left" href="javascript:void(0)"><img class="media-object rounded" src="'.$ava_url.'package/slideout/avatar/system.jpg" width="45" alt="'.$jkl["g56"].'"></a><div class="media-body"><h4 class="media-heading">'.$jkl["g56"].'<span class="small pull-right chat-timestamp">'.JAK_base::jakTimesince(date('Y-m-d H:i:s'), "", JAK_TIMEFORMAT).'</span></h4><p class="media-text" id="msg'.(isset($lastid) ? $lastid : 0).'">'.(isset($message) ? stripcslashes($message) : '').'</p></div></div></div></div>';

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
			  			<img class="d-flex mr-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/slideout/avatar/system.jpg" alt="system" width="45">
			  		    <div class="media-body">
			  		    	<h4 class="media-heading h4-preview">System <small class="direct-chat-timestamp">1 minute ago</small></h4>
			  		        <span class="classic-text-preview">This is a system message.</span>
			  		    </div>
			  		</div>
			  		<hr>
			  		<div class="media">
			  		      <img class="d-flex mr-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/slideout/avatar/1.jpg" width="45" alt="operator">
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
			  		      <img class="d-flex ml-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/slideout/avatar/3.jpg" width="45" alt="client">
			  		  </div>
			  		<hr>
			  		<div class="media">
			  		      <img class="d-flex mr-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/slideout/avatar/1.jpg" width="45" alt="operator">
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
			  		       <img class="d-flex ml-3 img-thumbnail" src="'.BASE_URL_ORIG.'package/slideout/avatar/3.jpg" width="45" alt="client">
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

/* Custom functions */
// Verfiy if there is a online operator
if (!function_exists('online_operator_list')) {
	function online_operator_list($dp, $did = 0, $oid = 0) {
		
		$timeout = time() - 300;
		$timerunout = 1;
		$department = 0;
		$opdetails = array();
		
		global $jakdb;

	    // Check if the client is logged in
	    $dbfiltered = $dp;
		
		// Update database first to see who is online!
		$jakdb->update("user", ["available" => 0], ["lastactivity[<]" => $timeout]);

		// Set to zero
		$sql_where = '';
		
		// We do have a department id
		if ($did > 0) {
			$sql_where = ' AND (departments = 0 OR FIND_IN_SET(:did, departments))';
		}
		
		// We do have an operator id
		if ($oid > 0) {
			$sql_where = ' AND id = :oid';
		}

		$sth = $jakdb->pdo->prepare("SELECT id, name, picture, hours_array, phonenumber, available, departments, emailnot, pusho_tok, push_notifications FROM ".JAKDB_PREFIX."user WHERE access = 1".$sql_where." ORDER BY departments ASC");

		if ($oid > 0)$sth->bindParam(':oid', $oid, PDO::PARAM_INT);
		if ($did > 0 && $oid == 0) $sth->bindParam(':did', $did, PDO::PARAM_INT);

		$sth->execute();

		$result = $sth->fetchAll();

		if (isset($result) && !empty($result)) {
			foreach ($result as $row) {
				
				$oponline = false;
				
				// Operator is available
				if ($row["available"] == 1) $oponline = true;
				
				// Now let's check if we have a time available
				if (!$oponline && JAK_base::jakAvailableHours($row["hours_array"], date('Y-m-d H:i:s')) && ($row["phonenumber"] || $row["emailnot"] || JAK_NATIVE_APP_TOKEN || $row["pusho_tok"] || $row["push_notifications"])) $oponline = true;
				
				// Now we have an available operator
				if ($oponline) {

					// Get the user stats
					$ustat = $jakdb->count("user_stats", "id", ["AND" => ["userid" => $row["id"], "vote[>]" => 2]]);
				
					// Departments is 0 we use all.
					$deptitle = "";
					if (is_numeric($row["departments"])) {
					
						if (isset($dbfiltered) && is_array($dbfiltered)) foreach($dbfiltered as $z) {
						
							if ($z["id"] == $row["departments"]) {
								$deptitle = $z["title"];
							}
						
						}
					// Department array, let's get the right ones.
					} elseif ($row["departments"] != 0 && !is_numeric($row["departments"])) {
						
						if (isset($dbfiltered) && is_array($dbfiltered)) foreach($dbfiltered as $z) {
						
							if (in_array($z["id"], explode(',', $row["departments"]))) {
								$deptitle = $z["title"];
							}
						
						}
					
					}

					$opdetails[] = array("id" => $row["id"], "name" => $row["name"], "picture" => $row["picture"], "sum" => $ustat, "title" => $deptitle);
				}
			
			}
			
		} else {
			$timerunout = 0;
		}
		
		if ($timerunout) {
			return $opdetails;
		} else {
			return false;
		}
	}
}

// Set or unset the operator
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['template']) && $_POST['template'] == "slideout") {

	if (isset($_POST["opid"]) && is_numeric($_POST["opid"]) && $_POST["opid"] != 0 && $jakdb->has("user", ["id" => $_POST["opid"]])) {
		$_SESSION["select_operator"] = $_POST["opid"];
	} else {
		unset($_SESSION["select_operator"]);
	}

	/* Outputtng the error messages */
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		header('Cache-Control: no-cache');
		die(json_encode(array('status' => 1)));
					
	}
}
?>