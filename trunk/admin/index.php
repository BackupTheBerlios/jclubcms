<?php
/**
 * @author Simon Däster
 * @package JClubCMS
 * Index.php
 * 
 * Diese Seite ist für das Anzeigen der Administrationsoberfläche verantwortlich und lädt alle notwendigen Module.
 */

$microtime = microtime();

//Config laden
require_once('../config/config.inc.php');
require_once('./config/auth_config.inc.php');

//notwendige Module laden
require_once('../modules/mysql.class.php');
require_once('../Smarty/Smarty.class.php');

require_once('./modules/auth.class.php');
require_once('./modules/session.class.php');

$mysql = new mysql($db_server, $db_name, $db_user, $db_pw);

//Smarty-Objekt
$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;

$auth = new auth($smarty, $mysql);

echo "Index: Nach Login ausschau halten<br />\n";

if($auth->check4login() == true)
{
	echo "Index: Jemand ist am Login<br />\n";
	exit();
}


echo "Index: Nach User ausschau halten<br />\n";

if($auth->check4user() == false)
{
	echo "Index: Kein User da<br />\n";
	exit();
}



echo "Index: Ende der Datei<br />\n"

/*
//Ist der Benutzer eingeloggt
if($session->is_logged() == false)
{
	header("Location: http://" . $_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."/login.php");
	exit;
}

//Überprüfen des rechtmässigen Zugriffs
if($session->security_check() == false)
{
	$smarty->display("login_error.tpl");
	exit;
}




//Mysql-Objekt
$mysql = new mysql($db_server, $db_name, $db_user, $db_pw);

$mysql->query("SELECT menu_ID, menu_name FROM menu WHERE menu_topid=0 and `menu_display` != '0' ORDER BY menu_position ASC");
$nav_array = array();
$i = 0;
while ($nav_data = $mysql->fetcharray()) {
	$nav_array[$i] = array('menu_ID'=>$nav_data["menu_ID"], 'menu_name'=>$nav_data["menu_name"]);
	$i++;
}

$smarty->assign("nav", $nav_array);

//Kontrolle der Get-Variable $_GET['nav_id']. Zur Vereinfachung in $nav_id gespeichert
$nav_id = (int) $_GET["nav_id"];
if ($nav_id <= 0) {
	$nav_id = $nav_array[0]['menu_ID'];
}
*/

/**
 * Hier werden alle Verweise ausgelesen: ID, höhere Navigation (topid), Position, Name,
 * zugehörige Seite (page) und ob Modul oder Page £
 */
/*
$mysql->query("SELECT * FROM menu WHERE menu_ID = $nav_id");
$page_data = $mysql->fetcharray();

$page_id = $page_data["menu_page"];
*/
?>