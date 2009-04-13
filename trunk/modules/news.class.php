<?php 
/**
 * Dieses Modul ist zuständig für das anzeigen von Newseinträgen
 * @author Simon Däster
 * @package JClubCMS
 * @license  http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 
 */

require_once ADMIN_DIR.'lib/module.interface.php';
require_once ADMIN_DIR.'lib/messageboxes.class.php';
require_once ADMIN_DIR.'lib/smilies.class.php';

/**
 * Diese Klasse ist zustaendig fuer Anzeigen von Newseinträgen.
 * 
 * 
 * 
 * @author Simon Däster
 * @package JClubCMS
 * @uses Mysql Für Verbindungen zur MySQL-DB.
 * news.class.php
 */

class News implements Module
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
	 * GET, POST, COOKIE-Array
	 * 
	 * @var array
	 */
	private $_gpc = array();
	
	/**
	 * Zeitformat
	 *
	 * @var string
	 */
	private $_timeformat = TIMEFORMAT;


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
		$this->_gpc = $gpc;

		$this->_msbox = new Messageboxes($this->_mysql, 'news', array('ID' => 'news_ID', 'ref_ID' => 'news_ref_ID', 'content' => 'news_content', 'name' => 'news_name', 'time' => 'news_time', 'email' => 'news_email', 'hp' => 'news_hp', 'title' => 'news_title'));

		$this->_smilie = new Smilies(SMILIES_DIR);

		//Keine Angabe -> Ausgabe der News
		$this->_view(NEWS_ENTRIES_PER_PAGE);
		return true;

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

			//Nur news-Daten ohne $news_array['many'] abchecken
			$news_array[$key]['news_content'] = $this->_smilie->show_smilie(nl2br(htmlentities($value['news_content'])), $this->_mysql);


			foreach ($value['comments'] as $ckey => $cvalue) {
				$news_array[$key]['comments'][$ckey]['news_content'] = $this->_smilie->show_smilie(nl2br(htmlentities($value['news_content'])), $this->_mysql);

			}


		}

		$this->_smarty->assign('newsarray', $news_array);
		$this->_smarty->assign('pages', $pagesnav_array);

	}
}

?>
