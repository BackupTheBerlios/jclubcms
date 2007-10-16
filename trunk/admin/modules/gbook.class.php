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

class Gbook implements Module
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
	 * Messagebox Klasse
	 *
	 * @var Messageboxes
	 */
	private $msbox = null;
	
	/**
	 * Aufbau der Klasse
	 *
	 * @param object $mysql Mysql-Objekt
	 * @param object $smarty Smarty-Objekt
	 */

	public function __construct($mysql, $smarty)
	{
		$this->mysql = $mysql;
		$this->smarty = $smarty;
	}

	
	/**
	 * Fuehrt die einzelnen Methoden aus, abhaengig vom parameter
	 *
	 * @param unknown_type $parameters
	 */
	public function action($parameters)
	{
		global $dir_smilies;
		$this->post_arr = $parameters['POST'];
		$this->get_arr = $parameters['GET'];
		
		$this->msbox = new MessageBoxes($this->mysql, 'gbook', array('ID' => 'gbook_ID', 'ref_ID' => 'gbook_ref_ID', 'content' => 'gbook_content', 'name' => 'gbook_name', 'time' => 'gbook_time', 'mail' => 'gbook_email', 'hp' => 'gbook_hp', 'title' => 'gbook_title'));
		
		$this->smilie = new smilies($dir_smilies);
		
		if (isset($this->get_arr['action'])) {
			switch ($this->get_arr['action']) {
				case 'new':
					$this->add();
					return true;
				case 'edit':
					$this->edit();
					return true;
				case 'del':
					$this->del();
					return true;
				case 'view':
					$this->view(5);
					return true;
				case '':
					$this->view(5);
					return true;
				default:
					throw new CMSException('Gewaehlte Option ist nicht moeglich', EXCEPTION_MODULE_CODE);
					return false;
			}
		} else {
			$this->view(5);
			return true;
		}
	}
	
	/**
	 * Liefert die zugehoerige Templatedatei
	 *
	 * @return string $tplfile Templatedatei
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
		$this->tplfile = 'gbook.tpl';
		$gbook_array = array();
		
		if (isset($this->get_arr['page']) && is_numeric($this->get_arr['page']) && $this->get_arr['page'] > 0) {
			$page = $this->get_arr['page'];
		} else {
			$page = 1;
		}

		$gbook_array = $this->msbox->getEntries($max_entries_pp, $page, 'DESC', 'ASC', '%e.%m.%Y %k:%i');
		$this->mysql->query('SELECT COUNT(*) as many FROM `gbook` WHERE `gbook_ref_ID` = \'0\'');
		$data = $this->mysql->fetcharray('assoc');
		
		
		
		$pagesnav_array = Page::get_static_pagesnav_array($data['many'],$max_entries_pp, $this->get_arr);

		$gbook_smarty_array = array();
		
		//Inhalt parsen (Smilies) und an Smarty-Array uebergeben
		foreach ($gbook_array as $key => $value) {
			$value['gbook_content'] = $this->smilie->show_smilie($value['gbook_content'], $this->mysql);
			
			$gbook_smarty_array[$key] = array('ID' => $value['gbook_ID'], 'title' => $value['gbook_title'], 'content' => $value['gbook_content'], 'name' => $value['gbook_name'], 'time' => $value['time'], 'mail' => $value['gbook_ID'], 'hp' => $value['gbook_hp']);
			
			//Kommentare durchackern
			foreach ($value['comments'] as $ckey => $cvalue) {
				$value['comments'][$ckey]['gbook_content'] = $this->smilie->show_smilie($cvalue['gbook_content'], $this->mysql);
				
				$gbook_smarty_array[$key]['comments'][$ckey] = array('ID' => $cvalue['gbook_ID'], 'title' => $cvalue['gbook_title'], 'content' => $cvalue['gbook_content'], 'name' => $cvalue['gbook_name'], 'time' => $cvalue['time'], 'mail' => $cvalue['gbook_ID'], 'hp' => $cvalue['gbook_hp']);
				
			}
			
			$gbook_array[$key] = $value;
		}
		
		$this->smarty->assign('gbook', $gbook_smarty_array);
		$this->smarty->assign('pages', $pagesnav_array);
		$this->smarty->assign('entrys', $data['many']);

	}
	
	/**
	 * Fuegt einen Eintrag hinzu oder liefert das Forumular dazu
	 *
	 */

	private function add()
	{
		$this->smarty->assign('action', $this->get_arr['action']);
		if (isset($this->post_arr['btn_send']) && $this->post_arr['btn_send'] == 'Senden') {
			$this->smarty->assign("forward_text", "Eintrag wurde aus technischen Gr&uuml;nden nicht erstellt");
			$this->smarty->assign("forward_linktext", "Angucken");
			$this->smarty->assign("forward_link", Page::getUriStatic($this->get_arr, array('action')));
			$this->tplfile ='forward_include.tpl';
			
			
		} else {
			$this->tplfile = 'gbook_entry.tpl';
			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);
			$this->smarty->assign('action', $this->get_arr['action']);
			$news_arr = $this->msbox->getEntry($this->get_arr['id'], '%e.%m.%Y %k:%i');
			$smarty_arr = array('entry_name' => $news_arr['gbook_name'], 'entry_content' => $news_arr['gbook_content'], 
								'entry_email' => $news_arr['gbook__email'], 'entry_hp' => $news_arr['gbook__hp'], 'entry_title' => 									$news_arr['gbook__title'], 'entry_time' => $news_arr['time']);
			$this->smarty->assign($smarty_arr);
			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);
			$this->smarty->assign('smilies_list', $smilie_arr);

		}
		
		//$this->msbox->addEntry(array('ID' => '3', 'ref_ID' => '', 'content' => 'Momentan wird hart an der Klasse messageboxes.class.php gearbeitet', 'name' => 'CO-Admin', 'time' => "NOW()", 'mail' => 'mail@jclub.ch', 'hp' => 'http://www.besj.ch', 'title' => 'Im Wandel'));
	}

	/**
	 * Editiert einen Eintrag im Mysql oder liefert das zugehoerige Formular.
	 *
	 */
	
	private function edit()
	{
		$this->smarty->assign('action', $this->get_arr['action']);
		
		if (isset($this->post_arr['btn_send']) && $this->post_arr['btn_send'] == 'Senden') {
			$this->smarty->assign("forward_text", "Eintrag wurde aus technischen Gr&uuml;nden nicht erstellt");
			$this->smarty->assign("forward_linktext", "Angucken");
			$this->smarty->assign("forward_link", Page::getUriStatic($this->get_arr, array('action')));
			$this->tplfile ='forward_include.tpl';
			
			
		} else {
			$this->tplfile = 'gbook_entry.tpl';
			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);
			$this->smarty->assign('action', $this->get_arr['action']);
			$news_arr = $this->msbox->getEntry($this->get_arr['id'], '%e.%m.%Y %k:%i');
			$smarty_arr = array('entry_name' => $news_arr['gbook_name'], 'entry_content' => $news_arr['gbook_content'], 
								'entry_email' => $news_arr['gbook__email'], 'entry_hp' => $news_arr['gbook__hp'], 'entry_title' => 									$news_arr['gbook__title'], 'entry_time' => $news_arr['time']);
			$this->smarty->assign($smarty_arr);
			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);
			$this->smarty->assign('smilies_list', $smilie_arr);

		}
		
	}
	
	/**
	 * Loescht einen Eintrag im Mysql oder liefert die Auswahlliste
	 *
	 */

	private function del()
	{
		;
	}
	
//	/**
//	 * Gibt ein Fehler an den User aus.
//	 *
//	 * @param int $line Zeile
//	 * @param string $errortext Text
//	 * @param string $errortitle Titel
//	 */
//
//	private function error($line, $errortext, $errortitle = "Fehler")
//	{
//		$this->tplfile = 'error_include.tpl';
//		$this->smarty->assign(array('error_title' => $errortitle, 'error_text' => $errortext));
//	}

}

?>