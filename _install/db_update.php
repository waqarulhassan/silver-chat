<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1980 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.8.6                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2020 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../config.php')) die('install/[db_update.php] config.php not exist');
require_once '../config.php';

if (is_numeric($_POST['step']) && $_POST['step'] == 4) {

$result = $jakdb->get("departments", "title", ["id" => 1]);
  	
if ($result) {

// Check the current version
$version = $jakdb->get("settings", "used_value", ["varname" => "version"]);

// Ok, we are already up to date
if ($version == "3.8.6") die(json_encode(array("status" => 2)));

// Proceed with the update
if ($version == "1.0") {

  // Update transcript to store operatorid
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."transcript ADD `operatorid` INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER `user`");
  
  // Choose if transcript can be send
  // Choose chat color
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
  ('chat_colour', 'setting', 'primary', 'primary', 'input', 'free', 'jakweb'),
  ('send_tscript', 'setting', '1', '1', 'yesno', 'boolean', 'jakweb');");
  
  $jakdb->query('ALTER TABLE '.JAKDB_PREFIX.'sessions ADD `usr_avatar` VARCHAR(255) NULL AFTER `operatorname`');

}

if ($version <= "1.1" ) {

  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
  ('show_avatar', 'setting', '1', '1', 'yesno', 'boolean', 'jakweb');");

}

if ($version <= "1.2") {

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user ADD `operatorchatpublic` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER `operatorchat`");

  $jakdb->query('DROP TABLE '.JAKDB_PREFIX.'operatortyping');

}

if ($version <= "1.3") {

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."responses ADD `department` INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`");
  
}

if ($version <= "1.4") {

$jakdb->query("INSERT INTO ".JAKDB_PREFIX."setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
('show_ips', 'setting', '1', '1', 'yesno', 'boolean', 'jakweb');");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user ADD `useronlinelist` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER `files`, ADD `chat_latency` smallint(4) UNSIGNED NOT NULL DEFAULT '3000' AFTER `files`");

}

if ($version <= "1.5") {

  // Live Chat Business 2.0
  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."answers (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `department` int(10) unsigned NOT NULL DEFAULT '0',
    `lang` varchar(3) DEFAULT NULL,
    `title` varchar(255) DEFAULT NULL,
    `message` text,
    `fireup` smallint(5) unsigned NOT NULL DEFAULT '60',
    `msgtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=standard,2=welcome,3=closed,4=expired,5=firstmsg',
    `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `depid` (`department`,`lang`,`fireup`,`msgtype`)
  ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
  
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."answers (`id`, `department`, `lang`, `title`, `message`, `fireup`, `msgtype`, `created`) VALUES
  (1, 0, 'en', 'Enters Chat', '%operator% enters the chat.', 15, 2, NOW()),
  (2, 0, 'en', 'Expired', 'This session has expired!', 15, 4, NOW()),
  (3, 0, 'en', 'Ended', '%client% has ended the conversation', 15, 3, NOW()),
  (4, 0, 'en', 'Welcome', 'Welcome %client%, a representative will be with you shortly.', 15, 5, NOW()),
  (5, 0, 'en', 'Leave', 'has left the conversation.', 15, 6, NOW()),
  (6, 0, 'en', 'Start Page', 'Please insert your name to begin, a representative will be with you shortly.', 15, 7, NOW()),
  (7, 0, 'en', 'Contact Page', 'None of our representatives are available right now, although you are welcome to leave a message!', 15, 8, NOW()),
  (8, 0, 'en', 'Feedback Page', 'We would appreciate your feedback to improve our service.', 15, 9, NOW()),
  (9, 0, 'en', 'Quickstart Page', 'Please type a message and hit enter to start the conversation.', 15, 10, NOW())");
  
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
  ('contact_redirect', 'setting', '8', '8', 'input', 'boolean', 'jakweb'), ('client_left', 'setting', '30', '30', 'input', 'boolean', 'jakweb'),
  ('client_expired', 'setting', '600', '600', 'input', 'boolean', 'jakweb'), ('ring_tone', 'setting', 'ring', 'ring', 'input', 'free', 'jakweb'),
  ('msg_tone', 'setting', 'new_message', 'new_message', 'input', 'free', 'jakweb'), ('puscolor_tpl', 'setting', '#f9f9f9', '#f9f9f9', 'input', 'free', 'jakweb')");

}

if ($version <= "2.0") {

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."contacts (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `depid` int(10) unsigned NOT NULL DEFAULT '0',
    `name` varchar(255) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `message` text,
    `ip` char(15) DEFAULT NULL,
    `country` varchar(64) DEFAULT NULL,
    `city` varchar(64) DEFAULT NULL,
    `countrycode` varchar(2) DEFAULT NULL,
    `latitude` varchar(255) DEFAULT NULL,
    `longitude` varchar(255) DEFAULT NULL,
    `referrer` varchar(255) DEFAULT NULL,
    `reply` smallint(1) unsigned NOT NULL DEFAULT '0',
    `answered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `depid` (`depid`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
  
  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."contactsreply (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `contactid` int(11) unsigned NOT NULL DEFAULT '0',
    `operatorid` int(11) unsigned NOT NULL DEFAULT '0',
    `operatorname` varchar(255) DEFAULT NULL,
    `subject` varchar(255) DEFAULT NULL,
    `message` text,
    `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `contactid` (`contactid`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
  
}

if ($version <= "2.2") {

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user DROP `tw_days`, DROP `tw_time_from`, DROP `tw_time_to`");
  
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user ADD `hours_array` TEXT NULL AFTER `busy`");
  
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ('chat_style', 'setting', 'bubbles', 'bubbles', 'input', 'free', 'jakweb'),('url_redirect', 'setting', '', '', 'input', 'free', 'jakweb')");

}

if ($version <= "2.3") {

  // Better message handling
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."sessions ADD `canswered` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `answered`");

  // New Visitor Engage Style
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."autoproactive DROP `wayin`, DROP `wayout`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."autoproactive ADD `title` VARCHAR(255) NULL AFTER `path`, ADD `imgpath` VARCHAR(255) NULL AFTER `title`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."autoproactive CHANGE `message` `message` VARCHAR(255) NULL DEFAULT NULL");

  // User transfer chats
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user ADD `transferc` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER `operatorlist`");

  // Remove some settings
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'pro_wayout'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'pro_wayin'");

}

if ($version <= "2.5") {

$jakdb->query("INSERT INTO ".JAKDB_PREFIX."setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
  ('mapapikey', 'setting', '', '@google', 'input', 'free', 'jakweb'), ('openop', 'setting', 1, 1, 'yesno', 'boolean', 'jakweb');");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."answers CHANGE `created` `created` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."autoproactive CHANGE `time` `time` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."buttonstats CHANGE `ip` `ip` CHAR(45) NOT NULL DEFAULT '0', CHANGE `lasttime` `lasttime` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00', CHANGE `time` `time` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."clientcontact CHANGE `sent` `sent` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."contacts CHANGE `ip` `ip` CHAR(45) DEFAULT NULL, CHANGE `answered` `answered` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00', CHANGE `sent` `sent` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."contactsreply CHANGE `sent` `sent` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."departments CHANGE `time` `time` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."files CHANGE `path` `path` TEXT NULL, CHANGE `description` `description` TEXT NULL");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."loginlog CHANGE `ip` `ip` CHAR(45) NOT NULL DEFAULT '0', CHANGE `time` `time` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."responses CHANGE `message` `message` TEXT NULL");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."sessions CHANGE `ip` `ip` CHAR(45) NULL DEFAULT NULL");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."transcript CHANGE `time` `time` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user CHANGE `time` `time` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

$jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user_stats CHANGE `time` `time` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00'");

}

if ($version < "2.6") {

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."bot_question (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `depid` int(10) unsigned NOT NULL DEFAULT '0',
    `lang` varchar(3) DEFAULT NULL,
    `question` text,
    `answer` text,
    `updated` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`),
    KEY `depid` (`depid`, `lang`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

}

if ($version < "2.7") {

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user ADD `pusho_tok` VARCHAR(50) NULL AFTER `phonenumber`, ADD `pusho_key` VARCHAR(50) NULL AFTER `pusho_tok`, ADD `push_notifications` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `chat_latency`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."departments ADD `faq_url` TEXT NULL AFTER `email`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."autoproactive ADD `btn_confirm` VARCHAR(50) NULL AFTER `message`, ADD `btn_cancel` VARCHAR(50) NULL AFTER `btn_confirm`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user DROP `dnotify`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."sessions DROP `sendfiles`, DROP `knockknock`, DROP `updated`, DROP `answered`, DROP `canswered`, DROP `u_status`, DROP `u_typing`, DROP `o_typing`, DROP `denied`, DROP `transferid`, DROP `transfermsg`, DROP `ip`, DROP `referrer`, DROP `creferrer`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."buttonstats DROP `sessionid`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."transcript ADD `quoted` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `convid`, ADD `replied` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `quoted`, ADD `starred` TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER `replied`, ADD `editoid` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `starred`, ADD `edited` DATETIME NOT NULL DEFAULT '1980-05-06 00:00:00' AFTER `starred`");

  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
    ('validtill', 'setting', 0, 0, 'date', 'free', 'jakweb');");

  // Delete old stuff from settings
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'smilies'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'chat_style'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'chat_colour'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'font_tpl'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'fontg_tpl'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'fcolor_tpl'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'fhccolor_tpl'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'fhcolor_tpl'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'puscolor_tpl'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'facolor_tpl'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'bgcolor_tpl'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'iccolor_tpl'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'mapapikey'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."setting WHERE `varname` = 'sitehttps'");

  $jakdb->query("RENAME TABLE ".JAKDB_PREFIX."setting TO ".JAKDB_PREFIX."setting_old");

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."settings (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `varname` varchar(100) DEFAULT NULL,
    `used_value` text,
    `default_value` text,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

  // Import old settings from table
  $oldsettings = $jakdb->select("setting_old", ["varname", "value", "defaultvalue"]);

  if (isset($oldsettings) && is_array($oldsettings)) foreach ($oldsettings as $v) {
    # code...
    $jakdb->insert("settings", ["varname" => $v["varname"], "used_value" => $v["value"], "default_value" => $v["defaultvalue"]]);
  }

  // Now delete the old table
  $jakdb->query("DROP TABLE ".JAKDB_PREFIX."setting_old");

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."checkstatus (
    `convid` int(10) unsigned NOT NULL,
    `depid` int(10) unsigned NOT NULL DEFAULT '0',
    `department` varchar(100) DEFAULT NULL,
    `operatorid` int(10) unsigned NOT NULL DEFAULT '0',
    `operator` varchar(100) DEFAULT NULL,
    `pusho` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `newc` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `newo` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `files` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `knockknock` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `msgdel` int(10) unsigned NOT NULL DEFAULT '0',
    `msgedit` int(10) unsigned NOT NULL DEFAULT '0',
    `typec` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `typeo` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `transferoid` int(10) unsigned NOT NULL DEFAULT '0',
    `transferid` int(10) unsigned NOT NULL DEFAULT '0',
    `denied` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `hide` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `datac` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `statusc` int(10) unsigned NOT NULL DEFAULT '0',
    `statuso` int(10) unsigned NOT NULL DEFAULT '0',
    `initiated` int(10) unsigned NOT NULL DEFAULT '0',
    UNIQUE KEY `convid` (`convid`),
    KEY `denied` (`denied`,`hide`,`statusc`,`statuso`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."transfer (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `convid` int(10) unsigned NOT NULL DEFAULT '0',
    `fromoid` int(10) unsigned NOT NULL DEFAULT '0',
    `fromname` varchar(100) DEFAULT NULL,
    `tooid` int(10) unsigned NOT NULL DEFAULT '0',
    `toname` varchar(100) DEFAULT NULL,
    `message` text,
    `used` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    PRIMARY KEY (`id`),
    KEY `convid` (`convid`,`tooid`,`used`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."chatwidget (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(100) DEFAULT NULL,
    `depid` int(10) unsigned NOT NULL DEFAULT '0',
    `opid` int(10) unsigned NOT NULL DEFAULT '0',
    `lang` char(2) DEFAULT NULL,
    `widget` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:SlideUp,2:Button/SlideUP,3PopUp',
    `slideup` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:right,2:left',
    `hideoff` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `buttonimg` varchar(100) NOT NULL,
    `slideimg` varchar(100) NOT NULL,
    `floatpopup` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `chatstyle` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:Classic,2:Bubbles',
    `bubble_colour` varchar(10) DEFAULT 'primary',
    `body_colour` char(7) DEFAULT '#ffffff',
    `h_colour` char(7) DEFAULT '#494949',
    `c_colour` char(7) DEFAULT '#494949',
    `time_colour` char(7) DEFAULT '#999999',
    `link_colour` char(7) DEFAULT '#2f942b',
    `sidebar_colour` char(7) DEFAULT '#857d7d',
    `h_font` varchar(100) NOT NULL DEFAULT 'NonGoogle',
    `c_font` varchar(100) NOT NULL DEFAULT 'Arial, Helvetica, sans-serif',
    `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."chatwidget (`id`, `title`, `depid`, `opid`, `lang`, `widget`, `slideup`, `hideoff`, `buttonimg`, `slideimg`, `floatpopup`, `chatstyle`, `bubble_colour`, `body_colour`, `h_colour`, `c_colour`, `time_colour`, `link_colour`, `sidebar_colour`, `h_font`, `c_font`, `created`) VALUES
  (1, 'Live Chat', 0, 0, 'en', 1, 1, 0, 'globe_on.png', 'chatnow_on.png', 0, 1, 'primary', '#ffffff', '#494949', '#494949', '#999999', '#007ff5', '#857d7d', 'NonGoogle', 'Tahoma, Geneva, Kalimati, sans-serif', 'NOW()')");

}

if ($version < "3.0") {

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `slideupsize` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `floatpopup`, ADD `sucolor` CHAR(7) NOT NULL DEFAULT '#6f6f6f' AFTER `slideupsize`, ADD `sutcolor` CHAR(7) NOT NULL DEFAULT '#ffffff' AFTER `sucolor`");

}

if ($version < "3.0.2") {

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."urlblacklist (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `path` varchar(200) NULL DEFAULT NULL,
    `title` varchar(255) NULL DEFAULT NULL,
    `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    PRIMARY KEY (`id`),
    KEY `path` (`path`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

}

// Changes for 3.0.3
if ($version < "3.0.3") {
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."settings (`varname`, `used_value`, `default_value`) VALUES ('holiday_mode', '0', '0')");

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."groupchat (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `password` varchar(20) NULL DEFAULT NULL,
    `title` varchar(100) DEFAULT NULL,
    `opids` varchar(10) DEFAULT '0',
    `maxclients` tinyint(3) unsigned NOT NULL DEFAULT '20',
    `lang` char(2) DEFAULT NULL,
    `buttonimg` varchar(100) NOT NULL,
    `floatpopup` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `active` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    PRIMARY KEY (`id`),
    KEY `opids` (`opids`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."groupchat (`id`, `title`, `opids`, `maxclients`, `lang`, `buttonimg`, `floatpopup`, `active`, `created`) VALUES
  (1, 'Weekly Support', '0', 10, 'en', 'blue_on.png', 0, 0, NOW())");

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."groupchatmsg (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `groupchatid` int(10) NOT NULL DEFAULT '0',
    `chathistory` mediumtext,
    `operatorid` int(10) unsigned NOT NULL DEFAULT '0',
    `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    PRIMARY KEY (`id`),
    KEY `groupchatid` (`groupchatid`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."groupchatuser (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `groupchatid` int(10) NOT NULL DEFAULT '0',
    `name` varchar(100) NULL DEFAULT NULL,
    `usr_avatar` varchar(255) NULL DEFAULT NULL,
    `statusc` int(10) unsigned NOT NULL DEFAULT '0',
    `lastmsg` int(10) unsigned NOT NULL DEFAULT '0',
    `banned` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `ip` char(45) NOT NULL DEFAULT '0',
    `isop` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `session` varchar(64) DEFAULT NULL,
    `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    PRIMARY KEY (`id`),
    KEY `groupchatid` (`groupchatid`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."answers (`department`, `lang`, `title`, `message`, `fireup`, `msgtype`, `created`) VALUES
  (0, 'en', 'Group Chat Welcome Message', 'Welcome to our weekly support session, sharing experience and feedback.', 0, 11, NOW()),
  (0, 'en', 'Group Chat Offline Message', 'The public chat is offline at this moment, please try again later.', 15, 12, NOW()),
  (0, 'en', 'Group Chat Full Message', 'The publich chat is full, please try again later.', 15, 13, NOW())");

}

// Changes for 3.0.4
if ($version < "3.0.4") {
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."settings (`varname`, `used_value`, `default_value`) VALUES ('push_reminder', '120', '120')");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `t_font` VARCHAR(100) NULL AFTER `sidebar_colour`");
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."settings (`id`, `varname`, `used_value`, `default_value`) VALUES (NULL, 'native_app_token', NULL, 'jakweb_app'), (NULL, 'native_app_key', NULL, 'jakweb_app')");

  $jakdb->query("CREATE TABLE ".JAKDB_PREFIX."push_notification_devices (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `userid` int(10) unsigned NOT NULL DEFAULT '0',
    `ostype` enum('ios','android') NOT NULL DEFAULT 'ios',
    `token` varchar(255) DEFAULT NULL,
    `lastedit` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
    PRIMARY KEY (`id`),
    KEY `userid` (`userid`,`ostype`,`token`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
}

// Changes for 3.0.5
if ($version < "3.0.5") {
  if (!$jakdb->has("settings", ["varname" => "native_app_token"])) {
    $jakdb->query("INSERT INTO ".JAKDB_PREFIX."settings (`id`, `varname`, `used_value`, `default_value`) VALUES (NULL, 'native_app_token', NULL, 'jakweb_app'), (NULL, 'native_app_key', NULL, 'jakweb_app')");
  }
}

// Changes for 3.1
if ($version < "3.1") {
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."settings (`id`, `varname`, `used_value`, `default_value`) VALUES (NULL, 'client_push_not', '1', '1'), (NULL, 'engage_sound', 'new_message3', 'new_message3'), (NULL, 'client_sound', 'hello', 'hello'), (NULL, 'live_online_status', '0', '0')");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."autoproactive ADD `soundalert` VARCHAR(100) NULL AFTER `showalert`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `template` VARCHAR(20) NULL AFTER `sutcolor`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget DROP `chatstyle`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."buttonstats ADD `country` VARCHAR(64) NULL AFTER `ip`, ADD `countrycode` CHAR(2) NOT NULL DEFAULT 'xx' AFTER `country`");

  $jakdb->query("UPDATE ".JAKDB_PREFIX."chatwidget SET `template` = 'standard'");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget CHANGE `bubble_colour` `theme_colour` VARCHAR(10) NULL DEFAULT 'primary'");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."sessions ADD `template` VARCHAR(20) NULL AFTER `operatorname`");

  $jakdb->query("UPDATE ".JAKDB_PREFIX."sessions SET usr_avatar = '/standard.jpg' WHERE usr_avatar = '/standard.png'");

  $jakdb->query("UPDATE ".JAKDB_PREFIX."user SET picture = '/standard.jpg' WHERE picture = '/standard.png'");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user CHANGE `picture` `picture` VARCHAR(100) NOT NULL DEFAULT '/standard.jpg'");

  $jakdb->query("UPDATE ".JAKDB_PREFIX."sessions SET template = 'standard'");
}

// Changes for 3.2
if ($version < "3.2") {
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."groupchat ADD `description` TEXT NULL AFTER `title`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."groupchat ADD `floatcss` VARCHAR(100) NULL AFTER `floatpopup`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `floatcss` VARCHAR(100) NULL AFTER `floatpopup`");
}

// Changes for 3.3
if ($version < "3.3") {
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget DROP `slideup`, DROP `slideupsize`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget CHANGE `widget` `widget` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1'");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `floatcsschat` VARCHAR(100) NULL AFTER `floatcss`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `widget_whitelist` TEXT NULL AFTER `c_font`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `chat_direct` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `floatpopup`, ADD `client_email` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `chat_direct`, ADD `client_semail` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `client_email`, ADD `client_phone` TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER `client_semail`, ADD `client_sphone` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `client_phone`, ADD `client_question` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `client_sphone`, ADD `client_squestion` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `client_question`, ADD `show_avatar` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `client_squestion`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD INDEX( `depid`, `opid`, `lang`)");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."buttonstats ADD `latitude` VARCHAR(255) NULL AFTER `countrycode`, ADD `longitude` VARCHAR(255) NULL AFTER `latitude`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `mobilebuttonimg` VARCHAR(100) NULL AFTER `buttonimg`");

  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings WHERE `varname` = 'chat_direct'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings WHERE `varname` = 'client_email'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings WHERE `varname` = 'client_semail'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings WHERE `varname` = 'client_phone'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings WHERE `varname` = 'client_sphone'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings WHERE `varname` = 'client_question'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings WHERE `varname` = 'client_squestion'");
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings WHERE `varname` = 'show_avatar'");
}

// Version 3.4
if ($version < "3.4") {
  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings WHERE `varname` = 'langdirection'");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `btn_animation` VARCHAR(20) NULL AFTER `floatcsschat`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `chat_animation` VARCHAR(20) NULL AFTER `btn_animation`");
}


// Version 3.5
if ($version < "3.5") {
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."bot_question ADD `widgetids` varchar(100) NOT NULL DEFAULT '0' AFTER `id`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."bot_question ADD INDEX `depid_lang_widgetids` (`depid`, `lang`, `widgetids`), DROP INDEX `depid`");
}

// Version 3.6
if ($version < "3.6") {
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."settings (`varname`, `used_value`, `default_value`)
  VALUES ('dsgvo', 'I accept the <a href=\"https://www.jakweb.ch/privacy\" target=\"_blank\">privacy agreement</a>.', 'I accept the privacy agreement.')");
}

// Version 3.6.2
if ($version < "3.6.2") {
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."transcript ADD `sentstatus` tinyint(3) unsigned NOT NULL DEFAULT '0' AFTER `time`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user ADD `alwaysnot` tinyint(1) NOT NULL DEFAULT '0' AFTER `ringing`");
}

// Update for 3.7
if ($version < "3.7") {
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget
  ADD `dsgvo` text COLLATE 'utf8_general_ci' NULL AFTER `chat_animation`,
  ADD `redirect_url` varchar(200) COLLATE 'utf8_general_ci' NULL AFTER `dsgvo`,
  ADD `redirect_active` tinyint(3) unsigned NULL DEFAULT '0' AFTER `redirect_url`,
  ADD `redirect_after` tinyint(3) unsigned NULL DEFAULT '8' AFTER `redirect_active`,
  ADD `feedback` tinyint(3) unsigned NULL DEFAULT '1' AFTER `redirect_after`");

  $jakdb->query("DELETE FROM ".JAKDB_PREFIX."settings
  WHERE ((`varname` = 'contact_redirect') OR (`varname` = 'wait_message3') OR (`varname` = 'dsgvo') OR (`varname` = 'url_redirect') OR (`varname` = 'feedback'))");

  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."settings (`varname`, `used_value`, `default_value`)
  VALUES ('proactive_time', '3', '3')");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget
  CHANGE `depid` `depid` varchar(50) COLLATE 'utf8_general_ci' NOT NULL DEFAULT '0' AFTER `title`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."user
  ADD `whatsappnumber` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `phonenumber`");

  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget
  ADD `whatsapp_message` text COLLATE 'utf8_general_ci' NULL AFTER `title`,
  ADD `whatsapp_online` tinyint(3) unsigned NOT NULL DEFAULT '0' AFTER `chat_direct`,
  ADD `whatsapp_offline` tinyint(3) unsigned NOT NULL DEFAULT '0' AFTER `whatsapp_online`");

  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."answers (`id`, `department`, `lang`, `title`, `message`, `fireup`, `msgtype`, `created`) VALUES
  (NULL, 0, 'en', 'WhatsApp Online', 'Please click on a operator below to connect via WhatsApp and get help immediately.', 15, 26, NOW()),
  (NULL, 0, 'en', 'WhatsApp Offline', 'We are currently offline however please check below for available operators in WhatsApp, we try to help you as soon as possible.', 15, 27, NOW())");
}

if ($version < "3.8.1") {
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `engagecss` VARCHAR(100) NULL AFTER `floatcsschat`");
  $jakdb->query("ALTER TABLE ".JAKDB_PREFIX."chatwidget ADD `engage_animation` VARCHAR(20) NULL AFTER `chat_animation`");
}

if ($version < "3.8.3") {
  $jakdb->query("INSERT INTO ".JAKDB_PREFIX."settings (`varname`, `used_value`, `default_value`)
    VALUES ('chat_upload_standard', '0', '0')");
}

// confirm
$email_body = 'URL: '.BASE_URL.'<br />Email: '.JAK_EMAIL.'<br />License: '.JAK_O_NUMBER;

// Send the email to the customer
$mail = new PHPMailer(); // defaults to using php "mail()"
$body = str_ireplace("[\]", "", $email_body);
$mail->SetFrom(JAK_EMAIL);
$mail->AddReplyTo(JAK_EMAIL);
$mail->AddAddress('lic@jakweb.ch');
$mail->Subject = 'Update - LiveChat 3 / 3.8.6';
$mail->AltBody = 'HTML Format';
$mail->MsgHTML($body);
$mail->Send();

// update time so css and javascript will be loaded fresh
$jakdb->update("settings", ["used_value" => time()], ["varname" => "updated"]);
// update version
$jakdb->update("settings", ["used_value" => "3.8.6"], ["varname" => "version"]);

// Now let us delete all cache files
$cacheallfiles = '../'.JAK_CACHE_DIRECTORY.'/';
$msfi = glob($cacheallfiles."*.php");
if ($msfi) foreach ($msfi as $filen) {
    if (file_exists($filen)) unlink($filen);
}
	
die(json_encode(array("status" => 1)));

}

} else {
	die(json_encode(array("status" => 0)));
}
?>