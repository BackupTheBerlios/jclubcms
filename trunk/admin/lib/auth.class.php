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
	 * @var page
	 */
	private $page;
	
	private $session;
	private $mysql;
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
	 * @return boolean Antwort, ob sich jemand einloggt.
	 */

	public function check4login()
	{


		global $auth_error_noentry, $auth_error_failname, $auth_error_failpw, $auth_forward_linktext, $auth_forward_successlogin, $auth_forward_title;

		//Login-Formular gesendet?
		if (isset($_POST['login']) && $_POST['login'] != "") {
			$login_data = $this->getlogindata();

			
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
	 * @return boolean
	 */

	public function check4user()
	{
		global $session_timeout;

		global $auth_error_nonactiv, $auth_error_sessioncorupt;

		if ($this->session->watch4session() == false) {
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

		$this->smarty->assign('SID', $session->get_sessionstring());
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
	 * @return array|int
	 */

	private function getlogindata()
	{
		$name = "";
		$password_encrypted = "";
		
		$error = 0;

		if (isset($_POST['name']) && !empty($_POST['name'])) {
			$name = $_POST['name'];

		} else {
			$error = 1;

		}

		if (isset($_POST['password'])&& !empty($_POST['password'])) {
			$password_encrypted = md5($_POST['password']);

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