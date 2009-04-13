<?php
/**
 * 
 * Diese Seite speichert die Texte ab, welche zur Verfügung stehen müssen, wenn kein Zugriff auf die textes.conf mittels Smarty möglich ist.
 * Diese Texte werden hauptsächlich beim Werfen von Exceptions gebraucht
 * 
 * @author Simon Däster
 * @package JClubCMS
 * system_textes.inc.php
 */

$system_textes = array();
$system_textes['de'] = array();

//**Core
$system_textes['de']['core'] = array();
$system_textes['de']['core']['exp_no_smarty_instance'] = 'Keine Instanz der Smarty-Klasse vorhanden';
$system_textes['de']['core']['exp_error_in_file'] = 'Fehler aufgetreten in der Datei';
$system_textes['de']['core']['exp_on_line'] = 'auf Zeilenummer';
$system_textes['de']['core']['exp_error_often'] = 'Sollte dieser Fehler öfters auftreten, benachrichtigen Sie bitte den Administrator.Danke.';

$system_textes['de']['core']['func_exec_fail'] = 'Interne Funktion nicht ausführbar';
$system_textes['de']['core']['modul_not_found'] = 'Das angegebene Modul konnte nicht gefunden werden';
$system_textes['de']['core']['modul_dismacht_id'] = 'Für die angegebene Modul-ID ist kein Modul hinterlegt!!!';
$system_textes['de']['core']['file_not_included'] =  'Datei konnte nicht included werden!!!';
$system_textes['de']['core']['modul_not_found'] = 'Modul nicht gefunden';
$system_textes['de']['core']['modul_load_error'] = 'Fehler beim Modulladen';
$system_textes['de']['core']['class_not_exists'] = 'Klasse nicht vorhanden!!!';
$system_textes['de']['core']['class_lost'] = 'Klasse fehlt';
$system_textes['de']['core']['not_accessible'] = 'Nicht erreichbar';
$system_textes['de']['core']['now_not_accessible'] = 'ist zur Zeit nicht erreichbar';


//**MySQL
$system_textes['de']['mysql'] = array();
$system_textes['de']['mysql']['server_connection_failed'] = 'Verbindung zum Mysql-Server fehlgeschlagen';
$system_textes['de']['mysql']['query_not_masked'] = 'Mysql-Anfrage konnte nicht maskiert werden';
$system_textes['de']['mysql']['query_not_string'] = 'Angegebener Mysql-Query ist kein String';
$system_textes['de']['mysql']['query_invalid'] = 'Mysql-Query ist ungültig"';
$system_textes['de']['mysql']['server_not_closed'] = 'Mysql-Verbindung konnte nicht auf Anfrage geschlossen werden';

//**Form
$system_textes['de']['form'] = array();
$system_textes['de']['form']['wrong_parameter'] = 'Falsche Parameterangaben in Funktion -  1. oder 2. Parameter kein Array';
$system_textes['de']['form']['file_countr_not_found'] = 'Datei mit Länderendungen nicht gefunden';

//**MessageBoxen
$system_textes['de']['msg_box'] = array();
$system_textes['de']['msg_box']['wrong_param_mysql'] = 'Falsche Parameterangaben. Parameter ist kein mysql-objekt';
$system_textes['de']['msg_box']['wrong_param_string'] = 'Falsche Parameterangaben. Parameter ist kein String';
$system_textes['de']['msg_box']['wrong_param_mysqltab'] = 'Falsche Parameterangaben. Keine passende Mysql-Tabelle vorhanden';
$system_textes['de']['msg_box']['wrong_param_key'] = 'Falsche Parameterangaben. Parameter beinhahlte nicht ein Index ID, Content- oder Zeit-Schluessel';
$system_textes['de']['msg_box']['wrong_param_array'] = 'Falsche Parameterangaben. Parameter ist kein Array';
$system_textes['de']['msg_box']['wrong_param_text'] = 'Falsche Parameterangaben. Kein Text angegeben';
$system_textes['de']['msg_box']['no_check_valid'] = 'Eingaben wurde nicht auf Gültigkeit ueberprueft';
$system_textes['de']['msg_box']['wrong_param_int'] = 'Falsche Parameterangaben. Angegeben ID ist kein Int-Wert';
$system_textes['de']['msg_box']['wrong_param_num'] = 'Falsche Parameterangaben. Argument ist kein Zahlenwert';
$system_textes['de']['msg_box']['wrong_param_invalid'] = 'Falsche Parameterangaben. Argument nicht zulässig';
$system_textes['de']['msg_box']['wrong_param_time'] = 'Falsche Parameterangaben. Argument ist keine Zeitangabe';

//**Content
$system_textes['de']['content'] = array();
//Texte aus den Sprachvariablen der MessageBoxen holen, da sich diese überschneiden
array_push($system_textes['de']['content'], $system_textes['de']['msg_box']);
$system_textes['de']['content']['runtime_error'] = 'Laufzeit-Fehler';
$system_textes['de']['content']['no_content_id'] = 'Daten ungültig. Content-ID verlangt';
$system_textes['de']['content']['no_menu_id'] = 'Daten ungültig. Menu-ID verlangt';

//**Gbook
$system_textes['de']['gbook'] = array();
$system_textes['de']['gbook']['invalid_option'] = 'Gewählte Option nicht möglich';

//**Mail
$system_textes['de']['mail'] = array();
$system_textes['de']['mail']['invalid_param'] = 'Die Parameternangaben sind ungültig. Bitte geben Sie richtige Parameter an oder lassen Sie es';
$system_textes['de']['mail']['param_navid'] = 'Parameter `nav_id` nicht angegeben';
$system_textes['de']['mail']['param_missing'] = 'Parameter fehlt';
$system_textes['de']['mail']['modul_no_mail'] = 'Angegebenes Modul unterstützt kein Mailversand';
$system_textes['de']['mail']['no_support'] = 'Keine Mailunterstüzung';
$system_textes['de']['mail']['no_matching_table1'] = 'Angegebene Tabelle oder Tabellenstruktur nicht vorhanden';
$system_textes['de']['mail']['no_matching_table2'] = 'Keine passende Tabelle';
$system_textes['de']['mail']['wrong_form'] = 'Sie benutzen das falsche Formular für diese Mailadresse';
$system_textes['de']['mail']['no_hash'] = 'Parameter `hash` nicht angegeben';
$system_textes['de']['mail']['data_collaps'] = 'Datenkollision';


//**Menu
$system_textes['de']['menu'] = array();
//Texte aus den Sprachvariablen von Content holen, da sich diese überschneiden
array_push($system_textes['de']['menu'], $system_textes['de']['content']);
$system_textes['de']['menu']['no_matching_id'] = 'Angegeben ID für Menueintrag ist nicht vorhanden';
$system_textes['de']['menu']['invalid_id'] = 'Ungültige ID';

//**News
$system_textes['de']['news'] = array();
$system_textes['de']['news']['invalid_url'] = 'Sie haben falsche URL-Parameter weitergegeben. Daher konnte keine entsprechende Aktion ausgeführt werden';

//**Image
$system_textes['de']['img'] = array();
$system_textes['de']['img']['no_img_param'] = 'kein Bild über &img=... angegeben';
$system_textes['de']['img']['param_error'] = 'Parameterfehler';
$system_textes['de']['img']['error_open_file'] = 'Die Bilddatei konnte nicht geöffnet werten!';
$system_textes['de']['img']['error_open'] = 'Fehler beim Öffnen';

//**Exception
$system_textes['de']['excn'] = array();
$system_textes['de']['excn']['cms_core_error'] = 'CMS-Core-Fehler';
$system_textes['de']['excn']['mysql_error'] = 'Mysql-Fehler';
$system_textes['de']['excn']['modul_error'] = 'Modul-Fehler';
$system_textes['de']['excn']['libary_error'] = 'Libary-Fehler';
$system_textes['de']['excn']['error'] = 'Fehler';
$system_textes['de']['excn']['error_in_file'] = 'Es ist ein Fehler aufgetreten in der Datei';
$system_textes['de']['excn']['on_line'] = 'auf der Zeile';
$system_textes['de']['excn']['with_msg'] = 'mit folgendern Nachricht';
$system_textes['de']['excn']['jclub_error'] = 'Jclub -  Fehler';
$system_textes['de']['excn']['unexcn_error'] = 'Es ist ein unerwarteter Fehler aufgetreten';
$system_textes['de']['excn']['error_table'] = 'Fehlertabelle';
$system_textes['de']['excn']['file'] = 'Datei';
$system_textes['de']['excn']['line'] = 'Zeile';
$system_textes['de']['excn']['message'] = 'Nachricht';
$system_textes['de']['excn']['trace'] = 'Trace';
$system_textes['de']['excn']['exp_error_often'] = $system_textes['de']['core']['exp_error_often'];


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