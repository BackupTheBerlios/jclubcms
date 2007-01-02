<?php
/** 
 * @author David Däster
 * @package JClubCMS
 * File: formular_check.class.php
 * Classes: formularcheck
 * Requieres: PHP5
 */

class formular_check {
	
	private $mail = null;
	private $domain = null;
	private $country = null;
	private $name = null;
	private $failer_error = 0;
	
	public function __construct () {
		return 0;
	}
	/**
	 * Überprüft ob der angegebene String den nicht erlaubten default-Einträgen 
	 * von den Forumlaren entspricht
	 *
	 * @param string $field
	 * @param string $not_allowed
	 * @return boolean
	 */
	public function field_check ($field, $not_allowed = NULL) {
		if ($field == "" || $field==$not_allowed) {
			return false;
		}
		else {
			return true;
		}
	}
	/**
	 * Ersetzt http:// und ftp:// mit einem Leerzeichen, da die Templates diesen Aufruf machen
	 *
	 * @param string $hp
	 * @return string
	 */
	public function hpcheck ($hp) {
		$hp = str_replace("http://", "", $hp);
		$hp = str_replace("ftp://", "", $hp);
		return $hp;
	}
	/**
	 * Der Mail-Exploder
	 *
	 * Teil die Mail für die einfachere Prüfung in ihre Subsegmente auf
	 */
	private function mailexplode() {
		$mailarray = explode('@', $this->mail);
		$this->name = $mailarray[0];
		for ($i = strpos($mailarray[1], ".")+1; $i <= strlen($mailarray[1]); $i++) {
			$this->country .= $mailarray[1][$i];
		}
		$domainarray = explode('.', $mailarray[1]);
		$this->domain = $domainarray[0];
	}
	/**
	 * Der Domain-Name-Checker
	 *
	 * Prüft einfach ob die Domain ihre Minimalwerte hat.
	 */
	private function is_domain () {
		$failer_error = 0;
		switch ($this->domain) {
			case "":
				$failer_error = 1;
				break;
			case strlen($this->domain) < 3:
				$failer_error = 1;
				break;
		}
		$this->failer_error+=$failer_error;
	}
	/**
	 * Der Domain-Name-Checker
	 * 
	 * Prüft einfach ob die Domain ihre Minimalwerte hat.
	 */
	private function is_name () {
		$failer_error = 0;
		switch ($this->name) {
			case "":
				$failer_error = 1;
				break;
			case strlen($this->name) < 3:
				$failer_error = 1;
				break;
		}
		$this->failer_error+=$failer_error;
	}
	/**
	 * Hier wird geschaut ob es ein korrektes Land ist.
	 * Die Länderliste wird aus einem Text-File in ein Array abgespitzt
	 * und nachher wird aus diesem Array geprüft.
	 *
	 * Quelle der Domains später vieleicht oline.
	 */
	private function is_country () {
		$handle = fopen("./config/country.txt", "r");
		$country_array = array();
		$i = 0;
		while (!feof($handle)) {
			$country = fgets($handle, 4096);
			$country = trim($country);
			$country_array[$i] = $country;
			$i++;
		}
		fclose ($handle);
		$failer_error = 1;
		$i--;
		while ($failer_error == 1 && $i >= 0) {
			if ($country_array[$i] == trim($this->country)) {
				$failer_error = 0;
			}
			$i--;
		}
		$this->failer_error+=$failer_error;
	}
	/**
	 * Wird aufgerufen, startet alle anderen Funktionen und gibt den Fehlercode zurück.
	 *
	 * @return integer
	 */
	public function mailcheck ($mail) {
		$this->mail = $mail;
		$this->mailexplode();
		$this->is_name();
		$this->is_domain();
		$this->is_country();

		return $this->failer_error;
	}	
	
	/**
	 * Klassendestruktor
	 *
	 */
	public function __destruct() {
		$this->mail = null;
		$this->name = null;
		$this->domain = null;
		$this->country = null;
		$this->failer_error = null;
	}
}
?>