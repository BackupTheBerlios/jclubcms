<?php
/**
 * Dieses File beinhaltet die Klassen und Methoden für die Authentifizeriung
 * 
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 * @package JClubCMS
 * @author Simon Däster
 */
require_once ADMIN_DIR.'lib/session.class.php';
/**
 * 
 * Authorisierungsklasse für den Adminbereich
 * 
 * Diese Seite ist das Autorisierungs-Modul. Sie ist fuer das rechtmässige Einloggen
 * verantwortlich; sie schaut, ob der Benutzer noch aktiv ist und schmeisst in, wenn
 * noetig, aus dem Administration. Weiter ist sie dafuer verantworlich, dass der Benutzer 
 * nur Befehle ausfürht, die er rechtmässig verwenden darf.
 *
 * @author Simon Däster
 * File: auth.class.php
 * class: Auth
 * @requires PHP5
 */

class Auth
{
	/**
	 * Page-Klasse
	 *
	 * @var Page
	 */
	private $_page;
	
	/**
	 * Session-Klasse
	 *
	 * @var Session
	 */
	private $_session;
	
	/**
	 * Mysql-Klasse
	 *
	 * @var Mysql
	 */
	private $_mysql;
	
	/**
	 * User-ID
	 *
	 * @var int
	 */
	private $_user_id;
	
	/**
	 * Texte für die Fehler
	 *
	 * @var array
	 */
	private $_textes = array();

	/**
	 * Oeffnet die Autorisierungsklasse
	 *
	 * @param smarty $smarty
	 * @param mysql $mysql
	 */

	public function __construct($smarty, $mysql)
	{
		$this->_smarty = $smarty;
		$this->_mysql = $mysql;
		$this->_session = new Session('s', $mysql);
		$this->_smarty->assign('TEMPLATESET_DIR', TEMPLATESET_DIR);
		
		global $system_textes;
		$this->_textes = $system_textes[LANGUAGE_ABR]['auth'];

	}

	/**
	 * Ueberprueft ob sich jemand einloggt 
	 *
	 * @param array $post_array $_POST-Daten
	 * @return boolean Antwort, ob sich jemand einloggt.
	 */

	public function check4login(&$post_array)
	{

		//Login-Formular gesendet?
		if (isset($post_array['login']) && $post_array['login'] == "Anmelden") {
			$login_data = $this->_getlogindata($post_array);
			
			if (is_array($login_data)) {

				//Benutzername und Passwort ueberpruefen
				$this->_mysql->query("SELECT `user_ID` FROM `admin_users` WHERE `user_name` = '{$login_data['name']}' LIMIT 1");
				
				if (($data = $this->_mysql->fetcharray('assoc')) === false) {
					$this->_smarty->assign('login_error', $this->_textes['failname']);
					$this->_smarty->display('login.tpl');
					
				} else {
					$this->_mysql->query("SELECT `user_ID` FROM  `admin_users` WHERE `user_name` = '{$login_data['name']}' AND `user_pw` = '{$login_data['password_encrypted']}' LIMIT 1");

					$data = $this->_mysql->fetcharray();

					if(is_numeric($data[0])) {
						$this->_user_id = $data[0];
						$this->_session->create_session($data[0]);

						//Sektion der Sprachdatei weitergeben für die Texte im Template
						$this->_smarty->assign('section', 'Login');
						$this->_smarty->assign('forward_link', "?".$this->_session->get_sessionstring());
						$this->_smarty->display('forward.tpl');
						$this->_smarty->display('forward.tpl');


					} elseif ($data == false) {

						$this->_smarty->assign('login_error', $this->_textes['failpw']);
						$this->_smarty->display('login.tpl');
						
					} else {
						/* Query zwar richtig, aber user_ID ungültig */
						$this->_smarty->assign('login_error', $this->_textes['userinvalid']);
						$this->_smarty->display('login.tpl');
					}
				}

				return true;

			} else {
				$this->_smarty->assign('login_error', $this->_textes['noentry']);
				$this->_smarty->display('login.tpl');
				return true;

			}

		} else {
			return false;
		}
	}

	/**
	 * Schaut nach, ob sich ein User rechtmaessig eingeloggt hat, und prüft auf deren Rechmaessigkeit
	 * 
	 * @param array $get_array $_GET-Daten
	 * @return boolean
	 */

	public function check4user($get_array)
	{

		if ($this->_session->watch4session($get_array) == false) {
			$this->_smarty->assign('file', "");
			$this->_smarty->display('login.tpl');
			return false;
		}

		if ($this->_session->checksession() == false) {

			$this->_session->delete();
			$this->_smarty->assign('error_text', $this->_textes['sessioncorupt']);
			$this->_smarty->display('error_alone.tpl');

			return false;
		}

		if ($this->_session->activ(SESSION_TIMEOUT) == false) {
			$this->_session->delete();

			$this->_smarty->assign('error_text', $this->_textes['nonactiv']);
			$this->_smarty->display('error_alone.tpl');

			return false;
		}

		$this->_smarty->assign('SID', $this->_session->get_sessionstring());
		return true;

	}

	/**
	 * Loggt den User aus
	 *
	 */

	public function logout()
	{
		$this->_session->delete();
		//Sektion der Sprachdatei weitergeben für die Texte im Template
		$this->_smarty->assign('section', 'Logout');
		$this->_smarty->assign('forward_link', "?");
		$this->_smarty->display('forward.tpl');
	}



	/**
	 * List die Logindaten heraus oder gibt einen Fehlerwert zurueck
	 *
	 * @param array $post_array $_POST-Daten
	 * @return array|int
	 */

	private function _getlogindata(&$post_array)
	{
		$name = "";
		$password_encrypted = "";
		
		$error = 0;

		if (isset($post_array['name']) && !empty($post_array['name'])) {
			$name = $post_array['name'];

		} else {
			$error = 1;

		}

		if (isset($post_array['password'])&& !empty($post_array['password'])) {
			$password_encrypted = md5($post_array['password']);
			unset($post_array['password']);

		} else {
			$error += 2;
		}

		if ($error > 0) {
			return false;
		} else {
			return array('name' => $name, 'password_encrypted' => $password_encrypted);
		}
	}


	/**
	 * Ueberprueft die Rechte.
	 *
	 * @param string $rightname Name des Rechts
	 */

	private function _controlrights($rightname)
	{
		;
	}

}
?>
