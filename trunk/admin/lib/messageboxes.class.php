<?php

/**
 * @author Simon Däster
 * @package JClubCMS
 * File: messageboxes.class.php
 * Classes: messageboxes
 * Requieres: PHP5
 * 
 * 
 * Beschrieb:
 * Dem Konstruktor wird der Aufbau der Tabelle mit einem Array weitergegeben. WerteIn diesem Array unbeding vorkommen muss ID
 * und content. Weiter nueztliche Dine sind ref_ID, name, time, hp, mail. So koennen die Daten nach time geordenet werden 
 * oder hp/mail verifiziert werden. Sie sind nicht absolut noetig, aber hilfreich. Damit diese richtig behandelt werden,
 * muessen sie mit den richtigen Array-keys uebermittelt werden. Natuerlich koennen weitere Daten angegeben werden,
 * die werden aber nicht besonders behandelt. Diese koennen mit nummerierten keys weitergegeben werden.
 */

require_once ADMIN_DIR.'lib/captcha.class.php';
require_once ADMIN_DIR.'lib/mysql.class.php';
require_once ADMIN_DIR.'lib/formular_check.class.php';

class MessageBoxes {
	
	private $_mysql = null;
	private $_formCheck = null;
	
	private $_tablename = null;
	private $_tablestruct = array('ID' => null, 'content' => null, 'ref_ID' => null, 'name' => null, 'time' => null);
	
	private $_error = array();
	private $_errorexists = false;
	
	
	/**
	 * Baut die Klasse auf. Kontrolliert, ob ein MySQL-Objetk weitergegeben wurde und testet (mittels anderer
	 * Methoden), ob der Tabellenname und die Struktur stimmen.
	 *
	 * @param MySQL-Objekt $mysql Mysql-Objekt
	 * @param string $tablename Tabellenname
	 * @param array $tablestruct Struktur der Tabelle
	 */
	
	public function __construct($mysql, $tablename, $tablestruct)
	{
		
		if ($mysql instanceof mysql) {
			$this->mysql = $mysql;
		} else {
			$this->_logError(__FUNCTION__, __LINE__, '1. Parameter ist kein mysql-objekt');
		}
		
		if (is_string($tablename) && !$this->_errorexists) {
			$this->_tablename = $tablename;
		} elseif (!$this->_errorexists) {
			$this->_logError(__FUNCTION__, __LINE__, '2. Parameter ist kein String');
		}
				
		//Ist $tabelstruct ein Array, wird die objekt-eigenschaft verfolstaendigt.
		if (is_array($tablestruct) && !$this->_errorexists) {

			if (!$this->_checkTable($tablestruct) && !$this->_errorexists) {
				$this->_logError(__FUNCTION__, __LINE__, 'Keine passende Mysql-Tabelle vorhanden');
			}
			
			if (!$this->_fillStruct($tablestruct) && !$this->_errorexists) {
				$this->_logError(__FUNCTION__, __LINE__, '3. Parameter beinhahlte nicht ein Index ID oder content');
			}
		
			
		} elseif (!$this->_errorexists) {
			$this->_logError(__FUNCTION__, __LINE__, '3. Parameter ist kein Array');
		}
					
	}
	
	
	/**
	 * Ueberprueft die Eintraege und fuegt dann einen Eintrag in die MySQL-Tabele mit den angegebenen Daten
	 *
	 * @param array $tabledata
	 */
	
	public function addEntry($tabledata)
	{
		if ($this->_errorexists) {
			return false;
		}
		
		if ($tabledata['content'] == "") {
			$this->_logError(__FUNCTION__, __LINE__, 'Kein Text angegeben');
			return false;
		}
		
		//ID darf nicht angegeben werden, Gefahr der Ueberschreibung
		$tabledata['ID'] = "";
		
		//DATEN KONTROLLIEREN!!!!!
		
		$sql = "INSERT INTO `$this->_tablename` ( ";
		$keys = array_keys($tabledata);
		$num = count($tabledata);

		NSERT INTO `jclubbeta`.`test` (`ID`, `name`, `text`, `time`, `test`) VALUES (NULL, 'asdf4845asdf',
		
		$i = 1;
		foreach($tabledata as $key => $value) {
			$sql .= "`{$this->_tablestruct[$key]}`";
			if ($i != $num) {
				$sql .= " , ";
			}
			$i++;
		}
	}
	
	
	/**
	 * Fuellt die Eigenschaft _tablestruct mit den Werten, welche an den Konstruktor weitergegeben wurden.
	 * Wichtige Angaben sind ID und content als Schluessel. $this->_tablestruct enthaelt danach ein Array, desen Werte
	 * die Indizes der Mysql-Tabelle sind.
	 *
	 * @param array $tablestruct Array vom Konstruktor
	 * @return boolean Erfolg
	 */
		
	private function _fillStruct($tablestruct)
	{
		$temp_array = array();
		
		//Mindest ID und content muessen vorhanden sein
		if (array_key_exists("ID", $tablestruct) && array_key_exists("content", $tablestruct)) {
				
			//So werden unnoetige Schluessel ueberschrieben. Kommt z.B. time nicht vor, wird es ueberschrieben.
			$this->_tablestruct = $tablestruct;
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Ueberprueft, ob die Tabelle mit der angegebenen Struktur ueberhaupt existiert.
	 *
	 * @param array $tablestruct
	 * @return boolean Erfolg
	 */
	
	private function _checkTable($tablestruct)
	{
		$table_infos = array();
		$colums_names = array();
		$this->mysql->query('SHOW COLUMNS FROM '.$this->_tablename);
		$this->mysql->saverecords('assoc');
		$table_infos = $this->mysql->get_records();
		
		//Zuschneiden von $table_infos (komplexes Array) in ein einfaches Array
		foreach ($table_infos as $key => $value) {
			$colums_names[$key] = $table_infos[$key]['Field'];
		}
		
		//Sind die angebenen Spalten vorhanden?
		foreach ($tablestruct as $key => $value) {
			if (array_search($value, $colums_names) === false) {
				return false;
			}
		}
		
		return true;
	}
	
	
	/**
	 * Speichert Fehlers in der Fehlertabelle. Diese Funktionen wird von den Klasseneigenen Funktionen aufgerufen
	 *
	 * @param string $function Funktion/Methode, wo der Fehler passier ist
	 * @param string $line Zeilennummer
	 * @param string $message Hinweis
	 */
	private function _logError($function, $line, $message)
	{
		$this->_errorexists = true;
		$this->_error = array('function' => $function, 'line' => $line, 'message' => $message);		
	}
	
	
	/**
	 * Gibt zurueck, ob es ein Fehler gegeben hat.
	 *
	 * @return boolean $errorexists
	 */
	
	public function isError()
	{
		if ($this->_errorexists) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Liefert das Array mit den Fehlermeldungen zurueck
	 *
	 * @return array $error_array Fehlermeldungen
	 */
	
	public function getError()
	{
		return $this->_error;
	}
}
?>