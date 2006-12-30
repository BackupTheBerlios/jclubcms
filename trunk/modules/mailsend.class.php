<?php
/** 
 * @author David Däster
 * @package JClubCMS
 * File: mailsend.class.php
 * Classes: mailsend
 * Requieres: PHP5
 *
 * 
 */

/**
 * Klasse für den den ganzen Mail-Ablauf
 * - Versand
 * - Hash-Berechnung
 * - Bestätigungsmail
 */

class mailsend {
	private $mail_reciver;
	private $mail_sender_name;
	private $mail_sender;
	private $mail_titel;
	private $mail_content;
	
	/**
	 * Das Konstrukt dieser Klasse
	 *
	 * @param string $mail_reciver
	 * @param string $mail_sender_name
	 * @param string $mail_sender
	 * @param string $mail_titel
	 * @param string $mail_content
	 */
	public function __construct ($mail_reciver, $mail_sender_name, $mail_sender, $mail_titel, $mail_content) {
		$this->mail_reciver = $mail_reciver;
		$this->mail_sender_name = $mail_sender_name;
		$this->mail_sender = $mail_sender;
		$this->mail_titel = $mail_titel;
		$this->mail_content = $mail_content;
		return 0;
	}
	public function mail_send_hash () {
		$header = $header = "From: $this->mail_sender_name <$this->mail_sender>\r\n"
				. "Content-Type: text/plain\r\n"
				. "Content-Transfer-Encoding: 7bit\n";
		$msg = $this->mail_content;
		$betreff = $this->mail_titel;
		$this->mail_send($empfaenger, $betreff, $msg, $header);
		return 0;
	}
	/**
	 * Versendet den Link um die Mail auszulösen
	 *
	 * @param string $hash
	 */
	public function mail_send_link($hash) {
		$header = "From: JClub.ch <mail_query@jclub.ch>\r\n"
				. "Content-Type: text/plain\r\n"
				. "Content-Transfer-Encoding: 7bit\n";
		$msg = "Um die Mail zu senden benutzen Sie bitte folgenden Link:\r\n"
             ."http://www.jclub.ch/index.php?mail=".$hash;
		$empfaenger = utf8_encode($this->mail_sender_name." <".$this->mail_sender.">");
		$betreff = utf8_encode("Bestätigung des Mail-Sendens");
		$this->mail_send($empfaenger,$betreff,$msg,$header);
		return 0;
	}
	/**
	 * Zuständig für das Versenden von Mails
	 *
	 * @param string $reciver
	 * @param string $subject
	 * @param string $message
	 * @param string $header
	 */
	private function mail_send ($reciver, $subject, $message, $header) {
		mail($reciver, $subject, $message, $header);
		return 0;
	}
	/**
	 * Liefert dem Hash der Mail zurück um in die DB abzulegen
	 *
	 * @return hash
	 */
	public function mail_hash () {
		/*Jeder einzelne Wert wird gehasht mit der MicroTime um je eintrag einen
      Eindeutigen Hash zu erhalten*/
      $hash = md5($this->mail_reciver)
            . md5($this->mail_sender_name)
            . md5($this->mail_sender)
            . md5($this->mail_titel)
            . md5($this->mail_content)
            . microtime();

      $hash = md5($hash);

      return $hash;
	}
	public function __destruct () {
		$this->mail_reciver = "";
		$this->mail_sender_name = "";
		$this->mail_sender = "";
		$this->mail_titel = "";
		$this->mail_content = "";
		return 0;
	}
}
?>