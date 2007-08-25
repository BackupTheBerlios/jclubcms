<?php

/**
 * @author Simon Daester
 * @package JClubCMS
 * File: page.class.php
 * class: Page
 * requires: mysql.class.php, Smarty.class.php
 * 
 * Diese Klasse ist fuer die Darstellung der Seite verantworlich. Sie bietet geeignete Methoden fuer die Menudarstellung und
 * Seitennavigation an (vormals in pagesnav.class gelagert)
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

	public function get_menu_array($nav_id, $shortlinks = false, $admin_menu = false)
	{
		$mysql = $this->mysql;
		$menu_array = array();

		//Ob es das Admin- oder User-Menu ist, aendert sich der Tabellen-Name im MySQL.
		$table_name = ($admin_menu == true)?"admin_menu":"menu";

		//Ist $nav_id kleiner gleich Null, wird ihr der erste Wert in der MySQL-Tabelle zugewiesen.
		if($nav_id <= 0)
		{
			$mysql->query("SELECT `menu_ID` FROM `$table_name` LIMIT 1");
			$nav_id = $mysql->fetcharray();
			$nav_id = $nav_id[0];
		}




		//Ist $shortlinks an, so wird die shortlinks-Funktion aufgerufen, sonst topidsmenu-Funktion
		$menu_array = ($shortlinks == true) ? $this->get_shortlinksmenu_array($nav_id, $table_name) : $this->get_topidsmenu_array($nav_id, $admin_menu);



		return $menu_array;
	}

	private function get_shortlinksmenu_array($nav_id, $table_name)
	{
		;
	}

	private function get_topidsmenu_array($nav_id, $table_name)
	{
		$mysql = $this->mysql;
		$menu_array = array();
		$topid_array = array();


		$topid_array[0] = $nav_id;

		$i = 1;
		$id = $nav_id;
		$top_id = 0;

		//Top-IDs herauslesen, damit die rekursive Funktion richtig arbeiten kann, um subnav-Array zu erstellen
		do {
			$mysql->query(" SELECT `menu_topid` FROM `$table_name` WHERE `menu_ID` = $id ORDER BY `menu_position` ASC LIMIT 1");
			$top_id = $mysql->fetcharray();

			if($top_id[0] == 0) {
				//Die Eintraege mit der top_Id 0 befinden sich in der topnav, daher wird hier abgebrochen!
				break;
			}
			$topid_array[$i] = $top_id[0];
			$id = $top_id[0];

			$i++;
		} while (true);

		//Funktion aufrufen, damit subnav-Array erstellt wird
		build_subnav_array($table_name, $topid_array, &$menu_array['subnav']);

		//topnav-Array erstellen

	}

	private function build_subnav_array($table_name, $topid_array, &$subnav_array)
	{
		$mysql = $this->mysql;
		for($i = 0; $i < count($topid_array); $i++)
		{
			
			$mysql->query("SELECT * FROM `$table_name` WHERE `menu_topid` = {$topid_array[$i]} ORDER BY `menu_position` ASC");
			while($data = $mysql->fetcharray("assoc"))
			{
				;
			}
			
		}

	}




	/**
	 * Liefert ein Array, welches die Eintraege der Seitennavigation enthält.
	 * Vorher erledigte dies die Klasse pagesnav
	 *
	 * @param int $number_entries Anzahl der Eintraege
	 * @param int $max_entries_pp maximale Anzahl Eintraege pro Siete
	 * @return array $pages_array Array der Eintraege
	 */

	public function get_pagesnav_array($number_entries, $max_entries_pp)
	{
		return self::get_static_pagesnav_array($number_entries, $main_url);
	}


	/**
	 * Die statische(!) Funktion zur Rueckgabe der Seitennavigation.
	 * Sie kann aufgerufen werden, ohne dass es eine Initialisierung der Klasse braucht
	 * Nachtrag: warscheinlich unnötig, da index.php die klasse Page initialiert.
	 * 
	 *
	 * @param int $number_entries Anzahl der Eintraege
	 * @param int $max_entries_pp maximale Anzahl Eintraege pro Siete
	 * @return array $pages_array Array der Eintraege
	 */

	public static function get_static_pagesnav_array($number_entries, $max_entries_pp)
	{
		$main_url = $_SERVER['_URI'];
		$nav_id = $_REQUEST['nav_id'];
		$page = $_REQUEST['page'];
		if ($page < 0) {
			$page = 0;
		}

		$number_of_pages = $number_entries / $max_entries_pp;

		$pages_array = array();
		for ($i = 0; $i < $number_of_pages; $i++) {
			$link = $main_url.'?nav_id='.$nav_id.'&page='.$i;
			$pages_array[$i] = array('page'=>$i+1, 'link'=>$link);
		}

		return $pages_array;
	}



	public function __destruct()
	{
		$this->smarty = null;
		$this->mysql = null;
		$this->auth = null;
	}


}
?>