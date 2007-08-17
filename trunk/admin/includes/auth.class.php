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

class Auth
{
	private $pageobj;
	private $sessionobj;
	private $mysqlobj;
	private $user_id;
	
	/**
	 * Oeffnet die Autorisierungsklasse
	 *
	 * @param smarty $smarty
	 * @param mysqlobj $mysqlobj
	 */
	
	public function __construct($pageobj, $mysqlobj)
	{
		$this->pageobj = $pageobj;
		$this->mysqlobj = $mysqlobj;
		$this->sessionobj = new Session('s', $mysqlobj);
		
	}
	
	
	public function check4login()
	{
		$mysqlobj = $this->mysqlobj;
		$pageobj = $this->pageobj;
		$sessionobj = $this->sessionobj;
		
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
				$mysqlobj->query("SELECT `user_ID` FROM  `admin_user` WHERE `user_name` = '{$login_data['name']}' AND `user_pw` = '{$login_data['password_encrypted']}' LIMIT 1");
				$data = $mysqlobj->fetcharray();
				echo "Auth->check4login(): Variable USER_ID: {$data[0]}<br />\n";
				if(is_numeric($data[0]))
				{
					echo "Auth->check4login(): Der User existiert. Weiterleiten<br />\n";
					$this->user_id = $data[0];
					
					echo "Auth->check4login(): Create-Session() wird aufgerufen<br />\n";
					if($sessionobj->create_session($data[0]))
					{
						echo "Session wurde erfolreich erstellt";
					}
					
					$pageobj->smarty_show('forward', array('forward_text' => $auth_forward_successlogin, 'forward_linktext' => $auth_forward_linktext, 'forward_link' => $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?".$sessionobj->get_sessionstring()));
					
					
				} 
				elseif ($data == false)
				{
					echo "Auth->check4login(): User existiert nicht<br />\n";
					$pageobj->smarty_show('login', array('login_error' => $auth_error_logindata2));
				}
				
				return true;
			}
			
			echo "Auth->check4login(): Es wurden keine Daten angegeben<br />\n";
			$pageobj->smarty_show('login', array('login_error' => $auth_error_logindata1));
			
			
			
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
		global $session_timeout;
		
		echo "Auth->check4user(): Start der Methode<br />\n";
		$sessionobj = $this->sessionobj;
		$pageobj = $this->pageobj;
		
		global $auth_error_nonactiv, $auth_error_sessioncorupt;
		
		if($sessionobj->watch4session() == false)
		{
			echo "Auth->check4user(): Keine Session vorhanden<br />\n";
			$pageobj->smarty_show('login', array('file' => $_SERVER['PHP_SELF']));
			return false;
		} 
		
		if($sessionobj->checksession() == false)
		{
			echo "Auth->check4user(): Session korrupt<br />\n";
			$sessionobj->delete();
			$pageobj->smarty_show('error', array('error_text' => $auth_error_sessioncorupt));
			
			return false;
		}
		
		if($sessionobj->activ($session_timeout) == false)
		{
			echo "Auth->check4user(): User schläft<br />\n";
			$sessionobj->delete();
			$pageobj->smarty_show('error', array('error_text' => $auth_error_nonactiv));
			
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