<?php
/**
 * @author David Daester
 * @package JClubCMS
 * File: formular_check.class.php
 * Classes: Formularcheck
 * Requieres: PHP5
 */

class Formularcheck {

	private $mail = null;
	private $domain = null;
	private $country = null;
	private $name = null;
	private $failer_error = 0;

	public function __construct () {
		return 0;
	}
	/**
	 * Ueberprueft ob der angegebene String den nicht erlaubten default-Eintraegen 
	 * von den Forumlaren entspricht
	 *
	 * @param string $field
	 * @param string $not_allowed
	 * @return boolean
	 */

	public function field_check ($field, $not_allowed = NULL) {
		if ($field == "" || $field == $not_allowed) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Überprüft, ob das angegebene Array Leer-String oder default-Einträge hat
	 * (@see field_check)
	 *
	 * @param array $fields Zu überprüfende Felder
	 * @param array $unalloweds Default-Array
	 * @return array Fehlerarray
	 */

	public function field_check_arr(array $fields, array $unalloweds = array())
	{
		if (!is_array($fields) || !is_array($unalloweds)) {
			throw  new CMSException('Falsche Parameterangaben in Funktion '.__FUNCTION__.'. 1. oder 2. Parameter kein Array', EXCEPTION_LIBARY_CODE);
		}

		$arr_rtn = array();

		foreach ($fields as $key => $value) {

			if (array_key_exists($key, $unalloweds) == true) {
				$arr_rtn[$key] = $this->field_check($value, $unalloweds[$key]);
			} else {
				$arr_rtn[$key] = $this->field_check($value);
			}


		}

		return $arr_rtn;
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
	 * Wird aufgerufen, startet alle anderen Funktionen und gibt den Fehlercode zurueck.
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
	 * Der Mail-Exploder
	 *
	 * Teil die Mail fuer die einfachere Pruefung in ihre Subsegmente auf
	 */

	private function mailexplode() {
		$mailarray = explode('@', $this->mail);
		$this->name = $mailarray[0];
		if (key_exists(1, $mailarray)) {

			for ($i = strpos($mailarray[1], ".")+1; $i < strlen($mailarray[1]); $i++) {
				$this->country .= $mailarray[1][$i];
			}
			$domainarray = explode('.', $mailarray[1]);
			$this->domain = $domainarray[0];
		} else {
			$this->failer_error++;
		}
	}

	/**
	 * Der Domain-Name-Checker
	 *
	 * Prueft einfach ob die Domain ihre Minimalwerte hat.
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
	 * Prueft einfach ob die Domain ihre Minimalwerte hat.
	 */
	private function is_name () {
		$failer_error = 0;
		switch ($this->name) {
			case "":
				$failer_error = 2;
				break;
			case strlen($this->name) < 3:
				$failer_error = 2;
				break;
		}
		$this->failer_error+=$failer_error;
	}
	/**
	 * Hier wird geschaut ob es ein korrektes Land ist.
	 * Die Laenderliste wird aus einem Text-File in ein Array abgespitzt
	 * und nachher wird aus diesem Array geprueft.
	 *
	 * Quelle der Domains spaeter vieleicht oline.
	 */
	private function is_country () {
		if (!file_exists(USER_DIR."/config/country.txt")) {
			throw new CMSException('Datei mit Laenderendungen nicht gefunden', EXCEPTION_LIBARY_CODE);
		}
		$handle = fopen(USER_DIR."/config/country.txt", "r");
		$country_array = array();
		$i = 0;
		while (!feof($handle)) {
			$country = fgets($handle, 4096);
			$country = trim($country);
			$country_array[$i] = $country;
			$i++;
		}
		fclose ($handle);
		$failer_error = 4;
		$i--;
		while ($failer_error == 4 && $i >= 0) {
			if ($country_array[$i] == trim($this->country)) {
				$failer_error = 0;
			}
			$i--;
		}
		$this->failer_error+=$failer_error;
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