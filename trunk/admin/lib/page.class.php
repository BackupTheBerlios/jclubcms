<?php

/**
 * Diese Klasse ist fuer die Darstellung der Seite verantworlich. Sie bietet geeignete Methoden fuer die Menudarstellung und
 * Seitennavigation an (vormals in pagesnav.class gelagert)
 * 
 * @author Simon Daester
 * @package JClubCMS
 * File: page.class.php
 * class: Page
 * requires: mysql.class.php, Smarty.class.php
 * 
 *
 */



class Page
{
	private $smarty;
	private $mysql;
	private $auth;

	/**
	 * Initialisiert die Klasse
	 *
	 * @param Smarty $smarty
	 * @param Mysql $mysql
	 */

	public function __construct($smarty, $mysql)
	{
		$this->smarty = $smarty;
		$this->mysql = $mysql;
		$this->auth = new Auth($this, $mysql);
	}


	/**
	 * Gibt das Menu-Array zurueck, um das Menu darzustellen
	 *
	 * @param boolean $shortlinks Sind in der topnav shortlinks?
	 * @param boolean $admin_menu Muss das Admin-Menu dargestellt werden?
	 * @return array $menu_array Array mit den Menu-Eintraegen Keys: nav_id, topnav, subnav
	 */


	public function get_menu_array($get_array, $shortlinks = false, $admin_menu = false)
	{
		$menu_array = array();

		if (array_key_exists('nav_id',$get_array)) {
			$nav_id = (int)$get_array['nav_id'];
		} else {
			$nav_id = 0;
		}

		//Ob es das Admin- oder User-Menu ist, aendert sich der Tabellen-Name im MySQL.
		$table_name = ($admin_menu === true)?"admin_menu":"menu";

		//Ist $nav_id kleiner gleich Null, wird ihr der erste Wert aus der MySQL-Tabelle zugewiesen.
		if($nav_id <= 0) {
			$this->mysql->query("SELECT `menu_ID` FROM `$table_name` ORDER BY `menu_position` ASC LIMIT 1");
			$nav_id = $this->mysql->fetcharray('num');
			$nav_id = $nav_id[0];
		}

		//Ist $shortlinks an, so wird die shortlinks-Funktion aufgerufen, sonst topidsmenu-Funktion
		$menu_array = ($shortlinks == true) ? $this->_get_shortlinksmenu_array($nav_id, $table_name) :
		$this->_get_topidsmenu_array($nav_id, $table_name);

		//Damit muss im index nicht nochmal die $nav_id kontroliert werden
		$menu_array['nav_id'] = $nav_id;


		return $menu_array;
	}



	public static function get_current_page($get_array)
	{
		if (!key_exists('page', $get_array) || $get_array['page'] < 1) {
			return 1;
		} else {
			return $get_array['page'];
		}
	}



	/**
	 * Liefert ein Array, welches die Eintraege der Seitennavigation enthält.
	 * Vorher erledigte dies die Klasse pagesnav
	 *
	 * @param int $number_entries Anzahl der Eintraege
	 * @param int $max_entries_pp maximale Anzahl Eintraege pro Seite
	 * @param array $get_array Inhalt von $_GET, kontroliert abzugeben
	 * @return array $pages_array Array der Eintraege
	 */

	public function get_pagesnav_array($number_entries, $max_entries_pp, $get_array)
	{
		return self::get_static_pagesnav_array($number_entries, $max_entries_pp, $get_array);
	}


	/**
	 * Liefert ein Array, welches die Eintraege der Seitennavigation enthält.
	 * Klasse braucht nicht initialisiert zu werden.
	 * 
	 *
	 * @param int $number_entries Anzahl der Eintraege
	 * @param int $max_entries_pp maximale Anzahl Eintraege pro Seite
	 * @param array $get_array Inhalt von $_GET, kontroliert abzugeben
	 * @return array $pages_array Array der Eintraege
	 */

	public static function get_static_pagesnav_array($number_entries, $max_entries_pp, $get_array)
	{
		//$main_url = $_SERVER['REQUEST_URI'];
		$main_url = $_SERVER['PHP_SELF'];
		$nav_id = $get_array['nav_id'];
		$apendices = "";

		$page = self::get_current_page($get_array);


		foreach ($get_array as $key => $value) {
			if ($key != 'nav_id' && $key != 'page') {
				$apendices .= "&amp;$key=$value";
			}
		}


		$number_of_pages = ceil($number_entries / $max_entries_pp);

		$pages_array = array();

		/* Vorwärtslink setzen */
		if ($page > 1) {
			$link = $main_url.'?nav_id='.$nav_id.'&amp;page='.($page-1).$apendices;
			$pages_array[0] = array('page'=>'<', 'link'=>$link);
		}

		/*Seiten dazwischen ausgeben */
		for ($i = 1; $i <= $number_of_pages; $i++) {

			if ($i == $page) {
				$link = null;
			} else {
				$link = $main_url.'?nav_id='.$nav_id.'&amp;page='.$i.$apendices;
			}
			$pages_array[$i] = array('page'=>$i, 'link'=>$link);

		}


		/* Rückwärtslink setzen */
		if ($page < $number_of_pages) {
			$link = $main_url.'?nav_id='.$nav_id.'&amp;page='.($page+1).$apendices;
			$pages_array[] = array('page'=>'>', 'link'=>$link);
		}

		return $pages_array;
	}

	/**
	 * Gibt die URL zurueck mit dem aktuellen Skriptund allen $_GET-Variablen ausser denen,
	 * welche im Array $black_list aufgelistet sind 
	 *
	 * @param array $get_array Array der $_GET-Variablen
	 * @param array $black_list Array mit den $_GET-Keys, die nicht vorkommen sollen
	 * @return string $url URL-String
	 */

	public function getUri($get_array, $black_list)
	{
		return self::getUriStatic($get_array, $black_list);
	}

	/**
	 * Gibt die URL zurueck mit dem aktuellen Skriptund allen $_GET-Variablen ausser denen,
	 * welche im Array $black_list aufgelistet sind 
	 *
	 * @param array $get_array Array der $_GET-Variablen
	 * @param array $black_list Array mit den $_GET-Keys, die nicht vorkommen sollen
	 * @return string $url URL-String
	 */

	public static function getUriStatic($get_array, $black_list = array())
	{
		$main_url = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];

		$apendices = "";

		$i = 0;
		foreach ($get_array as $key => $value) {

			if (in_array($key, $black_list) == false) {
				if ($i == 0) {
					$sep = '?';
				} else {
					$sep = '&amp;';
				}

				$apendices .= $sep."$key=$value";

				$i++;
			}
		}
		return $main_url.$apendices;
	}

	/**
	 * Baut ein Menu-Array auf. Das mitgelieferte Topid-Array wird durchgearbeitet, indem zuerst alle
	 * Menu-Einträge der ersten TopID (1. Schlüssel des TopID-Arrays) aus der Datenbank gelesen werden.
	 * Die Menu-Einträge werden durchgearbeitet als Array durchgearbeitet. Tritt ein Menu-Eintrag auf, welcher
	 * die Menu-ID hat, welcher der Id des 2. Schlüssels des TopID-Arrays entspricht, werden alle Menu-Einträge
	 * mit dieser TopID aufgerufen. Das ganze beginnt dann wieder von vorn mit dem durcharbeiten, menuID = topID usw.
	 * Daher wird bei menuID = topID die Funktion rekursiv aufgerufen
	 *
	 * @param array $topid_array Array mit den Top-IDs
	 * @param array[reference] &$subnav_array Array, wo die Navigation gespeichert wird
	 * @param bool Admin-Menu oder User-Menu
	 * @param bool[optional] $show Nur die aktiven und übergeorndete Menues oder alle(!) Menues ausklappen
	 */

	public function let_build_menu_array($topid_array, &$menu_array, $admin_menu = false, $show_all = false)
	{
		//Ob es das Admin- oder User-Menu ist, aendert sich der Tabellen-Name im MySQL.
		$table_name = ($admin_menu === true)?"admin_menu":"menu";
		return $this->_build_subnav_array($table_name, $topid_array, &$menu_array, $show_all, true);
	}

	/**
	 * Destruktor der Klasse
	 *
	 */

	public function __destruct()
	{
		$this->smarty = null;
		$this->mysql = null;
		$this->auth = null;
	}


	/**
	 * Liefert ein Array zurueck, welches die Menu-Eintraege enthaelt. Die shortlinks-Menu befinden sich hier in der topnav.
	 *
	 * @param int $nav_id Navigations-Id
	 * @param string $table_name Name der Mysql-Tabelle
	 * @return array Menu-Array
	 */

	private function _get_shortlinksmenu_array($nav_id, $table_name)
	{
		$menu_array = array();
		$topid_array = array();

		$topid_array[0] = $nav_id;

		$i = 1;
		$id = $nav_id;
		$top_id = array();

		//Top-IDs herauslesen, damit die rekursive Funktion richtig arbeiten kann, um subnav-Array zu erstellen
		do {
			$this->mysql->query("SELECT `menu_topid` FROM `$table_name` WHERE `menu_ID` = $id
								ORDER BY `menu_position`ASC LIMIT 1");
			$top_id = $this->mysql->fetcharray("num");
			$topid_array[$i] = $top_id[0];
			$id = $top_id[0];

			$i++;
		} while ($top_id[0] != 0);


		//topid-Array umkehren, damit oberste Schicht der Menus zuerst ausgelesen wird
		$topid_array = array_reverse($topid_array);
		/*$temp_array = $topid_array;
		$max = count($topid_array);
		for($i = 0; $i < $max; $i++)
		{
		$topid_array[$i] = $temp_array[$max-$i-1];
		}*/


		//Funktion aufrufen, damit subnav-Array erstellt wird
		$this->_build_subnav_array($table_name, $topid_array, $menu_array['subnav']);


		//topnav-Array erstellen
		$this->mysql->query("SELECT `menu_ID`, `menu_name`, `menu_image`, `menu_modvar` FROM `$table_name`
							WHERE `menu_topid` = '0' AND `menu_display` != '0' AND menu_shortlink = '1' 
							ORDER BY `menu_position` ASC");
		$i = 0;
		$this->mysql->saverecords('assoc');
		$menu_array['topnav'] = $this->mysql->get_records();

		return $menu_array;
	}


	/**
	 * Gibt das Menu-Array zurück, wo die Top-Navigation aus Eintraegen mit topID == 0 besteht
	 *
	 * @param int $nav_id Navigations-ID
	 * @param string $table_name Name der MySQL-Tabelle
	 * @return array $menu_array Array des Menus
	 */

	private function _get_topidsmenu_array($nav_id, $table_name)
	{
		$menu_array = array();
		$topid_array = array();


		$topid_array[0] = $nav_id;

		$i = 1;
		$id = $nav_id;
		$top_id = array();

		//Top-IDs herauslesen, damit die rekursive Funktion richtig arbeiten kann, um subnav-Array zu erstellen
		do {
			$this->mysql->query("SELECT `menu_topid` FROM `$table_name` WHERE `menu_ID` = $id
								ORDER BY `menu_position` ASC LIMIT 1");
			$top_id = $this->mysql->fetcharray("num");

			if($top_id[0] == 0) {
				//Die Eintraege mit der top_Id 0 befinden sich in der topnav, daher wird hier abgebrochen!
				break;
			}
			$topid_array[$i] = $top_id[0];
			$id = $top_id[0];

			$i++;
		} while (true);

		//topid-Array umkehren, damit oberste Schicht der Menus zuerst ausgelesen wird
		$temp_array = $topid_array;
		$max = count($topid_array);
		for($i = 0; $i < $max; $i++)
		{
			$topid_array[$i] = $temp_array[$max-$i-1];
		}

		//Funktion aufrufen, damit subnav-Array erstellt wird
		$this->_build_subnav_array($table_name, $topid_array, $menu_array['subnav']);

		//topnav-Array erstellen
		$this->mysql->query("SELECT `menu_ID`, `menu_name`, `menu_modvar` FROM `$table_name`
							WHERE `menu_topid` = '0' AND `menu_display` != '0' ORDER BY `menu_position` ASC");
		$i = 0;

		$this->mysql->saverecords('assoc');
		$menu_array['topnav'] = $this->mysql->get_records();


		return $menu_array;

	}

	/**
	 * Baut das Subnav-Array auf. Das mitgelieferte Topid-Array wird durchgearbeitet, indem zuerst alle
	 * Menu-Einträge der ersten TopID (1. Schlüssel des TopID-Arrays) aus der Datenbank gelesen werden.
	 * Die Menu-Einträge werden durchgearbeitet als Array durchgearbeitet. Tritt ein Menu-Eintrag auf, welcher
	 * die Menu-ID hat, welcher der Id des 2. Schlüssels des TopID-Arrays entspricht, werden alle Menu-Einträge
	 * mit dieser TopID aufgerufen. Das ganze beginnt dann wieder von vorn mit dem durcharbeiten, menuID = topID usw.
	 * Daher wird bei menuID = topID die Funktion rekursiv aufgerufen
	 *
	 * @param string $table_name Name der MySQL-Tabelle
	 * @param array $topid_array Array mit den Top-IDs
	 * @param array[reference] &$subnav_array Array, wo die Navigation gespeichert wird
	 * @param bool[optional] $show Nur die aktiven und übergeorndete Menues oder alle(!) Menues ausklappen
	 * @param bool $reset Alle Variablen zurücksetzen (nötig wenn Funktion verschiedene Male aufgerufen wird)
	 */

	private function _build_subnav_array($table_name, &$topid_array, &$subnav_array, $show_all = false, $reset = false)
	{
		$mysql_array = array();
		//$j wird gebraucht, um $topid_array durchzugehen. $i brauchts fuer $subnav_array.
		static $i = 0, $st_level = 0;
		if ($reset == true) {
			$i = 0; $st_level = 0;
		}

		$this->mysql->query("SELECT `menu_ID`,`menu_topid`, `menu_name`, `menu_modvar`, `menu_page`as '_menu_page' 
							FROM `$table_name`
							WHERE `menu_topid` = '{$topid_array[0]}' AND `menu_display` != '0' 
							AND `menu_shortlink` != '1' ORDER BY `menu_position` ASC");

		$mysql_array = $this->mysql->get_records();

		//Durchlaeuft $mysql_array und baut so die Navigation auf.
		//$j++;

		//$level aendert sich nicht innerhalb der Funktion.
		$st_level++;
		array_shift($topid_array);

		$lc_level = $st_level;
		//Baut den Navigationsbaum auf, indem bei jedem Treffer Topid -> menu_Id ein neuer Ast entsteht.
		foreach ($mysql_array as $value) {

			$value['menu_name'] = htmlentities($value['menu_name']);
			$subnav_array[$i] = $value;
			$subnav_array[$i]['level'] = $lc_level;
			$i++;
			

			/**if($j < count($topid_array) && $value['menu_ID'] == $topid_array[$j])
			{
			$this->_build_subnav_array($table_name, $topid_array, $subnav_array);
			}*/
			if ($show_all == true && count($topid_array) > 0 && in_array($value['menu_ID'], $topid_array)) {
				$key = array_search($value['menu_ID'], $topid_array);
				if ($key != 0) {
					$topid_array[0] = $topid_array[$key];
					unset($topid_array[$key]);
				}
				$this->_build_subnav_array($table_name, &$topid_array, $subnav_array, $show_all);

			} elseif (count($topid_array) > 0 && $value['menu_ID'] == $topid_array[0]) {
				$this->_build_subnav_array($table_name, $topid_array, $subnav_array);
			}

		}
	}


}
?>