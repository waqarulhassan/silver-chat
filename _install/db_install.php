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

if (!file_exists('../config.php')) die('install/[db_install.php] config.php not exist');
require_once '../config.php';

if (is_numeric($_POST['step']) && $_POST['step'] == 3) {

$result = $jakdb->get("departments", "title", ["id" => 1]);
  	
if (!$result) {

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."answers (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `department` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(3) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text,
  `fireup` smallint(5) unsigned NOT NULL DEFAULT '60',
  `msgtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=standard,2=welcome,3=closed,4=expired,5=firstmsg',
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`),
  KEY `depid` (`department`,`lang`,`fireup`,`msgtype`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8");

$jakdb->query("INSERT INTO ".JAKDB_PREFIX."answers (`id`, `department`, `lang`, `title`, `message`, `fireup`, `msgtype`, `created`) VALUES
(1, 0, 'en', 'Enters Chat', '%operator% enters the chat.', 15, 2, NOW()),
(2, 0, 'en', 'Expired', 'This session has expired!', 15, 4, NOW()),
(3, 0, 'en', 'Ended', '%client% has ended the conversation', 15, 3, NOW()),
(4, 0, 'en', 'Welcome', 'Welcome %client%, a representative will be with you shortly.', 15, 5, NOW()),
(5, 0, 'en', 'Leave', 'has left the conversation.', 15, 6, NOW()),
(6, 0, 'en', 'Start Page', 'Please insert your name to begin, a representative will be with you shortly.', 15, 7, NOW()),
(7, 0, 'en', 'Contact Page', 'None of our representatives are available right now, although you are welcome to leave a message!', 15, 8, NOW()),
(8, 0, 'en', 'Feedback Page', 'We would appreciate your feedback to improve our service.', 15, 9, NOW()),
(9, 0, 'en', 'Quickstart Page', 'Please type a message and hit enter to start the conversation.', 15, 10, NOW()),
(10, 0, 'en', 'Group Chat Welcome Message', 'Welcome to our weekly support session, sharing experience and feedback.', 0, 11, NOW()),
(11, 0, 'en', 'Group Chat Offline Message', 'The public chat is offline at this moment, please try again later.', 15, 12, NOW()),
(12, 0, 'en', 'Group Chat Full Message', 'The public chat is full, please try again later.', 15, 13, NOW()),
(NULL, 0, 'en', 'WhatsApp Online', 'Please click on a operator below to connect via WhatsApp and get help immediately.', 15, 26, NOW()),
(NULL, 0, 'en', 'WhatsApp Offline', 'We are currently offline however please check below for available operators in WhatsApp, we try to help you as soon as possible.', 15, 27, NOW())");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."autoproactive (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `path` varchar(200) NULL DEFAULT NULL,
  `title` varchar(255) NULL DEFAULT NULL,
  `imgpath` varchar(255) NULL DEFAULT NULL,
  `message` varchar(255) NULL DEFAULT NULL,
  `btn_confirm` VARCHAR(50) NULL DEFAULT NULL,
  `btn_cancel` VARCHAR(50) NULL DEFAULT NULL,
  `showalert` smallint(1) unsigned NOT NULL DEFAULT '1',
  `soundalert` VARCHAR(100) NULL DEFAULT NULL,
  `timeonsite` smallint(3) unsigned NOT NULL DEFAULT '2',
  `visitedsites` smallint(2) unsigned NOT NULL DEFAULT '1',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`),
  KEY `path` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."urlblacklist (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `path` varchar(200) NULL DEFAULT NULL,
  `title` varchar(255) NULL DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`),
  KEY `path` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."buttonstats (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `depid` int(10) unsigned NOT NULL DEFAULT '0',
  `opid` int(10) unsigned NOT NULL DEFAULT '0',
  `referrer` varchar(255) DEFAULT NULL,
  `firstreferrer` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `hits` int(10) NOT NULL DEFAULT '0',
  `ip` char(45) NOT NULL DEFAULT '0',
  `country` varchar(64) DEFAULT NULL,
  `countrycode` CHAR(2) NOT NULL DEFAULT 'xx',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `proactive` int(10) NOT NULL DEFAULT '0',
  `message` varchar(255) DEFAULT NULL,
  `readtime` smallint(1) NOT NULL DEFAULT '0',
  `session` varchar(64) DEFAULT NULL,
  `lasttime` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`),
  KEY `depid` (`depid`),
  KEY `session` (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."bot_question (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `widgetids` varchar(100) DEFAULT '0',
  `depid` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(2) DEFAULT NULL,
  `question` text,
  `answer` text,
  `updated` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `widgetids` (`widgetids`, `depid`, `lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."chatwidget (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `whatsapp_message` text,
  `depid` varchar(50) NOT NULL DEFAULT '0',
  `opid` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` char(2) DEFAULT NULL,
  `widget` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `hideoff` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `buttonimg` varchar(100) NOT NULL,
  `mobilebuttonimg` varchar(100) NOT NULL,
  `slideimg` varchar(100) NOT NULL,
  `floatpopup` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `chat_direct` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `whatsapp_online` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `whatsapp_offline` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `client_email` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `client_semail` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `client_phone` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `client_sphone` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `client_question` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `client_squestion` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `show_avatar` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `floatcss` varchar(100) DEFAULT NULL,
  `floatcsschat` varchar(100) DEFAULT NULL,
  `engagecss` varchar(100) DEFAULT NULL,
  `btn_animation` varchar(20) DEFAULT NULL,
  `chat_animation` varchar(20) DEFAULT NULL,
  `engage_animation` varchar(20) DEFAULT NULL,
  `dsgvo` text,
  `redirect_url` varchar(200) DEFAULT NULL,
  `redirect_active` tinyint(3) unsigned DEFAULT '0',
  `redirect_after` tinyint(3) unsigned DEFAULT '8',
  `feedback` tinyint(3) unsigned NULL DEFAULT '1',
  `sucolor` char(7) NOT NULL DEFAULT '#6f6f6f',
  `sutcolor` char(7) NOT NULL DEFAULT '#ffffff',
  `template` varchar(20) DEFAULT NULL,
  `theme_colour` varchar(10) DEFAULT 'primary',
  `body_colour` char(7) DEFAULT '#ffffff',
  `h_colour` char(7) DEFAULT '#494949',
  `c_colour` char(7) DEFAULT '#494949',
  `time_colour` char(7) DEFAULT '#999999',
  `link_colour` char(7) DEFAULT '#2f942b',
  `sidebar_colour` char(7) DEFAULT '#857d7d',
  `t_font` varchar(100) NOT NULL,
  `h_font` varchar(100) NOT NULL DEFAULT 'NonGoogle',
  `c_font` varchar(100) NOT NULL DEFAULT 'Arial, Helvetica, sans-serif',
  `widget_whitelist` text,
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`),
  KEY `depid` (`depid`, `opid`, `lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

$jakdb->query("INSERT INTO ".JAKDB_PREFIX."chatwidget (`id`, `title`, `depid`, `opid`, `lang`, `widget`, `hideoff`, `buttonimg`, `slideimg`, `floatpopup`, `chat_direct`, `client_email`, `client_semail`, `client_phone`, `client_sphone`, `client_question`, `client_squestion`, `show_avatar`, `floatcss`, `floatcsschat`, `engagecss`, `sucolor`, `sutcolor`, `template`, `theme_colour`, `body_colour`, `h_colour`, `c_colour`, `time_colour`, `link_colour`, `sidebar_colour`, `t_font`, `h_font`, `c_font`, `widget_whitelist`, `created`) VALUES
(1, 'Live Support Chat',  0,  0,  'en', 1,  0,  'jaklc_on.png', 'chatnow_on.png', 1, 1, 1, 1, 0, 1, 1, 1, 1, 'bottom:0;right:40px;', 'bottom:0;right:40px;', 'left:50%;top:50%;transform: translate(-50%, -50%);', '', '', 'modern', 'standard', '#ffffff', '#494949', '#494949', '#999999', '#007ff5', '#857d7d', '', 'Open+Sans', 'Open+Sans', '', NOW())");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."clientcontact (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sessionid` int(10) unsigned NOT NULL DEFAULT '0',
  `operatorid` int(10) unsigned NOT NULL DEFAULT '0',
  `operatorname` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `sent` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."contacts (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `depid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` text,
  `ip` char(45) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `countrycode` varchar(2) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `reply` smallint(1) unsigned NOT NULL DEFAULT '0',
  `answered` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `sent` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`),
  KEY `depid` (`depid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."contactsreply (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `contactid` int(10) unsigned NOT NULL DEFAULT '0',
  `operatorid` int(10) unsigned NOT NULL DEFAULT '0',
  `operatorname` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `sent` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`),
  KEY `contactid` (`contactid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."departments (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` mediumtext,
  `email` varchar(255) DEFAULT NULL,
  `faq_url` text,
  `active` smallint(1) unsigned NOT NULL DEFAULT '1',
  `dorder` smallint(2) unsigned NOT NULL DEFAULT '1',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2");

$jakdb->query("INSERT INTO ".JAKDB_PREFIX."departments (`id`, `title`, `description`, `active`, `dorder`, `time`) VALUES
(1, 'My First Department', 'Edit this department to your needs...', 1, 1, NOW())");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."files (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `path` text,
  `name` varchar(200) NULL DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."groupchat (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `password` varchar(20) NULL DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text NULL DEFAULT NULL,
  `opids` varchar(10) DEFAULT '0',
  `maxclients` tinyint(3) unsigned NOT NULL DEFAULT '20',
  `lang` char(2) DEFAULT NULL,
  `buttonimg` varchar(100) NOT NULL,
  `floatpopup` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `floatcss` varchar(100) DEFAULT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`),
  KEY `opids` (`opids`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8");

$jakdb->query("INSERT INTO ".JAKDB_PREFIX."groupchat (`id`, `title`, `opids`, `maxclients`, `lang`, `buttonimg`, `floatpopup`, `floatcss`, `active`, `created`) VALUES
(1, 'Weekly Support', '0', 10, 'en', 'colour_on.png', 0, 'bottom:20px;left:20px', 0, NOW())");

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

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."loginlog (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `fromwhere` varchar(255) DEFAULT NULL,
  `ip` char(45) NOT NULL DEFAULT '0',
  `usragent` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `access` smallint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."operatorchat (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fromid` int(10) NOT NULL DEFAULT '0',
  `toid` int(10) NOT NULL DEFAULT '0',
  `message` text NULL DEFAULT NULL,
  `sent` int(10) NOT NULL DEFAULT '0',
  `received` smallint(1) unsigned NOT NULL DEFAULT '0',
  `msgpublic` smallint(1) unsigned NOT NULL DEFAULT '0',
  `system_message` varchar(3) DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."responses (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `department` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(200) NULL DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2");

$jakdb->query("INSERT INTO ".JAKDB_PREFIX."responses (`id`, `title`, `message`) VALUES
(1, 'Assist Today', 'How can I assist you today?')");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."sessions (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` varchar(200) NULL DEFAULT NULL,
  `department` int(10) unsigned NOT NULL DEFAULT '0',
  `operatorid` int(10) unsigned NOT NULL DEFAULT '0',
  `operatorname` varchar(255) NULL DEFAULT NULL,
  `template` varchar(20) NULL DEFAULT NULL,
  `usr_avatar` varchar(255) NULL DEFAULT NULL,
  `name` varchar(100) NULL DEFAULT NULL,
  `email` varchar(100) NULL DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `countrycode` varchar(2) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `notes` text,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `fcontact` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `initiated` int(10) unsigned NOT NULL DEFAULT '0',
  `ended` int(10) unsigned NOT NULL DEFAULT '0',
  `deniedoid` int(10) unsigned NOT NULL DEFAULT '0',
  `session` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `operatorid` (`operatorid`),
  KEY `session` (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."settings (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(100) DEFAULT NULL,
  `used_value` text,
  `default_value` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

$jakdb->query("INSERT INTO ".JAKDB_PREFIX."settings (`id`, `varname`, `used_value`, `default_value`) VALUES
(NULL, 'allowedo_files', '.zip,.rar,.jpg,.jpeg,.png,.gif', '.zip,.rar,.jpg,.jpeg,.png,.gif'),
(NULL, 'allowed_files', '.zip,.rar,.jpg,.jpeg,.png,.gif', '.zip,.rar,.jpg,.jpeg,.png,.gif'),
(NULL, 'validtill', 0, 0),
(NULL, 'captcha', '0', '1'),
(NULL, 'client_expired', '600', '600'),
(NULL, 'client_left', '300', '300'),
(NULL, 'crating', '1', '0'),
(NULL, 'dateformat', 'd.m.Y', 'd.m.Y'),
(NULL, 'email', '', '@lc3jak'),
(NULL, 'emailcc', '', '@jakcc'),
(NULL, 'email_block', '', NULL),
(NULL, 'facebook', '', ''),
(NULL, 'facebook_big', '', ''),
(NULL, 'ip_block', '', NULL),
(NULL, 'lang', 'en', 'en'),
(NULL, 'live_online_status', '0', '0'),
(NULL, 'chat_upload_standard', '0', '0'),
(NULL, 'msg_tone', 'new_message', 'new_message'),
(NULL, 'openop', '1', '1'),
(NULL, 'o_number', 'O-test', '0'),
(NULL, 'pro_alert', '1', '1'),
(NULL, 'ring_tone', 'ring', 'ring'),
(NULL, 'send_tscript', '1', '1'),
(NULL, 'show_ips', '1', '1'),
(NULL, 'smtphost', '', ''),
(NULL, 'smtppassword', '', ''),
(NULL, 'smtpport', '25', '25'),
(NULL, 'smtpusername', '', ''),
(NULL, 'smtp_alive', '0', '0'),
(NULL, 'smtp_auth', '0', '0'),
(NULL, 'smtp_mail', '0', '0'),
(NULL, 'smtp_prefix', '', ''),
(NULL, 'timeformat', 'g:i a', 'g:i a'),
(NULL, 'timezoneserver', 'Europe/Zurich', 'Europe/Zurich'),
(NULL, 'title', 'Live Chat 3', 'Live Chat 3'),
(NULL, 'twilio_nexmo', '0', '1'),
(NULL, 'twitter', '', ''),
(NULL, 'twitter_big', '', ''),
(NULL, 'tw_msg', 'A customer is requesting attention.', 'A customer is requesting attention.'),
(NULL, 'tw_phone', '', ''),
(NULL, 'tw_sid', '', ''),
(NULL, 'tw_token', '', ''),
(NULL, 'updated', '".time()."', '1475494685'),
(NULL, 'useravatheight', '113', '113'),
(NULL, 'useravatwidth', '150', '150'),
(NULL, 'version', '3.8.6', '3.8.6'),
(NULL, 'holiday_mode', '0', '0'),
(NULL, 'push_reminder', '120', '120'),
(NULL, 'native_app_token', '', 'jakweb_app'),
(NULL, 'native_app_key', '', 'jakweb_app'),
(NULL, 'client_push_not', '1', '1'),
(NULL, 'engage_sound', 'sound/new_message3', 'sound/new_message3'),
(NULL, 'client_sound', 'sound/hello', 'sound/hello'),
(NULL, 'proactive_time', '3', '3')");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."transcript (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NULL DEFAULT NULL,
  `message` varchar(2000) NULL DEFAULT NULL,
  `user` varchar(100) NULL DEFAULT NULL,
  `operatorid` int(10) unsigned NOT NULL DEFAULT '0',
  `convid` int(10) unsigned NOT NULL DEFAULT '0',
  `quoted` int(10) unsigned NOT NULL DEFAULT '0',
  `replied` int(10) unsigned NOT NULL DEFAULT '0',
  `starred` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `editoid` int(10) unsigned NOT NULL DEFAULT '0',
  `edited` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `sentstatus` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `class` varchar(20) NULL DEFAULT NULL,
  `plevel` smallint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `convid` (`convid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."user (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `departments` varchar(100) DEFAULT '0',
  `available` smallint(1) unsigned NOT NULL DEFAULT '0',
  `busy` smallint(1) unsigned NOT NULL DEFAULT '0',
  `hours_array` TEXT NULL,
  `phonenumber` varchar(255) DEFAULT NULL,
  `whatsappnumber` varchar(255) DEFAULT NULL,
  `pusho_tok` VARCHAR(50) DEFAULT NULL,
  `pusho_key` VARCHAR(50) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` char(64) NULL DEFAULT NULL,
  `idhash` varchar(32) DEFAULT NULL,
  `session` varchar(64) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `picture` varchar(100) NOT NULL DEFAULT '/standard.jpg',
  `language` varchar(10) DEFAULT NULL,
  `invitationmsg` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `lastactivity` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `responses` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `files` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `useronlinelist` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `operatorchat` tinyint(1) NOT NULL DEFAULT '0',
  `operatorchatpublic` tinyint(1) NOT NULL DEFAULT '1',
  `operatorlist` tinyint(1) NOT NULL DEFAULT '0',
  `transferc` tinyint(1) NOT NULL DEFAULT '1',
  `chat_latency` smallint(4) UNSIGNED NOT NULL DEFAULT '3000',
  `push_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `sound` tinyint(1) NOT NULL DEFAULT '1',
  `ringing` tinyint(2) NOT NULL DEFAULT '3',
  `alwaysnot` tinyint(1) NOT NULL DEFAULT '0',
  `emailnot` tinyint(1) NOT NULL DEFAULT '0',
  `access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `permissions` varchar(512) DEFAULT NULL,
  `forgot` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$jakdb->query("CREATE TABLE ".JAKDB_PREFIX."user_stats (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `vote` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text,
  `support_time` int(10) unsigned NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

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
  `id` int(10) NOT NULL AUTO_INCREMENT,
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

// Now let us delete all cache files
$cacheallfiles = '../'.JAK_CACHE_DIRECTORY.'/';
$msfi = glob($cacheallfiles."*.php");
if ($msfi) foreach ($msfi as $filen) {
    if (file_exists($filen)) unlink($filen);
}
	
	die(json_encode(array("status" => 1)));

} else {
	die(json_encode(array("status" => 2)));
}

} else {
	die(json_encode(array("status" => 0)));
}
?>