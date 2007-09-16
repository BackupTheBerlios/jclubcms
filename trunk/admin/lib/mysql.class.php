<?php

/**
 * @package JClubCMS
 * @author David Daester, Simon Daester
* File: mysql.class.php
* Classes: mysql
* Requieres: PHP5, MySQL 4.x
* 
* Die Klasse mysql ist zustaendig fuer das ganze Datenbankhandling
* von mysql.
* Ueber sie gehen alle Verbindungen, Queries und MySQL-Spezifische
* Funktionen (z.B. mysql_fetch_array)
* Die Daten werden in der Klasse gespeichert und nur die Enddaten
* ausgegeben.
*
*
*-----------------------------------------------------------------*/

class mysql {

	
	/**
	 * Servername
	 *
	 * @var string
	 */
	private $mysql_server = null;
	
	/**
	 * Mysql-Datenbank, mit der gearbeitet wird
	 *
	 * @var string
	 */
	private $mysql_db = null;
	
	/**
	 * Name des Mysql-Users
	 *
	 * @var string
	 */
	private $mysql_user = null;
	
	/**
	 * Password des Mysql-Users
	 *
	 * @var string
	 */
	private $mysql_pw = null;
	
	/**
	 * Gibt an, ob bei einer Mysql-Verbindung mit gleichem Server und User eine neue Verbindung geoeffnet wird oder nicht.
	 *
	 * @var boolean
	 */
	private $new_c = null;

	
	/**
	 * Verbindungserkennung zum Server
	 *
	 * @var resource
	 */
	private $server_link = null;
	
	/**
	 * Verbinungserkennung zur Datenbankabfrage
	 *
	 * @var resource
	 */
	private $result = null;
	
	/**
	 * Angabe, ob mysql_query() eine resource zurueckgibt. Fast nur bei SELECT, SHOW, DESCRIBE, EXPLAIN.
	 *
	 * @var resource
	 */
	private $no_result = false;
	
	/**
	 * Array zum speichern von Mysql-Datensaetzen
	 *
	 * @var array
	 * @access private
	 */
	private $query_records = array();

	/**
	 * Das Konstrukt dieser Klasse
	 *
	 * @param string $server Name des Servers
	 * @param string $name Name der Datenbank
	 * @param string $user Username
	 * @param string $pw Password
	 * @param boolean $newcon Neue Verbindung?
	 */

	function __construct($server, $db, $user, $pw, $newcon = true) {

		$this->mysql_server = $server;
		$this->mysql_db = $db;
		$this->mysql_user = $user;
		$this->mysql_pw = $pw;
		$this->new_c = $newcon;
		$this->connect();
	}

	/**
	 * Oeffnet die Verbindung zum Server (wird beim Erstellen des Objekts
	 * aufgerufen)
	 * Gibt bei Erfolg true zurueck, sonst false
	 *
	 * @return boolean
	 */

	private function connect() {

		$this->server_link = mysql_connect($this->mysql_server, $this->mysql_user, $this->mysql_pw, $this->new_c);
		if(!is_resource($this->server_link)) {
			return false;
		}

		if(!mysql_select_db($this->mysql_db, $this->server_link)) {
			return false;
		} else {
			return true;
		}

	}

	/**
	 * Sendet eine Anfrage an MySQL. Bei Erfolg liefert sie true, sonst false
	 *
	 * @param string $query Die Mysql-Eingabe
	 * @return true|false
	 */

	public function query($query) {
		
		//Query-Record loeschen, weil ein neuer Query gestartet wurde
		$this->query_records = array();
		$give_result = false;
				
		//Kontrolliert, ob der query SELECT, SHOW, EXPLAIN oder DESCRIBE enthaelt. Nur dann gibt mysql_query ein result zurück
		$query_result_by = array('SELECT', 'Select', 'select', 'SHOW', 'Show', 'show', 'EXPLAIN','Explain', 'explain', 'DESCRIBE', 'Describe', 'describe');
		
		foreach ($query_result_by as $value)
		{
			//Enthaelt $query ein solcher string, wird die schleife abgebrochen
			$give_result = (strpos($query, $value) === false)?false:true;
			
			if($give_result)
			{
				break;
			}
		}
		
		if($give_result == true)
		{
			//echo "mysql->query: \$query '$query' doesn't contain INSERT<br />\n";
			$this->result = mysql_query($query, $this->server_link);
			
		}
		else
		{
			//echo "mysql->query: \$query '$query' contains INSERT<br />\n";
			mysql_query($query, $this->server_link);
			$this->no_result = true;
		
		}
		
		//echo "mysql->query: \$this->result ".print_r($this->result, 1)."<br />\n";
		//debugecho(__LINE__, __FILE__, __FUNCTION__, __CLASS__);

		if($this->result === false) {
			return false;			
		} else {
			return true;
		}
	}
	

	/**
	 * Liefert bei Erfolg einen Datensatz als Array, sonst false
	 * 
	 * @param string[optional] $resulttype "both"|"num"|"assoc"
	 * @return array|false 
	 */

	public function fetcharray($resulttype = "both") {

		switch ($resulttype)
		{
			case "num":
				$type = MYSQL_NUM;
				break;

			case "assoc":
				$type = MYSQL_ASSOC;
				break;

			default:
				$type = MYSQL_BOTH;
		}


		$data = mysql_fetch_array($this->result, $type);


		if(is_array($data)) {
			return $data;
		} else {			
			return false;
		}

	}
	
	/**
	 * Speichert der Datensatz/die Datensaetze der letzen Anfrage intern ab.
	 *
	 * @param string[optional] $resulttype "both"|"num"|"assoc"
	 */
	
	public function saverecords($resulttype = "assoc")
	{
		$i = 0;
		while($data = $this->fetcharray($resulttype))
		{
			$this->query_records[$i] = $data;
			$i++;
		}
	}
	
	/**
	 * Gibt der abgespeicherte Datensatz als Array zurueck. Wurde kein Datensatz gespeichert, erledigt das diese Methode.
	 *
	 * @return array letzter gespeicherter Datensatz
	 */
	
	public function get_records()
	{
		if(!empty($this->query_records))
		{
			return $this->query_records;
		}
		else
		{
			$this->saverecords();
			return $this->query_records;
		}
	}

	/**
	 * Liefert die Anzahl der Datensaetze im Ergebnis
	 *
	 * @return int|false
	 */

	public function num_rows() {
		
		$number = mysql_num_rows($this->result);
		
		return $number;

	}

	/**
	 * Liefert die Anzahl betroffener Datensaetze einer vorhergehenden MySQL Operation
	 *
	 * @return int|false
	 */

	public function affected_rows() {
		
		if ($this->no_result === true) {
			$number = mysql_affected_rows();
		} else {
			$number = mysql_affected_rows($this->result);
		}
		
		return $number;
	}
	

	/**
	 * Trennt die Verbindung zur Datenbank
	 * (@link mysql_close)
	 *
	 */

	public function disconnect() {
		if(!mysql_close($this->server_link))
		{
			return false;
		}
		
		return true;

		$this->__destruct();
	}
	
	/**
	 * Ueberschreibung der magischen Methode clone. So werden beim Klonen wichtige Eigenschaften geloescht.
	 * Ebenfalls wird eine neue Verbindung zum Mysql-Datenbank hergestellt. Beim Klonen wird nämlich der Konstruktor nicht nochmals aufgerufen
	 *
	 */
	
	public function __clone()
	{
		$this->result = null;
		$this->new_c = true;
		$this->connect();
	}

	/**
	 * Der Destruktor dieser Klasse
	 * (@link $this->disconnect)
	 */

	public function __destruct() {
		$this->mysql_server = null;
		$this->mysql_db = null;
		$this->mysql_user = null;
		$this->mysql_pw = null;
		$this->new_c = null;
		$this->server_link = null;
		$this->result = null;

	}
	
	private function _logError($function, $line, $msg)
	{
		$this->_errorexists = true;
		$this->_error = array('function' => $function, 'line' => $line, 'msg' => $msg);
	}

};