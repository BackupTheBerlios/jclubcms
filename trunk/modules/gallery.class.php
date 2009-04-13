<?php

require_once ADMIN_DIR."lib/page.class.php";

require_once ADMIN_DIR.'lib/module.interface.php';
require_once ADMIN_DIR.'lib/messageboxes.class.php';
require_once ADMIN_DIR.'lib/smilies.class.php';
require_once USER_DIR.'config/gbook_textes.inc.php';

/**
 * Dieses Modul ist für die Gallery zuständig, die Anzeige von Bildern
 * in den verschiedenen Alben und richtigen Reihenfolge
 *
 * INFO:
 * @package JClubCMS
 * @author Simon Däster
 * File: gallery.php
 * Classes: none
 * Requieres: PHP5
 */

class Gallery implements Module
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
	 * Führt die einzelnen Methoden aus, abhaengig vom parameter
	 * @global string dir_smilies Used for the dir where the smilies-gif are saved
	 * @param array $parameters POST, GET und COOKIE-Variablen
	 */

	public function action($gpc)
	{
		//Daten initialisieren
		$this->_gpc = $gpc;
		$this->_smilie = new Smilies(SMILIES_DIR);

		/*
		Unterstützung in der nächsten Version
		if (key_exists('comment', $this->_gpc['GET'])) {
		$this->_commentImg($this->_gpc['GET']['comment']);
		}*/

		/* Je nach Parameter wird eine andere Methode aufgerufen */
		/* Die $_GET-Schlüsseln werden gelesen und mit den Optionen verglichen */
		$keys = array_keys($this->_gpc['GET']);
		$exit = false;
		while ($exit != true && ($mode = next($keys)) !== false) {
			$ID = $this->_gpc['GET'][$mode];
			switch ($mode) {
				case 'gal':
					$this->_showGallery($ID);
					$exit = true;
					break;
				case 'cat':
					$this->_showCat($ID);
					$exit = true;
					break;
				case 'img':
					$this->_showImg($ID);
					$exit = true;
					break;
				default:
					$exit = false;
			}
		}

		/* Wenn keine Option zutrifft -> Standartaktion */
		if ($exit == false) {
			$this->_showCat(null);
		}

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
	 * Kategorie anzeigen inklusive Unterkategorien. Kategoriene können übergeordnete und 
	 * untergeordnete Kategorien haben. Gallerien können nur Bilder enthalten und sind einer
	 * Kategorie untergeordnet.
	 *
	 * @param int $cat_ID Kategorie-ID
	 */
	private function _showCat($cat_ID) {
		$this->_tplfile = 'gallery.tpl';

		if ($cat_ID == null) {
			$cat_ID = 0;
		}

		$entries = array();

		/* Untergerodnete Kategorien auslesen */
		$this->_mysql->query("SELECT `ID`,`ref_ID`, `name`,`comment`, DATE_FORMAT(`time`, '%d.%m.%Y') as 'time'
							FROM `gallery_categories`
							WHERE `gallery_categories`.`ref_ID` = '$cat_ID'");
		$this->_mysql->saverecords('assoc');
		$entries['cat'] = $this->_mysql->get_records();

		/* Untergeordnete Gallerien auslesen */
		/* Wenn die oberste Kategorie ($cat_id = 0 ) ausgelesen wird, werden alle Gallerien angezeigt */
		
		if(SHOW_ALL_GALLERIES_ON_TOP == true && $cat_ID == 0) {
			$this->_mysql->query("SELECT `ID`,`name`,`comment`,DATE_FORMAT(`time`, '%d.%m.%Y') as 'time' FROM `gallery_alben`");
		} else {
		
		$this->_mysql->query("SELECT `ID`,`name`,`comment`,DATE_FORMAT(`time`, '%d.%m.%Y') as 'time' FROM `gallery_alben`
							WHERE `gallery_alben`.`ref_ID` = '$cat_ID'");
		}
		$this->_mysql->saverecords('assoc');
		$entries['gal'] = $this->_mysql->get_records();

		if ($cat_ID != 0) {
			$this->_mysql->query("SELECT `name` FROM `gallery_categories`
							WHERE `gallery_categories`.`ID` = '$cat_ID'");
			$cat = $this->_mysql->fetcharray('assoc');

			$root = $this->_getRoot($cat_ID);
		} else {
			$cat['name'] = 'Hauptseite';
			$root = $this->_getRoot($cat, false, false);
		}

		$this->_smarty->assign('root', $root);
		$this->_smarty->assign('cat_name', $cat['name']);
		$this->_smarty->assign('categories', $entries['cat']);
		$this->_smarty->assign('galleries', $entries['gal']);

	}

	/**
	 * Zeigt die Gallery an, genauer einen Teil der Bilder zu der gehörenden Gallery.
	 * Eine Gallery kann in mehrere Seiten unterteilt sein, je nach der Anzahl der Bilder.
	 * Eine Gallery kann eine übergeordnete Kategorie haben, jedoch keine übergeordnete Gallery.
	 * @global int gallery_pics_x Number of pictures in x
	 * @global int $gallery_pics_y Number of pictures in y
	 * @param int $gal_ID Gallery-ID
	 */
	private function _showGallery($gal_ID)
	{
		$this->_tplfile = 'gallery_album.tpl';
		/* Anzeige-Config-Daten auslesen */
		include_once(USER_DIR.'config/user-config.inc.php');


		/*Aktuelle Seite ermitteln */
		$page = Page::get_current_page($this->_gpc['GET']);

		//Ein paar Daten berechnen
		$bildproseite = (int)(GALLERY_PICS_X * GALLERY_PICS_Y);
		$start = (int)(($page-1)*$bildproseite);


		//Anzahl Eintraege
		$this->_mysql->query("SELECT * FROM gallery_eintraege WHERE fid_album = '$gal_ID'");
		$number = $this->_mysql->num_rows();



		//Eintraege und Albenname abrufen
		$this->_mysql->query("SELECT `gallery_eintraege`.`fid_bild` as 'img_ID', `gallery_alben`.`name`, `gallery_alben`.`ref_ID`
							FROM `gallery_eintraege`,`gallery_alben`
							WHERE `gallery_alben`.`ID` = '$gal_ID' AND `gallery_eintraege`.`fid_album` = '$gal_ID'
							ORDER BY `gallery_eintraege`.`sequence`
							LIMIT $start,$bildproseite");

		$this->_mysql->saverecords('assoc');
		$gallery_imgs = $this->_mysql->get_records();
		$gallery_name = $gallery_imgs[0]['name'];
		$cat_ID = $gallery_imgs[0]['ref_ID'];

		$pages_array = Page::get_static_pagesnav_array($number, $bildproseite, $this->_gpc['GET']);

		$root = $this->_getRoot($cat_ID, true);

		//Smarty-Variablen belegen
		$this->_smarty->assign('root', $root);
		$this->_smarty->assign("pages", $pages_array);
		$this->_smarty->assign("gallery", $gallery_imgs);
		$this->_smarty->assign(array('thispage' => $page, 'number' => $number, 'gal_ID' => $gal_ID,
		'top_ID' => $root[(count($root) - 1)]['ID'], 'gallery_name' => $gallery_name, 'breakline' => GALLERY_PICS_X));


	}

	/**
	 * Anzeige des Bildes 
	 *
	 * @param unknown_type $img_ID
	 */

	private function _showImg($img_ID) {
		$this->_tplfile = 'gallery_pic.tpl';;

		//Die benötigten Daten für das Bild von der DB holen
		$this->_mysql->query("SELECT `gallery_eintraege`.`fid_bild`, `gallery_eintraege`.`fid_album`,
			`gallery_eintraege`.`sequence`,	`gallery_eintraege`.`sequence`, `bilder`.`filename`, 
			`gallery_alben`.`ref_ID`, `gallery_alben`.`name`
		FROM `bilder`, `gallery_eintraege`, `gallery_alben`
		WHERE `fid_bild` = '$img_ID' AND `bilder_ID` = '$img_ID' AND `gallery_alben`.`ID` = `gallery_eintraege`.`fid_album`
		LIMIT 1");
		$shown_bild = $this->_mysql->fetcharray("assoc");

		//Zur Vereinfachung
		$album_ID = $shown_bild['fid_album'];
		$bild_sequence = (int)$shown_bild['sequence'];
		$album_name = $shown_bild['name'];

		/* Wurzel bestimmen */
		$root = $this->_getRoot($shown_bild['ref_ID'], true);

		
		/* Zahlen ermitteln */
		$this->_mysql->query("SELECT * FROM gallery_eintraege WHERE fid_album = '$album_ID'");
		$count = $this->_mysql->num_rows();





		//Das vordere Bild
		$this->_mysql->query("SELECT `fid_bild` FROM `gallery_eintraege`
							WHERE `sequence` < '$bild_sequence' and `fid_album` = '$album_ID'
							ORDER BY sequence DESC Limit 1");
		$prev_bild = $this->_mysql->fetcharray("assoc");

		//Das hintere Bild
		$this->_mysql->query("SELECT `fid_bild` FROM `gallery_eintraege`
							WHERE `sequence` > '$bild_sequence' and `fid_album` = '$album_ID'
							ORDER BY sequence ASC Limit 1");
		$next_bild = $this->_mysql->fetcharray("assoc");

		//Smarty-Variablen
		$this->_smarty->assign("album", array('ID' => $album_ID, 'name' => $album_name));

		$this->_smarty->assign(array('ID_bild' => $img_ID, 'prev_bild' => $prev_bild['fid_bild'],
		'next_bild' => $next_bild['fid_bild'], 'filename' => $shown_bild['filename'], 'count' => $count,
		'number' => $shown_bild['sequence']));

		$this->_smarty->assign("root", $root);

	}


	/**
	 * Kommentare zu den Bildern abgeben
	 * @todo In der nächsten Version, voraussichtlich
	 *
	 * @param int $img_ID
	 */
//	private function _commentImg($img_ID)
//	{
//		/*$msbox = new Messageboxes($this->_mysql, 'news', array('ID' => 'news_ID', 'ref_ID' => 'news_ref_ID', 'content' => 'news_content', 'name' => 'news_name', 'time' => 'news_time', 'email' => 'news_email', 'hp' => 'news_hp', 'title' => 'news_title'));*/
//	}

	/**
	 * Liefert der Path der Kategorien aus von der angegebenen Kategorie bis zur Hauptseite.
	 * Das zurückgelieferte Array sieht etwa folgendermassen aus:
	 * array(0 => Hauptseite, 1 => Kategorie 1, 2 => Kategorie 1.1, 3 => ...)
	 *
	 * @param int $cat_ID KategorieID der untersten Kategorie
	 * @param bool[optional] $inc_catID Gibt an, ob die Kategorie mit ID = $cat_ID auch in der Wurzel vorkommen soll
	 * @param bool[optional] $inc_hs Gibt an, ob der Eintrag 'Hauptseite' auch in der Wurzel vorkommen soll
	 * @return array $root_array Path der Kategorien.
	 */

	private function _getRoot($cat_ID, $inc_catID = false, $inc_hs = true)
	{
		/* Wurzel auslesen */
		$tmp_arr = array();
		if ($inc_catID == false) {
			$this->_mysql->query("SELECT `ref_ID` FROM `gallery_categories` WHERE `ID` = '$cat_ID' LIMIT 1");
			$data = $this->_mysql->fetcharray('assoc');
			$tmp_ID = $data['ref_ID'];
		} else {
			$tmp_ID = $cat_ID;
		}

		for ($i = 0; $tmp_ID != 0; $i++) {
			$this->_mysql->query("SELECT `ID`,`ref_ID`,`name` FROM `gallery_categories` WHERE `ID` = '$tmp_ID' LIMIT 1");
			$tmp_arr[$i] = $this->_mysql->fetcharray('assoc');

			$tmp_ID = $tmp_arr[$i]['ref_ID'];
		}

		if ($inc_hs == true) {
			/*Hauptseite noch einfügen*/
			$tmp_arr[++$i] = array('ID' => '0', 'name' => 'Hauptseite');
			return array_reverse($tmp_arr);
		} else {
			return null;
		}
	}
}
?>
	
