<?php
/**
 * @author Simon Däster
 * @package JClubCMS
 */
//Zum Schnelligkeits-Vergleich Start-Zeit erfassen
define('START_TIME',microtime(true));

//Zu Debug-Zwecken alle Fehler anzeigen
error_reporting(E_ALL | E_STRICT);

/**Konstanten definieren**/
define("ADMIN_DIR", "./admin/");
define("USER_DIR", "./");

/**Konfigurationen laden**/
require_once USER_DIR.'config/user-config.inc.php';
require_once ADMIN_DIR.'lib/core.class.php';

//CMS starten
Core::singleton();
?>
