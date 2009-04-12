<?php
/**
 * @package JClubCMS
 * @author David Däster, Simon Däster
 */

//**Templates Set
define('TEMPLATESET_DIR', 'templates/malte');

/*Menu-Einstellungen*/
define('USER_MENU_USE_SHORTLINKS',false);

/*News-Einstellungen*/
define('NEWS_ENTRIES_PER_PAGE',5);


/*Gallery-Einstellungen*/
define('GALLERY_PICS_X',4);
define('GALLERY_PICS_Y',4);
//Wieviele Bilder Links und Rechts des aktuellen Bildes gezeigt werden
define('GALLERY_MENUVIEW',2);

/*------$time_format-----------------------
* Analog des data() von PHP, mit Ausnahmen
* ------NICHT GEPLANTE UNTERSTÜZUNG--------
* B	Swatch-Internet-Zeit
* D	Tag der Woche gekuerzt auf drei Buchstaben
* I Fuellt ein Datum in die Sommerzeit
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
//$time_format = "j.m.Y H:i";


/*------GBook-Settings----------*/
define('GBOOK_ENTRIES_PER_PAGE',5);
?>
