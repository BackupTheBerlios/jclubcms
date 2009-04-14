<?php
/**
 * Messageboxes ist eine Abstraktion von gängingen Meitteilungsboxen
 * 
 * Messageboxes ermöglicht die standardisierte Variante von
 * <ul><li>Speichern</li><li>Auslesen</li><li>Ändern</li></ul>
 * von Daten, die in einer Mysql-Tabelle vorhanden sind.
 * 
 * @package JClubCMS
 * @author Simon Däster
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 */
require_once ADMIN_DIR.'lib/captcha.class.php';
require_once ADMIN_DIR.'lib/mysql.class.php';
require_once ADMIN_DIR.'lib/formularcheck.class.php';

if (!defined('MSGBOX_FORMCHECK_OK')) {
	/**
	 * Forumlarwert ist sauber
	 *
	 */
	define('MSGBOX_FORMCHECK_OK', 1);
}


if (!defined('MSGBOX_FORMCHECK_NONE')) {
	/**
	 * Formularwert enthält Standard-Wert oder ist leer
	 *
	 */
	define('MSGBOX_FORMCHECK_NONE', 2);
}


if (!defined('MSGBOX_FORMCHECK_INVALID')) {
	/**
	 * Formularwert ist ungueltig
	 *
	 */
	define('MSGBOX_FORMCHECK_INVALID', 4);
}
/**
* Die Klasse MessageBoxes ist verantwortlich für das Verwalten von Nachrichten in der Datenbank. 
 * Nachrichten können News, Gästebucheinträge, Nachrichten u.ä. sein.
 * 
 * Möglichkeiten der Klassen:
 * <ul><li>Nachrichten in die Datenbank eintragen</li>
 * <li>zu Nachrichten Kommentare schreiben</li>
 * <li>Nachrichten löschen</li>
 * <li>Nachrichten zurückgeben</li>
 * <li>überprüfen, ob einen Nachricht ein Kommentar einer anderen Nachricht ist.</li></ul>
 * Weiter verfügt die Klasse über eine Methode, die angegeben Einträge auf Standart-Werte und leere String 
 * prüft. Dies ist nützlich, wenn ein Modul überprüfen will, ob keine 
 * dieser Werte vorhanden sind.
 * 
 * Dem Konstruktor wird der Aufbau der Tabelle mit einem Array
 * weitergegeben. WerteIn diesem Array unbeding vorkommen muss 
 * ID und content. Weiter nueztliche Dine sind ref_ID, name, time, 
 * hp, mail. So koennen die Daten nach time geordenet werden  oder 
 * hp/mail verifiziert werden. Sie sind nicht absolut noetig, aber 
 * hilfreich. Damit diese richtig behandelt werden, muessen sie mit 
 * den richtigen Array-keys uebermittelt werden. Natuerlich koennen 
 * weitere Daten angegeben werden, die werden aber nicht besonders 
 * behandelt. Diese koennen mit nummerierten keys weitergegeben werden.
 * @author Simon Däster
 * @package JClubCMS
 * @uses Mysql Zugriff auf Datenbank
 * @uses Formularcheck Plausibilitätsüberprüfung von Formularen
 * 
 */
class Messageboxes {

	/**
	 * Mysql-Klasse
	 *
	 * @var mysql
	 */
	private $_mysql = null;
	/**
	 * FormularCheck-Klasse
	 *
	 * @var FormularCheck
	 */
	private $_formCheck = null;
	/**
	 * Gibt an, ob ein Check des Forumlars durch die Methode Messageboxes::formcheck
	 *
	 * @var boolean
	 */
	private $_form_checked = false;
	/**
	 * Name der Mysql-Tabelle, in welche die Message eingefügt wird
	 *
	 * @var string
	 */
	private $_tablename = null;
	/**
	 * FAufbau der Tabelle $_tablename, welche im Array gespeichert wird
	 *
	 * @var array
	 */
	private $_tablestruct = array('ID' => null, 'content' => null, 'ref_ID' => null, 'name' => null, 'time' => null);


	/**
	 * Baut die Klasse auf. Kontrolliert, ob ein MySQL-Objetk weitergegeben wurde und testet (mittels anderer
	 * Methoden), ob der Tabellenname und die Struktur stimmen.
	 *
	 * @param Mysql $mysql Mysql-Objekt
	 * @param string $tablename Tabellenname
	 * @param array $tablestruct Struktur der Tabelle
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 * @uses Formularcheck Plausibilitätsüberprüfung von Formularen
	 * @uses CMSException
	 */
	public function __construct($mysql, $tablename, $tablestruct)
	{
		//Argumente ueberpruefen
		if ($mysql instanceof Mysql) {
			$this->_mysql = $mysql;
		} else {
			throw new CMSException(array('msg_box' => 'wrong_param_mysql'), EXCEPTION_LIBARY_CODE);
		}

		if (is_string($tablename)) {
			$this->_tablename = $this->_mysql->escapeString($tablename);
		} else {
			throw new CMSException(array('msg_box' => 'wrong_param_string'), EXCEPTION_LIBARY_CODE);
		}

		//Ist $tabelstruct ein Array, wird die objekt-eigenschaft verfolstaendigt.
		if (is_array($tablestruct)) {

			if (!$this->_checkTable($tablestruct)) {
				throw new CMSException(array('msg_box' => 'wrong_param_mysqltab'), EXCEPTION_LIBARY_CODE);
			}

			if (!$this->_fillStruct($tablestruct)) {
				throw new CMSException(array('msg_box' => 'wrong_param_key'), EXCEPTION_LIBARY_CODE);
			}


		} else {
			throw new CMSException(array('msg_box' => 'wrong_param_array'), EXCEPTION_LIBARY_CODE);
		}

		//Eigene Objekte initialisieren
		$this->_formCheck = new Formularcheck();

	}


	/**
	 * Ueberprueft die Eintraege und fuegt dann einen Eintrag in die MySQL-Tabele mit den angegebenen Daten
	 *
	 * @param array $tabledata einzugebende Daten
	 * @return boolean Liefert bei Erfolg true, sonst Exception
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 * @uses CMSException
	 */

	public function addEntry($tabledata)
	{
		if ($tabledata['content'] == "") {
			throw new CMSException(array('msg_box' => 'wrong_param_text'), EXCEPTION_LIBARY_CODE);
		}

		if ($this->_form_checked == false) {
			throw  new CMSException(array('msg_box' => 'no_check_valid'), EXCEPTION_LIBARY_CODE);
		}

		//Formular-Check durchführen

		//ID darf nicht angegeben werden, Gefahr der Ueberschreibung
		$tabledata['ID'] = "";
		//Time muss beim Argument nicht angegeben werden, darum wird der Schluessel hier definiert.
		$tabledata['time'] = "NOW()";


		$sql['def'] = "INSERT INTO `$this->_tablename` ( ";
		$sql['val'] = ") VALUES (";
		$num = count($tabledata);


		$i = 1;
		foreach ($tabledata as $key => $value) {
			$sql['def'] .= "`{$this->_tablestruct[$key]}`";

			//Zur Sicherheit escapen
			if ($key == 'time') {
				$sql['val'] .= "NOW()";
			} else {
				$sql['val'] .= "'".$this->_mysql->escapeString($value)."'";
			}

			if ($i != $num) {
				$sql['def'] .= ", ";
				$sql['val'] .= ", ";
			}
			$i++;
		}
		
		
		if (!key_exists('time', $tabledata)) {
			$sql['def'] .= ", {$this->_tabbelstruct['time']}";
			$sql['val'] .= ", NOW()";
		}

		$sql['val'] .= ")";
		$query = join("", $sql);

		$this->_mysql->query($query);
		return true;
	}
	
	/**
	 * Ueberprueft die Eintraege und fuegt dann einen Eintrag in die MySQL-Tabele mit den angegebenen Daten. 
	 * 
	 * Der Eintrag wird so in der Mysql-Tabelle erstellt, dass er zum vorherigen Beitrag refernziert und so einen Kommentar darstellt
	 *
	 * @param num $id ID der referenzierenden Beitrags
	 * @param array $tabledata einzugebende Daten
	 * @return boolean Liefert bei Erfolg true, sonst Exception
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 * @uses CMSException
	 */	

	public function commentEntry($id, array $tabledata)
	{
		if (!is_int($id)) {
			throw new CMSException(array('msg_box' => 'wrong_param_int'), EXCEPTION_LIBARY_CODE);
		}

		if ($tabledata['content'] == "") {
			throw new CMSException(array('msg_box' => 'wrong_param_text'), EXCEPTION_LIBARY_CODE);
		}

		if ($this->_form_checked == false) {
			throw  new CMSException(array('msg_box' => 'wrong_param_int'), EXCEPTION_LIBARY_CODE);
		}

		//Formular-Check durchfuehren

		//ID darf nicht angegeben werden, Gefahr der Ueberschreibung
		$tabledata['ref_ID'] = $id;
		//Time muss beim Argument nicht angegeben werden, darum wird der Schluessel hier definiert.
		$tabledata['time'] = "NOW()";


		$sql['def'] = "INSERT INTO `$this->_tablename` ( ";
		$sql['val'] = ") VALUES (";
		$num = count($tabledata);


		$i = 1;
		foreach ($tabledata as $key => $value) {
			$sql['def'] .= "`{$this->_tablestruct[$key]}`";

			//Zur Sicherheit escapen
			if ($key == 'time') {
				$sql['val'] .= "NOW()";
			} else {
				$sql['val'] .= "'".$this->_mysql->escapeString($value)."'";
			}

			if ($i != $num) {
				$sql['def'] .= ", ";
				$sql['val'] .= ", ";
			}
			$i++;
		}
		
		if (!key_exists('time', $tabledata)) {
			$sql['def'] .= ", `{$this->_tablestruct['time']}`";
			$sql['val'] .= ", NOW()";
		}

		$sql['val'] .= ")";
		$query = join("", $sql);

		$this->_mysql->query($query);
		return true;
	}


	/**
	 * Ueberprueft die Eintrage und fuegt sie in die MySQL-Tabelle per Update-Befehl ein.
	 *
	 * @param array $tabledata einzugebende Daten
	 * @param array $tablestddata Standartdaten aus dem Formular, welche nicht gebraucht werden duerfen.
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 * @uses CMSException
	 */

	public function editEntry($tabledata)
	{
		if ($this->_form_checked == false) {
			throw  new CMSException(array('msg_box' => 'no_check_valid'), EXCEPTION_LIBARY_CODE);
		}


		if ($tabledata['content'] == "") {
			throw new CMSException(array('msg_box' => 'wrong_param_text'), EXCEPTION_LIBARY_CODE);
		}


		if ($tabledata['ID'] == ""  || !is_numeric($tabledata['ID'])) {
			throw new CMSException(array('msg_box' => 'wrong_param_int'), EXCEPTION_LIBARY_CODE);
		}

		$sql = "UPDATE `$this->_tablename` SET  ";
		//$num = count($tabledata);

		$i = 1;
		foreach ($tabledata as $key => $value) {
			//ID wird in WHERE-Klausel verwendet
			if ($key != 'ID' && $key != 'time') {
				if ($i != 1) {
					$sql .= ", ";
				}
				$sql .= "`{$this->_tablestruct[$key]}`";

				//Zur Sicherheit escapen
				$sql .= " = '".$this->_mysql->escapeString($value)."'";

				$i++;
			}

		}

		$sql .= " WHERE `{$this->_tablestruct['ID']}` = '{$tabledata['ID']}' LIMIT 1";

		$this->_mysql->query($sql);
		return true;

	}



	/**
	 * Liefert ein Tabelleneintrag mit der angegebenen ID und formatiert (wenn angegeben) die Zeit.
	 *
	 * @param int $id ID des Eintrags
	 * @param string $timeformat Zeitformat nach Mysql
	 * @param boolean $comments Kommentare auch senden
	 * @return array Eintrag, bei Fehler false
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 * @uses CMSException
	 */

	public function getEntry($id, $timeformat = "", $comments = true)
	{
		$msg_array = array();

		if (!is_numeric($id)) {
			throw new CMSException(array('msg_box' => 'wrong_param_num'), EXCEPTION_LIBARY_CODE);
		}

		if(!is_string($timeformat)) {
			throw new CMSException(array('msg_box' => 'wrong_param_string'), EXCEPTION_LIBARY_CODE);
		}

		/*Haupt-Nachricht*/
		$sql = "SELECT * FROM `{$this->_tablename}` WHERE `{$this->_tablestruct['ID']}` = '$id' LIMIT 1";
		$this->_mysql->query($sql);

		$msg_array = $this->_mysql->fetcharray('assoc');

		/*Kommentare*/
		if ($comments == true) {
			$this->_mysql->query("SELECT * FROM {$this->_tablename} WHERE `{$this->_tablestruct['ref_ID']}` = '$id' ORDER BY `{$this->_tablestruct['time']}` ASC");
			$this->_mysql->saverecords('assoc');
			$msg_array['comments'] = $this->_mysql->get_records();
		}


		/* Wenn angegeben wird die Zeit formatiert */
		if ($timeformat && is_string($timeformat) && isset($this->_tablestruct['time'])) {
			$msg_array[$this->_tablestruct['time']] = $this->_formatTime($msg_array[$this->_tablestruct['time']], $timeformat);

			if ($comments == true) {
				foreach ($msg_array['comments'] as $key => $value) {
					$msg_array['comments'][$key][$this->_tablestruct['time']] = $this->_formatTime($value[$this->_tablestruct['time']], $timeformat);
				}
			}
		}
		return $msg_array;

	}



	/**
	 * Liefert die Tabelleneintraege im angegebenen Bereich (wenn moeglich) zeitlich geordnet und (wenn angegeben)
	 * zeitformatiert zurueck.
	 *
	 * @param int $entries_pp Eintraege pro Seite
	 * @param int $page Seite (startet bei 1)
	 * @param string $order Reihenfolge der Haupteinträge DESC|ASC
	 * @param string $corder Reihenfolge der Kommentare DESC|ASC
	 * @param string $timeformat Zeitformat nach Mysql
	 * @return array Eintraege, bei Fehler false
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 * @uses CMSException
	 */

	public function getEntries($entries_pp, $page, $order = 'DESC', $corder = 'ASC', $timeformat = "")
	{
		$msg_array = array();	//Array mit den Nachrichten
		$strorder = array();	//Array mit den Anordnungsbedingungen-Strings
		$num = 0; //Anzahl Eintraege


		if (!is_numeric($entries_pp) && !is_numeric($page)) {
			throw new CMSException(array('msg_box' => 'wrong_param_num'), EXCEPTION_LIBARY_CODE);
		}


		//Ordnungsbedingung fuer Mysql-Query
		if ($order != 'ASC' && $order != 'DESC' && $order != "") {
			throw new CMSException(array('msg_box' => 'wrong_param_invalid'), EXCEPTION_LIBARY_CODE);

		} elseif ($corder != 'ASC' && $corder != 'DESC' && $corder != "") {
			throw new CMSException(array('msg_box' => 'wrong_param_invalid'), EXCEPTION_LIBARY_CODE);

		} elseif (isset($this->_tablestruct['time']) && !empty($this->_tablestruct['time']) && $order != "" && $corder != "") {
			//Ordnungsbedingungen-Strings in top-nachrichten und kommentaren
			$strorder['norm'] = "ORDER BY `{$this->_tablestruct['time']}` $order";
			$strorder['comm'] = "ORDER BY `{$this->_tablestruct['time']}` $corder";

		} else {
			$strorder['norm'] = "";
			$strorder['comm'] = "";

		}

		/* Startpunkt der Mysql-Einträge im Query */
		$start = ($page-1)*$entries_pp;

		/* Bedingungen für Haupteinträge */
		if (isset($this->_tablestruct['ref_ID'])) {
			$condition = "WHERE `{$this->_tablestruct['ref_ID']}` = '0'";
		} else {
			/* Keine Haupteinträge -> Keine Kommentare. Alle Einträge werden gleich behandelt*/
			$condition = "";
		}

		/* Haupteinträge auslesen */
		$sql = "SELECT * FROM `{$this->_tablename}` $condition {$strorder['norm']} LIMIT $start, $entries_pp";
		$this->_mysql->query($sql);
		$this->_mysql->saverecords('assoc');
		$msg_array = $this->_mysql->get_records();

		//Eintraege zahlen
		$num += count($msg_array);

		//Zeit formatieren und Kommentare holen.
		foreach ($msg_array as $key => $value) {

			if ($condition != "") {//ref_ID ist demnach gesetzt.

				$this->_mysql->query("SELECT * FROM {$this->_tablename} WHERE `{$this->_tablestruct['ref_ID']}` = '{$value[$this->_tablestruct['ID']]}' {$strorder['comm']}");
				$this->_mysql->saverecords('assoc');
				$value['comments'] = $this->_mysql->get_records();

				//Eintrage zaehlen
				$num += count($value['comments']);

			}

			//Zeit formatieren
			if ($timeformat && is_string($timeformat) && isset($this->_tablestruct['time'])) {
				$value[$this->_tablestruct['time']] = $this->_formatTime($value[$this->_tablestruct['time']], $timeformat);

				if ($condition != "") {//ref_ID ist also gesetzt.

					foreach ($value['comments'] as $key2 => $cvalue) {
						$value['comments'][$key2][$this->_tablestruct['time']] = $this->_formatTime($cvalue[$this->_tablestruct['time']], $timeformat);

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
	 * Loescht einen Eintrag aus der Datenbank inkl. alle Kommentaren
	 *
	 * @param int $id
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 * @uses CMSException
	 */

	public function delEntry($id)
	{
		if (!is_int($id)) {
			throw new CMSException(array('msg_box' => 'wrong_param_invalid'), EXCEPTION_LIBARY_CODE);
		}

		if (array_key_exists('ref_ID', $this->_tablestruct)) {
			$query = "SELECT `{$this->_tablestruct['ID']}` FROM `{$this->_tablename}` "
			."WHERE `{$this->_tablestruct['ref_ID']}` = '$id'";
			$this->_mysql->query($query);
			$this->_mysql->saverecords('assoc');
			$id_arr = $this->_mysql->get_records();

			/* Kommentare löschen */
			for ($i = 0; $i < count($id_arr); $i++) {
				$query = "DELETE FROM `{$this->_tablename}` "
				."WHERE `{$this->_tablestruct['ID']}` = '{$id_arr[$i][$this->_tablestruct['ID']]}' LIMIT 1";
				//$this->_mysql->query($query);
			}
		}


		$query = "DELETE FROM `{$this->_tablename}` WHERE `{$this->_tablestruct['ID']}` = '$id' LIMIT 1";

		$this->_mysql->query($query);
	}

	/**
	 * Gibt an, ob die angegeben ID ein Kommentar ist oder nicht
	 *
	 * @param int $id
	 * @return boolean 
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 * @uses CMSException
	 */

	public function is_comment($id)
	{
		if (!is_numeric($id)) {
			throw new CMSException(array('msg_box' => 'wrong_param_invalid'), EXCEPTION_LIBARY_CODE);
		}

		$this->_mysql->query("SELECT `{$this->_tablestruct['ref_ID']}` FROM `{$this->_tablename}` "
		."WHERE `{$this->_tablestruct['ID']}` = '$id' LIMIT 1");
		$this->_mysql->saverecords('assoc');
		$data = $this->_mysql->get_records();

		if ($data[$this->_tablestruct['ref_ID']] == 0) {
			return false;	//Kein Kommentar, sondern Haupteintrag
		} else {
			return true;
		}

	}

	/**
	 * Kontrolliert die Daten auf Standarteintraege und leere Strings; ebenso wird die Mail-Adresse und die Homepage kontrolliert.
	 * Zurueck kommt ein Array mit den Schluesseln vom $tabledata mit folgenden Angaben:
	 * true -> angaben richtig
	 * false -> angaben leer oder Standartwert
	 * 'invalid' -> ungueltig (nur bei email)
	 * string -> korrigierter wert (nur bei hp)
	 *
	 * @param array $tabledata
	 * @param array $stddata Standartangaben
	 * @return array $arr_rtn Ergebnis
	 * @uses Formularcheck Plausibilitätsüberprüfung von Formularen
	 * @uses CMSException
	 */

	public function formCheck($tabledata, $stddata)
	{
		$arr_rtn = array();
		//$ok = true;

		if (!is_array($tabledata)) {
			throw  new CMSException(array('msg_box' => 'wrong_param_array'), EXCEPTION_LIBARY_CODE, __FUNCTION__);
		}

		$check_arr = $this->_formCheck->field_check_arr($tabledata, $stddata);

		foreach ($check_arr as $key => $value) {

			if ($value === true) {
				$arr_rtn[$key] = MSGBOX_FORMCHECK_OK;
			} else {
				$arr_rtn[$key] = MSGBOX_FORMCHECK_NONE;
			}

			//Mail und Hp noch seperat testen
			if ($key == 'email' && $value === true && $this->_formCheck->mailcheck($tabledata[$key]) > 0) {
				$arr_rtn[$key] = MSGBOX_FORMCHECK_INVALID;

			} elseif ($key == 'hp' && $value === true) {

				$new_hp= $this->_formCheck->hpcheck($tabledata[$key]);
				$arr_rtn[$key] = $new_hp;

				//Bei Standartwert (oder leer :-)) wird bei 'hp' ein leer-String zurueckgegeben
			} elseif ($key == 'hp' && $value === false) {
				$arr_rtn[$key] = "";
			}


		}

		$this->_form_checked = true;

		return $arr_rtn;
	}



	/**
	 * Formatiert die angegeben Zeit mittels Mysql
	 *
	 * @param string $time
	 * @param string $timeformat
	 * @return string formatierte Zeit, bei Fehler false
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 * @uses CMSException
	 */

	private function _formatTime($time, $timeformat)
	{

		if (is_string($timeformat) && !empty($timeformat) && is_string($time)&& !empty($time)) {
			$this->_mysql->query("SELECT DATE_FORMAT('$time', '$timeformat') as time");
			$arr = $this->_mysql->fetcharray('assoc');
			return $arr['time'];
		} else {
			throw new CMSException(array('msg_box' => 'wrong_param_time'), EXCEPTION_LIBARY_CODE);
		}


	}


	/**
	 * Fuellt die Eigenschaft _tablestruct mit den Werten, welche an den Konstruktor weitergegeben wurden.
	 * Wichtige Angaben sind ID, time und content als Schluessel. $this->_tablestruct enthaelt danach ein Array, desen Werte
	 * die Indizes der Mysql-Tabelle sind.
	 *
	 * @param array $tablestruct Array vom Konstruktor
	 * @return boolean Erfolg
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 */

	private function _fillStruct($tablestruct)
	{
		//Mindest ID, content und time muessen vorhanden sein
		if (key_exists("ID", $tablestruct) && key_exists("content", $tablestruct) && key_exists("time", $tablestruct)) {

			foreach ($tablestruct as $key => $value) {
				$tablestruct[$key] = $this->_mysql->escapeString($value);
			}
			
			
			//So werden die unnoetig vordefinierten Schluesseln im $_tablestruct ueberschrieben,  z.B. time
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
	 * @uses Mysql Für die Verbindung zur Mysql-DB
	 */

	private function _checkTable($tablestruct)
	{
		$table_infos = array();
		$colums_names = array();
		$this->_mysql->query("SHOW COLUMNS FROM `$this->_tablename`");
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
