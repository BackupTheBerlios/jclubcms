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
		//Daten initialisieren
		global $dir_smilies;
		$this->_gpc['POST'] = $gpc['POST'];
		$this->_gpc['GET'] = $gpc['GET'];


		$this->_msbox = new Messageboxes($this->_mysql, 'news', array('ID' => 'news_ID', 'ref_ID' => 'news_ref_ID', 'content' => 'news_content', 'name' => 'news_name', 'time' => 'news_time', 'email' => 'news_email', 'hp' => 'news_hp', 'title' => 'news_title'));

		$this->_smilie = new Smilies($dir_smilies);

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
					throw new CMSException("Sie haben falsche URL-Parameter weitergegeben. Daher konnte keine entsprechende Aktion ausgef&uuml;hrt werden", EXCEPTION_MODULE_CODE);
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
	 * Zeigt die Einträge an
	 *
	 * @param int $max_entries_pp Anzahl Einträge pro Seite
	 */

	private function _view($max_entries_pp)
	{

		//Daten definiere und initialisieren
		$this->_tplfile = 'news.tpl';
		$news_array = array();
		$error = false;

		//Seite herausfinden
		if (isset($this->_gpc['GET']['page']) && is_numeric($this->_gpc['GET']['page']) && $this->_gpc['GET']['page'] > 0) {
			$page = $this->_gpc['GET']['page'];
		} else {
			$page = 1;
		}

		//Daten holen
		$news_array = $this->_msbox->getEntries($max_entries_pp, $page, 'DESC','ASC', $this->_timeformat);
		$this->_mysql->query('SELECT COUNT(*) as many FROM `news` WHERE `news_ref_ID` = \'0\'');
		$entries = $this->_mysql->fetcharray('num');

		$pagesnav_array = Page::get_static_pagesnav_array($entries[0],$max_entries_pp, $this->_gpc['GET']);


		$this->_smarty->assign('entrys', $entries[0]);
	
		foreach ($news_array as $key => $value) {

			$value['news_content'] = $this->_smilie->show_smilie($value['news_content'], $this->_mysql);

			foreach ($value['comments'] as $ckey => $cvalue) {
				$value['comments'][$ckey]['news_content'] = $this->_smilie->show_smilie($cvalue['news_content'], $this->_mysql);
			}

			$news_array[$key] = $value;

		}

		$this->_smarty->assign('newsarray', $news_array);
		$this->_smarty->assign('pages', $pagesnav_array);

	}


	/**
	 * Fuegt einen Eintrag ein oder liefert das Formular dazu
	 *
	 */

	private function _add()
	{

		//Eingetragen und ueberpruefen
		if (isset($this->_gpc['POST']['btn_send']) && $this->_gpc['POST']['btn_send'] == 'Senden') {

			$answer = "";

			$entry = $this->_getPostVars();

			$check = $this->_exefcheck($entry);
			$answer = $this->_fcheck2answer($check);

			if ($answer == "") {
				$entry['hp'] = $check['hp'];
				$entry['time'] = "NOW()";
				$this->_msbox->addEntry($entry);
				$answer = "Eintrag wurde erfolgreich erstellt";
				$title = "Eintrag erstellt";
				$link = Page::getUriStatic($this->_gpc['GET'], array('action'));
				$linktext = 'Angugcken';

				$this->_smarty->assign('feedback_title', $title);
				$this->_smarty->assign("feedback_content", $answer);
				$this->_smarty->assign("feedback_linktext", $linktext);
				$this->_smarty->assign("feedback_link", 'http://'.$link);
				$this->_tplfile ='feedback.tpl';

			} else {

				$this->_tplfile ='news_entry.tpl';

				$title = 'ungueltige Angaben';

				$this->_smarty->assign('dump_errors', true);
				$this->_smarty->assign('error_title', $title);
				$this->_smarty->assign('error_content', $answer);

				$smarty_arr = $this->_getSmartyVars('post');

				$this->_smarty->assign('action', $this->_gpc['GET']['action']);
				$this->_smarty->assign($smarty_arr);
				$smilie_arr = $this->_smilie->create_smiliesarray($this->_mysql);
				$this->_smarty->assign('smilies_list', $smilie_arr);
			}

		} else {

			$smarty_arr = $this->_getSmartyVars('std');

			$this->_tplfile = 'news_entry.tpl';
			$this->_smarty->assign('action', $this->_gpc['GET']['action']);
			$this->_smarty->assign($smarty_arr);
			$smilie_arr = $this->_smilie->create_smiliesarray($this->_mysql);
			$this->_smarty->assign('smilies_list', $smilie_arr);
		}


	}

	/**
	 * Kommentarfunktion dieser Klasse
	 *
	 */

	private function _comment()
	{
		if (isset($this->_gpc['POST']['btn_send']) && $this->_gpc['POST']['btn_send'] == 'Senden') {

			$answer = "";
			$entry = $this->_getPostVars();
			unset($entry['title']);
			$check = $this->_exefcheck($entry);
			$answer = $this->_fcheck2answer($check);
			var_dump($answer);

			if ($answer == "") {
				$entry['hp'] = $check['hp'];
				$entry['time'] = "NOW()";
				$this->_msbox->commentEntry((int)$this->_gpc['GET']['ref_ID'], $entry);
				$answer = "Eintrag wurde erfolgreich erstellt";
				$title = "Eintrag erstellt";
				$link = Page::getUriStatic($this->_gpc['GET'], array('action'));
				$linktext = 'Angugcken';

				$this->_smarty->assign('feedback_title', $title);
				$this->_smarty->assign("feedback_content", $answer);
				$this->_smarty->assign("feedback_linktext", $linktext);
				$this->_smarty->assign("feedback_link", 'http://'.$link);
				$this->_tplfile ='feedback.tpl';

				//Falsche Eintraege
			} else {

				$news = $this->_msbox->getEntry($this->_gpc['GET']['ref_ID'], $this->_timeformat);
				$news['news_content'] = $this->_smilie->show_smilie($news['news_content'], $this->_mysql);
				$news['ID'] = $this->_gpc['GET']['ref_ID'];

				$this->_tplfile ='news_comment.tpl';

				$title = 'ungueltige Angaben';

				$this->_smarty->assign('news', $news);

				$this->_smarty->assign('dump_errors', true);
				$this->_smarty->assign('error_title', $title);
				$this->_smarty->assign('error_content', $answer);

				$smarty_arr = $this->_getSmartyVars('post');

				$this->_smarty->assign('action', $this->_gpc['GET']['action']);
				$this->_smarty->assign($smarty_arr);
				$smilie_arr = $this->_smilie->create_smiliesarray($this->_mysql);
				$this->_smarty->assign('smilies_list', $smilie_arr);
			}

			//1. Aufruf des Formulars
		} else {
			$news = $this->_msbox->getEntry($this->_gpc['GET']['ref_ID'], $this->_timeformat);
			$news['news_content'] = $this->_smilie->show_smilie($news['news_content'], $this->_mysql);
			$news['ID'] = $this->_gpc['GET']['ref_ID'];

			$this->_tplfile ='news_comment.tpl';
			
			$this->_smarty->assign('news', $news);

			$smarty_arr = $this->_getSmartyVars('std');

			$this->_smarty->assign('action', $this->_gpc['GET']['action']);
			$this->_smarty->assign($smarty_arr);
			$smilie_arr = $this->_smilie->create_smiliesarray($this->_mysql);
			$this->_smarty->assign('smilies_list', $smilie_arr);
		}
	}

	/**
	 * Editiert einen Eintrag im Mysql oder liefert das zugehoerige Formular
	 *
	 */

	private function _edit()
	{



		//Eingetragen und ueberpruefen
		if (isset($this->_gpc['POST']['btn_send']) && $this->_gpc['POST']['btn_send'] == 'Senden') {

			$answer = "";

			$entry = $this->_getPostVars();

			$check = $this->_exefcheck($entry);
			$answer = $this->_fcheck2answer($check);



			//Keine Antwort -> korrekte Daten
			if ($answer == "") {

				//Angepasster (wenn überhaupt) hp-string speichern
				$entry['hp'] = $check['hp'];

				//In Datenbank einschreiben
				$this->_msbox->editEntry($entry);

				//Angaben fuer Benutzer
				$answer = "Eintrag wurde erfolgreich ver&auml;ndert";
				$title = "Eintrag ver&auml;ndert";
				$link = Page::getUriStatic($this->_gpc['GET'], array('action'));
				$linktext = 'Angugcken';

				/* Smarty-Werte */
				$this->_tplfile ='feedback.tpl';

				$this->_smarty->assign('feedback_title', $title);
				$this->_smarty->assign("feedback_content", $answer);
				$this->_smarty->assign("feedback_linktext", $linktext);
				$this->_smarty->assign("feedback_link", 'http://'.$link);


				//Dateneingaben waren fehlerhaft
			} else {

				//Action an Template mitteilen, zur Anpassung des Formulars


				$news_arr = $this->_msbox->getEntry($this->_gpc['GET']['ref_ID'], $this->_timeformat);

				$smarty_arr = $this->_getSmartyVars('post');
				$smarty_arr['entry_time'] = $news_arr['time'];

				$title = 'ung&uuml;ltige Angaben';

				$this->_tplfile ='news_entry.tpl';

				$this->_smarty->assign($smarty_arr);

				$this->_smarty->assign('dump_errors', true);
				$this->_smarty->assign('error_title', $title);
				$this->_smarty->assign('error_content', $answer);

				$this->_smarty->assign('action', $this->_gpc['GET']['action']."&id={$entry['ID']}");

				$smilie_arr = $this->_smilie->create_smiliesarray($this->_mysql);
				$this->_smarty->assign('smilies_list', $smilie_arr);
			}

			//1. Aufruf des Editier-Formulars
		} else {

			$this->_tplfile = 'news_entry.tpl';
			//Action an Template mitteilen, zur Anpassung des Formulars
			$this->_smarty->assign('action', $this->_gpc['GET']['action']);

			//Daten aus dem msbox-Objekt holen
			$news_arr = $this->_msbox->getEntry($this->_gpc['GET']['ref_ID'], $this->_timeformat);

			//Template-Daten erstellen
			$smarty_arr = array('entry_ID' => $this->_gpc['GET']['ref_ID'], 'entry_name' => $news_arr['news_name'],
			'entry_content' => $news_arr['news_content'], 'entry_email' => $news_arr['news_email'],
			'entry_hp' => $news_arr['news_hp'], 'entry_title' => $news_arr['news_title'], 'entry_time' => $news_arr['time']);

			$this->_smarty->assign($smarty_arr);
			$smilie_arr = $this->_smilie->create_smiliesarray($this->_mysql);
			$this->_smarty->assign('smilies_list', $smilie_arr);

		}

	}

	/**
	 * Loescht einen Eintrag im Mysql oder liefert die Auswahlliste.
	 *
	 */

	private function _del()
	{
		$linktext = "JA";
		$linktext2 = "NEIN";

		//Bestaetigung zum Loeschen geklickt
		if (isset($this->_gpc['POST']['weiter']) && $this->_gpc['POST']['weiter'] == $linktext && isset($this->_gpc['POST']['del_ID'])) {
			$this->_msbox->delEntry((int)$this->_gpc['POST']['del_ID']);
			$title = "Loeschung erfolgreich";
			$msg = "Nachricht wurde erfolgreich geloescht";
			$linktext = "Zu den News";
			$link = Page::getUriStatic($this->_gpc['GET'], array('action'));

			//Abbruch der Loeschung
		} elseif (isset($this->_gpc['POST']['nein']) && $this->_gpc['POST']['nein'] == $linktext2 && isset($this->_gpc['POST']['del_ID'])) {
			$title = "Loeschung abgebrochen";
			$msg = "Sie haben die Loeschung der Nachricht abgebrochen";
			$linktext = "Zu den News";
			$link = Page::getUriStatic($this->_gpc['GET'], array('action'));

			//Aufruf des Loeschvorgangs
		} elseif (isset($this->_gpc['GET']['ref_ID'])) {
			$id = (int)$this->_gpc['GET']['ref_ID'];
			$title = "<b>Loeschung</b> bestaetigen";
			$msg = "<form>\n\t<fieldset>\n\t<legend>Nachricht</legend>\n<br />\n";
			$nr = $this->_msbox->getEntry($id);
			$msg .= $this->_smilie->show_smilie($nr['news_content'], $this->_mysql);
			$msg .= "\n\t</fieldset>\n</form>";
			$msg .= "Wollen Sie die <b>Nachricht</b> mit der ID $id mit allen <b>Kommentaren(!) wirklich loeschen</b>?<br />\nDie Loeschung ist UNWIDERRUFLICH!<br />";

			$this->_smarty->assign("SEND_FORMS", true);
			$this->_smarty->assign("SE_SUB", true);
			$this->_smarty->assign("feedback_linktext2", $linktext2);
			$this->_smarty->assign("form_array", array('del_ID' => $id));

			$link = Page::getUriStatic($this->_gpc['GET'], array('id'));

			//Ungueltiger Aufruf
		} else {
			$title = "Falscher Aufruf";
			$msg = "Sie haben einen Link aufgerufen, der nicht gueltig ist!!";
			$linktext = "Zu den News";
			$link = Page::getUriStatic($this->_gpc['GET'], array('action'));
		}

		$this->_smarty->assign('feedback_title', $title);
		$this->_smarty->assign("feedback_content", $msg);
		$this->_smarty->assign("feedback_linktext", $linktext);
		$this->_smarty->assign("feedback_link", 'http://'.$link);
		$this->_tplfile ='feedback.tpl';
	}



	/**
	 * * * * * * * * * * * * * * * * * * * * * *
	 * Einige nützliche Funktionen kommen jetzt
	 * * * * * * * * * * * * * * * * * * * * * *
	 */



	/**
	 * Fuehrt msbox::formCheck aus. Der 1. Parameter enthaelt die Daten; ist er nicht angegeben, werden die Daten 
	 * aus dem Post-Formular geholt. Der 2. Parameter enthaelt die Standartwerten; ist er nicht angegeben, werden die 
	 * Daten aus der gbook_textes-Datei geholt
	 *
	 * @param array $data Daten
	 * @param array $std Standartwerte
	 * @return array $check Antwort von msbox::formcheck
	 */

	private function _exefcheck(array $data = null, array $std = null)
	{
		global $gbook_entry_name, $gbook_entry_content, $gbook_entry_email, $gbook_entry_hp, $gbook_entry_title;

		if ($data == null) {
			$data = $this->_getPostVars();
			$data['ID'] = $this->_gpc['GET']['ref_ID'];
		}

		if ($std == null) {
			$std = array('content' => $gbook_entry_content, 'name' => $gbook_entry_name, 'email' => $gbook_entry_email, 'hp' => $gbook_entry_hp, 'title' => $gbook_entry_title);
		}

		$check = $this->_msbox->formCheck($data, $std);
		return $check;
	}


	/**
	 * Erstellt aus den Rueckgabewerten von msbox::formcheck eine Antwort
	 *
	 * @param array $check Rueckgabewerf von msbox::formcheck
	 * @return string $answer Antwort
	 */

	private function _fcheck2answer(array $check)
	{
		$answer = "";
		foreach ($check as $key => $value) {
			if ($key != 'hp') {
				switch ($value) {
					case MSGBOX_FORMCHECK_NONE:
						$answer .= ucfirst($key).": leer oder Standartwert - ".var_export($value, 1)."<br />\n";
						break;
					case MSGBOX_FORMCHECK_INVALID:
						$answer .= ucfirst($key).": ung&uuml;ltig - ".var_export($value, 1)."<br />\n";
						break;
					case MSGBOX_FORMCHECK_OK:
						break;
					default:
						throw new CMSException('Ungueltiger Rueckgabewert der msbox-Klasse', EXCEPTION_MODULE_CODE);

				}
			}

		}

		return $answer;
	}


	/**
	 * Gibt ein Array mit den Smarty-Entry-Variablen zurueck. Die Werte werden je nach $mode
	 * mit den Standartdaten belegt oder aus den Post-Formular-Daten geholt
	 * Keys: entry_ID (hoechstens bei post), entry_name, entry_content entry_email, entry_hp, entry_title;
	 *
	 * @param string $mode 'std'|'post'
	 * @return array Smarty-Array
	 */

	private function _getSmartyVars($mode = 'std')
	{
		global $gbook_entry_name, $gbook_entry_content, $gbook_entry_email, $gbook_entry_hp, $gbook_entry_title;

		switch ($mode) {
			//Standartwerte
			case 'std':
				$arr =  array('entry_name' => $gbook_entry_name, 'entry_content' => $gbook_entry_content,
				'entry_email' => $gbook_entry_email, 'entry_hp' => $gbook_entry_hp, 'entry_title' => 									$gbook_entry_title);
				break;

				//Post-Variablen
			case 'post':

				$entry = $this->_getPostVars();

				if (array_key_exists('ID', $entry)) {
					$arr['entry_ID'] = $entry['ID'];
				}

				$arr = array('entry_name' => $entry['name'], 'entry_content' => $entry['content'], 'entry_email' => $entry['email'], 'entry_hp' => $entry['hp'], 'entry_title' => $entry['title']);

				break;

			default:
				throw new CMSException('Ungueltiger Parameter', EXCEPTION_MODULE_CODE);
				break;
		}

		return $arr;
	}


	/**
	 * Gibt die Post-Daten aus dem Formular zurueck:
	 * ID (wenn vorhanden), content, name, email, hp, title sind die Keys
	 *
	 * @return array $entry Daten
	 */

	private function _getPostVars()
	{
		$entry = array('content' => $this->__gpc['POST']['content'], 'name' => $this->_gpc['POST']['name'], 'email' => $this->_gpc['POST']['email'], 'hp' => $this->_gpc['POST']['hp'], 'title' => $this->_gpc['POST']['title']);
		
		if (array_key_exists('ID', $this->_gpc['POST'])) {
			$entry['ID'] = $this->_gpc['POST']['ID'];
		}

		return $entry;
	}
	
	/**
	 * Kontrolliert das Formular auf Standarteinträge und richtige Mailmuster.
	 * Ist alles ordnungsgemäss, wird true zurückgegeben, sonst false. Bei false finden sich die Mängel
	 * in $answer.
	 *
	 * @param array[reference] $answer Antwort
	 * @param array $blacklist Array der Schlüssel, die nicht geprüft werden sollen
	 * @return boolean Erfolg
	 */
	private function _check_form(&$answer, $blacklist = null)
	{
		$gbook_vars = $this->_configvars['Gbook'];
		$error_vars =$this->_configvars['Error'];

		/* Formularcheck vorbereiten */
		$formcheck = new Formularcheck();

		/*Formulardaten */
		$val = array('title' => $this->_gpc['POST']['title'], 'content' => $this->_gpc['POST']['content'],
		'name' =>  $this->_gpc['POST']['name'], 'email' => $this->_gpc['POST']['email']);
		/* Standart-Strings*/
		$std = array('title' => $gbook_vars['entry_title'], 'content' => $gbook_vars['entry_content'],
		'name' => $gbook_vars['entry_name'],'email' => $gbook_vars['entry_email']);
		/* Error-Strings */
		$err = array('title' => $error_vars['title_error'], 'content' => $error_vars['content_error'],
		'name' => $error_vars['name_error'],'email' => $error_vars['email_error']);

		/* Unerwünschte Schlüssel nicht kontrollieren und speichern */
		if (!empty($blacklist) && is_array($blacklist)) {
			foreach ($blacklist as $value) {
				unset($val[$value], $std[$value], $err[$value]);
			}
		}
		
		
		/*$rtn_arr = $formcheck->field_check_arr($val, $std)*/
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
			/*Wenn keine Fehler aufgetaucht sind, werden die Einträge zurückgegeben*/
			$answer = array('content' => $this->_gpc['POST']['content'], 'name' => $this->_gpc['POST']['name'],
			'time' => 'gbook_time', 'email' => $this->_gpc['POST']['email'], 'hp' => $this->_gpc['POST']['hp'],
			'title' => $this->_gpc['POST']['title']);
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
			$data +=array('entry_title' => stripslashes($this->_gpc['POST']['title']),
			'entry_content' => stripslashes($this->_gpc['POST']['content']), 'entry_name' => stripslashes($this->_gpc['POST']['name']),
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

			$this->_tplfile = "gbook_new_comment.tpl";
			
			$data['gbook'] = $this->_msbox->getEntry($this->_gpc['GET']['ref_ID'], $this->_timeformat);
			
			$data['gbook']['gbook_title'] = htmlentities($data['gbook']['gbook_title']);
			$data['gbook']['gbook_content'] = htmlentities($data['gbook']['gbook_content']);
			$data['gbook']['gbook_email'] = htmlentities($data['gbook']['gbook_email']);
			$data['gbook']['gbook_hp'] = htmlentities($data['gbook']['gbook_hp']);
			
			$data['gbook']['gbook_content'] = $this->_smilie->show_smilie($data['gbook']['gbook_content'], $this->_mysql);
			
			/* HTML-Zeichen umwandeln */
			foreach($data['gbook']['comments'] as $key => $value) {
				
				$data['gbook']['comments'][$key]['gbook_content'] = htmlentities($value['gbook_content']);
				$data['gbook']['comments'][$key]['gbook_email'] = htmlentities($value['gbook_email']);
				$data['gbook']['comments'][$key]['gbook_hp'] = htmlentities($value['gbook_hp']);
				
				$data['gbook']['comments'][$key]['gbook_content'] =  $this->_smilie->show_smilie($data['gbook']['comments'][$key]['gbook_content'], $this->_mysql); 
			}
			
			/*Anzeigetitle des Editors festlegen */
			$data['entry_title'] = 'RE: '.$data['gbook']['gbook_title'];

		} else {
			/* Keine Kommentareintrag -> Normaler Editor */
			$this->_tplfile = "gbook_new_entry.tpl";
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