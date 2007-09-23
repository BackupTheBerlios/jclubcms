-- phpMyAdmin SQL Dump
-- version 2.11.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 23. September 2007 um 23:54
-- Server Version: 5.0.45
-- PHP-Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `jclubbeta`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_content`
--

CREATE TABLE `admin_content` (
  `content_ID` int(10) NOT NULL auto_increment,
  `content_title` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  `content_text` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`content_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `admin_content`
--

INSERT INTO `admin_content` (`content_ID`, `content_title`, `content_text`) VALUES(1, 'Home', 'Hallo und herzlich Willkommen im Admin-Menu');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_groups`
--

CREATE TABLE `admin_groups` (
  `groups_ID` int(11) NOT NULL auto_increment,
  `groups_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `groups_chief_ref_ID` int(11) NOT NULL,
  PRIMARY KEY  (`groups_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `admin_groups`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_menu`
--

CREATE TABLE `admin_menu` (
  `menu_ID` int(11) NOT NULL auto_increment COMMENT 'Jetzt weisi wär du bisch',
  `menu_topid` int(11) NOT NULL default '0' COMMENT 'Stohsch wieder über de andere',
  `menu_position` int(11) NOT NULL default '0' COMMENT '"Die Ersten werden die LETZTEN sein" ',
  `menu_name` text collate utf8_unicode_ci NOT NULL COMMENT 'Sgit besseri Näme',
  `menu_page` int(11) NOT NULL default '0' COMMENT 'Gang mou dört go sueche!',
  `menu_pagetyp` enum('mod','pag') collate utf8_unicode_ci NOT NULL default 'mod' COMMENT 'Machts e Unterschie?!?',
  `menu_shortlink` enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  `menu_image` varchar(50) collate utf8_unicode_ci NOT NULL,
  `menu_modvar` varchar(45) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Wotsch no öppis mitgäh?!?',
  `menu_display` enum('0','1') collate utf8_unicode_ci NOT NULL default '1' COMMENT 'Wotsch mi gseh?!?',
  PRIMARY KEY  (`menu_ID`),
  KEY `menu_topid` (`menu_topid`),
  KEY `menu_page` (`menu_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `admin_menu`
--

INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(1, 0, 1, 'Home', 1, 'pag', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(2, 0, 2, 'Inhalte editieren', 5, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(3, 0, 3, 'News editieren', 1, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(4, 0, 4, 'G&auml;stebuch editieren', 2, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(5, 0, 5, 'Gallery editieren', 3, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(6, 0, 6, 'Mitglieder editieren', 4, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(7, 3, 1, 'Neue News hinzuf&uuml;gen', 1, 'mod', '0', '', 'action=new', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(8, 0, 1, 'Kontakt', 0, 'mod', '1', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(9, 0, 1, 'Logout', 0, 'mod', '1', '', 'action=logout', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_modules`
--

CREATE TABLE `admin_modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `admin_modules`
--

INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES(1, 'news.class.php');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES(2, 'gbook.class.php');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES(3, 'gallery_edit.php');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES(4, 'members_edit.php');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES(5, 'content_edit.php');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_rights`
--

CREATE TABLE `admin_rights` (
  `rights_ID` int(11) NOT NULL auto_increment,
  `rights_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `rights_explain` tinytext collate utf8_unicode_ci NOT NULL,
  `rights_accesstype` enum('normal','file') collate utf8_unicode_ci NOT NULL,
  `rights_pagetype` enum('page','mod') collate utf8_unicode_ci NOT NULL,
  `rights_page_ref_ID` int(11) NOT NULL,
  PRIMARY KEY  (`rights_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `admin_rights`
--

INSERT INTO `admin_rights` (`rights_ID`, `rights_name`, `rights_explain`, `rights_accesstype`, `rights_pagetype`, `rights_page_ref_ID`) VALUES(1, 'access_allowed', 'Dieses Recht wird nun jenen gewährt, die sich ins AdminCP einloggen können.\r\nunknow_user darf das z.b. nicht', 'normal', 'page', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_rights_link`
--

CREATE TABLE `admin_rights_link` (
  `link_ID` int(11) NOT NULL auto_increment,
  `link_typ` enum('group','user') collate utf8_unicode_ci NOT NULL,
  `link_gu_ref_ID` int(11) NOT NULL,
  `link_right_ref_ID` int(11) NOT NULL,
  PRIMARY KEY  (`link_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `admin_rights_link`
--

INSERT INTO `admin_rights_link` (`link_ID`, `link_typ`, `link_gu_ref_ID`, `link_right_ref_ID`) VALUES(1, 'user', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_session`
--

CREATE TABLE `admin_session` (
  `ID` int(11) NOT NULL auto_increment,
  `session_id` varchar(50) collate utf8_unicode_ci NOT NULL,
  `ip_address` varchar(20) collate utf8_unicode_ci NOT NULL,
  `user_agent` tinytext collate utf8_unicode_ci NOT NULL,
  `user_ref_ID` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `last_activity` datetime NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=123 ;

--
-- Daten für Tabelle `admin_session`
--

INSERT INTO `admin_session` (`ID`, `session_id`, `ip_address`, `user_agent`, `user_ref_ID`, `login_time`, `last_activity`) VALUES(122, 'a93aca2f02941e14075061d30ab7d222', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.7', 2, '2007-09-23 22:27:43', '2007-09-23 23:46:37');
INSERT INTO `admin_session` (`ID`, `session_id`, `ip_address`, `user_agent`, `user_ref_ID`, `login_time`, `last_activity`) VALUES(113, 'c806f5706679b7b3d5a8734aba3c4edc', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6', 2, '2007-09-18 23:40:06', '2007-09-18 23:47:36');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_users`
--

CREATE TABLE `admin_users` (
  `user_ID` int(11) NOT NULL auto_increment,
  `user_name` varchar(50) collate utf8_bin NOT NULL,
  `user_pw` varchar(200) collate utf8_bin NOT NULL,
  `user_mail` varchar(100) collate utf8_bin NOT NULL,
  `user_group_ref_ID` int(11) NOT NULL,
  `user_comment` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`user_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `admin_users`
--

INSERT INTO `admin_users` (`user_ID`, `user_name`, `user_pw`, `user_mail`, `user_group_ref_ID`, `user_comment`) VALUES(2, 'Simon', 'fc5e038d38a57032085441e7fe7010b0', 'simon_@gmx.net', 0, 'der erst User');
INSERT INTO `admin_users` (`user_ID`, `user_name`, `user_pw`, `user_mail`, `user_group_ref_ID`, `user_comment`) VALUES(1, 'unknow_user', '', ' ', 1, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bbcodes`
--

CREATE TABLE `bbcodes` (
  `bbcodes_ID` int(11) NOT NULL auto_increment,
  `bbcodes_bbctag` varchar(50) character set utf8 NOT NULL COMMENT 'Den Code zum Zeigen für den Eintrag',
  `bbcodes_regex` varchar(150) collate latin1_general_ci NOT NULL,
  `bbcodes_htmltag` varchar(50) character set utf8 NOT NULL COMMENT 'Beispiel: <a href="%s">%s</href>',
  `bbcodes_rights` set('gb','news','content') collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`bbcodes_ID`),
  UNIQUE KEY `bbcodes_bbcstarttag` (`bbcodes_bbctag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `bbcodes`
--

INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(1, '[b][/b]', '/\\[b\\](.*?)\\[\\/b\\]/si', '<b>\\\\1</b>', 'gb,news,content');
INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(2, '[u][/u]', '/\\[u\\](.*?)\\[\\/u\\]/si', '<u>\\\\1</u>', 'gb,news,content');
INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(3, 'img', '', '<img src="\\\\1></img>', 'news,content');
INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(4, 'url', '', '<a href="\\\\1">%s</a>', 'news,content');
INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(5, '[i][/i]', '/\\[i\\](.*?)\\[\\/i\\]/si', '<i>\\\\1</i>', 'gb,news,content');
