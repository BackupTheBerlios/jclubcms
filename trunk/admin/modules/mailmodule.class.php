<?php
/**
 * @package JClubCMS
 * @author Simon Däster
 * File: mailmodule.class.php
 * Classes: Mailmodule
 * Requieres: PHP5
 *
 * Dieses Modul ist für das Mailforumular zum Versenden des Bestätigungsmail verantwortlich sowie 
 * für das Versenden des angegebenen Mails nach der erfolgreichen Bestätigung.
 *
 */

require_once ADMIN_DIR.'lib/module.interface.php';
require_once ADMIN_DIR.'lib/captcha.class.php';
require_once ADMIN_DIR.'lib/formularcheck.class.php';
require_once ADMIN_DIR.'lib/mailsend.class.php';

class Mailmodule implements Module
{
	/**
	 * Smarty-Objekt
	 *
	 * @var Smarty
	 */
	private $_smarty;

	/**
	 * Mysql-Objekt
	 *
	 * @var Mysql
	 */
	private $_mysql;

	/**
	 * Captcha-Objekt
	 *
	 * @var Captcha
	 */
	private $_captcha;

	/**
	 * Session-Code für Captcha
	 *
	 * @var string
	 */
	private $_sessioncode;
	/**
	 * Templatefile
	 *
	 * @var string
	 */
	private $_tplfile = 'mailform.tpl';


	/**
	 * GET, POST, COOKIE-Daten
	 *
	 * @var array
	 */
	private $_gpc = array();

	/**
	 * Daten aus den Config-Dateien
	 *
	 * @var array
	 */
	private $_configvars = array();
	
	/**
	 * Daten der Tabellen für Emailversand
	 *
	 * @var array
	 */
	private $mail_tbl = array();

	/**
	 * Aufbau der Klasse
	 *
	 * @param Smarty $smarty
	 * @param Mysql $mysql
	 */
	public function __construct($mysql, $smarty)
	{
		$this->_smarty = $smarty;
		$this->_mysql = $mysql;
	}

	/**
	 * Start des Moduls
	 *
	 * @param array $gpc
	 */
	public function action($gpc)
	{
		$this->_gpc = $gpc;

		//Daten laden
		$this->_smarty->config_load('textes.de.conf', 'Mail');
		$this->_configvars['Mail'] = $this->_smarty->get_config_vars();
		$this->_smarty->config_load('textes.de.conf', 'Form_Error');
		$this->_configvars['Error'] = $this->_smarty->get_config_vars();

		if (key_exists('hash', $gpc['GET']) && is_string($gpc['GET']['hash'])) {
			$this->_truemail_send($gpc['GET']['hash']);
		} elseif (key_exists('nav_id', $gpc['GET']) && is_numeric($gpc['GET']['nav_id'])) {
			$this->_checkmail_send($gpc['GET']['nav_id']);
		} else {
			throw new CMSException('Die Parameternangaben sind ungültig. Bitte geben Sie richtige Parameter an oder lassen Sie es', EXCEPTION_MODULE_CODE);
		}

	}

	/**
	 * Rückgabe der Templatedatei.
	 *
	 * @return string Templatedatei
	 */
	public function gettplfile()
	{
		return $this->_tplfile;
	}

	/**
	 * Schickt das Kontrollmail an den Sender, um sicherzugehen, dass die Sender-Adresse wirklich existiert
	 *
	 * @param int $mod_navID Nav-ID des Moduls
	 */

	private function _checkmail_send($mod_navID)
	{
		$mail_vars = $this->_configvars['Mail'];

		/* nav_id angegeben? */
		if (!key_exists('nav_id', $this->_gpc['GET'])) {
			throw new CMSException('Parameter `nav_id` nicht angegeben', EXCEPTION_MODULE_CODE, 'Parameter fehlt');
		}


		/* darf modul mit nav_id mail senden? */
		if ($this->_get_tabledata($mod_navID) == false) {
			throw new CMSException('Angegebenes Modul unterstützt kein Mailversand', EXCEPTION_MODULE_CODE, 'Keine Mailunterstüzung');
		}


		if ($this->_check_mailtable() == false) {
			throw new CMSException('Angegebene Tabelle oder Tabellenstruktur nicht vorhanden', EXCEPTION_MODULE_CODE, 'Keine passende Tabelle');
		}



		if (isset($this->_gpc['POST']['btn_send']) && $this->_gpc['POST']['btn_send'] == 'Senden') {
			/*Formular wurde gesendet */

			//Formular-Kontrolle
			if ($this->_gpc['POST']['entry_id'] != $this->_gpc['GET']['entry_id']) {
				throw new CMSException("Sie benutzen das falsche Formular für diese Mailadresse", EXCEPTION_MODULE_CODE, 'Datenkollision');
			}

			//Benutzung einfacher Variablen
			$title = $this->_gpc['POST']['title'];
			$content = $this->_gpc['POST']['content'];
			$name = $this->_gpc['POST']['name'];
			$email = $this->_gpc['POST']['email'];
			$entry_id = $this->_gpc['POST']['entry_id'];

			/* Formular kontrollieren */
			$answer = array();
			$success = $this->_check_form($answer);

			if ($success == true) {
				/*Mail schicken*/

				$navigation_id = $this->_smarty->get_template_vars('local_link');

				$this->_mysql->query("SELECT `{$this->mail_tbl['column_name']}`, `{$this->mail_tbl['column_email']}` FROM `{$this->mail_tbl['table']}` WHERE `{$this->mail_tbl['column_ID']}` = '$entry_id'");
				$mail_reciver = $this->_mysql->fetcharray('assoc');
				$mail_reciver_name = $mail_reciver[$this->mail_tbl['column_name']];
				$mail_reciver_email = $mail_reciver[$this->mail_tbl['column_email']];

				$mail = new Mailsend();
				$mailsend_controll = $mail->mail_send_link($this->_mysql, $mail_reciver_name, $mail_reciver_email, $name, $email, $title, $content);

				if ($mailsend_controll == true) {
					/* Erfolgreich gespeichert */
					$this->_send_feedback($mail_vars['saved_title'], $mail_vars['saved_content'], "?nav_id=$navigation_id", $mail_vars['send_link']);
				} else {
					/* Fehler bei der Speicherung */
					$this->_send_feedback($mail_vars['failer_save_title'], $mail_vars['failer_save_content'], "?nav_id=$navigation_id", $mail_vars['send_link']);
				}


			} else {
				/* Fehler im Formular */
				$this->_send_entryform(false, $answer);
			}


		} else {
			/* Kein Formular abgeschickt */

			//Captcha zurücksetzen
			if (key_exists('captcha_revoke', $this->_gpc['POST'])) {
				$first_form = false;
			} else {
				$first_form = true;
			}

			$this->_send_entryform($first_form);
		}


	}

	/**
	 * Sendet das geschriebene Mail, welches in der Datenbank gespeichert war.
	 *
	 * @param string $hash Hash vom Link
	 */
	private function _truemail_send($hash)
	{
		$mail_vars = $this->_configvars['Mail'];

		if (!key_exists('hash', $this->_gpc['GET'])) {
			throw new CMSException('Parameter `hash` nicht angegeben', EXCEPTION_MODULE_CODE, 'Parameter fehlt');
		}

		$mail_hash = $this->_gpc['GET']['hash'];
		$mail_send = new Mailsend();
		$controll = $mail_send->mail_send_hash($this->_mysql, $mail_hash);

		if ($controll == true) {
			$this->_send_feedback($mail_vars['saved_title'], $mail_vars['saved_content'], "", $mail_vars['send_link']);
		} else {
			$this->_send_feedback($mail_vars['failer_send_title'], $mail_vars['failer_send_content'], "", $mail_vars['send_link']);
		}
	}

	/**
	 * Ermittelt die Adress-Daten für die Tabelle des angegebenen Moduls. Existiert keine Mailunterstützung durch das
	 * angegebene Modul, wird false zurückgegeben.
	 *
	 * @param int $mod_navID
	 * @return array|false 
	 */
	private function _get_tabledata($mod_navID)
	{
		$this->_mysql->query("SELECT `admin_modules`.`modules_ID`, `admin_modules`.`modules_mail_support` FROM `admin_modules`, `admin_menu` WHERE
		 `admin_menu`.`menu_ID` = '$mod_navID' AND `admin_menu`.`menu_pagetyp` = 'mod' AND 
		 `admin_menu`.`menu_page` = `admin_modules`.`modules_ID` LIMIT 1");
		$mod_data = $this->_mysql->fetcharray('num');

		/* Keine Unterstützung? */
		if ($mod_data[1] != 'yes') {
			return false;
		}

		$this->_mysql->query("SELECT `modules_mail_table` as 'table', `modules_mail_columns` as 'columns' FROM `admin_modules` WHERE `modules_ID` = '{$mod_data[0]}' LIMIT 1");

		$mod_data = $this->_mysql->fetcharray('assoc');

		$this->mail_tbl['table'] = $mod_data['table'];
		/* Spaltennamen zuweisen */
		list($this->mail_tbl['column_ID'], $this->mail_tbl['column_name'], $this->mail_tbl['column_email']) = explode(',',$mod_data['columns']);

		return true;


	}

	/**
	 * Kontrolliert, ob die angegebenen Spalten vorhanden sind
	 * @see _get_tabledata
	 *
	 * @param array $table_data
	 * @return boolean
	 */

	private function _check_mailtable()
	{
		$table_infos = array();
		$colums_names = array();
		$columns_search = array($this->mail_tbl['column_ID'], $this->mail_tbl['column_name'], $this->mail_tbl['column_email']);
		
		$this->_mysql->query("SHOW COLUMNS FROM `{$this->mail_tbl['table']}`");
		$this->_mysql->saverecords('assoc');
		$table_infos = $this->_mysql->get_records();

		//Zuschneiden von $table_infos (komplexes Array) in ein einfaches Array
		foreach ($table_infos as $key => $value) {
			$colums_names[$key] = $table_infos[$key]['Field'];
		}
		
		//Sind die angebenen Spalten vorhanden?
		foreach ($columns_search as $value) {
			if (in_array($value, $colums_names) === false) {
				return false;
			}
		}

		return true;
	}


	/**
	 * Kontrolliert das Formular auf Standarteinträge, richtige Mailmuster und Captcha-Wort.
	 * Ist alles ordnungsgemäss, wird true zurückgegeben, sonst false. Bei false finden sich die Mängel
	 * in $answer.
	 *
	 * @param array[reference] $answer Antowrt
	 * @return boolean Erfolg
	 */
	private function _check_form(&$answer)
	{
		$mail_vars = $this->_configvars['Mail'];
		$error_vars =$this->_configvars['Error'];

		/* Formularcheck vorbereiten */
		$formcheck = new Formularcheck();
		$val = array($this->_gpc['POST']['title'], $this->_gpc['POST']['content'], $this->_gpc['POST']['name'],
		$this->_gpc['POST']['email']);
		$std = array($mail_vars['entry_title'], $mail_vars['entry_content'], $mail_vars['entry_name'],
		$mail_vars['entry_email']);
		$err = array($error_vars['title_error'], $error_vars['content_error'], $error_vars['name_error'],
		$error_vars['email_error']);

		$rtn_arr = $formcheck->field_check_arr($val, $std);

		//Fehlerarray durchgehen
		foreach ($rtn_arr as $key => $value) {
			if ($value == false) {
				$answer[] = $err[$key];
			}
		}
		
		//Email-Adresse auf Gültigkeit prüfen
		if ($this->_gpc['POST']['email'] != "" && $formcheck->mailcheck($this->_gpc['POST']['email']) > 0) {
			$answer[] = $error_vars['email_checkfailed'];
		}

		if (empty($answer)) {
			return true;
		} else {
			return false;
		}
	}

	

	/**
	 * Sendet das Formular zum Eintragen der Nachricht. Je nach Parameter werden Standartwerte oder POST-Daten an
	 * das Formular weitergegeben.
	 *
	 * @param boolean $first_form
	 * @param string $error
	 */
	private function _send_entryform($first_form = true, $error = null)
	{
		$this->_tpl_file = "mailform.tpl";

		/* Daten ermitteln */
		if ($first_form == false) {
			/* Daten aus Post-Array */
			$data = array('entry_id' => $this->_gpc['POST']['entry_id'], 'entry_title' => $this->_gpc['POST']['title'],
			'entry_content' => $this->_gpc['POST']['content'], 'entry_name' => $this->_gpc['POST']['name'],
			'entry_email' => $this->_gpc['POST']['email'], 'sessioncode' => $this->_sessioncode);
		} else {
			/* Standard-Einträge */
			$mail_vars = $this->_configvars['Mail'];
			$data = array('entry_id' => $this->_gpc['GET']['entry_id'], 'entry_title' => $mail_vars['entry_title'],
			'entry_content' => $mail_vars['entry_content'], 'entry_name' => $mail_vars['entry_name'],
			'entry_email' => $mail_vars['entry_email'], 'sessioncode' => $this->_sessioncode);
		}

		/* Error-Einträge */
		if (isset($error)) {
			$data['dump_errors'] = true;
			$data['error_title'] = 'Fehler im Formular';
			$data['error_contents'] = $error;
		}


		$this->_mysql->query("SELECT `{$this->mail_tbl['column_name']}` FROM `{$this->mail_tbl['table']}` WHERE `{$this->mail_tbl['column_ID']}` = '{$data['entry_id']}' LIMIT 1");
		$member_array = $this->_mysql->fetcharray();
		$data['reciver_name'] = $member_array[$this->mail_tbl['column_name']];

		$this->_smarty->assign($data);


	}

	/**
	 * Speichert die angegebenen Variablen in Smarty und speichert das Feedback-Template
	 *
	 * @param string $title Titel
	 * @param string $content Inhalt
	 * @param string $link Link
	 * @param string $linktext Linktext
	 */
	private function _send_feedback($title, $content, $link, $linktext)
	{
		$this->_smarty->assign("feedback_title", $title);
		$this->_smarty->assign("feedback_content", $content);
		$this->_smarty->assign("link", $link);
		$this->_smarty->assign("link_text", $linktext);

		$this->_tplfile = "feedback.tpl";
	}


}





?>
