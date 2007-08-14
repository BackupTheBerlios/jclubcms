<?php
/**
 * @author Simon Däster
 * @package JClubCMS
 * File: auth.class.php
 * class: auth
 * requires: session.class.php
 * 
 * Diese Seite ist das Autorisierungs-Modul. Sie ist für das rechtmässige Einloggen
 *  verantwortlich; sie schaut, ob der Benutzer noch aktiv ist und schmeisst in, wenn
 *  nötig, aus dem Administration. Weiter ist sie dafür verantworlich, dass der Benutzer 
 * nur Befehle ausfürht, die er rechtmässig verwenden darf.
 *
 */

class auth
{
	private $smarty;
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
		$this->session = new session('s', $mysql);
		
	}
	
	
	public function check4login()
	{
		$mysql = $this->mysql;
		$smarty = $this->smarty;
		$session = $this->session;
		
		global $auth_error_logindata1, $auth_error_logindata1, $auth_forward_linktext, $auth_forward_successlogin;
		
		echo "Auth->check4login(): Logintaste gedrückt?<br />\n";
		if(isset($_POST['login']) && $_POST['login'] != "")
		{
			echo "Auth->check4login(): Login-Daten holen<br />\n";
			$login_data = $this->getlogindata();
			
			if(is_array($login_data))
			{
				echo "Auth->check4login(): Login-Daten vorhanden als Array<br />\n";
				//Benutzername und Passwort überprüfen
				$mysql->query("SELECT `user_ID` FROM  `admin_user` WHERE `user_name` = '{$login_data['name']}' AND `user_pw` = '{$login_data['password_encrypted']}' LIMIT 1");
				$data = $mysql->fetcharray();
				echo "Auth->check4login(): Variable USER_ID: {$data[0]}<br />\n";
				if(is_numeric($data[0]))
				{
					echo "Auth->check4login(): Der User existiert. Weiterleiten<br />\n";
					$this->user_id = $data[0];
					
					echo "Auth->check4login(): Create-Session() wird aufgerufen<br />\n";
					if($session->create_session($data[0]))
					{
						echo "Session wurde erfolreich erstellt";
					}
					
					$smarty->assign('forward_text', $auth_forward_successlogin);
					$smarty->assign('forward_linktext', $auth_forward_linktext);
					$smarty->assign('forward_link', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?".$session->get_sessionstring());
					$smarty->display('forward.tpl');
					
				} 
				elseif ($data == false)
				{
					echo "Auth->check4login(): User existiert nicht<br />\n";
					$smarty->assign('login_error', $auth_error_logindata2);
					$smarty->display('login.tpl');
				}
				
				return true;
			}
			
			echo "Auth->check4login(): Es wurden keine Daten angegeben<br />\n";
			$smarty->assign('login_error', $auth_error_logindata1);
			$smarty->display('login.tpl');
			
			
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Schaut nach, ob sich ein User eingeloggt hat, und prüft auf deren Rechmässigkeit
	 *
	 * @return boolean
	 */
	
	public function check4user()
	{
		global $auth_session_timeout;
		
		echo "Auth->check4user(): Start der Methode<br />\n";
		$session = $this->session;
		$smarty = $this->smarty;
		
		global $auth_error_nonactiv, $auth_error_sessioncorupt;
		
		if($session->watch4session() == false)
		{
			echo "Auth->check4user(): Keine Session vorhanden<br />\n";
			$smarty->assign('file', $_SERVER['PHP_SELF']);
			$smarty->display('login.tpl');
			return false;
		} 
		
		if($session->checksession() == false)
		{
			echo "Auth->check4user(): Session korrupt<br />\n";
			$session->delete();
			$smarty->assign('error_text', $auth_error_sessioncorupt);
			$smarty->display('error.tpl');
			return false;
		}
		
		if($session->activ($auth_session_timeout) == false)
		{
			echo "Auth->check4user(): User schläft<br />\n";
			$session->delete();
			$smarty->assign('error_text', $auth_error_nonactiv);
			$smarty->display('error.tpl');
			return false;
		}
		
		return true;
		
	}
	
	/**
	 * List die Logindaten heraus oder gibt einen Fehlerwert zurück
	 *
	 * @return array|int
	 */
	
	
	private function getlogindata()
	{
		$name = "";
		$password_encrypted = "";
		
		echo "Auth->getlogindata(): Start der Methode<br />\n";
		$error = 0;
		
		if(isset($_POST['name']) && !empty($_POST['name']))
		{
			$name = $_POST['name'];
			echo "Auth->getlogindata(): Name angegeben<br />\n";
			
		} 
		else 
		{
			$error = 1;
			echo "Auth->getlogindata(): Name <b>nicht</b> angegeben<br />\n";
		}
		
		if(isset($_POST['password'])&& !empty($_POST['password']))
		{
			$password_encrypted = md5($_POST['password']);
			echo "Auth->getlogindata(): Passwort angegeben<br />\n";
		} 
		else 
		{
			echo "Auth->getlogindata(): Passwort <b>nicht</b> angegeben<br />\n";
			$error = 1;
		}
		
		if($error > 0)
		{
			echo "Auth->getlogindata(): Name oder Passwort fehlt<br />\n";
			return false;
		}
		else
		{
			echo "Auth->getlogindata(): Name und Passwort angegeben<br />\n";
			return array('name' => $name, 'password_encrypted' => $password_encrypted);
		}
	}
	
}
?>