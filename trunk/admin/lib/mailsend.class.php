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
 * Klasse fuer den den ganzen Mail-Ablauf
 * 1. Phase
 * - Hash-Berechnung 
 * - Ablage in Datenbank
 * - Versand Kontrollmail
 * 2. Phase
 * - Auslese aus Datenbank
 * - Versand des Mails
 */
class Mailsend {
	private $_mail_reciver_name;
	private $_mail_reciver;
	private $_mail_sender_name;
	private $_mail_sender;
	private $_mail_titel;
	private $_mail_content;
	
	/**
	 * Das Konstrukt dieser Klasse
	 */
	public function __construct () {
		return 0;
	}
	/**
	 * Versendet den Link um die Mail auszulösen
	 *
	 * @param object $mysql_link MysqlObjekt
	 * @param string $mail_reciver_name Mailempängername (aus Datenbank)
	 * @param string $mail_reciver Mailempfänger (aus Datenbank)
	 * @param string $mail_sender_name Mailsendername (aus Formular)
	 * @param string $mail_sender Mailsenderadresse (aus Formular)
	 * @param string $mail_titel Subjekt des Mails (aus Formular)
	 * @param string $mail_content Inhalt des Mails (aus Formular)
	 * 
	 * @return boolean
	 */
	public function mail_send_link($mysql_link, $mail_reciver_name, $mail_reciver, $mail_sender_name, $mail_sender, $mail_titel, $mail_content) {
		
		$this->_mail_reciver_name = $mail_reciver_name;
		$this->_mail_reciver = $mail_reciver;
		$this->_mail_sender_name = $mail_sender_name;
		$this->_mail_sender = $mail_sender;
		$this->_mail_titel = $mail_titel;
		$this->_mail_content = $mail_content;
		
		$hash = $this->_mail_hash();
		$this->_mail2db($mysql_link, $hash);
		
                $header = 'From: Jclub.ch <mail_query@jclub.ch>'."\r\n"
                          .'X-Mailer: PHP/' . phpversion();
                $msg = "Um die Mail zu senden benutzen Sie bitte folgenden Link:\r\n"
                   ."http://www.jclub.ch/index.php?action=mail&hash=".$hash;
                $empfaenger = $this->_mail_sender;
                $betreff = 'Bestaetigung des Mail-Sendens';
                $failer = $this->_mail_send($empfaenger,$betreff,$msg,$header);
                return $failer;
	}

	/**
	 * Liefert dem Hash der Mail zurück um in die DB abzulegen
	 *
	 * @return string
	 */
	private function _mail_hash () {
		$hash = md5($this->_mail_reciver)
		      . md5($this->_mail_sender_name)
		      . md5($this->_mail_sender)
		      . md5($this->_mail_titel)
		      . md5($this->_mail_content)
		      . microtime();
		
		$hash = md5($hash);
		return $hash;
	}
	
	/**
	 * Füllt die Daten in die Tabelle ab, um später zu versenden.
	 *
	 * @param reference $mysql_link MySQL-Objekt
	 * @param string $mail_hash Hash des Mails
	 */
	private function _mail2db ($mysql_link, $mail_hash) {
		$reciver_name = $this->_mail_reciver_name;
		$reciver_email = $this->_mail_reciver;
		$sender_name = $this->_mail_sender_name;
		$sender_email = $this->_mail_sender;
		$subject = $this->_mail_titel;
		$content = $this->_mail_content;
		
		$insert_query = "INSERT INTO mailto (mailto_reciver_name, mailto_reciver_email, mailto_sender_name, mailto_sender_email, mailto_subject, mailto_content, mailto_hash, mailto_time) "
						."VALUES ('$reciver_name', '$reciver_email', '$sender_name', '$sender_email', '$subject', '$content', '$mail_hash', NOW())";
		$mysql_link->query($insert_query);
		
	}
	
	/**
	 * Startet das Senden des Links an den Empfänger bei gültigem Hash
	 *
	 * @param reference $mysql_link
	 * @param string $hash
	 * @return boolean
	 */
	public function mail_send_hash ($mysql_link, $hash) {
		$this->_db2mail($mysql_link, $hash);
		$header = $header = 'From: '.$this->_mail_sender_name.' <'.$this->_mail_sender.'>'."\r\n"
				. 'Content-Type: text/plain'."\r\n"
                          .'X-Mailer: PHP/'.phpversion();
		$msg = $this->_mail_content;
		$betreff = $this->_mail_titel;
		$empfaenger = $this->_mail_reciver_name.'<'.$this->_mail_reciver.'>';
		$mail = $this->_mail_send($empfaenger, $betreff, $msg, $header);
		if ($mail == true) {
			$this->_db2mail($mysql_link, $hash, true);
		}
		return $mail;
		
	}
	/**
	 * Liest aus der DB die Maildaten aus.
	 *
	 * @param reference $mysql_link MySQL Objekt
	 * @param string $hash Hash
	 */
	private function _db2mail($mysql_link, $hash, $delete = false) {
		if ($delete == false) {
			$select_query = "SELECT * FROM mailto WHERE mailto_hash = '$hash'";
			$mysql_link->query($select_query);
			$mailto_data = $mysql_link->fetcharray();
			$this->_mail_reciver_name = $mailto_data["mailto_reciver_name"];
			$this->_mail_reciver = $mailto_data["mailto_reciver_email"];
			$this->_mail_sender_name = $mailto_data["mailto_sender_name"];
			$this->_mail_sender = $mailto_data["mailto_sender_email"];
			$this->_mail_titel = $mailto_data["mailto_subject"];
			$this->_mail_content = $mailto_data["mailto_content"];	
		}
		else {
			$delete_query = "DELETE FROM mailto WHERE mailto_hash = '$hash'";
			$mysql_link->query($delete_query);
		}
	}
		/**
	 * Zustaendig fuer das Versenden von Mails
	 *
	 * @param string $reciver Empfänger
	 * @param string $subject Betreff
	 * @param string $message Nachricht
	 * @param string $header Headerdaten (Sender, Name, Mailer)
	 * 
	 * @return boolean
	 */
	private function _mail_send ($reciver, $subject, $message, $header) {
		$failer = mail($reciver, $subject, $message, $header);
		
		return $failer;
	}
	
	/**
	 * Klassendestruktor
	 *
	 * @return boolean
	 */
	public function __destruct () {
		$this->_mail_reciver = "";
		$this->_mail_sender_name = "";
		$this->_mail_sender = "";
		$this->_mail_titel = "";
		$this->_mail_content = "";
		return true;
	}
}
?>