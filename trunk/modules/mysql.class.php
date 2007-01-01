<?php

/**
 * @package JClubCMS
 * @author David D�ster, Simon D�ster
* File: mysql.class.php
* Classes: mysql
* Requieres: PHP5, MySQL 4.x
* 
* Die Klasse mysql ist zust�ndig f�r das ganze Datenbankh�ndling
* von mysql.
* �ber sie gehen alle Verbindungen, Queries und MySQL-Spezifische
* Funktionen (z.B. mysql_fetch_array)
* Die Daten werden in der Klasse gespeichert und nur die Enddaten
* ausgegeben.
*
*
* Funktionsbeschrieb:
** __construct($server, $name, $user, $pw, [$newcon])
** 
*
** connect()
** �ffnet die Verbindung zum Server (wird beim Erstellen des Objekts
** aufgerufen
*
** fetcharray()
** Analog mysql_fetch_array
*
** num_rows()
** Analog mysql_num_rows
*
**error($errorcode, $errortext)
**Gibt die Fehler aus
*
** disconnect()
** Analog mysql_close (Wird vom Destruktor aufgerufen)

** __destruct
** Der Destruktor der Klasse
*-----------------------------------------------------------------*/

class mysql {

	private $mysql_server = null;
	private $mysql_db = null;
	private $mysql_user = null;
	private $mysql_pw = null;
	private $new_c = null;

	private $server_link = null;
	private $result = null;

	private $error = false;
	private $error_text = "";
	private $error_no = "";

	/**
	 * Das Konstrukt dieser Klasse
	 *
	 * @param string $server
	 * @param string $name
	 * @param string $user
	 * @param string $pw
	 * @param string $newcon
	 */

	function __construct($server, $name, $user, $pw, $newcon = 1) {

		$this->mysql_server = $server;
		$this->mysql_db = $name;
		$this->mysql_user = $user;
		$this->mysql_pw = $pw;
		$this->new_c = $newcon;
		$this->connect();
	}

	/**
	 * �ffnet die Verbindung zum Server (wird beim Erstellen des Objekts
	 * aufgerufen)
	 * Gibt bei Erfolg true zur�ck, sonst false
	 *
	 * @return boolean
	 */

	private function connect() {

		$this->server_link = mysql_connect($this->mysql_server, $this->mysql_user, $this->mysql_pw, $this->new_c);
		if(!is_resource($this->server_link)) {
			$this->error = true;
			$this->error_text = mysql_error();
			$this->error_no = mysql_errno();
			return false;
		}

		if(!mysql_select_db($this->mysql_db, $this->server_link)) {
			$this->error = true;
			$this->error_text = mysql_error($this->server_link);
			$this->error_no = mysql_errno($this->server_link);
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
		$this->result = @mysql_query($query, $this->server_link);

		if(!is_resource($this->result)) {
			$this->error = true;
			$this->error_text = "query-result is not a resource in fucntion query";
			$this->error_no = "no error-number";
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Liefert bei Erfolg einen Datensatz als Array, sonst false
	 * 
	 * @param string[optional] $resulttype = "both"|"num"|"assoc"
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

		$data = @mysql_fetch_array($this->result, $type);


		if(is_array($data)) {
			return $data;
		} else {
			$this->error = true;
			$this->error_text = "return value is not a array in function fetcharray";
			$this->error_no = "no error-number";
			return false;
		}

	}

	/**
	 * Liefert die Anzahl der Datens�tze im Ergebnis
	 *
	 * @return int|false
	 */

	public function num_rows() {
		$number = @mysql_num_rows($this->result, $type);
		if($number == false) {
			$this->error = true;
			$this->error_text = "return value is not a number in function num_rows";
			$this->error_no = "no error-number";
			return false;
		}
		return $number;

	}

	/**
	 * Liefert die Anzahl betroffener Datens�tze einer vorhergehenden MySQL Operation
	 *
	 * @return int|false
	 */

	public function affected_rows() {
		$number = mysql_affected_rows($this->result);
		if($number == false) {
			$this->error = true;
			$this->error_text = "return value is not a number in function affected_rows";
			$this->error_no = "no error-number";
			return false;
		}
		return $number;
	}
	
	/**
	 * Wenn es einen Fehler gegeben hat, liefert die Funktion den Fehlertext und Fehlernummer
	 * Hat es keinen Fehler gegeben, liefert sie false
	 *
	 * @return array|false
	 */
	
	public function get_error() {
		if($this->error) {
			return array($this->error_no, $this->error_text);
		} else {
			return false;
		}
	}


	/**
	 * Trennt die Verbindung zur Datenbank
	 * (@link mysql_close)
	 *
	 */

	public function disconnect() {
		if(!mysql_close($this->server_link))
		{
			$this->error = true;
			$this->error_text = "conncect-reult is not a ressource in function disconnect";
			$this->error_no = "no error-number";
			return false;
		}

		$this->__destruct();
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

};