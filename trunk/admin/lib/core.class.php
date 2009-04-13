<?php
/**
 * Die core-Datei erledigt:
 * <ul><li>laedt notweindige Libaries</li>
 * <li>registriert den Exception-Handler</li></ul>
 * @package JClubCMS
 * @author Simon Däster
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 */ 
//Config laden
require_once ADMIN_DIR.'config/global-config.inc.php';
require_once ADMIN_DIR.'config/functions.inc.php';
require_once ADMIN_DIR.'config/system_textes.inc.php';


//notwendige Module laden
require_once ADMIN_DIR.'lib/mysql.class.php';
require_once ADMIN_DIR.'lib/Smarty/Smarty.class.php';

require_once ADMIN_DIR.'lib/auth.class.php';
require_once ADMIN_DIR.'lib/session.class.php';
require_once ADMIN_DIR.'lib/page.class.php';

require_once ADMIN_DIR.'lib/cmsexception.class.php';

set_exception_handler(array('CMSException', 'stdExceptionHandler'));
/**
 * Die core-Datei erledigt:
 * <ul><li>laedt notweindige Libaries</li>
 * <li>registriert den Exception-Handler</li></ul>
 * 
 * Die core-Klasse erledigt folgendes:
 * <ul><li>Erstellten der notwendigen Objekte (smarty, mysql)</li>
 * <li>Initialiesieren der Rechteverwaltung und testen auf erfolgreiches login</li>
 * <li>Erstellen der Navigation</li>
 * <li>Ueberpruefen der Benutzerangaben ueber $_GET / $_POST / $_COOKIE</li>
 * <li>Aufrufen des geladenen Moduls</li>
 * <li>Aufrufen der geladenen Seite</li></ul>
 * 
 * @package JClubCMS
 * @author Simon Däster
 * File: core.class.php
 * Classes: core
 * @requires PHP5
 */
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
		if (empty(self::$_core) && !(self::$_core instanceof Core)) {
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

			$this->_initObjects();
			$this->_checkGpc();

			$this->_smarty_array = array();

			if (ADMIN_DIR == './') {
				$this->_is_admin = true;
				$this->_checkAdmin();
			}


			$this->_initPage();

		} catch(CMSException $e) {
			
			global $system_textes;

			$strTrace = '#'.substr($e->getTraceAsString(), 1);
			//Ist Smarty nicht vorhanden, wird eine Nachricht ueber den Exceptionhandler geschickt, der kein Smarty braucht.
			if (!class_exists('Smarty') || !($this->_smarty instanceof Smarty)) {
				CMSException::logException($e,null,$system_textes[LANGUAGE_ABR]['core']['exp_no_smarty_instance']);
				CMSException::printException($e->getFilename(), $e->getLine(), $e->getMessage(), $strTrace);
				
			} else {
				CMSException::logException($e);
				
				//Zugriff auf die System-Texte ermöglichen
				global $system_textes;
				$textes = $system_textes[LANGUAGE_ABR]['core'];
				
				//**Template-Set einstellen und für die Templates als Variable zugänglich machen
				$this->_smarty_array['TEMPLATESET_DIR'] = TEMPLATESET_DIR;
				$this->_smarty_array['file'] = 'error_include.tpl';
				$this->_smarty_array['error_title'] = CMSException::htmlencode($e->getTitle());
				$this->_smarty_array['error_text'] = CMSException::htmlencode($e->getMessage())."<br />\n".$textes['exp_error_in_file']." ".$e->getFilename()." ".$textes['exp_on_line']." ".$e->getLine();
				
				//Aus Sicherheitsgründen (z.B. Sicht auf das MySQL-Passwort bei Mysql-Fehler) nur Trace anzeigen, wenn explizit angegeben!
				if(EXCEPTION_SHOW_TRACE == true) {
					$this->_smarty_array['error_text'] .= "<br />\n"."<div style=\"font-size: 11px\">\n".nl2br(CMSException::htmlencode($strTrace))."\n</div>";
				}
				
				$this->_smarty_array['error_text'] .= "<br /><div style=\"font-size: 13px; font-weight: bold\">".$textes['exp_error_often']."</div>";
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
		//Smarty-Objekt
		$this->_smarty = new Smarty();
		
		//Eigenschaften des Smarty-Objektes nach den Vorgaben von global-config.inc.php ändern
		$this->_smarty->compile_check = SMARTY_COMPILE_CHECK;
		$this->_smarty->debugging = SMARTY_DEBUGING;
		$this->_smarty->config_dir = SMARTY_CONFIG_DIR;
		
		//**Template-Set einstellen und für die Templates als Variable zugänglich machen
		$this->_smarty->template_dir = TEMPLATESET_DIR;
		
		//MySQL-Objekt initialisieren
		$this->_mysql = new Mysql(DB_SERVER, DB_NAME, DB_USER, DB_PW);

		//Page-Objekt initialisieren für die Darstellung des CMS
		$this->_page = new Page($this->_smarty, $this->_mysql);
		
		//Auth-Objekt initialisieren für die Zutrittsverwaltung
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
			throw new CMSException(array('core' => 'func_exec_fail'), EXCEPTION_CORE_CODE);
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
		//**Template-Set einstellen und für die Templates als Variable zugänglich machen
		$this->_smarty_array['TEMPLATESET_DIR'] = TEMPLATESET_DIR;

		$this->_tplfile = 'index.tpl';



		if ($this->_is_admin == true) {
			$table = 'admin_menu';
			$shortlink = ADMIN_MENU_USE_SHORTLINKS;
		} else {
			$table = 'menu';
			$shortlink = USER_MENU_USE_SHORTLINKS;
		}

		$this->_loadNav($shortlink);
		$this->_check_spec_action();
		
		$this->_mysql->query("SELECT `menu_pagetyp`, `menu_page`,  `menu_name` FROM `$table` WHERE `menu_ID`= '{$this->_nav_id}'");
		$page_data = $this->_mysql->fetcharray("assoc");

		$page_id = (int)$page_data['menu_page'];

		// erste Variablen abspeichern, damit sie in den Modulen aufgerufen werden können
		$this->_smarty->assign($this->_smarty_array);
		$this->_smarty_array = array();
		
		
			
		if ($page_data['menu_pagetyp'] == 'mod') {
			$this->_loadModule($page_id, $page_data);

		} elseif ($page_data['menu_pagetyp'] == 'pag') {
			$this->_loadContent($page_id, $page_data);

		} else {
			throw new CMSException(array('core' => 'modul_not_found'), null, "", array('core' => 'modul_load_error'));
		}

		$this->_smarty_array['shortlink'] = $shortlink;

		$this->_smarty_array['generated_time'] = round(((float)(microtime(true) - START_TIME)),5);

		
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


	private function _loadModule($module_ID, $page_data)
	{
		//Kann ueberschrieben, aber damit sicher etwas steht -> speichern
		$this->_smarty->assign('content_title', 'JClub');

		if ($this->_is_admin == true) {
			$mod_table = 'admin_modules';
		} else {
			$mod_table = 'modules';
		}

		//Modul aus Datenbank lesen
		$this->_mysql->query("SELECT `modules_name`, `modules_file`,`modules_template_support`, `modules_status` FROM `$mod_table` WHERE `modules_ID`= '$module_ID' LIMIT 1");
		$data = $this->_mysql->fetcharray("assoc");

		if (empty($data) && $data == false) {
			throw new CMSException(array('core' => 'modul_dismacht_id'), EXCEPTION_CORE_CODE, "", array('core' => 'modul_not_found'));
			return;
		}

		/*Ist das Modul online?*/
		if ($data['modules_status'] == 'on') {
			/*Modul ist online*/

			//Modul-Path ermittelnt
			if ($this->_is_admin == true) {
				$path = ADMIN_DIR.'modules/'.$data['modules_file'];
			} else {
				$path = USER_DIR.'modules/'.$data['modules_file'];
			}

			/**Sicherheitscheck noch machen, ob Datei im richtigen Ordner liegen**/

			//File prüfen
			if(!file_exists($path)) {
				throw new CMSException(array('core' => 'file_not_included'), EXCEPTION_CORE_CODE, $path, array('core' => 'modul_load_error'));
				return;
			}

			//Modul einbinden
			include_once($path);

			//Klassennamen herausfinden
			$split = explode(".", $data['modules_file']);
			$class = ucfirst($split[0]);	//Klassen sind "first-character-uppercase"

			//Existenz der Klasse pruefen
			if(!class_exists($class)) {
				throw new CMSException(array('core' => 'class_not_exists'), EXCEPTION_CORE_CODE, $class, array('core' => 'class_lost'));
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
			
		} else {
			/*Modul ist offline*/
			
			global $system_textes;
			$textes = $system_textes[LANGUAGE_ABR]['core'];
			
			$this->_smarty_array['error_title'] = $textes['not_accessible'];
			$this->_smarty_array['error_text'] = $page_data['menu_name'].$textes['now_not_accessible'];
			$this->_smarty_array['file'] = 'error_include.tpl';
		}

	}


	/**
	 * Laedt den Inhalt aus der Datenbank mit der angegebenen ID
	 *
	 * @param int $page_ID
	 */

	private function _loadContent($page_ID, $page_data)
	{
		if ($this->_is_admin == true) {
			$cnt_table = 'admin_content';
		} else {
			$cnt_table = 'content';
		}

		$this->_mysql->query("SELECT `content_title`, `content_text`, `content_archiv` FROM `$cnt_table` WHERE `content_ID` = '$page_ID' LIMIT 1");
		$data = $this->_mysql->fetcharray("assoc");

		if ($data['content_archiv'] == 'no') {
			$content_title = htmlspecialchars_decode(htmlentities($data['content_title']));
			$content_text = htmlspecialchars_decode(htmlentities($data['content_text']));
			$this->_smarty_array += array('content_title' => $content_title, 'content_text' => $content_text);
		} else {
			
			global $system_textes;
			$textes = $system_textes[LANGUAGE_ABR]['core'];
			
			$this->_smarty_array['error_title'] = $textes['not_accessible'];
			$this->_smarty_array['error_text'] = $page_data['menu_name'].$textes['now_not_accessible'];
			$this->_smarty_array['file'] = 'error_include.tpl';
		}



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

}



?>
