-- phpMyAdmin SQL Dump
-- version 2.11.9.1
-- http://www.phpmyadmin.net
--
-- Host: server16.db.internal
-- Erstellungszeit: 06. April 2009 um 17:57
-- Server Version: 4.1.25
-- PHP-Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `jclubch_jclubcms`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_content`
--

CREATE TABLE IF NOT EXISTS `admin_content` (
  `content_ID` int(11) NOT NULL auto_increment,
  `content_title` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  `content_text` text collate utf8_unicode_ci NOT NULL,
  `content_archiv` enum('no','yes') collate utf8_unicode_ci NOT NULL default 'no',
  PRIMARY KEY  (`content_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `admin_content`
--

INSERT INTO `admin_content` (`content_ID`, `content_title`, `content_text`, `content_archiv`) VALUES
(1, 'Home', 'Hallo und herzlich Willkommen im Admin-Menu.<br />\r\nHier kannst du Inhalte &auml;ndern, Menus anpassen, G&auml;stebucheintr&auml;ge editieren/l&ouml;schen (mit Vorsicht zu geniessen) und News verfassen/l&ouml;schen.<br />\r\nEin Modul f&uuml;r die Gallery ist nicht vorhanden, ebenfalls kannst du (noch) nicht Bilder in ein Inhalt einf&uuml;gen. Falls du dies aber tun m&ouml;chtest oder die Gallery anpassen willst, melde dich bei Dave oder Simon (simon.daester[at]gmx.ch).<br />\r\nWeiter Hilfe findest du in der Rubrick hilfe.<br />\r\nFalls du mit der Arbeit in der Administrations fertig bist, LOGGE dich bitte AUS (Link oben rechts).<br />\r\nSch&ouml;nen Aufenthalt hier in der Adminsitration.', 'no'),
(2, '"Wer sucht, der wird finden"', 'Hallo, du Hilfesuchender.<br />\r\nBist du mit etwas nicht zufrieden oder blickst du irgendwo überhaupt nicht durch, dann folgende Anleitung befolgen:\r\n\r\n<li>1. Stossgebet zum Himmel, den dein himmlischer Vater kann alles richten.</li>\r\n<li>2. Ein paar Mal tief einatmen und ausatmen</li>\r\n<li>3. Nochmal das Problem überdenken und versuchen, auf eine Lösung zu kommen.</li>\r\n<li>4. Sollte das alles dich in deinem Problem nicht weitergebracht haben, mache noch mal das, was in Punkt 1 steht.</li>\r\n<li>Wenn nötig, nimm Kontakt mit mir auf: simon.daester@gmx.ch\r\n</li>\r\n<p>Hoffe, ich konnte helfen :-)</p>', 'no');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_groups`
--

CREATE TABLE IF NOT EXISTS `admin_groups` (
  `groups_ID` int(11) NOT NULL auto_increment,
  `groups_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `groups_chief_ref_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`groups_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `admin_groups`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_menu`
--

CREATE TABLE IF NOT EXISTS `admin_menu` (
  `menu_ID` int(11) NOT NULL auto_increment COMMENT 'Jetzt weisi wär du bisch',
  `menu_topid` int(11) NOT NULL default '0' COMMENT 'Stohsch wieder über de andere',
  `menu_position` int(11) NOT NULL default '0' COMMENT '"Die Ersten werden die LETZTEN sein" ',
  `menu_name` text collate utf8_unicode_ci NOT NULL COMMENT 'Sgit besseri Näme',
  `menu_page` int(11) NOT NULL default '0' COMMENT 'Gang mou dört go sueche!',
  `menu_pagetyp` enum('mod','pag') collate utf8_unicode_ci NOT NULL default 'mod' COMMENT 'Machts e Unterschie?!?',
  `menu_shortlink` enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  `menu_image` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `menu_modvar` varchar(45) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Wotsch no öppis mitgäh?!?',
  `menu_display` enum('0','1') collate utf8_unicode_ci NOT NULL default '1' COMMENT 'Wotsch mi gseh?!?',
  PRIMARY KEY  (`menu_ID`),
  KEY `menu_topid` (`menu_topid`),
  KEY `menu_page` (`menu_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `admin_menu`
--

INSERT INTO `admin_menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES
(1, 0, -10, 'Home', 1, 'pag', '0', '', '', '1'),
(2, 0, 2, 'Inhalte editieren', 5, 'mod', '0', '', '', '1'),
(3, 0, 4, 'News editieren', 1, 'mod', '0', '', '', '1'),
(4, 0, 5, 'Gästebuch editieren', 2, 'mod', '0', '', '', '1'),
(5, 0, 6, 'Gallery editieren', 3, 'mod', '0', '', '', '0'),
(6, 0, 7, 'Mitglieder editieren', 4, 'mod', '0', '', '', '0'),
(7, 3, 1, 'Neue News hinzufügen', 1, 'mod', '0', '', 'action=new', '1'),
(8, 0, 8, 'Hilfe', 2, 'pag', '1', '', '', '1'),
(9, 0, 9, 'Logout', 0, 'mod', '1', '', 'action=logout', '1'),
(10, 4, 1, 'Neuer Gästebucheintrag erstellen', 2, 'mod', '0', '', 'action=new', '1'),
(11, 0, 0, 'Mailmodul anzeigen', 6, 'mod', '0', '', '', '0'),
(12, 0, 0, 'Bildanzeige', 7, 'mod', '0', '', '', '0'),
(13, 2, 0, 'Neuer Inhalt erstellen', 5, 'mod', '0', '', 'action=new', '1'),
(14, 0, 3, 'Menu editieren', 8, 'mod', '0', '', '', '1'),
(15, 0, 9, 'Module editieren', 9, 'mod', '0', '', '', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_modules`
--

CREATE TABLE IF NOT EXISTS `admin_modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(50) character set utf8 collate utf8_bin NOT NULL default '',
  `modules_file` varchar(45) character set utf8 collate utf8_bin NOT NULL default '',
  `modules_status` enum('on','off') collate utf8_unicode_ci NOT NULL default 'on',
  `modules_template_support` enum('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
  `modules_mail_support` enum('no','yes') collate utf8_unicode_ci NOT NULL default 'no',
  `modules_mail_table` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `modules_mail_columns` tinytext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_file`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `admin_modules`
--

INSERT INTO `admin_modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES
(1, 'newsadmin', 'newsadmin.class.php', 'on', 'yes', 'yes', 'news', 'news_ID,news_name,news_email'),
(2, 'gbookadmin', 'gbookadmin.class.php', 'on', 'yes', 'yes', 'gbook', 'gbook_ID,gbook_name,gbook_email'),
(3, 'galleryadmin', 'galleryadmin.class.php', 'on', 'yes', 'no', '', ''),
(4, 'membersadmin', 'membersadmin.class.php', 'on', 'yes', 'yes', 'members', 'members_ID,members_name,members_email'),
(5, 'contentadmin', 'contentadmin.class.php', 'on', 'yes', 'no', '', ''),
(6, 'mailmodule', 'mailmodule.class.php', 'on', 'yes', 'no', '', ''),
(7, 'image_send', 'image_send.class.php', 'on', 'no', 'no', '', ''),
(8, 'menuadmin', 'menuadmin.class.php', 'on', 'yes', 'no', '', ''),
(9, 'Admin-Modul', 'moduladmin.class.php', 'on', 'yes', 'no', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_rights`
--

CREATE TABLE IF NOT EXISTS `admin_rights` (
  `rights_ID` int(11) NOT NULL auto_increment,
  `rights_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `rights_explain` tinytext collate utf8_unicode_ci NOT NULL,
  `rights_accesstype` enum('normal','file') collate utf8_unicode_ci NOT NULL default 'normal',
  `rights_pagetype` enum('page','mod') collate utf8_unicode_ci NOT NULL default 'page',
  `rights_page_ref_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`rights_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `admin_rights`
--

INSERT INTO `admin_rights` (`rights_ID`, `rights_name`, `rights_explain`, `rights_accesstype`, `rights_pagetype`, `rights_page_ref_ID`) VALUES
(1, 'access_allowed', 'Dieses Recht wird nun jenen gewährt, die sich ins AdminCP einloggen können.\r\nunknow_user darf das z.b. nicht', 'normal', 'page', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_rights_link`
--

CREATE TABLE IF NOT EXISTS `admin_rights_link` (
  `link_ID` int(11) NOT NULL auto_increment,
  `link_typ` enum('group','user') collate utf8_unicode_ci NOT NULL default 'group',
  `link_gu_ref_ID` int(11) NOT NULL default '0',
  `link_right_ref_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`link_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `admin_rights_link`
--

INSERT INTO `admin_rights_link` (`link_ID`, `link_typ`, `link_gu_ref_ID`, `link_right_ref_ID`) VALUES
(1, 'user', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_session`
--

CREATE TABLE IF NOT EXISTS `admin_session` (
  `ID` int(11) NOT NULL auto_increment,
  `session_id` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `ip_address` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `user_agent` tinytext collate utf8_unicode_ci NOT NULL,
  `user_ref_ID` int(11) NOT NULL default '0',
  `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_activity` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=272 ;

--
-- Daten für Tabelle `admin_session`
--

INSERT INTO `admin_session` (`ID`, `session_id`, `ip_address`, `user_agent`, `user_ref_ID`, `login_time`, `last_activity`) VALUES
(267, 'da8c199e79f1b207bd126b7c5c7780d7', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11', 2, '2008-01-19 22:55:31', '2008-01-20 01:50:30'),
(271, '512288d71ba75e5c4abfd148d5b2fb29', '62.203.238.71', 'Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.0.7) Gecko/2009030422 Ubuntu/8.10 (intrepid) Firefox/3.0.7', 3, '2009-03-14 17:51:03', '2009-03-14 17:51:08');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `user_ID` int(11) NOT NULL auto_increment,
  `user_name` varchar(50) collate utf8_bin NOT NULL default '',
  `user_pw` varchar(200) collate utf8_bin NOT NULL default '',
  `user_mail` varchar(100) collate utf8_bin NOT NULL default '',
  `user_group_ref_ID` int(11) NOT NULL default '0',
  `user_comment` varchar(200) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`user_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `admin_users`
--

INSERT INTO `admin_users` (`user_ID`, `user_name`, `user_pw`, `user_mail`, `user_group_ref_ID`, `user_comment`) VALUES
(2, 'Simon', 'fc5e038d38a57032085441e7fe7010b0', 'simon_@gmx.net', 0, 'der erst User'),
(1, 'Unknow', '!_asdfsasdf_____', '', 1, ''),
(3, 'david', 'bec9ffb7d04484b8b066aca4b7e6834a', 'admin@jclub.ch', 0, 'DER Admin');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bbcodes`
--

CREATE TABLE IF NOT EXISTS `bbcodes` (
  `bbcodes_ID` int(11) NOT NULL auto_increment,
  `bbcodes_bbctag` varchar(50) character set utf8 NOT NULL default '' COMMENT 'Den Code zum Zeigen für den Eintrag',
  `bbcodes_regex` varchar(150) character set latin1 collate latin1_general_ci NOT NULL default '',
  `bbcodes_htmltag` varchar(50) character set utf8 NOT NULL default '' COMMENT 'Beispiel: <a href="%s">%s</href>',
  `bbcodes_rights` set('gb','news','content') character set latin1 collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`bbcodes_ID`),
  UNIQUE KEY `bbcodes_bbcstarttag` (`bbcodes_bbctag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `bbcodes`
--

INSERT INTO `bbcodes` (`bbcodes_ID`, `bbcodes_bbctag`, `bbcodes_regex`, `bbcodes_htmltag`, `bbcodes_rights`) VALUES
(1, '[b][/b]', '/\\[b\\](.*?)\\[\\/b\\]/si', '<b>\\\\1</b>', 'gb,news,content'),
(2, '[u][/u]', '/\\[u\\](.*?)\\[\\/u\\]/si', '<u>\\\\1</u>', 'gb,news,content'),
(3, 'img', '/img (.*?)/si', '<img src="\\\\1></img>', 'news,content'),
(4, 'url', '', '<a href="\\\\1">%s</a>', 'news,content'),
(5, '[i][/i]', '/\\[i\\](.*?)\\[\\/i\\]/si', '<i>\\\\1</i>', 'gb,news,content');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bilder`
--

CREATE TABLE IF NOT EXISTS `bilder` (
  `bilder_ID` int(4) NOT NULL auto_increment,
  `filename` varchar(200) collate utf8_unicode_ci NOT NULL default '',
  `erstellt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bilder_ID`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=210 ;

--
-- Daten für Tabelle `bilder`
--

INSERT INTO `bilder` (`bilder_ID`, `filename`, `erstellt`) VALUES
(2, 'ende_phase_1_01.jpg', '2006-07-23 01:01:45'),
(3, 'ende_phase_1_02.jpg', '2006-07-23 01:06:45'),
(4, 'ende_phase_1_03.jpg', '2006-07-23 01:07:37'),
(5, 'ende_phase_1_04.jpg', '2006-07-23 01:07:37'),
(6, 'ende_phase_1_05.jpg', '2006-07-23 01:07:37'),
(7, 'vor_umbau_01.jpg', '2006-07-23 01:10:06'),
(8, 'vor_umbau_02.jpg', '2006-07-23 01:10:06'),
(9, 'vor_umbau_03.jpg', '2006-07-23 01:10:06'),
(10, 'vor_umbau_04.jpg', '2006-07-23 01:10:06'),
(11, 'vor_umbau_05.jpg', '2006-07-23 01:10:06'),
(12, 'vor_umbau_06.jpg', '2006-07-23 01:10:06'),
(13, 'wand_1_01.jpg', '2006-07-23 01:10:45'),
(14, 'wand_1_02.jpg', '2006-07-23 01:10:45'),
(15, 'wand_1_03.jpg', '2006-07-23 01:10:45'),
(16, 'wand_1_04.jpg', '2006-07-23 01:10:45'),
(17, 'wand_1_05.jpg', '2006-07-23 01:10:45'),
(18, 'wand_1_06.jpg', '2006-07-23 01:10:45'),
(19, 'wand_1_07.jpg', '2006-07-23 01:10:45'),
(20, 'wand_1_08.jpg', '2006-07-23 01:10:45'),
(21, 'wand_2_01.jpg', '2006-07-23 01:11:17'),
(22, 'wand_2_02.jpg', '2006-07-23 01:11:17'),
(23, 'wand_2_03.jpg', '2006-07-23 01:11:17'),
(24, 'wand_2_04.jpg', '2006-07-23 01:11:17'),
(25, 'wand_2_05.jpg', '2006-07-23 01:11:17'),
(26, 'wand_2_06.jpg', '2006-07-23 01:11:17'),
(27, 'wand_2_07.jpg', '2006-07-23 01:11:17'),
(72, 'wand_1_017.jpg', '2007-01-04 01:53:15'),
(29, 'jg_programm06_04_lq.jpg', '2006-12-31 18:03:02'),
(71, 'photo074.jpg', '2007-01-01 04:36:19'),
(70, 'photo073.jpg', '2007-01-01 04:36:19'),
(69, 'photo072.jpg', '2007-01-01 04:36:19'),
(68, 'photo071.jpg', '2007-01-01 04:36:19'),
(67, 'photo070.jpg', '2007-01-01 04:36:19'),
(66, 'photo069.jpg', '2007-01-01 04:36:19'),
(65, 'photo068.jpg', '2007-01-01 04:36:19'),
(64, 'photo067.jpg', '2007-01-01 04:36:19'),
(63, 'photo066.jpg', '2007-01-01 04:36:19'),
(62, 'photo065.jpg', '2007-01-01 04:36:19'),
(61, 'photo064.jpg', '2007-01-01 04:36:19'),
(60, 'photo063.jpg', '2007-01-01 04:36:19'),
(59, 'photo062.jpg', '2007-01-01 04:36:19'),
(58, 'photo061.jpg', '2007-01-01 04:36:19'),
(57, 'photo060.jpg', '2007-01-01 04:36:19'),
(56, 'photo059.jpg', '2007-01-01 04:36:19'),
(55, 'photo058.jpg', '2007-01-01 04:36:19'),
(54, 'photo057.jpg', '2007-01-01 04:36:19'),
(53, 'photo056.jpg', '2007-01-01 04:36:19'),
(112, 'photo043.jpg', '2007-01-05 21:20:42'),
(74, 'vor_umbau_001.jpg', '2007-01-05 20:45:51'),
(75, 'vor_umbau_003.jpg', '2007-01-05 20:45:51'),
(76, 'vor_umbau_005.jpg', '2007-01-05 20:46:01'),
(111, 'photo042.jpg', '2007-01-05 21:20:42'),
(110, 'photo041.jpg', '2007-01-05 21:20:42'),
(109, 'photo040.jpg', '2007-01-05 21:20:42'),
(108, 'photo039.jpg', '2007-01-05 21:20:42'),
(107, 'photo038.jpg', '2007-01-05 21:20:42'),
(106, 'photo037.jpg', '2007-01-05 21:20:42'),
(105, 'photo036.jpg', '2007-01-05 21:20:42'),
(104, 'photo035.jpg', '2007-01-05 21:20:42'),
(103, 'photo034.jpg', '2007-01-05 21:20:42'),
(102, 'photo033.jpg', '2007-01-05 21:20:42'),
(101, 'photo032.jpg', '2007-01-05 21:20:42'),
(113, 'photo044.jpg', '2007-01-05 21:20:42'),
(114, 'photo045.jpg', '2007-01-05 21:20:42'),
(115, 'photo046.jpg', '2007-01-05 21:20:42'),
(116, 'photo047.jpg', '2007-01-05 21:20:42'),
(125, 'vor_umbau_004.jpg', '2007-01-05 21:35:18'),
(118, 'photo049.jpg', '2007-01-05 21:20:42'),
(119, 'photo050.jpg', '2007-01-05 21:20:42'),
(120, 'photo051.jpg', '2007-01-05 21:20:42'),
(121, 'photo052.jpg', '2007-01-05 21:20:42'),
(122, 'photo053.jpg', '2007-01-05 21:20:42'),
(123, 'photo054.jpg', '2007-01-05 21:20:42'),
(124, 'photo055.jpg', '2007-01-05 21:20:42'),
(126, 'programm4_07.jpg', '2007-01-06 19:24:28'),
(127, 'snowcamp-flyer.jpg', '2007-01-06 19:24:28'),
(128, 'jg-weekend001.jpg', '2007-02-19 21:33:41'),
(129, 'jg-weekend002.jpg', '2007-02-19 21:33:41'),
(130, 'jg-weekend003.jpg', '2007-02-19 21:33:41'),
(131, 'jg-weekend004.jpg', '2007-02-19 21:33:42'),
(132, 'jg-weekend005.jpg', '2007-02-19 21:33:42'),
(133, 'jg-weekend006.jpg', '2007-02-19 21:33:42'),
(134, 'jg-weekend007.jpg', '2007-02-19 21:33:42'),
(135, 'jg-weekend008.jpg', '2007-02-19 21:33:42'),
(136, 'jg-weekend009.jpg', '2007-02-19 21:33:42'),
(137, 'jg-weekend010.jpg', '2007-02-19 21:33:42'),
(138, 'jg-weekend011.jpg', '2007-02-19 21:33:42'),
(139, 'jg-weekend012.jpg', '2007-02-19 21:33:42'),
(140, 'jg-weekend013.jpg', '2007-02-19 21:33:42'),
(141, 'jg-weekend014.jpg', '2007-02-19 21:33:42'),
(142, 'jg-weekend015.jpg', '2007-02-19 21:33:42'),
(143, 'jg-weekend016.jpg', '2007-02-19 21:33:42'),
(144, 'jg-weekend017.jpg', '2007-02-19 21:33:42'),
(145, 'jg-weekend018.jpg', '2007-02-19 21:33:42'),
(146, 'jg-weekend019.jpg', '2007-02-19 21:33:42'),
(147, 'jg-weekend020.jpg', '2007-02-19 21:33:42'),
(148, 'jg-weekend021.jpg', '2007-02-19 21:33:42'),
(149, 'jg-weekend022.jpg', '2007-02-19 21:33:42'),
(150, 'jg-weekend023.jpg', '2007-02-19 21:33:42'),
(151, 'jg-weekend024.jpg', '2007-02-19 21:33:42'),
(152, 'jg-weekend025.jpg', '2007-02-19 21:33:42'),
(153, 'jg-weekend026.jpg', '2007-02-19 21:33:42'),
(154, 'jg-weekend027.jpg', '2007-02-19 21:33:42'),
(155, 'jg-weekend028.jpg', '2007-02-19 21:33:42'),
(156, 'jg-weekend029.jpg', '2007-02-19 21:33:42'),
(157, 'jg-weekend030.jpg', '2007-02-19 21:33:42'),
(158, 'jg-weekend031.jpg', '2007-02-19 21:33:42'),
(159, 'jg-weekend032.jpg', '2007-02-19 21:33:42'),
(160, 'jg-weekend033.jpg', '2007-02-19 21:33:42'),
(161, 'jg-weekend034.jpg', '2007-02-19 21:33:42'),
(162, 'jg-weekend035.jpg', '2007-02-19 21:33:42'),
(163, 'jg-weekend036.jpg', '2007-02-19 21:33:42'),
(164, 'jg-weekend037.jpg', '2007-02-19 21:33:42'),
(165, 'jg-weekend038.jpg', '2007-02-19 21:33:42'),
(166, 'jg-weekend039.jpg', '2007-02-19 21:33:42'),
(167, 'jg-weekend040.jpg', '2007-02-19 21:33:42'),
(168, 'jg-weekend041.jpg', '2007-02-19 21:33:42'),
(169, 'jg-weekend042.jpg', '2007-02-19 21:33:42'),
(170, 'jg-weekend043.jpg', '2007-02-19 21:33:42'),
(171, 'jg-weekend044.jpg', '2007-02-19 21:33:42'),
(172, 'jg-weekend045.jpg', '2007-02-19 21:33:42'),
(173, 'jg-weekend046.jpg', '2007-02-19 21:33:42'),
(174, 'jg-weekend047.jpg', '2007-02-19 21:33:42'),
(175, 'jg-weekend048.jpg', '2007-02-19 21:33:42'),
(176, 'jg-weekend049.jpg', '2007-02-19 21:33:42'),
(177, 'jg-weekend050.jpg', '2007-02-19 21:33:42'),
(178, 'jg-weekend051.jpg', '2007-02-19 21:33:42'),
(179, 'jg-weekend052.jpg', '2007-02-19 21:33:42'),
(180, 'jg-weekend053.jpg', '2007-02-19 21:33:42'),
(181, 'jg-weekend054.jpg', '2007-02-19 21:33:42'),
(182, 'jg-weekend055.jpg', '2007-02-19 21:33:42'),
(183, 'jg-weekend056.jpg', '2007-02-19 21:33:42'),
(184, 'jg-weekend057.jpg', '2007-02-19 21:33:42'),
(185, 'jg-weekend058.jpg', '2007-02-19 21:33:42'),
(186, 'jg-weekend059.jpg', '2007-02-19 21:33:42'),
(187, 'jg-weekend060.jpg', '2007-02-19 21:33:42'),
(188, 'jg-weekend061.jpg', '2007-02-19 21:33:42'),
(189, 'jg-weekend062.jpg', '2007-02-19 21:33:42'),
(190, 'jg-weekend063.jpg', '2007-02-19 21:33:42'),
(191, 'jg-weekend064.jpg', '2007-02-19 21:33:42'),
(192, 'jg-weekend065.jpg', '2007-02-19 21:33:42'),
(193, 'jg-weekend066.jpg', '2007-02-19 21:33:42'),
(194, 'jg-weekend067.jpg', '2007-02-19 21:33:42'),
(195, 'jg-weekend068.jpg', '2007-02-19 21:33:42'),
(196, 'jg-weekend069.jpg', '2007-02-19 21:33:42'),
(197, 'jg-weekend070.jpg', '2007-02-19 21:33:42'),
(198, 'jg-weekend071.jpg', '2007-02-19 21:33:42'),
(199, 'jg-weekend072.jpg', '2007-02-19 21:33:42'),
(200, 'jg-weekend073.jpg', '2007-02-19 21:33:42'),
(201, 'jg-weekend074.jpg', '2007-02-19 21:33:42'),
(202, 'jg-weekend075.jpg', '2007-02-19 21:33:42'),
(203, 'jg-weekend076.jpg', '2007-02-19 21:33:42'),
(204, 'jg-weekend077.jpg', '2007-02-19 21:33:42'),
(205, 'jg-weekend078.jpg', '2007-02-19 21:33:42'),
(206, 'jg-weekend079.jpg', '2007-02-19 21:33:42'),
(207, 'jg-weekend080.jpg', '2007-02-19 21:33:42'),
(208, 'jg-weekend081.jpg', '2007-02-19 21:33:42'),
(209, 'jg-weekend082.jpg', '2007-02-19 21:33:42');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `content_ID` int(10) NOT NULL auto_increment,
  `content_title` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  `content_text` text collate utf8_unicode_ci NOT NULL,
  `content_author` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `content_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `content_archiv` enum('no','yes') collate utf8_unicode_ci NOT NULL default 'no',
  PRIMARY KEY  (`content_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Daten für Tabelle `content`
--

INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_author`, `content_time`, `content_archiv`) VALUES
(1, 'Willkommen', '<p>Wir begr&uuml;ssen euch herzlich auf der Seite des J-Club''s aus Balsthal-Thal.<br />\r\n    <center>\r\n       <a href="./index.php?nav_id=44"><img src="index.php?nav_id=41&thumb=29"></a>\r\n	<br />\r\n        <br />\r\n        <script src=''http://www.nikodemus.net/free.php?cart-write'' type=''text/javascript''></script>\r\n     </center>', '', '0000-00-00 00:00:00', 'no'),
(2, 'Über uns', '<b>Wer seit ihr?</b><br />\r\nWir sind eine Gruppe junger Menschen aus verschiedenen Berufsschichten mit einem brennenden Herzen für Jesus.<br />\r\n<b>Und was macht ihr?</b><br />\r\nUnsere Absicht ist es, den Teenies das Evangelium auf moderne Art und Weise zu verkünden.<br />\r\n<b>Und was macht ihr an euren Abenden?</b><br />\r\nUm den Teenies zeitgemässe Worship-Musik bieten zu können, haben wir eine eigene JugendBand auf die Beine gestellt, welche schon an diversen Gemeindeveranstaltungen gespielt hat.\r\nDank der Gründung dieser Band haben wir die Möglichkeit die JG-Abende mit Worship zu starten<br />\r\n<b>Danke für das kurze Interview</b><br />\r\nBitte', '', '0000-00-00 00:00:00', 'no'),
(3, 'Programm', '<div style="margin-left:5px"><br>\r\n                  <a target="_blank" href="./index.php?nav_id=41&bild=29"><img src="./index.php?nav_id=41&bild=29" alt="JG-Programm"></a><br>\r\n  Was uns noch fehlt bist..... <b>DU</b><br></div>', '', '0000-00-00 00:00:00', 'no'),
(4, 'Gott kann reden!', 'Ich durften in den Jahren, seit ich Nachfolger von Jesus bin, schon viele Erlebnisse mit Gott erleben. Doch DAS Erlebnis, das mich am meisten geprägt hat, hat sich vor ca. 2 Jahren ereignet.<br />\r\n<br>\r\nWir hatten in unserer Gemeinde wieder mal eine Versammlung übers Vorjahr, wo über die Finanzen und die gesamte Gemeinde gesprochen wurde, ein Jahresrückblick könnte man sagen. Zu Beginn einer solchen Veranstaltung gab es jeweils in den Jahren zuvor einen kurzen Input, meist von einem Pastor oder Ältesten unserer Gemeinde.<br /><br />\r\n\r\nDoch drei Tage vor dieser Versammlung hörte ich während der Arbeit Gottes Stimme, die zu mir sprach, dass ich diesen Input vorbereiten solle. Doch ich konnte mir nicht vorstellen diese Aufgabe als Jugendleiter zu übernehmen. Ich dachte, das hätte ich mir vielleicht selbst ausgedacht. Doch die Stimme verfolgte mich, den ganzen Tag – so gab ich schliesslich nach. Ich ging von der Arbeit nach Hause und schrieb den Input ohne dass mich vorher jemand angefragt hätte. Am nächsten Tag, am Tag vor der Versammlung rief mich der Präsident der Gemeinde an und wollte mich schüchtern was fragen. Ich wusste genau, was er wollte und sprach zu ihm, dass ich den Input bereits vorbereitet hätte.<br /><br />\r\n\r\nEs war ein unglaubliches Gefühl Gottes Nähe so spüren zu können. Das durfte ich dann auch den Leuten in der Versammlung weitergeben. Dieses Erlebnis hat mich persönlich sehr berührt und ich habe gemerkt, dass Gott wirklich aktiv zu mir, zu dir reden kann.<br /><br />\r\n\r\n<b>Praise the Lord!</b><br />von Bebu', '', '0000-00-00 00:00:00', 'no'),
(5, 'Unsere JG', '<p>Als Jugendgruppe \r\nsehen wir in der Bibel die Grundlage unseres Lebens. Das Wort Gottes \r\ngibt uns Anweisungen für unser Leben, die uns zeigen wie ein Leben \r\nin der Beziehung zu Gott aussehen kann. Damit wir aber durch die vielen \r\nAussagen der Bibel das Wesentliche nicht aus den Augen verlieren, haben \r\nwir unsere Vision und 5 Aufträge formuliert, die wir in die Tat umsetzen \r\nwollen. <br><br><br></p>\r\n\r\n<p><b>Unsere Vision</b> <br>\r\n</p>\r\n<p><b>„Als Jugendgruppe \r\nmöchten wir, dass die Jugendlichen unserer Region durch die Liebe Gottes \r\nverändert werden.“</b> <br></p>\r\n<p>Es ist unser \r\nAnliegen möglichst viele junge Leute in unserer Region mit dem Evangelium \r\nzu erreichen, auf eine möglichst einfache und verständliche Art. </p>\r\n<p>Jesus ist für \r\nuns am Kreuz gestorben. ER hat für unsere Sünden, die wir gemacht \r\nhaben und auch heute noch machen, bezahlt. Durch seine Liebe ist es \r\nfür uns Menschen überhaupt möglich geworden Veränderung in unserem \r\nLeben zu erfahren. So ist es unser Wunsch, dass diese Liebe, die wir \r\ntäglich erfahren dürfen auch noch andere Menschen erfahren können \r\nund dass diese Leute dann selber zu einem Samen für andere Menschen \r\nwerden können. <br> <br></p>\r\n<p><i>Unsere 5 \r\nAufträge, die uns helfen sollen unsere Vision Wirklichkeit werden zu \r\nlassen</i>: <br> <br></p>\r\n\r\n<p><b>Nachfolge</b> <br>\r\n</p>\r\n<p><b>„Als Jugendgruppe \r\nwollen wir immer mehr Jesus mässig Leben und so auch zum Licht für \r\nunsere Mitmenschen werden.“</b> <br></p>\r\n<p>Im Neuen Testament \r\nfinden wir in einigen Versen den Ausdruck „folge mir nach!“, den \r\nJesus spricht. Nach diesem Bild wollen wir Menschen sein, die seinem \r\nBeispiel folgen. Wir wollen immer bewusster Jesus mässig leben. Alle \r\nBereiche unseres Lebens sollen von IHM bestimmt werden. Als seine Jünger \r\nwollen wir Jesus nachfolgen. <br> <br></p>\r\n<p><b>Anbetung</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nGott anbeten und IHM die Ehre geben für das, was ER für uns getan \r\nhat.“</b> <br></p>\r\n\r\n<p>Wir wollen \r\nGott anbeten aus Dankbarkeit dafür, dass ER seinen Sohn für uns hingegeben \r\nhat. Von dieser Liebe, die ER uns gegeben hat wollen wir IHM etwas zurückgeben. \r\nAus diesem Grund wollen wir Gott mit unserem ganzen Leben anbeten. Wir \r\nwollen IHN loben und preisen für seine Schöpfung und seine Allmacht. <br>\r\n <br></p>\r\n<p><b>Gemeinschaft</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nuns gegenseitig in der Jugendgruppe annehmen und achten, so dass echte \r\nGemeinschaft mit Tiefgang entstehen darf.“</b> <br></p>\r\n<p>Was uns alle \r\nin der Jugendgruppe verbindet ist der Glaube an Jesus Christus. Jesus \r\nliebt jeden und jede genau gleich und so wie Jesus dies tut, versuchen \r\nauch wir einander anzunehmen und zu akzeptieren wie wir sind. </p>\r\n<p>Wir wollen \r\nmiteinander ein aktives Leben im Glauben führen, das Tiefgang hat und \r\nnicht nur oberflächlich wirkt. Auch ist der Glaube nach neutestamentlicher \r\nAuffassung keine Privatsache, wo jeder sein Christsein für sich lebt, \r\nsondern jeder Gläubige braucht den Austausch, die Gemeinschaft und \r\nden Umgang mit anderen Christen. <br> <br></p>\r\n\r\n<p><b>Evangelisation</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nGottes Frohe Botschaft auf eine moderne Art weitergeben, so dass auch \r\njüngere Menschen den Zugang zu Gott finden können.“</b> <br>\r\n</p>\r\n<p>Wir glauben \r\ndaran, dass nur ein Leben mit Jesus Sinn macht. Aus diesem Grund wollen \r\nwir, dass Menschen von der Liebe Gottes hören, sie aufnehmen und sich \r\nvon Gott verändern lassen. Weil es uns nicht egal ist, was mit unseren \r\nMitmenschen passiert, möchten wir ihnen als Werkzeug Gottes dienen. <br>\r\n <br></p>\r\n<p><b>Dienerschaft</b> <br>\r\n</p>\r\n\r\n<p><b>„Es ist \r\nunser Anliegen, dass Mitglieder der Jugendgruppe sich mit ihren Gaben \r\nund Talenten in der JG bzw. in der Gemeinde engagieren.“</b> <br>\r\n</p>\r\n<p>Gott hat uns \r\nALLE mit verschiedenen Gaben und Talenten ausgestattet. Mit diesen Eigenschaften, \r\nmit denen uns Gott ausgestattet hat, wollen wir Gott loben und anbeten. \r\nJeder Mensch ist einzigartig – und mit diesen Fähigkeiten wollen \r\nwir Gott anbeten. Wir wollen die JG zusammen gestalten, einander unterstützen \r\nund uns gegenseitig dienen.</p>', '', '0000-00-00 00:00:00', 'no'),
(6, 'Unsere Visionen', '<p><b>„Als Jugendgruppe \r\nmöchten wir, dass die Jugendlichen unserer Region durch die Liebe Gottes \r\nverändert werden.“</b> <br></p>\r\n<p>Es ist unser \r\nAnliegen möglichst viele junge Leute in unserer Region mit dem Evangelium \r\nzu erreichen, auf eine möglichst einfache und verständliche Art. </p>\r\n<p>Jesus ist für \r\nuns am Kreuz gestorben. ER hat für unsere Sünden, die wir gemacht \r\nhaben und auch heute noch machen, bezahlt. Durch seine Liebe ist es \r\nfür uns Menschen überhaupt möglich geworden Veränderung in unserem \r\nLeben zu erfahren. So ist es unser Wunsch, dass diese Liebe, die wir \r\ntäglich erfahren dürfen auch noch andere Menschen erfahren können \r\nund dass diese Leute dann selber zu einem Samen für andere Menschen \r\nwerden können. <br> <br></p>\r\n<p><i>Unsere 5 \r\nAufträge, die uns helfen sollen unsere Vision Wirklichkeit werden zu \r\nlassen</i>: <br> <br></p>\r\n\r\n<p><b>Nachfolge</b> <br>\r\n</p>\r\n<p><b>„Als Jugendgruppe \r\nwollen wir immer mehr Jesus mässig Leben und so auch zum Licht für \r\nunsere Mitmenschen werden.“</b> <br></p>\r\n<p>Im Neuen Testament \r\nfinden wir in einigen Versen den Ausdruck „folge mir nach!“, den \r\nJesus spricht. Nach diesem Bild wollen wir Menschen sein, die seinem \r\nBeispiel folgen. Wir wollen immer bewusster Jesus mässig leben. Alle \r\nBereiche unseres Lebens sollen von IHM bestimmt werden. Als seine Jünger \r\nwollen wir Jesus nachfolgen. <br> <br></p>\r\n<p><b>Anbetung</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nGott anbeten und IHM die Ehre geben für das, was ER für uns getan \r\nhat.“</b> <br></p>\r\n\r\n<p>Wir wollen \r\nGott anbeten aus Dankbarkeit dafür, dass ER seinen Sohn für uns hingegeben \r\nhat. Von dieser Liebe, die ER uns gegeben hat wollen wir IHM etwas zurückgeben. \r\nAus diesem Grund wollen wir Gott mit unserem ganzen Leben anbeten. Wir \r\nwollen IHN loben und preisen für seine Schöpfung und seine Allmacht. <br>\r\n <br></p>\r\n<p><b>Gemeinschaft</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nuns gegenseitig in der Jugendgruppe annehmen und achten, so dass echte \r\nGemeinschaft mit Tiefgang entstehen darf.“</b> <br></p>\r\n<p>Was uns alle \r\nin der Jugendgruppe verbindet ist der Glaube an Jesus Christus. Jesus \r\nliebt jeden und jede genau gleich und so wie Jesus dies tut, versuchen \r\nauch wir einander anzunehmen und zu akzeptieren wie wir sind. </p>\r\n<p>Wir wollen \r\nmiteinander ein aktives Leben im Glauben führen, das Tiefgang hat und \r\nnicht nur oberflächlich wirkt. Auch ist der Glaube nach neutestamentlicher \r\nAuffassung keine Privatsache, wo jeder sein Christsein für sich lebt, \r\nsondern jeder Gläubige braucht den Austausch, die Gemeinschaft und \r\nden Umgang mit anderen Christen. <br> <br></p>\r\n\r\n<p><b>Evangelisation</b> <br>\r\n</p>\r\n<p><b>„Wir wollen \r\nGottes Frohe Botschaft auf eine moderne Art weitergeben, so dass auch \r\njüngere Menschen den Zugang zu Gott finden können.“</b> <br>\r\n</p>\r\n<p>Wir glauben \r\ndaran, dass nur ein Leben mit Jesus Sinn macht. Aus diesem Grund wollen \r\nwir, dass Menschen von der Liebe Gottes hören, sie aufnehmen und sich \r\nvon Gott verändern lassen. Weil es uns nicht egal ist, was mit unseren \r\nMitmenschen passiert, möchten wir ihnen als Werkzeug Gottes dienen. <br>\r\n <br></p>\r\n<p><b>Dienerschaft</b> <br>\r\n</p>\r\n\r\n<p><b>„Es ist \r\nunser Anliegen, dass Mitglieder der Jugendgruppe sich mit ihren Gaben \r\nund Talenten in der JG bzw. in der Gemeinde engagieren.“</b> <br>\r\n</p>\r\n<p>Gott hat uns \r\nALLE mit verschiedenen Gaben und Talenten ausgestattet. Mit diesen Eigenschaften, \r\nmit denen uns Gott ausgestattet hat, wollen wir Gott loben und anbeten. \r\nJeder Mensch ist einzigartig – und mit diesen Fähigkeiten wollen \r\nwir Gott anbeten. Wir wollen die JG zusammen gestalten, einander unterstützen \r\nund uns gegenseitig dienen.</p>', '', '0000-00-00 00:00:00', 'no'),
(7, 'Nachfolge', '<p><b>„Als Jugendgruppe \r\nwollen wir immer mehr Jesus mässig Leben und so auch zum Licht für \r\nunsere Mitmenschen werden.“</b> <br></p>\r\n<p>Im Neuen Testament \r\nfinden wir in einigen Versen den Ausdruck „folge mir nach!“, den \r\nJesus spricht. Nach diesem Bild wollen wir Menschen sein, die seinem \r\nBeispiel folgen. Wir wollen immer bewusster Jesus mässig leben. Alle \r\nBereiche unseres Lebens sollen von IHM bestimmt werden. Als seine Jünger \r\nwollen wir Jesus nachfolgen. <br> <br></p>', '', '0000-00-00 00:00:00', 'no'),
(8, 'Anbetung', '<p><b>„Wir wollen \r\nGott anbeten und IHM die Ehre geben für das, was ER für uns getan \r\nhat.“</b> <br></p>\r\n\r\n<p>Wir wollen \r\nGott anbeten aus Dankbarkeit dafür, dass ER seinen Sohn für uns hingegeben \r\nhat. Von dieser Liebe, die ER uns gegeben hat wollen wir IHM etwas zurückgeben. \r\nAus diesem Grund wollen wir Gott mit unserem ganzen Leben anbeten. Wir \r\nwollen IHN loben und preisen für seine Schöpfung und seine Allmacht. <br>\r\n <br></p>', '', '0000-00-00 00:00:00', 'no'),
(9, 'Gemeinschaft', '<p><b>„Wir wollen \r\nuns gegenseitig in der Jugendgruppe annehmen und achten, so dass echte \r\nGemeinschaft mit Tiefgang entstehen darf.“</b> <br></p>\r\n<p>Was uns alle \r\nin der Jugendgruppe verbindet ist der Glaube an Jesus Christus. Jesus \r\nliebt jeden und jede genau gleich und so wie Jesus dies tut, versuchen \r\nauch wir einander anzunehmen und zu akzeptieren wie wir sind. </p>\r\n<p>Wir wollen \r\nmiteinander ein aktives Leben im Glauben führen, das Tiefgang hat und \r\nnicht nur oberflächlich wirkt. Auch ist der Glaube nach neutestamentlicher \r\nAuffassung keine Privatsache, wo jeder sein Christsein für sich lebt, \r\nsondern jeder Gläubige braucht den Austausch, die Gemeinschaft und \r\nden Umgang mit anderen Christen. <br> <br></p>', '', '0000-00-00 00:00:00', 'no'),
(10, 'Evangelisation', '<p><b>„Wir wollen \r\nGottes Frohe Botschaft auf eine moderne Art weitergeben, so dass auch \r\njüngere Menschen den Zugang zu Gott finden können.“</b> <br>\r\n</p>\r\n<p>Wir glauben \r\ndaran, dass nur ein Leben mit Jesus Sinn macht. Aus diesem Grund wollen \r\nwir, dass Menschen von der Liebe Gottes hören, sie aufnehmen und sich \r\nvon Gott verändern lassen. Weil es uns nicht egal ist, was mit unseren \r\nMitmenschen passiert, möchten wir ihnen als Werkzeug Gottes dienen. <br>\r\n <br></p>', '', '0000-00-00 00:00:00', 'no'),
(11, 'Dienerschaft', '<p><b>„Es ist \r\nunser Anliegen, dass Mitglieder der Jugendgruppe sich mit ihren Gaben \r\nund Talenten in der JG bzw. in der Gemeinde engagieren.“</b> <br>\r\n</p>\r\n<p>Gott hat uns \r\nALLE mit verschiedenen Gaben und Talenten ausgestattet. Mit diesen Eigenschaften, \r\nmit denen uns Gott ausgestattet hat, wollen wir Gott loben und anbeten. \r\nJeder Mensch ist einzigartig – und mit diesen Fähigkeiten wollen \r\nwir Gott anbeten. Wir wollen die JG zusammen gestalten, einander unterstützen \r\nund uns gegenseitig dienen.</p>', '', '0000-00-00 00:00:00', 'no'),
(12, 'Programm bis Ende 08', '<ul><li>5. September</li>\r\n<li>19. September (Geburtstag Lüdi)</li>\r\n<li>10. Oktober</li>\r\n<li>17. Oktober</li>\r\n<li>31. Oktober</li>\r\n<li>14. November</li>\r\n<li>28. November</li>\r\n<li>12. Dezember</li>\r\n<li>19. Dezember: Weihnachtsparty</li>\r\n</ul>', '', '0000-00-00 00:00:00', 'no'),
(13, '12. Januar', '<p><i>Allianz \r\nWoche</i></p>\r\n<p>Wie letztes \r\nJahr wollen wir auch dieses Jahr an der regionalen Allianz – Gebetswoche \r\nmitmachen, um uns gegenseitig zu ermutigen und zu stärken. <br>\r\n <br></p>', '', '0000-00-00 00:00:00', 'yes'),
(14, '19.  – 21. Januar', '<p><i>Snowcamp \r\nin Raron (VS)</i></p>\r\n<p>Ein Wochenende \r\nzieht es uns in die schönen Berge ins Vallis. Nebst dem Schnee wollen \r\nwir auch die Gemeinschaft zusammen und mit Gott geniessen.</p>\r\n<p>(Anmeldung: \r\nsiehe Flyer separat!) <br> <br></p>', '', '0000-00-00 00:00:00', 'yes'),
(15, '26. Januar', '<p><i>Worship \r\n– Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm. <br>\r\n <br></p>', '', '0000-00-00 00:00:00', 'yes'),
(16, '2. Februar', '<p><i>JG \r\n– Raum – Lifting</i></p>\r\n<p>Nachdem unser \r\nJG – Raum vorletztes Jahr grösstenteils renoviert worden ist, kommen \r\njetzt noch kleine Details, die dazu beitragen sollen, den JG – Raum \r\nnoch jugendfreundlicher zu gestalten.</p>', '', '0000-00-00 00:00:00', 'yes'),
(17, '23. Februar', '<p><i>Worship \r\n– Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm.</p>', '', '0000-00-00 00:00:00', 'yes'),
(18, '2. März', '<p><i>Warum dieses \r\nLeid?</i></p>\r\n<p>In der Welt \r\ngibt es so viel Trauer, so viel Leid und so viel Schmerz, aber warum? \r\nWir wollen uns mit der Frage auseinandersetzen, warum Gott das überhaupt \r\nzulässt.</p>', '', '0000-00-00 00:00:00', 'yes'),
(19, '9. März', '<p><i>Das Gebet \r\nals mächtige Waffe</i></p>\r\n<p>Vielmals wird \r\ndie Kraft des Gebets unterschätzt. Aus diesem Grunde wird heutzutage \r\nvon vielen Menschen nicht mehr regelmässig gebetet. Wir fragen uns, \r\nwarum das so ist und was es mit der Kraft des Gebets auf sich hat.</p>', '', '0000-00-00 00:00:00', 'yes'),
(20, '16. März', '<p><i>Warum christliche \r\nSchriften?</i></p>\r\n<p>10 wesentliche \r\nPunkte sollen uns als Anreiz dienen, christliche Schriften an andere \r\nMenschen weiterzugeben.</p>', '', '0000-00-00 00:00:00', 'yes'),
(21, '23. März', '<p><i>Servant \r\nEvangelism</i></p>\r\n<p>Was wir am \r\n16. März gelernt haben wollen wir in die Tat umsetzen: Wir gehen auf \r\ndie Strasse, um den Menschen vom Evangelium zu erzählen. <br>\r\n</p>\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>', '', '0000-00-00 00:00:00', 'yes'),
(22, '30. März', '<p><i>Worship \r\n– Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm.</p>', '', '0000-00-00 00:00:00', 'yes'),
(23, '6. April', '<p><i>Wir nehmen \r\nein gemeinsames Abendmahl</i></p>\r\n<p>Passend zu \r\nOstern wollen wir ein Abendmahl zu uns nehmen wie das vor ca. 2000 Jahren \r\nder Brauch gewesen ist und uns an das erinnern, was Jesus am Kreuz für \r\nuns getan hat.</p>', '', '0000-00-00 00:00:00', 'yes'),
(24, '27. April', '<p><i>Worship \r\n– Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm.</p>', '', '0000-00-00 00:00:00', 'yes'),
(25, '4. Mai', '<p><i>Musik in \r\nder Bibel</i></p>\r\n<p>Wir wollen \r\nuns damit befassen, welche Rolle die Musik in der bibel innehat und \r\nwelche Rolle ihr heute beigemessen wird.</p>', '', '0000-00-00 00:00:00', 'yes'),
(26, '11. Mai', '<p><i>Zum Christsein \r\nstehen</i></p>\r\n<p>Es fällt nicht \r\njedem und jeder leicht in allen Situationen zum Christsein zu stehen. \r\nWir wollen uns austauschen wo Schwierigkeiten und Probleme liegen und \r\nversuchen einen Ansatz zu einer möglichen Besserung zu finden.</p>', '', '0000-00-00 00:00:00', 'yes'),
(27, '18. Mai', '<p><i>Was sind \r\nPfingstgemeinden?</i></p>\r\n<p>In der Schweiz \r\ngibt es nicht nur die Evangelisch – Reformierte und die Römisch – \r\nKatholische Kirche, sondern es gibt noch viele andere Kirchen, die sich \r\n„Freikirchen“ nennen. Wir wollen uns besonders mit den „Pfingstgemeinden“ \r\nauseinandersetzen.</p>', '', '0000-00-00 00:00:00', 'yes'),
(28, '1. Juni', '<p><i>Bibelauslegung \r\nheute</i></p>\r\n<p>Vielmals ist \r\ndas Bibellesen ein Frust, wenn man etwas nicht versteht. Aus diesem \r\nGrund suchen wir nach Hilfsmittel und möglichen Hilfeleistungen, die \r\nuns das Bibellesen zur Freude machen – so dass wir die Bibel besser \r\nverstehen können.</p>', '', '0000-00-00 00:00:00', 'yes'),
(29, '8. Juni', '<p><i>Welche \r\n„Art“ Christ bin ich?</i></p>\r\n<p>Christen glauben \r\nzwar dasselbe, haben aber trotzdem unterschiedliche Ansichten und Lebenseinstellungen. \r\nWir wollen herausfinden wer von uns in welche Richtung schlägt.</p>', '', '0000-00-00 00:00:00', 'yes'),
(30, '15. Juni', '<p><i>Das Internet \r\nsinnvoll nutzen</i></p>\r\n<p>Viele Jugendliche \r\nverbringen oft Stunden im Internet. Doch vielmals auf Seiten, die sie \r\nnegativ beeinflussen. Wir wollen uns mit den Angeboten an christlichen \r\nWebsites vertraut machen.</p>', '', '0000-00-00 00:00:00', 'yes'),
(31, '22. Juni', '<p><i>Die Rolle \r\nder Frau in der Bibel</i></p>\r\n<p>Viele Frauen \r\nhaben in der bibel eine wichtige rolle gespielt. Doch auch heute noch \r\ngibt es brisante Themen (Kopftuch: ja oder nein / Frauen dürfen predigen?). \r\nWir wollen uns mit diesen Fragen auseinandersetzen und dabei die Bibel \r\nals Vorlage nehmen.</p>', '', '0000-00-00 00:00:00', 'yes'),
(32, '29. Juni', '<p><i>Worship \r\n– Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship – Zeit, Zeugnisse und ein Input gehören hier zum Programm. <br>\r\n</p>', '', '0000-00-00 00:00:00', 'yes'),
(33, '6. Juli', '<p><i>Kino</i> <br>\r\n</p>\r\n<p>Als krönender \r\nAbschluss vor den Schulferien besuchen wir als ganze Jugendgruppe wieder \r\neinmal das Kino</p>\r\n\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>', '', '0000-00-00 00:00:00', 'yes'),
(35, 'Geschichte unserer Jugendgruppe', '<p>Wir schreiben das Jahr 2007. Genau vor 10 Jahren wurde die Jugendgruppe in Balsthal gegründet. Ohne wirklich eine Ahnung zu haben, was denn genau eine Jugendgruppe so macht, wurde ich (Bebu, Leiter der JG) vom damaligen Kirchgemeindepräsidenten (Markus Schenk) angefragt, eine solche Gruppe zu gründen. Ich liess mich überreden und so kam es im Jahr 1997 zur Gründung dieser JG.</p><p>\r\nDoch damit ich als Ahnungsloser nicht alleine im Schilf stehen musste, wurde ich von diversen Menschen unterstützt, die mir besonders zu Beginn der Gründung der Gruppe eine hilfreiche Stütze waren. Insbesondere Anna Däster, Christian Ledermann und Patrick Allemann waren es, die mir geholfen haben eine solche Jugendgruppe auf die Beine zu stellen. Doch der Anfang war alles andere als einfach, da wir uns erstmals einen Kontaktkreis aufbauen mussten. Doch nach langer Anlaufszeit war dies geschafft. Wir konnten so richtig beginnen durchzustarten…</p><p>\r\nEs vergingen 3 – 4 Jahre, da gaben mir Anna und Christian, später auch Patrick bekannt, dass sie es aus verschiedenen Gründen nicht mehr sehen würden als Leiter in der Jugendgruppe zu fungieren. So erlebte die JG eine neue Epoche, in der ich die Jugendgruppe alleine zu leiten versuchte. Inzwischen im Glauben reifer geworden traute ich mir diese Aufgabe zu. Zudem fand ich immer wieder Leute, die mich unterstützen. Als ich die RS zu absolvieren hatte war Daniel Joss alias Omega in der Jungschi bereit, für mich die Leitung zu übernehmen. Ich war und bin auch heute noch dankbar, dass sich immer wieder Menschen für die Jugendgruppe investiert haben, wenn es für mich nicht möglich war da zu sein.</p><p>\r\nEin paar Jahre vergingen und in der Zwischenzeit entstand in mir das Gefühl, dass die Gruppe nicht von einer, sondern von mehreren Personen geführt werden sollte. Da die treusten Mitglieder im Laufe der Jahre auch älter geworden sind, schien mir das durchaus möglich. So kam es dann im Jahr 2006 zur Gründung des Leitungsteams, das aus Mitgliedern der JG besteht. Es ist für mich einerseits eine Entlastung, andererseits aber sicherlich auch eine Bereicherung für die jüngeren Leitungsmitglieder zu profitieren, Erfahrungen zu sammeln als Leiter und selbst aktiv zu werden.</p><p>\r\nIch danke Gott, dass er mir und der Jugendgruppe in all den Jahren treu zur Seite gestanden ist, dass Er uns durch schwierige Zeiten durchgetragen hat, uns immer wieder Menschen geschenkt hat, die sich für die JG hingegeben haben. Mit Gottes Hilfe wollen wir als Jugendgruppe die nächsten Jahre in Angriff nehmen und noch für viele Menschen zum Segen werden.</p>', '', '0000-00-00 00:00:00', 'no');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery_alben`
--

CREATE TABLE IF NOT EXISTS `gallery_alben` (
  `ID` int(4) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `ref_ID` int(11) NOT NULL default '0',
  `comment` tinytext collate utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `gallery_alben`
--

INSERT INTO `gallery_alben` (`ID`, `name`, `ref_ID`, `comment`, `time`) VALUES
(1, 'Vor dem Umbau', 0, '', '2007-01-02 12:00:00'),
(2, 'Herausnehmen der 1. Trennwand', 0, '', '2007-01-02 12:00:00'),
(3, 'Herausnehmen der 2. Trennwand', 0, '', '2007-01-02 12:00:00'),
(4, 'Ende der 1. Phase', 0, '', '2007-01-02 12:00:00'),
(5, 'Fertigstellung', 0, '', '2007-01-02 12:00:00'),
(6, 'Neujahrsfeier 05/06', 0, 'Gut gegessen, viele Filme geschaut und wenig geschlafen', '2006-01-02 12:00:00'),
(8, 'Skiweekend ohne Schnee', 0, '', '2007-01-02 12:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery_categories`
--

CREATE TABLE IF NOT EXISTS `gallery_categories` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_bin NOT NULL default '',
  `ref_ID` int(11) NOT NULL default '0',
  `comment` tinytext collate utf8_bin NOT NULL,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `gallery_categories`
--

INSERT INTO `gallery_categories` (`ID`, `name`, `ref_ID`, `comment`, `time`) VALUES
(1, 'Umbau', 0, 'Umbau des JG-Raumes', '2007-12-22 17:37:56');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery_eintraege`
--

CREATE TABLE IF NOT EXISTS `gallery_eintraege` (
  `ID` int(4) NOT NULL auto_increment,
  `fid_bild` int(4) NOT NULL default '0',
  `fid_album` int(4) NOT NULL default '0',
  `sequence` tinyint(11) NOT NULL default '0',
  `comment` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=187 ;

--
-- Daten für Tabelle `gallery_eintraege`
--

INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES
(1, 7, 1, 1, ''),
(2, 8, 1, 8, ''),
(3, 9, 1, 3, ''),
(4, 10, 1, 7, ''),
(5, 11, 1, 9, ''),
(6, 12, 1, 10, ''),
(47, 71, 6, 19, ''),
(46, 70, 6, 18, ''),
(45, 69, 6, 17, ''),
(44, 68, 6, 16, ''),
(43, 67, 6, 15, ''),
(42, 66, 6, 14, ''),
(41, 65, 6, 13, ''),
(40, 64, 6, 12, ''),
(39, 63, 6, 11, ''),
(38, 62, 6, 10, ''),
(37, 61, 6, 9, ''),
(36, 60, 6, 8, ''),
(35, 59, 6, 7, ''),
(34, 58, 6, 6, ''),
(33, 57, 6, 5, ''),
(32, 56, 6, 4, ''),
(31, 55, 6, 3, ''),
(30, 54, 6, 2, ''),
(29, 53, 6, 1, ''),
(51, 13, 2, 9, ''),
(52, 14, 2, 8, ''),
(53, 15, 2, 6, ''),
(54, 16, 2, 7, ''),
(55, 17, 2, 5, ''),
(56, 18, 2, 3, ''),
(57, 19, 2, 1, ''),
(58, 20, 2, 2, ''),
(69, 22, 3, 3, ''),
(68, 21, 3, 2, ''),
(66, 72, 2, 4, ''),
(63, 74, 1, 2, ''),
(64, 75, 1, 4, ''),
(65, 76, 1, 6, ''),
(70, 23, 3, 4, ''),
(71, 24, 3, 5, ''),
(72, 25, 3, 6, ''),
(73, 26, 3, 7, ''),
(74, 27, 3, 8, ''),
(75, 2, 4, 1, ''),
(76, 3, 4, 2, ''),
(77, 4, 4, 3, ''),
(78, 5, 4, 4, ''),
(79, 6, 4, 5, ''),
(80, 101, 5, 1, ''),
(81, 102, 5, 2, ''),
(82, 103, 5, 3, ''),
(83, 104, 5, 4, ''),
(84, 105, 5, 5, ''),
(85, 106, 5, 6, ''),
(86, 107, 5, 7, ''),
(87, 108, 5, 8, ''),
(88, 109, 5, 9, ''),
(89, 110, 5, 10, ''),
(90, 111, 5, 11, ''),
(91, 112, 5, 12, ''),
(92, 113, 5, 13, ''),
(93, 114, 5, 14, ''),
(94, 115, 5, 15, ''),
(95, 116, 5, 16, ''),
(104, 125, 1, 5, ''),
(97, 118, 5, 18, ''),
(98, 119, 5, 19, ''),
(99, 120, 5, 20, ''),
(100, 121, 5, 21, ''),
(101, 122, 5, 22, ''),
(102, 123, 5, 23, ''),
(103, 124, 5, 24, ''),
(105, 128, 8, 1, ''),
(106, 129, 8, 2, ''),
(107, 130, 8, 3, ''),
(108, 131, 8, 4, ''),
(109, 132, 8, 5, ''),
(110, 133, 8, 6, ''),
(111, 134, 8, 7, ''),
(112, 135, 8, 8, ''),
(113, 136, 8, 9, ''),
(114, 137, 8, 10, ''),
(115, 138, 8, 11, ''),
(116, 139, 8, 12, ''),
(117, 140, 8, 13, ''),
(118, 141, 8, 14, ''),
(119, 142, 8, 15, ''),
(120, 143, 8, 16, ''),
(121, 144, 8, 17, ''),
(122, 145, 8, 18, ''),
(123, 146, 8, 19, ''),
(124, 147, 8, 20, ''),
(125, 148, 8, 21, ''),
(126, 149, 8, 22, ''),
(127, 150, 8, 23, ''),
(128, 151, 8, 24, ''),
(129, 152, 8, 25, ''),
(130, 153, 8, 26, ''),
(131, 154, 8, 27, ''),
(132, 155, 8, 28, ''),
(133, 156, 8, 29, ''),
(134, 157, 8, 30, ''),
(135, 158, 8, 31, ''),
(136, 159, 8, 32, ''),
(137, 160, 8, 33, ''),
(138, 161, 8, 34, ''),
(139, 162, 8, 35, ''),
(140, 163, 8, 36, ''),
(141, 164, 8, 37, ''),
(142, 165, 8, 38, ''),
(143, 166, 8, 39, ''),
(144, 167, 8, 40, ''),
(145, 168, 8, 41, ''),
(146, 169, 8, 42, ''),
(147, 170, 8, 43, ''),
(148, 171, 8, 44, ''),
(149, 172, 8, 45, ''),
(150, 173, 8, 46, ''),
(151, 174, 8, 47, ''),
(152, 175, 8, 48, ''),
(153, 176, 8, 49, ''),
(154, 177, 8, 50, ''),
(155, 178, 8, 51, ''),
(156, 179, 8, 52, ''),
(157, 180, 8, 53, ''),
(158, 181, 8, 54, ''),
(159, 182, 8, 55, ''),
(160, 183, 8, 56, ''),
(161, 184, 8, 57, ''),
(162, 185, 8, 58, ''),
(163, 186, 8, 59, ''),
(164, 187, 8, 60, ''),
(165, 188, 8, 61, ''),
(166, 189, 8, 62, ''),
(167, 190, 8, 63, ''),
(168, 191, 8, 64, ''),
(169, 192, 8, 65, ''),
(170, 193, 8, 66, ''),
(171, 194, 8, 67, ''),
(172, 195, 8, 68, ''),
(173, 196, 8, 69, ''),
(174, 197, 8, 70, ''),
(175, 198, 8, 71, ''),
(176, 199, 8, 72, ''),
(177, 200, 8, 73, ''),
(178, 201, 8, 74, ''),
(179, 202, 8, 75, ''),
(180, 203, 8, 76, ''),
(181, 204, 8, 77, ''),
(182, 205, 8, 78, ''),
(183, 206, 8, 79, ''),
(184, 207, 8, 80, ''),
(185, 208, 8, 81, ''),
(186, 209, 8, 82, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gbook`
--

CREATE TABLE IF NOT EXISTS `gbook` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=146 ;

--
-- Daten für Tabelle `gbook`
--

INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES
(1, 0, '2007-01-02 23:36:44', 'David Däster', 'dfd1985@gmail.com', 'www.jclub.ch', 'Hallo Leute.\r\nGut Weile will dauer haben. Und nun ist es endlich da.\r\nDie neue Seite ist online. Fehler sind möglich, bitte meldet sie per Email an mich oder Simon.', '1. Eintrag', 0),
(2, 0, '2007-01-03 00:06:17', 'Reine Chefasche (Bebu)', 'fieserfettsack_@hotmail.com', '', 'Auso nachdäm dasi da die letschte Iiträg  so gläse ha, hani dänkt, da müess mau wieder öppis "ganz Schlaus" ine, drum hani dänkt, da müess i mi drum kümmere... :-Q\r\nNei seich, i wünsche euch ganz e guete Rutsch is nöie Jahr, tüet geng schön artig, fouget öichem usgsproche nätte JG-Leiter immer ganz guet, und de git das es ganz es guets 07. :-D\r\n\r\nFür au di wo regumässig id JG chöme, ir erschte Wuche nach de Ferie (12. Jan) geseh mer üs wieder, für aui angere.... chömet denn ou! Auso dämfau ! Rütschet guet und de bis im 07!\r\n*dance* *dance* *dance* *dance* *dance*', 'Kopie vom alte Gästebuech...', 0),
(3, 0, '2007-01-03 11:17:37', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hallo Leute\r\n\r\nGut habt ihr das hingekriegt. Sieht toll aus. Danke schon mal im Voraus für eure geleistete Arbeit!\r\nGruss \r\n\r\nvom Scheff persönlich', 'Ja, hallo erstmaaaaal....', 0),
(4, 3, '2007-01-03 12:00:09', 'Administrator', 'admin@jclub.ch', 'www.jclub.ch', 'Merci für d''Blueme...\r\nMir si ou chli stolz druf ;)', '', 0),
(5, 0, '2007-01-03 13:27:04', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Hei Jungs\r\n\r\nGseht würkläch guät us. \r\n\r\nNo ä Frag ä nöggi: Wieso schribsch du Hochdeutsch?\r\n\r\nAuso no e schönä..\r\n\r\nSalüüü', 'Persönlicher Eintrag Nummer 1', 0),
(6, 5, '2007-01-03 13:31:15', 'Hans Holunder alias Bebu', 'fieserfettsack_@hotmail.com', '', 'Das geit di absolut agr nüt a!!!\r\n\r\nDas blibt mis Gheimnis...', '', 0),
(7, 5, '2007-01-03 18:55:01', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Da das e chrischtlächi Sitä isch machis jetz nid, aber du weisch welä Finger das jetzt däheim hätsch gseh gäu ;-)', '', 0),
(8, 0, '2007-01-04 15:09:26', 'Ändu', 'andreasallemann@gmx.ch', '', 'I gse vouer stouz die neuei site. Das luegt auso scho angersch us aus die auti site.\r\n\r\nFrage: Cha me do keini sooo coooooli Smilies me mache wie im aute Gästebuech?', 'Bravo!!!', 0),
(9, 0, '2007-01-04 15:48:32', 'Rebi', 'dietrich.rebekka@hotmail.com', '', 'hey!\r\nmir gfout die page ou mega guet!\r\ns wartä het sech ächt gLohnt!\r\ni hoffä dir siget aui guet is nöiä johr gschtartet und bis gLiiii\r\n', 'aLoha!', 0),
(10, 0, '2007-01-04 16:30:16', 'Surli', 'Surli87@gmx.ch', '', 'Wow he, mega genial heit dir die Homepage gmacht!!\r\nEs riise Lob a die Person wos gmacht het!!\r\nNachträglech wünschi euch aune es ganzes guets neus Jahr, Gottes riiche Säge und e ganze gueti Zyt!!\r\nBye bye Soraya', 'Achtung Surli chunnt ;-)', 0),
(11, 10, '2007-01-04 16:43:12', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Es si mehreri Personoä gsi...', '', 0),
(12, 8, '2007-01-04 19:31:34', 'Administrator(en)', 'dfd1985@gmail.com', 'www.nowayback.ch.vu', 'Nei, no nid. Aber wird no cho.\r\nJe nach däm wie stark i mues schaffe halt scho früecher oder halt chli später.\r\nD''Smily-Codes wärde aber witgehend die gliche blibe, evnt. gits de o es paar neui ;)', '', 0),
(13, 0, '2007-01-04 19:52:28', 'Barbara (die besseri Heufti (Schwöster) vom BORN)', 'barbara_born@hotmail.com', 'www.artchicks.ch.vu', 'Hallo zäme\r\nHa uf die Site gfunge und dänkt i schribe doch grad mou öbbis ine! Und das uf BÄRNdütsch! Schöni Homepage und hebit nech Sorg!\r\nLiebs Grüessli\r\nBarbara', 'Schöni HP', 0),
(14, 13, '2007-01-04 19:59:29', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Isch ja schliesslech dr schönscht Dialäkt!!', '', 0),
(15, 0, '2007-01-07 14:53:13', 'Marco', 'marco.flueck@ggs.ch', 'www.jesus.ch', 'Lüdi dini Komentär si witzig und närvig zuglich! (als VW verstoh -verwirrender Witz) ;-O', 'Lüdi!!!', 0),
(16, 0, '2007-01-07 14:58:27', 'Marco', 'marco.flueck@ggs.ch', 'www.jesus.ch', 'Hey das Programm gseht cooooooool und vieeeeeeeeeelversprächend us!!!! :):):)\r\n', 'Wunderbars Programm', 0),
(17, 15, '2007-01-09 18:42:26', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', '..das isch ja wohl die gröschti afigöörei gsi...', '', 0),
(18, 16, '2007-01-09 18:43:27', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Hesch vom Bebu öppis angers erwartet??? he? he?\r\n\r\nsägs numä!', '', 0),
(19, 15, '2007-01-09 19:45:27', 'Marco', 'marco.flueck@ggs.ch', 'www.jesus.ch', 'Jo i bi i dere Sach a dr vorderschter Front :)', '', 0),
(20, 15, '2007-01-10 19:39:47', 'Kommentarschreiber (Lüdi)', 'Lukas.Schlaepfer@gmx.ch', '', '...I cha ou eifach nüm schribä oder!! Mueschs numä sägä!!... ;-)', '', 0),
(29, 28, '2007-01-16 22:51:39', 'DD', 'admin@jclub.ch', '', 'Tja, cheut ja e Schatzsuechi mache... wär het zuerscht Schnee gfunde ;)\r\nNei Seich, do gäbs z.B.: Badi, Usflug, Wandere, u.a.', '', 0),
(30, 28, '2007-01-16 22:56:31', 'BB', 'barbara_born@hotmail.com', '', 'Wellness weekend :)\r\n(nid auzu ärnst näh chume nid mit isch darum nume e idee gsi)\r\n(und DD was du chasch cha i ou ;)', '', 0),
(31, 28, '2007-01-16 22:56:41', 'Der Kommentarschreiber (Lüdi)', 'Lukas,Schlaepfer@gmx.ch', '', 'die Organsation he..tztzt... zwichtigschtä isch mau wieder vergässä gangä...', '', 0),
(32, 28, '2007-01-17 13:29:48', 'Räphu', 'waeili@gmx.ch', 'www.scb.ch', '"Badi" Im Winter?\r\n"Usflug" Ähmmm... du meinsch chli ir Gägend umänang fahrä? \r\n"Wandere" Wo ja sooo beliebt isch bi 13-18 jährigä Lüt... \r\n"u.a." Ja?', '', 0),
(33, 28, '2007-01-17 14:21:46', 'DD', 'dfd1985@gmail.com', 'www.jclub.ch', 'Ja, Badi... z.B. Hallebad. Ha ja nid gseit "Freibad".\r\nUsflug... z.B. bi Visp go luege?\r\nWandere... ja, ok, es Argumänt, aber immerhin e vorschlag.\r\nTja, u süsch e Graasschlacht (da es ja so viel Schnee het), süsch irgend öbis (nei, Lüdi, nid XBox)...', '', 0),
(34, 28, '2007-01-17 15:12:33', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'hesch rächt Dästi... XBox 360 nämläch..', '', 0),
(35, 28, '2007-01-17 18:51:26', 'Räphu', 'waeili@gmx.ch', 'www.scb.ch', 'Ja okay, Däschter, scho chli konkreter! ;) Aber unger "Badi" verschta ig persönlech haut äs Freibad - was aber eventuell a mim Dialäkt chönt ligä!? Und Visp... weiss gar nid ob die überhoupt schpilä, ig ga uf jedä Fau a SCB-Mätsch am Samschti^^', '', 0),
(28, 0, '2007-01-16 22:43:11', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hallo zusammen!!!!\r\n\r\nWie ihr vielleicht gesehen habt ist der Schnee nicht mehr geworden. Wir müssen also schon mal für ein Alternativprogramm schauen! Wenn ihr eine Idee habt, meldet euch doch baldmöglichst, denn mit dem Skifahren wird es sehr wahrscheinlich nichts werden... leider!\r\n\r\nGruss und eine schöne Woche\r\n\r\n\r\nBebu', '!!! Ski - Weekend !!!', 0),
(36, 28, '2007-01-17 21:05:04', 'Jöggu', 'dschalk@gmail.com', 'www.realnet.ch', 'Is hauebad wär scho nid schlächt. Aber dr Ganz Tag lot sich so au nid lo fülle...\r\nund Wandere... naja. Ha scho bessers ghört.\r\nAber e Vorschlag han ig glich no:\r\nme chönt doch dr Döggelichschte mittnäh :D\r\n', '', 0),
(37, 28, '2007-01-17 21:14:01', 'Räphu', 'waeili@gmx.ch', 'www.scb.ch', '"me chönt doch dr Döggelichschte mittnäh" Genialä Vorschlag! :-D Mir müesse di eifach ufs Dach bingä, de bringä mer nä vilech inä. Wüu fürä Töggelichaschtä wärs z schad. Isch das guet?^^', '', 0),
(38, 28, '2007-01-18 17:54:28', 'öhm... Jöggu?', 'ha_se_vergässe@kei_ahnig.ch', 'www.keine_ahnung.ch', 'Hmm. Das mit em ufs Dach binde isch gar kei so schlächti Idee. Aber chlei ufwändig. Und de müese mir no einisch meh Bätte, dass dr Töggelichaschte die Fahrt überstoht... \r\nBesseri Idee:\r\nMe chönt doch e Lan-Party mache^^ :D', '', 0),
(39, 28, '2007-01-19 14:15:13', 'Räphu', 'waeili@gmx.ch', 'www.scb.ch', 'Du hesch nid richtig gläsä, Jöggu. Ig wot DI ufs Dach bingä, äbä nid dr Töggälichaschtä!', '', 0),
(40, 28, '2007-01-22 18:47:25', 'Ändu', 'andreasallemann@gmx.ch', '', 'Jo i glaube, das mitem töggelichaschte het sich erledigt... dört wo mer gse si, hets jo scho eine gha:-)\r\n\r\nI muess auso säge: ES isch sooo meeegaa guet gsi, es hät glaub fasch nid besser chönne si süsch nöime...', '', 0),
(41, 0, '2007-01-25 16:30:05', 'Marco', 'marco.flueck @ggs.ch', '', 'Findi toll, dass dir so vili Kommentär schribend, drum hani jetz mol wieder en Nachricht gschribe =)\r\n=) =) (i hoffe, mi verstoht, was i möcht sägä; e Tipp: das isch Doppelironie)', 'Nachricht', 0),
(42, 0, '2007-01-31 20:15:12', 'Rebi', 'dietrich.rebekka@hotmail.com', '', 'hey!\r\nja us öisem ski-weekend isch Leidr nix wordä...\r\nabr isch gLich haMmr xi! fröiä mi scho uf das wucheänd, wird sichr widr cooL!\r\nschönä obä no und e gsägneti zyt', 'weekends', 0),
(43, 41, '2007-02-01 19:01:27', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Ja isch guet Marco mir schribä witerhin Kommentär :-)', '', 0),
(44, 42, '2007-02-01 19:04:20', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'weekends? fröiä mi scho uf das wucheänd?\r\n\r\nhani irgendöppis verpasst?\r\n\r\n\r\nlouft i-öppis vor JG us dä Fritig? i ha drum kei ahnig.. ', '', 0),
(45, 42, '2007-02-01 21:07:45', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Auso ha grad dr Befäu vom Bebu übercho euch morn ä Fium abzlah...\r\n\r\ni-ei Kömodie hets gheissä!\r\n\r\ndämfau bis morn...', '', 0),
(46, 0, '2007-02-04 14:53:02', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hallo Lütlis!!\r\n\r\nI hoffe es isch aues klar bi öich? \r\nBi mir scho... I bi im Momänt no in Dütschland, chume aber am FR morge wieder id Schwiz.\r\n\r\nUnd i würd a däm FR (9.2.) gärn e sone Abättigsabe mache wie am FR vo üsem "SKI - Weekend". I weiss, dass Ferie si, aber viu gö ja nid furt. Chömet doch möglechscht aui und säget, oder schribet echli wär das aus würd cho. S`Ziu söu si, dasmer eifach richtigi id Gägewart vo Gott chöi cho und Gott eso richtig dörfe erläbe. Würd mi mega fröie we ganz viu würde cho. \r\n\r\nDas Ganze würd um 19.30 Uhr gstartet wärde (Band wes geit 2 Std ender) und när sötti none "Folieschieber" ha, wesech öpper beruefe würd füehle....\r\n\r\nAuso Lüt häbet no ganz e schöne SO und hoffentlech bis am nächschte FR (schribet doch is Gäschtebuech ob der chömet oder so und ladet no ganz viu Lüt i!!!)\r\n\r\nBis denn!\r\n\r\nBebu', 'FR 9. Februar: Abättigs - Abe!!!', 0),
(47, 46, '2007-02-05 12:55:29', 'Räphu', 'waeili@gmx.ch', 'www.scb.ch', 'Auso ig weiss no gar nid, obi denn überhoupt umä bi oder nid. Tendenziell wirdi äuä nid chönnä cho. Aber definitiv isch no nüt!', '', 0),
(48, 46, '2007-02-05 21:23:07', 'Surli', 'Surli87@gmx.ch', '', 'Hy Bebu e mega geniali Idee, i luege emau obi denne frei bechumme!! Wäri scho dr Hammer!\r\nWenni frei ha, chummi au wider emau!!\r\nU danke no, dassd au a mi dänkt hesch bim Mail verschicke!!\r\nVillech bis glii!!', '', 0),
(49, 46, '2007-02-05 22:08:50', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Bin dabei! Folieschriber übernimmi ou..', '', 0),
(50, 46, '2007-02-06 00:06:42', 'Rebi', 'dietrich.rebekka@hotmail.com', '', 'aso i würd ou mega gärn cho!\r\ni hoffä mou i cha ou...', '', 0),
(51, 46, '2007-02-06 11:34:20', 'Simon', 'simon_@gmx.net', 'http://www.nikodemus.net', 'Bi debi\r\nFröi mi', '', 0),
(52, 46, '2007-02-06 19:22:41', 'Dani', 'sherlock@gmx.ch', '', 'Jo e Schlagzüger hesch.', '', 0),
(53, 46, '2007-02-07 01:23:53', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Das tönt Super Giele! Ladet no es paari i!!!\r\n(I hoffe mi Flüger chunt rächtzitig a....)\r\nDas git e geniali Sach! Bis denn Ladies! I fröie mi scho sehr öich wieder z`gseh!!!!!\r\nGruess and have a nice Night!\r\n\r\nBebu', '', 0),
(54, 0, '2007-02-10 21:43:15', 'Surli', 'Surli87@gmx.ch', '', 'Hy Hallo Zäme,\r\n\r\nMir hets gester am Abe mega gfaue!!\r\nEs isch eifach esooo schön, weme Gägewart vo Gott immer wider neu darf erfahre!!\r\nMi hets sone fridleche Abe dünkt, aui si fröhlech gsi, guet gluunt und es het eifach passt!!\r\nDoch i wet au ganz klar am Beni und dr Band danke säge, dass dir immer so flissig am üebe sit für d`Jg, dass dir euch Zyt nämet, zum üs ine Lobpriszyt inne z füehre!!\r\nMerci veu mau und i wet au grad es Lob us spräche, dir machet das sehr guet, es tönt richtig guet!!\r\nAu dis Klavier spile Beni, absolut guet mach numme witer so!!\r\nKlar i ha früeh hei müesse, doch i ha ebe au wider gschaffet!!\r\n\r\nAuso, bis glii wider emau! Gottes Säge!!', 'DANKE !', 0),
(55, 54, '2007-02-11 00:05:58', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Auso ich cha da numä bistimmä!\r\n\r\nSuper sach!!\r\n\r\nund wie guät die Folie si ufgleit worde... sennsationel.. hehehhe :-)', 'Dein Titel', 0),
(56, 54, '2007-02-11 17:37:07', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Fröit mi, dases öich gfaue het. I hoffe de angere ou...\r\nCool bisch wieder mau cho Soraya! Es fröit mi immer sehr weni auti oder nöii Gsichter gseh! aber natürlech ou die ', 'Dein Titel', 0),
(57, 54, '2007-02-11 17:39:43', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Nei, wäg dene doofe Zeiche isch jetz mi haub Iitrag wäg! I ha nume no wüue säge: i has ganz e tolle abe gfunge. cool, dass dir aui sit cho und chömet doch wieder mau. I dänke mir si ufeme guete Wäg vorwärts z`gah.\r\nI wünsche nech ganz e guete Wuchestart und Gottes Säge bi auem!\r\n\r\nBebu', 'Dein Titel', 0),
(58, 54, '2007-02-11 23:04:38', 'Rebi', 'dietrich.rebekka@hotmail.com', '', 'hey\r\naso i has ou ächt hammr gfundä am fritig!\r\nsit eifacht e supr band,me xeet richtig wiä viu fröid as es öich macht!\r\nbis gLi widrmou\r\nRebi', 'Dein Titel', 0),
(59, 0, '2007-02-15 23:19:43', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hey Lütlis!\r\n\r\nI bis wiedermau! \r\nD`Ferie gö für viu langsam z`Ändi und es geit wieder i grau Schueuautag. I wünsche dene wo das betrift de wieder e guete Start.\r\nMorn ire Wuche isch ja bekanntlech Worship - Night. Chömt wieder ganz zauriich und ladet no viu, viu... Lütlis, Verwandti, Bekannti, Eutere, Nachbare, etc. i. Das git e super Sach!\r\n\r\nAuso, es schöns Weekend, e guete Start i di nöii Wuche und de gseht me sech am FR wieder!\r\n\r\nGruess \r\n\r\nBebu', 'Worship - Night vom 23. Februar', 0),
(60, 59, '2007-02-25 21:07:50', 'Ig', 'Surli87@gmx.ch', '', 'Hy Bebu, i ha a euch dänkt letscht Fritig... wäri au gern cho numme i ha ebe NONI Ferie!!\r\nAber glii!!\r\nI hoffe dir heits guet gha??\r\n\r\nOk hebet e gueti Zyt und e ganze gueti Wuche!!\r\nMir wärde enang sicher glii wider emau gseh u süsch Bebu gäu, amne Mändig im Gäupark trifft me sech sicher wider emau a;-)!!\r\nBye and tschüss', 'Dein Titel', 0),
(61, 59, '2007-02-26 12:50:39', 'öber anders', 'dfd1985@gmail.com', 'www.jclub.ch', 'Wär isch dr Ig?', 'Dein Titel', 0),
(62, 59, '2007-02-26 19:28:05', 'e dritte', 'marco.flueck@ggs.ch', '', 'Wär isch dr öpper anders?', 'Dein Titel', 0),
(64, 59, '2007-02-27 22:09:59', 'Ig', 'Surli87@gmx.ch', '', 'Tja, dr ig bi ebe IG!!\r\n\r\nIg säuber weisch... numme IG!!', 'Dein Titel', 0),
(65, 59, '2007-02-28 12:10:06', 'öper anders', 'dfd1985@gmail.com', 'www.jclub.ch', 'Hmm... dr Ig dönt ganz nach Surli. ;)', 'Dein Titel', 0),
(66, 59, '2007-02-28 16:32:49', 'nomou öbr', 'dietrich.rebekka@hotmail.com', '', 'dänkä ou,dass si dr Ig isch...', 'Dein Titel', 0),
(67, 59, '2007-02-28 20:17:42', 'e dritte', 'marco.flueck@ggs.ch', 'www.jesus.ch', 'Vergiss es, dass si alli 3 dr Lüdi!', 'Dein Titel', 0),
(68, 59, '2007-02-28 21:27:28', 'öber anders', 'dfd1985@gmail.com', '', 'an "e dritte":\r\nNei, da cha ig di als öber anders beruhige, dass sicher nid alli dr Lüdi si.\r\nDenn I bi nid dr Lüdi', 'Dein Titel', 0),
(69, 59, '2007-03-02 23:52:35', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Scho guet oder... we öpper ä scheiss macht is eifach mau dr Lüdi... i ha scho verschtangä. aber nur so näbäbi... ig schribä öpper und nid öber..\r\n\r\naber scho guät heits probiert... dr IG isch zu 100 % ds Soraya', 'Dein Titel', 0),
(70, 59, '2007-03-02 23:58:19', 'Lüdi', 'Lukas,Schlaepfer@gmx.ch', '', 'und ig schribä angers und nid anders. und ä drittä und nid e dritte. Und ou nid nomou öbr sondern nomou öpper...tja...dir söttet doch mi diäläkt mit minä äs ös und üs afa kennä... aber scho guät :-)', 'Dein Titel', 0),
(71, 59, '2007-03-05 22:45:11', 'Ig', 'Surli87@gmx.ch', '', 'Auso nei, wiso muess immer dr Lüdi hi ha??\r\nDr IG isch 100% nid dr Lüdi!!\r\n\r\nRatet numme chli witer, villech chömmet dir einisch vo säuber druf!!', 'Dein Titel', 0),
(72, 59, '2007-03-06 22:14:58', 'Admin', 'admin@jclub.ch', 'www.jclub.ch', 'Ig, bzw. Surli bzw Soraya, di Name isch scho lang glüftet. Lueg dr Bitrag vo dene Date/Zyte ah:\r\n\r\n28.02.2007 12:10\r\n28.02.2007 16:32\r\n02.03.2007 23:52\r\n\r\nE bweiss tritte i hie aber zum Schutz vor Spammer nid ah.', 'Dein Titel', 0),
(73, 59, '2007-03-17 19:45:51', 'IG', 'Surli87@gmx.ch', '', 'Hihihi, ja eh bis ig!\r\n\r\nNmme das wäg de Date het no lang nüt z`säge!!\r\nOk, i wünschenech ganz es schöns Weekend und e gueti gsägneti Zyt!\r\nBye bye Surli;-)', 'Dein Titel', 0),
(74, 0, '2007-03-21 08:28:08', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hey Lütlis!\r\n\r\nAm FR gö mer ja bekanntlech wieder mau ufd Strass. Für aui die wo letschte FR nid si derbi gsi hie no es paar Infos. Mir würde nis (die wo chöi) uf die haube 6e im JG - Ruum träffe. We der das nid geit oder zfrüe isch, de chunsch am Beschte eifach id Golgass (Migros, Coop). Mir gö drum so früeh wüu mer wüsse, dass um die Ziit no meh Lüt uf der Strass si aus ersch ab de haube 8e. \r\nWed ersch uf die haube 8e chasch cho, de chasch i JG Ruum ga. Denn uf die Ziit wette mer wieder zrüg si. Anschliessend wei mer die Aktion uswärte, Idrück ustuusche und de süsch no öppis angers mache. \r\nOK, alles klar? Für Frage schicket mer es Mail oder es SMS! \r\n\r\nGruess und es schöns Tägli!\r\n\r\nBebu', 'Servant Evangelism', 0),
(75, 74, '2007-04-04 07:25:16', 'Lüdi', 'Lukas.Schlaepfer@coop.ch', '', 'So.. ou dä Servant Evangelism isch wieder verbi...\r\n\r\nEs witers mau hets so viu Jungi gha, das mer eifach nid aui hei chönnä asprächä :-)\r\nImmerhin hani öppä 10 Flyer verteilt. 7 dervo a Räphu und a Andu, 2 a einä wo vom Andu scho 5 het übercho und no einä eim, woni ha müässä überschnurrä nä überhoupt mitznä...\r\nAber der Fium när isch guät gsi :-D\r\n\r\nA Aui diä wo hättä chönnä cho, aber glich nid si cho: Schämet näch!\r\n\r\nGruess Lüdi', 'Dein Titel', 0),
(77, 0, '2007-05-28 10:02:31', 'Simon', 'simon_@gmx.net', 'www.livenet.ch', 'Höi zäme\r\nWünsche euch no nachträglech no tolle Pfingste, hoffe dir heit es guets Wucheänd gha. Bi mir isches ämu e so :-)\r\nIg hoffe, die vor Jungschi wärde no trocke nach dem nasse Lager.\r\nJedefaus wünschi euch no e schöne Wuche, wär toll weme sech nöchst Fritig gseht (-> Bibelauslegung heute)\r\nGrüessli', 'Pfingsten & Grüessli', 0),
(88, 81, '2007-06-26 20:07:14', 'Jonöggu', 'schalk.lpd@gmx.ch', 'www.jungschi-bauschtu.ch.vu', 'Was het är gseit gha? I weis es cho nümme (Ironie!!!)', 'Dein Titel', 0),
(81, 0, '2007-06-03 20:49:39', 'Marco', 'marco.flueck@ggs.ch', '', 'Hey, Bibelauslegung heute isch voll cool gsi!\r\nHa mou vili Büecher gseh, wo me no chönnti brueche.\r\nUnd Volksbibel isch voll luschtig! :)\r\nE schöni Woche allne', 'Bibelauslegung heute', 0),
(82, 0, '2007-06-15 06:57:57', 'Schukas Läpfer', 'Lüdikas@work.ch', 'www.schaff.jetzt', 'So Jungs und Mädels\r\nHa dänkt ig müäsi da mau wieder öppis inäschribä.\r\n\r\nDa i aber gar nid weiss was, bini hiemit ou scho wieder am Ende.\r\n\r\nBis hüt em Abe he....\r\n\r\ncu', 'Hoooooooooooooooooooooooooooooooooi', 0),
(83, 81, '2007-06-15 07:00:25', 'Lüdi', 'Lukas.Schlaepfer@coop.ch', '', 'Scho ja! Und denket immer dra, was der vorem Bibuuslegä müässt machä. Dr Flück het das dütläch gseit ;-) mehrmals ;-)', 'Dein Titel', 0),
(84, 77, '2007-06-15 07:01:48', 'Lüdi', 'Lukas.Schlaepfer@coop.ch', '', 'Merci. Wünsch i der ou... nachträgläch ;-)', 'Dein Titel', 0),
(85, 0, '2007-06-18 07:25:43', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Hey Jclubler und Jclublerinnä\r\n\r\nAuso ig wünschä euch scho mau schöni Feriä, wüu ig vorrussichtläch die nächschte 3 mau nüm cha cho. Evt. chumi nächscht mau no, aber eher nid. und nach dene 3 Mau si eh grad Ferie.\r\n\r\nAuso he schribet chli meh is Gästebuäch inä, ou wes numä scheiss isch :-)\r\n\r\nSchöni Zit Jungs und Mädels\r\n\r\nSalüüü', 'Schöni Feriä ;-)', 0),
(86, 0, '2007-06-18 20:42:31', 'Marco', 'marco.flueck@ggs.ch', '', 'Hey Lüdi; Was du chasch nümme cho. Saublöd, säg i do numme. Hoffe trotzdämn i gseh di nöchscht Fritig!', 'Lüdi nit do?', 0),
(87, 0, '2007-06-23 09:30:18', 'Simon', 'simon_@gmx.net', 'www.besj.ch', 'He Lüdi\r\nAuso würkech, jetzt bisch eifach gester is Wallis abghoue, auso so öppis, ts,ts....\r\nJedefaus wünschi dir glich schöni Ferie\r\nBye\r\n', 'Auso Lüdi', 0),
(92, 87, '2007-07-06 15:35:50', 'Lüdi', 'Lukas.Schlaepfer@coop.ch', '', 'Ig chume de hüt glich no mit...\r\n\r\nUnd Feriä ha ig armi Sau nid :-( i schaffe dr ganz lieb lang Summer dürä.. bis i \r\nHerbst...derfür fliesst ändläch ändläch richtig Gäud id Kasse <--- für mini Verhäutniss richtig Gäud meini :-D\r\n\r\n', 'Dein Titel', 0),
(93, 86, '2007-07-06 15:36:35', 'Lüdi', 'Lukas.Schlaepfer@coop.ch', '', 'Ig cha jetzt glich wieder....', 'Dein Titel', 0),
(94, 87, '2007-07-09 19:44:57', 'Jonöggu', 'dschalk@gmail.ch', '', 'Ooooooooooooh, dr Lüdi het mit sim Lehrlingslohn nid gnue ;)\r\n\r\nBisch en arme :D\r\n\r\nUnd i chume erscht is 2. Lehrjohr. Isch zwar scho nid grad dr hufe wo me verdient, aber es längt, wür i meine...', 'Dein Titel', 0),
(95, 0, '2007-07-14 00:51:59', 'Administrator', 'dfd1@gmx.net', 'www.jclub.ch', 'Lang isch es här, jetzt si si ändlich do...\r\nDie Smilies! *hopses*.\r\nJa, mir wüsse, es het duret, aber endlich si si ja da. :-D\r\nU wehe, sie gfalle euch nid *fire*\r\n*ironie*', 'Endlich Smilies', 0),
(96, 0, '2007-07-18 20:23:56', 'Marco', 'marco.flueck@ggs.ch', '', 'Hey die Smilies sio voll cool!\r\n*thanks*\r\n*respect*', 'Smilies', 0),
(97, 96, '2007-07-20 13:30:12', 'Administrator', 'dfd1@gmx.net', 'www.jclub.ch', '*pc**pc*Bitte, Bitte  *dance*', 'Dein Titel', 0),
(98, 0, '2007-07-20 22:41:51', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Das dr Administrator näbscht dä Chinobsüäch überhoupt no het Zit gha zum Smilies ibouä isch eh erstunläch :-D   	*thumbsup*', 'Admin & Smilie', 0),
(99, 98, '2007-07-20 22:45:02', 'Admin', 'admin@jclub.ch', '', 'Tja, Admins si halt so komischi Lüt wo mängisch trotz weni Zyt viel Zyt hei, u hankerum trotz viel Zyt kei Zyt...:-D\r\nDas isch ir Sach vor Natur bi dene Admins.\r\nSo, nochli *pc* *pc*', 'Dein Titel', 0),
(100, 0, '2007-08-04 20:39:50', 'Hansli Holunderli', 'mein@e-mail.ch', 'www.meine.hp', 'Mein Text\r\n\r\n:D\r\n\r\n\r\nSo, nur damit der Staub mal wieder weggewischt wird ;)\r\n\r\nUnd noch einen schlauen Text:\r\n\r\nPhantasie ist wichtiger als Wissen, denn Wissen ist begrenzt.\r\nDas, wobei unsere Berechnungen versagen, nennen wir Zufall.\r\nOrdnung braucht nur der Dumme, das Genie beherrscht das Chaos.\r\nDer Mensch erfand die Atombombe, doch keine Maus der Welt würde eine Mausefalle konstruieren.\r\n\r\nAlbert Einstein\r\n\r\n\r\n', 'Mein Titel', 0),
(101, 100, '2007-08-04 20:41:16', 'Hansli Holunderli', 'mein@e-mail.ch', 'www.meine.hp', 'Um Meine Identität nicht zu verbergen:\r\nJDD', 'Dein Titel', 0),
(102, 100, '2007-08-05 17:38:12', 'Admin', 'admin@jclub.ch', '', 'Spammer!! *fire**fire*\r\n:-D:-D', 'Dein Titel', 0),
(103, 100, '2007-08-06 20:15:53', 'terbla nietsnie', 'hallo.10.orangutan@a-bc.net', '', 'Dieser Text gefällt mir am besten:\r\n"Der Mensch erfand die Atombombe, doch keine Maus der Welt würde eine Mausefalle konstruieren."\r\nTrotzdem, lieber Holunderli, muss ich dem Admin recht geben, ist wirklich ein bisschen spammerhaft. \r\nHat nicht viel mit dieser Seite zu tun.\r\nDamit dies bei mir nicht der Fall wird, möchte ich mein Beitrag mit folgenden Worten abschliessen:\r\n"Hey Lüt, ig fröi mi uf die nöchschti JG, wo hoffentlech gli chunt"\r\n', 'Dein Titel', 0),
(104, 0, '2007-08-16 20:34:56', 'Marco', 'marco.flueck@ggs.ch', '', 'Wär isch äch dr nietse irgendwer? I weiss immer noni!', 'Identitätsproblem', 0),
(105, 104, '2007-08-17 17:33:36', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'dr Albert einstein', 'Dein Titel', 0),
(106, 104, '2007-08-22 17:32:56', 'Marco', 'marco.flueck@ggs.ch', '', 'Aha*thanks*', 'Dein Titel', 0),
(107, 104, '2007-08-31 11:12:19', 'Marco', 'marco.flueck@ggs.ch', '', 'e=mchoch2?', 'Dein Titel', 0),
(108, 104, '2007-09-01 00:43:14', 'Admin', 'admin@jclub.ch', '', 'Bessere Schreibweise: e=mc^2\r\nAber im Prinzip genau der.', 'Dein Titel', 0),
(109, 98, '2007-09-19 11:17:14', 'Co-Programmer', 'simon_@gmx.net', '', 'Es git haut so Globis, wo am Admin sini Sache muesse mache  *pc*', 'Dein Titel', 0),
(110, 0, '2007-10-07 17:22:28', 'Simon', 'simon_@gmx.net', 'www.besj.ch', 'Greez mitenand\r\nHa mou dänkt, ig chönt das Gästebuch wieder e chli ufpeppe. Ig möcht de Jungschi es ganz tolls Lager wünsche im schöne Jura. Hoffe, dir händ super Wätter. Denn wünschi dene wo süsch no Ferie händ e tolli Wuche und aune dene wo schaffe (inkl. mir) vöu Chraft zum Durehaute bis zum nöchste Wucheend ;-). Hoffe, meh gseht sech ir nöchste JG wieder, duret aber leider no echli', 'Es ist Oktober', 0),
(111, 0, '2007-10-23 20:29:36', 'Marco Flück', 'marco.flueck@ggs.ch', '', 'Findi e tolli Idee, dass mou is Gästebuech schribsch!*respect*\r\nA allne andere ou en Ufruf zum meh Benutze und no e gsägneti Woche!*thumbsup*', 'Toll!!!', 0),
(112, 0, '2007-12-01 00:07:50', 'Simon', 'simon_@gmx.net', 'www.besj.ch', 'Herzlich Willkommen im Dezember\r\nEs ist schon lange her seit dem letzten Eintrag. Es ist ein bisschen schade, dass niemand im November etwas geschrieben hat. Tja,was solls. Die Zeiten ändern sich.\r\nWie wie meisten Wissen, gibt es nächsten Freitag (7. Dezember) keine JG, dafür geht am 14. Dezember die Party los. Bebu wird dann sicher noch mehr dazu sagen.\r\nIch wünsche euch Gottes Segen, bis zum nächsten Mal\r\n', 'Es ist Dezember', 0),
(113, 0, '2007-12-04 15:03:11', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hallo zusammen!\r\n\r\nWie Siomon bereits geschrieben hat und wie man dem JG - Programm entnehmen kann, findet nächsten FR (7.12.) keine JG statt. Dafür steigt dann am 14. eine grosse Party!\r\nIhr habt die Gelegenheit bis Ende Woche mir eure Wünsche und Anliegen für die Fete mitzuteilen (am liebsten via E-Mail bitte! Nciht ins Gästebuch!).\r\n\r\nBis dahin wünsche ich euch allen eine gute Zeit und Gottes Segen!\r\n\r\nLG\r\n\r\nBebu\r\n\r\nIm Mittelpunkt der Feier soll Jesus stehen, denn wegen ihm feiern wir ja auch Weihnachten. Ich bin aber sehr offen und hoffe sehr auf gute (und umsetzbare) Vorschläge! ', 'FR 14. 12. Partytime!!!!', 0),
(114, 0, '2007-12-21 16:48:53', 'Joelle, Seline, Simone', 'seline.stalder@ggs.ch', '', 'Jeh,endlich ferie mir wünsche aune, wo au ferie hei, schöni täg und vüu gschänkli a dr WIEHNACHT ;-) hehe   ', 'Gruess von Seline,Joelle und Simi a aui', 0),
(115, 0, '2007-12-25 22:25:07', 'Jonas', 'dschalk@gmail.ch', '', 'Salü Zäme\r\n\r\nMir mache am Silvester nach langem hin u här glich no es Fescht. \r\nDa no nüt Vorbereitet isch, si mer uf d Hilf vo aune Agwise... D.H. dass dir öi Ideene oder Wünsch chöit als Comment a füege, oder mir es Mail schriibe...\r\n\r\nI dänke, we jede 1 Idee abgit, de chöi mer scho vei chlei öppis zäme mache.\r\n\r\nFyret no schön und bis am 31.12.\r\n\r\nGod bless you all\r\n\r\nJonas\r\n\r\nP.S. Zyt und gnaueri Infos wird i no do ineschriibe. \r\nAm beschte lueget dr eifach au 5 min do dri und schriibet am beschte no grad öppis...', 'Silvester/Neujahr', 0),
(116, 0, '2007-12-28 21:32:29', 'Simon Däster', 'simon.daester@gmx.ch', 'www.besj.ch', 'Hoi zäme\r\nIg hoffe, dir heit schöni Wiehnachte gha und freuet öich ufs Silverster, denn es louft öppis. D Jonas hets jo scho atönt. Leider si vo üchere Site keni Ideene cho, aber es wird glich lustig.\r\nMir wäre froh, weme sech bis am Sunntig  amäudet entweder bim Dani (Nat. 079 685 15 64) oder bi mir (Nat. 079 339 21 31 / email: simon.daester [ät] gmx.ch oder rächts ufe link E-mail klicke).\r\nDir dörft natürlech gärn Fründe und Kollege mitnäh, wäre aber froh, wenn die ou agmäudet wärde', 'Silversterparty', 0),
(117, 116, '2007-12-30 00:39:52', 'Simon Däster', 'simon.daester@gmx.ch', 'www.besj.ch', 'S''Programm grob zämegfasst:\r\nMäntig, 31.12.07\r\n19.00 Abschlussgottesdienst ir ref. Chile\r\n20.00 Apèro, Quatsche,...\r\nbis Mitternacht: es tolls Programm, es wird sicher nid längwilig\r\n23:59 -\r\nZischtig, 1.1.08\r\n		- 00:01 Johreswächsu, Astosse, chline Imbiss.\r\n		\r\nWär wott duremache, darf das härzlech\r\n\r\nMitnäh muesst der e gueti Lune, Schlofsack (faus dir weit pfuse, für Schlofmöglechkeite isch gsorgt).\r\nKoste: Da s''Ässe nid gratis isch, "kostet" die Sach pro Person 5.- Fr.\r\n\r\nWenn no witeri Froge si, cha sech mäude oder do im Gästebuech e Kommentar abgäh.\r\n\r\ngby\r\nSimon', '', 0),
(119, 116, '2007-12-31 12:00:11', 'Sheriff', 'marco.flueck@ggs.ch', 'www.besj.ch', 'Cooli Sach-i chume', 'Dein Titel', 0),
(120, 0, '2008-01-01 14:17:12', 'Simon', 'simon.daester@gmx.ch', 'www.besj.ch', 'Tschau zäme\r\nIg hoffe, dir sit aui guet grütscht. Party isch cool gsi, trinke hets sicher gnue gäh (voraum Rimus) und Apèro und Zmorge si super gsi. Mir händ üse Spass gha, Päch für die wo nid cho si.\r\nTrotzdäm: Euch aune es super 2008, me gseht sech\r\ngby\r\nSimon', 'Silvesterparty', 0),
(121, 120, '2008-01-25 16:37:31', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', '', 'Chuck Norris!', 'Dein Titel', 0),
(122, 85, '2008-06-27 14:35:49', 'doris', 'doris078@gmail.com', 'www.free-sex-films-gay.net', 'Ich finde den Aufbau der Seite sehr gut. Macht weiter so.\r\n', 'Dein Titel', 0),
(123, 0, '2008-08-23 12:08:16', 'Simon', 'gbook.20.orangutan@spamgourmet.com', 'www.besj.ch', 'Sodeli, mal wieder etwas Kommentar von meiner Seite.\r\nSit gester isches bekannt: JG gits jetzt numme au 2 Wuche. Dr Beni (und hoffentlech ou anderi :-) ) erhoffe sech debi e besseri Qualtiät. \r\n*thumbsup*\r\nS''Ziel isch, meh *fire* (Füür) i üsem Läbe zha, Inputs ghöre, wo mir wärde :-O (stune)oder *confused* (vewirrt si)\r\nFür das bruchts öich ;-) zum bätte, denn ohni GOTT louft nüt!\r\nZum Schluss am Beni no es riese längs *thanks**thanks**thanks**thanks**thanks**thanks**thanks**thanks**thanks*', 'Wo bleibt ihr', 0),
(124, 123, '2008-08-24 03:13:12', 'Lüdi', 'Lukas.Schlaepfer@gmx.ch', 'www.meinehp.ch', 'Chuck Norris!', 'Dein Titel', 0),
(125, 123, '2008-08-28 13:56:56', 'Dave', 'dfd1985@gmail.com', '', 'Naja, u süsch no öbis mit em Carlos Ray Norris Jr.?*ironie*', 'Dein Titel', 0),
(126, 123, '2008-09-03 13:50:38', 'Lüdi', 'Lukas.Schlaepfer@coop.ch', '', 'Dr Chuck Norris schläft nicht mit einem Revolver unter seinem Kissen, er schläft mit einem Kissen unter seinem Revolver.', 'Dein Titel', 0),
(127, 0, '2008-09-04 08:20:17', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hey Lütlis!\r\n\r\nI hoffe öich geits aune guet??? Morn isch ja wieder JG!!! I hoffe es chöme möglechscht viu vo öich wieder - wär cool! Es wird sicher e gute Abe wärde! Auso mini liebe Lüt! Häbet es schöns Tägli & de gseht me sech hoffentlech morn!!!\r\n\r\nLiebi Grüess\r\n\r\n\r\nBebu', 'Hallo Leute!!! --- Morgen ist wieder JG!!! --- Bit', 0),
(128, 127, '2008-09-07 21:05:37', 'Räphu', 'alpha.lpd@gmx.ch', '', 'Sehr idrückleche Obe gsi, super gmacht Beni\r\n\r\nChuck Norris', 'Dein Titel', 0),
(129, 0, '2008-09-11 09:40:21', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hey Lütlis! I gseh, da louft wieder mau chli öppis im Gästebuech (danke Räphu für di Iitrag!), das isch cool! I freue mi scho ufe nächscht Abe. Es isch vou supi, dasme jetz richtig merkt, dass hie öppis abgeit und i bi überzügt, dass das no meh und meh Forme anäh wird und mir ou immer meh veränderet wärde dür Gott. Isch Hammer sit dir aui derbi! We mer jetz no aui e chli apacke und enang ungerstütze, de wird aus no einisch genialer! Auso - liebi Lütlis! Mi gseht sech morn ire Wuche. I hoffe dir sit au derbi???? Es wird wieder super Abe wärde! Gottes Säge für euch und e gueti Wuche! Liebi Grüess: Bebu', 'Ich freue mich auf euch!', 0),
(130, 127, '2008-09-19 07:29:50', 'Chuck Norris', 'Chuck.Norris@roundhousekick.com', 'www.findchucknorris.com', 'Kopier mi nid!\r\n\r\nChuck Norris und Superman haben mal gegeneinander gewettet. Der Verlierer musste von da an seine Unterhosen über den Hosen tragen.', 'Dein Titel', 0),
(131, 0, '2008-09-22 15:46:32', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hey Leute!\r\n\r\nIch hoffe es geht euch allen gut?\r\n\r\nWie bereits angekündigt findet am MI (24.9. um 20.00 Uhr) "Bibel aktuell" statt. Ich werde dort sein an Stelle von Alfred, der eine Weiterbildung besucht. Es wäre cool, wenn der eine oder die andere auch kommen würde.\r\nwir werden einem kurzen Bibelabschnitt auf den Grund gehen. Ich würde mich sehr freuen, wenn jemand kommen würde.... sonst fühle ich mich sooo alleine (:-))!!!\r\n\r\nAlso bis hoffentlich MI!\r\n\r\nMacht''s gut und Gottes fetten Segen für diese Woche!\r\n\r\n\r\nLiebe Grüsse\r\n\r\nBebu', 'Am MI isch um 20:00 "Bibel - aktuell" - kommt doch', 0),
(132, 0, '2008-09-22 15:46:34', 'Lüdi', 'duon@harrypotter-fans.de', '', 'Hoi Hoi Hoi\r\n\r\nAlles klar?\r\nAuso bi mir scho... Wieder ä cooli JG gsi, ou weni nid sehr viu ha mitübercho. Jetzt womer numä no jedä 2. Fritig hei, chönnt mä ja nächscht Fritig (26.09.08) mau Pokere?\r\n\r\nAuso he schöne Tag no und dänket dra:\r\nUri Geller verbiegt Löffel, Chuck Norris verbiegt Uri Geller.\r\n\r\nWeder ou gärn wieder mau würdet Pokere, so schribet doch is GB oder churz es SMS :D\r\n\r\nlg\r\nLüdi', 'Hoi', 0),
(133, 132, '2008-09-23 11:43:21', 'Hansi Anhai', 'Hansi@gmx.ch', '', 'I gseh, dr Adrang isch riiiisig :D', 'Dein Titel', 0),
(134, 132, '2008-09-24 20:43:19', 'Räphu Däster', 'alpha.lpd@gmx.ch', '', 'OK cool bi debie\r\nZit 19:30 wie immer dänk?\r\n\r\nCu', 'Dein Titel', 0),
(135, 132, '2008-09-24 20:46:40', 'Ig', 'dschalk@gmail.com', 'keineHP', 'Merke:\r\nDr Dani het am Fr. Geburi!\r\nüberföuetne mit SMS :-D\r\n\r\nZudäm chum i gärn a poker-obe um chlei dr blöffer cho usehänge...', 'Dein Titel', 0),
(136, 132, '2008-09-24 20:48:54', 'Jönu', 'dschalk@gmail.com', '', 'PS: ^\r\n    ¦\r\n\r\nwas me: Jonas', 'Dein Titel', 0),
(137, 132, '2008-09-24 23:17:22', 'Dani', 'sherlock@gmx.ch', '', 'Salü Zäme\r\n\r\nIg chume ou und gwünne aues!!!! :-D\r\n\r\nWie si d''Regle scho wider.......*confused*', 'Dein Titel', 0),
(138, 132, '2008-09-26 17:33:17', 'Hansi', 'marco.flueck@ggs.ch', '', 'I chume ou aber mache sicher nid das Sch...Spiel *confused*', 'Dein Titel', 0),
(139, 0, '2008-09-28 20:37:26', 'Dr echt IG', 'Surli87@gmx.ch', '', 'Tschou Zäme,\r\n\r\nZerst emau, wär heisst sit nöiem genau gliich wie ebe IG??\r\nQAuso nei he... MI NAME!!\r\nDoch cool heissisch au Ig:-)\r\n\r\nLütlis wie geits euch??\r\nHanech scho uuuuu lang nümme gseh:-(\r\nMau dr Dani natürlech:-D!!!!!!!!\r\n\r\nI hoffe i finge glii wider emau Zyt zum euch cho z`Bsueche;-) wäri geniau wider emau mit euch cho Gott lobe und priise *dance* !!\r\n\r\nAuso, hebet no ne hammer *hopses* gueti Zyt u Gottes riiche Säge!\r\n', 'Bsuech vom IG !!!!!!!!!!!!!!!!!!!!!', 0),
(140, 0, '2008-11-23 17:15:39', 'Surli', 'Surli87@gmx.ch', '', 'Jööö Lütlis, heit dir aui kei Zyt meh zum schribe?\r\nDr letscht Itrag isch ja au vo mir u scho uuuu mega lang här:-(', 'Hy sit dir aui usgstorbe??', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mailto`
--

CREATE TABLE IF NOT EXISTS `mailto` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Daten für Tabelle `mailto`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `members`
--

CREATE TABLE IF NOT EXISTS `members` (
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

INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES
(1, 'Benjamin Schläpfer', 'Bebu', '1982-03-06', 'Forever you', 'JG, Musizieren, Sport', 'Lassagne', 'Student an der STH Basel', 'What Would Jesus Do??', 'fieserfettsack_@hotmail.com', ''),
(4, 'Lukas Schläpfer', 'Lüdi', '1987-09-19', 'Lord I lift your name on high', 'Gamen, JG, PC, Sport', 'Lassagne', 'kaufmännischer Angestellter (in Ausbildung)', '-', '', ''),
(6, 'Simon Däster', 'Simon', '1989-01-25', 'The days of Elijah', 'JS, JG, PC, Freundin, Musik', '', 'Schüler', '', '', ''),
(7, 'Daniel Schenk', 'Dani', '1989-09-26', '-', 'Klettern, Jungschar', '-', 'Polymechaniker (in Ausbildung)', '-', '', ''),
(8, 'Marco Flück', 'Marco', '1989-12-14', '-', 'Jungschar, Ping-Pong, JG, Skifahren', '-', 'Schüler', '-', '', ''),
(10, 'Anna Gasser', 'Anna', '1991-03-21', 'Chönig vo mim Härz', 'lesen, in der Natur sein, Musik hören', 'Lasagne', '', '-', '', ''),
(11, 'Samuel Bader', 'Sämi', '1991-10-09', 'sick and tired', 'Fussball, Hockey, PC, JG', 'Schnipo', 'Schüler', '-', '', ''),
(12, 'Raphael Däster', '&alpha; (Alpha)', '1991-12-24', 'Awesome God', 'Sport, JG, Jungschi', 'Lasagne', 'Schüler', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_ID` int(11) NOT NULL auto_increment COMMENT 'Jetzt weisi wär du bisch',
  `menu_topid` int(11) NOT NULL default '0' COMMENT 'Stohsch wieder über de andere',
  `menu_position` int(11) NOT NULL default '0' COMMENT '"Die Ersten werden die LETZTEN sein" ',
  `menu_name` text collate utf8_unicode_ci NOT NULL COMMENT 'Sgit besseri Näme',
  `menu_page` int(11) NOT NULL default '0' COMMENT 'Gang mou dört go sueche!',
  `menu_pagetyp` enum('mod','pag') collate utf8_unicode_ci NOT NULL default 'mod' COMMENT 'Machts e Unterschie?!?',
  `menu_shortlink` enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  `menu_image` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `menu_modvar` varchar(45) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Wotsch no öppis mitgäh?!?',
  `menu_display` enum('0','1') collate utf8_unicode_ci NOT NULL default '1' COMMENT 'Wotsch mi gseh?!?',
  PRIMARY KEY  (`menu_ID`),
  KEY `menu_topid` (`menu_topid`),
  KEY `menu_page` (`menu_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=79 ;

--
-- Daten für Tabelle `menu`
--

INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_shortlink`, `menu_image`, `menu_modvar`, `menu_display`) VALUES
(25, 0, 1, 'Home', 5, 'pag', '0', '', '', '1'),
(26, 0, 3, 'Über uns', 35, 'pag', '0', '', '', '1'),
(33, 0, 7, 'Gästebuch', 1, 'mod', '0', '', '', '1'),
(44, 0, 5, 'Programm', 12, 'pag', '0', '', '', '1'),
(40, 0, 8, 'Gallery', 3, 'mod', '0', '', '', '1'),
(41, 0, 100, 'image', 4, 'mod', '0', '', '', '0'),
(42, 0, 4, 'Mitglieder', 5, 'mod', '0', '', '', '0'),
(43, 0, 3, 'News', 6, 'mod', '0', '', '', '1'),
(45, 42, 1, 'Gott kann reden', 4, 'pag', '0', '', '', '1'),
(46, 42, 0, 'Members', 5, 'mod', '0', '', '', '1'),
(47, 26, 2, 'Unsere Visionen', 6, 'pag', '0', '', '', '1'),
(48, 47, 1, 'Nachfolge', 7, 'pag', '0', '', '', '1'),
(49, 47, 2, 'Anbetung', 8, 'pag', '0', '', '', '1'),
(50, 47, 3, 'Gemeinschaft', 9, 'pag', '0', '', '', '1'),
(51, 47, 4, 'Evangelisation', 10, 'pag', '0', '', '', '1'),
(52, 47, 5, 'Dienerschaft', 11, 'pag', '0', '', '', '1'),
(53, 26, 1, 'Interview', 2, 'pag', '0', '', '', '1'),
(54, 44, 1, 'JG-Programm - Übersicht', 12, 'pag', '0', '', '', '1'),
(77, 26, 0, 'Geschichte unserer JG', 35, 'pag', '0', '', '', '1'),
(78, 0, 0, 'Captcha_bild', 7, 'mod', '0', '', '', '0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `modules_file` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  `modules_status` enum('on','off') collate utf8_unicode_ci NOT NULL default 'on',
  `modules_template_support` enum('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
  `modules_mail_support` enum('no','yes') collate utf8_unicode_ci NOT NULL default 'no',
  `modules_mail_table` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `modules_mail_columns` tinytext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_file`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `modules`
--

INSERT INTO `modules` (`modules_ID`, `modules_name`, `modules_file`, `modules_status`, `modules_template_support`, `modules_mail_support`, `modules_mail_table`, `modules_mail_columns`) VALUES
(1, 'gbook', 'gbook.class.php', 'on', 'yes', 'yes', 'gbook', 'gbook_ID,gbook_name,gbook_email'),
(3, 'gallery', 'gallery.class.php', 'on', 'yes', 'no', '', ''),
(4, 'image_send', 'image_send.class.php', 'on', 'no', 'no', '', ''),
(5, 'members', 'members.class.php', 'off', 'yes', 'yes', 'members', 'members_ID,members_name,members_email'),
(6, 'news', 'news.class.php', 'on', 'yes', 'yes', 'news', 'news_ID,news_name,news_email'),
(7, 'captcha_image', 'captcha_image.class.php', 'on', 'no', 'no', '', ''),
(9, 'mailmodule', 'mailmodule.class.php', 'on', 'yes', 'no', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE IF NOT EXISTS `news` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `news`
--

INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES
(1, 0, '2007-01-02 22:53:52', 'Administrator', 'mail@jclub.ch', 'http://www.jclub.ch', 'So, die neue Seite ist online.\r\nHabt Nachsicht falls noch irgendwelche Fehler auftreten und meldet es uns.', '1. Newseintrag', 0),
(2, 0, '2008-11-04 23:30:17', 'Admin', 'admin@jclub.ch', 'www.jclub.ch', 'Sorry für die lange downtime der Webseite. :-(Ich habe es schlichtweg erst dieses Wochenende bemerkt, und der Hauptentwickler ist momentan in den grünen Ferien. :-O\r\n\r\n\r\nJetzt sollte es wieder funktionieren.:-)\r\n\r\n*thanks* für eure Geduld.', 'Webseite wieder on', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `smilies`
--

CREATE TABLE IF NOT EXISTS `smilies` (
  `smilies_ID` int(11) NOT NULL auto_increment,
  `smilies_sign` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `smilies_file` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`smilies_ID`),
  UNIQUE KEY `smilies_sign` (`smilies_sign`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Daten für Tabelle `smilies`
--

INSERT INTO `smilies` (`smilies_ID`, `smilies_sign`, `smilies_file`) VALUES
(2, ':-)', 'smile.gif'),
(3, ':-D', 'bigsmile.gif'),
(4, '*angel*', 'angel.gif'),
(5, '*confused*', 'confused.gif'),
(6, '*dance*', 'dance.gif'),
(7, '*disco*', 'disco.gif'),
(8, '*eager*', 'eager.gif'),
(9, '*fire*', 'fire.gif'),
(10, '*hops*', 'hops.gif'),
(11, '*hopses*', 'hopses.gif'),
(12, '*ironie*', 'ironieattention.gif'),
(13, ':-O', 'mouthopen.gif'),
(14, '*pc*', 'pc.gif'),
(15, '*respect*', 'respect.gif'),
(16, '*roll*', 'roll.gif'),
(17, '*thanks*', 'thanks.gif'),
(18, '*thumbsup*', 'thumbsup.gif'),
(19, '*thumb*', 'thumbup.gif'),
(20, ':-p', 'tongue.gif'),
(21, ':-Q', 'smoke.gif'),
(22, ':)', 'smile.gif'),
(23, ':D', 'bigsmile.gif'),
(24, ':p', 'tongue.gif'),
(25, ':Q', 'smoke.gif'),
(26, ':O', 'mouthopen.gif'),
(27, ';-)', 'wink.gif'),
(28, ';)', 'wink.gif'),
(29, ':-(', 'sad.gif'),
(30, ':(', 'sad.gif');
