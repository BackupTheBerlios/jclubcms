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
	 * Texte aus der Config-Datei
	 *
	 * @var array
	 */
	private $_configvars = array();

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
		global $dir_smilies;
		$this->_gpc['POST'] = $gpc['POST'];
		$this->_gpc['GET'] = $gpc['GET'];

		/* Daten laden */
		$this->_smarty->config_load('textes.de.conf', 'Editor');
		$this->_configvars['Editor'] = $this->_smarty->get_config_vars();
		$this->_smarty->config_load('textes.de.conf', 'Editor-Entry');
		$this->_configvars['Editor-Entry'] = $this->_smarty->get_config_vars();
		$this->_smarty->config_load('textes.de.conf', 'Editor-Error');
		$this->_configvars['Editor-Error'] = $this->_smarty->get_config_vars();

		$this->_nav_id = $this->_smarty->get_template_vars('local_link');

		$this->_smilie = new Smilies($dir_smilies);

		//Je nach Get-Parameter die zugehörige Anweisung ausfuehren
		if (key_exists('action', $this->_gpc['GET'])) {
			switch ($this->_gpc['GET']['action']) {
				case 'new':
					$this->_create();
					break;

				default:
					$this->_view(15);
			}

		} else {
			$this->_view(15);
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
		$this->_smarty->assign('pages', $pages_nav);

	}

	private function _create()
	{
		$lang_vars = $this->_configvars['Editor'];
		if ($this->_isformsend()) {
			$answer = array();
			$success = $this->_checkformdata($answer);

			if ($success == true) {
				$this->_Con2mysql($answer, 'add');
				$this->_send_feedback($lang_vars['saved_title'], $lang_vars['saved_content'],
				"?nav_id=$this->_nav_id", $lang_vars['link_text']);
			} else {
				$this->_showeditor(false, $answer);
			}
		} else {
			$this->_showeditor();
		}
	}

	private function _edit($ID)
	{
		;
	}

	private function _del($ID)
	{
		;
	}


	private function _Con2mysql($data, $modus = '')
	{
		/*Parameter kontrollieren */
		if (!is_array($data) || empty($data)) {
			throw new CMSException('1. Parameter ist nicht gültig. Typ Array ist verlangt.', EXCEPTION_MODULE_CODE, 'Laufzeit-Fehler');
		}
		if (!is_string($modus) || empty($modus)) {
			throw new CMSException('2. Parameter ist nicht gültig. Typ String ist verlangt.', EXCEPTION_MODULE_CODE, 'Laufzeit-Fehler');
		}

		if ($modus == 'add') {
			$sql = "INSERT INTO `content` (`content_ID`, `content_title`, `content_text`, `content_time`, `content_archiv`) VALUES (";
			$sql .= "'', '{$data['c_title']}', '{$data['c_text']}', NOW(),";

			if ($data['c_hide'] == true) {
				$sql .= "'1'";
			} else {
				$sql .= "'0'";
			}
			$sql .= ")";

			echo $sql."\n";
			
			//$this->_mysql->query($sql);
			$c_ID = $this->_mysql->insert_id();
			
			$sql = "INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_name`, `menu_position`, `menu_page`, `menu_pagetyp`, `menu_display`) VALUES (";
			$sql .= "'', '{$data['m_topid']}', '{$data['m_name']}', '{$data['m_pos']}', '$c_ID', 'pag',";
			
			if ($data['m_display'] == true) {
				$sql .= "'1'";
			} else {
				$sql .= "'0'";
			}		
			$sql .= ")";
			
			echo $sql."\n";
			//$this->_mysql->query($sql);
			
		} elseif ($modus == 'edit') {

		} else {
			throw new CMSException('Angegebener Modus nicht gültig.', EXCEPTION_MODULE_CODE, 'Laufzeit-Fehler');
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
	 * Kontrolliert die Daten, welche aus dem Formular stammen. Sind die Daten fehlerhaft (leere oder ungültige Einträge)
	 * gibt die Funktion false zurück und der Parameter $answer enthält die Fehlermeldungen.
	 * Sind die Daten hingegen gut, enthält $answer ein Array mit den Daten aus dem Formular.
	 *
	 * @param unknown_type $answer
	 */
	private function _checkformdata(&$answer)
	{
		$answer = array();

		$entry_vars = $this->_configvars['Editor-Entry'];
		$error_vars = $this->_configvars['Editor-Error'];

		$formcheck = new Formularcheck();

		$post_vars = $this->_gpc['POST'];

		$val = array('c_title' => $post_vars['content_title'], 'c_text' => $post_vars['content_text']);
		$std = array('c_title' => $entry_vars['content_title'], 'c_text' => $entry_vars['content_text']);
		$err = array('c_title' => $error_vars['content_title_error'], 'c_text' => $error_vars['content_text_error']);


		/* Menu-Einträge ignorieren? */
		if (!key_exists('menu_ignore', $this->_gpc['POST'])) {
			$tmp['m_ignore'] = false;

			$val += array('m_name' => $post_vars['menu_name'], 'm_pos' => $post_vars['menu_position'],
			'm_topid' => $post_vars['menu_topid']);
			$std += array('m_name' => $entry_vars['menu_name'], 'm_pos' => '', 'm_topid' => '');
			$err += array('m_name' => $error_vars['menu_name_error'], 'm_pos' => $error_vars['menu_position_error'],
			'm_topid' => $error_vars['menu_topid_error']);

			if (!is_numeric($val['m_pos'])) {
				$answer[] = $err['m_pos'];
			}

			if (!is_numeric($val['m_topid'])) {
				$answer[] = $err['m_topid'];
			}

		} else {
			$tmp['m_ignore'] = true;
		}

		if (key_exists('content_hide', $this->_gpc['POST'])) {
			$tmp['c_hide'] = true;
		} else {
			$tmp['c_hide'] = false;
		}
		
		if (key_exists('menu_display', $this->_gpc['POST'])) {
			$tmp['m_display'] = true;
		} else {
			$tmp['m_display'] = false;
		}

		$fmcheck_array = $formcheck->field_check_arr($val, $std);

		foreach ($fmcheck_array as $key => $value) {
			if ($value == false) {
				$answer[] = $err[$key];
			}
		}

		/* Keine Fehler gefunden -> Daten in $answer speichern */
		if (empty($answer)) {
			$answer = $val;
			$answer += $tmp;
			return true;
		} else {
			return false;
		}



	}

	/**
	 * Zeigt den Editor an
	 *
	 * @param boolean[optional] $tk_std_values Soll der Editor mit Standartwerten gefüllt werden?
	 * @param array[optional] $error_arr Fehlerstring-Array aus checkformdata
	 * @param boolean[optional] $tk_mysql_values Soll der Editor mit den Daten aus der Datenbank gefüllt werden?
	 * @param int[optional] $ref_ID ID des contents aus der Mysql-DB
	 */
	private function _showeditor($tk_std_values = true, $error_arr = null, $tk_mysql_values = false, $ref_ID = 0)
	{
		$this->_tplfile = 'content_new.tpl';
		$smarty_array = array();




		if (is_array($error_arr) && !empty($error_arr)) {
			$smarty_array += array('dump_errors' => true, 'error_content' => implode("<br />\n", $error_arr));
		}

		
		if ($tk_std_values == false) {
			/* Daten vom POST-Formular nehmen */
			$post = $this->_gpc['POST'];

			$smarty_array += array('content_title' => $post['content_title'], 'content_text' => $post['content_text'],
			'menu_name' => $post['menu_name'], 'menu_position' => $post['menu_position'], 'menu_topid' => $post['menu_topid']);

			if (key_exists('content_hide', $post)) {
				$smarty_array['content_hide'] = $post['content_hide'];
			}

			if (key_exists('menu_ignore', $post)) {
				$smarty_array['menu_ignore'] = $post['menu_ignore'];
			}
			
			if (key_exists('menu_display', $post)) {
				$smarty_array['menu_display'] = $post['menu_display'];
			}

		} elseif ($tk_mysql_values == true) {
			/*Daten von Mysql holen*/			
			$this->_mysql->query("SELECT `content_title`, `content_text`, `content_time`, `content_archiv` FROM `content` WHERE `content_ID` = '$ref_ID' LIMIT 1");
			$data = $this->_mysql->fetcharray('assoc');

			$smarty_array += array('content_title' => $data['content_title'], 'content_text' => $data['content_text']);

			if ($data['content_archiv'] == '1') {
				$smarty_array['content_hide'] = true;
			}
			//'menu_name' => $post['menu_name'], 'menu_position' => $post['menu_position'], 'menu_topid' => $post['menu_topid']);

		} else {
			$lang_vars = $this->_configvars['Editor-Entry'];
			$smarty_array += array('content_title' => $lang_vars['content_title'], 'content_text' => $lang_vars['content_text'],
			'menu_name' => $lang_vars['menu_name'], 'menu_position' => '0', 'menu_topid' => '0');

		}



		$smarty_array['menues'] = $this->_getMenues();
		$smarty_array['positions'] = $this->_getPos(7);
		$this->_smarty->assign('editor', $smarty_array);
	}

	/**
	 * Gibt die Navigation in Form eines Arrays zurück
	 *
	 * @return array Navigation
	 */

	private function _getMenues()
	{
		static $nav_arr = null;

		/* Navigation nur Aufrufen, falls dies noch nicht getan wurde */
		if (!is_array($nav_arr)) {
			$nav_arr = array();
			$topid_arr = array();

			$page = new Page($this->_smarty, $this->_mysql);

			$this->_mysql->query("SELECT `menu_topid`, COUNT(*) as 'count' FROM `menu` GROUP BY `menu_topid`");
			$i = 0;
			while(($data = $this->_mysql->fetcharray('assoc')) !== false) {
				$topid_arr[$i] = (int)$data['menu_topid'];
				$i++;
			}
			/* @var $page Page */
			$page->let_build_menu_array($topid_arr, $nav_arr, false, true);
		}

		return $nav_arr;

	}

	private function _getPos($number = 10){
		$number = (int)$number;
		static $pos_arr = null;
		static $st_num = 0;

		if (!is_array($pos_arr) || $st_num != $number) {
			$pos_arr = array();
			$st_num = $number;
			for ($i = 0; $i <= 2*$number; $i++) {
				$pos_arr[$i]['pos_name'] = (string)($i-$number);
			}
		}
		return $pos_arr;
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

	/**
	 * Entfernt die Sessionid aus dem Text. Nützlich, falls Bilder eingefügt wurden und die 
	 * Sessionid aus der Bild-URL entfernt werden soll, bevor der Text in der Datenbank gespeichert wird.
	 *
	 * @param string $text Text, wo die Session-ID herausgeschnitten werden soll.
	 */
	private function _cutSessID($text)
	{
		$sess_id = $this->_smarty->get_template_vars('SID');
		str_replace($sess_id, "", $text);
	}
}


?>