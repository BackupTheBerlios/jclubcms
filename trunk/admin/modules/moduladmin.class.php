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

class Moduladmin implements Module
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
	 * POST, GET, COOKIE-Array
	 *
	 * @var array
	 */
	private $_gpc = array();


	/**
	 * Nav_ID dieses Moduls
	 *
	 * @var int
	 */
	private $_nav_id = null;


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

		$this->_nav_id = $this->_smarty->get_template_vars('local_link');

		$this->_view();
		return true;

	}

	/**
	 * Liefert die Template-File zurück
	 *
	 * @return string Template-Datei
	 */
	public function gettplfile()
	{
		return $this->_tplfile;
	}

	/**
	 * Zeigt die einzelnen Contents an.
	 *
	 * @param int $number Anzahl Einträge pro Seite
	 */
	private function _view($number = 20)
	{
		$this->_tplfile = 'module.tpl';

		if ($this->_isformsend()) {
			$this->_updmods();
		}



		$this->_mysql->query("SELECT COUNT(*) as 'count' FROM `modules`");
		$count = $this->_mysql->fetcharray('assoc');
		$count = $count['count'];

		$page = Page::get_current_page($this->_gpc['GET']);
		$pages_nav = Page::get_static_pagesnav_array($count, $number, $this->_gpc['GET']);
		$start = ($page - 1)*$number;

		$this->_mysql->query("SELECT `modules_ID`, `modules_name`, `modules_file`, `modules_template_support`, `modules_mail_support`, `modules_status` FROM `modules` LIMIT $start, $number");
		$this->_mysql->saverecords('assoc');
		$modules_data = $this->_mysql->get_records();


		$this->_smarty->assign('modules', $modules_data);
		$this->_smarty->assign('pages', $pages_nav);
		$this->_smarty->assign('info', $this->_getinfo(true));

	}


	/**
	 * Schaut nach veränderten Modulen und ändert den Status
	 *
	 * @param array $data Daten
	 */
	private function _updmods()
	{
		$post = $this->_gpc['POST'];
		$status_arr = array();

		if (key_exists('modules_check', $post)) {
			foreach ($post['modules_check'] as $key => $value) {
				$st_value = $post['modules_status'][$key];
				if ($st_value != 'on' && $st_value != 'off') {
					$this->setinfo("Erlaubte Werte für Status sind nur on und off, keine anderen.");
					break;
				} else {
					$status_arr[] = array('ID' => $this->_mysql->escapeString($key), 'value' => $this->_mysql->escapeString($st_value));
				}

			}
		}

		if (!empty($status_arr)) {
			$query = "";
			foreach ($status_arr as $value) {
				$this->_mysql->query("UPDATE `modules` SET `modules_status` = '{$value['value']}' WHERE `modules_ID` = '{$value['ID']}' LIMIT 1");
			}

		}

	}

	/**
	 * Prüft, ob das Editor-Formular gesendet wurde. Trifft dies zu, gibt die Methode true zurück, ansonsten false
	 *
	 * @return boolean Formular gesendet?
	 */
	private function _isformsend()
	{

		return (key_exists('btn_senden', $this->_gpc['POST']) && $this->_gpc['POST']['btn_senden'] == "Senden");
	}

	/**
	 * Speichert Strings in einem Array ab, das jederzeit verfügbar ist.
	 *
	 * @param string $string Zeichenkette, die gespeichert werden soll
	 * @return array Aktuelles Array
	 */
	private function _setinfo($string = null)
	{
		static $info = array();
		if ($string != null &&!empty($string)) {
			$info[] = $string;
		}
		return $info;
	}

	/**
	 * Speichert Strings in einem Array ab, das jederzeit verfügbar ist.
	 *
	 * @param boolean $as_string Daten in Array oder als String zurückgeben
	 * @return array|string Aktuelles Array (im Format String, wenn gewählt)
	 */
	private function _getinfo($as_string = true)
	{
		if ($as_string == true) {
			return implode('<br />\n', $this->_setinfo());
		} else {
			return setinfo();
		}
	}

}


?>