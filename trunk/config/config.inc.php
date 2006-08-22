<?php

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
$gbook_entry_title = "Dein Titel";
$gbook_entry_content  = "Dein Text";
$gbook_entry_name  = "Hans Holunder";
$gbook_entry_hp = "www.deinehp.dt";
$gbook_entry_email = "Deine E-Mail";

$gbook_onerror_title_de = "Eintrag fehlerhaft";
$gbook_title_onerror_de = "Fehler im Titel.<br />Darf nicht leer sein, oder den Standard-Wert haben";
$gbook_content_onerror_de = "Fehler im Inhalt.<br />Darf nicht leer sein, oder den Standard-Wert haben";
$gbook_name_onerror_de = "Fehler im Name.<br />Darf nicht leer sein, oder den Standard-Wert haben";
$gbook_email_onerror_de = "Fehler in der Email-Adresse.<br />Darf nicht leer sein, oder den Standard-Wert haben";
$gbook_hp_onerror_de = "Fehler im Link zu deiner Homepage.<br />Darf nicht den Standard-Wert haben";
$gbook_link_onerror_de = "Zur&uuml;ck";

$gbook_allright_title = "Eintrag erstellt";
$gbook_allright_content = "Dein Eintrag wurde gespeichert, und steht sofort im GB zur Verfügung";
$gbook_allright_link = "Zur&uuml;ck zum G&auml;stebuch";
?>
