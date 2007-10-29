<?php
/**
 * @author David Daester
 * @package JClubCMS
 * @copyright JClub
 * @link http://www.jclub.ch
 * File: smilies.class.php
 * Classes: smilies
 * Reuqires: PHP5
 */

/**
 * Klasse fuer das Aulsenen der Smilies aus der DB, 
 * Ueberpruefung ob die Bilder noch vorhanden sind
 * und Retourgabe der Daten als Array.
 * 
 * Evnt. noch Administration der Smilies.
 */

class Smilies {
	/**
	 * Pfad zu den Smilies
	 *
	 * @var unknown_type
	 * @access private
	 */
	private $dir_smilies;
	
	
	/**
	 * Das Konstrukt dieser Klasse
	 * 
	 * @param string dir_smilies Pfad zu den Smilies
	 */
	public function __construct ($dir_smilies) {
		$this->dir_smilies = $dir_smilies;
	}
	
	/**
	 * Destruktor der Klasse.
	 *
	 */
	public function __destruct() {
		$this->dir_smilies = null;
	}
	
	/**
	 * Erstellt das Array der Smilies.
	 *
	 * Grober Ablauf (zur Nachkontrolle):
	 * 1. Auslesen der Tabelle(grupiert nach Bild)
	 * 2. Ueberpruefen ob das Smilie �berhaupt noch existiert (is_file), wenn nicht, auslassen
	 * 3. Rueckgabe des Arrays.
	 * 
	 * Aufbau des Arrays: Code, Filepath
	 * 
	 * @param resource $mysql_link Verbindung zur DB
	 * @return array Array der Smilies.
	 */
	public function create_smiliesarray ($mysql_link) {
		$query = "SELECT * FROM smilies GROUP BY smilies_file ORDER BY smilies_sign";
		$mysql_link->query($query);
		$smiliearray = array();
		$i = 0;
		while($smilies_data = $mysql_link->fetcharray()) {
			if (is_file($this->dir_smilies.$smilies_data["smilies_file"])) {
				$smiliearray[$i] = array('file'=>$this->dir_smilies.$smilies_data["smilies_file"], 'sign'=>$smilies_data["smilies_sign"]);
				$i++;
				
			} else {}
		}
		return $smiliearray;
	}
	
	/**
	 * Erstellt via RegEx die Smilies im Text und gibt sie retour.
	 * 
	 * Grober Ablauf (zur Nachkontrolle):
	 * 1. Auslesen der Smilies aus der Tabelle
	 * 2. Ueberpruefen ob das Smilie ueberhaupt noch existiert (is_file), wenn nicht, auslassen
	 * 3. RegEx der Texte
	 * 4. Rueckgabe des Textes. 
	 *
	 * @param string $text Der zu parsende Text
	 * @param object $mysql_link Verbindung zur DB
	 * @return string
	 */
	public function show_smilie ($text, $mysql_link) {
		$query = "SELECT * FROM smilies ORDER BY smilies_sign";
		$mysql_link->query($query);
		$return_text = $text;
		while ($smilies_data = $mysql_link->fetcharray()) {
			if (is_file($this->dir_smilies.$smilies_data["smilies_file"])) {
				$return_text = str_replace($smilies_data["smilies_sign"], '<img src="'.$this->dir_smilies.$smilies_data["smilies_file"].'" alt="'.$smilies_data["smilies_file"].'"></img>', $return_text);				
			} else {}
		}		
		return $return_text;
	}
}
?>
