-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 26. Juni 2007 um 21:26
-- Server Version: 5.0.37
-- PHP-Version: 5.2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Datenbank: `jclubbeta`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `smilies`
-- 

DROP TABLE IF EXISTS `smilies`;
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

INSERT INTO `smilies` VALUES (2, ':-)', 'smile.gif');
INSERT INTO `smilies` VALUES (3, ':-D', 'bigsmile.gif');
INSERT INTO `smilies` VALUES (4, '*angel*', 'angel.gif');
INSERT INTO `smilies` VALUES (5, '*confused*', 'confused.gif');
INSERT INTO `smilies` VALUES (6, '*dance*', 'dance.gif');
INSERT INTO `smilies` VALUES (7, '*disco*', 'disco.gif');
INSERT INTO `smilies` VALUES (8, '*eager*', 'eager.gif');
INSERT INTO `smilies` VALUES (9, '*fire*', 'fire.gif');
INSERT INTO `smilies` VALUES (10, '*hops*', 'hops.gif');
INSERT INTO `smilies` VALUES (11, '*hopses*', 'hopses.gif');
INSERT INTO `smilies` VALUES (12, '*ironie*', 'ironieattention.gif');
INSERT INTO `smilies` VALUES (13, ':-O', 'mouthopen.gif');
INSERT INTO `smilies` VALUES (14, '*pc*', 'pc.gif');
INSERT INTO `smilies` VALUES (15, '*respect*', 'respect.gif');
INSERT INTO `smilies` VALUES (16, '*roll*', 'roll.gif');
INSERT INTO `smilies` VALUES (17, '*thanks*', 'thanks.gif');
INSERT INTO `smilies` VALUES (18, '*thumbsup*', 'thumbsup.gif');
INSERT INTO `smilies` VALUES (19, '*thumb*', 'thumbup.gif');
INSERT INTO `smilies` VALUES (20, ':-p', 'tongue.gif');
INSERT INTO `smilies` VALUES (21, ':-Q', 'smoke.gif');
INSERT INTO `smilies` VALUES (22, ':)', 'smile.gif');
INSERT INTO `smilies` VALUES (23, ':D', 'bigsmile.gif');
INSERT INTO `smilies` VALUES (24, ':p', 'tongue.gif');
INSERT INTO `smilies` VALUES (25, ':Q', 'smoke.gif');
INSERT INTO `smilies` VALUES (26, ':O', 'mouthopen.gif');
INSERT INTO `smilies` VALUES (27, ';-)', 'wink.gif');
INSERT INTO `smilies` VALUES (28, ';)', 'wink.gif');
INSERT INTO `smilies` VALUES (29, ':-(', 'sad.gif');
INSERT INTO `smilies` VALUES (30, ':(', 'sad.gif');
