<?php
/**
 * Beinhaltet die Klassen und Methoden für das Sessionhandling.
 * @author Simon Däster
 * @package JClubCMS
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 */
/**
 * Ermöglicht das Sessionhandling.
 * Wird primär gebraucht für Bereiche mit Login.
 * @author Simon Däster
 * @package JClubCMS
 *
 */
class Session {

	private $_mysql;
	private $_ip_adress;
	private $_user_agent;
	private $_session_id;
	private $_session_name;
	
	/**
	 * Erstellt die Klasse
	 *
	 * @param string $session_name
	 * @param mysql $mysql
	 */
	
    public function __construct($session_name, $mysql) {
    	
    	$this->_session_name = $session_name;
    	$this->_mysql = $mysql;
    	$this->_ip_adress = $_SERVER['REMOTE_ADDR'];
    	$this->_user_agent = $_SERVER['HTTP_USER_AGENT'];
    	
    }
    
    
    /**
     * Schaut, ob der User bereits eine Session hat
     *
     * @param array $get_array $_GET-Daten
     * @return boolean Session vorhanden
     */
    
    public function watch4session($get_array)
    {
    	if(!empty($get_array[$this->_session_name]) && is_string($get_array[$this->_session_name]) && strlen($get_array[$this->_session_name]) == 32)
    	{
    		$this->_session_id = $get_array[$this->_session_name];
    		return true;
    	} else {
    		return false;
    	}	
    }
    
    /**
     * Kontroliert, ob die Session gültig ist. 
     *
     * @return boolean
     */
    
    public function checksession()
    {
    	$this->_mysql->query("SELECT `session_id`, `user_ref_ID` FROM `admin_session` WHERE `ip_address` = '{$this->_ip_adress}' AND `user_agent` = '{$this->_user_agent}' LIMIT 1");
    	$data = $this->_mysql->fetcharray("num");
    	
    	if($data == false)
    	{
    		return false;
    	} 
    	else if($this->_session_id != $data[0])
    	{
    		return false;
    	}
    	else 
    	{
    		$this->_mysql->query("SELECT `user_name` FROM `admin_users` WHERE `user_ID` = '{$data[1]}' LIMIT 1");
    		$data = $this->_mysql->fetcharray('num');
    		
    		
    		return true;
    	}
    }
    
    /**
     * Kontroliert, ob der User noch aktiv ist
     *
     * @param int $maxtime Anzahl "inaktiver" Sekunden
     * @return boolean
     */
    
    public function activ($maxtime)
    {
    	$this->_mysql->query("SELECT `last_activity` FROM `admin_session` WHERE `session_id` = '{$this->_session_id}'");
    	$lasttime = $this->_mysql->fetcharray();

    	$this->_mysql->query("SELECT TIME_TO_SEC(TIMEDIFF(NOW(), '{$lasttime[0]}')) as Diff");
    	$diff = $this->_mysql->fetcharray();
    	
    	if($maxtime < $diff[0])
    	{
    		return false;
    	}
    	
    	$this->_mysql->query("UPDATE `admin_session` SET `last_activity` = NOW() WHERE `admin_session`.`session_id` = '{$this->_session_id}' LIMIT 1 ;");
    		
    	return true;
    }
    
    /**
     * Erstellt eine Session mit der gegebenen User_ID.
     * War die Erstellung der Session erfolgreich, gibt die Funktion true zurueck, sonst false.
     *
     * @param int $userID
     * @return boolean 
     */
    
    public function create_session($userID)
    {
    	$this->_session_id = md5(sha1((time().rand())));
    	
    	$return = true;
    	$this->_mysql->query("INSERT INTO `admin_session` (`ID`, `session_id`, `user_agent`, `user_ref_ID`, `ip_address`, `login_time`, `last_activity`) VALUES (NULL, '{$this->_session_id}', '{$this->_user_agent}', $userID, '{$this->_ip_adress}', NOW(), NOW())");
    	  	
    	$num = $this->_mysql->affected_rows();
    	
    	if($num < 1)
    	{
    		$return = false;
    	}
    	
    	$this->_garbage_collector($userID);
    	
    	return $return;
    	
    }
    
    /**
     * Gibt den Sessionstring zurueck: session_name=session_id
     *
     * @return string session_string
     */
    
    public function get_sessionstring()
    {
    	return "$this->_session_name=$this->_session_id";
    }
        
    
    /**
     * ZERSTOERT die Session
     */
     
    public function delete()
	{
		$this->_mysql->query("DELETE FROM `admin_session` WHERE  `session_id` = '$this->_session_id' LIMIT 1");
	}
	
	
	/**
	 * Räumt die Session_IDs weg, welche dieselbe user_id, ip_address und user_agent haben wie die momentane Session
	 * Gab es etwas zu rueumen, wird true zurueckgegeben; andernfalls false.
	 * @param int $userID User_ID des Benutzers
	 * @return boolean Sessions wurden gelöscht
	 */
	
	private function _garbage_collector($userID)
	{
		$i = 0;
		/* Alte Session mit der gleichen User_ID löschen */
		$sql = "SELECT `session_id` FROM `admin_session` WHERE `session_id` != '{$this->_session_id}'";
		
		$this->_mysql->query($sql);
		$this->_mysql->saverecords('num');
		$data = $this->_mysql->get_records();
		
		
		foreach ($data as $value) {
			$this->_mysql->query("DELETE FROM `admin_session` WHERE `user_ref_id` = '$userID' AND `session_id` = '{$value[0]}' LIMIT 1");
			$i++;
		}
		
		if ($i > 0) {
			return true;
		} else {
			return false;
		}
	}
}

?>
