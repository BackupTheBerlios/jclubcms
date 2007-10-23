<?php 

/**
 * @author Simon Daester
 * @package JClubCMS
 * news.class.php
 * 
 * Diese Klasse ist zustaendig fuer das Editieren der Newseintraege. Auch koennen neue Beitraege hinzugefuegt oder geloescht
 * werden
 */

require_once ADMIN_DIR.'lib/module.interface.php';
require_once ADMIN_DIR.'lib/messageboxes.class.php';
require_once ADMIN_DIR.'lib/smilies.class.php';
require_once USER_DIR.'config/gbook_textes.inc.php';

class News implements Module
{
	/**
	 * Templatefile
	 *
	 * @var string
	 */
	private $tplfile = null;
	/**
	 * Mysql-Klasse
	 *
	 * @var mysql
	 */
	private $mysql = null;
	/**
	 * Smarty-Klasse
	 *
	 * @var Smarty
	 */
	private $smarty = null;
	/**
	 * Smilie-Klasse
	 *
	 * @var smilies
	 */
	private $smilie = null;
	private $post_arr = array();
	private $get_arr = array();
	/**
	 * Messagebox Klass
	 *
	 * @var Messageboxes
	 */
	private $msbox = null;


	/**
	 * Aufbau der Klasse
	 *
	 * @param Mysql $mysql Mysql-Objekt
	 * @param Smarty $smarty Smarty-Objekt
	 */

	public function __construct($mysql, $smarty)
	{
		$this->mysql = $mysql;
		$this->smarty = $smarty;
	}


	/**
	 * Fuehrt die einzelnen Methoden aus, abhaengig vom parameter
	 *
	 * @param array $parameters POST- und GET-Variablen
	 */

	public function action($parameters)
	{
		//Daten initialisieren
		global $dir_smilies;
		$this->post_arr = $parameters['POST'];
		$this->get_arr = $parameters['GET'];


		$this->msbox = new Messageboxes($this->mysql, 'news', array('ID' => 'news_ID', 'ref_ID' => 'news_ref_ID', 'content' => 'news_content', 'name' => 'news_name', 'time' => 'news_time', 'mail' => 'news_email', 'hp' => 'news_hp', 'title' => 'news_title'));

		$this->smilie = new smilies($dir_smilies);

		//Je nach Get-Parameter die zugehoerige Anweisung ausfuehren
		if (isset($this->get_arr['action'])) {
			switch ($this->get_arr['action']) {
				case 'new':
					$this->add();
					return true;
				case 'comment':
					$this->comment();
					return true;
				case 'edit':
					$this->edit();
					return true;
				case 'del':
					$this->del();
					return true;
				case 'view':
					$this->view(15);
					return true;
				case '':
					$this->view(15);
					return true;
				default:
					//Falsche Angaben enden im Fehler
					throw new CMSException("Sie haben falsche URL-Parameter weitergegeben. Daher konnte keine entsprechende Aktion ausgef&uuml;hrt werden", EXCEPTION_MODULE_CODE);
			}
		} else {
			//Keine Angabe -> Ausgabe der News
			$this->view(15);
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
		return $this->tplfile;
	}

	/**
	 * Zeigt die Eintraege an
	 *
	 * @param int $max_entries_pp Anzahl Eintraege pro Seite
	 */

	private function view($max_entries_pp)
	{

		//Daten definiere und initialisieren
		$this->tplfile = 'news.tpl';
		$news_array = array();
		$error = false;

		//Seite herausfinden
		if (isset($this->get_arr['page']) && is_numeric($this->get_arr['page']) && $this->get_arr['page'] > 0) {
			$page = $this->get_arr['page'];
		} else {
			$page = 1;
		}

		//Daten holen
		$news_array = $this->msbox->getEntries($max_entries_pp, $page, 'DESC','ASC', '%e.%m.%Y %k:%i');

		//Anzahl der Daten holen
		/*$this->mysql->query('SELECT COUNT(*) as many FROM `news`');
		$data = $this->mysql->fetcharray('assoc');*/



		$pagesnav_array = Page::get_static_pagesnav_array($data['many'],$max_entries_pp, $this->get_arr);

		foreach ($news_array as $key => $value) {

			//Nur news-Daten ohne $news_array['many'] abchecken
			if ($key !== 'many') {
				$value['news_content'] = $this->smilie->show_smilie($value['news_content'], $this->mysql);

				foreach ($value['comments'] as $ckey => $cvalue) {
					$value['comments'][$ckey]['news_content'] = $this->smilie->show_smilie($cvalue['news_content'], $this->mysql);
				}


				$news_array[$key] = $value;
			}

		}

		$this->smarty->assign('entrys', $news_array['many']);
		unset($news_array['many']);
		$this->smarty->assign('newsarray', $news_array);
		$this->smarty->assign('pages', $pagesnav_array);

	}


	/**
	 * Fuegt einen Eintrag ein oder liefert das Formular dazu
	 *
	 */

	private function add()
	{

		global $gbook_entry_name, $gbook_entry_content, $gbook_entry_email, $gbook_entry_hp, $gbook_entry_title;

		//Eingetragen und ueberpruefen
		if (isset($this->post_arr['btn_send']) && $this->post_arr['btn_send'] == 'Senden') {

			$answer = "";


			$entry= array('content' => $this->post_arr['content'], 'name' => $this->post_arr['name'], 'mail' => $this->post_arr['email'], 'hp' => $this->post_arr['hp'], 'title' => $this->post_arr['title']);
			$std = array('content' => $gbook_entry_content, 'name' => $gbook_entry_name, 'mail' => $gbook_entry_email, 'hp' => $gbook_entry_hp, 'title' => $gbook_entry_title);

			$check = $this->msbox->formCheck($entry, $std);

			foreach ($check as $key => $value) {
				if ($key != 'hp') {
					switch ($value) {
						case MSGBOX_FORMCHECK_NONE:
							$answer .= ucfirst($key).": leer oder Standartwert - ".var_export($value, 1)."<br />\n";
							break;
						case MSGBOX_FORMCHECK_INVALID:
							$answer .= ucfirst($key).": ung&uuml;ltig - ".var_export($value, 1)."<br />\n";
							break;
						default:

					}
				}

			}

			if ($answer == "") {
				$entry['hp'] = $check['hp'];
				$entry['time'] = "NOW()";
				$this->msbox->addEntry($entry);
				$answer = "Eintrag wurde erfolgreich erstellt";
				$title = "Eintrag erstellt";
				$link = Page::getUriStatic($this->get_arr, array('action'));
				$linktext = 'Angugcken';

			} else {
				$link = Page::getUriStatic($this->get_arr);
				$linktext = 'Zurueck';
				$title = 'ungueltige Angaben';

				$this->smarty->assign('SEND_FORMS', true);
				$form = array('content' => $this->post_arr['content'], 'name' => $this->post_arr['name'], 'email' => $this->post_arr['email'], 'hp' => $this->post_arr['hp'], 'title' => $this->post_arr['title']);
				$this->smarty->assign('form_array', $form);
			}


			$this->smarty->assign('feedback_title', $title);
			$this->smarty->assign("feedback_content", $answer);
			$this->smarty->assign("feedback_linktext", $linktext);
			$this->smarty->assign("feedback_link", 'http://'.$link);
			$this->tplfile ='feedback.tpl';

		} elseif (isset($this->post_arr['weiter'])) {

			$smarty_arr = array('entry_name' => $this->post_arr['name'], 'entry_content' => $this->post_arr['content'],
			'entry_email' => $this->post_arr['email'], 'entry_hp' => $this->post_arr['hp'], 'entry_title' => 									$this->post_arr['title']);

			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);

			$this->tplfile = 'news_entry.tpl';
			$this->smarty->assign($smarty_arr);
			$this->smarty->assign('action', $this->get_arr['action']);
			$this->smarty->assign('smilies_list', $smilie_arr);

		} else {


			$smarty_arr = array('entry_name' => $gbook_entry_name, 'entry_content' => $gbook_entry_content,
			'entry_email' => $gbook_entry_email, 'entry_hp' => $gbook_entry_hp, 'entry_title' => 									$gbook_entry_title);
			$this->tplfile = 'news_entry.tpl';
			$this->smarty->assign('action', $this->get_arr['action']);
			$this->smarty->assign($smarty_arr);
			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);
			$this->smarty->assign('smilies_list', $smilie_arr);
		}


	}
	
	/**
	 * Kommentarfunktion dieser Klasse
	 *
	 */
	
	private function comment()
	{
		
	}

	/**
	 * Editiert einen Eintrag im Mysql oder liefert das zugehoerige Formular
	 *
	 */

	private function edit()
	{

		global $gbook_entry_name, $gbook_entry_content, $gbook_entry_email, $gbook_entry_hp, $gbook_entry_title;

		//Eingetragen und ueberpruefen
		if (isset($this->post_arr['btn_send']) && $this->post_arr['btn_send'] == 'Senden') {

			$answer = "";


			$entry= array('content' => $this->post_arr['content'], 'name' => $this->post_arr['name'], 'mail' => $this->post_arr['email'], 'hp' => $this->post_arr['hp'], 'title' => $this->post_arr['title'], 'ID' => $this->get_arr['id']);
			$std = array('content' => $gbook_entry_content, 'name' => $gbook_entry_name, 'mail' => $gbook_entry_email, 'hp' => $gbook_entry_hp, 'title' => $gbook_entry_title);

			$check = $this->msbox->formCheck($entry, $std);

			foreach ($check as $key => $value) {
				if ($key != 'hp') {
					switch ($value) {
						case MSGBOX_FORMCHECK_NONE:
							$answer .= ucfirst($key).": leer oder Standartwert - ".var_export($value, 1)."<br />\n";
							break;
						case MSGBOX_FORMCHECK_INVALID:
							$answer .= ucfirst($key).": ung&uuml;ltig - ".var_export($value, 1)."<br />\n";
							break;
						default:

					}
				}

			}

			if ($answer == "") {
				$entry['hp'] = $check['hp'];

				//In Datenbank einschreiben
				$this->msbox->editEntry($entry);

				//Angaben fuer Benutzer
				$answer = "Eintrag wurde erfolgreich ver&auml;ndert";
				$title = "Eintrag erstellt";
				$link = Page::getUriStatic($this->get_arr, array('action'));
				$linktext = 'Angugcken';

			} else {
				$link = Page::getUriStatic($this->get_arr);
				$linktext = 'Zurueck';
				$title = 'ungueltige Angaben';


				//Daten mittels Forumlar weiterschicken, um sie wiederzuverwenden
				$this->smarty->assign('SEND_FORMS', true);
				$form = array('content' => $this->post_arr['content'], 'name' => $this->post_arr['name'], 'email' => $this->post_arr['email'], 'hp' => $this->post_arr['hp'], 'title' => $this->post_arr['title']);
				$this->smarty->assign('form_array', $form);
			}

			//Smarty-Ausgabe
			$this->smarty->assign('feedback_title', $title);
			$this->smarty->assign("feedback_content", $answer);
			$this->smarty->assign("feedback_linktext", $linktext);
			$this->smarty->assign("feedback_link", 'http://'.$link);
			$this->tplfile ='feedback.tpl';

		} elseif (isset($this->post_arr['weiter'])) {

			//Daten fuer Smarty, werden von POST-Formular uebernommen
			$smarty_arr = array('entry_name' => $this->post_arr['name'], 'entry_content' => $this->post_arr['content'],
			'entry_email' => $this->post_arr['email'], 'entry_hp' => $this->post_arr['hp'], 'entry_title' => 									$this->post_arr['title']);

			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);

			$this->tplfile = 'news_entry.tpl';
			$this->smarty->assign($smarty_arr);
			$this->smarty->assign('action', $this->get_arr['action']."&id={$this->get_arr['id']}");
			$this->smarty->assign('smilies_list', $smilie_arr);

		} else {

			$this->tplfile = 'news_entry.tpl';
			//Action an Template mitteilen, zur Anpassung des Formulars
			$this->smarty->assign('action', $this->get_arr['action']."&id={$this->get_arr['id']}");

			//Daten aus dem msbox-Objekt holen
			$news_arr = $this->msbox->getEntry($this->get_arr['id'], '%e.%m.%Y %k:%i');

			$smarty_arr = array('entry_ID' => $this->get_arr['id'], 'entry_name' => $news_arr['news_name'], 'entry_content' => $news_arr['news_content'],
			'entry_email' => $news_arr['news_email'], 'entry_hp' => $news_arr['news_hp'], 'entry_title' => 									$news_arr['news_title'], 'entry_time' => $news_arr['time']);

			$this->smarty->assign($smarty_arr);
			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);
			$this->smarty->assign('smilies_list', $smilie_arr);

		}

	}

	/**
	 * Loescht einen Eintrag im Mysql oder liefert die Auswahlliste.
	 *
	 */

	private function del()
	{
		$linktext = "JA";
		$linktext2 = "NEIN";
		//Bestaetigung zum Loeschen geklickt
		if (isset($this->post_arr['weiter']) && $this->post_arr['weiter'] == $linktext && isset($this->post_arr['del_ID'])) {
			$this->msbox->delEntry((int)$this->post_arr['del_ID']);
			$title = "Loeschung erfolgreich";
			$msg = "Nachricht wurde erfolgreich geloescht";
			$linktext = "Zu den News";
			$link = Page::getUriStatic($this->get_arr, array('action'));
			
		} elseif (isset($this->post_arr['rauf']) && $this->post_arr['rauf'] == $linktext2 && isset($this->post_arr['del_ID'])) {
			$title = "Loeschung abgebrochen";
			$msg = "Sie haben die Loeschung der Nachricht abgebrochen";
			$linktext = "Zu den News";
			$link = Page::getUriStatic($this->get_arr, array('action'));
			
		} elseif (isset($this->get_arr['id'])) {
			$id = (int)$this->get_arr['id'];
			$title = "<b>Loeschung</b> bestaetigen";
			$msg = "<form>\n\t<fieldset>\n\t<legend>Nachricht</legend>\n<br />\n";
			$nr = $this->msbox->getEntry($id);
			$msg .= $this->smilie->show_smilie($nr['news_content'], $this->mysql);
			$msg .= "\n\t</fieldset>\n</form>";
			$msg .= "Wollen Sie die <b>Nachricht</b> mit der ID $id <b>wirklich loeschen</b>?<br />\nDie Loeschung ist UNWIDERRUFLICH!<br />";
			
			$this->smarty->assign("SEND_FORMS", true);
			$this->smarty->assign("SE_SUB", true);
			$this->smarty->assign("feedback_linktext2", $linktext2);
			$this->smarty->assign("form_array", array('del_ID' => $id));
			
			$link = Page::getUriStatic($this->get_arr, array('id'));
		} else {
			$title = "Falscher Aufruf";
			$msg = "Sie haben einen Link aufgerufen, der nicht gueltig ist!!";
			$linktext = "Zu den News";
			$link = Page::getUriStatic($this->get_arr, array('action'));
		}

		$this->smarty->assign('feedback_title', $title);
		$this->smarty->assign("feedback_content", $msg);
		$this->smarty->assign("feedback_linktext", $linktext);
		$this->smarty->assign("feedback_link", 'http://'.$link);
		$this->tplfile ='feedback.tpl';
	}

	//	/**
	//	 * Wird von den Methoden aufgerufen. Gibt einen Fehler in HTML aus.
	//	 *
	//	 * @param int $line
	//	 * @param string $errortext
	//	 * @param string[optional] $errortitle
	//	 */
	//
	//	private function error($line, $errortext, $errortitle = "Fehler")
	//	{
	//		$this->tplfile = 'error_include.tpl';
	//
	//		if (is_string($errortext) && !empty($errortext)) {
	//
	//			$errortitle = $errortitle;
	//			$errortext = $errortext."<br />\nInfo: Fehler auf Zeile $line";
	//
	//		} elseif (is_array($errortext)) {
	//			$errortitle = $errortext['title'];
	//			$errortext = $errortext['text']."<br />\nInfo: Fehler auf Zeile $line";
	//
	//		} else {
	//			$errortitle = "Fehler";
	//			$errortext = "Sie oder das Skript haben ein Fehler verursacht. Die Aktion wurde daher abgebrochen<br />\nInfo: Fehler auf Zeile $line";
	//
	//		}
	//
	//		$this->smarty->assign(array('error_title' => $errortitle, 'error_text' => $errortext));
	//	}

}

?>