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
	/**
	 * Smarty-Klasse
	 *
	 * @var $smarty Smarty
	 */
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
	 * @param array $parameters POST- und GET-Variablen
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
					$this->error(__LINE__, "Sie haben falsche URL-Parameter weitergegeben. Daher konnte keine entsprechende Aktion ausgef&uuml;fr werden", "Falsche URL-Parameter");
					return false;
			}
		} else {
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
	 * Test mit der Messagebox-Klasse
	 *
	 */

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


	/**
	 * Zeigt die Eintraege an
	 *
	 * @param int $max_entries_pp Anzahl Eintraege pro Seite
	 */

	private function view($max_entries_pp)
	{
		//die("Tsch&uuml;ss");
		$this->tplfile = 'news.tpl';
		$news_array = array();
		$error = false;

		if (isset($this->get_arr['page']) && is_numeric($this->get_arr['page']) && $this->get_arr['page'] > 0) {
			$page = $this->get_arr['page'];
		} else {
			$page = 1;
		}

		while ($error == false) {
			
			if (($news_array = $this->msbox->getEntries($max_entries_pp, $page, 'DESC','ASC', '%e.%m.%Y %k:%i')) == false) {
				$error = true;
				$error_text = join(" - ", $this->msbox->getError());
				$error_title = "Messagebox-Fehler";
				continue;
			}


			$this->mysql->query('SELECT COUNT(*) as many FROM `news`');
			$data = $this->mysql->fetcharray('assoc');

			if ($this->mysql->isError() == true) {
				$error = true;
				$error_text = "Ein Mysql-Fehler ist auf der Zeile ".__LINE__." aufgetaucht.<br />\nNachricht: ".join(" - ", $this->mysql->getError());
				$error_title = "Mysql-Fehler";
				continue;
			}
			
			
			$pagesnav_array = Page::get_static_pagesnav_array($data['many'],$max_entries_pp, $this->get_arr);

			foreach ($news_array as $key => $value) {
				$value['news_content'] = $this->smilie->show_smilie($value['news_content'], $this->mysql);
				foreach ($value['comments'] as $ckey => $cvalue) {
					$value['comments'][$ckey]['news_content'] = $this->smilie->show_smilie($cvalue['news_content'], $this->mysql);

				}

				$news_array[$key] = $value;

			}

			$this->smarty->assign('newsarray', $news_array);
			$this->smarty->assign('pages', $pagesnav_array);
			break;

		}

		if ($error == true) {
			$this->error(__LINE__, $error_text, $error_title);
		}


	}
	
	
	/**
	 * Fuegt einen Eintrag ein oder liefert das Formular dazu
	 *
	 */

	private function add()
	{
		throw  new ErrorException('Dies ist nichts anderes als ein Test-Fehler', EXCEPTION_MODULE_CODE, 2);
		if (isset($this->post_arr['btn_send']) && $this->post_arr['btn_send'] == 'Senden') {
			$this->smarty->assign("forward_text", "Eintrag wurde aus technischen Gr&uuml;nden nicht erstellt");
			$this->smarty->assign("forward_linktext", "Angucken");
			$this->smarty->assign("forward_link", Page::getUriStatic($this->get_arr, array('action')));
			$this->tplfile ='forward_include.tpl';
		} else {
			$this->tplfile = 'news_entry.tpl';
			$this->smarty->assign('action', $this->get_arr['action']);
			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);
			$this->smarty->assign('smilies_list', $smilie_arr);
		}


	}
	
	/**
	 * Editiert einen Eintrag im Mysql oder liefert das zugehoerige Formular
	 *
	 */

	private function edit()
	{
		
		
		if (isset($this->post_arr['btn_send']) && $this->post_arr['btn_send'] == 'Senden') {
			$this->smarty->assign("forward_text", "Eintrag wurde aus technischen Gr&uuml;nden nicht erstellt");
			$this->smarty->assign("forward_linktext", "Angucken");
			$this->smarty->assign("forward_link", Page::getUriStatic($this->get_arr, array('action')));
			$this->tplfile ='forward_include.tpl';
		} else {
			$this->tplfile = 'news_entr.tpl';
			$smilie_arr = $this->smilie->create_smiliesarray($this->mysql);
			$this->smarty->assign('action', $this->get_arr['action']);
			$news_arr = $this->msbox->getEntry($this->get_arr['id'], '%e.%m.%Y %k:%i');
			$smarty_arr = array('entry_name' => $news_arr['news_name'], 'entry_content' => $news_arr['news_content'], 
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
		;
	}

	/**
	 * Wird von den Methoden aufgerufen. Gibt einen Fehler in HTML aus.
	 *
	 * @param int $line
	 * @param string $errortext
	 * @param string[optional] $errortitle
	 */
	
	private function error($line, $errortext, $errortitle = "Fehler")
	{
		$this->tplfile = 'error_include.tpl';

		if (is_string($errortext) && !empty($errortext)) {

			$errortitle = $errortitle;
			$errortext = $errortext."<br />\nInfo: Fehler auf Zeile $line";

		} elseif (is_array($errortext)) {
			$errortitle = $errortext['title'];
			$errortext = $errortext['text']."<br />\nInfo: Fehler auf Zeile $line";

		} else {
			$errortitle = "Fehler";
			$errortext = "Sie oder das Skript haben ein Fehler verursacht. Die Aktion wurde daher abgebrochen<br />\nInfo: Fehler auf Zeile $line";

		}

		$this->smarty->assign(array('error_title' => $errortitle, 'error_text' => $errortext));
	}

}

?>