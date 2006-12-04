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


/*Gallery-Einstellungen*/
$news_entries_per_page = 5;
$gallery_pics_x = 4;
$gallery_pics_y = 4;
$gallery_menuview = 2; //Wieviele Bilder Links und Rechts des aktuellen Bildes gezeigt werden

//**Bild und Thumb

//!!! Bilder sind stdmässig in originals abgespeichert, aber wenn sie zu gross sind, in gallery
$dir_orgImage = "../graphics/originals/"; //Relativ zum Ordner Modules
$dir_galImage = "../graphics/gallery/";  //Relativ zum Ordner Modules
$image_maxheight = 600;
$image_maxwidth = 600;

$dir_thumb = "../graphics/gallery/thumbs/";  //Relativ zum Ordner Modules
$thumb_maxheight = 150;
$thumb_maxwidth = 150;


/*------$time_format-----------------------
* Analog des data() von PHP, mit Ausnahmen
* ------NICHT GEPLANTE UNTERSTÜZUNG--------
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
$time_format = "\I\m \J\a\h\r\e Y \d\e\s \H\err\n";


/*------GBook-Settings----------*/
$gbook_entries_per_page = 5;
?>
