<?php

/**
 * @author David D�ster
 * @package JClubCMS
 * File: messageboxes.class.php
 * Classes: messageboxes
 * Requieres: PHP5
 */

/* Notitz: Hinzuf�gen und �hnliches geht in etwa so:
- Es wird ne Funktion Add-entry oder add-comment aufgerufen
- Die Funktion pr�ft die Korrektheit, und gibt bei Erfolg den Fehlercode 0 aus, und speichert die Daten.
- Bei Fehler gibt sie einen Fehlercode aus, anhand der gefunden Fehler.
- Die Module fragen anschliessend zur�ck, welche Fehler es gibt (show_failer).
- Das Modul gibt die Fehler zur�ck.

Ungef�hre Idee, neuster Stand, nix so wie ist:
Klasse bekommt entweder ein Array, oder die anzahl der zur�ckgegebenen werten.
Erstellen des Array's mit den werten, oder �berpr�fen anhand bekannter kriterien (default, email, webpage).

Problem: Woher weiss die Klasse, welcher Datensatz des Arrays zu welcher Zelle in der DB-Tabelle geh�rt?
Wie �berpr�fe ich, ob alle n�tigen werte, die von der MySQL-Tabelle n�tig sind, angegeben wurden?

*/

require_once(ADMIN_DIR.'lib/captcha.class.php');
class messageboxes {

	private $table_name = "";
	private $button_click = "";
	private $title = "";
	private $content = "";
	private $name = "";
	private $email = "";
	private $hp = "";
	private $navigation_id = "";
	private $captcha_word = "";
/**
 * Klassenkonstruktor
 * Alle Variablen ausser des Tabellennamens sind optional, d.H werden erst f�r einen Comment oder
 * einen neuen Eintrag gebraucht.
 *
 * @param string $table_name Name der Datenbank-Tabelle worauf zugegriffen werden soll
 * @param string $button_click Senden-Button
 * @param string $title Titel des Content
 * @param string $content Inhalt des Textes
 * @param string $name Name des Absenders
 * @param string $email EMail-Adresse des Absenders
 * @param string $hp Homepage des Absenders
 * @param int $navigation_id ID der Applikation (z.B. Navigations-ID des G�stebuchs)
 * @param string $captcha_word Eingegebenes Cpatcha-Wort.
 */

	public function __construct($table_name, $button_click="", $title = "", $content="", $name="", $email="", $hp="", $navigation_id = "", $captcha_word="") {
		$this->table_name = $table_name;
		$this->button_click = $button_click;
		$this->title = $title;
		$this->content = $conten;
		$this->name = $name;
		$this->email = $email;
		$this->hp = $hp;
		$this->navigation_id = $navigation_id;
		$this->captcha_word = $captcha_word;
	}


	public function add_comment ($entry_ID) {
		$failer_error = $this->mailcheck();
	}

	public function add_entry () {
		$failer_error = $this->mailcheck();
	}

	public function show_entry () {

	}
	private function mailcheck () {
		$failer_error = 0;
		$this->mailexplode();
		$failer_error += $this->is_name();
		$failer_error += $this->is_domain();
		$failer_error += $this->is_country();

		return $this->failer_error;
	}

		/**
	 * Der Mail-Exploder
	 *
	 * Teil die Mail f�r die einfachere Pr�fung in ihre Subsegmente auf
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
	 * Pr�ft einfach ob die Domain ihre Minimalwerte hat.
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
		return $failer_error;
	}
	/**
	 * Hier wird geschaut ob es ein korrektes Land ist.
	 * Die L�nderliste wird aus einem Text-File in ein Array abgespitzt
	 * und nachher wird aus diesem Array gepr�ft.
	 *
	 * Quelle der Domains sp�ter vieleicht oline.
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
	 * Der Domain-Name-Checker
	 *
	 * Pr�ft einfach ob die Domain ihre Minimalwerte hat.
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
		return $failer_error;
	}
}
?>