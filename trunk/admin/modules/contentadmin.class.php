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
		
		$this->_mysql->query("SELECT COUNT(*) as 'count' FROM `content` , `menu` 
		WHERE `menu`.`menu_pagetyp` = 'pag' AND `menu`.`menu_page` = `content`.`content_ID");
		$count = $this->_mysql->fetcharray('assoc');
		$count = $count['count'];
		
		$page = Page::get_current_page($this->_gpc['GET']);
		$pages_nav = Page::get_static_pagesnav_array($count, $number, $this->_gpc['GET']);
		$start = ($page - 1)*$number;

		$this->_mysql->query("SELECT `content_ID` , `content_title` , `content_text` , 
		`content_time`
		FROM `content` 
		LIMIT $start, $number");
		
		$this->_mysql->saverecords('assoc');
		$content_data = $this->_mysql->get_records();
		$this->_smarty->assign('contents', $content_data);
		$this->_smarty->assign('nav', $this->_getNav());
		$this->_smarty->assign('pages', $pages_nav);
	}
	
	private function _create()
	{
		if ($this->_isformsend()) {
			
		} else {
			
		}
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
	
	private function _isformsend() 
	{
		
		return (isset($this->_gpc['POST']['senden']) && $this->_gpc['POST']['senden'] == "Senden");
	}
	
	private function _checkformdata()
	{
		
	}
	
	private function _showeditor($error_arr = null)
	{
		if($error_arr != null && is_array($error_arr) && !empty($error_arr)) {
			;
		}
	}
	
	/**
	 * Gibt die Navigation in Form eines Arrays zurück
	 *
	 * @return array Navigation
	 */
	private function _getNav()
	{
		static $nav_arr = null;
		
		if (empty($nav_arr) || !is_array($nav_arr)) {
			$topid_arr = array();
			$page = new Page($this->_smarty, $this->_mysql);
			
			$this->_mysql->query("SELECT `menu_topid`, COUNT(*) as 'count' FROM `menu` GROUP BY `menu_topid`");
			$i = 0;
			while(($data = $this->_mysql->fetcharray('assoc')) !== false) {
				$topid_arr[$i] = (int)$data['menu_topid'];
				$i++;
			}
			
			$page->let_build_menu_array($topid_arr, $nav_arr, false, true);
		}
		return $nav_arr;
		
	}
}


?>