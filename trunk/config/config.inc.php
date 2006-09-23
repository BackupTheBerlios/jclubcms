<?php

/*DB-Einstellungen*/
$db_server = "localhost";
$db_name = "jclub-beta";
$db_user = "root";
$db_pw ="";


/*Gallery-Einstellungen*/
$news_entries_per_page = 5;
$gallery_pics_x = 4;
$gallery_pics_y = 4;
$gallery_menuview = 2; //Wieviele Bilder Links und Rechts des aktuellen Bildes gezeigt werden

//**Bild und Thumb
$dir_image = "bilder/gallery";  //Ohne "./" am Anfang!
$image_maxheight = 600;
$image_maxwidth = 600;

$cache_thumb = true;
$cachedir_thumb = "bilder/gallery/thumbs/";  //Ohne "./" am Anfang!
$thumb_maxheight = 150;
$thumb_maxwidth = 150;


/*------$time_format-----------------------
* Analog des time() von PHP, mit Ausnahmen
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
//$time_format = "\I\m \J\a\hr\e \d\e\s \H\err\\n Y\, \d\e\m d. \d\e\s \M\o\\n\at\s M \i\\n \der \St\u\\n\de H \u\\n\d \M\i\\n\ut\e i";

/*------GBook-Settings----------*/
$gbook_entries_per_page = 5;
?>
