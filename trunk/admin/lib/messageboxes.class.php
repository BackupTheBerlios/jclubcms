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
	
	public function __construct($mysql, $tablename, $tablestruct)
	{
		
		
		if (is_a($mysql, 'mysql')) {
			$this->mysql = $mysql;
		} else {
			$this->_logError(__FUNCTION__, __LINE__, '1. Parameter ist kein mysql-objekt');
		}
		
		if (is_string($tablename)) {
			$this->_tablename = $tablename;
		} else {
			$this->_logError(__FUNCTION__, __LINE__, '2. Parameter ist kein String');
		}
				
		//Ist $tabelstruct ein Array, wird die objekt-eigenschaft verfolstaendigt.
		if (is_array($tablestruct)) {

			if (!$this->_fillStruct($tablestruct)) {
				$this->_logError(__FUNCTION__, __LINE__, '3. Parameter beinhahlte nicht ein Index ID oder content');
			}
			
			if(!$this->_checkTable($tablestruct)) {
				$this->_logError(__FUNCTION__, __LINE__, 'Keine passende Mysql-Tabelle vorhanden');
			}
			
		} else {
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
		if($tabledata['content'] == "") {
			$this->_logError(__FUNCTION__, __LINE__, 'Kein Text angegeben');
			return false;
		}
		
		//DATEN KONTROLLIEREN!!!!!
		
		$sql = "INSERT INTO `$this->_tablename` ( ";
		$keys = array_keys($tabledata);

		foreach($key as $value) {
			$sql .= "`$key`, ";
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
			$temp_array['ID'] = $tablestruct['ID'];
			$temp_array['content'] = $tablestruct['content'];
			
			foreach ($tablestruct as $key => $value) {
				$temp_array[$key] = $value;
			}
			
			//So werden unnoetige Schluessel ueberschrieben. Kommt time nicht vor, wird es ueberschrieben
			$this->_tablestruct = $temp_array;
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
		$this->mysql->query('');
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
}
?>