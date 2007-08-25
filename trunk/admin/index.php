<?php
/**
 * @author Simon Daester
 * @package JClubCMS
 * Index.php
 * 
 * Diese Seite ist f�r das Anzeigen der Administrationsoberfl�che verantwortlich und l�dt alle notwendigen Module.
 */

error_reporting(E_ALL); //Zu Debug-Zwecken

$microtime = microtime();

/**Konstanten definieren**/
define("ADMIN_DIR", "./");
define("USER_DIR", "../");

//Config laden
require_once(ADMIN_DIR.'config/config.inc.php');
require_once(ADMIN_DIR.'config/functions.inc.php');
require_once(USER_DIR.'config/config.inc.php');

//notwendige Module laden
require_once(ADMIN_DIR.'lib/mysql.class.php');
require_once(ADMIN_DIR.'lib/Smarty/Smarty.class.php');

require_once(ADMIN_DIR.'lib/auth.class.php');
require_once(ADMIN_DIR.'lib/session.class.php');
require_once(ADMIN_DIR.'lib/page.class.php');

$mysql = new mysql($db_server, $db_name, $db_user, $db_pw);

//Smarty-Objekt
$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;

$page = new Page($smarty, $mysql);
$auth = new Auth($smarty, $mysql);


if($auth->check4login() == true)
{
	exit();
}

if($auth->check4user() == false)
{
	exit();
}




$nav_array = $page->get_menu_array(true, true);

//echo "<pre>".print_r($nav_array, 1)."</pre>\n";

//var_dump($error);

//echo "\$error <pre>".print_r($error, 1)."</pre>\n";
//echo "Index: Ende der Datei<br />\n";

switch ($nav_array['nav_id'])
{
	case 1:
	case 2:
	case 3:
	case 4:
		$content_title = "<b>!!!!!:::::!!!!!!FEHLER!!!!!:::::!!!!!!</b>";
		$content_text = "asdfasgsdfgawerafjpu12347859tur8a9t7qrwet<br />\nöadjföasjdfqwpeurqiwuerpijfjasdkfjasdfpjjjpwejqrpwkjer<br />\nöajkdfjapefujqwperirqwerqwerqwerqwerqwefasdfqwurq2348ur5qqerjqeipruqpwaskjfaskjpgupiuqtpertqwe564564qwe7rwerqwr^'12^3412341129380jrgjg0r9tu9425u34513 nadfakjasdfkjqwerj weqruqw8r123ru<br />\n
		<b>Syst&ouml;asd Absturz!477 BITTE INFORORMIEREN SIE UNVERZ&Uuml;GLICH DEN ADMINISTRATOR</b><br />\n<br />\nIch habe ja gesagt, dass es einen Fehler gibt :->";
		break;
	default:
		$content_title = "Index";
		$content_text = "Hallo und herzlich Willkommen im Admin-Menu<br />\nBitte dr&uuml;cken Sie nicht auf die Links im Menu, es f&uuml;hrt nur zu Fehlern :-)";

}

$mysql->query("SELECT `menu_pagetyp`, `menu_page` FROM `admin_menu` WHERE `menu_ID`= '{$nav_array['nav_id']}'");
$data = $mysql->fetcharray("assoc");

if($data['menu_pagetyp'] == "mod")
{
	$mysql->query("SELECT `modules_name` FROM `admin_modules` WHERE `modules_ID`= '{$data['menu_page']}'");
	$data = $mysql->fetcharray("assoc");
	$path = ADMIN_DIR.'modules/'.$data['modules_name'];
	if(file_exists($path))
	{
		require_once($path);
	} else {
		$content_text = "Datei $path konnte nicht included werden!!!<br />\n";
	}
} 
elseif($data['menu_pagetyp'] == "pag")
{
	$mysql->query("SELECT `content_title`, `content_text` FROM `admin_content` WHERE `content_ID` = {$data['menu_page']}");
	$data = $mysql->fetcharray("assoc");
	$content_title = $data['content_title'];
	$content_text = $data['content_text'];
}

$smarty_array = array('content_title' => $content_title, 'content_text' => $content_text, 'file' => 'main.tpl', 'topnav' => $nav_array['topnav'], 'subnav' => $nav_array['subnav']);
$smarty->assign($smarty_array);
$smarty->display('index.tpl');
/*

*/
?>