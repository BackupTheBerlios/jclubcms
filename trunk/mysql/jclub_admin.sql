-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 17. August 2007 um 16:00
-- Server Version: 5.0.45
-- PHP-Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Datenbank: `jclubbeta`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `admin_groups`
-- 

DROP TABLE IF EXISTS `admin_groups`;
CREATE TABLE IF NOT EXISTS `admin_groups` (
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

DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE IF NOT EXISTS `admin_menu` (
  `menu_ID` int(11) NOT NULL auto_increment COMMENT 'Jetzt weisi wär du bisch',
  `menu_topid` int(11) NOT NULL default '0' COMMENT 'Stohsch wieder über de andere',
  `menu_position` int(11) NOT NULL default '0' COMMENT '"Die Ersten werden die LETZTEN sein" ',
  `menu_name` text collate utf8_unicode_ci NOT NULL COMMENT 'Sgit besseri Näme',
  `menu_page` int(11) NOT NULL default '0' COMMENT 'Gang mou dört go sueche!',
  `menu_pagetyp` enum('mod','pag') collate utf8_unicode_ci NOT NULL default 'mod' COMMENT 'Machts e Unterschie?!?',
  `menu_modvar` varchar(45) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Wotsch no öppis mitgäh?!?',
  `menu_display` enum('0','1') collate utf8_unicode_ci NOT NULL default '1' COMMENT 'Wotsch mi gseh?!?',
  PRIMARY KEY  (`menu_ID`),
  KEY `menu_topid` (`menu_topid`),
  KEY `menu_page` (`menu_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- 
-- Daten für Tabelle `admin_menu`
-- 

INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_modvar`, `menu_display`) VALUES (1, 0, 1, 'Inhalte editieren', 5, 'mod', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_modvar`, `menu_display`) VALUES (2, 0, 2, 'News editieren', 1, 'mod', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_modvar`, `menu_display`) VALUES (3, 0, 3, 'G&auml;stebuch editieren', 2, 'mod', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_modvar`, `menu_display`) VALUES (4, 0, 4, 'Gallery editieren', 3, 'mod', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_modvar`, `menu_display`) VALUES (5, 0, 5, 'Mitglieder editieren', 4, 'mod', '', '1');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `admin_modules`
-- 

DROP TABLE IF EXISTS `admin_modules`;
CREATE TABLE IF NOT EXISTS `admin_modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- 
-- Daten für Tabelle `admin_modules`
-- 

INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES (1, 'news_edit.php');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES (2, 'gbook_edit.php');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES (3, 'gallery_edit.php');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES (4, 'members_edit.php');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`) VALUES (5, 'content_edit.php');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `admin_rights`
-- 

DROP TABLE IF EXISTS `admin_rights`;
CREATE TABLE IF NOT EXISTS `admin_rights` (
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

INSERT INTO `admin_rights` (`rights_ID`, `rights_name`, `rights_explain`, `rights_accesstype`, `rights_pagetype`, `rights_page_ref_ID`) VALUES (1, 'access_allowed', 'Dieses Recht wird nun jenen gewährt, die sich ins AdminCP einloggen können.\r\nunknow_user darf das z.b. nicht', 'normal', 'page', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `admin_session`
-- 

DROP TABLE IF EXISTS `admin_session`;
CREATE TABLE IF NOT EXISTS `admin_session` (
  `ID` int(11) NOT NULL auto_increment,
  `session_id` varchar(50) collate utf8_unicode_ci NOT NULL,
  `ip_address` varchar(20) collate utf8_unicode_ci NOT NULL,
  `user_agent` tinytext collate utf8_unicode_ci NOT NULL,
  `user_ref_ID` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `last_activity` datetime NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

-- 
-- Daten für Tabelle `admin_session`
-- 

INSERT INTO `admin_session` (`ID`, `session_id`, `ip_address`, `user_agent`, `user_ref_ID`, `login_time`, `last_activity`) VALUES (29, '24c1bff591ca4b4f5e8a7779e31f8a6b', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6', 1, '2007-08-17 00:24:44', '2007-08-17 00:24:44');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `admin_users`
-- 

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE IF NOT EXISTS `admin_users` (
  `user_ID` int(11) NOT NULL auto_increment,
  `user_name` varchar(50) collate utf8_bin NOT NULL,
  `user_pw` varchar(200) collate utf8_bin NOT NULL,
  `user_mail` varchar(100) collate utf8_bin NOT NULL,
  `user_comment` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`user_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `admin_users`
-- 

INSERT INTO `admin_users` (`user_ID`, `user_name`, `user_pw`, `user_mail`, `user_comment`) VALUES (1, 0x53696d6f6e, 0x6663356530333864333861353730333230383534343165376665373031306230, 0x73696d6f6e5f40676d782e6e6574, 0x64657220657273742055736572);
INSERT INTO `admin_users` (`user_ID`, `user_name`, `user_pw`, `user_mail`, `user_comment`) VALUES (0, 0x756e6b6e6f775f75736572, '', '', '');
