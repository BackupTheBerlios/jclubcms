-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 08. Februar 2007 um 23:59
-- Server Version: 5.0.27
-- PHP-Version: 5.2.0
-- 
-- Datenbank: `jclubbeta`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `bilder`
-- 

CREATE TABLE `bilder` (
  `bilder_ID` tinyint(4) NOT NULL auto_increment,
  `filename` varchar(200) collate utf8_unicode_ci NOT NULL default '',
  `erstellt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bilder_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=128 ;

-- 
-- Daten f�r Tabelle `bilder`
-- 

INSERT INTO `bilder` VALUES (2, 'ende_phase_1_01.jpg', '2006-07-23 01:01:45');
INSERT INTO `bilder` VALUES (3, 'ende_phase_1_02.jpg', '2006-07-23 01:06:45');
INSERT INTO `bilder` VALUES (4, 'ende_phase_1_03.jpg', '2006-07-23 01:07:37');
INSERT INTO `bilder` VALUES (5, 'ende_phase_1_04.jpg', '2006-07-23 01:07:37');
INSERT INTO `bilder` VALUES (6, 'ende_phase_1_05.jpg', '2006-07-23 01:07:37');
INSERT INTO `bilder` VALUES (7, 'vor_umbau_01.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` VALUES (8, 'vor_umbau_02.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` VALUES (9, 'vor_umbau_03.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` VALUES (10, 'vor_umbau_04.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` VALUES (11, 'vor_umbau_05.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` VALUES (12, 'vor_umbau_06.jpg', '2006-07-23 01:10:06');
INSERT INTO `bilder` VALUES (13, 'wand_1_01.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` VALUES (14, 'wand_1_02.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` VALUES (15, 'wand_1_03.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` VALUES (16, 'wand_1_04.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` VALUES (17, 'wand_1_05.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` VALUES (18, 'wand_1_06.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` VALUES (19, 'wand_1_07.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` VALUES (20, 'wand_1_08.jpg', '2006-07-23 01:10:45');
INSERT INTO `bilder` VALUES (21, 'wand_2_01.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` VALUES (22, 'wand_2_02.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` VALUES (23, 'wand_2_03.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` VALUES (24, 'wand_2_04.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` VALUES (25, 'wand_2_05.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` VALUES (26, 'wand_2_06.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` VALUES (27, 'wand_2_07.jpg', '2006-07-23 01:11:17');
INSERT INTO `bilder` VALUES (72, 'wand_1_017.jpg', '2007-01-04 01:53:15');
INSERT INTO `bilder` VALUES (29, 'jg_programm06_04_lq.jpg', '2006-12-31 18:03:02');
INSERT INTO `bilder` VALUES (71, 'photo074.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (70, 'photo073.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (69, 'photo072.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (68, 'photo071.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (67, 'photo070.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (66, 'photo069.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (65, 'photo068.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (64, 'photo067.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (63, 'photo066.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (62, 'photo065.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (61, 'photo064.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (60, 'photo063.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (59, 'photo062.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (58, 'photo061.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (57, 'photo060.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (56, 'photo059.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (55, 'photo058.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (54, 'photo057.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (53, 'photo056.jpg', '2007-01-01 04:36:19');
INSERT INTO `bilder` VALUES (112, 'photo043.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (74, 'vor_umbau_001.jpg', '2007-01-05 20:45:51');
INSERT INTO `bilder` VALUES (75, 'vor_umbau_003.jpg', '2007-01-05 20:45:51');
INSERT INTO `bilder` VALUES (76, 'vor_umbau_005.jpg', '2007-01-05 20:46:01');
INSERT INTO `bilder` VALUES (111, 'photo042.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (110, 'photo041.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (109, 'photo040.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (108, 'photo039.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (107, 'photo038.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (106, 'photo037.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (105, 'photo036.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (104, 'photo035.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (103, 'photo034.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (102, 'photo033.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (101, 'photo032.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (113, 'photo044.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (114, 'photo045.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (115, 'photo046.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (116, 'photo047.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (125, 'vor_umbau_004.jpg', '2007-01-05 21:35:18');
INSERT INTO `bilder` VALUES (118, 'photo049.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (119, 'photo050.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (120, 'photo051.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (121, 'photo052.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (122, 'photo053.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (123, 'photo054.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (124, 'photo055.jpg', '2007-01-05 21:20:42');
INSERT INTO `bilder` VALUES (126, 'programm1_07.jpg', '2007-01-06 19:24:28');
INSERT INTO `bilder` VALUES (127, 'snowcamp-flyer.jpg', '2007-01-06 19:24:28');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `content`
-- 

CREATE TABLE `content` (
  `content_ID` int(10) NOT NULL auto_increment,
  `content_title` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  `content_text` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`content_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

-- 
-- Daten f�r Tabelle `content`
-- 

INSERT INTO `content` VALUES (1, 'Willkommen', '<p>Wir begr&uuml;ssen euch herzlich auf der Seite des J-Club''s aus Balsthal-Thal.<br />\r\n    <center>\r\n       <a href="./index.php?nav_id=44"><img src="index.php?nav_id=41&thumb=29"></a>\r\n	<br />\r\n        <br />\r\n        <script src=''http://www.nikodemus.net/free.php?cart-write'' type=''text/javascript''></script>\r\n     </center>');
INSERT INTO `content` VALUES (2, '�ber uns', '<b>Wer seit ihr?</b><br />\r\nWir sind eine Gruppe junger Menschen aus verschiedenen Berufsschichten mit einem brennenden Herzen f�r Jesus.<br />\r\n<b>Und was macht ihr?</b><br />\r\nUnsere Absicht ist es, den Teenies das Evangelium auf moderne Art und Weise zu verk�nden.<br />\r\n<b>Und was macht ihr an euren Abenden?</b><br />\r\nUm den Teenies zeitgem�sse Worship-Musik bieten zu k�nnen, haben wir eine eigene JugendBand auf die Beine gestellt, welche schon an diversen Gemeindeveranstaltungen gespielt hat.\r\nDank der Gr�ndung dieser Band haben wir die M�glichkeit die JG-Abende mit Worship zu starten<br />\r\n<b>Danke f�r das kurze Interview</b><br />\r\nBitte');
INSERT INTO `content` VALUES (3, 'Programm', '<div style="margin-left:5px"><br>\r\n                  <a target="_blank" href="./index.php?nav_id=41&bild=29"><img src="./index.php?nav_id=41&bild=29" alt="JG-Programm"></a><br>\r\n  Was uns noch fehlt bist..... <b>DU</b><br></div>');
INSERT INTO `content` VALUES (4, 'Gott kann reden!', 'Ich durften in den Jahren, seit ich Nachfolger von Jesus bin, schon viele Erlebnisse mit Gott erleben. Doch DAS Erlebnis, das mich am meisten gepr�gt hat, hat sich vor ca. 2 Jahren ereignet.<br />\r\n<br>\r\nWir hatten in unserer Gemeinde wieder mal eine Versammlung �bers Vorjahr, wo �ber die Finanzen und die gesamte Gemeinde gesprochen wurde, ein Jahresr�ckblick k�nnte man sagen. Zu Beginn einer solchen Veranstaltung gab es jeweils in den Jahren zuvor einen kurzen Input, meist von einem Pastor oder �ltesten unserer Gemeinde.<br /><br />\r\n\r\nDoch drei Tage vor dieser Versammlung h�rte ich w�hrend der Arbeit Gottes Stimme, die zu mir sprach, dass ich diesen Input vorbereiten solle. Doch ich konnte mir nicht vorstellen diese Aufgabe als Jugendleiter zu �bernehmen. Ich dachte, das h�tte ich mir vielleicht selbst ausgedacht. Doch die Stimme verfolgte mich, den ganzen Tag � so gab ich schliesslich nach. Ich ging von der Arbeit nach Hause und schrieb den Input ohne dass mich vorher jemand angefragt h�tte. Am n�chsten Tag, am Tag vor der Versammlung rief mich der Pr�sident der Gemeinde an und wollte mich sch�chtern was fragen. Ich wusste genau, was er wollte und sprach zu ihm, dass ich den Input bereits vorbereitet h�tte.<br /><br />\r\n\r\nEs war ein unglaubliches Gef�hl Gottes N�he so sp�ren zu k�nnen. Das durfte ich dann auch den Leuten in der Versammlung weitergeben. Dieses Erlebnis hat mich pers�nlich sehr ber�hrt und ich habe gemerkt, dass Gott wirklich aktiv zu mir, zu dir reden kann.<br /><br />\r\n\r\n<b>Praise the Lord!</b><br />von Bebu');
INSERT INTO `content` VALUES (5, 'Unsere JG', '<p>Als Jugendgruppe \r\nsehen wir in der Bibel die Grundlage unseres Lebens. Das Wort Gottes \r\ngibt uns Anweisungen f�r unser Leben, die uns zeigen wie ein Leben \r\nin der Beziehung zu Gott aussehen kann. Damit wir aber durch die vielen \r\nAussagen der Bibel das Wesentliche nicht aus den Augen verlieren, haben \r\nwir unsere Vision und 5 Auftr�ge formuliert, die wir in die Tat umsetzen \r\nwollen. <br><br><br></p>\r\n\r\n<p><b>Unsere Vision</b> <br>\r\n</p>\r\n<p><b>�Als Jugendgruppe \r\nm�chten wir, dass die Jugendlichen unserer Region durch die Liebe Gottes \r\nver�ndert werden.�</b> <br></p>\r\n<p>Es ist unser \r\nAnliegen m�glichst viele junge Leute in unserer Region mit dem Evangelium \r\nzu erreichen, auf eine m�glichst einfache und verst�ndliche Art. </p>\r\n<p>Jesus ist f�r \r\nuns am Kreuz gestorben. ER hat f�r unsere S�nden, die wir gemacht \r\nhaben und auch heute noch machen, bezahlt. Durch seine Liebe ist es \r\nf�r uns Menschen �berhaupt m�glich geworden Ver�nderung in unserem \r\nLeben zu erfahren. So ist es unser Wunsch, dass diese Liebe, die wir \r\nt�glich erfahren d�rfen auch noch andere Menschen erfahren k�nnen \r\nund dass diese Leute dann selber zu einem Samen f�r andere Menschen \r\nwerden k�nnen. <br> <br></p>\r\n<p><i>Unsere 5 \r\nAuftr�ge, die uns helfen sollen unsere Vision Wirklichkeit werden zu \r\nlassen</i>: <br> <br></p>\r\n\r\n<p><b>Nachfolge</b> <br>\r\n</p>\r\n<p><b>�Als Jugendgruppe \r\nwollen wir immer mehr Jesus m�ssig Leben und so auch zum Licht f�r \r\nunsere Mitmenschen werden.�</b> <br></p>\r\n<p>Im Neuen Testament \r\nfinden wir in einigen Versen den Ausdruck �folge mir nach!�, den \r\nJesus spricht. Nach diesem Bild wollen wir Menschen sein, die seinem \r\nBeispiel folgen. Wir wollen immer bewusster Jesus m�ssig leben. Alle \r\nBereiche unseres Lebens sollen von IHM bestimmt werden. Als seine J�nger \r\nwollen wir Jesus nachfolgen. <br> <br></p>\r\n<p><b>Anbetung</b> <br>\r\n</p>\r\n<p><b>�Wir wollen \r\nGott anbeten und IHM die Ehre geben f�r das, was ER f�r uns getan \r\nhat.�</b> <br></p>\r\n\r\n<p>Wir wollen \r\nGott anbeten aus Dankbarkeit daf�r, dass ER seinen Sohn f�r uns hingegeben \r\nhat. Von dieser Liebe, die ER uns gegeben hat wollen wir IHM etwas zur�ckgeben. \r\nAus diesem Grund wollen wir Gott mit unserem ganzen Leben anbeten. Wir \r\nwollen IHN loben und preisen f�r seine Sch�pfung und seine Allmacht. <br>\r\n <br></p>\r\n<p><b>Gemeinschaft</b> <br>\r\n</p>\r\n<p><b>�Wir wollen \r\nuns gegenseitig in der Jugendgruppe annehmen und achten, so dass echte \r\nGemeinschaft mit Tiefgang entstehen darf.�</b> <br></p>\r\n<p>Was uns alle \r\nin der Jugendgruppe verbindet ist der Glaube an Jesus Christus. Jesus \r\nliebt jeden und jede genau gleich und so wie Jesus dies tut, versuchen \r\nauch wir einander anzunehmen und zu akzeptieren wie wir sind. </p>\r\n<p>Wir wollen \r\nmiteinander ein aktives Leben im Glauben f�hren, das Tiefgang hat und \r\nnicht nur oberfl�chlich wirkt. Auch ist der Glaube nach neutestamentlicher \r\nAuffassung keine Privatsache, wo jeder sein Christsein f�r sich lebt, \r\nsondern jeder Gl�ubige braucht den Austausch, die Gemeinschaft und \r\nden Umgang mit anderen Christen. <br> <br></p>\r\n\r\n<p><b>Evangelisation</b> <br>\r\n</p>\r\n<p><b>�Wir wollen \r\nGottes Frohe Botschaft auf eine moderne Art weitergeben, so dass auch \r\nj�ngere Menschen den Zugang zu Gott finden k�nnen.�</b> <br>\r\n</p>\r\n<p>Wir glauben \r\ndaran, dass nur ein Leben mit Jesus Sinn macht. Aus diesem Grund wollen \r\nwir, dass Menschen von der Liebe Gottes h�ren, sie aufnehmen und sich \r\nvon Gott ver�ndern lassen. Weil es uns nicht egal ist, was mit unseren \r\nMitmenschen passiert, m�chten wir ihnen als Werkzeug Gottes dienen. <br>\r\n <br></p>\r\n<p><b>Dienerschaft</b> <br>\r\n</p>\r\n\r\n<p><b>�Es ist \r\nunser Anliegen, dass Mitglieder der Jugendgruppe sich mit ihren Gaben \r\nund Talenten in der JG bzw. in der Gemeinde engagieren.�</b> <br>\r\n</p>\r\n<p>Gott hat uns \r\nALLE mit verschiedenen Gaben und Talenten ausgestattet. Mit diesen Eigenschaften, \r\nmit denen uns Gott ausgestattet hat, wollen wir Gott loben und anbeten. \r\nJeder Mensch ist einzigartig � und mit diesen F�higkeiten wollen \r\nwir Gott anbeten. Wir wollen die JG zusammen gestalten, einander unterst�tzen \r\nund uns gegenseitig dienen.</p>');
INSERT INTO `content` VALUES (6, 'Unsere Visionen', '<p><b>�Als Jugendgruppe \r\nm�chten wir, dass die Jugendlichen unserer Region durch die Liebe Gottes \r\nver�ndert werden.�</b> <br></p>\r\n<p>Es ist unser \r\nAnliegen m�glichst viele junge Leute in unserer Region mit dem Evangelium \r\nzu erreichen, auf eine m�glichst einfache und verst�ndliche Art. </p>\r\n<p>Jesus ist f�r \r\nuns am Kreuz gestorben. ER hat f�r unsere S�nden, die wir gemacht \r\nhaben und auch heute noch machen, bezahlt. Durch seine Liebe ist es \r\nf�r uns Menschen �berhaupt m�glich geworden Ver�nderung in unserem \r\nLeben zu erfahren. So ist es unser Wunsch, dass diese Liebe, die wir \r\nt�glich erfahren d�rfen auch noch andere Menschen erfahren k�nnen \r\nund dass diese Leute dann selber zu einem Samen f�r andere Menschen \r\nwerden k�nnen. <br> <br></p>\r\n<p><i>Unsere 5 \r\nAuftr�ge, die uns helfen sollen unsere Vision Wirklichkeit werden zu \r\nlassen</i>: <br> <br></p>\r\n\r\n<p><b>Nachfolge</b> <br>\r\n</p>\r\n<p><b>�Als Jugendgruppe \r\nwollen wir immer mehr Jesus m�ssig Leben und so auch zum Licht f�r \r\nunsere Mitmenschen werden.�</b> <br></p>\r\n<p>Im Neuen Testament \r\nfinden wir in einigen Versen den Ausdruck �folge mir nach!�, den \r\nJesus spricht. Nach diesem Bild wollen wir Menschen sein, die seinem \r\nBeispiel folgen. Wir wollen immer bewusster Jesus m�ssig leben. Alle \r\nBereiche unseres Lebens sollen von IHM bestimmt werden. Als seine J�nger \r\nwollen wir Jesus nachfolgen. <br> <br></p>\r\n<p><b>Anbetung</b> <br>\r\n</p>\r\n<p><b>�Wir wollen \r\nGott anbeten und IHM die Ehre geben f�r das, was ER f�r uns getan \r\nhat.�</b> <br></p>\r\n\r\n<p>Wir wollen \r\nGott anbeten aus Dankbarkeit daf�r, dass ER seinen Sohn f�r uns hingegeben \r\nhat. Von dieser Liebe, die ER uns gegeben hat wollen wir IHM etwas zur�ckgeben. \r\nAus diesem Grund wollen wir Gott mit unserem ganzen Leben anbeten. Wir \r\nwollen IHN loben und preisen f�r seine Sch�pfung und seine Allmacht. <br>\r\n <br></p>\r\n<p><b>Gemeinschaft</b> <br>\r\n</p>\r\n<p><b>�Wir wollen \r\nuns gegenseitig in der Jugendgruppe annehmen und achten, so dass echte \r\nGemeinschaft mit Tiefgang entstehen darf.�</b> <br></p>\r\n<p>Was uns alle \r\nin der Jugendgruppe verbindet ist der Glaube an Jesus Christus. Jesus \r\nliebt jeden und jede genau gleich und so wie Jesus dies tut, versuchen \r\nauch wir einander anzunehmen und zu akzeptieren wie wir sind. </p>\r\n<p>Wir wollen \r\nmiteinander ein aktives Leben im Glauben f�hren, das Tiefgang hat und \r\nnicht nur oberfl�chlich wirkt. Auch ist der Glaube nach neutestamentlicher \r\nAuffassung keine Privatsache, wo jeder sein Christsein f�r sich lebt, \r\nsondern jeder Gl�ubige braucht den Austausch, die Gemeinschaft und \r\nden Umgang mit anderen Christen. <br> <br></p>\r\n\r\n<p><b>Evangelisation</b> <br>\r\n</p>\r\n<p><b>�Wir wollen \r\nGottes Frohe Botschaft auf eine moderne Art weitergeben, so dass auch \r\nj�ngere Menschen den Zugang zu Gott finden k�nnen.�</b> <br>\r\n</p>\r\n<p>Wir glauben \r\ndaran, dass nur ein Leben mit Jesus Sinn macht. Aus diesem Grund wollen \r\nwir, dass Menschen von der Liebe Gottes h�ren, sie aufnehmen und sich \r\nvon Gott ver�ndern lassen. Weil es uns nicht egal ist, was mit unseren \r\nMitmenschen passiert, m�chten wir ihnen als Werkzeug Gottes dienen. <br>\r\n <br></p>\r\n<p><b>Dienerschaft</b> <br>\r\n</p>\r\n\r\n<p><b>�Es ist \r\nunser Anliegen, dass Mitglieder der Jugendgruppe sich mit ihren Gaben \r\nund Talenten in der JG bzw. in der Gemeinde engagieren.�</b> <br>\r\n</p>\r\n<p>Gott hat uns \r\nALLE mit verschiedenen Gaben und Talenten ausgestattet. Mit diesen Eigenschaften, \r\nmit denen uns Gott ausgestattet hat, wollen wir Gott loben und anbeten. \r\nJeder Mensch ist einzigartig � und mit diesen F�higkeiten wollen \r\nwir Gott anbeten. Wir wollen die JG zusammen gestalten, einander unterst�tzen \r\nund uns gegenseitig dienen.</p>');
INSERT INTO `content` VALUES (7, 'Nachfolge', '<p><b>�Als Jugendgruppe \r\nwollen wir immer mehr Jesus m�ssig Leben und so auch zum Licht f�r \r\nunsere Mitmenschen werden.�</b> <br></p>\r\n<p>Im Neuen Testament \r\nfinden wir in einigen Versen den Ausdruck �folge mir nach!�, den \r\nJesus spricht. Nach diesem Bild wollen wir Menschen sein, die seinem \r\nBeispiel folgen. Wir wollen immer bewusster Jesus m�ssig leben. Alle \r\nBereiche unseres Lebens sollen von IHM bestimmt werden. Als seine J�nger \r\nwollen wir Jesus nachfolgen. <br> <br></p>');
INSERT INTO `content` VALUES (8, 'Anbetung', '<p><b>�Wir wollen \r\nGott anbeten und IHM die Ehre geben f�r das, was ER f�r uns getan \r\nhat.�</b> <br></p>\r\n\r\n<p>Wir wollen \r\nGott anbeten aus Dankbarkeit daf�r, dass ER seinen Sohn f�r uns hingegeben \r\nhat. Von dieser Liebe, die ER uns gegeben hat wollen wir IHM etwas zur�ckgeben. \r\nAus diesem Grund wollen wir Gott mit unserem ganzen Leben anbeten. Wir \r\nwollen IHN loben und preisen f�r seine Sch�pfung und seine Allmacht. <br>\r\n <br></p>');
INSERT INTO `content` VALUES (9, 'Gemeinschaft', '<p><b>�Wir wollen \r\nuns gegenseitig in der Jugendgruppe annehmen und achten, so dass echte \r\nGemeinschaft mit Tiefgang entstehen darf.�</b> <br></p>\r\n<p>Was uns alle \r\nin der Jugendgruppe verbindet ist der Glaube an Jesus Christus. Jesus \r\nliebt jeden und jede genau gleich und so wie Jesus dies tut, versuchen \r\nauch wir einander anzunehmen und zu akzeptieren wie wir sind. </p>\r\n<p>Wir wollen \r\nmiteinander ein aktives Leben im Glauben f�hren, das Tiefgang hat und \r\nnicht nur oberfl�chlich wirkt. Auch ist der Glaube nach neutestamentlicher \r\nAuffassung keine Privatsache, wo jeder sein Christsein f�r sich lebt, \r\nsondern jeder Gl�ubige braucht den Austausch, die Gemeinschaft und \r\nden Umgang mit anderen Christen. <br> <br></p>');
INSERT INTO `content` VALUES (10, 'Evangelisation', '<p><b>�Wir wollen \r\nGottes Frohe Botschaft auf eine moderne Art weitergeben, so dass auch \r\nj�ngere Menschen den Zugang zu Gott finden k�nnen.�</b> <br>\r\n</p>\r\n<p>Wir glauben \r\ndaran, dass nur ein Leben mit Jesus Sinn macht. Aus diesem Grund wollen \r\nwir, dass Menschen von der Liebe Gottes h�ren, sie aufnehmen und sich \r\nvon Gott ver�ndern lassen. Weil es uns nicht egal ist, was mit unseren \r\nMitmenschen passiert, m�chten wir ihnen als Werkzeug Gottes dienen. <br>\r\n <br></p>');
INSERT INTO `content` VALUES (11, 'Dienerschaft', '<p><b>�Es ist \r\nunser Anliegen, dass Mitglieder der Jugendgruppe sich mit ihren Gaben \r\nund Talenten in der JG bzw. in der Gemeinde engagieren.�</b> <br>\r\n</p>\r\n<p>Gott hat uns \r\nALLE mit verschiedenen Gaben und Talenten ausgestattet. Mit diesen Eigenschaften, \r\nmit denen uns Gott ausgestattet hat, wollen wir Gott loben und anbeten. \r\nJeder Mensch ist einzigartig � und mit diesen F�higkeiten wollen \r\nwir Gott anbeten. Wir wollen die JG zusammen gestalten, einander unterst�tzen \r\nund uns gegenseitig dienen.</p>');
INSERT INTO `content` VALUES (12, 'Programm Januar 07 � Juli 07', '<img src="http://www.jclub.ch/index.php?nav_id=41&bild=126" alt="Programm1 07">\r\n<p><b>12. Januar</b></p>\r\n\r\n<p><i>Allianz \r\nWoche</i></p>\r\n<p>Wie letztes \r\nJahr wollen wir auch dieses Jahr an der regionalen Allianz � Gebetswoche \r\nmitmachen, um uns gegenseitig zu ermutigen und zu st�rken. <br>\r\n</p>\r\n<p><b>19. \r\n� 21. Januar</b></p>\r\n<p><i>Snowcamp \r\nin Raron (VS)</i></p>\r\n<p>Ein Wochenende \r\nzieht es uns in die sch�nen Berge ins Vallis. Nebst dem Schnee wollen \r\nwir auch die Gemeinschaft zusammen und mit Gott geniessen.</p>\r\n<p>(Anmeldung: \r\nsiehe Flyer separat!)</p>\r\n\r\n<p><b>26. Januar</b></p>\r\n<p><i>Worship \r\n� Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm. <br>\r\n</p>\r\n<p><b>2. Februar</b></p>\r\n<p><i>JG \r\n� Raum � Lifting</i></p>\r\n<p>Nachdem unser \r\nJG � Raum vorletztes Jahr gr�sstenteils renoviert worden ist, kommen \r\njetzt noch kleine Details, die dazu beitragen sollen, den JG � Raum \r\nnoch jugendfreundlicher zu gestalten. <br> <br>\r\n\r\n</p>\r\n<p><b>23. Februar</b></p>\r\n<p><i>Worship \r\n� Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm. <br>\r\n</p>\r\n<p><b>2. M�rz</b></p>\r\n<p><i>Warum dieses \r\nLeid?</i></p>\r\n<p>In der Welt \r\ngibt es so viel Trauer, so viel Leid und so viel Schmerz, aber warum? \r\nWir wollen uns mit der Frage auseinandersetzen, warum Gott das �berhaupt \r\nzul�sst.</p>\r\n\r\n<p><b>9. M�rz</b></p>\r\n<p><i>Das Gebet \r\nals m�chtige Waffe</i></p>\r\n<p>Vielmals wird \r\ndie Kraft des Gebets untersch�tzt. Aus diesem Grunde wird heutzutage \r\nvon vielen Menschen nicht mehr regelm�ssig gebetet. Wir fragen uns, \r\nwarum das so ist und was es mit der Kraft des Gebets auf sich hat. <br>\r\n</p>\r\n<p><b>16. M�rz</b></p>\r\n<p><i>Warum christliche \r\nSchriften?</i></p>\r\n<p>10 wesentliche \r\nPunkte sollen uns als Anreiz dienen, christliche Schriften an andere \r\nMenschen weiterzugeben.</p>\r\n\r\n<p><b>23. M�rz</b></p>\r\n<p><i>Servant \r\nEvangelism</i></p>\r\n<p>Was wir am \r\n16. M�rz gelernt haben wollen wir in die Tat umsetzen: Wir gehen auf \r\ndie Strasse, um den Menschen vom Evangelium zu erz�hlen. <br>\r\n</p>\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>\r\n<p><b>30. M�rz </b></p>\r\n<p><i>Worship \r\n� Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm. <br>\r\n</p>\r\n<p><b>6. April</b></p>\r\n<p><i>Wir nehmen \r\nein gemeinsames Abendmahl</i></p>\r\n<p>Passend zu \r\nOstern wollen wir ein Abendmahl zu uns nehmen wie das vor ca. 2000 Jahren \r\nder Brauch gewesen ist und uns an das erinnern, was Jesus am Kreuz f�r \r\nuns getan hat.</p>\r\n<p><b>27. April</b></p>\r\n<p><i>Worship \r\n� Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm. <br>\r\n</p>\r\n<p><b>4. Mai</b></p>\r\n<p><i>Musik in \r\nder Bibel</i></p>\r\n<p>Wir wollen \r\nuns damit befassen, welche Rolle die Musik in der bibel innehat und \r\nwelche Rolle ihr heute beigemessen wird. <br> <br>\r\n</p>\r\n<p><b>11. Mai</b></p>\r\n\r\n<p><i>Zum Christsein \r\nstehen</i></p>\r\n<p>Es f�llt nicht \r\njedem und jeder leicht in allen Situationen zum Christsein zu stehen. \r\nWir wollen uns austauschen wo Schwierigkeiten und Probleme liegen und \r\nversuchen einen Ansatz zu einer m�glichen Besserung zu finden. <br>\r\n</p>\r\n<p><b>18. Mai</b></p>\r\n<p><i>Was sind \r\nPfingstgemeinden?</i></p>\r\n<p>In der Schweiz \r\ngibt es nicht nur die Evangelisch � Reformierte und die R�misch � \r\nKatholische Kirche, sondern es gibt noch viele andere Kirchen, die sich \r\n�Freikirchen� nennen. Wir wollen uns besonders mit den �Pfingstgemeinden� \r\nauseinandersetzen.</p>\r\n\r\n<p><b>1. Juni</b></p>\r\n<p><i>Bibelauslegung \r\nheute</i></p>\r\n<p>Vielmals ist \r\ndas Bibellesen ein Frust, wenn man etwas nicht versteht. Aus diesem \r\nGrund suchen wir nach Hilfsmittel und m�glichen Hilfeleistungen, die \r\nuns das Bibellesen zur Freude machen � so dass wir die Bibel besser \r\nverstehen k�nnen.</p>\r\n<p><b>8. Juni</b></p>\r\n<p><i>Welche \r\n�Art� Christ bin ich?</i></p>\r\n<p>Christen glauben \r\nzwar dasselbe, haben aber trotzdem unterschiedliche Ansichten und Lebenseinstellungen. \r\nWir wollen herausfinden wer von uns in welche Richtung schl�gt. <br>\r\n\r\n</p>\r\n<p><b>15. Juni</b></p>\r\n<p><i>Das Internet \r\nsinnvoll nutzen</i></p>\r\n<p>Viele Jugendliche \r\nverbringen oft Stunden im Internet. Doch vielmals auf Seiten, die sie \r\nnegativ beeinflussen. Wir wollen uns mit den Angeboten an christlichen \r\nWebsites vertraut machen.</p>\r\n<p><b>22. Juni</b></p>\r\n<p><i>Die Rolle \r\nder Frau in der Bibel</i></p>\r\n<p>Viele Frauen \r\nhaben in der bibel eine wichtige rolle gespielt. Doch auch heute noch \r\ngibt es brisante Themen (Kopftuch: ja oder nein / Frauen d�rfen predigen?). \r\nWir wollen uns mit diesen Fragen auseinandersetzen und dabei die Bibel \r\nals Vorlage nehmen.</p>\r\n\r\n<p><b>29. Juni</b></p>\r\n<p><i>Worship \r\n� Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm. <br>\r\n</p>\r\n<p><b>6. Juli</b></p>\r\n<p><i>Kino</i> <br>\r\n</p>\r\n<p>Als kr�nender \r\nAbschluss vor den Schulferien besuchen wir als ganze Jugendgruppe wieder \r\neinmal das Kino</p>\r\n\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>');
INSERT INTO `content` VALUES (13, '12. Januar', '<p><i>Allianz \r\nWoche</i></p>\r\n<p>Wie letztes \r\nJahr wollen wir auch dieses Jahr an der regionalen Allianz � Gebetswoche \r\nmitmachen, um uns gegenseitig zu ermutigen und zu st�rken. <br>\r\n <br></p>');
INSERT INTO `content` VALUES (14, '19.  � 21. Januar', '<p><i>Snowcamp \r\nin Raron (VS)</i></p>\r\n<p>Ein Wochenende \r\nzieht es uns in die sch�nen Berge ins Vallis. Nebst dem Schnee wollen \r\nwir auch die Gemeinschaft zusammen und mit Gott geniessen.</p>\r\n<p>(Anmeldung: \r\nsiehe Flyer separat!) <br> <br></p>');
INSERT INTO `content` VALUES (15, '26. Januar', '<p><i>Worship \r\n� Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm. <br>\r\n <br></p>');
INSERT INTO `content` VALUES (16, '2. Februar', '<p><i>JG \r\n� Raum � Lifting</i></p>\r\n<p>Nachdem unser \r\nJG � Raum vorletztes Jahr gr�sstenteils renoviert worden ist, kommen \r\njetzt noch kleine Details, die dazu beitragen sollen, den JG � Raum \r\nnoch jugendfreundlicher zu gestalten.</p>');
INSERT INTO `content` VALUES (17, '23. Februar', '<p><i>Worship \r\n� Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm.</p>');
INSERT INTO `content` VALUES (18, '2. M�rz', '<p><i>Warum dieses \r\nLeid?</i></p>\r\n<p>In der Welt \r\ngibt es so viel Trauer, so viel Leid und so viel Schmerz, aber warum? \r\nWir wollen uns mit der Frage auseinandersetzen, warum Gott das �berhaupt \r\nzul�sst.</p>');
INSERT INTO `content` VALUES (19, '9. M�rz', '<p><i>Das Gebet \r\nals m�chtige Waffe</i></p>\r\n<p>Vielmals wird \r\ndie Kraft des Gebets untersch�tzt. Aus diesem Grunde wird heutzutage \r\nvon vielen Menschen nicht mehr regelm�ssig gebetet. Wir fragen uns, \r\nwarum das so ist und was es mit der Kraft des Gebets auf sich hat.</p>');
INSERT INTO `content` VALUES (20, '16. M�rz', '<p><i>Warum christliche \r\nSchriften?</i></p>\r\n<p>10 wesentliche \r\nPunkte sollen uns als Anreiz dienen, christliche Schriften an andere \r\nMenschen weiterzugeben.</p>');
INSERT INTO `content` VALUES (21, '23. M�rz', '<p><i>Servant \r\nEvangelism</i></p>\r\n<p>Was wir am \r\n16. M�rz gelernt haben wollen wir in die Tat umsetzen: Wir gehen auf \r\ndie Strasse, um den Menschen vom Evangelium zu erz�hlen. <br>\r\n</p>\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>');
INSERT INTO `content` VALUES (22, '30. M�rz', '<p><i>Worship \r\n� Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm.</p>');
INSERT INTO `content` VALUES (23, '6. April', '<p><i>Wir nehmen \r\nein gemeinsames Abendmahl</i></p>\r\n<p>Passend zu \r\nOstern wollen wir ein Abendmahl zu uns nehmen wie das vor ca. 2000 Jahren \r\nder Brauch gewesen ist und uns an das erinnern, was Jesus am Kreuz f�r \r\nuns getan hat.</p>');
INSERT INTO `content` VALUES (24, '27. April', '<p><i>Worship \r\n� Night</i></p>\r\n\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm.</p>');
INSERT INTO `content` VALUES (25, '4. Mai', '<p><i>Musik in \r\nder Bibel</i></p>\r\n<p>Wir wollen \r\nuns damit befassen, welche Rolle die Musik in der bibel innehat und \r\nwelche Rolle ihr heute beigemessen wird.</p>');
INSERT INTO `content` VALUES (26, '11. Mai', '<p><i>Zum Christsein \r\nstehen</i></p>\r\n<p>Es f�llt nicht \r\njedem und jeder leicht in allen Situationen zum Christsein zu stehen. \r\nWir wollen uns austauschen wo Schwierigkeiten und Probleme liegen und \r\nversuchen einen Ansatz zu einer m�glichen Besserung zu finden.</p>');
INSERT INTO `content` VALUES (27, '18. Mai', '<p><i>Was sind \r\nPfingstgemeinden?</i></p>\r\n<p>In der Schweiz \r\ngibt es nicht nur die Evangelisch � Reformierte und die R�misch � \r\nKatholische Kirche, sondern es gibt noch viele andere Kirchen, die sich \r\n�Freikirchen� nennen. Wir wollen uns besonders mit den �Pfingstgemeinden� \r\nauseinandersetzen.</p>');
INSERT INTO `content` VALUES (28, '1. Juni', '<p><i>Bibelauslegung \r\nheute</i></p>\r\n<p>Vielmals ist \r\ndas Bibellesen ein Frust, wenn man etwas nicht versteht. Aus diesem \r\nGrund suchen wir nach Hilfsmittel und m�glichen Hilfeleistungen, die \r\nuns das Bibellesen zur Freude machen � so dass wir die Bibel besser \r\nverstehen k�nnen.</p>');
INSERT INTO `content` VALUES (29, '8. Juni', '<p><i>Welche \r\n�Art� Christ bin ich?</i></p>\r\n<p>Christen glauben \r\nzwar dasselbe, haben aber trotzdem unterschiedliche Ansichten und Lebenseinstellungen. \r\nWir wollen herausfinden wer von uns in welche Richtung schl�gt.</p>');
INSERT INTO `content` VALUES (30, '15. Juni', '<p><i>Das Internet \r\nsinnvoll nutzen</i></p>\r\n<p>Viele Jugendliche \r\nverbringen oft Stunden im Internet. Doch vielmals auf Seiten, die sie \r\nnegativ beeinflussen. Wir wollen uns mit den Angeboten an christlichen \r\nWebsites vertraut machen.</p>');
INSERT INTO `content` VALUES (31, '22. Juni', '<p><i>Die Rolle \r\nder Frau in der Bibel</i></p>\r\n<p>Viele Frauen \r\nhaben in der bibel eine wichtige rolle gespielt. Doch auch heute noch \r\ngibt es brisante Themen (Kopftuch: ja oder nein / Frauen d�rfen predigen?). \r\nWir wollen uns mit diesen Fragen auseinandersetzen und dabei die Bibel \r\nals Vorlage nehmen.</p>');
INSERT INTO `content` VALUES (32, '29. Juni', '<p><i>Worship \r\n� Night</i></p>\r\n<p>Jeden letzten \r\nFR im Monat wollen wir ganz bewusst der Anbetung Gottes widmen. Eine \r\nlange Worship � Zeit, Zeugnisse und ein Input geh�ren hier zum Programm. <br>\r\n</p>');
INSERT INTO `content` VALUES (33, '6. Juli', '<p><i>Kino</i> <br>\r\n</p>\r\n<p>Als kr�nender \r\nAbschluss vor den Schulferien besuchen wir als ganze Jugendgruppe wieder \r\neinmal das Kino</p>\r\n\r\n<p><b>Wichtig! \r\nTreffpunkt: 19.00 Uhr</b></p>');
INSERT INTO `content` VALUES (34, 'Snowcamp vom 19.-21. Jan 07', '<a href="http://www.jclub.ch/index.php?nav_id=41&bild=127"><img src="http://www.jclub.ch/index.php?nav_id=41&thumb=127"></a>\r\n<h3>Hey Leute!</h3><p>\r\nIn 2 Wochen findet unser Snowcamp statt. Dann heisst�s: Ab ins Vallis! Zusammen gehen wir auf die Suche nach dem weissen Gut. Doch nicht nur skifahren, sn�ben oder schlitteln ist angesagt. Wir wollen die Zeit auch nutzen, um die Gemeinschaft untereinander zu pflegen wie auch die Beziehung zu Gott.</p><p><b>\r\nAlle, die sich bis jetzt noch nicht offiziell angemeldet haben, sollten dies so schnell wie m�glich tun!<b></p> \r\n<img src="http://www.jclub.ch/index.php?nav_id=41&bild=127">');
INSERT INTO `content` VALUES (35, 'Geschichte unserer Jugendgruppe', '<p>Wir schreiben das Jahr 2007. Genau vor 10 Jahren wurde die Jugendgruppe in Balsthal gegr�ndet. Ohne wirklich eine Ahnung zu haben, was denn genau eine Jugendgruppe so macht, wurde ich (Bebu, Leiter der JG) vom damaligen Kirchgemeindepr�sidenten (Markus Schenk) angefragt, eine solche Gruppe zu gr�nden. Ich liess mich �berreden und so kam es im Jahr 1997 zur Gr�ndung dieser JG.</p><p>\r\nDoch damit ich als Ahnungsloser nicht alleine im Schilf stehen musste, wurde ich von diversen Menschen unterst�tzt, die mir besonders zu Beginn der Gr�ndung der Gruppe eine hilfreiche St�tze waren. Insbesondere Anna D�ster, Christian Ledermann und Patrick Allemann waren es, die mir geholfen haben eine solche Jugendgruppe auf die Beine zu stellen. Doch der Anfang war alles andere als einfach, da wir uns erstmals einen Kontaktkreis aufbauen mussten. Doch nach langer Anlaufszeit war dies geschafft. Wir konnten so richtig beginnen durchzustarten�</p><p>\r\nEs vergingen 3 � 4 Jahre, da gaben mir Anna und Christian, sp�ter auch Patrick bekannt, dass sie es aus verschiedenen Gr�nden nicht mehr sehen w�rden als Leiter in der Jugendgruppe zu fungieren. So erlebte die JG eine neue Epoche, in der ich die Jugendgruppe alleine zu leiten versuchte. Inzwischen im Glauben reifer geworden traute ich mir diese Aufgabe zu. Zudem fand ich immer wieder Leute, die mich unterst�tzen. Als ich die RS zu absolvieren hatte war Daniel Joss alias Omega in der Jungschi bereit, f�r mich die Leitung zu �bernehmen. Ich war und bin auch heute noch dankbar, dass sich immer wieder Menschen f�r die Jugendgruppe investiert haben, wenn es f�r mich nicht m�glich war da zu sein.</p><p>\r\nEin paar Jahre vergingen und in der Zwischenzeit entstand in mir das Gef�hl, dass die Gruppe nicht von einer, sondern von mehreren Personen gef�hrt werden sollte. Da die treusten Mitglieder im Laufe der Jahre auch �lter geworden sind, schien mir das durchaus m�glich. So kam es dann im Jahr 2006 zur Gr�ndung des Leitungsteams, das aus Mitgliedern der JG besteht. Es ist f�r mich einerseits eine Entlastung, andererseits aber sicherlich auch eine Bereicherung f�r die j�ngeren Leitungsmitglieder zu profitieren, Erfahrungen zu sammeln als Leiter und selbst aktiv zu werden.</p><p>\r\nIch danke Gott, dass er mir und der Jugendgruppe in all den Jahren treu zur Seite gestanden ist, dass Er uns durch schwierige Zeiten durchgetragen hat, uns immer wieder Menschen geschenkt hat, die sich f�r die JG hingegeben haben. Mit Gottes Hilfe wollen wir als Jugendgruppe die n�chsten Jahre in Angriff nehmen und noch f�r viele Menschen zum Segen werden.</p>');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `gallery_alben`
-- 

CREATE TABLE `gallery_alben` (
  `ID` tinyint(4) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `fid_parent` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- 
-- Daten f�r Tabelle `gallery_alben`
-- 

INSERT INTO `gallery_alben` VALUES (1, 'Vor dem Umbau', 0);
INSERT INTO `gallery_alben` VALUES (2, 'Herausnehmen der 1. Trennwand', 0);
INSERT INTO `gallery_alben` VALUES (3, 'Herausnehmen der 2. Trennwand', 0);
INSERT INTO `gallery_alben` VALUES (4, 'Ende der 1. Phase', 0);
INSERT INTO `gallery_alben` VALUES (5, 'Fertigstellung', 0);
INSERT INTO `gallery_alben` VALUES (6, 'Neujahrsfeier 05/06', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `gallery_eintraege`
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
-- Daten f�r Tabelle `gallery_eintraege`
-- 

INSERT INTO `gallery_eintraege` VALUES (1, 7, 1, 1, '');
INSERT INTO `gallery_eintraege` VALUES (2, 8, 1, 8, '');
INSERT INTO `gallery_eintraege` VALUES (3, 9, 1, 3, '');
INSERT INTO `gallery_eintraege` VALUES (4, 10, 1, 7, '');
INSERT INTO `gallery_eintraege` VALUES (5, 11, 1, 9, '');
INSERT INTO `gallery_eintraege` VALUES (6, 12, 1, 10, '');
INSERT INTO `gallery_eintraege` VALUES (47, 71, 6, 19, '');
INSERT INTO `gallery_eintraege` VALUES (46, 70, 6, 18, '');
INSERT INTO `gallery_eintraege` VALUES (45, 69, 6, 17, '');
INSERT INTO `gallery_eintraege` VALUES (44, 68, 6, 16, '');
INSERT INTO `gallery_eintraege` VALUES (43, 67, 6, 15, '');
INSERT INTO `gallery_eintraege` VALUES (42, 66, 6, 14, '');
INSERT INTO `gallery_eintraege` VALUES (41, 65, 6, 13, '');
INSERT INTO `gallery_eintraege` VALUES (40, 64, 6, 12, '');
INSERT INTO `gallery_eintraege` VALUES (39, 63, 6, 11, '');
INSERT INTO `gallery_eintraege` VALUES (38, 62, 6, 10, '');
INSERT INTO `gallery_eintraege` VALUES (37, 61, 6, 9, '');
INSERT INTO `gallery_eintraege` VALUES (36, 60, 6, 8, '');
INSERT INTO `gallery_eintraege` VALUES (35, 59, 6, 7, '');
INSERT INTO `gallery_eintraege` VALUES (34, 58, 6, 6, '');
INSERT INTO `gallery_eintraege` VALUES (33, 57, 6, 5, '');
INSERT INTO `gallery_eintraege` VALUES (32, 56, 6, 4, '');
INSERT INTO `gallery_eintraege` VALUES (31, 55, 6, 3, '');
INSERT INTO `gallery_eintraege` VALUES (30, 54, 6, 2, '');
INSERT INTO `gallery_eintraege` VALUES (29, 53, 6, 1, '');
INSERT INTO `gallery_eintraege` VALUES (51, 13, 2, 9, '');
INSERT INTO `gallery_eintraege` VALUES (52, 14, 2, 8, '');
INSERT INTO `gallery_eintraege` VALUES (53, 15, 2, 6, '');
INSERT INTO `gallery_eintraege` VALUES (54, 16, 2, 7, '');
INSERT INTO `gallery_eintraege` VALUES (55, 17, 2, 5, '');
INSERT INTO `gallery_eintraege` VALUES (56, 18, 2, 3, '');
INSERT INTO `gallery_eintraege` VALUES (57, 19, 2, 1, '');
INSERT INTO `gallery_eintraege` VALUES (58, 20, 2, 2, '');
INSERT INTO `gallery_eintraege` VALUES (69, 22, 3, 3, '');
INSERT INTO `gallery_eintraege` VALUES (68, 21, 3, 2, '');
INSERT INTO `gallery_eintraege` VALUES (66, 72, 2, 4, '');
INSERT INTO `gallery_eintraege` VALUES (63, 74, 1, 2, '');
INSERT INTO `gallery_eintraege` VALUES (64, 75, 1, 4, '');
INSERT INTO `gallery_eintraege` VALUES (65, 76, 1, 6, '');
INSERT INTO `gallery_eintraege` VALUES (70, 23, 3, 4, '');
INSERT INTO `gallery_eintraege` VALUES (71, 24, 3, 5, '');
INSERT INTO `gallery_eintraege` VALUES (72, 25, 3, 6, '');
INSERT INTO `gallery_eintraege` VALUES (73, 26, 3, 7, '');
INSERT INTO `gallery_eintraege` VALUES (74, 27, 3, 8, '');
INSERT INTO `gallery_eintraege` VALUES (75, 2, 4, 1, '');
INSERT INTO `gallery_eintraege` VALUES (76, 3, 4, 2, '');
INSERT INTO `gallery_eintraege` VALUES (77, 4, 4, 3, '');
INSERT INTO `gallery_eintraege` VALUES (78, 5, 4, 4, '');
INSERT INTO `gallery_eintraege` VALUES (79, 6, 4, 5, '');
INSERT INTO `gallery_eintraege` VALUES (80, 101, 5, 1, '');
INSERT INTO `gallery_eintraege` VALUES (81, 102, 5, 2, '');
INSERT INTO `gallery_eintraege` VALUES (82, 103, 5, 3, '');
INSERT INTO `gallery_eintraege` VALUES (83, 104, 5, 4, '');
INSERT INTO `gallery_eintraege` VALUES (84, 105, 5, 5, '');
INSERT INTO `gallery_eintraege` VALUES (85, 106, 5, 6, '');
INSERT INTO `gallery_eintraege` VALUES (86, 107, 5, 7, '');
INSERT INTO `gallery_eintraege` VALUES (87, 108, 5, 8, '');
INSERT INTO `gallery_eintraege` VALUES (88, 109, 5, 9, '');
INSERT INTO `gallery_eintraege` VALUES (89, 110, 5, 10, '');
INSERT INTO `gallery_eintraege` VALUES (90, 111, 5, 11, '');
INSERT INTO `gallery_eintraege` VALUES (91, 112, 5, 12, '');
INSERT INTO `gallery_eintraege` VALUES (92, 113, 5, 13, '');
INSERT INTO `gallery_eintraege` VALUES (93, 114, 5, 14, '');
INSERT INTO `gallery_eintraege` VALUES (94, 115, 5, 15, '');
INSERT INTO `gallery_eintraege` VALUES (95, 116, 5, 16, '');
INSERT INTO `gallery_eintraege` VALUES (104, 125, 1, 5, '');
INSERT INTO `gallery_eintraege` VALUES (97, 118, 5, 18, '');
INSERT INTO `gallery_eintraege` VALUES (98, 119, 5, 19, '');
INSERT INTO `gallery_eintraege` VALUES (99, 120, 5, 20, '');
INSERT INTO `gallery_eintraege` VALUES (100, 121, 5, 21, '');
INSERT INTO `gallery_eintraege` VALUES (101, 122, 5, 22, '');
INSERT INTO `gallery_eintraege` VALUES (102, 123, 5, 23, '');
INSERT INTO `gallery_eintraege` VALUES (103, 124, 5, 24, '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `gbook`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=56 ;

-- 
-- Daten f�r Tabelle `gbook`
-- 

INSERT INTO `gbook` VALUES (1, 0, '2007-01-02 23:36:44', 'David D�ster', 'dfd1985@gmail.com', 'www.jclub.ch', 'Hallo Leute.\r\nGut Weile will dauer haben. Und nun ist es endlich da.\r\nDie neue Seite ist online. Fehler sind m�glich, bitte meldet sie per Email an mich oder Simon.', '1. Eintrag', 0);
INSERT INTO `gbook` VALUES (2, 0, '2007-01-03 00:06:17', 'Reine Chefasche (Bebu)', 'fieserfettsack_@hotmail.com', '', 'Auso nachd�m dasi da die letschte Iitr�g  so gl�se ha, hani d�nkt, da m�ess mau wieder �ppis "ganz Schlaus" ine, drum hani d�nkt, da m�ess i mi drum k�mmere... :-Q\r\nNei seich, i w�nsche euch ganz e guete Rutsch is n�ie Jahr, t�et geng sch�n artig, fouget �ichem usgsproche n�tte JG-Leiter immer ganz guet, und de git das es ganz es guets 07. :-D\r\n\r\nF�r au di wo regum�ssig id JG ch�me, ir erschte Wuche nach de Ferie (12. Jan) geseh mer �s wieder, f�r aui angere.... ch�met denn ou! Auso d�mfau ! R�tschet guet und de bis im 07!\r\n*dance* *dance* *dance* *dance* *dance*', 'Kopie vom alte G�stebuech...', 0);
INSERT INTO `gbook` VALUES (3, 0, '2007-01-03 11:17:37', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hallo Leute\r\n\r\nGut habt ihr das hingekriegt. Sieht toll aus. Danke schon mal im Voraus f�r eure geleistete Arbeit!\r\nGruss \r\n\r\nvom Scheff pers�nlich', 'Ja, hallo erstmaaaaal....', 0);
INSERT INTO `gbook` VALUES (4, 3, '2007-01-03 12:00:09', 'Administrator', 'admin@jclub.ch', 'www.jclub.ch', 'Merci f�r d''Blueme...\r\nMir si ou chli stolz druf ;)', '', 0);
INSERT INTO `gbook` VALUES (5, 0, '2007-01-03 13:27:04', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', 'Hei Jungs\r\n\r\nGseht w�rkl�ch gu�t us. \r\n\r\nNo � Frag � n�ggi: Wieso schribsch du Hochdeutsch?\r\n\r\nAuso no e sch�n�..\r\n\r\nSal���', 'Pers�nlicher Eintrag Nummer 1', 0);
INSERT INTO `gbook` VALUES (6, 5, '2007-01-03 13:31:15', 'Hans Holunder alias Bebu', 'fieserfettsack_@hotmail.com', '', 'Das geit di absolut agr n�t a!!!\r\n\r\nDas blibt mis Gheimnis...', '', 0);
INSERT INTO `gbook` VALUES (7, 5, '2007-01-03 18:55:01', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', 'Da das e chrischtl�chi Sit� isch machis jetz nid, aber du weisch wel� Finger das jetzt d�heim h�tsch gseh g�u ;-)', '', 0);
INSERT INTO `gbook` VALUES (8, 0, '2007-01-04 15:09:26', '�ndu', 'andreasallemann@gmx.ch', '', 'I gse vouer stouz die neuei site. Das luegt auso scho angersch us aus die auti site.\r\n\r\nFrage: Cha me do keini sooo coooooli Smilies me mache wie im aute G�stebuech?', 'Bravo!!!', 0);
INSERT INTO `gbook` VALUES (9, 0, '2007-01-04 15:48:32', 'Rebi', 'dietrich.rebekka@hotmail.com', '', 'hey!\r\nmir gfout die page ou mega guet!\r\ns wart� het sech �cht gLohnt!\r\ni hoff� dir siget aui guet is n�i� johr gschtartet und bis gLiiii\r\n', 'aLoha!', 0);
INSERT INTO `gbook` VALUES (10, 0, '2007-01-04 16:30:16', 'Surli', 'Surli87@gmx.ch', '', 'Wow he, mega genial heit dir die Homepage gmacht!!\r\nEs riise Lob a die Person wos gmacht het!!\r\nNachtr�glech w�nschi euch aune es ganzes guets neus Jahr, Gottes riiche S�ge und e ganze gueti Zyt!!\r\nBye bye Soraya', 'Achtung Surli chunnt ;-)', 0);
INSERT INTO `gbook` VALUES (11, 10, '2007-01-04 16:43:12', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', 'Es si mehreri Persono� gsi...', '', 0);
INSERT INTO `gbook` VALUES (12, 8, '2007-01-04 19:31:34', 'Administrator(en)', 'dfd1985@gmail.com', 'www.nowayback.ch.vu', 'Nei, no nid. Aber wird no cho.\r\nJe nach d�m wie stark i mues schaffe halt scho fr�echer oder halt chli sp�ter.\r\nD''Smily-Codes w�rde aber witgehend die gliche blibe, evnt. gits de o es paar neui ;)', '', 0);
INSERT INTO `gbook` VALUES (13, 0, '2007-01-04 19:52:28', 'Barbara (die besseri Heufti (Schw�ster) vom BORN)', 'barbara_born@hotmail.com', 'www.artchicks.ch.vu', 'Hallo z�me\r\nHa uf die Site gfunge und d�nkt i schribe doch grad mou �bbis ine! Und das uf B�RNd�tsch! Sch�ni Homepage und hebit nech Sorg!\r\nLiebs Gr�essli\r\nBarbara', 'Sch�ni HP', 0);
INSERT INTO `gbook` VALUES (14, 13, '2007-01-04 19:59:29', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', 'Isch ja schliesslech dr sch�nscht Dial�kt!!', '', 0);
INSERT INTO `gbook` VALUES (15, 0, '2007-01-07 14:53:13', 'Marco', 'marco.flueck@ggs.ch', 'www.jesus.ch', 'L�di dini Koment�r si witzig und n�rvig zuglich! (als VW verstoh -verwirrender Witz) ;-O', 'L�di!!!', 0);
INSERT INTO `gbook` VALUES (16, 0, '2007-01-07 14:58:27', 'Marco', 'marco.flueck@ggs.ch', 'www.jesus.ch', 'Hey das Programm gseht cooooooool und vieeeeeeeeeelverspr�chend us!!!! :):):)\r\n', 'Wunderbars Programm', 0);
INSERT INTO `gbook` VALUES (17, 15, '2007-01-09 18:42:26', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', '..das isch ja wohl die gr�schti afig��rei gsi...', '', 0);
INSERT INTO `gbook` VALUES (18, 16, '2007-01-09 18:43:27', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', 'Hesch vom Bebu �ppis angers erwartet??? he? he?\r\n\r\ns�gs num�!', '', 0);
INSERT INTO `gbook` VALUES (19, 15, '2007-01-09 19:45:27', 'Marco', 'marco.flueck@ggs.ch', 'www.jesus.ch', 'Jo i bi i dere Sach a dr vorderschter Front :)', '', 0);
INSERT INTO `gbook` VALUES (20, 15, '2007-01-10 19:39:47', 'Kommentarschreiber (L�di)', 'Lukas.Schlaepfer@gmx.ch', '', '...I cha ou eifach n�m schrib� oder!! Mueschs num� s�g�!!... ;-)', '', 0);
INSERT INTO `gbook` VALUES (29, 28, '2007-01-16 22:51:39', 'DD', 'admin@jclub.ch', '', 'Tja, cheut ja e Schatzsuechi mache... w�r het zuerscht Schnee gfunde ;)\r\nNei Seich, do g�bs z.B.: Badi, Usflug, Wandere, u.a.', '', 0);
INSERT INTO `gbook` VALUES (30, 28, '2007-01-16 22:56:31', 'BB', 'barbara_born@hotmail.com', '', 'Wellness weekend :)\r\n(nid auzu �rnst n�h chume nid mit isch darum nume e idee gsi)\r\n(und DD was du chasch cha i ou ;)', '', 0);
INSERT INTO `gbook` VALUES (31, 28, '2007-01-16 22:56:41', 'Der Kommentarschreiber (L�di)', 'Lukas,Schlaepfer@gmx.ch', '', 'die Organsation he..tztzt... zwichtigscht� isch mau wieder verg�ss� gang�...', '', 0);
INSERT INTO `gbook` VALUES (32, 28, '2007-01-17 13:29:48', 'R�phu', 'waeili@gmx.ch', 'www.scb.ch', '"Badi" Im Winter?\r\n"Usflug" �hmmm... du meinsch chli ir G�gend um�nang fahr�? \r\n"Wandere" Wo ja sooo beliebt isch bi 13-18 j�hrig� L�t... \r\n"u.a." Ja?', '', 0);
INSERT INTO `gbook` VALUES (33, 28, '2007-01-17 14:21:46', 'DD', 'dfd1985@gmail.com', 'www.jclub.ch', 'Ja, Badi... z.B. Hallebad. Ha ja nid gseit "Freibad".\r\nUsflug... z.B. bi Visp go luege?\r\nWandere... ja, ok, es Argum�nt, aber immerhin e vorschlag.\r\nTja, u s�sch e Graasschlacht (da es ja so viel Schnee het), s�sch irgend �bis (nei, L�di, nid XBox)...', '', 0);
INSERT INTO `gbook` VALUES (34, 28, '2007-01-17 15:12:33', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', 'hesch r�cht D�sti... XBox 360 n�ml�ch..', '', 0);
INSERT INTO `gbook` VALUES (35, 28, '2007-01-17 18:51:26', 'R�phu', 'waeili@gmx.ch', 'www.scb.ch', 'Ja okay, D�schter, scho chli konkreter! ;) Aber unger "Badi" verschta ig pers�nlech haut �s Freibad - was aber eventuell a mim Dial�kt ch�nt lig�!? Und Visp... weiss gar nid ob die �berhoupt schpil�, ig ga uf jed� Fau a SCB-M�tsch am Samschti^^', '', 0);
INSERT INTO `gbook` VALUES (28, 0, '2007-01-16 22:43:11', 'Bebu', 'fieserfettsack_@hotmail.com', '', 'Hallo zusammen!!!!\r\n\r\nWie ihr vielleicht gesehen habt ist der Schnee nicht mehr geworden. Wir m�ssen also schon mal f�r ein Alternativprogramm schauen! Wenn ihr eine Idee habt, meldet euch doch baldm�glichst, denn mit dem Skifahren wird es sehr wahrscheinlich nichts werden... leider!\r\n\r\nGruss und eine sch�ne Woche\r\n\r\n\r\nBebu', '!!! Ski - Weekend !!!', 0);
INSERT INTO `gbook` VALUES (36, 28, '2007-01-17 21:05:04', 'J�ggu', 'dschalk@gmail.com', 'www.realnet.ch', 'Is hauebad w�r scho nid schl�cht. Aber dr Ganz Tag lot sich so au nid lo f�lle...\r\nund Wandere... naja. Ha scho bessers gh�rt.\r\nAber e Vorschlag han ig glich no:\r\nme ch�nt doch dr D�ggelichschte mittn�h :D\r\n', '', 0);
INSERT INTO `gbook` VALUES (37, 28, '2007-01-17 21:14:01', 'R�phu', 'waeili@gmx.ch', 'www.scb.ch', '"me ch�nt doch dr D�ggelichschte mittn�h" Genial� Vorschlag! :-D Mir m�esse di eifach ufs Dach bing�, de bring� mer n� vilech in�. W�u f�r� T�ggelichascht� w�rs z schad. Isch das guet?^^', '', 0);
INSERT INTO `gbook` VALUES (38, 28, '2007-01-18 17:54:28', '�hm... J�ggu?', 'ha_se_verg�sse@kei_ahnig.ch', 'www.keine_ahnung.ch', 'Hmm. Das mit em ufs Dach binde isch gar kei so schl�chti Idee. Aber chlei ufw�ndig. Und de m�ese mir no einisch meh B�tte, dass dr T�ggelichaschte die Fahrt �berstoht... \r\nBesseri Idee:\r\nMe ch�nt doch e Lan-Party mache^^ :D', '', 0);
INSERT INTO `gbook` VALUES (39, 28, '2007-01-19 14:15:13', 'R�phu', 'waeili@gmx.ch', 'www.scb.ch', 'Du hesch nid richtig gl�s�, J�ggu. Ig wot DI ufs Dach bing�, �b� nid dr T�gg�lichascht�!', '', 0);
INSERT INTO `gbook` VALUES (40, 28, '2007-01-22 18:47:25', '�ndu', 'andreasallemann@gmx.ch', '', 'Jo i glaube, das mitem t�ggelichaschte het sich erledigt... d�rt wo mer gse si, hets jo scho eine gha:-)\r\n\r\nI muess auso s�ge: ES isch sooo meeegaa guet gsi, es h�t glaub fasch nid besser ch�nne si s�sch n�ime...', '', 0);
INSERT INTO `gbook` VALUES (41, 0, '2007-01-25 16:30:05', 'Marco', 'marco.flueck @ggs.ch', '', 'Findi toll, dass dir so vili Komment�r schribend, drum hani jetz mol wieder en Nachricht gschribe =)\r\n=) =) (i hoffe, mi verstoht, was i m�cht s�g�; e Tipp: das isch Doppelironie)', 'Nachricht', 0);
INSERT INTO `gbook` VALUES (42, 0, '2007-01-31 20:15:12', 'Rebi', 'dietrich.rebekka@hotmail.com', '', 'hey!\r\nja us �isem ski-weekend isch Leidr nix word�...\r\nabr isch gLich haMmr xi! fr�i� mi scho uf das wuche�nd, wird sichr widr cooL!\r\nsch�n� ob� no und e gs�gneti zyt', 'weekends', 0);
INSERT INTO `gbook` VALUES (43, 41, '2007-02-01 19:01:27', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', 'Ja isch guet Marco mir schrib� witerhin Komment�r :-)', '', 0);
INSERT INTO `gbook` VALUES (44, 42, '2007-02-01 19:04:20', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', 'weekends? fr�i� mi scho uf das wuche�nd?\r\n\r\nhani irgend�ppis verpasst?\r\n\r\n\r\nlouft i-�ppis vor JG us d� Fritig? i ha drum kei ahnig.. ', '', 0);
INSERT INTO `gbook` VALUES (45, 42, '2007-02-01 21:07:45', 'L�di', 'Lukas.Schlaepfer@gmx.ch', '', 'Auso ha grad dr Bef�u vom Bebu �bercho euch morn � Fium abzlah...\r\n\r\ni-ei K�modie hets gheiss�!\r\n\r\nd�mfau bis morn...', '', 0);
INSERT INTO `gbook` VALUES (46, 0, '2007-02-08 10:25:27', 'Admin', 'simon_@gmx.net', '', 'Das beweise ich mit folgendem Post', 'Tests werden nie langweilig', 0);
INSERT INTO `gbook` VALUES (47, 46, '2007-02-08 10:26:05', 'Admin', 'simon_@gmx.net', '', 'Sogar kommentare schreiben macht immer noch spass', 'Dein Titel', 0);
INSERT INTO `gbook` VALUES (48, 46, '2007-02-08 10:39:08', 'Admin', 'simon_@gmx.net', '', 'Auch jetzt noch', 'Dein Titel', 0);
INSERT INTO `gbook` VALUES (49, 46, '2007-02-08 16:50:50', 'Admin', 'simon_@gmx.net', '', 'Immer noch nicht', 'Dein Titel', 0);
INSERT INTO `gbook` VALUES (50, 46, '2007-02-08 17:03:14', 'Admin', 'simon_@gmx.net', '', 'Test mit neuer �bergabe\r\nKlappt, yeah', 'Dein Titel', 0);
INSERT INTO `gbook` VALUES (51, 46, '2007-02-08 17:06:15', 'Admin', 'simon_@gmx.net', '', 'Letzter Test mit Kommentar.\r\nKlappt auch, yeah', 'Dein Titel', 0);
INSERT INTO `gbook` VALUES (52, 0, '2007-02-08 17:06:59', 'Admin', 'simon_@gmx.net', '', 'Und wieder ein Test im Hauptartikel', 'Denn testen muss man ja heutet', 0);
INSERT INTO `gbook` VALUES (53, 52, '2007-02-08 17:07:41', 'Admin', 'simon_@gmx.net', '', 'Auch wieder im Kommentar', 'Dein Titel', 0);
INSERT INTO `gbook` VALUES (54, 52, '2007-02-08 23:51:54', 'Admin', 'simon_@gmx.net', '', 'Und wieder ein Test', 'Dein Titel', 0);
INSERT INTO `gbook` VALUES (55, 0, '2007-02-08 23:52:28', 'Admin', 'simon_@gmx.net', '', 'Da muss ich einfach recht geben', 'Testen muss man auch mehrmals am Tag', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `mailto`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

-- 
-- Daten f�r Tabelle `mailto`
-- 

INSERT INTO `mailto` VALUES (18, 'Admin', 'simon_@gmx.net', 'Admin', 'simon_@gmx.net', 'Hi', 'Simon', '354ba4ebd4f5da1c014c557183b7989e', '2007-02-08 16:01:49');
INSERT INTO `mailto` VALUES (19, 'Admin', 'simon_@gmx.net', 'Admin', 'simon_@gmx.net', 'Hi', 'Simon', '02af8e1ed1ef6a5f1e52da2d0708a796', '2007-02-08 16:08:19');
INSERT INTO `mailto` VALUES (20, 'Admin', 'simon_@gmx.net', 'Mein Name', 'meine@email.de', 'Mein Titel', 'Hallo', 'dba83cce80b9ff255c4f361301187e79', '2007-02-08 16:46:34');
INSERT INTO `mailto` VALUES (21, 'Admin', 'simon_@gmx.net', 'Admin', 'simon_@gmx.net', 'test', 'test', '4a2ee6acc5be7b55df6b0f9ef119d181', '2007-02-08 17:08:02');
INSERT INTO `mailto` VALUES (22, 'Administrator', 'mail@jclub.ch', 'Admin', 'simon_@gmx.net', 'Mein Betreff', 'Mein Text', '2ab6232c765fddecb95dba16f26f693f', '2007-02-08 23:44:51');
INSERT INTO `mailto` VALUES (23, 'Administrator', 'mail@jclub.ch', 'Admin', 'simon_@gmx.net', 'Hallo Admin', 'Gr�ezi', '1bb692f9e358875fb1dcf36a79fbe2f6', '2007-02-08 23:57:24');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `members`
-- 

CREATE TABLE `members` (
  `members_ID` int(11) NOT NULL auto_increment COMMENT 'De weisi w�r du bisch',
  `members_name` varchar(50) collate utf8_unicode_ci NOT NULL default '' COMMENT 'L�ngwilig, f�r B�rokrate',
  `members_spitzname` varchar(50) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Toll, zum Fertigmache',
  `members_birthday` date NOT NULL default '0000-00-00' COMMENT 'Alter sch�tzt vor Torheit nicht',
  `members_song` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Ke Musiggschmack?',
  `members_hobby` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'L�ngwilig',
  `members_food` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Grusig',
  `members_job` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Verdiensch so weni Chol�?',
  `members_motto` varchar(200) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Haut di mou dra!',
  `members_email` varchar(100) collate utf8_unicode_ci NOT NULL default '' COMMENT 'so l�ng?',
  `members_FIDimage` varchar(200) collate utf8_unicode_ci NOT NULL default '' COMMENT 'hesch ou scho besser usgseh',
  PRIMARY KEY  (`members_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Die Mitgliedertabelle' AUTO_INCREMENT=13 ;

-- 
-- Daten f�r Tabelle `members`
-- 

INSERT INTO `members` VALUES (1, 'Benjamin Schl�pfer', 'Bebu', '1982-03-06', 'Forever you', 'JG, Musizieren, Sport', 'Lassagne', 'Student an der STH Basel', 'What Would Jesus Do??', 'fieserfettsack_@hotmail.com', '');
INSERT INTO `members` VALUES (3, 'David D�ster', 'Dave', '1985-04-22', 'Watching Over You', 'JG, PC, Sport, Musik', 'Broccoli', 'Informatiker', 'Pray Until Something Happens!', 'dfd1@gmx.net', '');
INSERT INTO `members` VALUES (4, 'Lukas Schl�pfer', 'L�di', '1987-09-19', 'Lord I lift your name on high', 'Gamen, JG, PC, Sport', 'Lassagne', 'kaufm�nnischer Angestellter (in Ausbildung)', '-', '', '');
INSERT INTO `members` VALUES (6, 'Simon D�ster', 'Simon', '1989-01-25', 'The days of Elijah', 'JS, JG, PC, Freundin, Musik', '', 'Sch�ler', '', '', '');
INSERT INTO `members` VALUES (7, 'Daniel Schenk', 'Dani', '1989-09-26', '-', 'Klettern, Jungschar', '-', 'Polymechaniker (in Ausbildung)', '-', '', '');
INSERT INTO `members` VALUES (8, 'Marco Fl�ck', 'Marco', '1989-12-14', '-', 'Jungschar, Ping-Pong, JG, Skifahren', '-', 'Sch�ler', '-', '', '');
INSERT INTO `members` VALUES (10, 'Anna Gasser', 'Anna', '1991-03-21', 'Ch�nig vo mim H�rz', 'lesen, in der Natur sein, Musik h�ren', 'Lasagne', '', '-', '', '');
INSERT INTO `members` VALUES (11, 'Samuel Bader', 'S�mi', '1991-10-09', 'sick and tired', 'Fussball, Hockey, PC, JG', 'Schnipo', 'Sch�ler', '-', '', '');
INSERT INTO `members` VALUES (12, 'Raphael D�ster', '&alpha; (Alpha)', '1991-12-24', 'Awesome God', 'Sport, JG, Jungschi', 'Lasagne', 'Sch�ler', '', '', '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `menu`
-- 

CREATE TABLE `menu` (
  `menu_ID` int(11) NOT NULL auto_increment COMMENT 'Jetzt weisi w�r du bisch',
  `menu_topid` int(11) NOT NULL default '0' COMMENT 'Stohsch wieder �ber de andere',
  `menu_position` int(11) NOT NULL default '0' COMMENT '"Die Ersten werden die LETZTEN sein" ',
  `menu_name` text collate utf8_unicode_ci NOT NULL COMMENT 'Sgit besseri N�me',
  `menu_page` int(11) NOT NULL default '0' COMMENT 'Gang mou d�rt go sueche!',
  `menu_pagetyp` enum('mod','pag') collate utf8_unicode_ci NOT NULL default 'mod' COMMENT 'Machts e Unterschie?!?',
  `menu_modvar` varchar(45) collate utf8_unicode_ci NOT NULL default '' COMMENT 'Wotsch no �ppis mitg�h?!?',
  `menu_display` enum('0','1') collate utf8_unicode_ci NOT NULL default '1' COMMENT 'Wotsch mi gseh?!?',
  PRIMARY KEY  (`menu_ID`),
  KEY `menu_topid` (`menu_topid`),
  KEY `menu_page` (`menu_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=79 ;

-- 
-- Daten f�r Tabelle `menu`
-- 

INSERT INTO `menu` VALUES (25, 0, 1, 'Home', 5, 'pag', '', '1');
INSERT INTO `menu` VALUES (26, 0, 3, '�ber uns', 35, 'pag', '', '1');
INSERT INTO `menu` VALUES (33, 0, 7, 'G&auml;stebuch', 1, 'mod', '', '1');
INSERT INTO `menu` VALUES (44, 0, 5, 'Programm', 12, 'pag', '', '1');
INSERT INTO `menu` VALUES (40, 0, 8, 'Gallery', 3, 'mod', '', '1');
INSERT INTO `menu` VALUES (41, 0, 100, 'image', 4, 'mod', '', '0');
INSERT INTO `menu` VALUES (42, 0, 4, 'Mitglieder', 5, 'mod', '', '1');
INSERT INTO `menu` VALUES (43, 0, 3, 'News', 6, 'mod', '', '1');
INSERT INTO `menu` VALUES (45, 42, 1, 'Gott kann reden', 4, 'pag', '', '1');
INSERT INTO `menu` VALUES (46, 42, 0, 'Members', 5, 'mod', '', '1');
INSERT INTO `menu` VALUES (47, 26, 2, 'Unsere Visionen', 6, 'pag', '', '1');
INSERT INTO `menu` VALUES (48, 47, 1, 'Nachfolge', 7, 'pag', '', '1');
INSERT INTO `menu` VALUES (49, 47, 2, 'Anbetung', 8, 'pag', '', '1');
INSERT INTO `menu` VALUES (50, 47, 3, 'Gemeinschaft', 9, 'pag', '', '1');
INSERT INTO `menu` VALUES (51, 47, 4, 'Evangelisation', 10, 'pag', '', '1');
INSERT INTO `menu` VALUES (52, 47, 5, 'Dienerschaft', 11, 'pag', '', '1');
INSERT INTO `menu` VALUES (53, 26, 1, 'Interview', 2, 'pag', '', '1');
INSERT INTO `menu` VALUES (54, 44, 1, 'JG-Programm - �bersicht', 12, 'pag', '', '1');
INSERT INTO `menu` VALUES (55, 54, 1, '12. Januar', 13, 'pag', '', '1');
INSERT INTO `menu` VALUES (56, 54, 2, '19. � 21. Januar', 14, 'pag', '', '1');
INSERT INTO `menu` VALUES (57, 54, 3, '26. Januar', 15, 'pag', '', '1');
INSERT INTO `menu` VALUES (58, 54, 4, '2. Februar', 16, 'pag', '', '1');
INSERT INTO `menu` VALUES (59, 54, 5, '23. Februar', 17, 'pag', '', '1');
INSERT INTO `menu` VALUES (60, 54, 6, '2. M�rz', 18, 'pag', '', '1');
INSERT INTO `menu` VALUES (61, 54, 7, '9. M�rz', 19, 'pag', '', '1');
INSERT INTO `menu` VALUES (62, 54, 8, '16. M�rz', 20, 'pag', '', '1');
INSERT INTO `menu` VALUES (63, 54, 9, '21. M�rz', 21, 'pag', '', '1');
INSERT INTO `menu` VALUES (64, 54, 10, '30. M�rz', 22, 'pag', '', '1');
INSERT INTO `menu` VALUES (65, 54, 11, '6. April', 23, 'pag', '', '1');
INSERT INTO `menu` VALUES (66, 54, 12, '27. April', 24, 'pag', '', '1');
INSERT INTO `menu` VALUES (67, 54, 13, '4. Mai', 25, 'pag', '', '1');
INSERT INTO `menu` VALUES (68, 54, 14, '11. Mai', 26, 'pag', '', '1');
INSERT INTO `menu` VALUES (69, 54, 15, '18. Mai', 27, 'pag', '', '1');
INSERT INTO `menu` VALUES (70, 54, 16, '1. Juni', 28, 'pag', '', '1');
INSERT INTO `menu` VALUES (71, 54, 17, '8. Juni', 29, 'pag', '', '1');
INSERT INTO `menu` VALUES (72, 54, 18, '15. Juni', 30, 'pag', '', '1');
INSERT INTO `menu` VALUES (73, 54, 19, '22. Juni', 31, 'pag', '', '1');
INSERT INTO `menu` VALUES (74, 54, 20, '29. Juni', 32, 'pag', '', '1');
INSERT INTO `menu` VALUES (75, 54, 21, '6. Juli', 33, 'pag', '', '1');
INSERT INTO `menu` VALUES (76, 44, 0, 'Snowcamp vom 19.-21. Jan 07', 34, 'pag', '', '1');
INSERT INTO `menu` VALUES (77, 26, 0, 'Geschichte unserer JG', 35, 'pag', '', '1');
INSERT INTO `menu` VALUES (78, 0, 0, 'Captcha_bild', 7, 'mod', '', '0');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `modules`
-- 

CREATE TABLE `modules` (
  `modules_ID` int(11) NOT NULL auto_increment,
  `modules_name` varchar(45) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`modules_ID`),
  UNIQUE KEY `modules` (`modules_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- 
-- Daten f�r Tabelle `modules`
-- 

INSERT INTO `modules` VALUES (1, 'gbook.php');
INSERT INTO `modules` VALUES (2, 'gbook2.php');
INSERT INTO `modules` VALUES (3, 'gallery.php');
INSERT INTO `modules` VALUES (4, 'image.php');
INSERT INTO `modules` VALUES (5, 'members.php');
INSERT INTO `modules` VALUES (6, 'news.php');
INSERT INTO `modules` VALUES (7, 'captcha_image.php');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `news`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- 
-- Daten f�r Tabelle `news`
-- 

INSERT INTO `news` VALUES (1, 0, '2007-01-02 22:53:52', 'Administrator', 'mail@jclub.ch', 'http://www.jclub.ch', 'So, die neue Seite ist online.\r\nHabt Nachsicht falls noch irgendwelche Fehler auftreten und meldet es uns.', '1. Newseintrag', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur f�r Tabelle `smilies`
-- 

CREATE TABLE `smilies` (
  `smilies_ID` int(11) NOT NULL auto_increment,
  `smilies_file` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`smilies_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- 
-- Daten f�r Tabelle `smilies`
-- 

