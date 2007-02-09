<?php
/**
 * @package JClubCMS
 * @author David däster
 * File: pagesnav.class.php
 * Classes: pagesnav
 * Requieres: PHP5
 *
 *
 * Die Klasse ist zuständig für das Erstellen des Arrays der Seiten.
 */
/**
 * @author David Däster
 * 
 * Ist für die Seitennavigationen für das Gästebuch und die News zuständig.
 */
class pagesnav {
	private $main_url = null;
	private $nav_id = null;
	private $number_entries = null;
	private $max_entries_pp = null;
	private $this_page = 0;
	
	/**
	 * Klassenkonstruktor
	 *
	 * @param int $number_entries Anzahl der Einträge
	 * @param int $max_entries_pp Einträge pro Seite
	 */
	public function __construct($number_entries, $max_entries_pp) {
		$this->main_url = $_SERVER['_URI'];
		$this->nav_id = $_REQUEST['nav_id'];
		$this->number_entries = $number_entries;
		$this->max_entries_pp = $max_entries_pp;
		$this_page = $_REQUEST['page'];
		if ($this_page > 0) {
			$this->this_page = $this_page;
		}
	}
	/**
	 * Errechnet wieviele Seiten es geben wird
	 *
	 * @return int $number_of_pages
	 */
	private function numberofpages () {
		$number_of_pages = $this->number_entries / $this->max_entries_pp;
		return $number_of_pages;
	}
	/**
	 * Bildet das Seiten-Array für Smarty
	 *
	 * @return array $pages_array
	 */
	public function build_array () {
		$number_of_pages = $this->numberofpages();
		$pages_array = array();
		for ($i = 0; $i < $number_of_pages; $i++) {
			$link = $this->main_url.'?nav_id='.$this->nav_id.'&page='.$i;
			$pages_array[$i] = array('page'=>$i+1, 'link'=>$link);
		}
		return $pages_array;
	}
	/**
	 * Der Klassendestruktor
	 *
	 */
	
	public function __destruct() {
	$this->main_url = null;
	$this->nav_id = null;
	$this->number_entries = null;
	$this->max_entries_pp = null;
	$this->this_page = 0;	
	}
}
?>