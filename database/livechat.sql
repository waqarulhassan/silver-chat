-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2020 at 05:32 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `livechat`
--

-- --------------------------------------------------------

--
-- Table structure for table `lc3_answers`
--

CREATE TABLE `lc3_answers` (
  `id` int(10) NOT NULL,
  `department` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(3) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text,
  `fireup` smallint(5) UNSIGNED NOT NULL DEFAULT '60',
  `msgtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=standard,2=welcome,3=closed,4=expired,5=firstmsg',
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lc3_answers`
--

INSERT INTO `lc3_answers` (`id`, `department`, `lang`, `title`, `message`, `fireup`, `msgtype`, `created`) VALUES
(1, 0, 'en', 'Enters Chat', '%operator% enters the chat.', 15, 2, '2020-02-05 14:57:46'),
(2, 0, 'en', 'Expired', 'This session has expired!', 15, 4, '2020-02-05 14:57:46'),
(3, 0, 'en', 'Ended', '%client% has ended the conversation', 15, 3, '2020-02-05 14:57:46'),
(4, 0, 'en', 'Welcome', 'Welcome %client%, a representative will be with you shortly.', 15, 5, '2020-02-05 14:57:46'),
(5, 0, 'en', 'Leave', 'has left the conversation.', 15, 6, '2020-02-05 14:57:46'),
(6, 0, 'en', 'Start Page', 'Please insert your name to begin, a representative will be with you shortly.', 15, 7, '2020-02-05 14:57:46'),
(7, 0, 'en', 'Contact Page', 'None of our representatives are available right now, although you are welcome to leave a message!', 15, 8, '2020-02-05 14:57:46'),
(8, 0, 'en', 'Feedback Page', 'We would appreciate your feedback to improve our service.', 15, 9, '2020-02-05 14:57:46'),
(9, 0, 'en', 'Quickstart Page', 'Please type a message and hit enter to start the conversation.', 15, 10, '2020-02-05 14:57:46'),
(10, 0, 'en', 'Group Chat Welcome Message', 'Welcome to our weekly support session, sharing experience and feedback.', 0, 11, '2020-02-05 14:57:46'),
(11, 0, 'en', 'Group Chat Offline Message', 'The public chat is offline at this moment, please try again later.', 15, 12, '2020-02-05 14:57:46'),
(12, 0, 'en', 'Group Chat Full Message', 'The public chat is full, please try again later.', 15, 13, '2020-02-05 14:57:46'),
(13, 0, 'en', 'WhatsApp Online', 'Please click on a operator below to connect via WhatsApp and get help immediately.', 15, 26, '2020-02-05 14:57:46'),
(14, 0, 'en', 'WhatsApp Offline', 'We are currently offline however please check below for available operators in WhatsApp, we try to help you as soon as possible.', 15, 27, '2020-02-05 14:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `lc3_autoproactive`
--

CREATE TABLE `lc3_autoproactive` (
  `id` int(10) NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `imgpath` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `btn_confirm` varchar(50) DEFAULT NULL,
  `btn_cancel` varchar(50) DEFAULT NULL,
  `showalert` smallint(1) UNSIGNED NOT NULL DEFAULT '1',
  `soundalert` varchar(100) DEFAULT NULL,
  `timeonsite` smallint(3) UNSIGNED NOT NULL DEFAULT '2',
  `visitedsites` smallint(2) UNSIGNED NOT NULL DEFAULT '1',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_bot_question`
--

CREATE TABLE `lc3_bot_question` (
  `id` int(10) NOT NULL,
  `widgetids` varchar(100) DEFAULT '0',
  `depid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(2) DEFAULT NULL,
  `question` text,
  `answer` text,
  `updated` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_buttonstats`
--

CREATE TABLE `lc3_buttonstats` (
  `id` int(10) NOT NULL,
  `depid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `opid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `referrer` varchar(255) DEFAULT NULL,
  `firstreferrer` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `hits` int(10) NOT NULL DEFAULT '0',
  `ip` char(45) NOT NULL DEFAULT '0',
  `country` varchar(64) DEFAULT NULL,
  `countrycode` char(2) NOT NULL DEFAULT 'xx',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `proactive` int(10) NOT NULL DEFAULT '0',
  `message` varchar(255) DEFAULT NULL,
  `readtime` smallint(1) NOT NULL DEFAULT '0',
  `session` varchar(64) DEFAULT NULL,
  `lasttime` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_chatwidget`
--

CREATE TABLE `lc3_chatwidget` (
  `id` int(10) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `whatsapp_message` text,
  `depid` varchar(50) NOT NULL DEFAULT '0',
  `opid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(2) DEFAULT NULL,
  `widget` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `hideoff` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `buttonimg` varchar(100) NOT NULL,
  `mobilebuttonimg` varchar(100) NOT NULL,
  `slideimg` varchar(100) NOT NULL,
  `floatpopup` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `chat_direct` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `whatsapp_online` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `whatsapp_offline` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `client_email` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `client_semail` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `client_phone` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `client_sphone` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `client_question` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `client_squestion` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `show_avatar` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `floatcss` varchar(100) DEFAULT NULL,
  `floatcsschat` varchar(100) DEFAULT NULL,
  `engagecss` varchar(100) DEFAULT NULL,
  `btn_animation` varchar(20) DEFAULT NULL,
  `chat_animation` varchar(20) DEFAULT NULL,
  `engage_animation` varchar(20) DEFAULT NULL,
  `dsgvo` text,
  `redirect_url` varchar(200) DEFAULT NULL,
  `redirect_active` tinyint(3) UNSIGNED DEFAULT '0',
  `redirect_after` tinyint(3) UNSIGNED DEFAULT '8',
  `feedback` tinyint(3) UNSIGNED DEFAULT '1',
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
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lc3_chatwidget`
--

INSERT INTO `lc3_chatwidget` (`id`, `title`, `whatsapp_message`, `depid`, `opid`, `lang`, `widget`, `hideoff`, `buttonimg`, `mobilebuttonimg`, `slideimg`, `floatpopup`, `chat_direct`, `whatsapp_online`, `whatsapp_offline`, `client_email`, `client_semail`, `client_phone`, `client_sphone`, `client_question`, `client_squestion`, `show_avatar`, `floatcss`, `floatcsschat`, `engagecss`, `btn_animation`, `chat_animation`, `engage_animation`, `dsgvo`, `redirect_url`, `redirect_active`, `redirect_after`, `feedback`, `sucolor`, `sutcolor`, `template`, `theme_colour`, `body_colour`, `h_colour`, `c_colour`, `time_colour`, `link_colour`, `sidebar_colour`, `t_font`, `h_font`, `c_font`, `widget_whitelist`, `created`) VALUES
(1, 'Live Support Chat', NULL, '0', 0, 'en', 1, 0, 'jaklc_on.png', '', 'chatnow_on.png', 1, 1, 0, 0, 1, 1, 0, 1, 1, 1, 1, 'bottom:0;right:40px;', 'bottom:0;right:40px;', 'left:50%;top:50%;transform: translate(-50%, -50%);', NULL, NULL, NULL, NULL, NULL, 0, 8, 1, '', '', 'modern', 'standard', '#ffffff', '#494949', '#494949', '#999999', '#007ff5', '#857d7d', '', 'Open+Sans', 'Open+Sans', '', '2020-02-05 14:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `lc3_checkstatus`
--

CREATE TABLE `lc3_checkstatus` (
  `convid` int(10) UNSIGNED NOT NULL,
  `depid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `department` varchar(100) DEFAULT NULL,
  `operatorid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `operator` varchar(100) DEFAULT NULL,
  `pusho` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `newc` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `newo` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `files` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `knockknock` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `msgdel` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `msgedit` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `typec` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `typeo` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `transferoid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `transferid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `denied` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `hide` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `datac` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `statusc` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `statuso` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `initiated` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_clientcontact`
--

CREATE TABLE `lc3_clientcontact` (
  `id` int(10) NOT NULL,
  `sessionid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `operatorid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `operatorname` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `sent` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_contacts`
--

CREATE TABLE `lc3_contacts` (
  `id` int(10) NOT NULL,
  `depid` int(10) UNSIGNED NOT NULL DEFAULT '0',
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
  `reply` smallint(1) UNSIGNED NOT NULL DEFAULT '0',
  `answered` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `sent` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_contactsreply`
--

CREATE TABLE `lc3_contactsreply` (
  `id` int(10) NOT NULL,
  `contactid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `operatorid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `operatorname` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `sent` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_departments`
--

CREATE TABLE `lc3_departments` (
  `id` int(10) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` mediumtext,
  `email` varchar(255) DEFAULT NULL,
  `faq_url` text,
  `active` smallint(1) UNSIGNED NOT NULL DEFAULT '1',
  `dorder` smallint(2) UNSIGNED NOT NULL DEFAULT '1',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lc3_departments`
--

INSERT INTO `lc3_departments` (`id`, `title`, `description`, `email`, `faq_url`, `active`, `dorder`, `time`) VALUES
(1, 'My First Department', 'Edit this department to your needs...', NULL, NULL, 1, 1, '2020-02-05 14:57:53');

-- --------------------------------------------------------

--
-- Table structure for table `lc3_files`
--

CREATE TABLE `lc3_files` (
  `id` int(10) NOT NULL,
  `path` text,
  `name` varchar(200) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_groupchat`
--

CREATE TABLE `lc3_groupchat` (
  `id` int(10) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `opids` varchar(10) DEFAULT '0',
  `maxclients` tinyint(3) UNSIGNED NOT NULL DEFAULT '20',
  `lang` char(2) DEFAULT NULL,
  `buttonimg` varchar(100) NOT NULL,
  `floatpopup` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `floatcss` varchar(100) DEFAULT NULL,
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lc3_groupchat`
--

INSERT INTO `lc3_groupchat` (`id`, `password`, `title`, `description`, `opids`, `maxclients`, `lang`, `buttonimg`, `floatpopup`, `floatcss`, `active`, `created`) VALUES
(1, NULL, 'Weekly Support', NULL, '0', 10, 'en', 'colour_on.png', 0, 'bottom:20px;left:20px', 0, '2020-02-05 14:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `lc3_groupchatmsg`
--

CREATE TABLE `lc3_groupchatmsg` (
  `id` int(10) NOT NULL,
  `groupchatid` int(10) NOT NULL DEFAULT '0',
  `chathistory` mediumtext,
  `operatorid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_groupchatuser`
--

CREATE TABLE `lc3_groupchatuser` (
  `id` int(10) NOT NULL,
  `groupchatid` int(10) NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `usr_avatar` varchar(255) DEFAULT NULL,
  `statusc` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `lastmsg` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `banned` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(45) NOT NULL DEFAULT '0',
  `isop` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `session` varchar(64) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_loginlog`
--

CREATE TABLE `lc3_loginlog` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `fromwhere` varchar(255) DEFAULT NULL,
  `ip` char(45) NOT NULL DEFAULT '0',
  `usragent` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `access` smallint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lc3_loginlog`
--

INSERT INTO `lc3_loginlog` (`id`, `name`, `fromwhere`, `ip`, `usragent`, `time`, `access`) VALUES
(1, 'admin', '/livechat/operator/', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2020-02-05 15:00:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lc3_operatorchat`
--

CREATE TABLE `lc3_operatorchat` (
  `id` int(10) UNSIGNED NOT NULL,
  `fromid` int(10) NOT NULL DEFAULT '0',
  `toid` int(10) NOT NULL DEFAULT '0',
  `message` text,
  `sent` int(10) NOT NULL DEFAULT '0',
  `received` smallint(1) UNSIGNED NOT NULL DEFAULT '0',
  `msgpublic` smallint(1) UNSIGNED NOT NULL DEFAULT '0',
  `system_message` varchar(3) DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_push_notification_devices`
--

CREATE TABLE `lc3_push_notification_devices` (
  `id` int(10) NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ostype` enum('ios','android') NOT NULL DEFAULT 'ios',
  `token` varchar(255) DEFAULT NULL,
  `lastedit` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_responses`
--

CREATE TABLE `lc3_responses` (
  `id` int(10) NOT NULL,
  `department` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(200) DEFAULT NULL,
  `message` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lc3_responses`
--

INSERT INTO `lc3_responses` (`id`, `department`, `title`, `message`) VALUES
(1, 0, 'Assist Today', 'How can I assist you today?');

-- --------------------------------------------------------

--
-- Table structure for table `lc3_sessions`
--

CREATE TABLE `lc3_sessions` (
  `id` int(10) NOT NULL,
  `userid` varchar(200) DEFAULT NULL,
  `department` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `operatorid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `operatorname` varchar(255) DEFAULT NULL,
  `template` varchar(20) DEFAULT NULL,
  `usr_avatar` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `countrycode` varchar(2) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `notes` text,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `fcontact` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `initiated` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ended` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `deniedoid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `session` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_settings`
--

CREATE TABLE `lc3_settings` (
  `id` int(10) NOT NULL,
  `varname` varchar(100) DEFAULT NULL,
  `used_value` text,
  `default_value` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lc3_settings`
--

INSERT INTO `lc3_settings` (`id`, `varname`, `used_value`, `default_value`) VALUES
(1, 'allowedo_files', '.zip,.rar,.jpg,.jpeg,.png,.gif', '.zip,.rar,.jpg,.jpeg,.png,.gif'),
(2, 'allowed_files', '.zip,.rar,.jpg,.jpeg,.png,.gif', '.zip,.rar,.jpg,.jpeg,.png,.gif'),
(3, 'validtill', '0', '0'),
(4, 'captcha', '0', '1'),
(5, 'client_expired', '600', '600'),
(6, 'client_left', '300', '300'),
(7, 'crating', '1', '0'),
(8, 'dateformat', 'd.m.Y', 'd.m.Y'),
(9, 'email', 'test@test.com', '@lc3jak'),
(10, 'emailcc', '', '@jakcc'),
(11, 'email_block', '', NULL),
(12, 'facebook', '', ''),
(13, 'facebook_big', '', ''),
(14, 'ip_block', '', NULL),
(15, 'lang', 'en', 'en'),
(16, 'live_online_status', '0', '0'),
(17, 'chat_upload_standard', '0', '0'),
(18, 'msg_tone', 'new_message', 'new_message'),
(19, 'openop', '1', '1'),
(20, 'o_number', '579e178e-d3c5-4cf1-8fc2-02543bb47c60', '0'),
(21, 'pro_alert', '1', '1'),
(22, 'ring_tone', 'ring', 'ring'),
(23, 'send_tscript', '1', '1'),
(24, 'show_ips', '1', '1'),
(25, 'smtphost', '', ''),
(26, 'smtppassword', '', ''),
(27, 'smtpport', '25', '25'),
(28, 'smtpusername', '', ''),
(29, 'smtp_alive', '0', '0'),
(30, 'smtp_auth', '0', '0'),
(31, 'smtp_mail', '0', '0'),
(32, 'smtp_prefix', '', ''),
(33, 'timeformat', 'g:i a', 'g:i a'),
(34, 'timezoneserver', 'Europe/Zurich', 'Europe/Zurich'),
(35, 'title', 'Live Chat 3', 'Live Chat 3'),
(36, 'twilio_nexmo', '0', '1'),
(37, 'twitter', '', ''),
(38, 'twitter_big', '', ''),
(39, 'tw_msg', 'A customer is requesting attention.', 'A customer is requesting attention.'),
(40, 'tw_phone', '', ''),
(41, 'tw_sid', '', ''),
(42, 'tw_token', '', ''),
(43, 'updated', '1580911080', '1475494685'),
(44, 'useravatheight', '113', '113'),
(45, 'useravatwidth', '150', '150'),
(46, 'version', '3.8.6', '3.8.6'),
(47, 'holiday_mode', '0', '0'),
(48, 'push_reminder', '120', '120'),
(49, 'native_app_token', '', 'jakweb_app'),
(50, 'native_app_key', '', 'jakweb_app'),
(51, 'client_push_not', '1', '1'),
(52, 'engage_sound', 'sound/new_message3', 'sound/new_message3'),
(53, 'client_sound', 'sound/hello', 'sound/hello'),
(54, 'proactive_time', '3', '3');

-- --------------------------------------------------------

--
-- Table structure for table `lc3_transcript`
--

CREATE TABLE `lc3_transcript` (
  `id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `message` varchar(2000) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `operatorid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `convid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `quoted` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `replied` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `starred` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `editoid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edited` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `sentstatus` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `class` varchar(20) DEFAULT NULL,
  `plevel` smallint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_transfer`
--

CREATE TABLE `lc3_transfer` (
  `id` int(10) NOT NULL,
  `convid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `fromoid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `fromname` varchar(100) DEFAULT NULL,
  `tooid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `toname` varchar(100) DEFAULT NULL,
  `message` text,
  `used` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_urlblacklist`
--

CREATE TABLE `lc3_urlblacklist` (
  `id` int(10) NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lc3_user`
--

CREATE TABLE `lc3_user` (
  `id` int(10) NOT NULL,
  `departments` varchar(100) DEFAULT '0',
  `available` smallint(1) UNSIGNED NOT NULL DEFAULT '0',
  `busy` smallint(1) UNSIGNED NOT NULL DEFAULT '0',
  `hours_array` text,
  `phonenumber` varchar(255) DEFAULT NULL,
  `whatsappnumber` varchar(255) DEFAULT NULL,
  `pusho_tok` varchar(50) DEFAULT NULL,
  `pusho_key` varchar(50) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` char(64) DEFAULT NULL,
  `idhash` varchar(32) DEFAULT NULL,
  `session` varchar(64) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `picture` varchar(100) NOT NULL DEFAULT '/standard.jpg',
  `language` varchar(10) DEFAULT NULL,
  `invitationmsg` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00',
  `lastactivity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `logins` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `responses` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `files` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `useronlinelist` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
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
  `access` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `permissions` varchar(512) DEFAULT NULL,
  `forgot` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lc3_user`
--

INSERT INTO `lc3_user` (`id`, `departments`, `available`, `busy`, `hours_array`, `phonenumber`, `whatsappnumber`, `pusho_tok`, `pusho_key`, `username`, `password`, `idhash`, `session`, `email`, `name`, `picture`, `language`, `invitationmsg`, `time`, `lastactivity`, `hits`, `logins`, `responses`, `files`, `useronlinelist`, `operatorchat`, `operatorchatpublic`, `operatorlist`, `transferc`, `chat_latency`, `push_notifications`, `sound`, `ringing`, `alwaysnot`, `emailnot`, `access`, `permissions`, `forgot`) VALUES
(1, '0', 1, 0, NULL, NULL, NULL, NULL, NULL, 'admin', '3086b059b2569020f04a7952559728d79c06c7bbd162630efaf163a19d8dae9f', '9af55ea15be7e29ff396b88709b7347f', 'c46fc8vu08qb7r155gorf6p8k1', 'test@test.com', 'silver', '/standard.jpg', NULL, NULL, '2020-02-05 14:59:46', 1580920272, 0, 1, 1, 1, 1, 1, 1, 0, 1, 3000, 0, 1, 3, 0, 0, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lc3_user_stats`
--

CREATE TABLE `lc3_user_stats` (
  `id` int(10) NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `vote` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text,
  `support_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '1980-05-06 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lc3_answers`
--
ALTER TABLE `lc3_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depid` (`department`,`lang`,`fireup`,`msgtype`);

--
-- Indexes for table `lc3_autoproactive`
--
ALTER TABLE `lc3_autoproactive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `path` (`path`);

--
-- Indexes for table `lc3_bot_question`
--
ALTER TABLE `lc3_bot_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `widgetids` (`widgetids`,`depid`,`lang`);

--
-- Indexes for table `lc3_buttonstats`
--
ALTER TABLE `lc3_buttonstats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depid` (`depid`),
  ADD KEY `session` (`session`);

--
-- Indexes for table `lc3_chatwidget`
--
ALTER TABLE `lc3_chatwidget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depid` (`depid`,`opid`,`lang`);

--
-- Indexes for table `lc3_checkstatus`
--
ALTER TABLE `lc3_checkstatus`
  ADD UNIQUE KEY `convid` (`convid`),
  ADD KEY `denied` (`denied`,`hide`,`statusc`,`statuso`);

--
-- Indexes for table `lc3_clientcontact`
--
ALTER TABLE `lc3_clientcontact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc3_contacts`
--
ALTER TABLE `lc3_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depid` (`depid`);

--
-- Indexes for table `lc3_contactsreply`
--
ALTER TABLE `lc3_contactsreply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contactid` (`contactid`);

--
-- Indexes for table `lc3_departments`
--
ALTER TABLE `lc3_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc3_files`
--
ALTER TABLE `lc3_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc3_groupchat`
--
ALTER TABLE `lc3_groupchat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opids` (`opids`);

--
-- Indexes for table `lc3_groupchatmsg`
--
ALTER TABLE `lc3_groupchatmsg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupchatid` (`groupchatid`);

--
-- Indexes for table `lc3_groupchatuser`
--
ALTER TABLE `lc3_groupchatuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupchatid` (`groupchatid`);

--
-- Indexes for table `lc3_loginlog`
--
ALTER TABLE `lc3_loginlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc3_operatorchat`
--
ALTER TABLE `lc3_operatorchat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc3_push_notification_devices`
--
ALTER TABLE `lc3_push_notification_devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`,`ostype`,`token`);

--
-- Indexes for table `lc3_responses`
--
ALTER TABLE `lc3_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc3_sessions`
--
ALTER TABLE `lc3_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `operatorid` (`operatorid`),
  ADD KEY `session` (`session`);

--
-- Indexes for table `lc3_settings`
--
ALTER TABLE `lc3_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc3_transcript`
--
ALTER TABLE `lc3_transcript`
  ADD PRIMARY KEY (`id`),
  ADD KEY `convid` (`convid`);

--
-- Indexes for table `lc3_transfer`
--
ALTER TABLE `lc3_transfer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `convid` (`convid`,`tooid`,`used`);

--
-- Indexes for table `lc3_urlblacklist`
--
ALTER TABLE `lc3_urlblacklist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `path` (`path`);

--
-- Indexes for table `lc3_user`
--
ALTER TABLE `lc3_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc3_user_stats`
--
ALTER TABLE `lc3_user_stats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lc3_answers`
--
ALTER TABLE `lc3_answers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `lc3_autoproactive`
--
ALTER TABLE `lc3_autoproactive`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_bot_question`
--
ALTER TABLE `lc3_bot_question`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_buttonstats`
--
ALTER TABLE `lc3_buttonstats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_chatwidget`
--
ALTER TABLE `lc3_chatwidget`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lc3_clientcontact`
--
ALTER TABLE `lc3_clientcontact`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_contacts`
--
ALTER TABLE `lc3_contacts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_contactsreply`
--
ALTER TABLE `lc3_contactsreply`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_departments`
--
ALTER TABLE `lc3_departments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lc3_files`
--
ALTER TABLE `lc3_files`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_groupchat`
--
ALTER TABLE `lc3_groupchat`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lc3_groupchatmsg`
--
ALTER TABLE `lc3_groupchatmsg`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_groupchatuser`
--
ALTER TABLE `lc3_groupchatuser`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_loginlog`
--
ALTER TABLE `lc3_loginlog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lc3_operatorchat`
--
ALTER TABLE `lc3_operatorchat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_push_notification_devices`
--
ALTER TABLE `lc3_push_notification_devices`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_responses`
--
ALTER TABLE `lc3_responses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lc3_sessions`
--
ALTER TABLE `lc3_sessions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_settings`
--
ALTER TABLE `lc3_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `lc3_transcript`
--
ALTER TABLE `lc3_transcript`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_transfer`
--
ALTER TABLE `lc3_transfer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_urlblacklist`
--
ALTER TABLE `lc3_urlblacklist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lc3_user`
--
ALTER TABLE `lc3_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lc3_user_stats`
--
ALTER TABLE `lc3_user_stats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
