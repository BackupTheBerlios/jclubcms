<?php
/**
 * @author Simon Daester
 * @package JClubCMS
 * Index.php
 * 
 * Diese Seite ist fuer das Anzeigen der Administrationsoberflaeche verantwortlich und laedt alle notwendigen Module.
 */



error_reporting(E_ALL | E_STRICT); //Zu Debug-Zwecken

$start_time = microtime(true);

/**Konstanten definieren**/
define("ADMIN_DIR", "./");
define("USER_DIR", "../");

//Config laden
require_once USER_DIR.'config/config.inc.php';
require_once ADMIN_DIR.'config/config.inc.php';
require_once ADMIN_DIR.'config/functions.inc.php';


//notwendige Module laden
require_once ADMIN_DIR.'lib/mysql.class.php';
require_once ADMIN_DIR.'lib/Smarty/Smarty.class.php';

require_once ADMIN_DIR.'lib/auth.class.php';
require_once ADMIN_DIR.'lib/session.class.php';
require_once ADMIN_DIR.'lib/page.class.php';

require_once ADMIN_DIR.'lib/cmsexception.class.php';

//Abfangen von Exceptions

try {
	set_exception_handler(array('CMSException', 'stdExceptionHandler'));
	
	//Smarty-Objekt
	$smarty = new Smarty();
	$smarty->compile_check = true;
	$smarty->debugging = false;
	
	$mysql = new mysql($db_server, $db_name, $db_user, $db_pw);


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


	if(array_key_exists('action', $_GET) && $_GET['action'] == 'logout')
	{
		$auth->logout();
		exit();
	}
	

	$admin_menu_shortlinks = true;

	$nav_array = $page->get_menu_array($admin_menu_shortlinks, true);

	//Wenn's nicht laeuft, muessen uebermittelte Variablen geparst werden
	if(get_magic_quotes_gpc() == 0)
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

	if ($data['menu_pagetyp'] == "mod") {
		//Kann ueberschrieben, aber damit sicher etwas steht -> speichern
		$smarty->assign('content_title', 'JClub - Administration');

		$mysql->query("SELECT `modules_name` FROM `admin_modules` WHERE `modules_ID`= '{$data['menu_page']}'");
		$data = $mysql->fetcharray("assoc");

		if (!empty($data) && $data !== false)
		{
			$path = ADMIN_DIR.'modules/'.$data['modules_name'];
			$split = explode(".", $data['modules_name']);
			$class = $split[0];
			if(file_exists($path))
			{
				include_once($path);

				if(class_exists($class)) {
					$module = new $class($mysql, $smarty);
					$module->action($paraGetPost);
					$smarty_array['file'] = $module->gettplfile();

				} elseif (class_exists(ucfirst($class))) {
					$class = ucfirst($class);
					$module = new $class($mysql, $smarty);
					$module->action($paraGetPost);
					$smarty_array['file'] = $module->gettplfile();

				} else {
					$content_text = "Klasse $class nicht vorhanden!!!<br />\n";
					$smarty_array += array('error_title' => 'Fehler beim Laden der Klasse', 'error_text' => $content_text, 'file' => 'error_include.tpl');

				}



			} else {
				$content_text = "Datei $path konnte nicht included werden!!!<br />\n";
				$smarty_array += array('error_title' => 'Fehler beim Modulladen', 'error_text' => $content_text, 'file' => 'error_include.tpl');
			}
		} else {
			$content_text = "Modul nicht vorhanden!!!<br />\n";
			$smarty_array += array('error_title' => 'Modul nicht vorhanden', 'error_text' => $content_text, 'file' => 'error_include.tpl');

		}

	} elseif ($data['menu_pagetyp'] == "pag") {
		$mysql->query("SELECT `content_title`, `content_text` FROM `admin_content` WHERE `content_ID` = {$data['menu_page']}");
		$data = $mysql->fetcharray("assoc");
		$content_title = $data['content_title'];
		$content_text = $data['content_text'];
		$smarty_array += array('content_title' => $content_title, 'content_text' => $content_text);

	} else {
		$content_text = "Modul nicht vorhanden!!!<br />\n";
		$smarty_array += array('error_title' => 'Modul nicht vorhanden', 'error_text' => $content_text, 'file' => 'error_include.tpl');

	}

	
	
}  catch(CMSException $e) {

	//Ist Smarty nicht vorhanden, wird eine Nachricht ueber den Exceptionhandler geschickt, der kein Smarty braucht.
	if (!class_exists('Smarty') || !($smarty instanceof Smarty)) {
		throw new Exception($e->getMessage(), $e->getCode());
	}

	$smarty_array['file'] = 'error_include.tpl';
	$smarty_array['error_title'] = $e->getTitle();
	$smarty_array['error_text'] = $e->getMessage()."<br />\nFehler aufgetreten in der Datei ".$e->getFilename()." auf Zeile ".$e->getLine();

}

$smarty_array += array('topnav' => $nav_array['topnav'], 'subnav' => $nav_array['subnav'], 'local_link' => $nav_array['nav_id']);
	$smarty->assign($smarty_array);


	$smarty->assign('shortlink', $admin_menu_shortlinks?1:0);


	$smarty->assign('generated_time', round((microtime(true) - $start_time), 4));
	$smarty->display('index.tpl');

?>
