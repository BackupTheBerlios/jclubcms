<?php
/**
 * @author Simon D�ster
 * @package JClubCMS
 * File: auth.class.php
 * class: Auth
 * requires: session.class.php
 * 
 * Diese Seite ist das Autorisierungs-Modul. Sie ist fuer das rechtm�ssige Einloggen
 * verantwortlich; sie schaut, ob der Benutzer noch aktiv ist und schmeisst in, wenn
 * noetig, aus dem Administration. Weiter ist sie dafuer verantworlich, dass der Benutzer 
 * nur Befehle ausf�rht, die er rechtm�ssig verwenden darf.
 *
 */

require_once ADMIN_DIR.'config/auth_textes.inc.php';
require_once ADMIN_DIR.'lib/session.class.php';

class Auth
{
	/**
	 * Page-Klasse
	 *
	 * @var Page
	 */
	private $page;
	
	/**
	 * Session-Klasse
	 *
	 * @var Session
	 */
	private $session;
	
	/**
	 * Mysql-Klasse
	 *
	 * @var Mysql
	 */
	private $mysql;
	
	/**
	 * User-ID
	 *
	 * @var int
	 */
	private $user_id;

	/**
	 * Oeffnet die Autorisierungsklasse
	 *
	 * @param smarty $smarty
	 * @param mysql $mysql
	 */

	public function __construct($smarty, $mysql)
	{
		$this->smarty = $smarty;
		$this->mysql = $mysql;
		$this->session = new Session('s', $mysql);

	}

	/**
	 * Ueberprueft ob sich jemand einloggt 
	 *
	 * @param array $post_array $_POST-Daten
	 * @return boolean Antwort, ob sich jemand einloggt.
	 */

	public function check4login($post_array)
	{


		global $auth_error_noentry, $auth_error_failname, $auth_error_failpw, $auth_forward_linktext, $auth_forward_successlogin, $auth_forward_title;

		//Login-Formular gesendet?
		if (isset($post_array['login']) && $post_array['login'] != "") {
			$login_data = $this->getlogindata($post_array);

			
			if (is_array($login_data)) {
				//echo "Auth->check4login(): Login-Daten vorhanden als Array<br />\n";
				//Benutzername und Passwort ueberpruefen
				$this->mysql->query("SELECT `user_ID` FROM `admin_users` WHERE `user_name` = '{$login_data['name']}' LIMIT 1");
				if (($data = $this->mysql->fetcharray('assoc')) === false) {
					$this->smarty->assign('login_error', $auth_error_failname);
					$this->smarty->display('login.tpl');
					
				} else {
					$this->mysql->query("SELECT `user_ID` FROM  `admin_users` WHERE `user_name` = '{$login_data['name']}' AND `user_pw` = '{$login_data['password_encrypted']}' LIMIT 1");

					$data = $this->mysql->fetcharray();

					if(is_numeric($data[0])) {
						$this->user_id = $data[0];
						$this->session->create_session($data[0]);

						$this->smarty->assign(array('forward_title' => $auth_forward_title, 'forward_text' => $auth_forward_successlogin, 'forward_linktext' => $auth_forward_linktext, 'forward_link' => $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?".$this->session->get_sessionstring()));
						$this->smarty->display('forward.tpl');


					} elseif ($data == false) {

						$this->smarty->assign('login_error', $auth_error_failpw);
						$this->smarty->display('login.tpl');
					}
				}

				return true;

			} else {
				$this->smarty->assign('login_error', $auth_error_noentry);
				$this->smarty->display('login.tpl');
				return true;

			}

		}
		else
		{
			return false;
		}
	}

	/**
	 * Schaut nach, ob sich ein User rechtmaessig eingeloggt hat, und prueft auf deren Rechmaessigkeit
	 * 
	 * @param array $get_array $_GET-Daten
	 * @return boolean
	 */

	public function check4user($get_array)
	{
		global $session_timeout;

		global $auth_error_nonactiv, $auth_error_sessioncorupt;

		if ($this->session->watch4session($get_array) == false) {
			$this->smarty->assign('file', 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
			$this->smarty->display('login.tpl');
			return false;
		}

		if ($this->session->checksession() == false) {

			$this->session->delete();
			$this->smarty->assign('error_text', $auth_error_sessioncorupt);
			$this->smarty->display('error_alone.tpl');

			return false;
		}

		if ($this->session->activ($session_timeout) == false) {
			$this->session->delete();

			$this->smarty->assign('error_text', $auth_error_nonactiv);
			$this->smarty->display('error_alone.tpl');

			return false;
		}

		$this->smarty->assign('SID', $this->session->get_sessionstring());
		return true;

	}

	/**
	 * Loggt den User aus
	 *
	 */

	public function logout()
	{
		$this->session->delete();

		$this->smarty->assign('forward_text', "Sie haben sich erfolgreich ausgeloggt");
		$this->smarty->assign('forward_linktext', "Zum Login");
		$this->smarty->assign('forward_link', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
		$this->smarty->display('forward.tpl');
	}



	/**
	 * List die Logindaten heraus oder gibt einen Fehlerwert zurueck
	 *
	 * @param array $post_array $_POST-Daten
	 * @return array|int
	 */

	private function getlogindata($post_array)
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

	private function controlrights($rightname)
	{
		;
	}

}
?>