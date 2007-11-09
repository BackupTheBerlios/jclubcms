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
require_once ADMIN_DIR.'config/global-config.inc.php';
require_once ADMIN_DIR.'config/functions.inc.php';


//notwendige Module laden
require_once ADMIN_DIR.'lib/mysql.class.php';
require_once ADMIN_DIR.'lib/Smarty/Smarty.class.php';

require_once ADMIN_DIR.'lib/auth.class.php';
require_once ADMIN_DIR.'lib/session.class.php';
require_once ADMIN_DIR.'lib/page.class.php';

require_once ADMIN_DIR.'lib/cmsexception.class.php';

set_exception_handler(array('CMSException', 'stdExceptionHandler'));


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

	private $gpc = array('GET' => array(), 'POST' => array(), 'COOKIE' => array());

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
		//Abfangen von Exceptions
		try {
			$this->initObjects();
			$this->checkGpc();

			$this->smarty_array = array();

			if (ADMIN_DIR == './') {
				$this->is_admin = true;
				$this->checkAdmin();
			}

			$this->initPage();

		} catch(CMSException $e) {

			$strTrace = '#'.str_replace('#', "<br />\n#", substr($e->getTraceAsString(), 1));
			//Ist Smarty nicht vorhanden, wird eine Nachricht ueber den Exceptionhandler geschickt, der kein Smarty braucht.
			if (!class_exists('Smarty') || !($this->smarty instanceof Smarty)) {
				CMSException::printException($e->getFilename(), $e->getLine(), $e->getMessage(), $strTrace);
			}

			$this->smarty_array['file'] = 'error_include.tpl';
			$this->smarty_array['error_title'] = $e->getTitle();
			$this->smarty_array['error_text'] = $e->getMessage()."<br />\nFehler aufgetreten in der Datei ".$e->getFilename()." auf Zeilenummer ".$e->getLine();
			$this->smarty_array['error_text'] .= "<br />\n".$strTrace;
			$this->smarty->assign($this->smarty_array);
			$this->smarty->display('index.tpl');



		}
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
		$globals = array('GET' => $_GET, 'POST' => $_POST, 'COOKIE' => $_COOKIE);

		if (get_magic_quotes_gpc() == 0) {
			$activ = false;
		} else {
			$activ = true;
		}

		foreach ($globals as $gkey => $gvalue) {

			foreach ($gvalue as $key => $value) {

				//Bei inkativen magic_quotes_gpc we
				if ($activ == false) {
					$value = addslashes($value);
				}

				$this->gpc[$gkey][$key] = $value;

			}

		}

		unset($_GET);
		unset($_POST);
		unset($_COOKIE);
		unset($_REQUEST);

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
		if(array_key_exists('action', $this->gpc['GET']) && $this->gpc['GET']['action'] == 'logout') {
			$auth->logout();
			exit;
		}

		//Haltet nach Login oder User ausschau (inkl. Sicherheitstest)
		if(($this->auth->check4login($this->gpc['POST']) == true) || ($this->auth->check4user($this->gpc['GET']) == false))
		{
			exit;
		}
	}



	/**
	 * Initialisiert den Seiteninhalt
	 *
	 */

	private function initPage()
	{
		global $start_time;
		$this->tplfile = 'index.tpl';

		if ($this->is_admin == true) {
			$table = 'admin_menu';
			$shortlink = true;
		} else {
			$table = 'menu';
			$shortlink = false;
		}

		$this->loadNav($shortlink);

		$this->mysql->query("SELECT `menu_pagetyp`, `menu_page` FROM `$table` WHERE `menu_ID`= '{$this->nav_id}'");
		$data = $this->mysql->fetcharray("assoc");

		$page_id = (int)$data['menu_page'];

		if ($data['menu_pagetyp'] == 'mod') {
			$this->loadModule($page_id);

		} elseif ($data['menu_pagetyp'] == 'pag') {
			$this->loadContent($page_id);

		} else {
			throw new CMSException("Das angegebene Modul konnte nicht gefunden werden", null, 'Modul nicht vorhanden');
		}

		$this->smarty->assign('shortlink', $shortlink);

		$this->smarty->assign('generated_time', round(((float)(microtime(true) - $start_time)),5));


		$this->smarty->assign($this->smarty_array);
		$this->smarty->display($this->tplfile);



	}

	/**
	 * Laedt die Navigation und speicher sie in $this->smarty_array
	 *
	 * @parambooleane $shortlinks
	 */

	private function loadNav($shortlinks = false)
	{
		if ($this->is_admin === true) {
			$adminmenu = true;
		} else {
			$adminmenu = false;
		}

		$nav_array = $this->page->get_menu_array($this->gpc['GET'], $shortlinks, $adminmenu);
		$this->smarty_array['topnav'] = $nav_array['topnav'];
		$this->smarty_array['subnav'] = $nav_array['subnav'];
		$this->smarty_array['local_link'] = ($this->nav_id = $nav_array['nav_id']);

		if ($this->is_admin === true) {
			$menu_table = 'admin_menu';
			$mod_table = 'admin_modules';
		} else {
			$menu_table = 'menu';
			$mod_table = 'modules';
		}


		$this->mysql->query("SELECT `$menu_table`.`menu_ID` as 'image_ID' FROM `$menu_table`, `$mod_table` WHERE `$mod_table`.`modules_file` = 'image_send.class.php' AND `$mod_table`.`modules_ID` = `$menu_table`.`menu_page` AND `$menu_table`.`menu_pagetyp` = 'mod' LIMIT 1");
		$data = $this->mysql->fetcharray('assoc');

		$this->smarty_array['image_link'] = $data['image_ID'];

		$this->mysql->query("SELECT `$menu_table`.`menu_ID` as 'captcha_ID' FROM `$menu_table`, `$mod_table` WHERE `$mod_table`.`modules_file` = 'captcha_image.class.php' AND `$mod_table`.`modules_ID` = `$menu_table`.`menu_page` AND `$menu_table`.`menu_pagetyp` = 'mod' LIMIT 1");
		$data = $this->mysql->fetcharray('assoc');
		
		$this->smarty_array['captcha_link'] = $data['captcha_ID'];

	}

	/**
	 * Laedt ein Modul und fuehrt es aus. Anschliessend wird das zugehoerige Template im $smarty_arry gespeichert
	 *
	 * @param int $module_ID
	 */


	private function loadModule($module_ID)
	{
		//Kann ueberschrieben, aber damit sicher etwas steht -> speichern
		$this->smarty->assign('content_title', 'JClub');

		if ($this->is_admin == true) {
			$mod_table = 'admin_modules';
		} else {
			$mod_table = 'modules';
		}

		//Modul aus Datenbank lesen
		$this->mysql->query("SELECT `modules_file`,`modules_template` FROM `$mod_table` WHERE `modules_ID`= '$module_ID' LIMIT 1");
		$data = $this->mysql->fetcharray("assoc");

		if (empty($data) && $data == false) {
			throw new CMSException("Für die angegebene Modul-ID ist kein Modul hinterlegt!!!", null, 'Modul nicht gefunden');
			return;
		}

		//Modul-Path ermittelnt
		if ($this->is_admin == true) {
			$path = ADMIN_DIR.'modules/'.$data['modules_file'];
		} else {
			$path = USER_DIR.'modules/'.$data['modules_file'];
		}

		/**Sicherheitscheck noch machen, ob Datei im richtigen Ordner!**/

		//File pruefen
		if(!file_exists($path)) {
			throw new CMSException("Datei $path konnte nicht included werden!!!", null, 'Fehler beim Modulladen');
			return;
		}

		//Modul einbinden
		include_once($path);

		//Klassennamen herausfinden
		$split = explode(".", $data['modules_file']);
		$class = ucfirst($split[0]);	//Klassen sind "first-character-uppercase"

		//Existenz der Klasse pruefen
		if(!class_exists($class)) {
			throw new CMSException("Klasse $class nicht vorhanden!!!", null, 'Klasse fehlt');
			return;
		}
	
		//Modul ausfuehren
		$module = new $class($this->mysql, $this->smarty);
		$module->action($this->gpc);	


		//Wenn das Modul kein Tmplate zurueckgibt -> Beenden
		if ($data['modules_template'] == 'no') {
			exit;
		}

		$this->smarty_array['file'] = $module->gettplfile();

	}


	/**
	 * Laedt den Inhalt aus der Datenbank mit der angegebenen ID
	 *
	 * @param int $page_ID
	 */

	private function loadContent($page_ID)
	{
		if ($this->is_admin == true) {
			$cnt_table = 'admin_content';
		} else {
			$cnt_table = 'content';
		}
		$this->mysql->query("SELECT `content_title`, `content_text` FROM `$cnt_table` WHERE `content_ID` = $page_ID");
		$data = $this->mysql->fetcharray("assoc");
		$content_title = $data['content_title'];
		$content_text = $data['content_text'];
		$this->smarty_array += array('content_title' => $content_title, 'content_text' => $content_text);
	}

}



?>