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
require_once ADMIN_DIR.'lib/formularcheck.class.php';

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
		//Argumente ueberpruefen
		if ($mysql instanceof mysql) {
			$this->_mysql = $mysql;
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

		//Eigene Objekte initialisieren
		$this->_formCheck = new FormularCheck();

	}


	/**
	 * Ueberprueft die Eintraege und fuegt dann einen Eintrag in die MySQL-Tabele mit den angegebenen Daten
	 *
	 * @param array $tabledata einzugebende Daten
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


		$sql[0] = "INSERT INTO `$this->_tablename` ( ";
		$sql[1] = ") VALUES (";
		$num = count($tabledata);


		$i = 1;
		foreach ($tabledata as $key => $value) {
			$sql[0] .= "`{$this->_tablestruct[$key]}`";

			//Zur Sicherheit escapen
			$sql[1] .= "'".$this->_mysql->escapeString($value)."'";
			if ($i != $num) {
				$sql[0] .= ", ";
				$sql[1] .= ", ";
			}
			$i++;
		}

		$sql[1] .= ")";
		$sql['string'] = join("", $sql);

		/*$sql .= ") VALUES (";

		$i = 1;
		foreach ($tabledata as $value) {
		//Zur Sicherheit escapen
		$sql .= "'".$this->_mysql->escapeString($value)."'";
		if ($i != $num) {
		$sql .= ", ";
		}
		$i++;
		}

		$sql .= ")";*/

		debugecho(debug_backtrace(), "SQL: {$sql['string']}");

		/** MYSQL-ERROR noch abfragen!!! **/
		//$this->_mysql->query($sql);
		return true;
	}

	/**
	 * Liefert die Tabelleneintraege im angegebenen Bereich (wenn moeglich) zeitlich geordnet und (wenn angegeben)
	 * zeitformatiert zurueck.
	 *
	 * @param int $entries_pp Eintraege pro Seite
	 * @param int $page Seite
	 * @param string $order Reihenfolge DESC|ASC
	 * @param string $timeformat Zeitformat nach Mysql
	 * @return array Eintraege, bei Fehler false
	 */

	public function getEntries($entries_pp, $page, $order = 'DESC', $timeformat = "")
	{
		$msg_array = array();
		$strorder = "";

		if ($this->_errorexists) {
			return false;
		}


		if ($order != 'ASC' && $order != 'DESC' && $order != "") {
			$this->_logError(__FUNCTION__, __LINE__, '3. Parameter nicht zulaessig');
			return false;

		} elseif (isset($this->_tablestruct['time']) && !empty($this->_tablestruct['time']) && $order != "") {
			$strorder = "ORDER BY {$this->_tablestruct['time']} $order";

		} else {
			$strorder = "";
		}

		if (!is_numeric($entries_pp) && !is_numeric($page)) {
			$this->_logError(__FUNCTION__, __LINE__, 'Angegebene Argumente sind keine Zahlenwerte');
			return false;
		}



		$start = ($page-1)*$entries_pp;

		if (isset($this->_tablestruct['ref_ID'])) {
			$condition = "WHERE `{$this->_tablestruct['ref_ID']}` = '0'";
		} else {
			$condition = "";
		}
		$sql = "SELECT * FROM `{$this->_tablename}` $condition $strorder LIMIT $start, $entries_pp";
		$this->_mysql->query($sql);
		$this->_mysql->saverecords('assoc');
		$msg_array = $this->_mysql->get_records();

		if ($condition != "") { //ref_ID muss gesetzt sein.
			foreach ($msg_array as $key => $value) {

				$this->_mysql->query("SELECT * FROM {$this->_tablename} WHERE `{$this->_tablestruct['ref_ID']}` = '{$value[$this->_tablestruct['ID']]}' $strorder");
				$this->_mysql->saverecords('assoc');
				$value['comments'] = $this->_mysql->get_records();

				//Zeit formatieren
				if ($timeformat && is_string($timeformat) && isset($this->_tablestruct['time'])) {
					$value['time'] = $this->_formatTime($value[$this->_tablestruct['time']], $timeformat);

					foreach ($value['comments'] as $key2 => $cvalue) {
						$value['comments'][$key2]['time'] = $this->_formatTime($cvalue[$this->_tablestruct['time']], $timeformat);

					}
				}
				$msg_array[$key] = $value;
				$msg_array[$key]['number_of_comments'] = count($value['comments']);
			}
		}
		/** MYSQL-ERROR noch abfragen!!! **/
		
		return $msg_array;

	}


	/**
	 * Formatiert die angegeben Zeit mittels Mysql
	 *
	 * @param string $time
	 * @param string $timeformat
	 * @return string formatierte Zeit, bei Fehler false
	 */

	private function _formatTime($time, $timeformat)
	{
		if (is_string($timeformat) && !empty($timeformat) && is_string($time)&& !empty($time)) {
			$this->_mysql->query("SELECT DATE_FORMAT('$time', '$timeformat') as time");
			$arr = $this->_mysql->fetcharray('assoc');
			return $arr['time'];
		} else {
			$this->_logError(__FUNCTION__, __LINE__, 'Timeformat-String oder Time-String falsch');
			return false;
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
		$this->_mysql->query('SHOW COLUMNS FROM '.$this->_tablename);
		$this->_mysql->saverecords('assoc');
		$table_infos = $this->_mysql->get_records();

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