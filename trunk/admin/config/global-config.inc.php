<?php

/**
 * @package JClubCMS
 * @author David Däter, Simon Däster
 */

/*DB-Einstellungen*/
define('DB_SERVER', 'localhost');
define('DB_NAME', 'jclubch_jclubcms');
define('DB_USER', 'jclubch_jclubcms');
define('DB_PW', '4pw4jclubcms');


/*Smarty-Einstellungen*/
define('SMARTY_COMPILE_CHECK', true);
define('SMARTY_DEBUGING', false);
define('SMARTY_CONFIG_DIR', 'config');

/*Sprach-Einstellungen*/
define('LANGUAGE_ABR', 'de');

/*Fehler-Einstellungen*/
//Trace des PHP-Parser anzeigen. Aus Sicherheitsgründen (z.B. Offenlegen des MySQL-Passworts bei MySQL-Fehler) nicht empfohlen
define('EXCEPTION_SHOW_TRACE', false);

/*Bild und Thumb*/
/**
 * **Speicherort der Bilder**
 * Bilder werden standartmässig im Ordner originals abgespeichert. 
 * Automatisch generierte Kopien dieser Bilder (u.a. weil das Originalbild zu gross ist) werden
 * im Ornder gallery abgespeichert.
 * Die kleinen automatische generierten Vorzeigebilder (sog. Thumbs) wernden standardmässig
 * im Ordner thumbs gespeichert.
 * 
 * Wichtig: Speicherorte sind relativ zur Index.php-Datei anzugeben
 *
 */
define('IMAGE_DIR_ORIGN', USER_DIR."graphics/originals/");
define('IMAGE_DIR_GALL', USER_DIR."graphics/gallery/");
define('IMAGE_MAXHEIGHT', 600);
define('IMAGE_MAXWIDTH', 600);

define('THUMB_DIR', USER_DIR."graphics/gallery/thumbs/");
define('THUMB_MAXHEIHGT', 150);
define('THUMB_MAXWIDTH', 150);



/**Smilies*/
define('SMILIES_DIR', USER_DIR."graphics/smilies/");


//**Date TimeZone
date_default_timezone_set('Europe/Zurich');



//**Bei der Gallerie: Alle Gallerien in der obersten Kategorie anzeigen, nicht nur die direkt untergeordneten
define('SHOW_ALL_GALLERIES_ON_TOP',true);

?>
