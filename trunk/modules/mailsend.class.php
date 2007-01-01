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
 * Klasse f��r den den ganzen Mail-Ablauf
 * 1. Phase
 * - Hash-Berechnung 
 * - Ablage in Datenbank
 * - Versand Kontrollmail
 * 2. Phase
 * - Auslese aus Datenbank
 * - Versand des Mails
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
	 */
	public function __construct () {
		return 0;
	}
	/**
	 * Versendet den Link um die Mail auszul�sen
	 *
	 * @param object $mysql_link MysqlObjekt
	 * @param string $mail_reciver_name Mailemp�ngername (aus Datenbank)
	 * @param string $mail_reciver Mailempf�nger (aus Datenbank)
	 * @param string $mail_sender_name Mailsendername (aus Formular)
	 * @param string $mail_sender Mailsenderadresse (aus Formular)
	 * @param string $mail_titel Subjekt des Mails (aus Formular)
	 * @param string $mail_content Inhalt des Mails (aus Formular)
	 * 
	 * @return boolean
	 */
	public function mail_send_link($mysql_link, $mail_reciver_name, $mail_reciver, $mail_sender_name, $mail_sender, $mail_titel, $mail_content) {
		
		$this->mail_reciver_name = $mail_reciver_name;
		$this->mail_reciver = $mail_reciver;
		$this->mail_sender_name = $mail_sender_name;
		$this->mail_sender = $mail_sender;
		$this->mail_titel = $mail_titel;
		$this->mail_content = $mail_content;
		
		$hash = $this->mail_hash();
		$this->mail2db($mysql_link, $hash);
		
                $header = 'From: Jclub.ch <mail_query@jclub.ch>'."\r\n"
                          .'X-Mailer: PHP/' . phpversion();
                $msg = "Um die Mail zu senden benutzen Sie bitte folgenden Link:\r\n"
                   ."http://www.jclub.ch/index.php?mail=".$hash;
                $empfaenger = $this->mail_sender;
                $betreff = 'Best�tigung des Mail-Sendens';
                $failer = $this->mail_send($empfaenger,$betreff,$msg,$header);
                return $failer;
	}

	/**
	 * Liefert dem Hash der Mail zur�ck um in die DB abzulegen
	 *
	 * @return string
	 */
	private function mail_hash () {
		$hash = md5($this->mail_reciver)
		      . md5($this->mail_sender_name)
		      . md5($this->mail_sender)
		      . md5($this->mail_titel)
		      . md5($this->mail_content)
		      . microtime();
		
		$hash = md5($hash);
		return $hash;
	}
	
	/**
	 * F�llt die Daten in die Tabelle ab, um sp�ter zu versenden.
	 *
	 * @param reference $mysql_link MySQL-Objekt
	 * @param string $mail_hash Hash des Mails
	 */
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
	
	/**
	 * Startet das senden des Links an den Empf�nger bei g�ltigem Hash
	 *
	 * @param reference $mysql_link
	 * @param string $hash
	 * @return boolean
	 */
	public function mail_send_hash ($mysql_link, $hash) {
		$this->db2mail($mysql_link, $hash);
		$header = $header = 'From: '.$this->mail_sender_name.' <'.$this->mail_sender.'>'."\r\n"
				. 'Content-Type: text/plain'."\r\n"
                          .'X-Mailer: PHP/'.phpversion();
		$msg = $this->mail_content;
		$betreff = $this->mail_titel;
		$empfaenger = $this->mail_sender_name.'<'.$this->mail_sender.'>';
		$mail = $this->mail_send($empfaenger, $betreff, $msg, $header);
		if ($mail == true) {
			$this->db2mail($mysql_link, $hash, true);
		}
		return $mail;
		
	}
	/**
	 * Liest aus der DB die Maildaten aus.
	 *
	 * @param reference $mysql_link MySQL Objekt
	 * @param string $hash Hash
	 */
	private function db2mail($mysql_link, $hash, $delete = false) {
		if ($delete == false) {
			$select_query = "SELECT * FROM mailto WHERE mailto_hash = '$hash'";
			$mysql_link->query($select_query);
			$mailto_data = $mysql_link->fetcharray();
			$this->mail_reciver_name = $mailto_data["mailto_reciver_name"];
			$this->mail_reciver = $mailto_data["mailto_reciver_email"];
			$this->mail_sender_name = $mailto_data["mailto_sender_name"];
			$this->mail_sender = $mailto_data["mailto_sender_email"];
			$this->mail_titel = $mailto_data["mailto_subject"];
			$this->mail_content = $mailto_data["mailto_content"];	
		}
		else {
			$delete_query = "DELETE FROM mailto WHERE mailto_hash = $hash";
			$mysql_link->query($delete_query);
		}
	}
		/**
	 * Zust�ndig f�r das Versenden von Mails
	 *
	 * @param string $reciver Empf�nger
	 * @param string $subject Betreff
	 * @param string $message Nachricht
	 * @param string $header Headerdaten (Sender, Name, Mailer)
	 * 
	 * @return boolean
	 */
	private function mail_send ($reciver, $subject, $message, $header) {
		$failer = mail($reciver, $subject, $message, $header);
		
		return $failer;
	}
	
	/**
	 * Klassendestruktor
	 *
	 * @return boolean
	 */
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