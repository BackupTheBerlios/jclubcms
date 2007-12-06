<?php
/**
 * @author Simon Däster
 * @package JClubCMS
 * gbook.class.php
 * 
 * Diese Klasse ist zuständig für das Anzeigen und Hinzufügen der Gästebucheinträge.
 * 
 */

require_once ADMIN_DIR.'lib/messageboxes.class.php';
require_once ADMIN_DIR.'lib/smilies.class.php';
require_once ADMIN_DIR.'lib/module.interface.php';
require_once USER_DIR.'config/gbook_textes.inc.php';

class Gbook implements Module {
	/**
	 * Templatefile
	 *
	 * @var string
	 */
	private $_tplfile = null;
	/**
	 * Mysql-Klasse
	 *
	 * @var mysql
	 */
	private $_mysql = null;

	/**
	 * Smarty-Klasse
	 *
	 * @var Smarty
	 */
	private $_smarty = null;
	/**
	 * Smilie-Klasse
	 *
	 * @var Smilies
	 */
	private $_smilie = null;

	/**
	 * Captcha-Klasse
	 *
	 * @var Captcha
	 */
	private $_captcha = null;

	/**
	 * GET, POST, COOKIE-Array
	 *
	 * @var array
	 */
	private $_gpc = array();
	/**
	 * Messagebox Klasse
	 *
	 * @var Messageboxes
	 */
	private $_msbox = null;

	private $_timeformat = '%e.%m.%Y %k:%i';

	/**
	 * Daten aus den Config-Dateien
	 *
	 * @var array
	 */
	private $_configvars = array();

	/**
	 * Sessionscode
	 *
	 * @var string
	 */
	private $_sessioncode;

	/**
	 * Aufbau der Klasse
	 *
	 * @param Mysql $mysql Mysql-Objekt
	 * @param Smarty $smarty Smarty-Objekt
	 */

	public function __construct($mysql, $smarty)
	{
		$this->_mysql = $mysql;
		$this->_smarty = $smarty;
	}


	/**
	 * Führt die einzelnen Methoden aus, abhängig vom Parameter
	 *
	 * @param array $gpc $_POST- und $_GET-Arrays
	 * @return boolean
	 */
	public function action($gpc)
	{
		global $dir_smilies;

		//Daten laden
		$this->_smarty->config_load('textes.de.conf', 'Gbook');
		$this->_configvars['Gbook'] = $this->_smarty->get_config_vars();
		$this->_smarty->config_load('textes.de.conf', 'Form_Error');
		$this->_configvars['Error'] = $this->_smarty->get_config_vars();

		$this->_gpc = $gpc;

		$this->_msbox = new MessageBoxes($this->_mysql, 'gbook', array('ID' => 'gbook_ID', 'ref_ID' => 'gbook_ref_ID', 'content' => 'gbook_content', 'name' => 'gbook_name', 'time' => 'gbook_time', 'email' => 'gbook_email', 'hp' => 'gbook_hp', 'title' => 'gbook_title'));

		$this->_smilie = new Smilies($dir_smilies);

		if (isset($this->_gpc['GET']['action'])) {
			switch ($this->_gpc['GET']['action']) {
				case 'new':
					$this->_add();
					return true;
				case 'comment':
					$this->_comment();
					return true;
				case 'edit':
					$this->_edit();
					return true;
				case 'del':
					$this->_del();
					return true;
				case 'view':
					$this->_view(5);
					return true;
				case '':
					$this->_view(5);
					return true;
				default:
					throw new CMSException('Gewählte Option ist nicht möglich', EXCEPTION_MODULE_CODE);
					return false;
			}
		} else {
			$this->_view(5);
			return true;
		}
	}

	/**
	 * Liefert die zugehörige Templatedatei
	 *
	 * @return string $tplfile Templatedatei
	 */

	public function gettplfile()
	{
		return $this->_tplfile;
	}

	/**
	 * Zeigt die Einträge an
	 *
	 * @param int $max_entries_pp Anzahl Einträge pro Seite
	 */

	private function _view($max_entries_pp)
	{
		$this->_tplfile = 'gbook.tpl';
		$gbook_array = array();

		if (isset($this->_gpc['GET']['page']) && is_numeric($this->_gpc['GET']['page']) && $this->_gpc['GET']['page'] > 0) {
			$page = $this->_gpc['GET']['page'];
		} else {
			$page = 1;
		}

		$gbook_array = $this->_msbox->getEntries($max_entries_pp, $page, 'DESC', 'ASC', $this->_timeformat);
		$this->_mysql->query('SELECT COUNT(*) as many FROM `gbook` WHERE `gbook_ref_ID` = \'0\'');
		$entries = $this->_mysql->fetcharray('num');
		$this->_mysql->query('SELECT COUNT(*) as many FROM `gbook` WHERE `gbook_ref_ID` != \'0\'');
		$comments = $this->_mysql->fetcharray('num');



		$pagesnav_array = Page::get_static_pagesnav_array($entries[0],$max_entries_pp, $this->_gpc['GET']);


		//Inhalt parsen (Smilies) und an Smarty-Array übergeben
		foreach ($gbook_array as $key => $value) {

			//Nur gbook-Daten ohne $gbook_array['many'] abchecken
			if ($key !== 'many') {
				$value['gbook_content'] = $this->_smilie->show_smilie($value['gbook_content'], $this->_mysql);

				$gbook_array[$key] = array('ID' => $value['gbook_ID'], 'title' => $value['gbook_title'], 'content' => $value['gbook_content'], 'name' => $value['gbook_name'], 'time' => $value['time'], 'email' => $value['gbook_email'], 'hp' => $value['gbook_hp']);

				//Kommentare durchackern
				foreach ($value['comments'] as $ckey => $cvalue) {
					$cvalue['gbook_content'] = $this->_smilie->show_smilie($cvalue['gbook_content'], $this->_mysql);

					$gbook_array[$key]['comments'][$ckey] = array('ID' => $cvalue['gbook_ID'], 'title' => $cvalue['gbook_title'], 'content' => $cvalue['gbook_content'], 'name' => $cvalue['gbook_name'], 'time' => $cvalue['time'], 'email' => $cvalue['gbook_email'], 'hp' => $cvalue['gbook_hp']);

				}

			}
		}

		$this->_smarty->assign('gbook', $gbook_array);
		$this->_smarty->assign('pages', $pagesnav_array);
		$this->_smarty->assign('entries', $entries[0]);
		$this->_smarty->assign('comments', $comments[0]);
		print_r($entries); print_r($comments);

	}

	/**
	 * Fügt einen Eintrag hinzu oder liefert das Forumular dazu
	 *
	 */

	private function _add()
	{
		$gbook_vars = $this->_configvars['Gbook'];

		$this->_initCaptcha();

		if (isset($this->_gpc['POST']['btn_send']) && $this->_gpc['POST']['btn_send'] == 'Senden') {
			/*Formular wurde gesendet */

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
				/*Eintrag machen*/

				$navigation_id = $this->_smarty->get_template_vars('local_link');

				$answer['time'] = "NOW()";
				$this->_msbox->addEntry($answer);


				$this->_send_feedback($gbook_vars['allright_title'], $gbook_vars['allright_content'], "?nav_id=$navigation_id", $mail_vars['allright_link']);



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
	 * Kommentarfunktion dieser Klasse
	 *
	 */

	private function _comment()
	{
		$gbook_vars = $this->_configvars['Gbook'];

		$this->_initCaptcha();

		if (isset($this->_gpc['POST']['btn_send']) && $this->_gpc['POST']['btn_send'] == 'Senden') {
			/*Formular wurde gesendet */

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
				/*Eintrag machen*/

				$navigation_id = $this->_smarty->get_template_vars('local_link');

				$answer['time'] = "NOW()";
				$this->_msbox->commentEntry($this->_gpc['POST']['ref_ID'],$answer);


				$this->_send_feedback($gbook_vars['allright_title'], $gbook_vars['allright_content'], "?nav_id=$navigation_id", $mail_vars['allright_link']);



			} else {
				/* Fehler im Formular */
				$this->_send_entryform(false,$answer,true);
			}


		} else {
			/* Kein Formular abgeschickt */

			//Captcha zurücksetzen
			if (key_exists('captcha_revoke', $this->_gpc['POST'])) {
				$first_form = false;
			} else {
				$first_form = true;
			}

			$this->_send_entryform($first_form,null,true);
		}

	}
	/**
	 * Initialisiert die Captcha-Klasse
	 *
	 */
	private function _initCaptcha()
	{
		//Captcha Start
		if(key_exists('sessioncode', $this->_gpc['POST']) && !empty($this->_gpc['POST']['sessioncode'])) {
			$this->_sessioncode = $this->_gpc['POST']['sessioncode'];
		} else {
			$this->_sessioncode = md5(microtime(true)*round(rand(1,40000)));
		}

		$this->_captcha = new Captcha($this->_sessioncode, USER_DIR."data/temp/captcha/", USER_DIR."data/");
	}


	/**
	 * Kontrolliert das Formular auf Standarteinträge, richtige Mailmuster und Captcha-Wort.
	 * Ist alles ordnungsgemäss, wird true zurückgegeben, sonst false. Bei false finden sich die Mängel
	 * in $answer.
	 *
	 * @param array[reference] $answer Antwort
	 * @return boolean Erfolg
	 */
	private function _check_form(&$answer)
	{
		$gbook_vars = $this->_configvars['Gbook'];
		$error_vars =$this->_configvars['Error'];

		/* Formularcheck vorbereiten */
		$formcheck = new Formularcheck();
		$val = array($this->_gpc['POST']['title'], $this->_gpc['POST']['content'], $this->_gpc['POST']['name'],
		$this->_gpc['POST']['email'], $this->_gpc['POST']['hp']);
		$std = array($gbook_vars['entry_title'], $gbook_vars['entry_content'], $gbook_vars['entry_name'],
		$gbook_vars['entry_email'], $gbook_vars['entry_hp']);
		$err = array($error_vars['title_error'], $error_vars['content_error'], $error_vars['name_error'],
		$error_vars['email_error'], $error_vars['hp_error']);

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

		//Captcha-Image prüfen
		if(!$this->_captcha->verify($this->_gpc['POST']['captcha_word'])) {
			$answer[] = $error_vars['captcha_error']."<br />";
		}

		if (empty($answer)) {
			/*Wenn keine Fehler aufgetaucht sind, werden die Einträge zurückgegeben*/
			$answer = array('content' => $this->_gpc['POST']['content'], 'name' => $this->_gpc['POST']['name'], 'time' => 'gbook_time', 'email' => $this->_gpc['POST']['email'], 'hp' => $this->_gpc['POST']['hp'], 'title' => $this->_gpc['POST']['title']);
			return true;
		} else {
			return false;
		}
	}



	private function _send_entryform($first_form = true, $error = null, $comment = false)
	{
		if ($comment == true) {
			$this->_tplfile = "gbook_new_comment.tpl";
			$data['gbook'] = $this->_msbox->getEntry($this->_gpc['GET']['ref_ID'], $this->_timeformat);
			$data['gbook']['gbook_content'] = $this->_smilie->show_smilie($data['gbook']['gbook_content'], $this->_mysql);
			
		} else {
			$this->_tplfile = "gbook_new_entry.tpl";
		}

		/* Daten ermitteln */
		if ($first_form == false) {
			/* Daten aus Post-Array */
			$data += array('entry_title' => $this->_gpc['POST']['title'],
			'entry_content' => $this->_gpc['POST']['content'], 'entry_name' => $this->_gpc['POST']['name'],
			'entry_email' => $this->_gpc['POST']['email'], 'entry_hp' => $this->_gpc['POST']['hp'], 'sessioncode' => $this->_sessioncode);
		} else {
			/* Standard-Einträge */
			$gbook_vars = $this->_configvars['Gbook'];
			$data += array('entry_title' => $gbook_vars['entry_title'],
			'entry_content' => $gbook_vars['entry_content'], 'entry_name' => $gbook_vars['entry_name'],
			'entry_email' => $gbook_vars['entry_email'],'entry_hp' => $gbook_vars['entry_hp'], 'sessioncode' => $this->_sessioncode);
		}

		/* Error-Einträge */
		if (isset($error)) {
			$data['dump_errors'] = true;
			$data['error_title'] = 'Fehler im Formular';
			$data['error_contents'] = $error;
		}

		$hash = $this->_captcha->get_pic(4);

		$data['captcha_img'] = $hash;
		$data['smilies_list'] = $this->_smilie->create_smiliesarray($this->_mysql);

		$this->_smarty->assign($data);
		print_r($data);

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