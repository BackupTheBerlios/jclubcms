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
	 * @return array $menu_array Array mit den Menu-Eintraegen
	 */

	public function get_menu_array($shortlinks = false, $admin_menu = false)
	{
		$menu_array = array();

		$nav_id = (int)$_GET['nav_id'];

		//Ob es das Admin- oder User-Menu ist, aendert sich der Tabellen-Name im MySQL.
		$table_name = ($admin_menu == true)?"admin_menu":"menu";

		//Ist $nav_id kleiner gleich Null, wird ihr der erste Wert aus der MySQL-Tabelle zugewiesen.
		if($nav_id <= 0)
		{
			$this->mysql->query("SELECT `menu_ID` FROM `$table_name` ORDER BY `menu_position` LIMIT 1");
			$nav_id = $this->mysql->fetcharray();
			$nav_id = $nav_id[0];
		}

		//Ist $shortlinks an, so wird die shortlinks-Funktion aufgerufen, sonst topidsmenu-Funktion
		$menu_array = ($shortlinks == true) ? $this->get_shortlinksmenu_array($nav_id, $table_name) : $this->get_topidsmenu_array($nav_id, $table_name);

		//Damit muss im index nicht nochmal die $nav_id kontroliert werden
		$menu_array['nav_id'] = $nav_id;

		return $menu_array;
	}

	/**
	 * Liefert ein Array zurueck, welches die Menu-Eintraege enthaelt. Die shortlinks-Menu befinden sich hier in der topnav.
	 *
	 * @param int $nav_id Navigations-Id
	 * @param string $table_name Name der Mysql-Tabelle
	 * @return array Menu-Array
	 */

	private function get_shortlinksmenu_array($nav_id, $table_name)
	{
		$menu_array = array();
		$topid_array = array();

		$topid_array[0] = $nav_id;

		$i = 1;
		$id = $nav_id;
		$top_id = 0;

		//Top-IDs herauslesen, damit die rekursive Funktion richtig arbeiten kann, um subnav-Array zu erstellen
		do {
			$this->mysql->query("SELECT `menu_topid` FROM `$table_name` WHERE `menu_ID` = $id ORDER BY `menu_position`ASC LIMIT 1");
			$top_id = $this->mysql->fetcharray("num");
			$topid_array[$i] = $top_id[0];
			$id = $top_id[0];

			$i++;
		} while ($top_id[0] != 0);


		//topid-Array umkehren, damit oberste Schicht der Menus zuerst ausgelesen wird
		$temp_array = $topid_array;
		$max = count($topid_array);
		for($i = 0; $i < $max; $i++)
		{
			$topid_array[$i] = $temp_array[$max-$i-1];
		}

		//echo "In get_shortlinksmenu_array: <pre>".print_r($topid_array, 1)."</pre> <br />\n";

		//Funktion aufrufen, damit subnav-Array erstellt wird
		$this->build_subnav_array($table_name, $topid_array, &$menu_array['subnav']);

		//topnav-Array erstellen
		$this->mysql->query("SELECT `menu_ID`, `menu_name`, `menu_image`, `menu_modvar` FROM `$table_name` WHERE `menu_topid` = '0' AND `menu_display` != '0' AND menu_shortlink = '1' ORDER BY `menu_position` ASC");
		$i = 0;
		while($data = $this->mysql->fetcharray('assoc'))
		{
			$menu_array['topnav'][$i++] = $data;
		}

		return $menu_array;
	}


	/**
	 * Gibt das Menu-Array zurück, wo die Top-Navigation aus Eintraegen mit topID == 0 besteht
	 *
	 * @param int $nav_id
	 * @param string $table_name
	 * @return array $menu_array
	 */

	private function get_topidsmenu_array($nav_id, $table_name)
	{
		$menu_array = array();
		$topid_array = array();


		$topid_array[0] = $nav_id;

		$i = 1;
		$id = $nav_id;
		$top_id = 0;

		//Top-IDs herauslesen, damit die rekursive Funktion richtig arbeiten kann, um subnav-Array zu erstellen
		do {
			$this->mysql->query("SELECT `menu_topid` FROM `$table_name` WHERE `menu_ID` = $id ORDER BY `menu_position` ASC LIMIT 1");
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
		$this->build_subnav_array($table_name, $topid_array, &$menu_array['subnav']);

		//topnav-Array erstellen
		$this->mysql->query("SELECT `menu_ID`, `menu_name`, `menu_modvar` FROM `$table_name` WHERE `menu_topid` = '0' AND `menu_display` != '0' ORDER BY `menu_position` ASC");
		$i = 0;
		while($data = $this->mysql->fetcharray('assoc'))
		{
			$menu_array['topnav'][$i++] = $data;
		}

		return $menu_array;

	}

	/**
	 * Baut das Subnav-Array auf
	 *
	 * @param string $table_name
	 * @param array $topid_array
	 * @param array[reference] &$subnav_array
	 */

	private function build_subnav_array($table_name, $topid_array, &$subnav_array)
	{
		$mysql_array = array();
		//$j wird gebraucht, um $topid_array durchzugehen. $i brauchts fuer $subnav_array.
		static $i = 0, $j = 0;

		$this->mysql->query("SELECT `menu_ID`, `menu_name`, `menu_modvar` FROM `$table_name` WHERE `menu_topid` = '{$topid_array[$j]}' AND `menu_display` != '0' AND `menu_shortlink` != '1' ORDER BY `menu_position` ASC");
		
		/*Ehemaliger Code: Ungueltig, denn shortlinks werden nur bei shortlink-option angezeigt, sonst nicht!
		if($shortlink)
		{
			$this->mysql->query("SELECT `menu_ID`, `menu_name` FROM `$table_name` WHERE `menu_topid` = '{$topid_array[$j]}' AND `menu_display` != '0' AND `menu_shortlink` != '1' ORDER BY `menu_position` ASC");
		}
		else
		{
			$this->mysql->query("SELECT `menu_ID`, `menu_name` FROM `$table_name` WHERE `menu_topid` = '{$topid_array[$j]}' AND `menu_display` != '0' ORDER BY `menu_position` ASC");
		}*/

		$mysql_array = $this->mysql->get_records();

		//Durchlaeuft $mysql_array und baut so die Navigation auf.
		$j++;

		//$level aendert sich nicht innerhalb der Funktion, $j hingegen schon, denn sie ist statisch.
		$level = $j;
		while($data = current($mysql_array))
		{
			$subnav_array[$i] = $data;
			$subnav_array[$i]['level'] = $level;
			$i++;

			if($j < count($topid_array) && $data['menu_ID'] == $topid_array[$j])
			{
				$this->build_subnav_array($table_name, $topid_array, &$subnav_array);
			}

			next($mysql_array);
		}

		//echo "In build_subnav_array: \$i $i, \$j $j, topid_array\n<pre>".print_r($topid_array, 1)."</pre><br />\n";
		//echo "In build_subnav_array: subnav_array\n<pre>".print_r($subnav_array, 1)."</pre> <br />\n";
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