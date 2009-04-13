<?php 
require_once ADMIN_DIR.'lib/module.interface.php';
require_once ADMIN_DIR.'lib/messageboxes.class.php';
require_once ADMIN_DIR.'lib/smilies.class.php';
require_once USER_DIR.'config/gbook_textes.inc.php';
/**
 * Diese Klasse ist zustaendig fuer das Editieren der Newseintraege. 
 * Auch koennen neue Beitraege hinzugefuegt oder geloescht werden.
 * 
 * @author Simon Däster
 * @package JClubCMS
 * news.class.php
 */

class Newsadmin implements Module
{
	/**
	 * Templatefile
	 *
	 * @var string
	 */
	private $_tplfile = null;
	/**
	 * Mysql-Klasse
	 *
	 * @var Mysql
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
	 * Messagebox Klass
	 *
	 * @var Messageboxes
	 */
	private $_msbox = null;

	/**
	 * POST, GET, COOKIE-Array
	 *
	 * @var array
	 */
	private $_gpc = array();
	
	/**
	 * Zeitformat
	 *
	 * @var string
	 */
	private $_timeformat = '%e.%m.%Y %k:%i';
	
	
	/**
	 * Daten aus den Config-Dateien
	 *
	 * @var array
	 */
	private $_configvars = array();
	
	/**
	 * Navigations-ID des Gästebuches
	 *
	 * @var string
	 */
	private $_nav_id = null;
	


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
	 * Fuehrt die einzelnen Methoden aus, abhaengig vom parameter
	 *
	 * @param array $parameters POST, GET und COOKIE-Variablen
	 */

	public function action($gpc)
	{
	
		//Daten laden
		$this->_smarty->config_load('textes.de.conf', 'News');
		$this->_configvars['News'] = $this->_smarty->get_config_vars();
		$this->_smarty->config_load('textes.de.conf', 'Form_Error');
		$this->_configvars['Error'] = $this->_smarty->get_config_vars();
		
		$this->_gpc = $gpc;

		$this->_nav_id = $this->_smarty->get_template_vars('local_link');
		
		$this->_msbox = new Messageboxes($this->_mysql, 'news', array('ID' => 'news_ID', 'ref_ID' => 'news_ref_ID', 'content' => 'news_content', 'name' => 'news_name', 'time' => 'news_time', 'email' => 'news_email', 'hp' => 'news_hp', 'title' => 'news_title'));

		$this->_smilie = new Smilies(SMILIES_DIR);
		
		if ($this->_getStatus() == 'off') {
			$this->_smarty->assign('info', 'Das Modul News ist deaktiviert. Benutzer k&ouml;nnen keine News anschauen');
		}

		//Je nach Get-Parameter die zugehörige Anweisung ausfuehren
		if (key_exists('action', $this->_gpc['GET'])) {
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
					$this->_view(15);
					return true;
				case '':
					$this->_view(15);
					return true;
				default:
					//Falsche Angaben enden im Fehler
					throw new CMSException(array('news' => 'invalid_url'), EXCEPTION_MODULE_CODE);
			}
		} else {
			//Keine Angabe -> Ausgabe der News
			$this->_view(15);
			return true;
		}
	}

	/**
	 * Liefert die Templatedatei der Klasse zurueck
	 *
	 * @return string $tplfile Template-Datei
	 */

	public function gettplfile()
	{
		return $this->_tplfile;
	}

	/**
	 * Gibt den Status des Moduls zurück, für dessen Verwaltung diese Klasse zuständig ist
	 *
	 * @return string Status (on|off);
	 */
	private function _getStatus()
	{
		$this->_mysql->query("SELECT `modules_status` FROM `modules` WHERE  `modules_name` = 'news'");
		$data = $this->_mysql->fetcharray('num');
		return $data[0];
	}

	/**
	 * Zeigt die Einträge an
	 *
	 * @param int $max_entries_pp Anzahl Einträge pro Seite
	 */

	private function _view($max_entries_pp)
	{
		$this->_tplfile = 'news.tpl';
		$news_array = array();

		if (isset($this->_gpc['GET']['page']) && is_numeric($this->_gpc['GET']['page']) && $this->_gpc['GET']['page'] > 0) {
			$page = $this->_gpc['GET']['page'];
		} else {
			$page = 1;
		}

		$news_array = $this->_msbox->getEntries($max_entries_pp, $page, 'DESC', 'ASC', $this->_timeformat);
		$this->_mysql->query('SELECT COUNT(*) as many FROM `news` WHERE `news_ref_ID` = \'0\'');
		$entries = $this->_mysql->fetcharray('num');

		$pagesnav_array = Page::get_static_pagesnav_array($entries[0],$max_entries_pp, $this->_gpc['GET']);


		//Inhalt parsen (Smilies) und an Smarty-Array übergeben
		foreach ($news_array as $key => $value) {

			$news_array[$key] = array('ID' => $value['news_ID'], 'title' => htmlentities($value['news_title']),
			'content' => $this->_smilie->show_smilie(htmlentities($value['news_content']), $this->_mysql),
			'name' => htmlentities($value['news_name']),
			'time' => $value['news_time'], 'email' => htmlentities($value['news_email']),
			'hp' => htmlentities($value['news_hp']), 'number_of_comments' => $value['number_of_comments']);

			$count = 0;
			//Kommentare durchackern
			foreach ($value['comments'] as $ckey => $cvalue) {

				$news_array[$key]['comments'][$ckey] = array('ID' => $cvalue['news_ID'],
				'title' => htmlentities($cvalue['news_title']),
				'content' => $this->_smilie->show_smilie(htmlentities($cvalue['news_content']), $this->_mysql),
				'name' => htmlentities($cvalue['news_name']), 'time' => $cvalue['news_time'],
				'email' => htmlentities($cvalue['news_email']), 'hp' => htmlentities($cvalue['news_hp']));

				$count++;

			}
		}


		$this->_smarty->assign('news', $news_array);
		$this->_smarty->assign('pages', $pagesnav_array);
		$this->_smarty->assign('entries', $entries[0]);

	}

	/**
	 * Fügt einen Eintrag hinzu oder liefert das Forumular dazu
	 *
	 */

	private function _add()
	{
		$news_vars = $this->_configvars['News'];


		if (isset($this->_gpc['POST']['btn_send']) && $this->_gpc['POST']['btn_send'] == 'Senden') {
			/*Formular wurde gesendet */

			/* Formular kontrollieren */
			$answer = array();
			$success = $this->_check_form($answer);

			if ($success == true) {
				/*Eintrag machen*/

				$answer['time'] = "NOW()";
				$this->_msbox->addEntry($answer);


				$this->_send_feedback($news_vars['allright_title'], $news_vars['allright_content'], "?nav_id=$this->_nav_id", 
				$news_vars['allright_link']);



			} else {
				/* Fehler im Formular */
				$this->_send_entryform(false, implode("<br />\n", $answer));
			}


		} else {
			/* Kein Formular abgeschickt */

			$this->_send_entryform(true);
		}

	}


	/**
	 * Kommentarfunktion dieser Klasse
	 *
	 */

	private function _comment()
	{
		$news_vars = $this->_configvars['News'];


		if (isset($this->_gpc['POST']['btn_send']) && $this->_gpc['POST']['btn_send'] == 'Senden') {
			/*Formular wurde gesendet */

			/* Formular kontrollieren */
			$answer = array();
			$success = $this->_check_form($answer, array('title'));

			if ($success == true) {
				/*Eintrag machen*/


				$answer['time'] = "NOW()";
				$this->_msbox->commentEntry((int)$this->_gpc['GET']['ref_ID'],$answer);


				$this->_send_feedback($news_vars['allright_title'], $news_vars['allright_content'],
				"?nav_id=$this->_nav_id", $news_vars['allright_link']);



			} else {
				/* Fehler im Formular */
				$this->_send_entryform(false,implode("<br />\n", $answer),true);
			}


		} else {
			/* Kein Formular abgeschickt */
			$this->_send_entryform(true,null,true);
		}

	}

	/**
	 * Editiert einen Eintrag im Mysql oder liefert das zugehörige Formular.
	 *
	 */

	private function _edit()
	{
		
		$news_vars = $this->_configvars['News'];

		//Eingetragen und überprüfen
		if (isset($this->_gpc['POST']['btn_send']) && $this->_gpc['POST']['btn_send'] == 'Senden') {

			/* Formular kontrollieren */
			$answer = array();
			$success = $this->_check_form($answer);

			if ($success == true) {
				/*Eintrag machen*/

				$navigation_id = $this->_smarty->get_template_vars('local_link');

				$answer['ID'] = $this->_gpc['GET']['ref_ID'];

				//In Datenbank einschreiben
				$this->_msbox->editEntry($answer);


				$this->_send_feedback($news_vars['allright_title'], $news_vars['allright_content'],
				"?nav_id=$navigation_id", $news_vars['allright_link']);

			} else {
				$this->_send_entryform(false,implode("<br />\n", $answer),true);
			}

		} else {

			$this->_send_entryform(true, null, false, true);

		}
	}

	/**
	 * Löscht einen Eintrag im Mysql oder das zugehörige Bestätigunsformular.
	 * Der Löschlink befindet sich in der Anzeige (@see _view()).
	 *
	 */

	private function _del()
	{
		$news_vars = $this->_configvars['News'];
		$linktext = "JA";
		$linktext2 = "NEIN";

		/* Aufrum zum Löschen */
		if (isset($this->_gpc['GET']['ref_ID']) && !isset($this->_gpc['POST']['weiter']) && !isset($this->_gpc['POST']['nein'])) {

			$id = (int)$this->_gpc['GET']['ref_ID'];
			$title = $news_vars['del_conf_title'];
			$msg = $this->_msbox->getEntry($id);
			$content = $this->_smilie->show_smilie($msg['news_content'], $this->_mysql);

			$data = array('title' => $title, 'content' => $content, 'del_ID' => $id, 'linktext' => $linktext,
			'linktext2' => $linktext2);
			
			$this->_smarty->assign($data);

			$this->_tplfile = 'msg_del.tpl';

		} else {

				/*Löschung erfolgreich*/
			if (isset($this->_gpc['POST']['weiter']) && $this->_gpc['POST']['weiter'] == $linktext) {
				$this->_msbox->delEntry((int)$this->_gpc['GET']['ref_ID']);
				$title = $news_vars['del_done_title'];
				$msg = $news_vars['del_done_content'];

				/*Löschung widerrufen */
			} elseif (isset($this->_gpc['POST']['nein']) && $this->_gpc['POST']['nein'] == $linktext2) {
				$title = $news_vars['del_abort_title'];
				$msg = $news_vars['del_abort_conten'];
				
				/*Falscher Link*/
			} else {
				$title = $news_vars['call_false_title'];
				$msg = $news_vars['calL_false_content'];
			}

			$this->_send_feedback($title, $msg, "?nav_id=$this->_nav_id", "Zum G&auml;stebuch");
		}

	}

	/**
	 * * * * * * * * * * * * * * * * * * * * * *
	 * Einige nützliche Funktionen kommen jetzt
	 * * * * * * * * * * * * * * * * * * * * * *
	 */

	
	/**
	 * Kontrolliert das Formular auf Standarteinträge und richtige Mailmuster.
	 * Ist alles ordnungsgemäss, wird true zurückgegeben, sonst false. Bei false finden sich die Mängel
	 * in $answer.
	 *
	 * @param array[reference] $answer Antwort
	 * @param array $blacklist Array der Schlüssel, die nicht geprüft werden sollen
	 * @return boolean Erfolg
	 */
	private function _check_form(&$answer, $blacklist = array())
	{
		$news_vars = $this->_configvars['News'];
		$error_vars =$this->_configvars['Error'];

		/* Formularcheck vorbereiten */
		$formcheck = new Formularcheck();

		/*Formulardaten */
		if (!in_array('title', $blacklist)) {
			/* Titel z.B. bei Kommentar nicht vorhanden */
			$val['title'] = $this->_gpc['POST']['title'];
		}
		$val = array(									'content' => $this->_gpc['POST']['content'],
		'name' =>  $this->_gpc['POST']['name'], 'email' => $this->_gpc['POST']['email'],
		'hp' => $this->_gpc['POST']['hp']);
		/* Standart-Strings*/
		$std = array('title' => $news_vars['entry_title'], 'content' => $news_vars['entry_content'],
		'name' => $news_vars['entry_name'],'email' => $news_vars['entry_email'], 'hp' => $news_vars['entry_hp']);
		/* Error-Strings */
		$err = array('title' => $error_vars['title_error'], 'content' => $error_vars['content_error'],
		'name' => $error_vars['name_error'],'email' => $error_vars['email_error']);

		/* Unerwünschte Schlüssel nicht kontrollieren und speichern */
		if (!empty($blacklist) && is_array($blacklist)) {
			foreach ($blacklist as $value) {
				unset($val[$value], $std[$value], $err[$value]);
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
			} elseif ($key == 'hp') {
				$this->_gpc['POST'][$key] = $rtn_arr[$key];
			}
		}

		if (empty($answer)) {
			if (!key_exists('title', $blacklist)) {
				$answer['title'] = $this->_gpc['POST']['title'];
			}
			/*Wenn keine Fehler aufgetaucht sind, werden die Einträge zurückgegeben*/
			$answer = array('content' => $this->_gpc['POST']['content'], 'name' => $this->_gpc['POST']['name'],
			'time' => 'news_time', 'email' => $this->_gpc['POST']['email'], 'hp' => $this->_gpc['POST']['hp']);
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
	private function _send_entryform($first_form = true, $error = null, $comment = false, $mysql_data = false)
	{
		$data = array();

		/* Daten ermitteln */
		if ($first_form == false) {
			/* Daten aus Post-Array */
			if ($comment == false) {
				$data['entry_title'] = stripslashes($this->_gpc['POST']['title']);
			}
			$data +=array('entry_content' => stripslashes($this->_gpc['POST']['content']), 'entry_name' => stripslashes($this->_gpc['POST']['name']),
			'entry_email' => stripslashes($this->_gpc['POST']['email']), 'entry_hp' => stripslashes($this->_gpc['POST']['hp']),);
		
		} elseif ($mysql_data == true) {
			//Daten aus dem msbox-Objekt holen
			$news_arr = $this->_msbox->getEntry($this->_gpc['GET']['ref_ID'], $this->_timeformat, false);
			$data += array('entry_title' => $news_arr['news_title'], 'entry_name' => $news_arr['news_name'],
			'entry_content' => $news_arr['news_content'], 'entry_email' => $news_arr['news_email'],
			'entry_hp' => $news_arr['news_hp'], 'entry_time' => $news_arr['news_time']);
		} else {
			/* Standard-Einträge */
			$news_vars = $this->_configvars['News'];
			$data += array('entry_title' => $news_vars['entry_title'],
			'entry_content' => $news_vars['entry_content'], 'entry_name' => $news_vars['entry_name'],
			'entry_email' => $news_vars['entry_email'],'entry_hp' => $news_vars['entry_hp'],);
		}
		
		/* Bei Kommentaren ist der vorhergehende Eintrag zu ermitteln */
		if ($comment == true) {		

			$this->_tplfile = "news_comment.tpl";
			
			$data['news'] = $this->_msbox->getEntry($this->_gpc['GET']['ref_ID'], $this->_timeformat, true);
						
			$data['news']['title'] = htmlentities($data['news']['news_title']);
			$data['news']['content'] = $this->_smilie->show_smilie(htmlentities($data['news']['news_content']), $this->_mysql);
			$data['news']['name'] = htmlentities($data['news']['news_name']);
			$data['news']['email'] = htmlentities($data['news']['news_email']);
			$data['news']['hp'] = htmlentities($data['news']['news_hp']);
			
			$data['news']['time'] = htmlentities($data['news']['news_time']);
			$data['news']['ID'] = $data['news']['news_ID'];
			
			/* HTML-Zeichen umwandeln */
			foreach($data['news']['comments'] as $key => $value) {
				
				$data['news']['comments'][$key]['content'] = $this->_smilie->show_smilie(htmlentities($value['news_content']), $this->_mysql);
				$data['news']['comments'][$key]['email'] = htmlentities($value['news_email']);
				$data['news']['comments'][$key]['hp'] = htmlentities($value['news_hp']);
				$data['news']['comments'][$key]['name'] = htmlentities($value['news_name']);
				
				$data['news']['comments'][$key]['time'] = htmlentities($value['news_time']);
				$data['news']['comments'][$key]['ID'] = $value['news_ID'];
				
			}
			
			/*Anzeigetitle des Editors festlegen */
			$data['entry_title'] = 'RE: '.htmlentities($data['news']['news_title']);

		} else {
			/* Keine Kommentareintrag -> Normaler Editor */
			$this->_tplfile = "msg_entry.tpl";
		}

		/* Error-Einträge */
		if (isset($error)) {
			$data['dump_errors'] = true;
			$data['error_title'] = 'Fehler im Formular';
			$data['error_content'] = $error;
		}

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
