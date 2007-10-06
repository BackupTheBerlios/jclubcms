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

	/**
	 * Mysql-Klasse
	 *
	 * @var mysql
	 */
	private $_mysql = null;
	private $_formCheck = null;

	private $_tablename = null;
	private $_tablestruct = array('ID' => null, 'content' => null, 'ref_ID' => null, 'name' => null, 'time' => null);


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
			throw new CMSException('Falsche Parameterangaben. 1. Parameter ist kein mysql-objekt', EXCEPTION_CORE_CODE);
		}

		if (is_string($tablename)) {
			$this->_tablename = $tablename;
		} elseif (!$this->_errorexists) {
			throw new CMSException('Falsche Parameterangaben. 2. Parameter ist kein String', EXCEPTION_CORE_CODE);
		}

		//Ist $tabelstruct ein Array, wird die objekt-eigenschaft verfolstaendigt.
		if (is_array($tablestruct)) {

			if (!$this->_checkTable($tablestruct)) {
				throw new CMSException('Falsche Parameterangaben. Keine passende Mysql-Tabelle vorhanden', EXCEPTION_CORE_CODE);
			}

			if (!$this->_fillStruct($tablestruct)) {
				throw new CMSException('Falsche Parameterangaben. 3. Parameter beinhahlte nicht ein Index ID oder content', EXCEPTION_CORE_CODE);
			}


		} else {
			throw new CMSException('Falsche Parameterangaben. 3. Parameter ist kein Array', EXCEPTION_CORE_CODE);
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

		if ($tabledata['content'] == "") {
			throw new CMSException('Falsche Parameterangaben. Kein Text angegeben', EXCEPTION_CORE_CODE);
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

		/** MYSQL-ERROR noch abfragen!!! **/
		//** Update: Nein, Exception regelt das **/
		$this->_mysql->query($sql);
		return true;
	}

	public function editEntry($tabledata)
	{

		if ($tabledata['content'] == "") {
			throw new CMSException('Falsche Parameterangaben. Kein Text angegeben', EXCEPTION_CORE_CODE);
		}


		if ($tabledata['ID'] == ""  || !is_numeric($tabledata['ID'])) {
			throw new CMSException('Falsche Parameterangaben. Kein Text angegeben', EXCEPTION_CORE_CODE);
		}

		$sql = "UPDATE `$this->_tablename` SET ( ";;
		$num = count($tabledata);


		$i = 1;
		foreach ($tabledata as $key => $value) {
			$sql .= "`{$this->_tablestruct[$key]}`";

			//Zur Sicherheit escapen
			$sql .= "'".$this->_mysql->escapeString($value)."'";
			if ($i != $num) {
				$sql .= ", ";
			}
			$i++;
		}

		$sql.= ")";


	}


	/**
	 * Liefert ein Tabelleneintrag mit der angegebenen ID und formatiert (wenn angegeben) die Zeit.
	 *
	 * @param int $id ID des Eintrags
	 * @param string $timeformat Zeitformat nach Mysql
	 * @return array Eintrag, bei Fehler false
	 */

	public function getEntry($id, $timeformat = "")
	{
		$msg_array = array();

		if (!is_numeric($id)) {
			throw new CMSException('Falsche Parameterangaben. 1. Argument ist kein Zahlenwert', EXCEPTION_CORE_CODE);
		}

		if(!is_string($timeformat)) {
			throw new CMSException('Falsche Parameterangaben. 2. Argument ist kein String', EXCEPTION_CORE_CODE);
		}

		$sql = "SELECT * FROM `{$this->_tablename}` WHERE `{$this->_tablestruct['ID']}` = '$id' LIMIT 1";
		/**
		 * @var $_mysql mysql
		 */
		$this->_mysql->query($sql);

		$msg_array = $this->_mysql->fetcharray('assoc');



		if ($timeformat && is_string($timeformat) && isset($this->_tablestruct['time'])) {
			$msg_array['time'] = $this->_formatTime($msg_array[$this->_tablestruct['time']], $timeformat);
		}


		return $msg_array;

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

	public function getEntries($entries_pp, $page, $order = 'DESC', $corder = 'ASC', $timeformat = "")
	{
		$msg_array = array();
		$strorder = array();


		if (!is_numeric($entries_pp) && !is_numeric($page)) {
						throw new CMSException('Falsche Parameterangaben. Angegebene Argumente sind keine Zahlenwerte', EXCEPTION_CORE_CODE);
		}


		//Ordnungsbedingung fuer Mysql-Query
		if ($order != 'ASC' && $order != 'DESC' && $order != "") {
			throw new CMSException('Falsche Parameterangaben. 3. Parameter nicht zulaessig', EXCEPTION_CORE_CODE);

		} elseif ($corder != 'ASC' && $corder != 'DESC' && $corder != "") {
			throw new CMSException('Falsche Parameterangaben. 4. Parameter nicht zulaessig', EXCEPTION_CORE_CODE);

		} elseif (isset($this->_tablestruct['time']) && !empty($this->_tablestruct['time']) && $order != "" && $corder != "") {
			$strorder['norm'] = "ORDER BY {$this->_tablestruct['time']} $order";
			$strorder['comm'] = "ORDER BY {$this->_tablestruct['time']} $corder";


		} else {
			$strorder['norm'] = "";
			$strorder['comm'] = "";

		}


		$start = ($page-1)*$entries_pp;


		if (isset($this->_tablestruct['ref_ID'])) {
			$condition = "WHERE `{$this->_tablestruct['ref_ID']}` = '0'";
		} else {
			$condition = "";
		}
		$sql = "SELECT * FROM `{$this->_tablename}` $condition {$strorder['norm']} LIMIT $start, $entries_pp";
		$this->_mysql->query($sql);
		$this->_mysql->saverecords('assoc');
		$msg_array = $this->_mysql->get_records();

		//Zeit formatieren und Kommentare holen.
		foreach ($msg_array as $key => $value) {

			if ($condition != "") {//ref_ID muss gesetzt sein.
				$this->_mysql->query("SELECT * FROM {$this->_tablename} WHERE `{$this->_tablestruct['ref_ID']}` = '{$value[$this->_tablestruct['ID']]}' {$strorder['comm']}");
				$this->_mysql->saverecords('assoc');
				$value['comments'] = $this->_mysql->get_records();

			}

			//Zeit formatieren
			if ($timeformat && is_string($timeformat) && isset($this->_tablestruct['time'])) {
				$value['time'] = $this->_formatTime($value[$this->_tablestruct['time']], $timeformat);

				if ($condition != "") {//ref_ID muss gesetzt sein.
					foreach ($value['comments'] as $key2 => $cvalue) {
						$value['comments'][$key2]['time'] = $this->_formatTime($cvalue[$this->_tablestruct['time']], $timeformat);

					}
				}
			}
			//Veraenderte Werte zuweisen
			$msg_array[$key] = $value;
			$msg_array[$key]['number_of_comments'] = count($value['comments']);
		}

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
			throw new CMSException('Falsche Parameterangaben. Timeformat-String oder Time-String falsch', EXCEPTION_CORE_CODE);
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
}
?>