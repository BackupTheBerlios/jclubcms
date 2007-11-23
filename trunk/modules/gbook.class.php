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
	 * @var smilies
	 */
	private $_smilie = null;
	private $_post_arr = array();
	private $_get_arr = array();
	/**
	 * Messagebox Klasse
	 *
	 * @var Messageboxes
	 */
	private $_msbox = null;

	private $_timeformat = '%e.%m.%Y %k:%i';

	/**
	 * Aufbau der Klasse
	 *
	 * @param object $mysql Mysql-Objekt
	 * @param object $smarty Smarty-Objekt
	 */

	public function __construct($mysql, $smarty)
	{
		$this->_mysql = $mysql;
		$this->_smarty = $smarty;
	}


	/**
	 * Führt die einzelnen Methoden aus, abhängig vom Parameter
	 *
	 * @param array $parameters $_POST- und $_GET-Arrays
	 */
	public function action($gpc)
	{
		global $dir_smilies;
		$this->_post_arr = $gpc['POST'];
		$this->_get_arr = $gpc['GET'];

		$this->_msbox = new MessageBoxes($this->_mysql, 'gbook', array('ID' => 'gbook_ID', 'ref_ID' => 'gbook_ref_ID', 'content' => 'gbook_content', 'name' => 'gbook_name', 'time' => 'gbook_time', 'email' => 'gbook_email', 'hp' => 'gbook_hp', 'title' => 'gbook_title'));

		$this->_smilie = new smilies($dir_smilies);

		if (isset($this->_get_arr['action'])) {
			switch ($this->_get_arr['action']) {
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

		if (isset($this->_get_arr['page']) && is_numeric($this->_get_arr['page']) && $this->_get_arr['page'] > 0) {
			$page = $this->_get_arr['page'];
		} else {
			$page = 1;
		}

		$gbook_array = $this->_msbox->getEntries($max_entries_pp, $page, 'DESC', 'ASC', $this->_timeformat);
		$this->_mysql->query('SELECT COUNT(*) as many FROM `gbook` WHERE `gbook_ref_ID` = \'0\'');
		$data = $this->_mysql->fetcharray('assoc');



		$pagesnav_array = Page::get_static_pagesnav_array($data['many'],$max_entries_pp, $this->_get_arr);

		$gbook_smarty_array = array();

		//Inhalt parsen (Smilies) und an Smarty-Array übergeben
		foreach ($gbook_array as $key => $value) {

			//Nur gbook-Daten ohne $gbook_array['many'] abchecken
			if ($key !== 'many') {
				$value['gbook_content'] = $this->_smilie->show_smilie($value['gbook_content'], $this->_mysql);

				$gbook_smarty_array[$key] = array('ID' => $value['gbook_ID'], 'title' => $value['gbook_title'], 'content' => $value['gbook_content'], 'name' => $value['gbook_name'], 'time' => $value['time'], 'email' => $value['gbook_email'], 'hp' => $value['gbook_hp']);

				//Kommentare durchackern
				foreach ($value['comments'] as $ckey => $cvalue) {
					$value['comments'][$ckey]['gbook_content'] = $this->_smilie->show_smilie($cvalue['gbook_content'], $this->_mysql);

					$gbook_smarty_array[$key]['comments'][$ckey] = array('ID' => $cvalue['gbook_ID'], 'title' => $cvalue['gbook_title'], 'content' => $cvalue['gbook_content'], 'name' => $cvalue['gbook_name'], 'time' => $cvalue['time'], 'email' => $cvalue['gbook_email'], 'hp' => $cvalue['gbook_hp']);

				}

				$gbook_array[$key] = $value;
			}
		}

		$this->_smarty->assign('gbook', $gbook_smarty_array);
		$this->_smarty->assign('pages', $pagesnav_array);
		$this->_smarty->assign('entrys', $data['many']);

	}

	/**
	 * Fügt einen Eintrag hinzu oder liefert das Forumular dazu
	 *
	 */

	private function _add()
	{
		global $gbook_entry_name, $gbook_entry_content, $gbook_entry_email, $gbook_entry_hp, $gbook_entry_title;

		//Eingetragen und überprüfen
		if (isset($this->_post_arr['btn_send']) && $this->_post_arr['btn_send'] == 'Senden') {

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
				$link = Page::getUriStatic($this->_get_arr, array('action'));
				$linktext = 'Angugcken';

				$this->_smarty->assign('feedback_title', $title);
				$this->_smarty->assign("feedback_content", $answer);
				$this->_smarty->assign("feedback_linktext", $linktext);
				$this->_smarty->assign("feedback_link", 'http://'.$link);
				$this->_tplfile ='feedback.tpl';

			} else {
				$this->_tplfile ='gbook_entry.tpl';

				$title = 'ungültige Angaben';

				$this->_smarty->assign('dump_errors', true);
				$this->_smarty->assign('error_title', $title);
				$this->_smarty->assign('error_content', $answer);

				$smarty_arr = $this->_getSmartyVars('std');

				$this->_smarty->assign('action', $this->_get_arr['action']);
				$this->_smarty->assign($smarty_arr);
				$smilie_arr = $this->_smilie->create_smiliesarray($this->_mysql);
				$this->_smarty->assign('smilies_list', $smilie_arr);

			}

		} else {
			$smarty_arr = $this->_getSmartyVars('std');

			$this->_tplfile = 'gbook_entry.tpl';
			$this->_smarty->assign('action', $this->_get_arr['action']);
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
		
		if (isset($this->_post_arr['btn_send']) && $this->_post_arr['btn_send'] == 'Senden') {

			$answer = "";
			$entry = $this->_getPostVars();
			unset($entry['title']);
			$check = $this->_exefcheck($entry);
			$answer = $this->_fcheck2answer($check);

			if ($answer == "") {
				$entry['hp'] = $check['hp'];
				$entry['time'] = "NOW()";
				$this->_msbox->commentEntry((int)$this->_get_arr['id'], $entry);
				$answer = "Eintrag wurde erfolgreich erstellt";
				$title = "Eintrag erstellt";
				$link = Page::getUriStatic($this->_get_arr, array('action'));
				$linktext = 'Angugcken';

				$this->_smarty->assign('feedback_title', $title);
				$this->_smarty->assign("feedback_content", $answer);
				$this->_smarty->assign("feedback_linktext", $linktext);
				$this->_smarty->assign("feedback_link", 'http://'.$link);
				$this->_tplfile ='feedback.tpl';

				//Falsche Einträge
			} else {

				$gbook = $this->_msbox->getEntry($this->_get_arr['id'], $this->_timeformat);
				$gbook['gbook_content'] = $this->_smilie->show_smilie($gbook['gbook_content'], $this->_mysql);
				$gbook['ID'] = $this->_get_arr['id'];

				$this->_tplfile ='gbook_comment.tpl';

				$title = 'ungültige Angaben';

				$this->_smarty->assign('gbook', $gbook);

				$this->_smarty->assign('dump_errors', true);
				$this->_smarty->assign('error_title', $title);
				$this->_smarty->assign('error_content', $answer);

				$smarty_arr = $this->_getSmartyVars('post');

				$this->_smarty->assign('action', $this->_get_arr['action']);
				$this->_smarty->assign($smarty_arr);
				$smilie_arr = $this->_smilie->create_smiliesarray($this->_mysql);
				$this->_smarty->assign('smilies_list', $smilie_arr);
			}

			//1. Aufruf des Formulars
		} else {
			$gbook = $this->_msbox->getEntry($this->_get_arr['id'], $this->_timeformat);
			$gbook['gbook_content'] = $this->_smilie->show_smilie($gbook['gbook_content'], $this->_mysql);
			$gbook['ID'] = $this->_get_arr['id'];

			$this->_tplfile ='gbook_comment.tpl';

			$this->_smarty->assign('gbook', $gbook);

			$smarty_arr = $this->_getSmartyVars('std');

			$this->_smarty->assign('action', $this->_get_arr['action']);
			$this->_smarty->assign($smarty_arr);
			$smilie_arr = $this->_smilie->create_smiliesarray($this->_mysql);
			$this->_smarty->assign('smilies_list', $smilie_arr);
		}
	}
}
?>