<?php
/** 
* File: mail.class.php
* Classes: mailcheck
* Requieres: PHP5
*
* Die Klasse ist zust�ndig zur �berpr�fung der EMail-Adresse auf ihre
* tauglichkeit, und auch zum versenden von Check-Mails im Mailformularen
*
* Funktionsbeschrieb:
* Soll das Mailchecking sowie das Mail-Versenden f�r die verschiedenen
* Modulen zentral Verwalten. Generell sollen 2 M�glichkeiten �ber diese Klasse
* erledigt werden:
** Tauglichkeitspr�fung der EMail f�r ein G�stebucheintrag
** MailVersand f�r Mailforumlare z.B. an G�stebuchuser's und an Members von JClub
*
*
* 
*/
class mail {

	private $mail = null;
	private $domain = null;
	private $country = null;
	private $name = null;
	private $failer_error = 0;

	/**
	 * Der Klassenkonstruktor
	 *
	 * @param string $mail Mailadresse
	 */
	public function __construct($mail) {
		$this->mail = $mail;
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
	 * 
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
		$this->failer_error+=$failer_error;
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
	 * Wird aufgerufen, startet alle anderen Funktionen und gibt den Fehlercode zur�ck.
	 *
	 * @return failer_error
	 */
	public function mailcheck () {
		$this->mailexplode();
		$this->is_name();
		$this->is_domain();
		$this->is_country();

		return $this->failer_error;
	}	
	
	/**
	 * Der Klassendestruktor
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