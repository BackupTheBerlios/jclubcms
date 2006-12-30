<?php
/** 
 * @author David D�ster
 * @package JClubCMS
 * File: mailsend.class.php
 * Classes: mailsend
 * Requieres: PHP5
 *
 * 
 */

/**
 * Klasse f�r den den ganzen Mail-Ablauf
 * - Versand
 * - Hash-Berechnung
 * - Best�tigungsmail
 */

class mailsend {
	private $mail_reciver_name;
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
	public function __construct ($mail_reciver_name, $mail_reciver, $mail_sender_name, $mail_sender, $mail_titel, $mail_content) {
		$this->mail_reciver_name = $mail_reciver_name;
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
	 * Versendet den Link um die Mail auszul�sen
	 *
	 * @param object $mysql_link MysqlLink
	 */
	public function mail_send_link($mysql_link) {
		$hash = $this->mail_hash();
		$this->mail2db($mysql_link, $hash);
		
                $header = 'From: Jclub.ch <mail_query@jclub.ch>'."\r\n"
                          .'X-Mailer: PHP/' . phpversion();
                $msg = "Um die Mail zu senden benutzen Sie bitte folgenden Link:\r\n"
                   ."http://www.jclub.ch/index.php?mail=".$hash;
                //$empfaenger = utf8_encode($this->mail_sender_name." <".$this->mail_sender.">");
                //$betreff = utf8_encode("Bestätigung des Mail-Sendens");
                $empfaenger = $this->mail_sender;
                $betreff = 'Bestätigung des Mail-Sendens';
                $failer = $this->mail_send($empfaenger,$betreff,$msg,$header);
                return $failer;
		
	}
	/**
	 * Zust�ndig f�r das Versenden von Mails
	 *
	 * @param string $reciver
	 * @param string $subject
	 * @param string $message
	 * @param string $header
	 */
	private function mail_send ($reciver, $subject, $message, $header) {
		$failer = mail($reciver, $subject, $message, $header);
		
		return $failer;
	}
	/**
	 * Liefert dem Hash der Mail zur�ck um in die DB abzulegen
	 *
	 * @return hash
	 */
	private function mail_hash () {
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
	private function mail2db ($mysql_link, $mail_hash) {
		$reciver_name = $this->mail_reciver_name;
		$reciver_email = $this->mail_reciver;
		$sender_name = $this->mail_sender_name;
		$sender_email = $this->mail_sender;
		$subject = $this->mail_titel;
		$content = $this->mail_content;
		
		$insert_query = "INSERT INTO mailto (mailto_reciver_name, mailto_reciver_email, mailto_sender_name, mailto_sender_email, mailto_subject, mailto_content, mailto_hash, mailto_time) "
						."VALUES ('$reciver_name', '$reciver_email', '$sender_name', '$sender_email', '$subject', '$content', '$mail_hash', NOW())";
		$mysql_link->query($insert_query);
		
	}
	public function __destruct () {
		$this->mail_reciver = "";
		$this->mail_sender_name = "";
		$this->mail_sender = "";
		$this->mail_titel = "";
		$this->mail_content = "";
		return true;
	}
}
?>