<?php
/**
 * 
 * Diese Seite speichert die Texte ab, welche immer wieder in der auth-Klasse gebraucht werden.
 * 
 * @author Simon Däster
 * @package JClubCMS
 * system_textes.inc.php
 */

$system_textes = array();
$system_textes['de'] = array();

//**Texte, welche in der Mysql-Klasse gebraucht werden
$system_textes['de']['mysql'] = array();
$system_textes['de']['mysql']['server_connection_failed'] = 'Verbindung zum Mysql-Server fehlgeschlagen';
$system_textes['de']['mysql']['query_not_masked'] = 'Mysql-Anfrage konnte nicht maskiert werden';
$system_textes['de']['mysql']['query_not_string'] = 'Angegebener Mysql-Query ist kein String';
$system_textes['de']['mysql']['query_invalid'] = 'Mysql-Query ist ungültig"';
$system_textes['de']['mysql']['server_not_closed'] = 'Mysql-Verbindung konnte nicht auf Anfrage geschlossen werden';


$auth_error_sessioncorupt = "Ihre Session-ID ist nicht mehr g&uuml;ltig oder wurde gef&auml;lscht. Bitte loggen Sie sich neu ein.";
$auth_error_nonactiv = "Sie waren zu lange inaktiv. Bitte loggen Sie sich neu ein";

$auth_error_noentry = "Sie m&uuml;ssen einen Benutzernamen und/oder ein Passwort eingeben";
$auth_error_failname = "Benutzername nicht vorhanden. (Achte auf Gross-/Kleinschreibung!)";
$auth_error_failpw = "Passwort wurde falsch eingegeben";
$auth_error_userinvalid = "Benutzer ist nicht g&uuml;ltig";

$auth_forward_successlogin = "Sie haben sich erfolgreich eingeloggt. Sie werden weitergeleitet.";
$auth_forward_linktext = "Sollte die Weiterleitung nicht funktionieren, dr&uuml;cken Sie diesen Link";
$auth_forward_title = "Weiterleitung JClub-Administration"
?>