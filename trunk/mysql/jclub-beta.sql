-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 28. Dezember 2006 um 14:46
-- Server Version: 4.1.21
-- PHP-Version: 4.3.9
-- 
-- Datenbank: `jclubch_beta`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bilder`
-- 

CREATE TABLE `bilder` (
  `bilder_ID` tinyint(4) NOT NULL auto_increment,
  `filename` varchar(200) collate latin1_general_ci NOT NULL default '',
  `height` int(11) NOT NULL default '0',
  `width` int(11) NOT NULL default '0',
  `erstellt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bilder_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=29 ;

-- 
-- Daten für Tabelle `bilder`
-- 

INSERT INTO `bilder` (`bilder_ID`, `filename`, `height`, `width`, `erstellt`) VALUES 
(2, 'ende_phase_1_01.jpg', 0, 0, '2006-07-23 01:01:45'),
(3, 'ende_phase_1_02.jpg', 0, 0, '2006-07-23 01:06:45'),
(4, 'ende_phase_1_03.jpg', 0, 0, '2006-07-23 01:07:37'),
(5, 'ende_phase_1_04.jpg', 0, 0, '2006-07-23 01:07:37'),
(6, 'ende_phase_1_05.jpg', 0, 0, '2006-07-23 01:07:37'),
(7, 'vor_umbau_01.jpg', 0, 0, '2006-07-23 01:10:06'),
(8, 'vor_umbau_02.jpg', 0, 0, '2006-07-23 01:10:06'),
(9, 'vor_umbau_03.jpg', 0, 0, '2006-07-23 01:10:06'),
(10, 'vor_umbau_04.jpg', 0, 0, '2006-07-23 01:10:06'),
(11, 'vor_umbau_05.jpg', 0, 0, '2006-07-23 01:10:06'),
(12, 'vor_umbau_06.jpg', 0, 0, '2006-07-23 01:10:06'),
(13, 'wand_1_01.jpg', 0, 0, '2006-07-23 01:10:45'),
(14, 'wand_1_02.jpg', 0, 0, '2006-07-23 01:10:45'),
(15, 'wand_1_03.jpg', 0, 0, '2006-07-23 01:10:45'),
(16, 'wand_1_04.jpg', 0, 0, '2006-07-23 01:10:45'),
(17, 'wand_1_05.jpg', 0, 0, '2006-07-23 01:10:45'),
(18, 'wand_1_06.jpg', 0, 0, '2006-07-23 01:10:45'),
(19, 'wand_1_07.jpg', 0, 0, '2006-07-23 01:10:45'),
(20, 'wand_1_08.jpg', 0, 0, '2006-07-23 01:10:45'),
(21, 'wand_2_01.jpg', 0, 0, '2006-07-23 01:11:17'),
(22, 'wand_2_02.jpg', 0, 0, '2006-07-23 01:11:17'),
(23, 'wand_2_03.jpg', 0, 0, '2006-07-23 01:11:17'),
(24, 'wand_2_04.jpg', 0, 0, '2006-07-23 01:11:17'),
(25, 'wand_2_05.jpg', 0, 0, '2006-07-23 01:11:17'),
(26, 'wand_2_06.jpg', 0, 0, '2006-07-23 01:11:17'),
(27, 'wand_2_07.jpg', 0, 0, '2006-07-23 01:11:17'),
(28, 'testbild.JPG', 0, 0, '2006-11-15 22:10:39');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `content`
-- 

CREATE TABLE `content` (
  `content_ID` int(10) NOT NULL auto_increment,
  `content_title` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  `content_text` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`content_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Daten für Tabelle `content`
-- 

INSERT INTO `content` (`content_ID`, `content_title`, `content_text`) VALUES 
(1, 'Small-Test', 'Dies ist nur ein bischen Text... wirklich nur wenig :-D'),
(2, 'Mehr Text', 'Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.'),
(3, 'Max-Text', 'Sehr viel Text<br /><br />Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online. Dies ist ein langer Text und noch Sinnloser als der untere. Die Seite ist aber auch noch nicht online.');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `gallery_alben`
-- 

CREATE TABLE `gallery_alben` (
  `ID` tinyint(4) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL default '',
  `fid_parent` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

-- 
-- Daten für Tabelle `gallery_alben`
-- 

INSERT INTO `gallery_alben` (`ID`, `name`, `fid_parent`) VALUES 
(1, 'Vor dem Umbau', 0),
(2, 'Herausnehmen der 1. Trennwand', 0),
(3, 'Herausnehmen der 2. Trennwand', 0),
(4, 'Ende der 1. Phase', 0),
(5, 'Fertigstellung', 0),
(6, 'Neujahrsfeier 05/06', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `gallery_eintraege`
-- 

CREATE TABLE `gallery_eintraege` (
  `ID` tinyint(4) NOT NULL auto_increment,
  `fid_bild` tinyint(4) NOT NULL default '0',
  `fid_album` tinyint(4) NOT NULL default '0',
  `sequence` tinyint(11) NOT NULL default '0',
  `comment` text character set latin1 collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

-- 
-- Daten für Tabelle `gallery_eintraege`
-- 

INSERT INTO `gallery_eintraege` (`ID`, `fid_bild`, `fid_album`, `sequence`, `comment`) VALUES 
(1, 7, 1, 1, ''),
(2, 8, 1, 2, ''),
(3, 9, 1, 3, ''),
(4, 10, 1, 4, ''),
(5, 11, 1, 5, ''),
(6, 12, 1, 6, '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `gbook`
-- 

CREATE TABLE `gbook` (
  `gbook_ID` int(11) NOT NULL auto_increment,
  `gbook_ref_ID` int(11) NOT NULL default '0',
  `gbook_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `gbook_name` varchar(50) collate latin1_general_ci NOT NULL default '',
  `gbook_email` varchar(50) collate latin1_general_ci NOT NULL default '',
  `gbook_hp` varchar(50) collate latin1_general_ci NOT NULL default '',
  `gbook_content` text collate latin1_general_ci NOT NULL,
  `gbook_title` varchar(50) collate latin1_general_ci NOT NULL default '',
  `gbook_smile_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gbook_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

-- 
-- Daten für Tabelle `gbook`
-- 

INSERT INTO `gbook` (`gbook_ID`, `gbook_ref_ID`, `gbook_time`, `gbook_name`, `gbook_email`, `gbook_hp`, `gbook_content`, `gbook_title`, `gbook_smile_ID`) VALUES 
(1, 0, '2006-05-21 23:06:35', 'David Däster', 'dfd1985@gmail.com', 'www.jclub.ch', 'Der 1 Eintrag im neuen GB :-D', '1. Eintrag :-D', 0),
(2, 1, '2006-05-21 23:07:02', 'Der Kommentator', '', 'www.jclub.ch', 'Und der 1. Kommentar :-P', '', 0),
(3, 0, '2006-05-22 23:57:44', 'Test', 'admin@localhost', 'www.jclub.ch', 'Noch ein Eintrag', '', 0),
(4, 1, '2006-05-22 23:57:44', 'asdf', 'adsf@asdf.com', 'www.jclub.ch', '2. Kommentar...', '', 0),
(5, 0, '2006-06-02 11:59:33', 'Hans Ueli', 'hans.ueli@hansueli.ch', 'www.hansueli.ch', 'Dr Hansueli schribt ou mol en Tescht', 'Was, sogar Titel?', 0),
(6, 5, '2006-06-02 09:59:33', 'Hans Kommentar', '', '', 'Ja, u dr Kommentar für em Hansueli si Bitrag chunt o no grad.\r\nÄtsch', '', 0),
(7, 0, '2006-07-22 12:12:07', 'Simon', 'simon.daester@jesus.ch', '', 'Neuer Kommentar', '', 0),
(8, 0, '2006-09-17 21:25:46', 'Simon Holunder', 'meineemail', '', 'Kommentar zum neusten', '', 0),
(9, 8, '2006-09-19 20:23:52', 'Simon Holunder', 'tja', '', 'Kommentar scheint toll zu klappen', '', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `guestbook`
-- 

CREATE TABLE `guestbook` (
  `name` varchar(50) collate latin1_general_ci NOT NULL default '',
  `mail` varchar(50) collate latin1_general_ci NOT NULL default '',
  `page` varchar(100) collate latin1_general_ci NOT NULL default '',
  `ort` varchar(50) collate latin1_general_ci NOT NULL default '',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `eintrag` text collate latin1_general_ci NOT NULL,
  `bild_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `guestbook`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `mailto`
-- 

CREATE TABLE `mailto` (
  `mailto_ID` int(11) NOT NULL default '0',
  `mailto_reciver_name` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `mailto_reciver_mail` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `mailto_sender_name` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `mailto_sender_mail` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `mailto_subject` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `mailto_content` varchar(255) collate latin1_german1_ci NOT NULL default '',
  `mailto_hash` varchar(32) collate latin1_german1_ci NOT NULL default '',
  PRIMARY KEY  (`mailto_ID`),
  FULLTEXT KEY `mailto_content` (`mailto_content`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- 
-- Daten für Tabelle `mailto`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `members`
-- 

CREATE TABLE `members` (
  `members_ID` int(11) NOT NULL auto_increment COMMENT 'De weisi wär du bisch',
  `members_name` varchar(50) collate latin1_general_ci NOT NULL default '' COMMENT 'Längwilig, für Bürokrate',
  `members_spitzname` varchar(50) collate latin1_general_ci NOT NULL default '' COMMENT 'Toll, zum Fertigmache',
  `members_birthday` date NOT NULL default '0000-00-00' COMMENT 'Alter schützt vor Torheit nicht',
  `members_song` varchar(100) collate latin1_general_ci NOT NULL default '' COMMENT 'Ke Musiggschmack?',
  `members_hobby` varchar(100) collate latin1_general_ci NOT NULL default '' COMMENT 'Längwilig',
  `members_food` varchar(100) collate latin1_general_ci NOT NULL default '' COMMENT 'Grusig',
  `members_job` varchar(100) collate latin1_general_ci NOT NULL default '' COMMENT 'Verdiensch so weni Cholä?',
  `members_motto` varchar(200) collate latin1_general_ci NOT NULL default '' COMMENT 'Haut di mou dra!',
  `members_mail` varchar(100) collate latin1_general_ci NOT NULL default '' COMMENT 'so läng?',
  `members_image` varchar(200) collate latin1_general_ci NOT NULL default '' COMMENT 'hesch ou scho besser usgseh',
  PRIMARY KEY  (`members_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Die Mitgliedertabelle' AUTO_INCREMENT=5 ;

-- 
-- Daten für Tabelle `members`
-- 

INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_mail`, `members_image`) VALUES 
(1, 'Benjamin Schläpfer', 'Bebu', '1982-03-06', 'Open the eyes of my heart', 'JG, Musizieren, Sport', 'Lassagne', 'Student an der STH Basel', 'What Would Jesus Do??', '', ''),
(2, 'Raphael Schläpfer', 'Wäili', '1984-01-17', 'Blessed be the name of the LORD', 'Sport, PC', 'Chinesisch', 'Drogist', '-', '', ''),
(3, 'David Däster', 'Dave', '1985-04-22', 'Watching Over You', 'JG, PC, Sport, Musik', 'Broccoli', 'Informatiker', 'Pray Until Something Happens!', '', ''),
(4, 'Lukas Schläpfer', 'Lüdi', '1987-09-19', 'Lord I lift your name on high', 'Gamen, JG, PC, Sport', 'Lassagne', 'kaufmännischer Angestellter (in Ausbildung)', '-', '', '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `menu`
-- 

CREATE TABLE `menu` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42 ;

-- 
-- Daten für Tabelle `menu`
-- 

INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_modvar`, `menu_display`) VALUES 
(25, 0, 1, 'Test1', 1, 'pag', '', '1'),
(26, 0, 2, 'Test2', 3, 'pag', '', '1'),
(27, 25, 1, 'SubTest1.1', 2, 'pag', '', '1'),
(28, 25, 2, 'SubTest1.2', 12, 'pag', '', '1'),
(29, 25, 3, 'SubTest1.3', 13, 'pag', '', '1'),
(30, 25, 4, 'SubTest1.4', 14, 'pag', '', '1'),
(31, 26, 1, 'SubTest2.1', 21, 'pag', '', '1'),
(32, 26, 2, 'SubTest2.2', 22, 'pag', '', '1'),
(33, 0, 3, 'G&auml;stebuch', 1, 'mod', '', '1'),
(34, 28, 1, 'SubTest1.2.1', 26, 'pag', '', '1'),
(35, 31, 1, 'Subtest2.1.1', 27, 'pag', '', '1'),
(36, 0, 4, 'G&auml;stebuch2', 2, 'mod', '', '1'),
(37, 34, 0, 'SubTest1.2.1.1', 1, 'pag', '', '1'),
(38, 28, 2, 'SubTest1.2.2', 1, 'pag', '', '1'),
(39, 35, 1, 'Subtest2.1.1.1', 27, 'pag', '', '1'),
(40, 0, 2, 'Gallery', 3, 'mod', '', '1'),
(41, 0, 1, 'image', 4, 'mod', '', '0');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `modules`
-- 

CREATE TABLE `modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(45) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

-- 
-- Daten für Tabelle `modules`
-- 

INSERT INTO `modules` (`modules_ID`, `modules_name`) VALUES 
(1, 'gbook.php'),
(2, 'gbook2.php'),
(3, 'gallery.php'),
(4, 'image.php');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `smilies`
-- 

CREATE TABLE `smilies` (
  `smilies_ID` int(11) NOT NULL auto_increment,
  `smilies_file` varchar(50) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`smilies_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `smilies`
-- 

