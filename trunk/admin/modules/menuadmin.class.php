<?php

require_once ADMIN_DIR.'lib/module.interface.php';
require_once ADMIN_DIR.'lib/smilies.class.php';

/**
 * Diese Datei ist für die Administration der Contents zuständig. Über dieses Modul
 * wird das Hinzufügen von neuen Inhalten (Contents), das Bearbeiten von bestehenden und 
 * das Archivieren (verstecken) von vergangenen und Löschen zuständig.
 * 
 * @todo Klasse aufbauen und Funktionen integrieren
 * @package JClubCMS
 * @author Simon Däster
 * contentadmin.class.php
 * 
 */
class Menuadmin implements Module
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

		if (key_exists('ref_ID', $this->_gpc['GET']) && is_numeric($this->_gpc['GET']['ref_ID'])) {
			$id = (int)$this->_gpc['GET']['ref_ID'];
		}

		//Je nach Get-Parameter die zugehörige Anweisung ausfuehren
		if (key_exists('action', $this->_gpc['GET'])) {
			switch ($this->_gpc['GET']['action']) {
				case 'new':
					$this->_create();
					break;
				case 'edit':
					$this->_edit($id);
					break;
				case 'del':
					$this->_del($id);
					break;
				default:
					$this->_view();
			}

		} else {
			$this->_view();
			return true;
		}
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
		$this->_tplfile = 'menu.tpl';

		if ($this->_isformsend()) {
			$this->_updView();
		}
		$this->_mysql->query("SELECT COUNT(*) as 'count' FROM `menu`");
		$count = $this->_mysql->fetcharray('assoc');
		$count = $count['count'];

		$page = Page::get_current_page($this->_gpc['GET']);
		$pages_nav = Page::get_static_pagesnav_array($count, $number, $this->_gpc['GET']);
		$start = ($page - 1)*$number;

		$menu_data = $this->_getMenues($start, $number, false);


		$this->_mysql->saverecords('assoc');
		$content_data = $this->_mysql->get_records();

		foreach($menu_data as $key => $value) {
			$str = "";
			for ($i = 0; $i < $value['level']; $i++) {
				$str .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			}

			$menu_data[$key]['menu_space'] = $str;
			$menu_data[$key]['menu_name'] = htmlentities($value['menu_name']);
		}

		$this->_smarty->assign('menus', $menu_data);
		$this->_smarty->assign('pages', $pages_nav);
		$this->_smarty->assign('positions', $this->_getPos(7));

	}


	/**
	 * Diese Funktion ist für das Erstellen neuer Inhalt verantwortlich.
	 *
	 */

	private function _create()
	{
		$lang_vars = $this->_configvars['Editor'];
		if ($this->_isformsend()) {
			$answer = array();
			$success = $this->_checkformdata($answer);

			if ($success == true) {
				$this->_add2mysql($answer);
				$this->_send_feedback($lang_vars['saved_title'], $lang_vars['saved_content'],
				"?nav_id=$this->_nav_id", $lang_vars['link_text']);
			} else {
				$this->_showeditor(false, $answer);
			}
		} else {
			$this->_showeditor();
		}
	}

	/**
	 * Diese Funktion ist für das Editieren bestehender Einträge verantwortlich.
	 *
	 * @param int $ID ID des Eintrags
	 */
	private function _edit($ID)
	{
		/*Parameter kontrollieren */
		if (!is_int($ID) || $ID < 1) {
			throw new CMSException('1. Parameter ist nicht gültig. Typ Int ist verlangt.', EXCEPTION_MODULE_CODE, 'Laufzeit-Fehler');
		}
		$lang_vars = $this->_configvars['Editor'];
		if ($this->_isformsend()) {
			$answer = array();
			$success = $this->_checkformdata($answer);

			if ($success == true) {
				$answer['m_ID'] = $ID;
				$this->_upd2mysql($answer);
				$this->_send_feedback($lang_vars['edit_title'], $lang_vars['edit_content'],
				"?nav_id=$this->_nav_id", $lang_vars['link_text']);
			} else {
				$this->_showeditor(false, $answer);
			}
		} else {
			$this->_showeditor(false, null, true, $ID);
		}
	}


	/**
	 * Verantwortlich für das Löschen eines Inhalts.
	 * 
	 * @param int $ID ID des Eintrags
	 */
	private function _del($ID)
	{
		$linktext = "JA";
		$linktext2 = "NEIN";
		$this->_tplfile = 'menu_del.tpl';
		$post = $this->_gpc['POST'];
		$lang_vars = $this->_configvars['Editor'];

		if (!is_int($ID) || $ID < 1) {
			throw new CMSException('1. Parameter ist nicht gültig. Typ Int ist verlangt.', EXCEPTION_MODULE_CODE, 'Laufzeit-Fehler');
		}

		if (key_exists('weiter', $post) && $post['weiter'] == $linktext) {

			$this->_mysql->query("DELETE FROM  `menu` WHERE `menu_ID` = '$ID' LIMIT 1");


			$this->_send_feedback($lang_vars['del_title'], $lang_vars['del_menu'],
			"?nav_id=$this->_nav_id", $lang_vars['link_text']);
		} elseif (key_exists('nein', $post) && $post['nein'] == $linktext2) {
			$this->_send_feedback($lang_vars['abort_title'], $lang_vars['abort_content'],
			"?nav_id=$this->_nav_id", $lang_vars['link_text']);
		} else {
			$this->_tplfile = 'menu_del.tpl';
			$sql = "SELECT `menu_name`, `menu_topid`, `menu_position`, `menu_page`, `menu_pagetyp`, `menu_modvar`, `menu_display`"
			." FROM `menu` WHERE `menu_ID` = '$ID' LIMIT 1";
			$this->_mysql->query($sql);
			$data = $this->_mysql->fetcharray('assoc');

			if ($data['menu_pagetyp'] == 'mod') {
				$this->_mysql->query("SELECT `modules_name` FROM `modules` WHERE `modules_ID` = '{$data['menu_page']}' LIMIT 1");
				$mdata = $this->_mysql->fetcharray('num');
				$m_linkname = $mdata[0];
			} else {
				$this->_mysql->query("SELECT `content_title` FROM `content` WHERE `content_ID` = '{$data['menu_page']}' LIMIT 1");
				$mdata = $this->_mysql->fetcharray('num');
				$m_linkname = $mdata[0];
			}

			$this->_smarty->assign($data);
			$this->_smarty->assign(array('menu_pagename' => $m_linkname, 'del_ID' => $ID,
			'linktext' => $linktext, 'linktext2' => $linktext2));

		}


	}

	/**
	 *  Macht ein Update der Positionen, die auf der Menu-Seite angegeben wurden
	 * 
	 */
	private function _updView()
	{
		$post = $this->_gpc['POST'];
		$pos_arr = array();
		$disp_arr = array();

		$break = false;

		if (key_exists('menu_check', $post)) {
			foreach ($post['menu_check'] as $key => $value) {
				$pos_value = $post['menu_position'][$key];
				if (!is_numeric($pos_value)) {
					$this->_smarty->assign('info', "Erlaubte Werte f&uuml;r Positionen sind nur Zahlenwerte, keine anderen.");
					$break = true;
					break;
				} else {
					$pos_arr[] = array('ID' => $this->_mysql->escapeString($key), 'value' => $this->_mysql->escapeString($pos_value));
				}
				
				$disp_value = $post['menu_display'][$key];
				if ($disp_value != '0' && $disp_value != '1') {
					$this->_smarty->assign('info', "Erlaubte Werte f&uuml;r Annzeige sind nur 0 und 1, keine anderen.");
					$break = true;
					break;
				} else {
					$disp_arr[] = array('ID' => $this->_mysql->escapeString($key), 'value' => $this->_mysql->escapeString($disp_value));
				}

			}
		}

		if ($break != true && !empty($pos_arr)) {
			
			foreach ($pos_arr as $value) {
				$this->_mysql->query("UPDATE `menu` SET `menu_position` = '{$value['value']}' WHERE `menu_ID` = '{$value['ID']}' LIMIT 1");
			}
			
			foreach ($disp_arr as $value) {
				$this->_mysql->query("UPDATE `menu` SET `menu_display` = '{$value['value']}' WHERE `menu_ID` = '{$value['ID']}' LIMIT 1");
			}


		}
	}

	/**
	 * Fügt einen Eintrag in die Datenbank ein. Wird von der Methode _create() aufgerufen.
	 *
	 * @param array $data Datenarray von checkformdata
	 */
	private function _add2mysql($data)
	{
		/*Parameter kontrollieren */
		if (!is_array($data) || empty($data)) {
			throw new CMSException('1. Parameter ist nicht gültig. Typ Array ist verlangt.', EXCEPTION_MODULE_CODE, 'Laufzeit-Fehler');
		}





		$sql = "INSERT INTO `menu` (`menu_ID`, `menu_topid`, `menu_name`, `menu_position`, `menu_page`, `menu_pagetyp`,"
		." `menu_display`) VALUES ('', '".$this->_mysql->escapeString($data['m_topid'])."', "
		."'".$this->_mysql->escapeString($data['m_name'])."', '".$this->_mysql->escapeString($data['m_pos'])."', "
		."'".$this->_mysql->escapeString($data['m_page'])."', '".$this->_mysql->escapeString($data['m_modus'])."',";

		if ($data['m_display'] == true) {
			$sql .= "'1'";
		} else {
			$sql .= "'0'";
		}

		$sql .= ")";

		$this->_mysql->query($sql);

		if ($this->_mysql->insert_id() == $data['m_topid']) {
			$error_str = "DAS UNMÖGLICHE WURDE VOLLBRACHT, GRATULIERE!!!<br />. "
			."Soeben wurde menu-id zur topid gewählt. Hast du ein wenig gehackt???"
			."Bitte das rückgängig machen (zurück-button des Browsers), ansonsten wird das Menu nie erscheinen, "
			."auch nicht im Editierbereich. Falls das geschieht, ist der Administrator zu informieren (mehr unter Hilfe)";
			throw new Exception($error_str, EXCEPTION_CORE_CODE, 'GLÜCKSPILZ');
		}




	}

	/**
	 * Erneuert einen bestehenden Eintrag und das Menu mit den angegebenen Daten
	 *
	 * @param array $data Daten
	 */
	private function _upd2mysql($data)
	{
		/*Parameter kontrollieren */
		if (!is_array($data) || empty($data)) {
			throw new CMSException('1. Parameter ist nicht gültig. Typ Array ist verlangt.', EXCEPTION_MODULE_CODE, 'Laufzeit-Fehler');
		}


		if (!key_exists('m_ID', $data) || !is_numeric($data['m_ID'])) {
			throw new CMSException('Daten ungültig. Menu-ID verlangt.', EXCEPTION_MODULE_CODE, 'Laufzeit-Fehler');
		}

		$sql = "UPDATE `menu` SET `menu_topid` = '".$this->_mysql->escapeString($data['m_topid'])."', `menu_position` = '".$this->_mysql->escapeString($data['m_pos'])."'";
		$sql .= ", `menu_name` = '".$this->_mysql->escapeString($data['m_name'])."', `menu_pagetyp` = '".$this->_mysql->escapeString($data['m_modus'])."'";
		$sql .= ", `menu_page` = '".$this->_mysql->escapeString($data['m_page'])."'";

		if ($data['m_display'] == true) {
			$sql .= ", `menu_display` = '1'";
		} else {
			$sql .= ", `menu_display` = '0'";
		}

		$sql .= " WHERE `menu_ID` = '".$this->_mysql->escapeString($data['m_ID'])."' LIMIT 1";

		$this->_mysql->query($sql);

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
	 * @param array[ref] $answer Antwort-Array, wird als Referenz übergeben. Enthält die Daten oder Fehlertexte
	 * @return boolean Erfolg(true) oder Fehler(false)
	 */
	private function _checkformdata(&$answer)
	{
		$answer = array();

		$entry_vars = $this->_configvars['Editor-Entry'];
		$error_vars = $this->_configvars['Editor-Error'];

		$formcheck = new Formularcheck();

		$post_vars = $this->_gpc['POST'];



		$val = array('m_name' => $post_vars['menu_name'], 'm_pos' => $post_vars['menu_position'],
		'm_topid' => $post_vars['menu_topid'], 'm_modus' => $post_vars['menu_modus'], 'm_page' => $post_vars['menu_page']);
		$std = array('m_name' => $entry_vars['menu_name'], 'm_pos' => '', 'm_topid' => '', 'm_modus' => '', 'm_page' => '');
		$err = array('m_name' => $error_vars['menu_name_error'], 'm_pos' => $error_vars['menu_position_error'],
		'm_topid' => $error_vars['menu_topid_error'], 'm_modus' => $error_vars['menu_modus_error'],
		'm_page' => $error_vars['menu_page_error']);



		$fmcheck_array = $formcheck->field_check_arr($val, $std);

		foreach ($fmcheck_array as $key => $value) {
			if ($value == false) {
				$answer[] = $err[$key];
			}
		}

		if (key_exists('menu_display', $post_vars)) {
			$val['m_display'] = true;
		} else {
			$val['m_display'] = false;
		}

		/* weitere Tests durchführen */
		if (!is_numeric($val['m_pos']) && !in_array($err['m_pos'], $answer)) {
			$answer[] = $err['m_pos'];
		}

		if (!is_numeric($val['m_topid']) && !in_array($err['m_topid'], $answer)) {
			$answer[] = $err['m_topid'];
		}

		if ($val['m_modus'] != 'pag' && $val['m_modus'] != 'mod' && !in_array($err['m_modus'], $answer)) {
			$answer[] = $err['m_modus'];
		}

		if (!is_numeric($val['m_page']) && !in_array($err['m_page'], $answer)) {
			$answer[] = $err['m_page'];
		}

		if (key_exists('ref_ID', $this->_gpc['GET']) && $val['m_topid'] == $this->_gpc['GET']['ref_ID']) {
			$answer[] = $error_vars['menu_topideqid_error'];
		}


		/* Keine Fehler gefunden -> Daten in $answer speichern */
		if (empty($answer)) {
			$answer = $val;
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
		$this->_tplfile = 'menu_editor.tpl';
		$smarty_array = array();
		$lang_vars = $this->_configvars['Editor-Entry'];




		if (is_array($error_arr) && !empty($error_arr)) {
			$smarty_array += array('dump_errors' => true, 'error_content' => implode("<br />\n", $error_arr));
		}


		if ($tk_mysql_values == true) {
			/*Daten von Mysql holen*/

			$sql = "SELECT `menu_ID`, `menu_topid`, `menu_position`, `menu_name`, `menu_pagetyp`,  `menu_page`, `menu_display`"
			." FROM `menu` WHERE `menu_ID` = '$ref_ID' LIMIT 1";
			$this->_mysql->query($sql);
			$data = $this->_mysql->fetcharray('assoc');

			if (!empty($data)) {
				$smarty_array += array('menu_ID' => $data['menu_ID'], 'menu_topid' => $data['menu_topid'],
				'menu_position' => $data['menu_position'], 'menu_name' => $data['menu_name'],
				'menu_modus' => $data['menu_pagetyp'], 'menu_page' => $data['menu_page']);

				if ($data['menu_display'] == '1') {
					$smarty_array['menu_display'] = true;
				}

			} else {
				throw new CMSException('Angegeben ID für Menueintrag ist nicht vorhanden', EXCEPTION_MODULE_CODE, 'Ungültige ID');
			}

		} elseif ($tk_std_values == false) {
			/* Daten vom POST-Formular nehmen */
			$post = $this->_gpc['POST'];

			$smarty_array += array('menu_name' => stripslashes($post['menu_name']), 'menu_position' => stripslashes($post['menu_position']),
			'menu_topid' => stripslashes($post['menu_topid']), 'menu_modus' => stripslashes($post['menu_modus']),
			'menu_page' => stripslashes($post['menu_page']));

			if (key_exists('menu_display', $post)) {
				$smarty_array['menu_display'] = $post['menu_display'];
			}

		} else {

			$smarty_array += array('menu_name' => $lang_vars['menu_name'], 'menu_position' => '0', 'menu_topid' => '0',
			'menu_page' => '1', 'menu_display' => true);

		}

		$menues = $this->_getMenues();

		foreach($menues as $key => $value) {
			$str = "";
			for ($i = 0; $i < $value['level']; $i++) {
				$str .= "&nbsp;&nbsp;";
			}

			$menues[$key]['menu_name'] = $str.htmlentities($value['menu_name']);
		}

		$smarty_array['menues'] = $menues;
		$smarty_array['positions'] = $this->_getPos(7);
		$this->_smarty->assign('editor', $smarty_array);
	}


	/**
	 * Gibt die Navigation in Form eines Arrays zurück
	 *
	 * @param int $start Start
	 * @param int $number Anzahl
	 * @param boolean $unit_topid untergeordnete Menus eines Topid-Menus (topid = 0) nicht trennen
	 * @return array Navigation
	 */

	private function _getMenues($start = null, $number = null, $unit_topid = true)
	{
		static $nav_arr = null;
		static $count_nav = null;

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

			$page->let_build_menu_array($topid_arr, $nav_arr, false, true, true, array('menu_position', 'menu_pagetyp', 'menu_display'));
			$count_nav['all'] = count($nav_arr);
			$count_nav['top'] = array();

			$i = 0;
			$count_nav['top'][0] = 0;
			foreach ($nav_arr as $key => $value) {
				if ($value['menu_topid'] == 0) {
					//$i = $value['menu_ID'];
					$i++;
					$count_nav['top'][$i] = 1;
				} else {
					$count_nav['top'][$i]++;
				}

			}
		}

		/* Hier wird nun der Bereich ausgewertet, welcher Teil des Menus zurückgegeben werden soll */
		if (isset($start)) {

			/* ist $unit_tropid true, wird eine topid = 0 und die darunterliegenden Menupunkte NICHT
			* getrennt, auch wenn die Anzahl der Menupunkte grösser ist als $number
			* Hat z.B. news (topid = 0) 10 darunterliegende Menupunkte, aber $number ist 7, wird news nicht
			* aufgeteilt, sondern als Einheit bewahrt. */
			if ($unit_topid == true) {

				$start = (int)$start;
				$count_start = 0;

				/*$i ist das Startelement von $nav_arr*/
				/* Die Anzahl Menupunkte für ein Topid (topid-menupunkt und darunterliegende)
				* sind in $count_nav['top'] aufgelistet. In dieser Schleife werden nun die
				* Anzahl Menupunkte zusammengezählt (speichern in $count_start), bis $start
				* erreicht wird. Ist $count_start nun grösser als $start, spielt das insofern
				* keine Rolle, weil die Topids zusammengehalten werden. */
				for($i = 0; $count_start < $start && $i < count($count_nav['top']); $i++) {
					$count_start += $count_nav['top'][$i];
				}

				if (isset($number)) {
					$number = (int)$number;
					$count_number = 0;

					/* Selbes Vorgehen wie bei der vorherigen For-Schleife */
					for ($j = $i; $count_number < ($count_start + $number) && $j < count($count_nav['top']); $j++) {
						$count_number += $count_nav['top'][$j];
					}

					return array_slice($nav_arr, $count_start, $count_number);

				} else {
					return array_slice($nav_arr, $count_start);
				}

			} else {
				/* Topids werde nicht zusammengehalten => einfaches Aufsplitten der Menues */
				if (isset($number)) {
					return array_slice($nav_arr, $start, $number);
				} else {
					return array_slice($nav_arr, $start);
				}
			}
		}

		/* Ohne Angabe von $start wird die gesammte Navigation zurückgegeben */
		return $nav_arr;

	}

	/**
	 * Liefert ein Array für die Auswahl von Positionen. Dieses wird im Template
	 * für die Auswahl in einer Select-Box gebraucht. Ist die $number z.B. 10, wird
	 * ein Array erstellt mit den Einträgen von -10 bis +10.
	 *
	 * @param int $number Abweichung von Null
	 * @return array Positionenarray
	 */
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
	 * Versucht, Menu-Probleme zu finden. U.a. wären dies folgende
	 * - Seite/Modul, auf die die Startseite verweisst, ist nicht erreichbar. 
	 * (Startseite wird mit der Mysql-Spalte `menu_position` bestummen).
	 * - Startseite-Menupunkt ist nicht erreichbar.
	 * - Menupunkte verweisen auf Seiten/Module, die nicht erreichbar sind.
	 * - Mehr als ein Menu-Punkt ist einem Inhalt/Modul zugewiesen
	 * - Ein Inhalt/Modul wird nicht von einem Menu-Punkt verwiesen
	 * 
	 *
	 */

	private function _checkMenuProbs()
	{
		;
	}

}


?>
