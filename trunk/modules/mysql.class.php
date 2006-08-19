<?php

/*-----------------------------------------------------------------
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
** Das Konstrukt dieser Klasse
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
	
	function __construct($server, $name, $user, $pw, $newcon = 1) {
		
		$this->mysql_server = $server;
		$this->mysql_db = $name;
		$this->mysql_user = $user;
		$this->mysql_pw = $pw;
		$this->new_c = $newcon;
		$this->connect();
	}
	
	private function connect() {
		
		$this->server_link = mysql_connect($this->mysql_server, $this->mysql_user, $this->mysql_pw, $this->new_c);
		mysql_select_db($this->mysql_db, $this->server_link) or die(mysql_error());
	}
	
	public function query($query) {
		$this->result = mysql_query($query, $this->server_link) or die(mysql_error());
	}
	
	public function fetcharray() {
		
		if(is_resource($this->result)) {
			$data = mysql_fetch_array($this->result);
		} else {
			return false;
		}
		
		if(is_array($data)) {
			return $data;
		} else {
			return false;
		}
		
		
	}
	
	public function num_rows() {
		$number = mysql_num_rows($this->result);
		return $number;
	}
	
	public function affected_rows() {
		$number = mysql_affected_rows($this->result);
		return $number;
	}
	
	private function disconnect() {
		mysql_close($this->server_link);
	}
	
	function __destruct() {
		$this->disconnect();
	}	
};