<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8.1                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!jak_get_access("widget", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) jak_redirect(BASE_URL);

// Reset some vars
$newwidg = true;

// All the tables we need for this plugin
$errors = array();
$jaktable = 'chatwidget';
$jaktable1 = 'departments';
$jaktable2 = 'user';

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	case 'delete':
		 
		// Check if user exists and can be deleted
		if (is_numeric($page2) && $page2 != 1) {
		        
			// Now check how many languages are installed and do the dirty work
			$result = $jakdb->delete($jaktable, ["id" => $page2]);
		
		if (!$result) {

		    $_SESSION["infomsg"] = $jkl['i'];
		    jak_redirect($_SESSION['LCRedirect']);
		} else {

			// Now let us delete the widget cache file
	        $cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$page2.'.php';
	        if (file_exists($cachewidget)) {
	            unlink($cachewidget);
	        }

		    $_SESSION["successmsg"] = $jkl['g14'];
		    jak_redirect($_SESSION['LCRedirect']);
		}
		    
		} else {

		   	$_SESSION["errormsg"] = $jkl['i3'];
		    jak_redirect($_SESSION['LCRedirect']);
		}
		
	break;
	case 'edit':
	
		// Check if the widget exists
		if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $jkp = $_POST;
		
		    if (empty($jkp['title'])) {
		        $errors['e'] = $jkl['e2'];
		    }
		    
		    if (count($errors) == 0) {

		    	if (!isset($jkp['jak_hide'])) $jkp['jak_hide'] = 0;
		    	if (!isset($jkp['jak_float'])) $jkp['jak_float'] = 0;
				if (!isset($jkp['chatCol'])) $jkp['chatCol'] = "";

				// if phone is compulsory we need to show the field
                if ($jkp['jak_cphone'] == 1) $jkp['jak_scphone'] = 1;

                // if question field is compulsory we need to show the field
                if ($jkp['jak_question'] == 1) $jkp['jak_squestion'] = 1;

                // Chat departments
                if (!isset($jkp['jak_depid'])) {
                    $depa = 0;
                } else {
                    $depa = join(',', $jkp['jak_depid']);
                }

                // Clean the dsgvo link
                include_once '../include/htmlawed.php';
	            $htmlconfig = array('comment'=>0, 'cdata'=>1, 'elements'=>'a, strong'); 
	            $dsgvo_clean = htmLawed($_REQUEST['jak_dsgvo'], $htmlconfig);

		    	$result = $jakdb->update($jaktable, ["title" => $jkp['title'],
		    		"whatsapp_message" => $jkp['whatsapp_msg'],
					"depid" => $depa,
					"opid" => $jkp['jak_opid'],
					"lang" => $jkp['jak_lang'],
					"widget" => $jkp['jak_widget'],
					"hideoff" => $jkp['jak_hide'],
					"floatpopup" => $jkp['jak_float'],
					"chat_direct" => $jkp['jak_chat_direct'],
					"whatsapp_online" => $jkp['jak_chat_waonline'],
					"whatsapp_offline" => $jkp['jak_chat_waoffline'],
					"client_email" => $jkp['jak_cemail'],
					"client_semail" => $jkp['jak_scemail'],
					"client_phone" => $jkp['jak_cphone'],
					"client_sphone" => $jkp['jak_scphone'],
					"client_question" => $jkp['jak_question'],
					"client_squestion" => $jkp['jak_squestion'],
					"show_avatar" => $jkp['jak_avatar'],
					"floatcss" => $jkp['jak_floatcss'],
					"floatcsschat" => $jkp['jak_floatcsschat'],
					"engagecss" => $jkp['jak_engagecss'],
					"btn_animation" => $jkp['jak_btnanimation'],
					"chat_animation" => $jkp['jak_chatanimation'],
					"engage_animation" => $jkp['jak_engageanimation'],
					"feedback" => $jkp['jak_feedback'],
					"redirect_active" => $jkp['redirect_active'],
					"redirect_url" => $jkp['url_red'],
					"redirect_after" => $jkp['jak_redi_contact'],
					"dsgvo" => $dsgvo_clean,
					"sucolor" => $jkp['jak_sucolor'],
					"sutcolor" => $jkp['jak_sutcolor'],
					"buttonimg" => $jkp['jak_buttonimg'],
					"mobilebuttonimg" => $jkp['jak_buttonimgmobile'],
					"slideimg" => $jkp['jak_slideimg'],
					"template" => $jkp['chatSty'],
					"theme_colour" => $jkp['chatCol'],
					"body_colour" => $jkp['pcolor'],
					"h_colour" => $jkp['pfhead'],
					"c_colour" => $jkp['pfont'],
					"time_colour" => $jkp['pfheadc'],
					"link_colour" => $jkp['pafont'],
					"sidebar_colour" => $jkp['pfsidec'],
					"t_font" => $jkp['tFont'],
					"h_font" => $jkp['gFont'],
					"c_font" => $jkp['cFont'],
					"widget_whitelist" => $jkp['jak_whitelist']], ["id" => $page2]);
		
				if (!$result) {
				    $_SESSION["infomsg"] = $jkl['i'];
		    		jak_redirect($_SESSION['LCRedirect']);
				} else {

					// Now let us delete the all the cache file
					$cacheallfiles = APP_PATH.JAK_CACHE_DIRECTORY.'/';
					$msfi = glob($cacheallfiles."*.php");
					if ($msfi) foreach ($msfi as $filen) {
					    if (file_exists($filen)) unlink($filen);
					}

				    $_SESSION["successmsg"] = $jkl['g14'];
		    		jak_redirect($_SESSION['LCRedirect']);
				}
		
			// Output the errors
			} else {
				$errors = $errors;
			}
		
			}
		
			// Title and Description
			$SECTION_TITLE = $jkl["g290"];
			$SECTION_DESC = "";
				
			// Get all departments
			$JAK_DEPARTMENTS = $jakdb->select($jaktable1, ["id", "title"], ["ORDER" => ["dorder" => "ASC"]]);

			// Get all operators
			$JAK_OPERATORS = $jakdb->select($jaktable2, ["id", "username"], ["ORDER" => ["username" => "ASC"]]);

			// Call the settings function
			$lang_files = jak_get_lang_files();

			// Call the packages
			$chat_packages = jak_get_chat_packages();

			// Get all buttons
    		$BUTTONS_ALL = jak_get_files(APP_PATH.JAK_FILES_DIRECTORY.'/buttons');

    		// Get all slideup
    		$SLIDEIMG_ALL = jak_get_files(APP_PATH.JAK_FILES_DIRECTORY.'/slideimg');
			
			$JAK_FORM_DATA = jak_get_data($page2, $jaktable);

			if (isset($JAK_FORM_DATA['template']) && !empty($JAK_FORM_DATA['template'])) {
				$styleconfig = APP_PATH.'package/'.$JAK_FORM_DATA['template'].'/config.php';
				if (file_exists($styleconfig)) include_once $styleconfig;
			}

			// Include the javascript file for results
			$js_file_footer = 'js_editwidget.php';
			$template = 'editwidget.php';
		
		} else {
		    
		   	$_SESSION["errormsg"] = $jkl['i3'];
		    jak_redirect($_SESSION['LCRedirect']);
		}
		
	break;
	default:
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_widget'])) {
		    $jkp = $_POST;

		    // Hosting is active we need to count the total operators
			if ($jakhs['hostactive']) {
				$totalwidg = $jakdb->count($jaktable);

				if ($totalwidg >= $jakhs['chatwidgets']) {
					$_SESSION["errormsg"] = $jkl['i6'];
		    		jak_redirect($_SESSION['LCRedirect']);
				}
			}
		    
		    if (empty($jkp['title'])) {
		        $errors['e'] = $jkl['e2'];
		    }
		        
		   	if (count($errors) == 0) {

		        $jakdb->insert($jaktable, ["title" => $jkp['title'],
					"depid" => $jkp['jak_depid'],
					"opid" => $jkp['jak_opid'],
					"lang" => $jkp['jak_lang'],
					"created" => $jakdb->raw("NOW()")]);

		        $lastid = $jakdb->id();

		    	if (!$lastid) {
		    		$_SESSION["infomsg"] = $jkl['i'];
		    		jak_redirect($_SESSION['LCRedirect']);
		    	} else {
		    		$_SESSION["successmsg"] = $jkl['g14'];
		    		jak_redirect($_SESSION['LCRedirect']);
		    	}
		    
		    // Output the errors
		    } else {
		    
		        $errors = $errors;
		    }  
   
		 }
		 
		// Get all departments
		$JAK_DEPARTMENTS = $jakdb->select($jaktable1, ["id", "title"], ["ORDER" => ["dorder" => "ASC"]]);

		// Get all operators
		$JAK_OPERATORS = $jakdb->select($jaktable2, ["id", "username"], ["ORDER" => ["username" => "ASC"]]);

		// Call the settings function
		$lang_files = jak_get_lang_files();
		
		// Get all responses
		$CHATWIDGET_ALL = jak_get_page_info($jaktable);
		
		// Hosting is active we need to count the total widgets
		if ($jakhs['hostactive']) {
			$totalwidg = $jakdb->count($jaktable);
			if ($totalwidg >= $jakhs['chatwidgets']) $newwidg = false;
		}
		
		// Title and Description
		$SECTION_TITLE = $jkl["m26"];
		$SECTION_DESC = "";
		
		// Include the javascript file for results
		$js_file_footer = 'js_widget.php';
		 
		// Call the template
		$template = 'widget.php';
}
?>