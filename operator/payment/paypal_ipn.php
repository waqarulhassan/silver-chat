<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.7.1                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('[ipn.php] config.php not exist');
require_once '../../config.php';

// Include phpmailer
include_once '../../class/PHPMailerAutoload.php';

// Include the paypal library
include_once ('paypal.php');

// Reset vars
$sendmail = 0;

// Create an instance of the paypal library
$myPaypal = new Paypal();

// Log the IPN results
$myPaypal->ipnLog = TRUE;

// Enable test mode if needed
//$myPaypal->enableTestMode();

// Change for 3.0.3
use JAKWEB\JAKsql;

// Check validity and write down it
if ($myPaypal->validateIpn()) {
    if ($myPaypal->ipnData['payment_status'] == 'Completed') {
    
    	$item_name = $myPaypal->ipnData['item_name'];
    	$payment_currency = $myPaypal->ipnData['mc_currency'];
    	$payment_status = $myPaypal->ipnData['payment_status'];
    	$txn_id = $myPaypal->ipnData['txn_id'];
    	$receiver_email = $myPaypal->ipnData['receiver_email'];
    	$payment_amount = $myPaypal->ipnData['mc_gross'];
    	$payer_email = $myPaypal->ipnData['payer_email'];

        // Userid
    	$userid = base64_decode($myPaypal->ipnData['custom']);

        // check that payment_amount/payment_currency are correct
        global $jakdb;

        // Now if we have multi site we have fully automated process
        if (!empty(JAKDB_MAIN_NAME) && JAK_MAIN_LOC) {
            // Database connection to the main site
            $jakdb1 = new JAKsql([
                // required
                'database_type' => JAKDB_MAIN_DBTYPE,
                'database_name' => JAKDB_MAIN_NAME,
                'server' => JAKDB_MAIN_HOST,
                'username' => JAKDB_MAIN_USER,
                'password' => JAKDB_MAIN_PASS,
                'charset' => 'utf8',
                'port' => JAKDB_MAIN_PORT,
                'prefix' => JAKDB_MAIN_PREFIX,
                         
                // [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
                'option' => [PDO::ATTR_CASE => PDO::CASE_NATURAL]
            ]);

            // We get the settings for the payment
            $sett = array();
            $settings = $jakdb1->select("settings", ["varname", "used_value"]);
            foreach ($settings as $v) {
                $sett[$v["varname"]] = $v["used_value"]; 
            }

            if (isset($payment_amount) && ($payment_amount == $jakhs['pricemonth'] || $payment_amount == (3*$jakhs['pricemonth']) || $payment_amount == (6*$jakhs['pricemonth']) || $payment_amount == (12*$jakhs['pricemonth']))) {

                // Get the trial in the correct format $jakwidget['validtill']
                if ($payment_amount == (12*$jakhs['pricemonth'])) {
                    if (JAK_VALIDTILL > time()) {
                        $paidunix = strtotime("+12 month", JAK_VALIDTILL);
                    } else {
                        $paidunix = strtotime("+12 month");
                    }
                } elseif ($payment_amount == (6*$jakhs['pricemonth'])) {
                    if (JAK_VALIDTILL > time()) {
                        $paidunix = strtotime("+6 month", JAK_VALIDTILL);
                    } else {
                        $paidunix = strtotime("+6 month");
                    }
                } elseif ($payment_amount == (3*$jakhs['pricemonth'])) {
                    if (JAK_VALIDTILL > time()) {
                        $paidunix = strtotime("+3 month", JAK_VALIDTILL);
                    } else {
                        $paidunix = strtotime("+3 month");
                    }
                } else {
                    if (JAK_VALIDTILL > time()) {
                        $paidunix = strtotime("+1 month", JAK_VALIDTILL);
                    } else {
                        $paidunix = strtotime("+1 month");
                    }
                }

                // get the nice time
                $paidtill = date('Y-m-d H:i:s', $paidunix);

                // Insert into payment
                $jakdb1->insert("payment_ipn", [ 
                    "userid" => $userid,
                    "status" => $payment_status,
                    "amount" => $payment_amount,
                    "currency" => $payment_currency,
                     "txn_id" => $txn_id,
                    "receiver_email" => $receiver_email,
                    "payer_email" => $payer_email,
                    "paid_with" => "Paypal for Advanced",
                    "time" => $jakdb->raw("NOW()")]);

                // We get the user data from the main table
                $opmain = $jakdb1->get("users", ["id"], ["AND" => ["opid" => $userid, "locationid" => JAK_MAIN_LOC]]);
        	
            	// Now make the stuff paid because we received the money.
                // finally update the main database
                $jakdb1->update("users", [ 
                    "trial" => "1980-05-06 00:00:00",
                    "paidtill" => $paidtill,
                    "active" => 1,
                    "confirm" => 0], ["AND" => ["opid" => $userid, "locationid" => JAK_MAIN_LOC]]);

                // Payment details insert
                $jakdb1->insert("subscriptions", [ 
                    "locationid" => JAK_MAIN_LOC,
                    "userid" => $userid,
                    "amount" => $payment_amount,
                    "currency" => $sett["currency"],
                    "paidfor" => "LC3 Membership",
                    "paidhow" => "Paypal",
                    "paidwhen" => $jakdb->raw("NOW()"),
                    "paidtill" => $paidtill,
                    "success" => 1]);

                // Update the advanced access table
                $jakdb1->update("advaccess", [ 
                    "lastedit" => $jakdb->raw("NOW()"),
                    "paidtill" => $paidtill,
                    "paythanks" => 1], ["AND" => ["opid" => $userid, "id" => $opmain["id"]]]);

                // Update the time for the user on the custom installation
                $jakdb->update("settings", ["used_value" => $paidunix], ["varname" => "validtill"]);

                // Now let us delete the define cache file
                $cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/opcache'.$userid.'.php';
                if (file_exists($cachewidget)) {
                    unlink($cachewidget);
                }

                // log for manual investigation amount is not the same
                $mail = new PHPMailer(); // defaults to using php "mail()"
                $mail->SetFrom(JAK_EMAIL);
                $mail->AddAddress(JAK_EMAIL);
                $mail->AddReplyTo($payer_email);
                $mail->Subject = JAK_TITLE.' - PAYPAL Success';
                $mail->Body = 'There is a new payment for advanced access thru Paypal, userid: '.$userid.' - '.$item_name.' - '.$payment_status.' - '.$payment_amount.' - '.$payment_currency.' - '.$txn_id.' - '.$receiver_email.' - '.$payer_email;
                $mail->Send(); // Send email without any warnings
    	   		
        	} else {
        	   	
        	   	// log for manual investigation amount is not the same
        	   	$mail = new PHPMailer(); // defaults to using php "mail()"
        	   	$mail->SetFrom(JAK_EMAIL);
                $mail->AddAddress(JAK_EMAIL);
                $mail->AddReplyTo($payer_email);
        	   	$mail->Subject = JAK_TITLE.' - PAYPAL Success, but...';
        	   	$mail->Body = 'There is a new payment thru Paypal for advanced access, userid: '.$userid.' - '.$item_name.' - '.$payment_status.' - '.$payment_amount.' - '.$payment_currency.' - '.$txn_id.' - '.$receiver_email.' - '.$payer_email.' But the amount was paid is not the same amount was ordered, please check in the paypal order details.';
        	   	$mail->Send(); // Send email without any warnings
        	   	
        	}

        }
    	       	
    } else {
         
        // log for manual investigation
        $mail = new PHPMailer(); // defaults to using php "mail()"
        $mail->SetFrom(JAK_EMAIL);
        $mail->AddAddress(JAK_EMAIL);
        $mail->AddReplyTo($payer_email);
        $mail->Subject = JAK_TITLE.' - PAYPAL HTTP error';
        $mail->Body = 'There is an error with PAYPAL, please check with Paypal.';
    }
}
?>