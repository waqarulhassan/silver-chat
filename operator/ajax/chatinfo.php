<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.7.2                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[oprequests.php] config.php not exist');
require_once '../../config.php';

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !isset($_SESSION['jak_lcp_idhash'])) die("Nothing to see here");

if (!is_numeric($_POST['uid']) && !is_numeric($_POST['convid'])) die("There is no such conversation");

// Check if user is logged in
$jakuserlogin = new JAK_userlogin();
$jakuserrow = $jakuserlogin->jakChecklogged();
$jakuser = new JAK_user($jakuserrow);

// Import the user or standard language file
if (isset($_SESSION['jak_lcp_lang']) && file_exists(APP_PATH.JAK_OPERATOR_LOC.'/lang/'.$_SESSION['jak_lcp_lang'].'.php')) {
    include_once(APP_PATH.JAK_OPERATOR_LOC.'/lang/'.$_SESSION['jak_lcp_lang'].'.php');
} else {
    include_once(APP_PATH.JAK_OPERATOR_LOC.'/lang/'.JAK_LANG.'.php');
}

$switchc = '';
if (isset($_POST['creq']) && !empty($_POST['creq'])) $switchc = $_POST['creq'];

switch ($switchc) {
	case 'info':
		# code
		$row = $jakdb->get("sessions", ["[>]departments" => ["department" => "id"], "[>]buttonstats" => ["session" => "session"], "[>]checkstatus" => ["id" => "convid"]], ["sessions.id", "sessions.department", "sessions.operatorid", "sessions.usr_avatar", "sessions.name", "sessions.email", "sessions.country", "sessions.city", "sessions.latitude", "sessions.longitude", "sessions.countrycode", "sessions.initiated", "sessions.operatorname", "sessions.status", "departments.title(dep_title)", "buttonstats.referrer", "buttonstats.firstreferrer", "buttonstats.agent", "buttonstats.hits", "buttonstats.ip", "checkstatus.files"], ["sessions.id" => $_POST['convid']]);

		if (isset($row) && !empty($row)) {
			
			// Reset
			$showphone = $showemail = $responses = $transferc = $knockknock = $endsess = '';
			
			// Show standard flag
			$usrc = $row['ip'];
			// Show country code
			if (isset($row['countrycode']) && !empty($row['countrycode']) && $row['countrycode'] != 'xx') $usrc = '<img src="'.str_replace("ajax/", "", BASE_URL).'img/blank.png" class="flag flag-'.$row['countrycode'].'" alt="'.$row['country'].'" title="'.$row['country'].' - '.$row['city'].'"> '.$row['ip'];
			// Show email
			if (filter_var($row['email'], FILTER_VALIDATE_EMAIL)) $showemail = '<p class="text-muted"><i class="fa fa-envelope-o"></i> '.$row['email'].'</p>';
			// Chat is active
			if ($row["status"]) {
				// Show files 
				$usrf = '<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="usrFiles('.$row['id'].');" id="user_files"><i class="fa fa-lock"></i> '.$jkl['u9'].'</a>';
				// Allowed to send files
				if ($row['files']) $usrf = ' <a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="usrFiles('.$row['id'].');" id="user_files"><i class="fa fa-check"></i> '.$jkl['u9'].'</a>';
				$knockknock = ' <a data-toggle="modal" class="btn btn-primary btn-sm" href="'.BASE_URL.'knockknock.php?id='.$row['id'].'" data-target="#jakModal"><i class="fa fa-bell"></i> '.$jkl['g223'].'</a>';
				// Can transfer clients
				if ($jakuser->getVar("transferc")) $transferc = '<a data-toggle="modal" class="btn btn-warning btn-sm" href="'.BASE_URL.'transfer.php?id='.$row['id'].'&amp;userid='.$row['operatorid'].'" data-target="#jakModal"><i class="fa fa-share-alt"></i> '.$jkl['g286'].'</a>';
				// end session
				$endsess = ' <a data-toggle="modal" class="btn btn-danger btn-sm" href="'.BASE_URL.'delconv.php?id='.$row['id'].'" data-target="#jakModal"><i class="fa fa-power-off"></i> '.$jkl['g62'].'</a>';

			}

			$clientinfo = '<h3><i class="fa fa-info"></i> '.$jkl['g40'].'</h3><div class="info-side-messages">';

			$clientinfo .= '<div class="media">
					<img class="d-flex mr-3 img-thumbnail" src="'.str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.$row['usr_avatar']).'" width="53" height="53" alt="'.$row['name'].'">
				    <div class="media-body">
				    	<h4 class="media-heading">'.$row['name'].'</h4>
				        <div class="media-text">
				        	<p class="text-muted"><i class="fa fa-clock-o"></i> '.JAK_base::jakTimesince($row['initiated'], "", JAK_TIMEFORMAT).' | <i class="fa fa-globe"></i> '.$usrc.' | <i class="fa fa-eye"></i> '.$row['hits'].'</p>
				        	'.$showemail.'
				        	<p class="text-muted"><i class="fa fa-university"></i> '.$row["dep_title"].'</p>
				        	<p class="text-muted"><i class="fa fa-laptop"></i> '.$row['agent'].'</p>
				        	<p class="text-muted"><i class="fa fa-link"></i> '.$row['referrer'].'</p>
				        </div>
				    </div>
				</div>
				<hr>';

			$clientinfo .= '<p>'.$usrf.$knockknock.'</p><p> <a data-toggle="modal" class="btn btn-success btn-sm" href="'.str_replace("ajax/", "", JAK_rewrite::jakParseurl('notes', $row['id'])).'" data-target="#jakModal"><i class="fa fa-comment-o"></i> '.$jkl['g181'].'</a> '.$transferc.$endsess.'</p>
				<hr>';
			
			if (JAK_SHOW_IPS && $row['latitude']) {

				$clientinfo .= '<div id="cmap_canvas" style="height: 300px;"></div><script type="text/javascript">
				    var cmap = L.map("cmap_canvas", {zoomControl:true}).setView(['.$row['latitude'].','.$row['longitude'].'], 8);

				    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
				      attribution: \'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, \' +
				            \'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>\'
				    }).addTo(cmap);

				    // Disable drag and zoom handlers.
				    cmap.dragging.disable();
				    cmap.touchZoom.disable();
				    cmap.doubleClickZoom.disable();
				    cmap.scrollWheelZoom.disable();

				    var marker = L.marker(['.$row['latitude'].','.$row['longitude'].']).addTo(cmap);
				    marker.bindPopup("'.$row['country'].' | '.$row['city'].'").openPopup();

				</script>';
				
			}

			$clientinfo .= '</div>';

		die(json_encode(array('status' => 1, 'html' => $clientinfo)));

	}
		die(json_encode(array('status' => 0, 'text' => $jkl['i2'])));
	break;
	case 'edit':
		# code...
		$row = $jakdb->get("sessions", ["id", "operatorid", "name", "email", "phone", "notes"], ["id" => $_POST['convid']]);

		if (isset($row) && !empty($row)) {

			$editclient = '<h3><i class="fa fa-edit"></i> '.$jkl['g287'].'</h3><div class="info-side-messages"><form id="cNotes" method="post" action="'.$_SERVER['REQUEST_URI'].'">';

			// Name
			$editclient .= '<div class="form-group">
			    <label for="name">'.$jkl["g54"].'</label>
				<input type="text" name="name" id="name" class="form-control" placeholder="'.$jkl["g54"].'" value="'.$row['name'].'">
			</div>';

			// Email
			$editclient .= '<div class="form-group">
			    <label for="email">'.$jkl['u1'].'</label>
				<input type="text" name="email" id="email" class="form-control" placeholder="'.$jkl['u1'].'" value="'.$row['email'].'">
			</div>';

			// Phone
			$editclient .= '<div class="form-group">
			    <label for="phone">'.$jkl['u14'].'</label>
				<input type="text" name="phone" id="phone" class="form-control" placeholder="'.$jkl['u14'].'" value="'.$row['phone'].'">
			</div>';

			// Notes
			$editclient .= '<div class="form-group">
			    <label for="note">'.$jkl["g181"].'</label>
				<textarea rows="5" name="note" id="note" class="form-control" placeholder="'.$jkl["g181"].'">'.$row['notes'].'</textarea>
			</div>';

			$editclient .= '<button type="submit" id="formsubmit" class="btn btn-primary btn-block">'.$jkl["g38"].'</button><input type="hidden" name="edit_customer" value="1"><input type="hidden" name="uid" value="'.$row['operatorid'].'"><input type="hidden" name="convid" id="convid" value="'.$row['id'].'"></form><script type="text/javascript" src="'.str_replace("ajax/", "", BASE_URL."js/notes.js").'"></script>';

			$editclient .= '</div>';

			die(json_encode(array('status' => 1, 'html' => $editclient)));
		}

		die(json_encode(array('status' => 0, 'text' => $jkl['i2'])));
	break;
	case 'search':
		# code...
		$searchmsg = '<h3><i class="fa fa-search"></i> '.$jkl['s6'].'</h3><div class="info-side-messages">';

		// Name
		$searchmsg .= '<div class="form-group">
			    <label class="sr-only" for="name">'.$jkl["s5"].'</label>
				<input type="text" name="name" id="name" class="form-control" onkeyup="showResult(this.value,'.$_POST['convid'].')" placeholder="'.$jkl["s5"].'">
			</div>';

		$searchmsg .= '<div id="livesearch"></div>';

		$searchmsg .= '<script type="text/javascript" src="'.str_replace("ajax/", "", BASE_URL."js/search.js").'"></script>';

		$searchmsg .= '</div>';

		die(json_encode(array('status' => 1, 'html' => $searchmsg)));

	break;
	case 'files':
		# code...
		$result = $jakdb->select("transcript", ["[>]user" => ["operatorid" => "id"], "[>]sessions" => ["convid" => "id"]], ["transcript.id", "transcript.name", "transcript.message", "transcript.operatorid", "transcript.time", "transcript.class", "transcript.quoted", "transcript.edited", "transcript.editoid", "transcript.convid", "user.picture", "sessions.usr_avatar"], ["AND" => ["transcript.convid" => $_POST['convid'], "transcript.class" => "download"], "ORDER" => ["transcript.id" => "ASC"]]);

		if (isset($result) && !empty($result)) {

			$sharedfiles = '<h3><i class="fa file-archive-o"></i> '.$jkl['g288'].'</h3><div class="info-side-messages">';

			foreach ($result as $row) {

				// On which class to show a system image
				$systemimg = array("bot", "notice", "url", "ended");
				
				$oimage = str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.$row["usr_avatar"]);
				if ($row["picture"] && $row["operatorid"]) $oimage = str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.JAK_FILES_DIRECTORY.$row["picture"]);
				if (in_array($row["class"], $systemimg)) $oimage = str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.JAK_FILES_DIRECTORY."/system.jpg");

				// Convert the message into something nice
				$message = $row['message'];
				$lightbox = "";
	    		if (getimagesize(APP_PATH.$message)) $lightbox = ' data-toggle="lightbox"';
	    		$message = '<a'.$lightbox.' href="'.str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.$message).'" target="_blank">'.basename($message).'</a>';

				$sharedfiles .= '<div class="media">
						<img class="d-flex mr-3 img-thumbnail" src="'.$oimage.'" width="53" height="53" alt="'.$row['name'].'">
					    <div class="media-body">
					    	<h4 class="media-heading">'.$row['name'].' <small>'.JAK_base::jakTimesince($row['time'], "", JAK_TIMEFORMAT).($row['editoid'] ? ' | <i class="fa fa-edit"></i> '.JAK_base::jakTimesince($row['edited'], "", JAK_TIMEFORMAT) : '').'</small>'.(!in_array($row["class"], $systemimg) ? ' <div class="chat-edit"><a href="javascript:void(0)" class="chat-edit-link clipboard" data-clipboard-target="#msg'.$row['id'].'"><i class="fa fa-clipboard"></i></a></div>' : '').'</h4>
					        <div class="media-text">'.stripcslashes($message).'</div>
					    </div>
					</div>
					<hr>';
			}

			$sharedfiles .= '</div>';
		
			die(json_encode(array('status' => 1, 'html' => $sharedfiles)));
		} else {

			// Nothing available
			die(json_encode(array('status' => 0, 'text' => $jkl["i3"])));
		}

	break;
	case 'starred':
		# code...
		$result = $jakdb->select("transcript", ["[>]user" => ["operatorid" => "id"], "[>]sessions" => ["convid" => "id"]], ["transcript.id", "transcript.name", "transcript.message", "transcript.operatorid", "transcript.time", "transcript.class", "transcript.quoted", "transcript.edited", "transcript.editoid", "transcript.convid", "user.picture", "sessions.usr_avatar"], ["AND" => ["transcript.convid" => $_POST['convid'], "transcript.starred" => 1], "ORDER" => ["transcript.id" => "ASC"]]);

		if (isset($result) && !empty($result)) {

			// include the PHP library (if not autoloaded)
			require('../../class/class.emoji.php');

			$starredmsg = '<h3><i class="fa fa-star"></i> '.$jkl['g275'].'</h3><div class="info-side-messages">';

			foreach ($result as $row) {

				// On which class to show a system image
				$systemimg = array("bot", "notice", "url", "ended", "download");
				
				$oimage = str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.$row["usr_avatar"]);
				if ($row["picture"] && $row["operatorid"]) $oimage = str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.JAK_FILES_DIRECTORY.$row["picture"]);
				if (in_array($row["class"], $systemimg)) $oimage = str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.JAK_FILES_DIRECTORY."/system.jpg");

				// We convert the br
				$message = nl2br($row['message'], false);

				// we have file
				if ($row['class'] == "download") {
					$lightbox = "";
		    		if (getimagesize(APP_PATH.$message)) $lightbox = ' class="lightbox"';
		    		$messageemoji = '<a'.$lightbox.' href="'.str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.$message).'" target="_blank">'.basename($message).'</a>';
				} else {
					// We convert the urls
					$messageemoji = replace_urls($message);
				}

				// Convert emotji
				$messageemoji = Emojione\Emojione::toImage($messageemoji);

				// Get the quote msg
				$quotemsg = '';
				if ($row['quoted']) {
					$quotemsg = $jakdb->get("transcript", "message", ["id" => $row["quoted"]]);
					// Convert urls
					$quotemsg = nl2br(replace_urls($quotemsg), false);

					// Convert emotji
					$quotemsg = Emojione\Emojione::toImage($quotemsg);

				}

				$starredmsg .= '<div class="media">
						<img class="d-flex mr-3 img-thumbnail" src="'.$oimage.'" width="53" height="53" alt="'.$row['name'].'">
					    <div class="media-body">
					    	<h4 class="media-heading">'.$row['name'].' <small>'.JAK_base::jakTimesince($row['time'], "", JAK_TIMEFORMAT).($row['editoid'] ? ' | <i class="fa fa-edit"></i> '.JAK_base::jakTimesince($row['edited'], "", JAK_TIMEFORMAT) : '').'</small>'.(!in_array($row["class"], $systemimg) ? ' <div class="chat-edit"><a href="javascript:void(0)" class="chat-edit-link clipboard" data-clipboard-target="#msg'.$row['id'].'"><i class="fa fa-clipboard"></i></a></div>' : '').'</h4>
					        <div class="media-text">'.($row['quoted'] ? '<blockquote class="blockquote"><i class="fa fa-reply"></i> '.$quotemsg.'</blockquote>' : '').stripcslashes($messageemoji).'</div>
					    </div>
					</div>
					<hr>';
			}

			$starredmsg .= '</div>';
		
			die(json_encode(array('status' => 1, 'html' => $starredmsg)));
		} else {

			// Nothing available
			die(json_encode(array('status' => 0, 'text' => $jkl["i3"])));
		}

	break;
	case 'faq':
		# code...
		$faq_url = false;
		$department = $jakdb->get("sessions", "department", ["AND" => ["id" => $_POST['convid'], "operatorid" => $_POST['uid']]]);

		if ($department) {
			foreach ($LC_DEPARTMENTS as $d) {
				if (in_array($department, $d)) {
					if ($d['faq_url']) $faq_url = $d['faq_url'];
				}
			}
		}

		if ($faq_url) {

			$loadiframe = '<iframe seamless="seamless" class="faq-frame" frameborder="0" src="'.$faq_url.'"></iframe>';
			die(json_encode(array('status' => 1, 'html' => $loadiframe)));

		}
		
		// Nothing worked cancel
		die(json_encode(array('status' => 0, 'text' => $jkl["i2"])));
	break;
	case 'history':
		# code...
		$row = $jakdb->get("sessions", ["name", "email"], ["id" => $_POST['convid']]);
	  		
	  	if (isset($row) && !empty($row)) {

	  		$email = '';
	  		if (filter_var($row['email'], FILTER_VALIDATE_EMAIL)) $email = $row['email'];
		  		
		  	$oldsessions = $jakdb->select("sessions", ["id", "name", "initiated"], ["OR #c" => ["AND #first" => ["id[!]" => $_POST['convid'], "name" => $row["name"]], "AND #second" => ["id[!]" => $_POST['convid'], "email" => $email]], "ORDER" => ["initiated" => "DESC"], "LIMIT" => 5]);

          	if (isset($oldsessions) && !empty($oldsessions)) {

          		// include the PHP library (if not autoloaded)
				require('../../class/class.emoji.php');

				$historymsg = '<h3><i class="fa fa-comments-o"></i> '.$jkl['m1'].'</h3><div class="info-side-messages"><div class="accordion" id="chat_history">';

            	foreach ($oldsessions as $rows) {
	
			  		$historymsg .= '<div class="card card-body">
			    			<h4 class="card-title">
			    			<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse'.$rows["id"].'">'.$rows["name"].'</button>
			        		<span class="badge badge-dark pull-right">'.JAK_base::jakTimesince($rows['initiated'], JAK_DATEFORMAT, JAK_TIMEFORMAT).'</span>
			      			</h4>
			    <div id="collapse'.$rows["id"].'" class="collapse" data-parent="#chat_history">
			      <div class="panel-body history-chat">';

			        $chatmsg = $jakdb->select("transcript", ["[>]user" => ["operatorid" => "id"], "[>]sessions" => ["convid" => "id"]], ["transcript.id", "transcript.name", "transcript.message", "transcript.operatorid", "transcript.time", "transcript.class", "transcript.quoted", "transcript.edited", "transcript.editoid", "transcript.convid", "user.picture", "sessions.usr_avatar"], ["transcript.convid" => $rows['id'], "ORDER" => ["transcript.id" => "ASC"]]);

			        if (isset($chatmsg) && !empty($chatmsg)) {

			        	foreach ($chatmsg as $z) {

			        		// On which class to show a system image
							$systemimg = array("bot", "notice", "url", "ended");
							
							$oimage = str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.$z["usr_avatar"]);
							if ($z["picture"] && $z["operatorid"]) $oimage = str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.JAK_FILES_DIRECTORY.$z["picture"]);
							if (in_array($z["class"], $systemimg)) $oimage = str_replace(JAK_OPERATOR_LOC."/ajax/", "", BASE_URL.JAK_FILES_DIRECTORY."/system.jpg");

							// We convert the urls/br
							$message = nl2br(replace_urls($z['message']), false);

							// Convert emotji
							$messageemoji = Emojione\Emojione::toImage($message);

							// Get the quote msg
							$quotemsg = '';
							if ($z['quoted']) {
								$quotemsg = $jakdb->get("transcript", "message", ["id" => $z["quoted"]]);
								// Convert urls
								$quotemsg = nl2br(replace_urls($quotemsg), false);

								// Convert emotji
								$quotemsg = Emojione\Emojione::toImage($quotemsg);

							}

			        		$historymsg .= '<div class="media">
								<img class="d-flex mr-3 img-thumbnail" src="'.$oimage.'" width="53" height="53" alt="'.$z['name'].'"></a>
							    <div class="media-body">
							    	<h4 class="media-heading">'.$z['name'].' <small>'.JAK_base::jakTimesince($z['time'], "", JAK_TIMEFORMAT).($z['editoid'] ? ' | <i class="fa fa-edit"></i> '.JAK_base::jakTimesince($row['edited'], "", JAK_TIMEFORMAT) : '').'</small></h4>
							        <div class="media-text">'.($z['quoted'] ? '<blockquote class="blockquote"><i class="fa fa-reply"></i> '.$quotemsg.'</blockquote>' : '').stripcslashes($messageemoji).'</div>
							    </div>
							</div>
							<hr>';
			            
			        	}
			        }

			        $historymsg .= '</div>
			    </div>
			  </div>';

            	}
            
      			$historymsg .= '</div></div>';

				die(json_encode(array('status' => 1, 'html' => $historymsg)));
			}
		}
		// Nothing available
		die(json_encode(array('status' => 0, 'text' => $jkl["i3"])));
	break;
	default:
		# code...
		// Save client data
		if (isset($_POST['edit_customer']) && is_numeric($_POST['convid'])) {
			$jkp = $_POST;

			$username = $jakdb->get("sessions", "name", ["id" => $jkp['convid']]);

			$jakdb->update("transcript", ["name" => $jkp['name']], ["AND" => ["convid" => $jkp['convid'], "class" => "user"]]);

			$jakdb->update("checkstatus", ["datac" => 1], ["convid" => $jkp['convid']]);

			$result = $jakdb->update("sessions", ["name" => $jkp['name'], "email" => $jkp['email'], "phone" => $jkp['phone'], "notes" => $jkp['note']], ["id" => $jkp['convid']]);

			$namechange = false;

			if (isset($jkp['name']) && $jkp['name'] != $username) $namechange = true;
					    
			if ($result) {
				// Ajax Request
				if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
					header('Cache-Control: no-cache');
					die(json_encode(array('status' => 1, 'namechange' => $namechange, 'label' => "name")));       
				}
			} else {
				// Ajax Request
				if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
					header('Cache-Control: no-cache');
					die(json_encode(array('status' => 2, 'txt' => $jkl['i'])));       
				}
			}
		}
		break;
}
	
?>