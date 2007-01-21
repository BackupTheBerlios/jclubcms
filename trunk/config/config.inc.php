<?php
/**
 * @package JClubCMS
 * @author David Däster, Simon Däster
 */
/*DB-Einstellungen*/
$db_server = "localhost";
$db_name = "jclubbeta";
$db_user = "jclubbeta";
$db_pw ="jclubbeta";


/*News-Einstellungen*/
$news_entries_per_page = 5;


/*Gallery-Einstellungen*/
$gallery_pics_x = 4;
$gallery_pics_y = 4;
$gallery_menuview = 2; //Wieviele Bilder Links und Rechts des aktuellen Bildes gezeigt werden

//**Bild und Thumb

//!!! Bilder sind stdmässig in originals abgespeichert, aber wenn sie zu gross sind, in gallery
$dir_orgImage = "./graphics/originals/"; //Relativ zur Index-Datei
$dir_galImage = "./graphics/gallery/";  //Relativ zur Index-Datei
$image_maxheight = 600;
$image_maxwidth = 600;

$dir_thumb = "./graphics/gallery/thumbs/";  //Relativ zur Index-Datei
$thumb_maxheight = 150;
$thumb_maxwidth = 150;


/*------$time_format-----------------------
* Analog des data() von PHP, mit Ausnahmen
* ------NICHT GEPLANTE UNTERSTÜTZUNG--------
* B	Swatch-Internet-Zeit
* D	Tag der Woche gekürzt auf drei Buchstaben
* I Fällt ein Datum in die Sommerzeit
* l Ausgeschriebener Tag der Woche
* L	Schaltjahr oder nicht
* S	Anhang der englischen Aufzählung für einen Monatstag, zwei Zeichen
* t	Anzahl der Tage des angegebenen Monats
* T	Zeitzoneneinstellung des Rechners
* U	Sekunden seit Beginn der UNIX-Epoche
* w	Numerischer Tag einer Woche
* W	ISO-8601 Wochennummer des Jahres, die Woche beginnt am Montag
* z	Der Tag eines Jahres
* Z	 Offset der Zeitzone in Sekunden.
*/
$time_format = "j.m.Y H:i";


/*------GBook-Settings----------*/
$gbook_entries_per_page = 5;
?>
