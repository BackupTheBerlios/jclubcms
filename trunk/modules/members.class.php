<?php
/**
 * @package JClubCMS
 * @author Simon Däster
 * File: members.class.php
 * Classes: Members
 * Requieres: PHP5
 *
 * Dieses Modul gibt die Mitglieder aus, welche im Mysql gespeichert sind.
 *
 */

require_once ADMIN_DIR.'lib/module.interface.php';

require_once ADMIN_DIR.'lib/captcha.class.php';

require_once ADMIN_DIR.'lib/mailsend.class.php';  //Für das versenden vom senden des Mails
require_once ADMIN_DIR.'lib/formularcheck.class.php'; //Überprüfen der Formularfelder
require_once USER_DIR.'config/mail_textes.inc.php'; //Standard-Texte für Mailformular und -fehler
require_once USER_DIR.'config/gbook_textes.inc.php';


class Members implements Module
{
	/**
	 * Smarty-Objekt
	 *
	 * @var Smarty
	 */
	private $smarty;

	/**
	 * Mysql-Objekt
	 *
	 * @var Mysql
	 */
	private $mysql;

	/**
	 * Template-Datei
	 *
	 * @var string
	 */
	private $tpl_file;

	/**
	 * GET, POST, COOKIE-Daten
	 *
	 * @var array
	 */
	private $gpc = array();

	/**
	 * Aufbau der Klasse
	 *
	 * @param Smarty $smarty
	 * @param Mysql $mysql
	 */
	public function __construct($mysql, $smarty)
	{
		$this->smarty = $smarty;
		$this->mysql = $mysql;
	}

	/**
	 * Start des Moduls
	 *
	 * @param array $gpc
	 */
	public function action($gpc)
	{
		$this->gpc = $gpc;
			
		$this->smarty->debugging = false;

		switch ($this->gpc['GET']['action']) {
			case 'mail':
				$this->mail();
				break;
			default:
				$this->view();
		}
		
		

	}


	public function gettplfile()
	{
		return $this->tpl_file;
	}

	private function view()
	{
		$this->tpl_file = "members.tpl";
		$members = array();

		$this->mysql->query('Select members_ID, members_name, members_spitzname, DATE_FORMAT(`members_birthday`, \'%W, %e.%m.%Y\') as members_birthday, members_song, members_hobby, members_job, members_motto, members_FIDimage from members ORDER BY `members`.`members_birthday` ASC Limit 0,30');

		$this->mysql->saverecords('assoc');
		$members = $this->mysql->get_records();

		$this->smarty->assign('members', $members);

	}
	

	/**
	 * Übernimmt das Verschicken von Mails
	 *
	 */

	private function mail()
	{

		$this->smarty->config_load('textes.de.conf', 'Mail');
		$mail_vars = $this->smarty->get_config_vars();
		$this->smarty->config_load('textes.de.conf', 'Error');
		$error_vars = $this->smarty->get_config_vars();
		
		$sessioncode = null;
		
		//Captcha zurücksetzen
		if (key_exists('captcha_revoke', $this->gpc['POST'])) {
			$new_code = true;
		} else {
			$new_code = false;
		}
		
		$captcha = $this->initCaptcha($sessioncode, $new_code);
		

		if (isset($this->gpc['POST']['btn_send']) && $this->gpc['POST']['btn_send'] == 'Senden') {
			/*Formular wurde gesendet */

			//Formular-Kontrolle
			if ($this->gpc['POST']['entry_id'] != $this->gpc['GET']['entry_id']) {
				throw new CMSException("Sie benutzen das falsche Formular für diese Mailadresse", EXCEPTION_MODULE_CODE, 'Datenkollision');
			}

			//Benutzung einfacher Variablen
			$title = $this->gpc['POST']["title"];
			$content = $this->gpc['POST']["content"];
			$name = $this->gpc['POST']["name"];
			$email = $this->gpc['POST']["email"];
			$entry_id = $this->gpc['POST']["entry_id"];
			$captcha_word = $this->gpc['POST']['captcha_word'];
			
			$answer = "";

			//Einleitung zur Formularcheck
			$formcheck = new Formularcheck();
			$val = array($title, $content, $name, $email);
			$std = array($mail_vars['entry_title'], $mail_vars['entry_content'], $mail_vars['entry_name'], $mail_vars['entry_email']);
			$err = array($error_vars['title_error'], $error_vars['content_error'], $error_vars['name_error'], $error_vars['email_error']);
			
			var_dump(array('val' => $val, 'std' => $std, 'err' => $err));

			$rtn_arr = $formcheck->field_check_arr($val, $std);

			//Fehlerarray durchgehen
			foreach ($rtn_arr as $key => $value) {
				if ($value === false) {
					$answer .= $err[$key]."<br />\n";
				}
			}

			//Email-Adresse auf Gültigkeit prüfen
			if ($email != "" && $formcheck->mailcheck($email) > 0) {
				$answer .= $error_vars['email_checkfailed'];
			}

			//Captcha-Image prüfen
			if(!$captcha->verify($captcha_word)) {
				$answer .= $error_vars['captcha_error']."<br />";
			}


			//Mail schicken oder
			if ($answer === "" && false) {

				$navigation_id = $this->smarty->get_template_vars('local_link');


				$this->mysql->query("SELECT members_name, members_email FROM members WHERE members_ID = $entry_id");
				$mail_reciver = $this->mysql->fetcharray();
				$mail_reciver_name = $mail_reciver['members_name'];
				$mail_reciver_email = $mail_reciver['members_email'];

				$mail = new Mailsend();
				$mailsend_controll = $mail->mail_send_link($this->mysql, $mail_reciver_name, $mail_reciver_email, $name, $email, $title, $content);

				if ($mailsend_controll == true) {
					$feedback_title = $mail_saved_title;
					$feedback_content = $mail_saved_content;
					$feedback_link = "?nav_id=$navigation_id";
					$feedback_linktext = $news_mail_link;
				}
				else {
					$feedback_title = $mail_failer_title;
					$feedback_content = $mail_failer_content;
					$feedback_link = "?nav_id=$navigation_id";
					$feedback_linktext = $news_mail_link;
				}

				$this->smarty->assign("feedback_title", $feedback_title);
				$this->smarty->assign("feedback_content", $feedback_content);
				$this->smarty->assign("link", $feedback_link);
				$this->smarty->assign("link_text", $feedback_linktext);
				$this->tpl_file = "feedback.tpl";

				//Zurück zum Mailformular
			} else {

				$data = array('entry_id' => $this->gpc['POST']['entry_id'], 'entry_title' => $title,
				'entry_content' => $content, 'entry_name' => $name, 'entry_email' => $email);

				$this->mailform($data);

				//Fehlerausgabe
				$this->smarty->assign(array('dump_errors' => true, 'error_title' => 'Fehler im Formular',
				'error_content' => $answer));
				
				var_dump($answer);

			}


			//1. Aufruf der Mail-Form
		} else {

			//Captcha erneuern
			if (key_exists('captcha_revoke', $this->gpc['POST'])) {
				$data = array('entry_id' => $this->gpc['POST']['entry_id'], 'entry_title' => $this->gpc['POST']['title'], 'entry_content' => $this->gpc['POST']['content'], 'entry_name' => $this->gpc['POST']['name'], 'entry_email' => $this->gpc['POST']['email'], 'sessioncode' => $sessioncode);
			} else {

				$data = array('entry_id' => $this->gpc['GET']['entry_id'], 'entry_title' => $mail_vars['entry_title'], 'entry_content' => $mail_vars['entry_content'], 'entry_name' => $mail_vars['entry_name'], 'entry_email' => $mail_vars['entry_email'], 'sessioncode' => $sessioncode);
			}
			
			$this->smarty->assign('captcha_img', $captcha->get_pic(6));
			
			$this->mailform($data);

		}

	}

	
	
	/**
	 * Gibt das Mailformular aus
	 *
	 * @param array $data Daten für Smarty
	 */

	private function mailform(array $data)
	{
		$this->tpl_file = "mail_form.tpl";

		$this->mysql->query("SELECT `members_name` FROM `members` WHERE `members_ID` = '{$data['entry_id']}' LIMIT 1");
		$member_array = $this->mysql->fetcharray();

		$this->smarty->assign(array('entry_id' => $data['entry_id'], 'entry_title' => $data['entry_title'], 'entry_content' => $data['entry_content'], 'entry_name' => $data['entry_name'], 'entry_email' => $data['entry_email'], 'sessioncode' => $data['sessioncode']));
		$this->smarty->assign("reciver_name", $member_array["members_name"]);
	}


	/**
	 * Initialisiert die Captcha-Klasse
	 *
	 * @param string[reference] $sessioncode Sessioncode, wird generiert oder übernommen
	 * @param boolean $new_code Neuer Sessioncode generieren?
	 * @return Captcha Captcha-Objekt
	 */
	private function initCaptcha(&$sessioncode, $new_code = false)
	{
		//Captcha Start
		if($new_code == false && key_exists('sessioncode', $this->gpc['POST']) && !empty($this->gpc['POST']['sessioncode'])) {
			$sessioncode = $this->gpc['POST']['sessioncode'];
		} else {
			$sessioncode = md5(microtime(true)*round(rand(1,40000)));
		}
		
		return new Captcha($sessioncode, USER_DIR."data/temp/");
	}

}







?>
