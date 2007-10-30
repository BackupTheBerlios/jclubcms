<?php

/**
 * file: core.class.php
 * Die core-Datei erledigt:
 * -laedt notweindige Libaries
 * -registriert den Exception-Handler
 * 
 * Die core-Klasse erledigt folgendes:
 * -Erstellten der notwendigen Objekte (smarty, mysql)
 * -Initialiesieren der Rechteverwaltung und testen auf erfolgreiches login
 * -Erstellen der Navigation
 * -Ueberpruefen der Benutzerangaben ueber $_GET / $_POST
 * -Aufrufen des geladenen Moduls
 * -Aufrufen des geladenen Moduls
 * 
 */



error_reporting(E_ALL | E_STRICT); //Zu Debug-Zwecken

$start_time = microtime(true);

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

set_exception_handler(array('CMSException', 'stdExceptionHandler'));

//Abfangen von Exceptions
try {
	class Core
	{
		/**
		 * Mysql-Objekt
		 *
		 * @var Mysql
		 */
		private $mysql = null;
		/**
		 * Smarty-Objekt
		 *
		 * @var Smarty
		 */
		private $smarty = null;
		/**
		 * Auth-Objekt
		 *
		 * @var Auth
		 */
		private $auth = null;
		/**
		 * Page-Objekt
		 *
		 * @var Page
		 */
		private $page = null;

		/**
		 * Admin-Modus?
		 *
		 * @var boolean
		 */
		private $is_admin = false;

		/**
		 * Smarty-Array
		 *
		 * @var array
		 */
		private $smarty_array = null;
		/**
		 * Enthaelt kontrollierte GET, POST, COOKIE-Parameter
		 *
		 * @var array
		 */

		private $gpc = array('GET' => null, 'POST' => null, 'COOKIE' => null);

		/**
		 * Navigations-Id
		 * 
		 * @var string
		 */
		private $nav_id = null;

		/**
		 * Template-Datei
		 *
		 * @var string
		 */		
		private $tplfile = null;


		/**
		 * Aufbau der Klasse
		 *
		 */

		public function __construct()
		{
			$this->initObjects();
			$this->checkGpc();

			$this->smarty_array = array();

			if (ADMIN_DIR == './') {
				$this->is_admin = true;
				$this->checkAdmin();
			}

			$this->initPage();
		}

		/**
		 * Initialsieren der Objekte
		 *
		 */

		private function initObjects()
		{
			global $db_server, $db_name, $db_user, $db_pw;
			//Smarty-Objekt
			$this->smarty = new Smarty();
			$this->smarty->compile_check = true;
			$this->smarty->debugging = false;

			$this->mysql = new Mysql($db_server, $db_name, $db_user, $db_pw);


			$this->page = new Page($this->smarty, $this->mysql);
			$this->auth = new Auth($this->smarty, $this->mysql);
		}

		/**
		 * Kontrolliere, ob magic_quotes_gpc ON, sonst selber veraendern
		 *
		 */

		private function checkGpc()
		{
			//Wenn's nicht laeuft, muessen uebermittelte Variablen geparst werden
			if(get_magic_quotes_gpc() == 0) {

				foreach($_GET as $key => $value) {
					$this->gpc['GET'] = addslashes($value);
					unset($_GET[$key]);
				}

				foreach($_POST as $key => $value) {
					$this->gpc['POST'] = addslashes($value);
					unset($_POST[$key]);
				}

				foreach($_COOKIE as $key => $value) {
					$this->gpc['COOKIE'] = addslashes($value);
					unset($_COOKIE[$key]);
				}
			}
		}


		/**
		 * Durchfuehren der Admin-Kontrollen zum Einloggen in den Admin-Bereich
		 *
		 */

		private function checkAdmin()
		{

			if ($this->is_admin != true) {
				throw new CMSException('Interne Funktion nicht ausfuehrbar', EXCEPTION_CORE_CODE);
			}

			//Testet auf Logout und fuehrt es durch
			if(array_key_exists('action', $_GET) && $_GET['action'] == 'logout') {
				$auth->logout();
				exit();
			}

			//Haltet nach Login oder User ausschau (inkl. Sicherheitstest)
			if(($this->auth->check4login() == true) || ($this->auth->check4user() == false))
			{
				exit();
			}
		}



		/**
		 * Initialisiert den Seiteninhalt
		 *
		 */

		private function initPage()
		{
			$this->tplfile = 'index.tpl';

			$admin_menu_shortlinks = true;

			$this->loadNav($admin_menu_shortlinks);

			if ($this->is_admin == true) {
				$table = 'admin_menu';
			} else {
				$table = 'menu';
			}

			$this->mysql->query("SELECT `menu_pagetyp`, `menu_page` FROM `$table` WHERE `menu_ID`= '{$this->nav_id}'");
			$data = $this->mysql->fetcharray("assoc");

			$page_id = (int)$data['menu_page'];

			if ($data['menu_pagetyp'] == 'mod') {
				$loaded = $this->loadModule($page_id);

			} elseif ($data['menu_pagetyp'] == 'pag') {
				$loaded = $this->loadContent($page_id);

			} else {
				$content_text = "Das angegebene Modul konnte nicht gefunden werden<br />\n";
				$smarty_array += array('error_title' => 'Modul nicht vorhanden', 'error_text' => $content_text, 'file' => 'error_include.tpl');
			}

			$this->smarty->assign('shortlink', $admin_menu_shortlinks?1:0);

			$this->smarty->assign('generated_time', round((microtime(true) - $start_time), 4));

			$this->smarty->assign($this->smarty_array);
			$this->smarty->display($this->tplfile);



		}

		/**
		 * Laedt die Navigation und speicher sie in $this->smarty_array
		 *
		 */

		private function loadNav($shortlinks = false)
		{
			if ($this->is_admin == true) {
				$admin = true;
			} else {
				$admin = false;
			}

			$nav_array = $this->page->get_menu_array($shortlinks, $admin);
			$this->smarty_array['topnav'] = $nav_array['topnav'];
			$this->smarty_array['subnav'] = $nav_array['subnav'];
			$this->smarty_array['local_link'] = ($this->nav_id = $nav_array['nav_id']);

		}

		/**
		 * Laedt ein Modul und fuehrt es aus. Anschliessend wird das zugehoerige Template im $smarty_arry gespeichert
		 *
		 * @param int $module_ID
		 */

		private function loadModule($module_ID)
		{
			//Kann ueberschrieben, aber damit sicher etwas steht -> speichern
			$this->smarty->assign('content_title', 'JClub - Administration');

			if ($this->is_admin == true) {
				$mod_table = 'admin_modules';
			} else {
				$mod_table = 'modules';
			}

			//Modul aus Datenbank lesen
			$this->mysql->query("SELECT `modules_name` FROM `$mod_table` WHERE `modules_ID`= '$module_ID' LIMIT 1");
			$data = $this->mysql->fetcharray("assoc");

			if (empty($data) && $data == false) {
				$content_text = "Angegebene Modul-ID nicht vorhanden!!!<br />\n";
				$this->smarty_array += array('error_title' => 'Modul nicht gefunden', 'error_text' => $content_text, 'file' => 'error_include.tpl');
				return;
			}

			//Modul-Path ermittelnt
			if ($is_admin == true) {
				$path = ADMIN_DIR.'modules/'.$data['modules_name'];
			} else {
				$path = USER_DIR.'modules/'.$data['modules_name'];
			}

			/**Sicherheitscheck noch machen, ob Datei im richtigen Ordner!**/

			//File pruefen
			if(!file_exists($path))
			{
				$content_text = "Datei $path konnte nicht included werden!!!<br />\n";
				$this->smarty_array += array('error_title' => 'Fehler beim Modulladen', 'error_text' => $content_text, 'file' => 'error_include.tpl');
				return;
			}

			//Modul einbinden
			include_once($path);

			//Klassennamen herausfinden
			$split = explode(".", $data['modules_name']);
			$class = ucfirst($split[0]);	//Klassen sind "first-character-uppercase"

			//Existenz der Klasse pruefen
			if(!class_exists($class)) {
				$content_text = "Klasse $class nicht vorhanden!!!<br />\n";
				$this->smarty_array += array('error_title' => 'Fehler beim Laden der Klasse', 'error_text' => $content_text, 'file' => 'error_include.tpl');
				return;
			}

			//Modul ausfuehren
			$module = new $class($this->mysql, $this->smarty);
			$module->action($this->gpc);
			$this->smarty_array['file'] = $module->gettplfile();

		}


		/**
		 * Laedt den Inhalt aus der Datenbank mit der angegebenen ID
		 *
		 * @param int $page_ID
		 */

		private function loadContent($page_ID)
		{
			$this->mysql->query("SELECT `content_title`, `content_text` FROM `admin_content` WHERE `content_ID` = {$data['menu_page']}");
			$data = $this->mysql->fetcharray("assoc");
			$content_title = $data['content_title'];
			$content_text = $data['content_text'];
			$this->smarty_array += array('content_title' => $content_title, 'content_text' => $content_text);
		}

	}



} catch(CMSException $e) {

	//Ist Smarty nicht vorhanden, wird eine Nachricht ueber den Exceptionhandler geschickt, der kein Smarty braucht.
	if (!class_exists('Smarty') || !($smarty instanceof Smarty)) {
		throw new Exception($e->getMessage(), $e->getCode());
	}

	$smarty_array['file'] = 'error_include.tpl';
	$smarty_array['error_title'] = $e->getTitle();
	$smarty_array['error_text'] = $e->getMessage()."<br />\nFehler aufgetreten in der Datei ".$e->getFilename()." auf Zeile ".$e->getLine();
	$smarty->assign($smarty_array);
	$smarty->assign('index.tpl');

}


?>