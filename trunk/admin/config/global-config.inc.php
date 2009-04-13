<?php

/**
 * @package JClubCMS
 * @author David Däter, Simon Däster
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License version 3
 */

/**
 * DBServer Adresse
 * 
 * Wird gebraucht als Zugriffspfad zum DBServer,
 * und wird vom Anbieter gegeben
 */
define('DB_SERVER', 'localhost');
/**
 * DB Name
 * 
 * Name der Datenbank, wird vom Anbieter geliefert
 */
define('DB_NAME', 'jclubch_jclubcms');
/**
 * DB Benutzer
 * 
 * Datenbankbenutzer, wird vom Anbieter geliefert
 */
define('DB_USER', 'jclubch_jclubcms');
/**
 * DB Benutzer Passwort
 * 
 * Passwort des Datenbankbenutzer, wird vom Anbieter geliefert
 */
define('DB_PW', '4pw4jclubcms');


/**
 * Einschalten des CompileChecks von Smarty
 */
define('SMARTY_COMPILE_CHECK', true);
/**
 * Einschalten des Debungings von Smarty
 */
define('SMARTY_DEBUGING', false);
/**
 * Konfigurationspfad von Smarty
 */
define('SMARTY_CONFIG_DIR', 'config');

/**
 * Sprache
 *
 * Definition der Seitensprache
 */
define('LANGUAGE_ABR', 'de');

/*Fehler-Einstellungen*/
/**
 * Trace des PHP-Parser anzeigen.
 * 
 * Aus Sicherheitsgründen (z.B. Offenlegen des MySQL-Passworts bei 
 * MySQL-Fehler) nicht empfohlen.
 */
define('EXCEPTION_SHOW_TRACE', false);

/*Bild und Thumb*/
/**
 * Speicherort der Bilder
 * Bilder werden standartmässig im Ordner originals abgespeichert. 
 * 
 * Automatisch generierte Kopien dieser Bilder (u.a. weil das Originalbild zu gross ist) werden
 * im Ornder gallery abgespeichert.
 * 
 * Die kleinen automatische generierten Vorzeigebilder (sog. Thumbs) wernden standardmässig
 * im Ordner thumbs gespeichert.
 * 
 * Wichtig: Speicherorte sind relativ zur index.php-Datei anzugeben
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

//**Ausgegebenes Timeformat
define('TIMEFORMAT', '%e.%m.%Y %k:%i');



//**Bei der Gallerie: Alle Gallerien in der obersten Kategorie anzeigen, nicht nur die direkt untergeordneten
define('SHOW_ALL_GALLERIES_ON_TOP',true);

?>
