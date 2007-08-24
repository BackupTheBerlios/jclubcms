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
	private $mysqlhobj;
	private $auth;
	
	public function __construct($smarty, $mysql)
	{
		$this->smarty = $smarty;
		$this->mysql = $mysql;
		$this->auth = new Auth($this, $mysql);
	}
	
	public function get_menu_array()
	{
		;
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