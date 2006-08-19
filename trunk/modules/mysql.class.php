<?php
class mysql {
		
	private $mysql_server;
	private $mysql_db;
	private $mysql_user;
	private $mysql_pw;
	
	private $server_link;
	private $result;
	
	function __construct() {
		require_once("./config/config.inc.php");
		
		$this->mysql_server = $db_server;
		$this->mysql_db = $db_name;
		$this->mysql_user = $db_user;
		$this->mysql_pw = $db_pw;
		$this->connect();
	}
	
	private function connect() {
		
		$this->server_link = mysql_connect($this->mysql_server, $this->mysql_user, $this->mysql_pw);
		mysql_select_db($this->mysql_db, $this->server_link) or die(mysql_error());
	}
	
	public function query($query) {
		$this->result = mysql_query($query, $this->server_link) or die(mysql_error());
	}
	
	public function fetcharray() {
		$data = mysql_fetch_array($this->result);
		return $data;
	}
	private function disconnect() {
		mysql_close($this->server_link);
	}
	
	function __destruct() {
		$this->disconnect();
	}	
};