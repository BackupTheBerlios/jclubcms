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

	private $timeformat = '%e.%m.%Y %k:%i';


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
	 * @param array $parameters POST, GET und COOKIE-Variablen
	 */

	public function action($gpc)
	{
		//Daten initialisieren
		global $dir_smilies;
		$this->post_arr = $gpc['POST'];
		$this->get_arr = $gpc['GET'];


		$this->msbox = new Messageboxes($this->mysql, 'news', array('ID' => 'news_ID', 'ref_ID' => 'news_ref_ID', 'content' => 'news_content', 'name' => 'news_name', 'time' => 'news_time', 'email' => 'news_email', 'hp' => 'news_hp', 'title' => 'news_title'));

		$this->smilie = new Smilies($dir_smilies);

		//Keine Angabe -> Ausgabe der News
		$this->view(15);
		return true;

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
	 * Zeigt die Einträge an
	 *
	 * @param int $max_entries_pp Anzahl Einträge pro Seite
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
		$news_array = $this->msbox->getEntries($max_entries_pp, $page, 'DESC','ASC', $this->timeformat);

		$pagesnav_array = Page::get_static_pagesnav_array($news_array['many'],$max_entries_pp, $this->get_arr);


		$this->smarty->assign('entrys', $news_array['many']);
		//Key 'many' loeschen, damit es nicht als News-Nachricht auftaucht.
		unset($news_array['many']);

		foreach ($news_array as $key => $value) {

			//Nur news-Daten ohne $news_array['many'] abchecken

			$value['news_content'] = $this->smilie->show_smilie($value['news_content'], $this->mysql);

			foreach ($value['comments'] as $ckey => $cvalue) {
				$value['comments'][$ckey]['news_content'] = $this->smilie->show_smilie($cvalue['news_content'], $this->mysql);
			}

			$news_array[$key] = $value;

		}

		$this->smarty->assign('newsarray', $news_array);
		$this->smarty->assign('pages', $pagesnav_array);

	}
}

?>