<?php
/**
 * @author Simon Daester
 * @package JClubCMS
 * Index.php
 * 
 * Diese Seite ist fuer das Anzeigen der Administrationsoberflaeche verantwortlich und laedt alle notwendigen Module.
 */

error_reporting(E_ALL|E_STRICT); //Zu Debug-Zwecken

$start_time = microtime(true);

/**Konstanten definieren**/
define("ADMIN_DIR", "./");
define("USER_DIR", "../");

//Config laden
require_once(USER_DIR.'config/config.inc.php');
require_once(ADMIN_DIR.'config/config.inc.php');
require_once(ADMIN_DIR.'config/functions.inc.php');


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

$smarty_array = array();


if($auth->check4login() == true)
{
	exit();
}

if($auth->check4user() == false)
{
	exit();
}


if($_GET['action'] == 'logout')
{
	$auth->logout();
	exit();
}

$admin_menu_shortlinks = true;

$nav_array = $page->get_menu_array($admin_menu_shortlinks, true);

//echo "<pre>".print_r($nav_array, 1)."</pre>\n";

//var_dump($error);

//echo "\$error <pre>".print_r($error, 1)."</pre>\n";
//echo "Index: Ende der Datei<br />\n";

//Wenn's nicht laeuft, muessen uebermittelte Variablen geparst werden
if(get_magic_quotes_gpc() == 1)
{
	foreach($_GET as $key => $value)
	{
		$_GET[$key] = addslashes($value);
	}
	
	foreach($_POST as $key => $value)
	{
		$_POST[$key] = addslashes($value);
	}
}

$paraGetPost = array("GET" => $_GET, "POST" => $_POST);

$mysql->query("SELECT `menu_pagetyp`, `menu_page` FROM `admin_menu` WHERE `menu_ID`= '{$nav_array['nav_id']}'");
$data = $mysql->fetcharray("assoc");

if($data['menu_pagetyp'] == "mod")
{
	$mysql->query("SELECT `modules_name` FROM `admin_modules` WHERE `modules_ID`= '{$data['menu_page']}'");
	$data = $mysql->fetcharray("assoc");
	if(!empty($data))
	{
		$path = ADMIN_DIR.'modules/'.$data['modules_name'];
		$split = explode(".", $data['modules_name']);
		$class = $split[0];
		if(file_exists($path))
		{

			require_once($path);
			$module = new $split[0]($mysql, $smarty);
			$module->action($paraGetPost);
			$smarty_array['file'] = $module->gettplfile();

		} else {
			$content_text = "Datei $path konnte nicht included werden!!!<br />\n";
			$smarty_array += array('content_title' => 'Fehler beim Modulladen', 'content_text' => $content_text, 'file' => 'main.tpl');
		}
	}
	else 
	{
		$content_text = "Modul nicht vorhanden!!!<br />\n";
		$smarty_array += array('content_title' => 'Modul nicht vorhanden', 'content_text' => $content_text, 'file' => 'main.tpl');

	}
}
elseif($data['menu_pagetyp'] == "pag")
{
	$mysql->query("SELECT `content_title`, `content_text` FROM `admin_content` WHERE `content_ID` = {$data['menu_page']}");
	$data = $mysql->fetcharray("assoc");
	$content_title = $data['content_title'];
	$content_text = $data['content_text'];
	$smarty_array[] = array('content_title' => $content_title, 'content_text' => $content_text);
}

$smarty_array += array('topnav' => $nav_array['topnav'], 'subnav' => $nav_array['subnav'], 'local_link' => $nav_array['nav_id']);
$smarty->assign($smarty_array);


$smarty->assign('shortlink', $admin_menu_shortlinks?1:0);

$smarty->assign('generated_time', round((microtime(true) - $start_time), 4));
$smarty->display('index.tpl');

//print_r($smarty_array);
/*

*/
?>
