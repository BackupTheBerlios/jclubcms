-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 20. Januar 2008 um 02:12
-- Server Version: 5.0.51
-- PHP-Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `jclubbeta`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_content`
--
-- Erzeugt am: 07. Januar 2008 um 20:18
-- Aktualisiert am: 14. Januar 2008 um 12:55
--

CREATE TABLE `admin_content` (
  `content_ID` int(11) NOT NULL auto_increment,
  `content_title` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  `content_text` text collate utf8_unicode_ci NOT NULL,
  `content_archiv` enum('no','yes') collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`content_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `admin_content`
--

INSERT INTO `admin_content` (`content_ID`, `content_title`, `content_text`, `content_archiv`) VALUES(1, 'Home', 'Hallo und herzlich Willkommen im Admin-Menu.<br />\r\nHier kannst du Inhalte &auml;ndern, Menus anpassen, G&auml;stebucheintr&auml;ge editieren/l&ouml;schen (mit Vorsicht zu geniessen) und News verfassen/l&ouml;schen.<br />\r\nEin Modul f&uuml;r die Gallery ist nicht vorhanden, ebenfalls kannst du (noch) nicht Bilder in ein Inhalt einf&uuml;gen. Falls du dies aber tun m&ouml;chtest oder die Gallery anpassen willst, melde dich bei Dave oder Simon (simon.daester[at]gmx.ch).<br />\r\nWeiter Hilfe findest du in der Rubrick hilfe.<br />\r\nFalls du mit der Arbeit in der Administrations fertig bist, LOGGE dich bitte AUS (Link oben rechts).<br />\r\nSch&ouml;nen Aufenthalt hier in der Adminsitration.', 'no');
INSERT INTO `admin_content` (`content_ID`, `content_title`, `content_text`, `content_archiv`) VALUES(2, '"Wer sucht, der wird finden"', 'Hallo, du Hilfesuchender.<br />\r\nBist du mit etwas nicht zufrieden oder blickst du irgendwo überhaupt nicht durch, dann folgende Anleitung befolgen:\r\n\r\n<li>1. Stossgebet zum Himmel, den dein himmlischer Vater kann alles richten.</li>\r\n<li>2. Ein paar Mal tief einatmen und ausatmen</li>\r\n<li>3. Nochmal das Problem überdenken und versuchen, auf eine Lösung zu kommen.</li>\r\n<li>4. Sollte das alles dich in deinem Problem nicht weitergebracht haben, mache noch mal das, was in Punkt 1 steht.</li>\r\n<li>Wenn nötig, nimm Kontakt mit mir auf: simon.daester@gmx.ch\r\n</li>\r\n<p>Hoffe, ich konnte helfen :-)</p>', 'no');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_groups`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
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
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 18. Januar 2008 um 02:33
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `admin_menu`
--

INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(1, 0, -10, 'Home', 1, 'pag', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(2, 0, 2, 'Inhalte editieren', 5, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(3, 0, 4, 'News editieren', 1, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(4, 0, 5, 'Gästebuch editieren', 2, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(5, 0, 6, 'Gallery editieren', 3, 'mod', '0', '', '', '0');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(6, 0, 7, 'Mitglieder editieren', 4, 'mod', '0', '', '', '0');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(7, 3, 1, 'Neue News hinzufügen', 1, 'mod', '0', '', 'action=new', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(8, 0, 8, 'Hilfe', 2, 'pag', '1', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(9, 0, 9, 'Logout', 0, 'mod', '1', '', 'action=logout', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(10, 4, 1, 'Neuer Gästebucheintrag erstellen', 2, 'mod', '0', '', 'action=new', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(11, 0, 0, 'Mailmodul anzeigen', 6, 'mod', '0', '', '', '0');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(12, 0, 0, 'Bildanzeige', 7, 'mod', '0', '', '', '0');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(13, 2, 0, 'Neuer Inhalt erstellen', 5, 'mod', '0', '', 'action=new', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(14, 0, 3, 'Menu editieren', 8, 'mod', '0', '', '', '1');
INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(15, 0, 9, 'Module editieren', 9, 'mod', '0', '', '', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_modules`
--
-- Erzeugt am: 07. Januar 2008 um 20:20
-- Aktualisiert am: 18. Januar 2008 um 02:33
--

CREATE TABLE `admin_modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `modules_file` varchar(45) character set utf8 collate utf8_bin NOT NULL,
  `modules_status` enum('on','off') collate utf8_unicode_ci NOT NULL,
  `modules_template_support` enum('yes','no') collate utf8_unicode_ci NOT NULL,
  `modules_mail_support` enum('no','yes') collate utf8_unicode_ci NOT NULL,
  `modules_mail_table` varchar(50) collate utf8_unicode_ci NOT NULL,
  `modules_mail_columns` tinytext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_file`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `admin_modules`
--

INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(1, 'newsadmin', 'newsadmin.class.php', 'on', 'yes', 'yes', 'news', 'news_ID,news_name,news_email');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(2, 'gbookadmin', 'gbookadmin.class.php', 'on', 'yes', 'yes', 'gbook', 'gbook_ID,gbook_name,gbook_email');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(3, 'galleryadmin', 'galleryadmin.class.php', 'on', 'yes', 'no', '', '');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(4, 'membersadmin', 'membersadmin.class.php', 'on', 'yes', 'yes', 'members', 'members_ID,members_name,members_email');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(5, 'contentadmin', 'contentadmin.class.php', 'on', 'yes', 'no', '', '');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(6, 'mailmodule', 'mailmodule.class.php', 'on', 'yes', 'no', '', '');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(7, 'image_send', 'image_send.class.php', 'on', 'no', 'no', '', '');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(8, 'menuadmin', 'menuadmin.class.php', 'on', 'yes', 'no', '', '');
INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(9, 'Admin-Modul', 'moduladmin.class.php', 'on', 'yes', 'no', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_rights`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
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
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
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
-- Erzeugt am: 05. Januar 2008 um 00:56
-- Aktualisiert am: 20. Januar 2008 um 01:52
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=268 ;

--
-- Daten für Tabelle `admin_session`
--

INSERT INTO `admin_session` (`ID`, `session_id`, `ip_address`, `user_agent`, `user_ref_ID`, `login_time`, `last_activity`) VALUES(267, 'da8c199e79f1b207bd126b7c5c7780d7', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11', 2, '2008-01-19 22:55:31', '2008-01-20 01:50:30');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_users`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 04. Januar 2008 um 22:17
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
INSERT INTO `admin_users` (`user_ID`, `user_name`, `user_pw`, `user_mail`, `user_group_ref_ID`, `user_comment`) VALUES(1, 'Unknow', '!_asdfsasdf_____', ' ', 1, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bbcodes`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
--

CREATE TABLE `bbcodes` (
  `bbcodes_ID` int(11) NOT NULL auto_increment,
  `bbcodes_bbctag` varchar(50) character set utf8 NOT NULL COMMENT 'Den Code zum Zeigen für den Eintrag',
  `bbcodes_regex` varchar(150) character set latin1 collate latin1_general_ci NOT NULL,
  `bbcodes_htmltag` varchar(50) character set utf8 NOT NULL COMMENT 'Beispiel: <a href="%s">%s</href>',
  `bbcodes_rights` set('gb','news','content') character set latin1 collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`bbcodes_ID`),
  UNIQUE KEY `bbcodes_bbcstarttag` (`bbcodes_bbctag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `bbcodes`
--

INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(1, '[b][/b]', '/\\[b\\](.*?)\\[\\/b\\]/si', '<b>\\\\1</b>', 'gb,news,content');
INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(2, '[u][/u]', '/\\[u\\](.*?)\\[\\/u\\]/si', '<u>\\\\1</u>', 'gb,news,content');
INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(3, 'img', '/img (.*?)/si', '<img src="\\\\1></img>', 'news,content');
INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(4, 'url', '', '<a href="\\\\1">%s</a>', 'news,content');
INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES(5, '[i][/i]', '/\\[i\\](.*?)\\[\\/i\\]/si', '<i>\\\\1</i>', 'gb,news,content');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bilder`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 03. Januar 2008 um 02:08
--

CREATE TABLE `bilder` (
  `bilder_ID` int(11) NOT NULL auto_increment,
  `filename` varchar(200) collate utf8_unicode_ci NOT NULL default '',
  `erstellt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bilder_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=130 ;

--
-- Daten für Tabelle `bilder`
--

INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(2, 'ende_phase_1_01.jpg', '2006-07-23 01:01:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(3, 'ende_phase_1_02.jpg', '2006-07-23 01:06:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(4, 'ende_phase_1_03.jpg', '2006-07-23 01:07:37');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(5, 'ende_phase_1_04.jpg', '2006-07-23 01:07:37');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(6, 'ende_phase_1_05.jpg', '2006-07-23 01:07:37');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(7, 'vor_umbau_01.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(8, 'vor_umbau_02.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(9, 'vor_umbau_03.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(10, 'vor_umbau_04.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(11, 'vor_umbau_05.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(12, 'vor_umbau_06.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(13, 'wand_1_01.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(14, 'wand_1_02.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(15, 'wand_1_03.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(16, 'wand_1_04.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(17, 'wand_1_05.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(18, 'wand_1_06.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(19, 'wand_1_07.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(20, 'wand_1_08.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(21, 'wand_2_01.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(22, 'wand_2_02.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(23, 'wand_2_03.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(24, 'wand_2_04.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(25, 'wand_2_05.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(26, 'wand_2_06.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(27, 'wand_2_07.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(72, 'wand_1_017.jpg', '2007-01-04 01:53:15');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(29, 'jg_programm06_04_lq.jpg', '2006-12-31 18:03:02');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(71, 'photo074.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(70, 'photo073.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(69, 'photo072.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(68, 'photo071.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(67, 'photo070.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(66, 'photo069.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(65, 'photo068.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(64, 'photo067.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(63, 'photo066.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(62, 'photo065.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(61, 'photo064.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(60, 'photo063.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(59, 'photo062.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(58, 'photo061.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(57, 'photo060.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(56, 'photo059.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(55, 'photo058.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(54, 'photo057.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(53, 'photo056.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(112, 'photo043.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(74, 'vor_umbau_001.jpg', '2007-01-05 20:45:51');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(75, 'vor_umbau_003.jpg', '2007-01-05 20:45:51');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(76, 'vor_umbau_005.jpg', '2007-01-05 20:46:01');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(111, 'photo042.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(110, 'photo041.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(109, 'photo040.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(108, 'photo039.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(107, 'photo038.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(106, 'photo037.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(105, 'photo036.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(104, 'photo035.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(103, 'photo034.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(102, 'photo033.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(101, 'photo032.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(113, 'photo044.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(114, 'photo045.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(115, 'photo046.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(116, 'photo047.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(125, 'vor_umbau_004.jpg', '2007-01-05 21:35:18');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(118, 'photo049.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(119, 'photo050.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(120, 'photo051.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(121, 'photo052.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(122, 'photo053.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(123, 'photo054.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(124, 'photo055.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(126, 'programm1_07.jpg', '2007-01-06 19:24:28');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(127, 'snowcamp-flyer.jpg', '2007-11-23 01:53:22');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(128, 'no_image.jpg', '2007-11-23 01:58:02');
INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES(129, 'burnout.jpg', '2008-01-03 02:07:05');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bildercategories`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
--

CREATE TABLE `bildercategories` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_bin NOT NULL,
  `explain` tinytext collate utf8_bin NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `bildercategories`
--

INSERT INTO `bildercategories` (`ID`, `name`, `explain`) VALUES(1, 'Shortcuts', 0x42696c6465722066c3bc72206469652053686f7274616374736d656e756573);
INSERT INTO `bildercategories` (`ID`, `name`, `explain`) VALUES(2, 'Seite', 0x5769726420696e2065696e657220536569746520676562726175636874);
INSERT INTO `bildercategories` (`ID`, `name`, `explain`) VALUES(3, 'Startseite', '');
INSERT INTO `bildercategories` (`ID`, `name`, `explain`) VALUES(4, 'Programm', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bildercategories_assign`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
--

CREATE TABLE `bildercategories_assign` (
  `ID` int(11) NOT NULL auto_increment,
  `ref_img` int(11) NOT NULL,
  `ref_cat` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Daten für Tabelle `bildercategories_assign`
--

INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(1, 3, 1);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(2, 4, 1);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(3, 5, 1);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(4, 1, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(5, 6, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(6, 7, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(7, 8, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(8, 9, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(9, 10, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(10, 11, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(11, 12, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(12, 13, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(13, 14, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(14, 15, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(15, 16, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(16, 17, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(17, 18, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(18, 2, 2);
INSERT INTO `bildercategories_assign` (`ID`, `ref_img`, `ref_cat`) VALUES(19, 1, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 06. Januar 2008 um 00:40
--

CREATE TABLE `content` (
  `content_ID` int(11) NOT NULL auto_increment,
  `content_title` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  `content_text` text collate utf8_unicode_ci NOT NULL,
  `content_author` varchar(50) collate utf8_unicode_ci NOT NULL,
  `content_time` datetime NOT NULL,
  `content_archiv` enum('no','yes') collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`content_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Daten für Tabelle `content`
--

INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(1, 'Willkommen', '<p>Wir begr&uuml;ssen euch herzlich auf der Seite des J-Club''s aus Balsthal-Thal.<br />     </p>        <a href="?nav_id=44"><img src="?image&amp;thumb=29&amp;" alt="" /></a> 	<br />         <br />               ', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(38, 'Programm ''Das fägtt?^''''', '<p>Hallo zum Programm &quot;DAs f&auml;gt''&quot; - &quot;<u>DER Alles sieht freude, &auml;rger, g&uuml;te, treue&quot;.</u></p><p>Hoffe, ihr habt noch viel Spass mit dem Programm und sonst vielFreude</p><p>&nbsp;</p>', '', '2008-01-06 00:28:26', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(2, 'Über uns', '<b>Wer seit ihr?</b><br />\r\nWir sind eine Gruppe junger Menschen aus verschiedenen Berufsschichten mit einem brennenden Herzen für Jesus.<br />\r\n<b>Und was macht ihr?</b><br />\r\nUnsere Absicht ist es, den Teenies das Evangelium auf moderne Art und Weise zu verkünden.<br />\r\n<b>Und was macht ihr an euren Abenden?</b><br />\r\nUm den Teenies zeitgemässe Worship-Musik bieten zu können, haben wir eine eigene JugendBand auf die Beine gestellt, welche schon an diversen Gemeindeveranstaltungen gespielt hat.\r\nDank der Gründung dieser Band haben wir die Möglichkeit die JG-Abende mit Worship zu starten<br />\r\n<b>Danke für das kurze Interview</b><br />\r\nBitte', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(3, 'Programm', '<div style="margin-left: 5px"><br />                   <a href="?image&amp;img=29&amp;" target="_blank"><img src="?image&amp;thumb=29&amp;" alt="JG-Programm" /></a><br />   Was uns noch fehlt bist..... <strong>DU</strong><br /></div>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(4, 'Gott kann reden!', 'Ich durften in den Jahren, seit ich Nachfolger von Jesus bin, schon viele Erlebnisse mit Gott erleben. Doch DAS Erlebnis, das mich am meisten geprägt hat, hat sich vor ca. 2 Jahren ereignet.<br />\r\n<br>\r\nWir hatten in unserer Gemeinde wieder mal eine Versammlung übers Vorjahr, wo über die Finanzen und die gesamte Gemeinde gesprochen wurde, ein Jahresrückblick könnte man sagen. Zu Beginn einer solchen Veranstaltung gab es jeweils in den Jahren zuvor einen kurzen Input, meist von einem Pastor oder Ältesten unserer Gemeinde.<br /><br />\r\n\r\nDoch drei Tage vor dieser Versammlung hörte ich während der Arbeit Gottes Stimme, die zu mir sprach, dass ich diesen Input vorbereiten solle. Doch ich konnte mir nicht vorstellen diese Aufgabe als Jugendleiter zu übernehmen. Ich dachte, das hätte ich mir vielleicht selbst ausgedacht. Doch die Stimme verfolgte mich, den ganzen Tag – so gab ich schliesslich nach. Ich ging von der Arbeit nach Hause und schrieb den Input ohne dass mich vorher jemand angefragt hätte. Am nächsten Tag, am Tag vor der Versammlung rief mich der Präsident der Gemeinde an und wollte mich schüchtern was fragen. Ich wusste genau, was er wollte und sprach zu ihm, dass ich den Input bereits vorbereitet hätte.<br /><br />\r\n\r\nEs war ein unglaubliches Gefühl Gottes Nähe so spüren zu können. Das durfte ich dann auch den Leuten in der Versammlung weitergeben. Dieses Erlebnis hat mich persönlich sehr berührt und ich habe gemerkt, dass Gott wirklich aktiv zu mir, zu dir reden kann.<br /><br />\r\n\r\n<b>Praise the Lord!</b><br />von Bebu', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(5, 'Unsere JG', '<p>Als Jugendgruppe \r\nsehen wir in der Bibel die Grundlage unseres Lebens. Das Wort Gottes \r\ngibt uns Anweisungen für unser Leben, die uns zeigen wie ein Leben \r\nin der Beziehung zu Gott aussehen kann. Damit wir aber durch die vielen \r\nAussagen der Bibel das Wesentliche nicht aus den Augen verlieren, haben \r\nwir unsere Vision und 5 Aufträge formuliert, die wir in die Tat umsetzen \r\nwollen. <br><br><br></p>\r\n\r\n<p><b>Unsere Vision</b> <br>\r\n</p>\r\n<p><b>„Als Jugendgruppe \r\nmöchten wir, dass die Jugendlichen unserer Region durch die Liebe Gottes \r\nverändert werden.“</b> <br></p>\r\n<p>Es ist unser \r\nAnliegen möglichst viele junge Leute in unserer Region mit dem Evangelium \r\nzu erreichen, auf eine möglichst einfache und verständliche Art. </p>\r\n<p>Jesus ist für \r\nuns am Kreuz gestorben. ER hat für unsere Sünden, die wir gemacht \r\nhaben und auch heute noch machen, bezahlt. Durch seine Liebe ist es \r\nfür uns Menschen überhaupt möglich geworden Veränderung in unserem \r\nLeben zu erfahren. So ist es unser Wunsch, dass diese Liebe, die wir \r\ntäglich erfahren dürfen auch noch andere Menschen erfahren können \r\nund dass diese Leute dann selber zu einem Samen für andere Menschen \r\nwerden können. <br> <br></p>\r\n<p><i>Unsere 5 \r\nAufträge, die uns helfen sollen unsere Vision Wirklichkeit werden zu \r\nlassen</i>: <br> <br></p>\r\n\r\n<p><b>Nachfolge</b> <br>\r\n</p>\r\n<p><b>„Als Jugendgruppe \r\nwollen wir immer mehr Jesus mässig Leben und so auch zum Licht für \r\nunsere Mitmenschen werden.“</b> <br></p>\r\n<p>Im Neuen Testament \r\nfinden wir in einigen Versen den Ausdruck „folge mir nach!“, den \r\nJesus spricht. Nach diesem Bild wollen wir Menschen sein, die seinem \r\nBeispiel folgen. Wir wollen immer bewusster Jesus mässig leben. Alle \r\nBereiche unseres Lebens sollen von IHM bestimmt werden. Als seine Jünger \r\nwollen wir Jesus nachfolgen. <br> <br></p>\r\n<p><b>Anbetung</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nGott anbeten und IHM die Ehre geben für das, was ER für uns getan \r\nhat.“</b> <br></p>\r\n\r\n<p>Wir wollen \r\nGott anbeten aus Dankbarkeit dafür, dass ER seinen Sohn für uns hingegeben \r\nhat. Von dieser Liebe, die ER uns gegeben hat wollen wir IHM etwas zurückgeben. \r\nAus diesem Grund wollen wir Gott mit unserem ganzen Leben anbeten. Wir \r\nwollen IHN loben und preisen für seine Schöpfung und seine Allmacht. <br>\r\n <br></p>\r\n<p><b>Gemeinschaft</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nuns gegenseitig in der Jugendgruppe annehmen und achten, so dass echte \r\nGemeinschaft mit Tiefgang entstehen darf.“</b> <br></p>\r\n<p>Was uns alle \r\nin der Jugendgruppe verbindet ist der Glaube an Jesus Christus. Jesus \r\nliebt jeden und jede genau gleich und so wie Jesus dies tut, versuchen \r\nauch wir einander anzunehmen und zu akzeptieren wie wir sind. </p>\r\n<p>Wir wollen \r\nmiteinander ein aktives Leben im Glauben führen, das Tiefgang hat und \r\nnicht nur oberflächlich wirkt. Auch ist der Glaube nach neutestamentlicher \r\nAuffassung keine Privatsache, wo jeder sein Christsein für sich lebt, \r\nsondern jeder Gläubige braucht den Austausch, die Gemeinschaft und \r\nden Umgang mit anderen Christen. <br> <br></p>\r\n\r\n<p><b>Evangelisation</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nGottes Frohe Botschaft auf eine moderne Art weitergeben, so dass auch \r\njüngere Menschen den Zugang zu Gott finden können.“</b> <br>\r\n</p>\r\n<p>Wir glauben \r\ndaran, dass nur ein Leben mit Jesus Sinn macht. Aus diesem Grund wollen \r\nwir, dass Menschen von der Liebe Gottes hören, sie aufnehmen und sich \r\nvon Gott verändern lassen. Weil es uns nicht egal ist, was mit unseren \r\nMitmenschen passiert, möchten wir ihnen als Werkzeug Gottes dienen. <br>\r\n <br></p>\r\n<p><b>Dienerschaft</b> <br>\r\n</p>\r\n\r\n<p><b>„Es ist \r\nunser Anliegen, dass Mitglieder der Jugendgruppe sich mit ihren Gaben \r\nund Talenten in der JG bzw. in der Gemeinde engagieren.“</b> <br>\r\n</p>\r\n<p>Gott hat uns \r\nALLE mit verschiedenen Gaben und Talenten ausgestattet. Mit diesen Eigenschaften, \r\nmit denen uns Gott ausgestattet hat, wollen wir Gott loben und anbeten. \r\nJeder Mensch ist einzigartig – und mit diesen Fähigkeiten wollen \r\nwir Gott anbeten. Wir wollen die JG zusammen gestalten, einander unterstützen \r\nund uns gegenseitig dienen.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(6, 'Unsere Visionen', '<p><b>„Als Jugendgruppe \r\nmöchten wir, dass die Jugendlichen unserer Region durch die Liebe Gottes \r\nverändert werden.“</b> <br></p>\r\n<p>Es ist unser \r\nAnliegen möglichst viele junge Leute in unserer Region mit dem Evangelium \r\nzu erreichen, auf eine möglichst einfache und verständliche Art. </p>\r\n<p>Jesus ist für \r\nuns am Kreuz gestorben. ER hat für unsere Sünden, die wir gemacht \r\nhaben und auch heute noch machen, bezahlt. Durch seine Liebe ist es \r\nfür uns Menschen überhaupt möglich geworden Veränderung in unserem \r\nLeben zu erfahren. So ist es unser Wunsch, dass diese Liebe, die wir \r\ntäglich erfahren dürfen auch noch andere Menschen erfahren können \r\nund dass diese Leute dann selber zu einem Samen für andere Menschen \r\nwerden können. <br> <br></p>\r\n<p><i>Unsere 5 \r\nAufträge, die uns helfen sollen unsere Vision Wirklichkeit werden zu \r\nlassen</i>: <br> <br></p>\r\n\r\n<p><b>Nachfolge</b> <br>\r\n</p>\r\n<p><b>„Als Jugendgruppe \r\nwollen wir immer mehr Jesus mässig Leben und so auch zum Licht für \r\nunsere Mitmenschen werden.“</b> <br></p>\r\n<p>Im Neuen Testament \r\nfinden wir in einigen Versen den Ausdruck „folge mir nach!“, den \r\nJesus spricht. Nach diesem Bild wollen wir Menschen sein, die seinem \r\nBeispiel folgen. Wir wollen immer bewusster Jesus mässig leben. Alle \r\nBereiche unseres Lebens sollen von IHM bestimmt werden. Als seine Jünger \r\nwollen wir Jesus nachfolgen. <br> <br></p>\r\n<p><b>Anbetung</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nGott anbeten und IHM die Ehre geben für das, was ER für uns getan \r\nhat.“</b> <br></p>\r\n\r\n<p>Wir wollen \r\nGott anbeten aus Dankbarkeit dafür, dass ER seinen Sohn für uns hingegeben \r\nhat. Von dieser Liebe, die ER uns gegeben hat wollen wir IHM etwas zurückgeben. \r\nAus diesem Grund wollen wir Gott mit unserem ganzen Leben anbeten. Wir \r\nwollen IHN loben und preisen für seine Schöpfung und seine Allmacht. <br>\r\n <br></p>\r\n<p><b>Gemeinschaft</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nuns gegenseitig in der Jugendgruppe annehmen und achten, so dass echte \r\nGemeinschaft mit Tiefgang entstehen darf.“</b> <br></p>\r\n<p>Was uns alle \r\nin der Jugendgruppe verbindet ist der Glaube an Jesus Christus. Jesus \r\nliebt jeden und jede genau gleich und so wie Jesus dies tut, versuchen \r\nauch wir einander anzunehmen und zu akzeptieren wie wir sind. </p>\r\n<p>Wir wollen \r\nmiteinander ein aktives Leben im Glauben führen, das Tiefgang hat und \r\nnicht nur oberflächlich wirkt. Auch ist der Glaube nach neutestamentlicher \r\nAuffassung keine Privatsache, wo jeder sein Christsein für sich lebt, \r\nsondern jeder Gläubige braucht den Austausch, die Gemeinschaft und \r\nden Umgang mit anderen Christen. <br> <br></p>\r\n\r\n<p><b>Evangelisation</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nGottes Frohe Botschaft auf eine moderne Art weitergeben, so dass auch \r\njüngere Menschen den Zugang zu Gott finden können.“</b> <br>\r\n</p>\r\n<p>Wir glauben \r\ndaran, dass nur ein Leben mit Jesus Sinn macht. Aus diesem Grund wollen \r\nwir, dass Menschen von der Liebe Gottes hören, sie aufnehmen und sich \r\nvon Gott verändern lassen. Weil es uns nicht egal ist, was mit unseren \r\nMitmenschen passiert, möchten wir ihnen als Werkzeug Gottes dienen. <br>\r\n <br></p>\r\n<p><b>Dienerschaft</b> <br>\r\n</p>\r\n\r\n<p><b>„Es ist \r\nunser Anliegen, dass Mitglieder der Jugendgruppe sich mit ihren Gaben \r\nund Talenten in der JG bzw. in der Gemeinde engagieren.“</b> <br>\r\n</p>\r\n<p>Gott hat uns \r\nALLE mit verschiedenen Gaben und Talenten ausgestattet. Mit diesen Eigenschaften, \r\nmit denen uns Gott ausgestattet hat, wollen wir Gott loben und anbeten. \r\nJeder Mensch ist einzigartig – und mit diesen Fähigkeiten wollen \r\nwir Gott anbeten. Wir wollen die JG zusammen gestalten, einander unterstützen \r\nund uns gegenseitig dienen.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(7, 'Nachfolge', '<p><b>„Als Jugendgruppe \r\nwollen wir immer mehr Jesus mässig Leben und so auch zum Licht für \r\nunsere Mitmenschen werden.“</b> <br></p>\r\n<p>Im Neuen Testament \r\nfinden wir in einigen Versen den Ausdruck „folge mir nach!“, den \r\nJesus spricht. Nach diesem Bild wollen wir Menschen sein, die seinem \r\nBeispiel folgen. Wir wollen immer bewusster Jesus mässig leben. Alle \r\nBereiche unseres Lebens sollen von IHM bestimmt werden. Als seine Jünger \r\nwollen wir Jesus nachfolgen. <br> <br></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(8, 'Anbetung', '<p><b>„Wir wollen \r\nGott anbeten und IHM die Ehre geben für das, was ER für uns getan \r\nhat.“</b> <br></p>\r\n\r\n<p>Wir wollen \r\nGott anbeten aus Dankbarkeit dafür, dass ER seinen Sohn für uns hingegeben \r\nhat. Von dieser Liebe, die ER uns gegeben hat wollen wir IHM etwas zurückgeben. \r\nAus diesem Grund wollen wir Gott mit unserem ganzen Leben anbeten. Wir \r\nwollen IHN loben und preisen für seine Schöpfung und seine Allmacht. <br>\r\n <br></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(9, 'Gemeinschaft', '<p><b>„Wir wollen \r\nuns gegenseitig in der Jugendgruppe annehmen und achten, so dass echte \r\nGemeinschaft mit Tiefgang entstehen darf.“</b> <br></p>\r\n<p>Was uns alle \r\nin der Jugendgruppe verbindet ist der Glaube an Jesus Christus. Jesus \r\nliebt jeden und jede genau gleich und so wie Jesus dies tut, versuchen \r\nauch wir einander anzunehmen und zu akzeptieren wie wir sind. </p>\r\n<p>Wir wollen \r\nmiteinander ein aktives Leben im Glauben führen, das Tiefgang hat und \r\nnicht nur oberflächlich wirkt. Auch ist der Glaube nach neutestamentlicher \r\nAuffassung keine Privatsache, wo jeder sein Christsein für sich lebt, \r\nsondern jeder Gläubige braucht den Austausch, die Gemeinschaft und \r\nden Umgang mit anderen Christen. <br> <br></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(10, 'Evangelisation', '<p><b>„Wir wollen \r\nGottes Frohe Botschaft auf eine moderne Art weitergeben, so dass auch \r\njüngere Menschen den Zugang zu Gott finden können.“</b> <br>\r\n</p>\r\n<p>Wir glauben \r\ndaran, dass nur ein Leben mit Jesus Sinn macht. Aus diesem Grund wollen \r\nwir, dass Menschen von der Liebe Gottes hören, sie aufnehmen und sich \r\nvon Gott verändern lassen. Weil es uns nicht egal ist, was mit unseren \r\nMitmenschen passiert, möchten wir ihnen als Werkzeug Gottes dienen. <br>\r\n <br></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(11, 'Dienerschaft', '<p><b>„Es ist \r\nunser Anliegen, dass Mitglieder der Jugendgruppe sich mit ihren Gaben \r\nund Talenten in der JG bzw. in der Gemeinde engagieren.“</b> <br>\r\n</p>\r\n<p>Gott hat uns \r\nALLE mit verschiedenen Gaben und Talenten ausgestattet. Mit diesen Eigenschaften, \r\nmit denen uns Gott ausgestattet hat, wollen wir Gott loben und anbeten. \r\nJeder Mensch ist einzigartig – und mit diesen Fähigkeiten wollen \r\nwir Gott anbeten. Wir wollen die JG zusammen gestalten, einander unterstützen \r\nund uns gegenseitig dienen.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(12, 'Programm Januar 07 – Juli 07', '<img src="?image&img=129" alt="Programm1 07">\r\n<p><b>12. Januar</b></p>\r\n\r\n<p><i>Allianz \r\nWoche</i></p>\r\n<p>Wie letztes \r\nJahr wollen wir auch dieses Jahr an der regionalen Allianz – Gebetswoche \r\nmitmachen, um uns gegenseitig zu ermutigen und zu stärken. <br>\r\n</p>\r\n<p><b>19. \r\n– 21. Januar</b></p>\r\n<p><i>Snowcamp \r\nin Raron (VS)</i></p>\r\n<p>Ein Wochenende \r\nzieht es uns in die schönen Berge ins Vallis. Nebst dem Schnee wollen \r\nwir auch die Gemeinschaft zusammen und mit Gott geniessen.</p>\r\n<p>(Anmeldung: \r\nsiehe Flyer separat!)</p>\r\n\r\n<p><b>26. Januar</b></p>\r\n<p><i>Worship \r\n– Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm. <br>\r\n</p>\r\n<p><b>2. Februar</b></p>\r\n<p><i>JG \r\n– Raum – Lifting</i></p>\r\n<p>Nachdem unser \r\nJG – Raum vorletztes Jahr grösstenteils renoviert worden ist, kommen \r\njetzt noch kleine Details, die dazu beitragen sollen, den JG – Raum \r\nnoch jugendfreundlicher zu gestalten. <br> <br>\r\n\r\n</p>\r\n<p><b>23. Februar</b></p>\r\n<p><i>Worship \r\n– Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm. <br>\r\n</p>\r\n<p><b>2. März</b></p>\r\n<p><i>Warum dieses \r\nLeid?</i></p>\r\n<p>In der Welt \r\ngibt es so viel Trauer, so viel Leid und so viel Schmerz, aber warum? \r\nWir wollen uns mit der Frage auseinandersetzen, warum Gott das überhaupt \r\nzulässt.</p>\r\n\r\n<p><b>9. März</b></p>\r\n<p><i>Das Gebet \r\nals mächtige Waffe</i></p>\r\n<p>Vielmals wird \r\ndie Kraft des Gebets unterschätzt. Aus diesem Grunde wird heutzutage \r\nvon vielen Menschen nicht mehr regelmässig gebetet. Wir fragen uns, \r\nwarum das so ist und was es mit der Kraft des Gebets auf sich hat. <br>\r\n</p>\r\n<p><b>16. März</b></p>\r\n<p><i>Warum christliche \r\nSchriften?</i></p>\r\n<p>10 wesentliche \r\nPunkte sollen uns als Anreiz dienen, christliche Schriften an andere \r\nMenschen weiterzugeben.</p>\r\n\r\n<p><b>23. März</b></p>\r\n<p><i>Servant \r\nEvangelism</i></p>\r\n<p>Was wir am \r\n16. März gelernt haben wollen wir in die Tat umsetzen: Wir gehen auf \r\ndie Strasse, um den Menschen vom Evangelium zu erzählen. <br>\r\n</p>\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>\r\n<p><b>30. März </b></p>\r\n<p><i>Worship \r\n– Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm. <br>\r\n</p>\r\n<p><b>6. April</b></p>\r\n<p><i>Wir nehmen \r\nein gemeinsames Abendmahl</i></p>\r\n<p>Passend zu \r\nOstern wollen wir ein Abendmahl zu uns nehmen wie das vor ca. 2000 Jahren \r\nder Brauch gewesen ist und uns an das erinnern, was Jesus am Kreuz für \r\nuns getan hat.</p>\r\n<p><b>27. April</b></p>\r\n<p><i>Worship \r\n– Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm. <br>\r\n</p>\r\n<p><b>4. Mai</b></p>\r\n<p><i>Musik in \r\nder Bibel</i></p>\r\n<p>Wir wollen \r\nuns damit befassen, welche Rolle die Musik in der bibel innehat und \r\nwelche Rolle ihr heute beigemessen wird. <br> <br>\r\n</p>\r\n<p><b>11. Mai</b></p>\r\n\r\n<p><i>Zum Christsein \r\nstehen</i></p>\r\n<p>Es fällt nicht \r\njedem und jeder leicht in allen Situationen zum Christsein zu stehen. \r\nWir wollen uns austauschen wo Schwierigkeiten und Probleme liegen und \r\nversuchen einen Ansatz zu einer möglichen Besserung zu finden. <br>\r\n</p>\r\n<p><b>18. Mai</b></p>\r\n<p><i>Was sind \r\nPfingstgemeinden?</i></p>\r\n<p>In der Schweiz \r\ngibt es nicht nur die Evangelisch – Reformierte und die Römisch – \r\nKatholische Kirche, sondern es gibt noch viele andere Kirchen, die sich \r\n„Freikirchen“ nennen. Wir wollen uns besonders mit den „Pfingstgemeinden“ \r\nauseinandersetzen.</p>\r\n\r\n<p><b>1. Juni</b></p>\r\n<p><i>Bibelauslegung \r\nheute</i></p>\r\n<p>Vielmals ist \r\ndas Bibellesen ein Frust, wenn man etwas nicht versteht. Aus diesem \r\nGrund suchen wir nach Hilfsmittel und möglichen Hilfeleistungen, die \r\nuns das Bibellesen zur Freude machen – so dass wir die Bibel besser \r\nverstehen können.</p>\r\n<p><b>8. Juni</b></p>\r\n<p><i>Welche \r\n„Art“ Christ bin ich?</i></p>\r\n<p>Christen glauben \r\nzwar dasselbe, haben aber trotzdem unterschiedliche Ansichten und Lebenseinstellungen. \r\nWir wollen herausfinden wer von uns in welche Richtung schlägt. <br>\r\n\r\n</p>\r\n<p><b>15. Juni</b></p>\r\n<p><i>Das Internet \r\nsinnvoll nutzen</i></p>\r\n<p>Viele Jugendliche \r\nverbringen oft Stunden im Internet. Doch vielmals auf Seiten, die sie \r\nnegativ beeinflussen. Wir wollen uns mit den Angeboten an christlichen \r\nWebsites vertraut machen.</p>\r\n<p><b>22. Juni</b></p>\r\n<p><i>Die Rolle \r\nder Frau in der Bibel</i></p>\r\n<p>Viele Frauen \r\nhaben in der bibel eine wichtige rolle gespielt. Doch auch heute noch \r\ngibt es brisante Themen (Kopftuch: ja oder nein / Frauen dürfen predigen?). \r\nWir wollen uns mit diesen Fragen auseinandersetzen und dabei die Bibel \r\nals Vorlage nehmen.</p>\r\n\r\n<p><b>29. Juni</b></p>\r\n<p><i>Worship \r\n– Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm. <br>\r\n</p>\r\n<p><b>6. Juli</b></p>\r\n<p><i>Kino</i> <br>\r\n</p>\r\n<p>Als krönender \r\nAbschluss vor den Schulferien besuchen wir als ganze Jugendgruppe wieder \r\neinmal das Kino</p>\r\n\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(13, '12. Januar', '<p><i>Allianz \r\nWoche</i></p>\r\n<p>Wie letztes \r\nJahr wollen wir auch dieses Jahr an der regionalen Allianz – Gebetswoche \r\nmitmachen, um uns gegenseitig zu ermutigen und zu stärken. <br>\r\n <br></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(14, '19.  – 21. Januar', '<p><i>Snowcamp \r\nin Raron (VS)</i></p>\r\n<p>Ein Wochenende \r\nzieht es uns in die schönen Berge ins Vallis. Nebst dem Schnee wollen \r\nwir auch die Gemeinschaft zusammen und mit Gott geniessen.</p>\r\n<p>(Anmeldung: \r\nsiehe Flyer separat!) <br> <br></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(15, '26. Januar', '<p><i>Worship \r\n– Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm. <br>\r\n <br></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(16, '2. Februar', '<p><i>JG \r\n– Raum – Lifting</i></p>\r\n<p>Nachdem unser \r\nJG – Raum vorletztes Jahr grösstenteils renoviert worden ist, kommen \r\njetzt noch kleine Details, die dazu beitragen sollen, den JG – Raum \r\nnoch jugendfreundlicher zu gestalten.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(17, '23. Februar', '<p><i>Worship \r\n– Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(18, '2. März', '<p><i>Warum dieses \r\nLeid?</i></p>\r\n<p>In der Welt \r\ngibt es so viel Trauer, so viel Leid und so viel Schmerz, aber warum? \r\nWir wollen uns mit der Frage auseinandersetzen, warum Gott das überhaupt \r\nzulässt.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(19, '9. März', '<p><i>Das Gebet \r\nals mächtige Waffe</i></p>\r\n<p>Vielmals wird \r\ndie Kraft des Gebets unterschätzt. Aus diesem Grunde wird heutzutage \r\nvon vielen Menschen nicht mehr regelmässig gebetet. Wir fragen uns, \r\nwarum das so ist und was es mit der Kraft des Gebets auf sich hat.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(20, '16. März', '<p><i>Warum christliche \r\nSchriften?</i></p>\r\n<p>10 wesentliche \r\nPunkte sollen uns als Anreiz dienen, christliche Schriften an andere \r\nMenschen weiterzugeben.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(21, '23. März', '<p><i>Servant \r\nEvangelism</i></p>\r\n<p>Was wir am \r\n16. März gelernt haben wollen wir in die Tat umsetzen: Wir gehen auf \r\ndie Strasse, um den Menschen vom Evangelium zu erzählen. <br>\r\n</p>\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(22, '30. März', '<p><i>Worship \r\n– Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(23, '6. April', '<p><i>Wir nehmen \r\nein gemeinsames Abendmahl</i></p>\r\n<p>Passend zu \r\nOstern wollen wir ein Abendmahl zu uns nehmen wie das vor ca. 2000 Jahren \r\nder Brauch gewesen ist und uns an das erinnern, was Jesus am Kreuz für \r\nuns getan hat.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(24, '27. April', '<p><i>Worship \r\n– Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(25, '4. Mai', '<p><i>Musik in \r\nder Bibel</i></p>\r\n<p>Wir wollen \r\nuns damit befassen, welche Rolle die Musik in der bibel innehat und \r\nwelche Rolle ihr heute beigemessen wird.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(26, '11. Mai', '<p><i>Zum Christsein \r\nstehen</i></p>\r\n<p>Es fällt nicht \r\njedem und jeder leicht in allen Situationen zum Christsein zu stehen. \r\nWir wollen uns austauschen wo Schwierigkeiten und Probleme liegen und \r\nversuchen einen Ansatz zu einer möglichen Besserung zu finden.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(27, '18. Mai', '<p><i>Was sind \r\nPfingstgemeinden?</i></p>\r\n<p>In der Schweiz \r\ngibt es nicht nur die Evangelisch – Reformierte und die Römisch – \r\nKatholische Kirche, sondern es gibt noch viele andere Kirchen, die sich \r\n„Freikirchen“ nennen. Wir wollen uns besonders mit den „Pfingstgemeinden“ \r\nauseinandersetzen.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(28, '1. Juni', '<p><i>Bibelauslegung \r\nheute</i></p>\r\n<p>Vielmals ist \r\ndas Bibellesen ein Frust, wenn man etwas nicht versteht. Aus diesem \r\nGrund suchen wir nach Hilfsmittel und möglichen Hilfeleistungen, die \r\nuns das Bibellesen zur Freude machen – so dass wir die Bibel besser \r\nverstehen können.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(29, '8. Juni', '<p><i>Welche \r\n„Art“ Christ bin ich?</i></p>\r\n<p>Christen glauben \r\nzwar dasselbe, haben aber trotzdem unterschiedliche Ansichten und Lebenseinstellungen. \r\nWir wollen herausfinden wer von uns in welche Richtung schlägt.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(30, '15. Juni', '<p><i>Das Internet \r\nsinnvoll nutzen</i></p>\r\n<p>Viele Jugendliche \r\nverbringen oft Stunden im Internet. Doch vielmals auf Seiten, die sie \r\nnegativ beeinflussen. Wir wollen uns mit den Angeboten an christlichen \r\nWebsites vertraut machen.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(31, '22. Juni', '<p><i>Die Rolle \r\nder Frau in der Bibel</i></p>\r\n<p>Viele Frauen \r\nhaben in der bibel eine wichtige rolle gespielt. Doch auch heute noch \r\ngibt es brisante Themen (Kopftuch: ja oder nein / Frauen dürfen predigen?). \r\nWir wollen uns mit diesen Fragen auseinandersetzen und dabei die Bibel \r\nals Vorlage nehmen.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(32, '29. Juni', '<p><i>Worship \r\n– Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm. <br>\r\n</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(33, '6. Juli', '<p><i>Kino</i> <br>\r\n</p>\r\n<p>Als krönender \r\nAbschluss vor den Schulferien besuchen wir als ganze Jugendgruppe wieder \r\neinmal das Kino</p>\r\n\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(34, 'Snowcamp vom 19.-21. Jan 07', '<a href="http://www.jclub.ch/index.php?nav_id=41&bild=127"><img src="http://www.jclub.ch/index.php?nav_id=41&thumb=127"></a>\r\n<h3>Hey Leute!</h3><p>\r\nIn 2 Wochen findet unser Snowcamp statt. Dann heisst’s: Ab ins Vallis! Zusammen gehen wir auf die Suche nach dem weissen Gut. Doch nicht nur skifahren, snöben oder schlitteln ist angesagt. Wir wollen die Zeit auch nutzen, um die Gemeinschaft untereinander zu pflegen wie auch die Beziehung zu Gott.</p><p><b>\r\nAlle, die sich bis jetzt noch nicht offiziell angemeldet haben, sollten dies so schnell wie möglich tun!<b></p> \r\n<img src="http://www.jclub.ch/index.php?nav_id=41&bild=127">', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(35, 'Geschichte unserer Jugendgruppe', '<p>Wir schreiben das Jahr 2007. Genau vor 10 Jahren wurde die Jugendgruppe in Balsthal gegründet. Ohne wirklich eine Ahnung zu haben, was denn genau eine Jugendgruppe so macht, wurde ich (Bebu, Leiter der JG) vom damaligen Kirchgemeindepräsidenten (Markus Schenk) angefragt, eine solche Gruppe zu gründen. Ich liess mich überreden und so kam es im Jahr 1997 zur Gründung dieser JG.</p><p>\r\nDoch damit ich als Ahnungsloser nicht alleine im Schilf stehen musste, wurde ich von diversen Menschen unterstützt, die mir besonders zu Beginn der Gründung der Gruppe eine hilfreiche Stütze waren. Insbesondere Anna Däster, Christian Ledermann und Patrick Allemann waren es, die mir geholfen haben eine solche Jugendgruppe auf die Beine zu stellen. Doch der Anfang war alles andere als einfach, da wir uns erstmals einen Kontaktkreis aufbauen mussten. Doch nach langer Anlaufszeit war dies geschafft. Wir konnten so richtig beginnen durchzustarten…</p><p>\r\nEs vergingen 3 – 4 Jahre, da gaben mir Anna und Christian, später auch Patrick bekannt, dass sie es aus verschiedenen Gründen nicht mehr sehen würden als Leiter in der Jugendgruppe zu fungieren. So erlebte die JG eine neue Epoche, in der ich die Jugendgruppe alleine zu leiten versuchte. Inzwischen im Glauben reifer geworden traute ich mir diese Aufgabe zu. Zudem fand ich immer wieder Leute, die mich unterstützen. Als ich die RS zu absolvieren hatte war Daniel Joss alias Omega in der Jungschi bereit, für mich die Leitung zu übernehmen. Ich war und bin auch heute noch dankbar, dass sich immer wieder Menschen für die Jugendgruppe investiert haben, wenn es für mich nicht möglich war da zu sein.</p><p>\r\nEin paar Jahre vergingen und in der Zwischenzeit entstand in mir das Gefühl, dass die Gruppe nicht von einer, sondern von mehreren Personen geführt werden sollte. Da die treusten Mitglieder im Laufe der Jahre auch älter geworden sind, schien mir das durchaus möglich. So kam es dann im Jahr 2006 zur Gründung des Leitungsteams, das aus Mitgliedern der JG besteht. Es ist für mich einerseits eine Entlastung, andererseits aber sicherlich auch eine Bereicherung für die jüngeren Leitungsmitglieder zu profitieren, Erfahrungen zu sammeln als Leiter und selbst aktiv zu werden.</p><p>\r\nIch danke Gott, dass er mir und der Jugendgruppe in all den Jahren treu zur Seite gestanden ist, dass Er uns durch schwierige Zeiten durchgetragen hat, uns immer wieder Menschen geschenkt hat, die sich für die JG hingegeben haben. Mit Gottes Hilfe wollen wir als Jugendgruppe die nächsten Jahre in Angriff nehmen und noch für viele Menschen zum Segen werden.</p>', '', '2007-12-31 12:00:00', 'no');
INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES(39, 'Sorry, vergässe''', 'Programm, das so richtig `f&auml;gt''''''\\'' g&auml;llen''sie', '', '2008-01-06 00:40:09', 'no');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery_alben`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
--

CREATE TABLE `gallery_alben` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `ref_ID` int(11) NOT NULL default '0',
  `comment` tinytext collate utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `gallery_alben`
--

INSERT INTO `gallery_alben` (`ID`, `name`, `ref_ID`, `comment`, `time`) VALUES(1, 'Vor dem Umbau', 1, '', '2007-01-02 12:00:00');
INSERT INTO `gallery_alben` (`ID`, `name`, `ref_ID`, `comment`, `time`) VALUES(2, 'Herausnehmen der 1. Trennwand', 1, '', '2007-01-02 12:00:00');
INSERT INTO `gallery_alben` (`ID`, `name`, `ref_ID`, `comment`, `time`) VALUES(3, 'Herausnehmen der 2. Trennwand', 1, '', '2007-01-02 12:00:00');
INSERT INTO `gallery_alben` (`ID`, `name`, `ref_ID`, `comment`, `time`) VALUES(4, 'Ende der 1. Phase', 1, '', '2007-01-02 12:00:00');
INSERT INTO `gallery_alben` (`ID`, `name`, `ref_ID`, `comment`, `time`) VALUES(5, 'Fertigstellung', 1, 'Nun gehts richtig zur Sache', '2007-01-02 12:00:00');
INSERT INTO `gallery_alben` (`ID`, `name`, `ref_ID`, `comment`, `time`) VALUES(6, 'Neujahrsfeier 05/06', 0, 'Gut gegessen, viele Filme geschaut und wenig geschlafen', '2007-01-02 12:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery_categories`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
--

CREATE TABLE `gallery_categories` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_bin NOT NULL,
  `ref_ID` int(11) NOT NULL,
  `comment` tinytext collate utf8_bin NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `gallery_categories`
--

INSERT INTO `gallery_categories` (`ID`, `name`, `ref_ID`, `comment`, `time`) VALUES(1, 'Umbau', 0, 0x556d62617520646573204a472d5261756d6573, '2007-12-22 17:37:56');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery_eintraege`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
--

CREATE TABLE `gallery_eintraege` (
  `ID` int(11) NOT NULL auto_increment,
  `fid_bild` int(11) NOT NULL default '0',
  `fid_album` int(11) NOT NULL default '0',
  `sequence` int(11) NOT NULL default '0',
  `comment` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=105 ;

--
-- Daten für Tabelle `gallery_eintraege`
--

INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(1, 7, 1, 1, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(29, 53, 6, 1, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(57, 19, 2, 1, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(75, 2, 4, 1, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(80, 101, 5, 1, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(30, 54, 6, 2, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(58, 20, 2, 2, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(68, 21, 3, 2, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(63, 74, 1, 2, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(76, 3, 4, 2, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(81, 102, 5, 2, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(3, 9, 1, 3, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(31, 55, 6, 3, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(56, 18, 2, 3, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(69, 22, 3, 3, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(77, 4, 4, 3, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(82, 103, 5, 3, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(32, 56, 6, 4, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(66, 72, 2, 4, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(64, 75, 1, 4, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(70, 23, 3, 4, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(78, 5, 4, 4, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(83, 104, 5, 4, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(33, 57, 6, 5, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(55, 17, 2, 5, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(71, 24, 3, 5, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(79, 6, 4, 5, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(84, 105, 5, 5, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(104, 125, 1, 5, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(34, 58, 6, 6, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(53, 15, 2, 6, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(65, 76, 1, 6, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(72, 25, 3, 6, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(85, 106, 5, 6, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(4, 10, 1, 7, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(35, 59, 6, 7, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(54, 16, 2, 7, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(73, 26, 3, 7, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(86, 107, 5, 7, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(2, 8, 1, 8, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(36, 60, 6, 8, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(52, 14, 2, 8, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(74, 27, 3, 8, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(87, 108, 5, 8, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(5, 11, 1, 9, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(37, 61, 6, 9, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(51, 13, 2, 9, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(88, 109, 5, 9, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(6, 12, 1, 10, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(38, 62, 6, 10, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(89, 110, 5, 10, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(39, 63, 6, 11, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(90, 111, 5, 11, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(40, 64, 6, 12, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(91, 112, 5, 12, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(41, 65, 6, 13, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(92, 113, 5, 13, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(42, 66, 6, 14, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(93, 114, 5, 14, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(43, 67, 6, 15, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(94, 115, 5, 15, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(44, 68, 6, 16, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(95, 116, 5, 16, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(45, 69, 6, 17, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(46, 70, 6, 18, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(97, 118, 5, 18, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(47, 71, 6, 19, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(98, 119, 5, 19, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(99, 120, 5, 20, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(100, 121, 5, 21, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(101, 122, 5, 22, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(102, 123, 5, 23, '');
INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES(103, 124, 5, 24, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gbook`
--
-- Erzeugt am: 02. Januar 2008 um 01:00
-- Aktualisiert am: 06. Januar 2008 um 15:49
--

CREATE TABLE `gbook` (
  `gbook_ID` int(11) NOT NULL auto_increment,
  `gbook_ref_ID` int(11) NOT NULL default '0',
  `gbook_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `gbook_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `gbook_email` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `gbook_hp` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `gbook_content` text collate utf8_unicode_ci NOT NULL,
  `gbook_title` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `gbook_smile_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gbook_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=58 ;

--
-- Daten für Tabelle `gbook`
--

INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(56, 0, '2008-01-06 00:07:57', 'Simon', 'hello@world.com', 'www.besj.ch', 'Kleiner Test', 'Testeintrag', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(46, 0, '2007-02-08 10:25:27', 'Admin', 'simon_@gmx.net', '', 'Das beweise ich mit folgendem Post. Genau', 'Tests werden nie langweilig', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(45, 42, '2007-02-01 21:07:45', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Auso ha grad dr Befäu vom Bebu übercho euch morn ä Fium abzlah...\r\n\r\ni-ei Kömodie hets gheissä!\r\n\r\ndämfau bis morn...', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(44, 42, '2007-02-01 19:04:20', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'weekends? fröiä mi scho uf das wucheänd?\r\n\r\nhani irgendöppis verpasst?\r\n\r\n\r\nlouft i-öppis vor JG us dä Fritig? i ha drum kei ahnig.. ', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(43, 41, '2007-02-01 19:01:27', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Ja isch guet Marco mir schribä witerhin Kommentär :-)', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(42, 0, '2007-01-31 20:15:12', 'Rebi', 'dietrich.rebekka@hotmail.com', '', 'hey!\r\nja us öisem ski-weekend isch Leidr nix wordä...\r\nabr isch gLich haMmr xi! fröiä mi scho uf das wucheänd, wird sichr widr cooL!\r\nschönä obä no und e gsägneti zyt', 'weekends', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(41, 0, '2007-01-25 16:30:05', 'Marco', 'marco.flueck @ggs.ch', '', 'Findi toll, dass dir so vili Kommentär schribend, drum hani jetz mol wieder en Nachricht gschribe =)\r\n=) =) (i hoffe, mi verstoht, was i möcht sägä; e Tipp: das isch Doppelironie)', 'Nachricht', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(40, 28, '2007-01-22 18:47:25', 'Ändu', 'andreasallemann@gmx.ch', '', 'Jo i glaube, das mitem töggelichaschte het sich erledigt... dört wo mer gse si, hets jo scho eine gha:-)\r\n\r\nI muess auso säge: ES isch sooo meeegaa guet gsi, es hät glaub fasch nid besser chönne si süsch nöime...', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(39, 28, '2007-01-19 14:15:13', 'Räphu', 'waeili@gmx.ch', 'www.scb.ch', 'Du hesch nid richtig gläsä, Jöggu. Ig wot DI ufs Dach bingä, äbä nid dr Töggälichaschtä!', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(38, 28, '2007-01-18 17:54:28', 'öhm... Jöggu?', 'ha_se_vergässe@kei_ahnig.ch', 'www.keine_ahnung.ch', 'Hmm. Das mit em ufs Dach binde isch gar kei so schlächti Idee. Aber chlei ufwändig. Und de müese mir no einisch meh Bätte, dass dr Töggelichaschte die Fahrt überstoht... \r\nBesseri Idee:\r\nMe chönt doch e Lan-Party mache^^ :D', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(37, 28, '2007-01-17 21:14:01', 'Räphu', 'waeili@gmx.ch', 'www.scb.ch', '"me chönt doch dr Döggelichschte mittnäh" Genialä Vorschlag! :-D Mir müesse di eifach ufs Dach bingä, de bringä mer nä vilech inä. Wüu fürä Töggelichaschtä wärs z schad. Isch das guet?^^', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(36, 28, '2007-01-17 21:05:04', 'Jöggu', 'dschalk@gmail.com', 'www.realnet.ch', 'Is hauebad wär scho nid schlächt. Aber dr Ganz Tag lot sich so au nid lo fülle...\r\nund Wandere... naja. Ha scho bessers ghört.\r\nAber e Vorschlag han ig glich no:\r\nme chönt doch dr Döggelichschte mittnäh :D\r\n', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(35, 28, '2007-01-17 18:51:26', 'Räphu', 'waeili@gmx.ch', 'www.scb.ch', 'Ja okay, Däschter, scho chli konkreter! ;) Aber unger "Badi" verschta ig persönlech haut äs Freibad - was aber eventuell a mim Dialäkt chönt ligä!? Und Visp... weiss gar nid ob die überhoupt schpilä, ig ga uf jedä Fau a SCB-Mätsch am Samschti^^', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(34, 28, '2007-01-17 15:12:33', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'hesch rächt Dästi... XBox 360 nämläch..', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(33, 28, '2007-01-17 14:21:46', 'DD', 'dfd1985@gmail.com', 'www.jclub.ch', 'Ja, Badi... z.B. Hallebad. Ha ja nid gseit "Freibad".\r\nUsflug... z.B. bi Visp go luege?\r\nWandere... ja, ok, es Argumänt, aber immerhin e vorschlag.\r\nTja, u süsch e Graasschlacht (da es ja so viel Schnee het), süsch irgend öbis (nei, Lüdi, nid XBox)...', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(32, 28, '2007-01-17 13:29:48', 'Räphu', 'waeili@gmx.ch', 'www.scb.ch', '"Badi" Im Winter?\r\n"Usflug" Ähmmm... du meinsch chli ir Gägend umänang fahrä? \r\n"Wandere" Wo ja sooo beliebt isch bi 13-18 jährigä Lüt... \r\n"u.a." Ja?', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(31, 28, '2007-01-16 22:56:41', 'Der Kommentarschreiber (Lüdi)', 'Lukas,Schlaepfer@gmx.ch', '', 'die Organsation he..tztzt... zwichtigschtä isch mau wieder vergässä gangä...', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(30, 28, '2007-01-16 22:56:31', 'BB', 'barbara_born@hotmail.com', '', 'Wellness weekend :)\r\n(nid auzu ärnst näh chume nid mit isch darum nume e idee gsi)\r\n(und DD was du chasch cha i ou ;)', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(29, 28, '2007-01-16 22:51:39', 'DD', 'admin@jclub.ch', '', 'Tja, cheut ja e Schatzsuechi mache... wär het zuerscht Schnee gfunde ;)\r\nNei Seich, do gäbs z.B.: Badi, Usflug, Wandere, u.a.', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(28, 0, '2007-01-16 22:43:11', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hallo zusammen!!!!\r\n\r\nWie ihr vielleicht gesehen habt ist der Schnee nicht mehr geworden. Wir müssen also schon mal für ein Alternativprogramm schauen! Wenn ihr eine Idee habt, meldet euch doch baldmöglichst, denn mit dem Skifahren wird es sehr wahrscheinlich nichts werden... leider!\r\n\r\nGruss und eine schöne Woche\r\n\r\n\r\nBebu', '!!! Ski - Weekend !!!', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(18, 16, '2007-01-09 18:43:27', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Hesch vom Bebu öppis angers erwartet??? he? he?\r\n\r\nsägs numä!', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(16, 0, '2007-01-07 14:58:27', 'Marco', 'marco.flueck@ggs.ch', 'www.jesus.ch', 'Hey das Programm gseht cooooooool und vieeeeeeeeeelversprächend us!!!! :):):)\r\n', 'Wunderbars Programm', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(15, 0, '2007-01-07 14:53:13', 'Marco', 'marco.flueck@ggs.ch', 'www.jesus.ch', 'Lüdi dini Komentär si witzig und närvig zuglich! (als VW verstoh -verwirrender Witz) ;-O', 'Lüdi!!!', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(14, 13, '2007-01-04 19:59:29', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Isch ja schliesslech dr schönscht Dialäkt!!', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(13, 0, '2007-01-04 19:52:28', 'Barbara (die besseri Heufti (Schwöster) vom BORN)', 'barbara_born@hotmail.com', 'www.artchicks.ch.vu', 'Hallo zäme\r\nHa uf die Site gfunge und dänkt i schribe doch grad mou öbbis ine! Und das uf BÄRNdütsch! Schöni Homepage und hebit nech Sorg!\r\nLiebs Grüessli\r\nBarbara', 'Schöni HP', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(12, 8, '2007-01-04 19:31:34', 'Administrator(en)', 'dfd1985@gmail.com', 'www.nowayback.ch.vu', 'Nei, no nid. Aber wird no cho.\r\nJe nach däm wie stark i mues schaffe halt scho früecher oder halt chli später.\r\nD''Smily-Codes wärde aber witgehend die gliche blibe, evnt. gits de o es paar neui ;)', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(11, 10, '2007-01-04 16:43:12', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Es si mehreri Personoä gsi...', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(10, 0, '2007-01-04 16:30:16', 'Surli', 'Surli87@gmx.ch', '', 'Wow he, mega genial heit dir die Homepage gmacht!!\r\nEs riise Lob a die Person wos gmacht het!!\r\nNachträglech wünschi euch aune es ganzes guets neus Jahr, Gottes riiche Säge und e ganze gueti Zyt!!\r\nBye bye Soraya', 'Achtung Surli chunnt ;-)', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(9, 0, '2007-01-04 15:48:32', 'Rebi', 'dietrich.rebekka@hotmail.com', '', 'hey!\r\nmir gfout die page ou mega guet!\r\ns wartä het sech ächt gLohnt!\r\ni hoffä dir siget aui guet is nöiä johr gschtartet und bis gLiiii\r\n', 'aLoha!', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(8, 0, '2007-01-04 15:09:26', 'Ändu', 'andreasallemann@gmx.ch', '', 'I gse vouer stouz die neuei site. Das luegt auso scho angersch us aus die auti site.\r\n\r\nFrage: Cha me do keini sooo coooooli Smilies me mache wie im aute Gästebuech?', 'Bravo!!!', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(7, 5, '2007-01-03 18:55:01', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Da das e chrischtlächi Sitä isch machis jetz nid, aber du weisch welä Finger das jetzt däheim hätsch gseh gäu ;-)', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(6, 5, '2007-01-03 13:31:15', 'Hans Holunder alias Bebu', 'fieserfettsack_@hotmail.com', '', 'Das geit di absolut agr nüt a!!!\r\n\r\nDas blibt mis Gheimnis...', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(5, 0, '2007-01-03 13:27:04', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Hei Jungs\r\n\r\nGseht würkläch guät us. \r\n\r\nNo ä Frag ä nöggi: Wieso schribsch du Hochdeutsch?\r\n\r\nAuso no e schönä..\r\n\r\nSalüüü', 'Persönlicher Eintrag Nummer 1', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(4, 3, '2007-01-03 12:00:09', 'Administrator', 'admin@jclub.ch', 'www.jclub.ch', 'Merci für d''Blueme...\r\nMir si ou chli stolz druf ;)', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(3, 0, '2007-01-03 11:17:37', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hallo Leute\r\n\r\nGut habt ihr das hingekriegt. Sieht toll aus. Danke schon mal im Voraus für eure geleistete Arbeit!\r\nGruss \r\n\r\nvom Scheff persönlich', 'Ja, hallo erstmaaaaal....', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(2, 0, '2007-01-03 00:06:17', 'Reine Chefasche (Bebu)', 'fieserfettsack_@hotmail.com', '', 'Auso nachdäm dasi da die letschte Iiträg  so gläse ha, hani dänkt, da müess mau wieder öppis "ganz Schlaus" ine, drum hani dänkt, da müess i mi drum kümmere... :-Q\r\nNei seich, i wünsche euch ganz e guete Rutsch is nöie Jahr, tüet geng schön artig, fouget öichem usgsproche nätte JG-Leiter immer ganz guet, und de git das es ganz es guets 07. :-D\r\n\r\nFür au di wo regumässig id JG chöme, ir erschte Wuche nach de Ferie (12. Jan) geseh mer üs wieder, für aui angere.... chömet denn ou! Auso dämfau ! Rütschet guet und de bis im 07!\r\n*dance* *dance* *dance* *dance* *dance*', 'Kopie vom alte Gästebuech...', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(1, 0, '2007-01-02 23:36:44', 'David Däster', 'dfd1985@gmail.com', 'www.jclub.ch', 'Hallo Leute.\r\nGut Weile will dauer haben. Und nun ist es endlich da.\r\nDie neue Seite ist online. Fehler sind möglich, bitte meldet sie per Email an mich oder Simon.', '1. Eintrag', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(48, 46, '2008-01-02 03:19:00', 'Simon', 'simon.daester@gmx.ch', 'www.deinehp.dt', '''Hallo'', sagt der "Milchmann"', '', 0);
INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES(49, 0, '2008-01-02 14:56:04', 'Bubi', 'bubi@herzensbrecher.de', 'www.deinehp.dt', 'Hallo erstmalrnKann man, rnmuss man aber nicht', 'spieglein, spieglein', 0);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `look4tags`
--
CREATE TABLE `look4tags` (
`filename` varchar(200)
,`name` varchar(50)
);
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mailto`
--
-- Erzeugt am: 02. Januar 2008 um 15:55
-- Aktualisiert am: 02. Januar 2008 um 23:01
-- Letzter Check am: 02. Januar 2008 um 15:55
--

CREATE TABLE `mailto` (
  `mailto_ID` int(11) NOT NULL auto_increment,
  `mailto_reciver_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `mailto_reciver_email` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `mailto_sender_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `mailto_sender_email` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `mailto_subject` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `mailto_content` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `mailto_hash` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `mailto_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`mailto_ID`),
  FULLTEXT KEY `mailto_content` (`mailto_content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `mailto`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `members`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
--

CREATE TABLE `members` (
  `members_ID` int(11) NOT NULL auto_increment COMMENT 'De weisi wär du bisch',
  `members_name` varchar(50) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Längwilig, für Bürokrate',
  `members_spitzname` varchar(50) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Toll, zum Fertigmache',
  `members_birthday` date NOT NULL default '0000-00-00' COMMENT 'Alter schützt vor Torheit nicht',
  `members_song` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Ke Musiggschmack?',
  `members_hobby` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Längwilig',
  `members_food` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Grusig',
  `members_job` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Verdiensch so weni Cholä?',
  `members_motto` varchar(200) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Haut di mou dra!',
  `members_email` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'so läng?',
  `members_FIDimage` varchar(200) collate utf8_unicode_ci NOT NULL default '' COMMENT 'hesch ou scho besser usgseh',
  PRIMARY KEY  (`members_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Die Mitgliedertabelle' AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `members`
--

INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES(1, 'Benjamin Schläpfer', 'Bebu', '1982-03-06', 'Forever you', 'JG, Musizieren, Sport', 'Lassagne', 'Student an der STH Basel', 'What Would Jesus Do??', 'fieserfettsack_@hotmail.com', '128');
INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES(3, 'David Däster', 'Dave', '1985-04-22', 'Watching Over You', 'JG, PC, Sport, Musik', 'Broccoli', 'Informatiker', 'Pray Until Something Happens!', 'dfd1@gmx.net', '128');
INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES(4, 'Lukas Schläpfer', 'Lüdi', '1987-09-19', 'Lord I lift your name on high', 'Gamen, JG, PC, Sport', 'Lassagne', 'kaufmännischer Angestellter (in Ausbildung)', '-', '', '128');
INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES(6, 'Simon Däster', 'Simon', '1989-01-25', 'The days of Elijah', 'JESUS, JG, PC, Sport, Musik', '', 'Worker (bis zum Militär :-) )', 'Beginne jeden Tag mit einem Gebet', '', '128');
INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES(7, 'Daniel Schenk', 'Dani', '1989-09-26', '-', 'Klettern, Jungschar', '-', 'Polymechaniker (in Ausbildung)', '-', '', '128');
INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES(8, 'Marco Flück', 'Marco', '1989-12-14', '-', 'Jungschar, Ping-Pong, JG, Skifahren', '-', 'Schüler', '-', '', '128');
INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES(10, 'Anna Gasser', 'Anna', '1991-03-21', 'Chönig vo mim Härz', 'lesen, in der Natur sein, Musik hören', 'Lasagne', '', '-', '', '128');
INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES(11, 'Samuel Bader', 'Sämi', '1991-10-09', 'sick and tired', 'Fussball, Hockey, PC, JG', 'Schnipo', 'Schüler', '-', '', '128');
INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES(12, 'Raphael Däster', '&alpha; (Alpha)', '1991-12-24', 'Awesome God', 'Sport, JG, Jungschi', 'Lasagne', 'Schüler', '', '', '128');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menu`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 20. Januar 2008 um 01:52
--

CREATE TABLE `menu` (
  `menu_ID` int(11) NOT NULL auto_increment COMMENT 'Jetzt weisi wär du bisch',
  `menu_topid` int(11) NOT NULL default '0' COMMENT 'Stohsch wieder über de andere',
  `menu_position` int(11) NOT NULL default '0' COMMENT '"Die Ersten werden die LETZTEN sein" ',
  `menu_name` text character set utf8 collate utf8_unicode_ci NOT NULL COMMENT 'Sgit besseri Näme',
  `menu_page` int(11) NOT NULL default '0' COMMENT 'Gang mou dört go sueche!',
  `menu_pagetyp` enum('mod','pag') character set utf8 collate utf8_unicode_ci NOT NULL default 'mod' COMMENT 'Machts e Unterschie?!?',
  `menu_shortlink` enum('0','1') character set utf8 collate utf8_unicode_ci NOT NULL default '0',
  `menu_image` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL,
  `menu_modvar` varchar(45) character set utf8 collate utf8_unicode_ci NOT NULL default '' COMMENT 'Wotsch no öppis mitgäh?!?',
  `menu_display` enum('0','1') character set utf8 collate utf8_unicode_ci NOT NULL default '1' COMMENT 'Wotsch mi gseh?!?',
  PRIMARY KEY  (`menu_ID`),
  KEY `menu_topid` (`menu_topid`),
  KEY `menu_page` (`menu_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=88 ;

--
-- Daten für Tabelle `menu`
--

INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(76, 44, 2, 'Snowcamp vom 19.-21. Jan 07', 34, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(77, 26, 0, 'Geschichte unserer JG', 35, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(78, 0, 7, 'Captcha_bild', 7, 'mod', '0', '', '', '0');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(1, 0, -7, 'Home', 5, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(45, 42, 0, 'Gott kann reden', 4, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(48, 47, 0, 'Nachfolge', 7, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(53, 26, 1, 'Interview', 2, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(54, 44, 0, 'JG-Programm - Übersicht', 12, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(55, 54, -7, '12. Januar', 13, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(47, 26, 2, 'Unsere Visionen', 6, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(49, 47, 1, 'Anbetung', 8, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(56, 54, -6, '19. – 21. Januar', 3, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(26, 0, -2, 'Über uns', 35, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(43, 0, -3, 'News', 6, 'mod', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(50, 47, 2, 'Gemeinschaft', 9, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(57, 54, -5, '26. Januar', 15, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(42, 0, 0, 'Mitglieder', 5, 'mod', '0', '', '', '0');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(51, 47, 3, 'Evangelisation', 10, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(58, 54, -4, '2. Februar', 16, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(44, 0, 1, 'Programm', 12, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(52, 47, 4, 'Dienerschaft', 11, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(59, 54, -3, '23. Februar', 17, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(60, 54, -2, '2. März', 18, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(33, 0, 3, 'Gästebuch', 1, 'mod', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(61, 54, -2, '9. März', 19, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(40, 0, 4, 'Gallery', 3, 'mod', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(62, 54, -1, '16. März', 20, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(63, 54, 0, '21. März', 21, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(64, 54, 1, '30. März', 22, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(65, 54, 2, '6. April', 23, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(66, 54, 3, '27. April', 24, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(67, 54, 4, '4. Mai', 25, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(68, 54, 5, '11. Mai', 26, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(69, 54, 6, '18. Mai', 27, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(70, 54, 7, '1. Juni', 28, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(71, 54, 8, '8. Juni', 29, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(72, 54, 9, '15. Juni', 30, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(73, 54, 10, '22. Juni', 31, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(74, 54, 11, '29. Juni', 32, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(75, 54, 12, '6. Juli', 33, 'pag', '0', '', '', '1');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(41, 0, 7, 'image', 4, 'mod', '0', '', '', '0');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(79, 0, 7, 'Mail versenden', 9, 'mod', '0', '', '', '0');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(83, 44, 5, 'Das fägt', 38, 'pag', '0', '', '', '0');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(84, 44, 6, 'das fägt 2', 38, 'pag', '0', '', '', '0');
INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES(85, 40, 1, 'Test für Gallery', 0, 'pag', '0', '', '', '0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `modules`
--
-- Erzeugt am: 06. Januar 2008 um 17:43
-- Aktualisiert am: 20. Januar 2008 um 01:23
--

CREATE TABLE `modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `modules_file` varchar(45) collate utf8_unicode_ci NOT NULL,
  `modules_status` enum('on','off') collate utf8_unicode_ci NOT NULL,
  `modules_template_support` enum('yes','no') collate utf8_unicode_ci NOT NULL,
  `modules_mail_support` enum('no','yes') collate utf8_unicode_ci NOT NULL,
  `modules_mail_table` varchar(50) collate utf8_unicode_ci NOT NULL,
  `modules_mail_columns` tinytext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_file`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `modules`
--

INSERT INTO `modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(1, 'gbook', 'gbook.class.php', 'on', 'yes', 'yes', 'gbook', 'gbook_ID,gbook_name,gbook_email');
INSERT INTO `modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(3, 'gallery', 'gallery.class.php', 'on', 'yes', 'no', '', '');
INSERT INTO `modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(4, 'image_send', 'image_send.class.php', 'on', 'no', 'no', '', '');
INSERT INTO `modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(5, 'members', 'members.class.php', 'off', 'yes', 'yes', 'members', 'members_ID,members_name,members_email');
INSERT INTO `modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(6, 'news', 'news.class.php', 'on', 'yes', 'yes', 'news', 'news_ID,news_name,news_email');
INSERT INTO `modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(7, 'captcha_image', 'captcha_image.class.php', 'on', 'no', 'no', '', '');
INSERT INTO `modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES(9, 'mailmodule', 'mailmodule.class.php', 'on', 'yes', 'no', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 02. Januar 2008 um 23:03
--

CREATE TABLE `news` (
  `news_ID` int(11) NOT NULL auto_increment,
  `news_ref_ID` int(11) NOT NULL default '0',
  `news_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `news_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `news_email` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `news_hp` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `news_content` text collate utf8_unicode_ci NOT NULL,
  `news_title` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `news_smile_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`news_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Daten für Tabelle `news`
--

INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(1, 0, '2007-01-02 22:53:52', 'Administrator', 'mail@jclub.ch', 'http://www.jclub.ch', 'So, die neue Seite ist online.\r\nHabt Nachsicht falls noch irgendwelche Fehler auftreten und meldet es uns.', '1. Newseintrag', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(2, 0, '2007-09-17 17:04:40', 'Co-Admin', 'mail@jclub.ch', 'http://www.besj.ch', 'Die Administrationsoberfläche wird überarbeitet, der Code von der Homepage wird angepasst, damit es in Zukunft schneller und wartungsarmer läuft.', 'Anpassungen', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(4, 0, '2007-09-17 23:12:47', 'CO-Admin', 'mail@jclub.ch', 'http://www.besj.ch', 'Momentan wird hart an der Klasse messageboxes.class.php gearbeitet', 'Im Wandel', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(17, 8, '2007-11-23 03:48:41', 'Co-Progger', 'simon@gmx.net', 'www.besj.ch', 'Und es geht immer weiter *pc**respect*', '', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(8, 0, '2007-10-16 17:30:43', 'Co-Progger', 'simon_@gmx.net', 'www.besj.ch', 'Tja, wir programmieren weiter, d.h. eher ich, da der Chef viel Schule hat :-D Macht nichts, bin ja immer noch ich da. Jedenfalls wird gerade die news.class.php kräftig erweitert und kommt bald zum Ende. Noch viel Spass beim lesen (und mir beim Proggen)', 'Neues in der Entwicklung', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(9, 0, '2007-10-20 16:53:50', 'Co-Progger', 'simon@gmx.net', 'www.besj.ch', 'Wie es so kommt, wird halt nicht gerade viel geproggt, da ich noch arbeite und mir sonst die Zeit nicht so nehme zum *pc*. *thanks* aber fürs Verständniss', 'Und noch weiter...', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(10, 0, '2007-10-20 17:00:22', 'Co-Progger', 'simon@gmx.net', 'www.besj.ch', 'Wie es so kommt, wird halt nicht gerade viel geproggt, da ich noch arbeite und mir sonst die Zeit nicht so nehme zum *pc*. *thanks* aber fürs Verständnis. Wenn du ein bisschen *confused* bist, dann :-Q doch eine oder *dance*\r\nMuss sagen, *respect**fire*:-O:-D', 'Und noch weiter...', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(13, 10, '2007-10-27 01:22:09', 'Co-Progger', 'simon_@gmx.net', '', 'Ja, es geht immer weiter*pc*', '', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(18, 9, '2007-11-23 03:49:02', 'test', 'test@mail.de', '', 'Bitte, bitte', '', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(19, 0, '2008-01-02 01:50:53', 'Simon', 'simon.daester@gmx.ch', '', 'Es geht vorwärts, und trotzdem kommen wir nicht vom Fleck. Schön, schön', 'Status', 0);
INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES(20, 0, '2008-01-02 01:50:53', 'Simon', 'simon.daester@gmx.ch', 'www.deinehp.dt', 'Es geht vorwärts, und trotzdem kommen wir nicht vom Fleck', 'Status Quo', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `smilies`
--
-- Erzeugt am: 01. Januar 2008 um 17:09
-- Aktualisiert am: 01. Januar 2008 um 17:09
--

CREATE TABLE `smilies` (
  `smilies_ID` int(11) NOT NULL auto_increment,
  `smilies_sign` varchar(20) collate utf8_unicode_ci NOT NULL,
  `smilies_file` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`smilies_ID`),
  UNIQUE KEY `smilies_sign` (`smilies_sign`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Daten für Tabelle `smilies`
--

INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(2, ':-)', 'smile.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(3, ':-D', 'bigsmile.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(4, '*angel*', 'angel.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(5, '*confused*', 'confused.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(6, '*dance*', 'dance.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(7, '*disco*', 'disco.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(8, '*eager*', 'eager.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(9, '*fire*', 'fire.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(10, '*hops*', 'hops.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(11, '*hopses*', 'hopses.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(12, '*ironie*', 'ironieattention.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(13, ':-O', 'mouthopen.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(14, '*pc*', 'pc.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(15, '*respect*', 'respect.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(16, '*roll*', 'roll.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(17, '*thanks*', 'thanks.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(18, '*thumbsup*', 'thumbsup.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(19, '*thumb*', 'thumbup.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(20, ':-p', 'tongue.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(21, ':-Q', 'smoke.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(22, ':)', 'smile.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(23, ':D', 'bigsmile.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(24, ':p', 'tongue.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(25, ':Q', 'smoke.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(26, ':O', 'mouthopen.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(27, ';-)', 'wink.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(28, ';)', 'wink.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(29, ':-(', 'sad.gif');
INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES(30, ':(', 'sad.gif');

-- --------------------------------------------------------

--
-- Struktur des Views `look4tags`
--
DROP TABLE IF EXISTS `look4tags`;

CREATE ALGORITHM=UNDEFINED DEFINER=`jclubbeta`@`localhost` SQL SECURITY DEFINER VIEW `jclubbeta`.`look4tags` AS select `jclubbeta`.`bilder`.`filename` AS `filename`,`jclubbeta`.`bildercategories`.`name` AS `name` from ((`jclubbeta`.`bildercategories` join `jclubbeta`.`bilder`) join `jclubbeta`.`bildercategories_assign`) where ((`jclubbeta`.`bilder`.`bilder_ID` = `jclubbeta`.`bildercategories_assign`.`ref_img`) and (`jclubbeta`.`bildercategories`.`ID` = `jclubbeta`.`bildercategories_assign`.`ref_cat`));
