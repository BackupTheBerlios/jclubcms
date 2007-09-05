<?php
/**
 * Die Session-Klasse handelt mit den Session-Daten, welche in der Datenbank abgespitz sind.
 * @author Simon Daester
 * @package JClubCMS
 * @link www.jclub.ch
 * 
 * file: session.class.php
 * classes: session
 *
 */
class Session {

	private $mysql;
	private $ip_adress;
	private $user_agent;
	private $session_id;
	private $session_name;
	
	/**
	 * Erstellt die Klasse
	 *
	 * @param string $session_name
	 * @param mysql $mysql
	 */
	
    public function __construct($session_name, $mysql) {
    	
    	$this->session_name = $session_name;
    	$this->mysql = $mysql;
    	$this->ip_adress = $_SERVER['REMOTE_ADDR'];
    	$this->user_agent = $_SERVER['HTTP_USER_AGENT'];
    	
    }
    
    
    /**
     * Schaut, ob der User bereits eine Session hat
     *
     * @return boolean Session vorhanden
     */
    
    public function watch4session()
    {
    	if(!empty($_GET[$this->session_name]) && is_string($_GET[$this->session_name]) && strlen($_GET[$this->session_name]) == 32)
    	{
    		$this->session_id = $_GET[$this->session_name];
    		return true;
    	} else {
    		return false;
    	}	
    }
    
    /**
     * Kontroliert, ob die Session gueltig ist
     *
     * @return boolean
     */
    
    public function checksession()
    {
    	$mysql = $this->mysql;
    	$mysql->query("SELECT `session_id` FROM `admin_session` WHERE `ip_address` = '{$this->ip_adress}' AND `user_agent` = '{$this->user_agent}' LIMIT 1");
    	//echo "session->checksession(): sql-string....  SELECT `session_id` FROM `admin_session` WHERE `ip_address` = '{$this->ip_adress}' AND `user_agent` = '{$this->user_agent}' LIMIT 1<br />\n";
    	$data = $mysql->fetcharray("num");
    	
    	if($data == false)
    	{
    		return false;
    	} 
    	else if($this->session_id != $data[0])
    	{
    		return false;
    	}
    	else 
    	{
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
    	$mysql = $this->mysql;
    	$mysql->query("Select last_activity from `admin_session`where `session_id` = '{$this->session_id}'");
    	$lasttime = $mysql->fetcharray();
    	//echo "session->activ(): \$lasttime {$lasttime[0]}<br />\n";
    	$mysql->query("SELECT TIME_TO_SEC(TIMEDIFF(NOW(), '{$lasttime[0]}')) as Diff");
    	$diff = $mysql->fetcharray();
    	    	
    	//echo "session->activ(): \$diff {$diff[0]}<br />\n";
    	//echo "session->activ(): \$maxtime $maxtime<br />\n";
    	
    	if($maxtime < $diff[0])
    	{
    		return false;
    	}
    	
    	$mysql->query("UPDATE `jclubbeta`.`admin_session` SET `last_activity` = NOW() WHERE `admin_session`.`session_id` = '{$this->session_id}' LIMIT 1 ;");
    	
    	
    	
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
    	$mysql = $this->mysql;
    	$this->session_id = md5(sha1((time().rand())));
    	
    	$return = true;
    	$mysql->query("INSERT INTO `jclubbeta`.`admin_session` (`ID`, `session_id`, `user_agent`, `user_ref_ID`, `ip_address`, `login_time`, `last_activity`) VALUES (NULL, '{$this->session_id}', '{$this->user_agent}', $userID, '{$this->ip_adress}', NOW(), NOW())");
    	
    	//echo "session->create_session: mysql-query<br />\nINSERT INTO `jclubbeta`.`admin_session` (`ID`, `session_id`, `user_agent`, `user_ref_ID`, `ip_address`, `login_time`, `last_activity`) VALUES (NULL, '{$this->session_id}', '{$this->user_agent}', $userID, '{$this->ip_adress}', NOW(), NOW())<br />\n";
    	
    	
    	$num = $mysql->affected_rows();
    	
    	if($num < 1)
    	{
    		$return = false;
    	}
    	
    	$this->garbage_collector($userID);
    	
    	return $return;
    	
    }
    
    /**
     * Gibt den Sessionstring zurueck: session_name=session_id
     *
     * @return string session_string
     */
    
    public function get_sessionstring()
    {
    	return "$this->session_name=$this->session_id";
    }
        
    
    /**
     * ZERSTOERT die Session
     */
     
    public function delete()
	{
		$mysql = $this->mysql;
		$mysql->query("DELETE FROM `admin_session` WHERE  `session_id` = '$this->session_id' LIMIT 1");
	}
	
	
	/**
	 * Raeumt die Session_IDs weg, welche dieselbe user_id, ip_address und user_agent haben wie die momentane Session
	 * Gab es etwas zu rueumen, wird true zurueckgegeben; andernfalls false;
	 * @param int $userID User_ID des Benutzers
	 * @return boolean
	 */
	
	private function garbage_collector($userID)
	{
		$mysql = $this->mysql;
		$i = 0;
		$sql = "SELECT `session_id` from `admin_session` WHERE  `ip_address` = '{$this->ip_adress}' AND  `user_agent` = '{$this->user_agent}' AND `user_ref_ID` = $userID AND `session_id` != '{$this->session_id}'";
		
		$mysql->query($sql);
		
		//echo "sesson->garbage_collector(): SQL $sql<br />\n";
		
		$com_mysql = clone $mysql;
		
		while($data = $mysql->fetcharray("num"))
		{
			//echo "session->garbage_collector(): while_ {$data[0]}<br />\n";
			$com_mysql->query("DELETE FROM `admin_session` WHERE `session_id` = '{$data[0]}' LIMIT 1");
			$i++;
		}
		
		
		if($i > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>