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

		$this->_msbox = new MessageBoxes($this->_mysql, 'gbook', array('ID' => 'gbook_ID', 'ref_ID' => 'gbook_ref_ID',
		'content' => 'gbook_content', 'name' => 'gbook_name', 'time' => 'gbook_time', 'email' => 'gbook_email',
		'hp' => 'gbook_hp', 'title' => 'gbook_title'));

		$this->_smilie = new Smilies($dir_smilies);

		if (isset($this->_gpc['GET']['action'])) {
			switch ($this->_gpc['GET']['action']) {
				case 'new':
					$this->_add();
					break;
				case 'comment':
					$this->_comment();
					break;
				case 'view':
					$this->_view(5);
					break;
				case '':
					$this->_view(5);
					break;
				default:
					throw new CMSException('Gewählte Option ist nicht möglich', EXCEPTION_MODULE_CODE);
					return false;
			}
		} else {
			$this->_view(5);
		}

		return true;
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

			$gbook_array[$key] = array('ID' => $value['gbook_ID'], 'title' => htmlentities($value['gbook_title']),
			'content' => $this->_smilie->show_smilie(htmlentities($value['gbook_content']), $this->_mysql),
			'name' => htmlentities($value['gbook_name']),
			'time' => $value['gbook_time'], 'email' => htmlentities($value['gbook_email']),
			'hp' => htmlentities($value['gbook_hp']), 'number_of_comments' => $value['number_of_comments']);

			$count = 0;
			//Kommentare durchackern
			foreach ($value['comments'] as $ckey => $cvalue) {

				$gbook_array[$key]['comments'][$ckey] = array('ID' => $cvalue['gbook_ID'],
				'title' => htmlentities($cvalue['gbook_title']),
				'content' => $this->_smilie->show_smilie(htmlentities($cvalue['gbook_content']), $this->_mysql),
				'name' => htmlentities($cvalue['gbook_name']), 'time' => $cvalue['gbook_time'],
				'email' => htmlentities($cvalue['gbook_email']), 'hp' => htmlentities($cvalue['gbook_hp']));

				$count++;

			}
		}

		$this->_smarty->assign('gbook', $gbook_array);
		$this->_smarty->assign('pages', $pagesnav_array);
		$this->_smarty->assign('entries', $entries[0]);
		$this->_smarty->assign('comments', $comments[0]);

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

			/* Formular kontrollieren */
			$answer = array();
			$success = $this->_check_form($answer);

			if ($success == true) {
				/*Eintrag machen*/
				foreach ($answer as $key => $value) {
					$answer[$key] = stripslashes($value);
				}

				$navigation_id = $this->_smarty->get_template_vars('local_link');

				$answer['time'] = "NOW()";
				$this->_msbox->addEntry($answer);


				$this->_send_feedback($gbook_vars['allright_title'], $gbook_vars['allright_content'], "?nav_id=$navigation_id", $gbook_vars['allright_link']);



			} else {
				/* Fehler im Formular */
				$this->_send_entryform(false, implode("<br />\n", $answer));
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

			/* Formular kontrollieren */
			$answer = array();
			$success = $this->_check_form($answer, array('title'));

			if ($success == true) {
				/*Eintrag machen*/

				$navigation_id = $this->_smarty->get_template_vars('local_link');

				foreach ($answer as $key => $value) {
					$answer[$key] = stripslashes($value);
				}
				
				$answer['time'] = "NOW()";
				$this->_msbox->commentEntry((int)$this->_gpc['GET']['ref_ID'],$answer);


				$this->_send_feedback($gbook_vars['allright_title'], $gbook_vars['allright_content'],
				"?nav_id=$navigation_id", $gbook_vars['allright_link']);



			} else {
				/* Fehler im Formular */
				$this->_send_entryform(false,implode("<br />\n", $answer),true);
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

		$this->_captcha = new Captcha($this->_sessioncode, USER_DIR."data/temp/captcha", USER_DIR."data");
	}


	/**
	 * Kontrolliert das Formular auf Standarteinträge, richtige Mailmuster und Captcha-Wort.
	 * Ist alles ordnungsgemäss, wird true zurückgegeben, sonst false. Bei false finden sich die Mängel
	 * in $answer.
	 *
	 * @param array[reference] $answer Antwort
	 * @param array $blacklist Array der Schlüssel, die nicht geprüft werden sollen
	 * @return boolean Erfolg
	 */
	private function _check_form(&$answer, $blacklist = array())
	{
		$gbook_vars = $this->_configvars['Gbook'];
		$error_vars =$this->_configvars['Error'];

		/* Formularcheck vorbereiten */
		$formcheck = new Formularcheck();

		/*Formulardaten */
		if (!in_array('title', $blacklist)) {
			/* Titel z.B. bei Kommentar nicht vorhanden */
			$val['title'] = $this->_gpc['POST']['title'];
		}
		$val = array(							'content' => $this->_gpc['POST']['content'],
		'name' =>  $this->_gpc['POST']['name'], 'email' => $this->_gpc['POST']['email'],
		'hp' => $this->_gpc['POST']['hp']);
		/* Standart-Strings*/
		$std = array('title' => $gbook_vars['entry_title'], 'content' => $gbook_vars['entry_content'],
		'name' => $gbook_vars['entry_name'],'email' => $gbook_vars['entry_email'], 
		'hp' => $gbook_vars['entry_hp']);
		/* Error-Strings */
		$err = array('title' => $error_vars['title_error'], 'content' => $error_vars['content_error'],
		'name' => $error_vars['name_error'],'email' => $error_vars['email_error']);


		/* Unerwünschte Schlüssel nicht kontrollieren und speichern */
		if (!empty($blacklist) && is_array($blacklist)) {
			foreach ($blacklist as $value) {
				/* Nur löschen, wenn Variable existiert */
				if (isset($val[$value])) {
					unset($val[$value]);
				}
				if (isset($std[$value])) {
					unset($std[$value]);
				}
				if (isset($err[$value])) {
					unset($err[$value]);
				}
			}
		}

		$rtn_arr = $this->_msbox->formCheck($val, $std);

		
		/* Fehlerarray durchgehen */
		foreach ($rtn_arr as $key => $value) {
			if ($value == MSGBOX_FORMCHECK_NONE) {
				$answer[] = $err[$key];
			}

			if ($value == MSGBOX_FORMCHECK_INVALID && $key = 'email') {
				$answer[] = $error_vars['email_checkfailed'];
			} elseif ($key == 'hp' ) {
				/* Wenn die hp falsch ist, gibt es kein Fehler */
					$val[$key] = $rtn_arr[$key];	
			}
		}

		/* Captcha-Image prüfen */
		if(!$this->_captcha->verify($this->_gpc['POST']['captcha_word'])) {
			$answer[] = $error_vars['captcha_error']."<br />";
		}
		
		if (empty($answer)) {
			if (!in_array('title', $blacklist)) {
				$answer['title'] = $this->_gpc['POST']['title'];
			}

			/*Wenn keine Fehler aufgetaucht sind, werden die Einträge zurückgegeben*/
			$answer += array('content' => $val['content'], 'name' => $val['name'],
			'time' => 'gbook_time', 'email' => $val['email'], 'hp' => $val['hp']);

			return true;
		} else {
			return false;
		}
	}


	/**
	 * Erstellt das Eintragsformular für Beiträge im Gästebuch. Wenn nötig werden der vorhergehende
	 * Einträg (und die Kommentare dazu) ermittelt.
	 *
	 * @param boolean $first_form 1. Aufruf des Formulars?
	 * @param string|null $error Errortexte
	 * @param boolean $comment Ist der Beitrag ein Kommentar?
	 * @param boolean $mysql_data Werden die Daten vom Mysql geholt.
	 */
	private function _send_entryform($first_form = true, $error = null, $comment = false)
	{
		$data = array();

		/* Daten ermitteln */
		if ($first_form == false) {
			
			/* Daten aus Post-Array */
			if ($comment == false) {
				$data['entry_title'] = stripslashes($this->_gpc['POST']['title']);
			}

			$data +=array('entry_content' => stripslashes($this->_gpc['POST']['content']), 'entry_name' => stripslashes($this->_gpc['POST']['name']),
			'entry_email' => stripslashes($this->_gpc['POST']['email']), 'entry_hp' => stripslashes($this->_gpc['POST']['hp']),
			'sessioncode' => $this->_sessioncode);
		
		} else {
			/* Standard-Einträge */
			$gbook_vars = $this->_configvars['Gbook'];
			$data += array('entry_title' => $gbook_vars['entry_title'],
			'entry_content' => $gbook_vars['entry_content'], 'entry_name' => $gbook_vars['entry_name'],
			'entry_email' => $gbook_vars['entry_email'],'entry_hp' => $gbook_vars['entry_hp'],
			'sessioncode' => $this->_sessioncode);
		}

		/* Bei Kommentaren ist der vorhergehende Eintrag zu ermitteln */
		if ($comment == true) {

			$this->_tplfile = "gbook_comment.tpl";

			$data['gbook'] = $this->_msbox->getEntry($this->_gpc['GET']['ref_ID'], $this->_timeformat, true);

			$data['gbook']['gbook_title'] = htmlentities($data['gbook']['gbook_title']);
			$data['gbook']['gbook_content'] = htmlentities($data['gbook']['gbook_content']);
			$data['gbook']['gbook_email'] = htmlentities($data['gbook']['gbook_email']);
			$data['gbook']['gbook_hp'] = htmlentities($data['gbook']['gbook_hp']);
			$data['gbook']['gbook_name'] = htmlentities($data['gbook']['gbook_name']);

			$data['gbook']['gbook_content'] = $this->_smilie->show_smilie($data['gbook']['gbook_content'], $this->_mysql);

			/* HTML-Zeichen umwandeln */
			foreach($data['gbook']['comments'] as $key => $value) {

				$data['gbook']['comments'][$key]['gbook_content'] = htmlentities($value['gbook_content']);
				$data['gbook']['comments'][$key]['gbook_email'] = htmlentities($value['gbook_email']);
				$data['gbook']['comments'][$key]['gbook_hp'] = htmlentities($value['gbook_hp']);
				$data['gbook']['comments'][$key]['gbook_name'] = htmlentities($value['gbook_name']);

				$data['gbook']['comments'][$key]['gbook_content'] =  $this->_smilie->show_smilie($data['gbook']['comments'][$key]['gbook_content'], $this->_mysql);
			}

			/*Anzeigetitle des Editors festlegen */
			$data['entry_title'] = 'RE: '.$data['gbook']['gbook_title'];

		} else {
			/* Keine Kommentareintrag -> Normaler Editor */
			$this->_tplfile = "gbook_entry.tpl";
		}

		/* Error-Einträge */
		if (isset($error)) {
			$data['dump_errors'] = true;
			$data['error_title'] = 'Fehler im Formular';
			$data['error_content'] = $error;
		}

		$hash = $this->_captcha->get_pic(4);

		$data['captcha_img'] = $hash;
		$data['smilies_list'] = $this->_smilie->create_smiliesarray($this->_mysql);

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
		$this->_smarty->assign("feedback_link", $link);
		$this->_smarty->assign("feedback_linktext", $linktext);

		$this->_tplfile = "feedback.tpl";
	}


}
?>
