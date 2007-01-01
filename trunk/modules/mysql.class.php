<?php

/**
 * @package JClubCMS
 * @author David Däster, Simon Däster
* File: mysql.class.php
* Classes: mysql
* Requieres: PHP5, MySQL 4.x
* 
* Die Klasse mysql ist zuständig für das ganze Datenbankhändling
* von mysql.
* Über sie gehen alle Verbindungen, Queries und MySQL-Spezifische
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
** Öffnet die Verbindung zum Server (wird beim Erstellen des Objekts
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

	private $mysql_server;
	private $mysql_db;
	private $mysql_user;
	private $mysql_pw;
	private $new_c;

	private $server_link;
	private $result;

	private $error_text;
	private $error_no;

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
	 * Öffnet die Verbindung zum Server (wird beim Erstellen des Objekts
	 * aufgerufen
	 *
	 */

	private function connect() {

		$this->server_link = mysql_connect($this->mysql_server, $this->mysql_user, $this->mysql_pw, $this->new_c);
		if(!is_resource($this->server_link)) {
			$this->error_text = mysql_error();
			$this->error_no = mysql_errno();
			return false;
		}

		if(!mysql_select_db($this->mysql_db, $this->server_link)) {
			$this->error_text = mysql_error();
			$this->error_no = mysql_errno();
			return false;
		} else {
			return true;
		}

	}

	/**
	 * Sendet eine Anfrage an MySQL
	 *
	 * @param string $query Die Mysql-Eingabe
	 */

	public function query($query) {
		$this->result = @mysql_query($query, $this->server_link);

		if(!is_resource($this->result)) {
			$this->error_text = mysql_error($this->server_link);
			$this->error_no = mysql_errno($this->server_link);
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Liefert einen Datensatz als Array
	 * 
	 * @param string[optional] $resulttype = "both"|"num"|"assoc"
	 * @return array|boolean $data|false
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
			$this->error_text = mysql_error($this->server_link);
			$this->error_no = mysql_errno($this->server_link);
			return false;
		}

	}

	/**
	 * Liefert die Anzahl der Datensätze im Ergebnis
	 *
	 * @return int
	 */

	public function num_rows() {
		$number = @mysql_num_rows($this->result, $type);
		if($number == false) {
			$this->error_text = mysql_error($this->server_link);
			$this->error_no = mysql_errno($this->server_link);
			return false;
		}
		return $number;

	}

	/**
	 * Liefert die Anzahl betroffener Datensätze einer vorhergehenden MySQL Operation
	 *
	 * @return int
	 */

	public function affected_rows() {
		$number = mysql_affected_rows($this->result);
		if($number == false) {
			$this->error_text = mysql_error($this->server_link);
			$this->error_no = mysql_errno($this->server_link);
			return false;
		}
		return $number;
	}
	
	public function get_error() {
		return array($this->error_no, $this->error_text);
	}


	/**
	 * Trennt die Verbindung zur Datenbank
	 * (@link mysql_close)
	 *
	 */

	public function disconnect() {
		if(mysql_close($this->server_link))
		{
			$this->error_text = mysql_error($this->server_link);
			$this->error_no = mysql_errno($this->server_link);
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