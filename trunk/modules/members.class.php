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

	public function view()
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

	public function mail()
	{
		
		
		global $mail_entry_title, $mail_entry_content, $mail_entry_name, $mail_entry_email;
		global $gbook_title_onerror_de, $gbook_content_onerror_de, $gbook_name_onerror_de, $gbook_email_onerror_de, $gbook_email_checkfaild_de, $gbook_captcha_onerror_de;
		global $mail_saved_title, $mail_saved_content, $news_mail_link, $mail_failer_title, $mail_failer_content;
		
		echo "TEST: ".$GLOBALS['mail_entry_title'].$GLOBALS['mail_entry_content'].$GLOBALS['mail_entry_name'].$GLOBALS['mail_entry_email'];
		

		
		$this->initCaptcha($captcha, $sessioncode);

		if (isset($this->gpc['POST']['btn_send']) && $this->gpc['POST']['btn_send'] == 'Senden') {


			//Formular-Kontrolle
			if ($this->gpc['POST']['entry_id'] !== $this->gpc['GET']['entry_id']) {
				throw new CMSException("Sie benutzen das falsche Formular für diese Mailadresse", EXCEPTION_MODULE_CODE, 'Datenkollision');
			}

			$title = $this->gpc['POST']["title"];
			$content = $this->gpc['POST']["content"];
			$name = $this->gpc['POST']["name"];
			$email = $this->gpc['POST']["email"];
			$entry_id = $this->gpc['POST']["entry_id"];
			$captcha_word = $this->gpc['POST']['captcha_word'];
			
			echo "$title, $content, $name, $email";

			$answer = "";

			$formcheck = new Formularcheck();
			$val = array($title, $content, $name, $email);
			$std = array($mail_entry_title, $mail_entry_content, $mail_entry_name, $mail_entry_email);
			$err = array($gbook_title_onerror_de, $gbook_content_onerror_de, $gbook_name_onerror_de, $gbook_email_onerror_de);
			
			var_dump(array('val' => $val, 'std' => $std, 'err' => $err));

			$rtn_arr = $formcheck->field_check_arr($val, $std);

			//Fehlerarray durchgehen
			foreach ($rtn_arr as $key => $value) {
				if ($value === true) {
					$answer .= $err[$key]."<br />\n";
				}
			}

			//Email-Adresse auf Gültigkeit prüfen
			if ($formcheck->mailcheck($email) > 0) {
				$answer .= $gbook_email_checkfaild_de;
			}

			//Captcha-Image prüfen
			if(!$captcha->verify($captcha_word)) {
				$answer .= $gbook_captcha_onerror_de."<br />";
			}




			//Mail schicken oder
			if ($answer === "") {

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

				$smarty->assign("feedback_title", $feedback_title);
				$smarty->assign("feedback_content", $feedback_content);
				$smarty->assign("link", $feedback_link);
				$smarty->assign("link_text", $feedback_linktext);
				$this->tpl_file = "feedback.tpl";

				//Zurück zum Mailformular
			} else {

				$data = array('entry_id' => $this->gpc['POST']['entry_id'], 'entry_title' => $title,
				'entry_content' => $content, 'entry_name' => $name, 'entry_email' => $email);

				$this->mailform($data);

				//Fehlerausgabe
				$this->smarty->assign(array('dump_errors' => true, 'error_title' => 'Fehler im Formular',
				'error_content' => $answer));

			}


			//1. Aufruf der Mail-Form
		} else {

			//Captcha erneuern
			if (key_exists('captcha_revoke', $this->gpc['POST'])) {
				$data = array('entry_id' => $this->gpc['POST']['entry_id'], 'entry_title' => $this->gpc['POST']['title'], 'entry_content' => $this->gpc['POST']['content'], 'entry_name' => $this->gpc['POST']['name'], 'entry_email' => $this->gpc['POST']['email']);
			} else {

				$data = array('entry_id' => $this->gpc['GET']['entry_id'], 'entry_title' => $mail_entry_title, 'entry_content' => $mail_entry_content, 'entry_name' => $mail_entry_name, 'entry_email' => $mail_entry_email);
			}

			var_dump($data);
			
			$this->mailform($data);

		}

	}

	private function mailform(array $data)
	{
		$this->tpl_file = "mail_form.tpl";

		$this->mysql->query("SELECT `members_name` FROM `members` WHERE `members_ID` = '{$data['entry_id']}' LIMIT 1");
		$member_array = $this->mysql->fetcharray();
		$member_name = $member_array["members_name"];

		$this->smarty->assign($data);
		$this->smarty->assign("reciver_name", $member_name);
	}


	//Initialisier die Captcha-Klasse
	private function initCaptcha(&$catpcha, &$sessoncode)
	{
		//Captcha Start
		if(isset($this->gpc['POST']['sessionscode']) && $this->gpc['POST']['sessionscode'] != "") {
			$sessionscode = $this->gpc['POST']['sessionscode'];
		} else {
			$sessionscode = md5(microtime(true)*round(rand(1,40000)));
		}

		$captcha = new captcha($sessionscode, "./data/temp");
	}

}







?>
