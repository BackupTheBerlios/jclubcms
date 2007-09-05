-- phpMyAdmin SQL Dump
-- version 2.11.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. September 2007 um 22:40
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

INSERT INTO `admin_content` VALUES(1, 'Home', 'Hallo und herzlich Willkommen im Admin-Menu');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `admin_menu`
--

INSERT INTO `admin_menu` VALUES(1, 0, 1, 'Home', 1, 'pag', '0', '', '', '1');
INSERT INTO `admin_menu` VALUES(2, 0, 2, 'Inhalte editieren', 5, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` VALUES(3, 0, 3, 'News editieren', 1, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` VALUES(4, 0, 4, 'G&auml;stebuch editieren', 2, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` VALUES(5, 0, 5, 'Gallery editieren', 3, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` VALUES(6, 0, 6, 'Mitglieder editieren', 4, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` VALUES(7, 3, 1, 'Neue News hinzuf&uuml;gen', 1, 'mod', '0', '', 'mode=add', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_modules`
--

CREATE TABLE `admin_modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `admin_modules`
--

INSERT INTO `admin_modules` VALUES(1, 'news_edit.class.php');
INSERT INTO `admin_modules` VALUES(2, 'gbook_edit.php');
INSERT INTO `admin_modules` VALUES(3, 'gallery_edit.php');
INSERT INTO `admin_modules` VALUES(4, 'members_edit.php');
INSERT INTO `admin_modules` VALUES(5, 'content_edit.php');

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

INSERT INTO `admin_rights` VALUES(1, 'access_allowed', 'Dieses Recht wird nun jenen gewährt, die sich ins AdminCP einloggen können.\r\nunknow_user darf das z.b. nicht', 'normal', 'page', 0);

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

INSERT INTO `admin_rights_link` VALUES(1, 'user', 0, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=53 ;

--
-- Daten für Tabelle `admin_session`
--

INSERT INTO `admin_session` VALUES(52, '5de4b045bde715cd0c5dc3fbad71289c', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6', 2, '2007-09-05 22:38:42', '2007-09-05 22:39:39');

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

INSERT INTO `admin_users` VALUES(2, 'Simon', 'fc5e038d38a57032085441e7fe7010b0', 'simon_@gmx.net', 0, 'der erst User');
INSERT INTO `admin_users` VALUES(1, 'unknow_user', '', ' ', 1, '');
