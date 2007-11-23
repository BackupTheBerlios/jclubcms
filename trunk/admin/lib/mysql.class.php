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

class Mysql {

	
	/**
	 * Servername
	 *
	 * @var string
	 */
	private $_mysqlserver = null;
	
	/**
	 * Mysql-Datenbank, mit der gearbeitet wird
	 *
	 * @var string
	 */
	private $_mysqldb = null;
	
	/**
	 * Name des Mysql-Users
	 *
	 * @var string
	 */
	private $_mysqluser = null;
	
	/**
	 * Password des Mysql-Users
	 *
	 * @var string
	 */
	private $_mysqlpw = null;
	
	/**
	 * Gibt an, ob bei einer Mysql-Verbindung mit gleichem Server und User eine neue Verbindung geoeffnet wird oder nicht.
	 *
	 * @var boolean
	 */
	private $_newc = null;

	
	/**
	 * Verbindungserkennung zum Server
	 *
	 * @var resource
	 */
	private $_serverlink = null;
	
	/**
	 * Verbinungserkennung zur Datenbankabfrage
	 *
	 * @var resource
	 */
	private $_result = null;
	
	/**
	 * Angabe, ob mysql_query() eine resource zurueckgibt. Fast nur bei SELECT, SHOW, DESCRIBE, EXPLAIN.
	 *
	 * @var resource
	 */
	private $_noresult = false;
	
	/**
	 * Specichern von Mysql-Datensaetzen
	 *
	 * @var array
	 * @access private
	 */
	private $_queryrecords = array();
	
	
	/**
	 * Gibt es ein Fehler
	 *
	 * @var boolean
	 */
	private $_errorexists = false;

	/**
	 * Speichern des Fehlers
	 * 
	 * @var array
	 */
	private $_error = array();
	
	
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

		$this->_mysqlserver = $server;
		$this->_mysqldb = $db;
		$this->_mysqluser = $user;
		$this->_mysqlpw = $pw;
		$this->_newc = $newcon;
		$this->_connect();
	}
	

	/**
	 * Oeffnet die Verbindung zum Server (wird beim Erstellen des Objekts
	 * aufgerufen)
	 * Gibt bei Erfolg true zurueck, sonst false
	 *
	 * @return boolean
	 */

	private function _connect() {

		$this->_serverlink = mysql_connect($this->_mysqlserver, $this->_mysqluser, $this->_mysqlpw, $this->_newc);
		
		if (!is_resource($this->_serverlink)) {
			$mysql_errstr = mysql_error();
			$mysql_errno = mysql_errno();
			$error_str = "Verbindung zum Mysql-Server fehlgeschlagen.<br />\n(#$mysql_errno) $mysql_errstr";
			throw new CMSException($error_str, EXCEPTION_MYSQL_CODE);
		}

		if (!mysql_select_db($this->_mysqldb, $this->_serverlink)) {
			throw new CMSException('Verbindung zum Mysql-Server fehlgeschlagen', EXCEPTION_MYSQL_CODE);
			//$this->_logError(__FUNCTION__, __LINE__, 'Verbindung zur Mysql-Datenbank fehlgeschlagen');
			//return false;
		}/* else {
			return true;
		}*/

	}
	
	/**
	 * Maskiert spezielle Zeichen im angegebenen String. Bei Binaerdaten zu verwenden
	 *
	 * @param string $string
	 * @return string maskierter String
	 */
	
	public function escapeString($string)
	{	
		if (($string = mysql_real_escape_string($string, $this->_serverlink)) === false) {
			throw new CMSException('Mysql-Anfrage konnte nicht maskiert werden', EXCEPTION_MYSQL_CODE);
		} else {
			return $string;
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
		$this->_queryrecords = array();
		$give_result = false;
		$success = true;
		
		if (!is_string($query)) {
			throw new CMSException('Angegebener Mysql-Query ist kein String', EXCEPTION_MYSQL_CODE);
		}
			
		//Kontrolliert, ob der query SELECT, SHOW, EXPLAIN oder DESCRIBE enthaelt. Nur dann gibt mysql_query ein result zurück
		$query_result_by = array('SELECT', 'SHOW', 'EXPLAIN', 'DESCRIBE');
		
		foreach ($query_result_by as $value) {
			//Enthaelt $query ein Select, Show, usw..., wird die schleife abgebrochen
			$give_result = (stripos($query, $value) === false)?false:true;
			
			if ($give_result == true) {
				break;
			}
		}
		
		if ($give_result == true) {
			$this->_result = mysql_query($query, $this->_serverlink);
			$this->_noresult = false;
			
		} else {
			
			$success = mysql_query($query, $this->_serverlink);
			$this->_noresult = true;
		
		}

		if(($this->_noresult == true && $success == false) || ($this->_noresult == false && $this->_result === false)) {
			throw new CMSException("Mysql-Query ist ung&uuml;ltig<br />\n".mysql_error($this->_serverlink), EXCEPTION_MYSQL_CODE);		
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

		if ($this->_errorexists) {
			return false;
		}
		
		switch ($resulttype) {
			case "num":
				$type = MYSQL_NUM;
				break;

			case "assoc":
				$type = MYSQL_ASSOC;
				break;

			default:
				$type = MYSQL_BOTH;
		}


		$data = mysql_fetch_array($this->_result, $type);
		
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
	 * @return boolean Erfolg
	 */
	
	public function saverecords($resulttype = "assoc")
	{
		$i = 0;
		while($data = $this->fetcharray($resulttype))
		{
			$this->_queryrecords[$i] = $data;
			$i++;
		}
		
		return true;
	}
	
	/**
	 * Gibt der abgespeicherte Datensatz als Array zurueck. Wurde kein Datensatz gespeichert, erledigt das diese Methode.
	 *
	 * @return array letzter gespeicherter Datensatz
	 */
	
	public function get_records()
	{
	
		if(!empty($this->_queryrecords))
		{
			return $this->_queryrecords;
		}
		else
		{
			$this->saverecords();
			return $this->_queryrecords;
		}
	}
	

	/**
	 * Liefert die Anzahl der Datensaetze im Ergebnis
	 *
	 * @return int|false
	 */

	public function num_rows() 
	{
		$number = mysql_num_rows($this->_result);
		
		return $number;

	}

	/**
	 * Liefert die Anzahl betroffener Datensaetze einer vorhergehenden MySQL Operation
	 *
	 * @return int|false
	 */

	public function affected_rows() 
	{
		if ($this->_noresult === true) {
			$number = mysql_affected_rows();
		} else {
			$number = mysql_affected_rows($this->_result);
		}
		
		return $number;
	}
	

	/**
	 * Trennt die Verbindung zur Datenbank
	 * (@link mysql_close)
	 *
	 */

	public function disconnect() {
		if (!is_resource($this->_serverlink) && !mysql_close($this->_serverlink))
		{
			throw new CMSException('Mysql-Verbindung konnte nicht auf Anfrage geschlossen werden', EXCEPTION_MYSQL_CODE);
		}
		
		return true;
	}
	
	/**
	 * Ueberschreibung der magischen Methode clone. So werden beim Klonen wichtige Eigenschaften geloescht.
	 * Ebenfalls wird eine neue Verbindung zum Mysql-Datenbank hergestellt. Beim Klonen wird nämlich der Konstruktor 
	 * nicht nochmals aufgerufen
	 *
	 */
	
	public function __clone()
	{
		$this->result = null;
		$this->new_c = true;
		$this->_connect();
	}

	/**
	 * Der Destruktor dieser Klasse
	 * (@link $this->disconnect)
	 */

	public function __destruct() {
		$this->disconnect();
		$this->_mysqlserver = null;
		$this->_mysqldb = null;
		$this->_mysqluser = null;
		$this->_mysqlpw = null;
		$this->_newc = null;
		$this->_serverlink = null;
		$this->_result = null;

	}
	
//	/**
//	 * Speichert intern den Fehler
//	 *
//	 * @param string $function Methode/Funktion
//	 * @param string $line Zeile
//	 * @param string $msg Nachricht
//	 */
//	
//	private function _logError($function, $line, $msg)
//	{
//		$this->_errorexists = true;
//		$this->_error = array('function' => $function, 'line' => $line, 'msg' => $msg);
//	}
//	
//	/**
//	 * Gibt an, ob ein Fehler aufgetreten ist.
//	 *
//	 * @return boolean
//	 */
//	
//	public function isError()
//	{
//		if ($this->_errorexists == true) {
//			return true;
//		} else {
//			return false;
//		}
//	}
//	
//	/**
//	 * Gibt ein Array zurueck, welches Ort, Zeile und Nachricht des Fehlers enthaelt
//	 *
//	 * @return array $error
//	 */
//	
//	public function getError()
//	{
//		return $this->_error;
//	}

};