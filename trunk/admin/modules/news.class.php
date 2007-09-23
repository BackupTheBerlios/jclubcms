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
	 * @var $mysql mysql
	 */
	private $mysql = null;
	private $smarty = null;
	/**
	 * Smilie-Klasse
	 *
	 * @var smilie
	 */
	private $smilie = null;
	private $post_arr = array();
	private $get_arr = array();
	/**
	 * Messagebox Klass
	 *
	 * @var MessageBoxes
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
	 * @param unknown_type $parameters
	 */
	public function action($parameters)
	{
		global $dir_smilies;
		$this->post_arr = $parameters['POST'];
		$this->get_arr = $parameters['GET'];
		
		$this->msbox = new MessageBoxes($this->mysql, 'news', array('ID' => 'news_ID', 'ref_ID' => 'news_ref_ID', 'content' => 'news_content', 'name' => 'news_name', 'time' => 'news_time', 'mail' => 'news_email', 'hp' => 'news_hp', 'title' => 'news_title'));
		
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
					$this->view(15);
					return true;
				case '':
					$this->view(15);
					return true;
				default:
					$this->error(__LINE__, 1);
					return false;
			}
		} else {
			$this->view(15);
			return true;
		}
	}

	public function gettplfile()
	{
		return $this->tplfile;
	}

	private function msboxtest()
	{
		$this->tplfile = 'main.tpl';
		
		$str = debugecho(debug_backtrace(),"Fehler da?: ".var_export($this->msbox->isError(),1), 1);

		if ($this->msbox->isError()) {
			$this->error(__LINE__, array('title' => 'Fehler in Messagebox', 'text' => var_export($this->msbox->isError(),1)));
		}

		$str .= debugecho(debug_backtrace(),"Fehler bei Tabelle:<br />\n".var_export($this->msbox->getError(),1), 1);

		//$this->msbox->addEntry(array('ID' => '3', 'ref_ID' => '', 'content' => 'Momentan wird hart an der Klasse messageboxes.class.php gearbeitet', 'name' => 'CO-Admin', 'time' => "NOW()", 'mail' => 'mail@jclub.ch', 'hp' => 'http://www.besj.ch', 'title' => 'Im Wandel'));
		$this->smarty->assign(array('content_title' => 'Debug-Infos', 'content_text' => $str));
	}
	

	
	
	private function view($max_entries_pp)
	{
		$this->tplfile = 'news.tpl';
		$news_array = array();
		
		if (isset($this->get_arr['page']) && is_numeric($this->get_arr['page']) && $this->get_arr['page'] > 0) {
			$page = $this->get_arr['page'];
		} else {
			$page = 1;
		}

		$news_array = $this->msbox->getEntries($max_entries_pp, $page, 'DESC', '%e.%m.%Y %k:%i');
		$this->mysql->query('SELECT COUNT(*) as many FROM `news`');
		$data = $this->mysql->fetcharray('assoc');
		$pagesnav_array = Page::get_static_pagesnav_array($data['many'],$max_entries_pp, $this->get_arr);

		foreach ($news_array as $key => $value) {
			$value['news_content'] = $this->smilie->show_smilie($value['news_content'], $this->mysql);
			foreach ($value['comments'] as $ckey => $cvalue) {
				$value['comments'][$ckey]['news_content'] = $this->smilie->show_smilie($cvalue['news_content'], $this->mysql);
				
			}
			
			$news_array[$key] = $value;
		}
		//Kommentaere nicht beachtet und ganzer code uebermittelt
		$this->smarty->assign('newsarray', $news_array);
		$this->smarty->assign('pages', $pagesnav_array);	

	}

	private function add()
	{
		$this->tplfile = 'news_entry.tpl';
		$this->smarty->assign('action', $this->get_arr['action']);
		
		if (isset($this->get_arr['submit']) && $this->get_arr['submit'] == 'Senden') {
			;
		} else {
			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);
		}
		
		
	}

	private function edit()
	{
		$this->tplfile = 'news_entry.tpl';
		$this->smarty->assign('action', $this->get_arr['action']);
		
	}

	private function del()
	{
		;
	}

	private function error($line, $errortext, $errortitle = "Fehler")
	{
		$this->tplfile = 'error_include.tpl';

		if (is_numeric($errortext)) {

			switch($errortext)
			{
				case 1:
					$errortitle = "Falsche URL-Parameter";
					$errortext = "Sie haben falsche URL-Parameter weitergegeben. Daher konnte keine entsprechende Aktion ausgef&uuml;fr werden<br />\nInfo: Fehler auf Zeile $line";
					break;
				default:
					$errortitle = "unbekannter Fehler";
					$errortext = "Sie haben irgendwie ein Fehler verursacht, ich weiss aber auch nicht wie. W&auml;re nett, wenn sie mir das erkl&auml;en k&ouml;nnten.<br />\nInfo: Fehler auf Zeile $line";
			}

			
		} elseif (is_array($errortext)) {
			$errortitle = $errortext['title'];
			$errortext = $errortext['text'];
			
		} elseif ($errortext == "") {
			$errortitle = "Fehler";
			$errortext = "Sie oder das Skript haben ein Fehler verursacht. Die Aktion wurde daher abgebrochen<br />\nInfo: Fehler auf Zeile $line";
			
		}
		
		
		
		$this->smarty->assign(array('error_title' => $errortitle, 'error_text' => $errortext));
	}

}

?>