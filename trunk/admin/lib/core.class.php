<?php

/**
 * @package JClubCMS
 * @author Simon Däster
 * File: core.class.php
 * Classes: core
 * Requires: PHP5
 * 
 * 
 * Die core-Datei erledigt:
 * -laedt notweindige Libaries
 * -registriert den Exception-Handler
 * 
 * Die core-Klasse erledigt folgendes:
 * -Erstellten der notwendigen Objekte (smarty, mysql)
 * -Initialiesieren der Rechteverwaltung und testen auf erfolgreiches login
 * -Erstellen der Navigation
 * -Ueberpruefen der Benutzerangaben ueber $_GET / $_POST / $_COOKIE
 * -Aufrufen des geladenen Moduls
 * -Aufrufen der geladenen Seite
 * 
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
	 * Core-Objekt (das einzige!)
	 *
	 * @var Core
	 */
	private static $_core = null;
	/**
		 * Mysql-Objekt
		 *
		 * @var Mysql
		 */
	private $_mysql = null;
	/**
		 * Smarty-Objekt
		 *
		 * @var Smarty
		 */
	private $_smarty = null;
	/**
		 * Auth-Objekt
		 *
		 * @var Auth
		 */
	private $_auth = null;
	/**
		 * Page-Objekt
		 *
		 * @var Page
		 */
	private $_page = null;

	/**
		 * Admin-Modus?
		 *
		 * @var boolean
		 */
	private $_is_admin = false;

	/**
		 * Smarty-Array
		 *
		 * @var array
		 */
	private $_smarty_array = null;
	/**
		 * Enthaelt kontrollierte GET, POST, COOKIE-Parameter
		 *
		 * @var array
		 */

	private $_gpc = array('GET' => array(), 'POST' => array(), 'COOKIE' => array());

	/**
		 * Navigations-Id
		 * 
		 * @var string
		 */
	private $_nav_id = null;

	/**
		 * Template-Datei
		 *
		 * @var string
		 */		
	private $_tplfile = null;

	/**
	 * Über diese Methode wird das Core-Objekt initialisiert. Der Grund, warum das über diese Methode
	 * und nicht über den Konstruktor geschieht, ist folgender: Es soll nur ein Core-Objekt geben.
	 * Daher wird ein Core-Objekt mit singelton initialiert. Wurde aber vorher ein Core-Objekt initialisiert,
	 * passiert keine neue Initialisierung eines Core-Objekts. Es gibt maximal ein Objekt der Core-Klasse.
	 * @link http://www.php.net/manual/en/language.oop5.patterns.php - singleton.
	 *
	 */


	public static function singleton()
	{
		if (!isset(self::$_core) && !(self::$_core instanceof Core)) {
			self::$_core = new Core;
		}
	}

	/**
	 * Der Konstruktor baut die Klasse auf. Der Konstruktor ist privat,
	 * die Initalisierung geschieht über die Methode singelton.
	 *
	 */

	private function __construct()
	{
		//Abfangen von Exceptions
		try {
			/* Ausgabe-Pufferung aktivieren - wird bei initPage geleert*/
			//ob_start(array(&$this, "_output_callback"));
			$this->_initObjects();
			$this->_checkGpc();

			$this->_smarty_array = array();

			if (ADMIN_DIR == './') {
				$this->_is_admin = true;
				$this->_checkAdmin();
			}

			$this->_initPage();

		} catch(CMSException $e) {

			$strTrace = '#'.str_replace('#', "<br />\n#", substr($e->getTraceAsString(), 1));
			//Ist Smarty nicht vorhanden, wird eine Nachricht ueber den Exceptionhandler geschickt, der kein Smarty braucht.
			if (!class_exists('Smarty') || !($this->_smarty instanceof Smarty)) {
				CMSException::printException($e->getFilename(), $e->getLine(), $e->getMessage(), $strTrace);

			} else {

				$this->_smarty_array['file'] = 'error_include.tpl';
				$this->_smarty_array['error_title'] = $e->getTitle();
				$this->_smarty_array['error_text'] = $e->getMessage()."<br />\nFehler aufgetreten in der Datei ".$e->getFilename()." auf Zeilenummer ".$e->getLine();
				$this->_smarty_array['error_text'] .= "<br />\n"."<div style=\"font-size: 11px\">".$strTrace."</div>";
				$this->_smarty->assign($this->_smarty_array);
				$this->_smarty->display('index.tpl');
			}



		}
	}

	/**
	 * Initialisiert die nötigen Objekte für den Aufbau des CMS.
	 * @deprecated Verwendung der globalen Variablen
	 *
	 */

	private function _initObjects()
	{
		global $db_server, $db_name, $db_user, $db_pw;
		//Smarty-Objekt
		$this->_smarty = new Smarty();
		$this->_smarty->compile_check = true;
		$this->_smarty->debugging = false;
		$this->_smarty->config_dir = 'config';

		$this->_mysql = new Mysql($db_server, $db_name, $db_user, $db_pw);


		$this->_page = new Page($this->_smarty, $this->_mysql);
		$this->_auth = new Auth($this->_smarty, $this->_mysql);
	}

	/**
	 * Kontrolliere, ob die globalen Variablen "geslashet" sind.
	 * Überprüft, ob magic_quotes_gpc ON ist (automatisches Slashen). Ist dies nicht
	 * der Fall, wird das Slashen selber gemacht.
	 *
	 */

	private function _checkGpc()
	{
		$this->_gpc = array('GET' => $_GET, 'POST' => $_POST, 'COOKIE' => $_COOKIE);

		/* Bei ausgeschalteten magic_quotes werden Slashes von Hand eingefügt */
		if (get_magic_quotes_gpc() == 0) {
			foreach ($this->_gpc as $gkey => $gvalue) {

				foreach ($gvalue as $key => $value) {

					$this->_gpc[$gkey][$key] = addslashes($value);

				}

			}
		}


		/* Nur noch die Gespeicherten Werte nutzen */
		unset($_GET);
		unset($_POST);
		unset($_COOKIE);
		unset($_REQUEST);



	}


	/**
	 * Durchfuehren der Admin-Kontrollen zum Einloggen in den Admin-Bereich
	 *
	 */

	private function _checkAdmin()
	{
		if ($this->_is_admin != true) {
			throw new CMSException('Interne Funktion nicht ausfuehrbar', EXCEPTION_CORE_CODE);
		}

		//Testet auf Logout und fuehrt es durch
		if(array_key_exists('action', $this->_gpc['GET']) && $this->_gpc['GET']['action'] == 'logout') {
			$this->_auth->logout();
			exit;
		}

		//Haltet nach Login oder User ausschau (inkl. Sicherheitstest)
		if($this->_auth->check4login($this->_gpc['POST']) == true || $this->_auth->check4user($this->_gpc['GET']) == false) {
			exit;
		}
	}



	/**
	 * Initialisiert den Seiteninhalt
	 *
	 */

	private function _initPage()
	{
		global $start_time;
		$this->_tplfile = 'index.tpl';



		if ($this->_is_admin == true) {
			$table = 'admin_menu';
			$shortlink = true;
		} else {
			$table = 'menu';
			$shortlink = false;
		}

		$this->_loadNav($shortlink);
		$this->_check_spec_action();

		$this->_mysql->query("SELECT `menu_pagetyp`, `menu_page` FROM `$table` WHERE `menu_ID`= '{$this->_nav_id}'");
		$data = $this->_mysql->fetcharray("assoc");

		$page_id = (int)$data['menu_page'];

		// erste Variablen abspeichern, damit sie in den Modulen aufgerufen werden können
		$this->_smarty->assign($this->_smarty_array);
		$this->_smarty_array = array();

		if ($data['menu_pagetyp'] == 'mod') {
			$this->_loadModule($page_id);

		} elseif ($data['menu_pagetyp'] == 'pag') {
			$this->_loadContent($page_id);

		} else {
			throw new CMSException("Das angegebene Modul konnte nicht gefunden werden", null, 'Modul nicht vorhanden');
		}

		$this->_smarty_array['shortlink'] = $shortlink;

		$this->_smarty_array['generated_time'] = round(((float)(microtime(true) - $start_time)),5);


		$this->_smarty->assign($this->_smarty_array);
		$this->_smarty->display($this->_tplfile);

	}

	/**
	 * Laedt die Navigation und speicher sie in $this->_smarty_array
	 *
	 * @parambooleane $shortlinks
	 */

	private function _loadNav($shortlinks = false)
	{
		if ($this->_is_admin === true) {
			$adminmenu = true;
		} else {
			$adminmenu = false;
		}

		/*Menu-Array ermitteln und in Smarty-Array speichertn, um später zu assignen (@link initPage() ) */
		$nav_array = $this->_page->get_menu_array($this->_gpc['GET'], $shortlinks, $adminmenu);


		/* Spezielle Zeichen zu HTML-Zeichen konvertieren */
		if (!empty($nav_array['topnav']) && is_array($nav_array['topnav'])) {
			foreach($nav_array['topnav'] as $key => $value) {
				$nav_array['topnav'][$key]['menu_name'] = htmlentities($value['menu_name']);
			}
		}

		if (!empty($nav_array['subnav']) && is_array($nav_array['subnav'])) {
			foreach($nav_array['subnav'] as $key => $value) {
				$nav_array['subnav'][$key]['menu_name'] = htmlentities($value['menu_name']);
			}
		}



		$this->_smarty_array['topnav'] = $nav_array['topnav'];
		$this->_smarty_array['subnav'] = $nav_array['subnav'];
		$this->_smarty_array['local_link'] = ($this->_nav_id = $nav_array['nav_id']);

		$this->_smarty_array['param']['nav_id'] = "nav_id";


		/* Tabellen für Mysql-Abfragen bestimmen */
		if ($this->_is_admin === true) {
			$menu_table = 'admin_menu';
			$mod_table = 'admin_modules';
		} else {
			$menu_table = 'menu';
			$mod_table = 'modules';
		}

		/*Link-ID für das Image-Module ermitteln */
		$this->_mysql->query("SELECT `$menu_table`.`menu_ID` as 'image_ID' FROM `$menu_table`, `$mod_table` WHERE `$mod_table`.`modules_file` = 'image_send.class.php' AND `$mod_table`.`modules_ID` = `$menu_table`.`menu_page` AND `$menu_table`.`menu_pagetyp` = 'mod' LIMIT 1");
		$data = $this->_mysql->fetcharray('assoc');

		$this->_smarty_array['img_link'] = $data['image_ID'];

		/*Link-ID für das Captcha-Module ermitteln */
		$this->_mysql->query("SELECT `$menu_table`.`menu_ID` as 'captcha_ID' FROM `$menu_table`, `$mod_table` WHERE `$mod_table`.`modules_file` = 'captcha_image.class.php' AND `$mod_table`.`modules_ID` = `$menu_table`.`menu_page` AND `$menu_table`.`menu_pagetyp` = 'mod' LIMIT 1");
		$data = $this->_mysql->fetcharray('assoc');

		$this->_smarty_array['captcha_link'] = $data['captcha_ID'];

	}

	/**
	 * Laedt ein Modul und fuehrt es aus. Anschliessend wird das zugehoerige Template im $smarty_arry gespeichert
	 *
	 * @param int $module_ID
	 */


	private function _loadModule($module_ID)
	{
		//Kann ueberschrieben, aber damit sicher etwas steht -> speichern
		$this->_smarty->assign('content_title', 'JClub');

		if ($this->_is_admin == true) {
			$mod_table = 'admin_modules';
		} else {
			$mod_table = 'modules';
		}

		//Modul aus Datenbank lesen
		$this->_mysql->query("SELECT `modules_file`,`modules_template_support` FROM `$mod_table` WHERE `modules_ID`= '$module_ID' LIMIT 1");
		$data = $this->_mysql->fetcharray("assoc");

		if (empty($data) && $data == false) {
			throw new CMSException("F&uuml;r die angegebene Modul-ID ist kein Modul hinterlegt!!!", EXCEPTION_CORE_CODE, 'Modul nicht gefunden');
			return;
		}

		//Modul-Path ermittelnt
		if ($this->_is_admin == true) {
			$path = ADMIN_DIR.'modules/'.$data['modules_file'];
		} else {
			$path = USER_DIR.'modules/'.$data['modules_file'];
		}

		/**Sicherheitscheck noch machen, ob Datei im richtigen Ordner!**/

		//File pruefen
		if(!file_exists($path)) {
			throw new CMSException("Datei $path konnte nicht included werden!!!", EXCEPTION_CORE_CODE, 'Fehler beim Modulladen');
			return;
		}

		//Modul einbinden
		include_once($path);

		//Klassennamen herausfinden
		$split = explode(".", $data['modules_file']);
		$class = ucfirst($split[0]);	//Klassen sind "first-character-uppercase"

		//Existenz der Klasse pruefen
		if(!class_exists($class)) {
			throw new CMSException("Klasse $class nicht vorhanden!!!", EXCEPTION_CORE_CODE, 'Klasse fehlt');
			return;
		}

		//Modul ausfuehren
		$module = new $class($this->_mysql, $this->_smarty);
		$module->action($this->_gpc);


		//Wenn das Modul kein Template zurueckgibt -> Beenden
		if ($data['modules_template_support'] == 'no') {
			exit;
		}

		$this->_smarty_array['file'] = $module->gettplfile();

	}


	/**
	 * Laedt den Inhalt aus der Datenbank mit der angegebenen ID
	 *
	 * @param int $page_ID
	 */

	private function _loadContent($page_ID)
	{
		if ($this->_is_admin == true) {
			$cnt_table = 'admin_content';
		} else {
			$cnt_table = 'content';
		}
		$this->_mysql->query("SELECT `content_title`, `content_text` FROM `$cnt_table` WHERE `content_ID` = '$page_ID'");
		$data = $this->_mysql->fetcharray("assoc");
		$content_title = $data['content_title'];	
		$content_text = $data['content_text'];
		
		$this->_smarty_array += array('content_title' => $content_title, 'content_text' => $content_text);
	}

	/**
	 * Prüft auf spezielle Aktionen durch
	 *
	 */
	private function _check_spec_action()
	{
		$modulname = '';
		if ($this->_is_admin == true) {
			$menu_tbl = 'admin_menu';
			$mod_tbl = 'admin_modules';
		} else {
			$menu_tbl = 'menu';
			$mod_tbl = 'modules';
		}

		if (key_exists('mail', $this->_gpc['GET'])) {
			$modulname = 'mailmodule';
		} elseif (key_exists('image', $this->_gpc['GET'])) {
			$modulname = 'image_send';

		}

		if ($modulname != '') {
			$query = "SELECT `$menu_tbl`.`menu_ID` FROM `$menu_tbl`,`$mod_tbl` "
			."WHERE `$mod_tbl`.`modules_name` = '$modulname' AND `$mod_tbl`.`modules_ID` = `$menu_tbl`.`menu_page` "
			."AND `$menu_tbl`.`menu_pagetyp` = 'mod' LIMIT 1";
			$this->_mysql->query($query);
			$data = $this->_mysql->fetcharray('num');
			$this->_smarty_array['local_link'] = $this->_nav_id = (int)$data[0];
		}

	}


	//	private function _output_callback($string)
	//	{
	//		$umlaut = array('ä', 'ö', 'ü', 'Ä','Ö', 'Ü');
	//		$httpumlaut = array('&auml;', '&ouml;', '&uuml;', '&Auml;','&Ouml;', '&Uuml;');
	//		str_replace($umlaut, $httpumlaut, $string);
	//		return $string;
	//	}


	//	private function _exe_reserved_action()
	//	{
	//		$reserved_action = Action::get_reserved_action();
	//
	//		foreach ($reserved_action as $key => $value) {
	//			/* Durchlaufen der reservierten Aktionen */
	//
	//			if (key_exists('action', $this->_gpc['GET']) && $this->_gpc['GET']['action'] == $key) {
	//				/* Testen auf GET-Parameter */
	//
	//				$action = new Action($this->_smarty, $this->_mysql, $this);
	//
	//				if (method_exists($action, "_exe_reserved_$key") == false) {
	//					throw new CMSException('Interne Funktion nicht vorhanden', EXCEPTION_CORE_CODE, 'Funktion fehlt');
	//				}
	//
	//				switch ($value) {
	//					case 'both':
	//						/* Egal ob Admin- oder Usermodus */
	//						call_user_method("_exe_reserved_$key", $action);
	//						break;
	//					case 'admin':
	//						/* Nur Adminmodues */
	//						if ($this->_is_admin === true) {
	//							call_user_method("_exe_reserved_$key", $action);
	//						}
	//						break;
	//					case 'user':
	//						/* Nur Usermodues */
	//						if ($this->_is_admin === false) {
	//							call_user_method("_exe_reserved_$key", $action);
	//						}
	//						break;
	//					default:
	//						throw new CMSException('Aufgrund ung&uuml;ltigen internen Daten wurde die Ausf&uuml;rung abgebrochen', EXCEPTION_CORE_CODE, 'Internes Datenproblem');
	//
	//				}
	//
	//			}
	//		}
	//	}

}



?>
