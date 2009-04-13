<?php
/**
 * TODO PageDoc
 * 
 * Filedokumentation fehlt
 * 
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 * @author David Däster
 * @package JClubCMS
 */
/**
 * Die Klasse soll die Texte aus den Inhalten der Seite, sowie aus den Gaestebuecher und News uebersetzen.
 * Die BBCodes sind in der MySQL-Tabelle bbcodes abgelegt, sowie das HTML-Pendant.
 * Das HTML-Pendant enthaelt jeweils ein oder mehrere %s welche den Standort des einzufuegenden Textes enthaelt.
 * 
 * Zudem muss noch ueberprueft werden:
 * -> BBCodes muessen sauber verschachtelt sein, wenn nicht sollen sie nicht uebersetzt oder bei der anzeige geloescht werden.
 * 
 * Beachtet werden sollte spaeter auch noch:
 * -> Nicht jeder BBCode sollte ueberall verwendet werden koennen (URL und IMG nicht im Gaestebuch)
 * 
 * @requires PHP5
 * @author David Däster
 * @package JClubCMS
 * @uses Mysql for connectiong to the database
 */
class Bbcodes {
	private $_bbcodes_array;
	private $_type;
	private $_mysql_link;
	/**
 	 * Konstruktor der Klasse
 	 *
 	 * @param string $type Welchen Inhalt muss geparst werden (GB, News, Content)
 	 * @param object $mysql_link Datenverbindung zur MySQL
 	 */
	public function __construct($type, $mysql_link) {
		$this->_type = $type;
		$this->_mysql_link = $mysql_link;

	}
	/**
 	 * Klassendestruktor
 	 *
 	 */
	public function __destruct() {
		$this->_bbcodes_array = NULL;
	}
	/**
 	 * Holt die BBCodes aus der Datenbank. Geschieht am Anfang, damit nachher dauernd mit den gleichen Daten gearbeitet wird.
 	 *
 	 * @param object $mysql_link Datenverbindung zur MySQL
 	 */
	private function _check_type() {
		//$mysql_link = $this->_mysql_link;
		$query = "SHOW COLUMNS FROM `bbcodes` LIKE 'bbcodes_rights'";
		$this->_mysql_link->query($query);
		$tabledata = $this->_mysql_link->fetcharray('assoc');
		$found = eregi($this->_type, $tabledata["Type"]);
		return $found;
	}

	/**
	 * Liefert die bbcodes zurück. Arbeitet mit {@link _check_type()} zusammen.
	 */
	public function get_bbcodes() {
		if ($this->_check_type()== 1) {
			//$mysql_link = $this->_mysql_link;
			$query = "SELECT * FROM `bbcodes` WHERE find_in_set('$this->_type', `bbcodes_rights`)";
			$this->_mysql_link->query($query);
			$bbcodes_array = array();

			$this->_mysql_link->saverecords('assoc');
			$bbcodes_array = $this->_mysql_link->get_records();
			
			$this->_bbcodes_array = $bbcodes_array;
			return $this->_bbcodes_array;

		} else {
			return 0;
		}
	}

	/**
	 * Ersetzt den Text durch 
	 */
	public function replace_bbcodes($text) {
		if ($this->_check_type()== 1) {
			//$this->_mysql_link = $this->_mysql_link;
			$query = "SELECT * FROM `bbcodes` WHERE find_in_set( '$this->_type', `bbcodes_rights`)";
			$this->_mysql_link->query($query);
			
			while ($bbcodes_data = $this->_mysql_link->fetcharray()) {
				$text = preg_replace($bbcodes_data["bbcodes_regex"], $bbcodes_data["bbcodes_htmltag"], $text);
			}
		}
		
		return $text;
	}
}
?>
