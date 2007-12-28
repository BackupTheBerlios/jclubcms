<?php

/**
 * @package JClubCMS
 * @author Simon Däster
 * contentadmin.class.php
 * 
 * Diese Datei ist für die Administration der Contents zuständig. Über dieses Modul
 * wird das Hinzufügen von neuen Inhalten (Contents), das Bearbeiten von bestehenden und 
 * das Archivieren (verstecken) von vergangenen und Löschen zuständig.
 * 
 * @todo Klasse aufbauen und Funktionen integrieren
 */

require_once ADMIN_DIR.'lib/module.interface.php';
require_once ADMIN_DIR.'lib/smilies.class.php';

class Contentadmin implements Module
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


		$this->_smilie = new Smilies($dir_smilies);

		//Je nach Get-Parameter die zugehörige Anweisung ausfuehren
		if (key_exists('action', $this->_gpc['GET'])) {
			switch ($this->_gpc['GET']['action']) {
				default:
					$this->_view(30);
			}
				
		} else {
			$this->_view(30);
			return true;
		}
	}
	
	public function gettplfile()
	{
		return $this->_tplfile;
	}
	
	private function _view($number)
	{
		$this->_tplfile = 'content.tpl';
		
		$page = Page::get_current_page($this->_gpc['GET']);
		$start = ($page - 1)*$number;

		$this->_mysql->query("SELECT `content_ID` , `content_title` , `content_text` , 
		`content_time` , `content_archiv` , `menu_ID` 
		FROM `content` , `menu` 
		WHERE `menu`.`menu_pagetyp` = 'pag' AND `menu`.`menu_page` = `content`.`content_ID`
		ORDER BY `menu`.`menu_topid` 
		LIMIT $start, $number");
		
		$this->_mysql->saverecords('assoc');
		$content_data = $this->_mysql->get_records();
		$this->_smarty->assign('contents', $content_data);
	}
	
	private function _create()
	{
		;
	}
	
	private function _edit($ID)
	{
		;
	}
	
	private function _archive($ID)
	{
		;
	}
	
	private function _del($ID)
	{
		;
	}
}


?>