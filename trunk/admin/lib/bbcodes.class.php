<?php
/**
 * @author David Däster
 * @package JClubCMS
 * File: bbcodes.class.php
 * Classes: bbcodes
 * Reuqires: PHP5
 */

/**
 * Die Klasse soll die Texte aus den Inhalten der Seite, sowie aus den Gästebücher und News übersetzen.
 * Die BBCodes sind in der MySQL-Tabelle bbcodes abgelegt, sowie das HTML-Pendant.
 * 
 * Das HTML-Pendant enthält jeweils ein oder mehrere %s welche den Standort des einzufügenden Textes enthält.
 * 
 * Zudem muss noch überprüft werden:
 * -> BBCodes müssen sauber verschachtelt sein, wenn nicht sollen sie nicht übersetzt oder bei der anzeige gelöscht werden.
 * 
 * Beachtet werden sollte später auch noch:
 * -> Nicht jeder BBCode sollte überall verwendet werden können (URL und IMG nicht im Gästebuch)
 */

 class bbcodes {
 	private $bbcodes_array;
 	private $type;
 	private $mysql_link;
 	/**
 	 * Konstruktor der Klasse
 	 *
 	 * @param object $mysql_link Datenverbindung zur MySQL
 	 * @param string $type Welchen Inhalt muss geparst werden (GB, News, Content)
 	 */
 	public function __construct($type, $mysql_link) {
 		$this->type = $type;
 		$this->mysql_link = $mysql_link;
 		
 	}
 	/**
 	 * Klassendestruktor
 	 *
 	 */
 	public function __destruct() {
 		$this->bbcodes_array = NULL;
 	}
 	/**
 	 * Holt die BBCodes aus der Datenbank. Geschieht am Anfang, damit nachher dauernd mit den gleichen Daten gearbeitet wird.
 	 *
 	 * @param object $mysql_link Datenverbindung zur MySQL
 	 */
 	private function check_type() {
 		$mysql_link = $this->mysql_link;
 		$found = 0;
 		$query = " SHOW COLUMNS FROM bbcodes LIKE 'bbcodes_rights'";
 		$mysql_link->query($query);
 		$tabledata = $mysql_link->fetcharray();
 		$found = eregi($this->type, $tabledata["Type"]);
 		return $found;
 	}
 	
 	public function get_bbcodes() {
 		if ($this->check_type()== 1) {
 		$mysql_link = $this->mysql_link;
 		$query = "SELECT * FROM bbcodes WHERE bbcodes_rights = $this->type";
 		$mysql_link->query($query);
 		$bbcodes_array = array();
 		$i = 0;
 		while ($bbcodes_data = $mysql_link->fetcharray()) {
 			$bbcodes_array[$i] = array('bbctag'=>$bbcodes_data["bbcodes_bbctag"], 'htmltag'=>$bbcodes_data["bbcodes_htmltag"]);
 			$i++;
 		}
 		$this->bbcodes_array = $bbcodes_array;
 		return $this->bbcodes_array;
 		
 		}
 		else {return 0;}
 	}
 	
 	public function replace_bbcodes($text) {
 		if ($this->check_type()== 1) {
 			$mysql_link = $this->mysql_link;
	 		$query = "SELECT * FROM bbcodes WHERE bbcodes_rights = $this->type";
	 		$mysql_link->query($query);
	 		$bbcodes_array = array();
	 		$i = 0;
	 		while ($bbcodes_data = $mysql_link->fetcharray()) {
	 			$text = preg_replace($bbcodes_data["bbcodes_regex"], $bbcodes_data["bbcodes_htmltag"], $text);
	 		}
 		}
		$text = preg_replace("/\[u\](.*?)\[\/u\]/si", "<u>\\1</u>",$text);
 		return $text;
 }
 }
?>