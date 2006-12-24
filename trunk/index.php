<?php

/**
 * @author David und Simon Däster
 * @package JClubCMS
 * Index.php
 * Diese Seite ist für die Anzeig der Navigation veranwortlich
 * und lädt die notwendigen Module
 */

/** Zu Testzwecken ! **/
//error_reporting(E_ALL|E_STRICT);
/** *** */

$microtime = microtime();

require_once('./includes/globals.php');
//$smarty->debugging = true;

/** Aufbau der Navigation */
/** Auslesen der Top-Navigation */

$mysql->query("SELECT menu_ID, menu_name FROM menu WHERE menu_topid=0 and `menu_display` != '0' ORDER BY menu_position ASC");
$nav_array = array();
$i = 0;
while ($nav_data = $mysql->fetcharray()) {
	$nav_array[$i] = array('menu_ID'=>$nav_data["menu_ID"], 'menu_name'=>$nav_data["menu_name"]);
	$i++;
}

$smarty->assign("nav", $nav_array);

/** Kontrolle der Get-Variable $_GET['nav_id']. Zur Vereinfachung in $nav_id gespeichert*/
$nav_id = (int) $_GET["nav_id"];
if ($nav_id <= 0) {
	$nav_id = $nav_array[0]['menu_ID'];
}


/**
 * Hier werden alle Verweise ausgelesen: ID, höhere Navigation (topid), Position, Name,
 * zugehörige Seite (page) und ob Modul oder Page £
 */
$mysql->query("SELECT * FROM menu WHERE menu_ID = $nav_id");
$page_data = $mysql->fetcharray();

$page_id = $page_data["menu_page"];





/**
 * Hier folgt das 
 * ***************M E N U ***************
 * ES wird kompliziert
 */


/** 
 * Der gerade aktive Navigationslink und alle direkt darüberliegende Links
 * werden im Array $root_array gespeichert.
 * 
 * Aufbau:
 * topid: 0     -Gallery
 * 				-Gästebuch
 * Und dann gehts weiter nach unten
 * Info: Einträge mit 'menu_display' = 0 werden nicht angezeigt
 * 
 */

$child_array = array();
$root_array = array();
//Verkehrte Stufe. Beginnt bei 1!!!!. Wird nachher umgerechnet
$invlevel = 1;

//Alle Einträge unterhalb des $nav_id Eintrags werden gelesen
//Sie haben den $invlevel 1
$mysql->query("SELECT menu_ID, menu_topid, menu_name FROM menu WHERE menu_topid = $nav_id and `menu_display` != '0' ORDER BY menu_position");
$i = 0;
while ($subnav_data = $mysql->fetcharray()) {
	$child_array[$i] = array('menu_ID'=>$subnav_data["menu_ID"], 'menu_name'=>$subnav_data["menu_name"], 'menu_topid'=>$subnav_data["menu_topid"], 'level'=>$invlevel);
	$i++;
}

//Die nächsthöhere TopID
$next_topid = $page_data["menu_topid"];


//Solange durchlaufen lassen, bis die menu_topid 0 ist, also die obersten Navitationsteile erreicht sind

while (($next_topid != 0 || $next_topid != false))	{

	$i = 0;

	// $top_id kann aus dem Array $child_array herausgelesen werden
	// ausser wenn es keine einträge unter $nav_id gibt, das $child_array leer ist (nur beim 1. Mal möglich)
	if(empty($child_array[0]["menu_topid"])) {
		$top_id = $nav_id;
	} else {
		$top_id = $child_array[0]["menu_topid"];
	}


	//Erhöhung des $invlevels, da eine Stufe weiter Richtung oben
	$invlevel++;

	$mysql->query("SELECT menu_ID, menu_topid, menu_name FROM menu WHERE menu_topid = $next_topid and `menu_display` != '0' ORDER BY menu_position ASC");
	//Die Tabelle auslesen
	while($subnav_data = $mysql->fetcharray()) {
		
		$root_array[$i] = array('menu_ID'=>$subnav_data["menu_ID"], 'menu_name'=>$subnav_data["menu_name"], 'menu_topid'=>$subnav_data["menu_topid"], 'level'=>$invlevel);
		/**
		 * //Wenn die menu_ID die Top_id des Child-Array ist, heisst das, 
		 * menu_ID liegt direkt darüber
		 * Z.B Eintrag 2.1
		 * 			Eintrag 2.1.1
		 * 			Eintrag 2.1.2
		 * 
		 * Eintrag 2.1 und Eintrag 2.1.1 liegen gerade übereinander
		 * 
		 * Array werden zusammengefügt.
		 * Anzahl der Elemente wird in $i gespeichert, damit weder überschrieben wird noch sich eine Lücke bildet
		 */
		if($root_array[$i]["menu_ID"] == $top_id) {

			$root_array = array_merge($root_array, $child_array);
			//Minus 1, weil es sonst einen Zwischenraum gibt. Z.B. $root_array[2], dann $root_array[4]
			$i = count($root_array) - 1;
		}
		$i++;
	}

	$child_array = $root_array;
	$root_array = array();
	
	/**
	 * Naechste top_id herausfinden 
	 */
	//Hier wird noch mit der alten $next_topid gerechnet. Die Topid vom höheren Menu wird gelesen
	$mysql->query("SELECT menu_topid FROM menu WHERE menu_ID = $next_topid and `menu_display` != '0' LIMIT 1");
	$subnav_data = $mysql->fetcharray();
	//Neues $next_topid
	$next_topid = $subnav_data["menu_topid"];


}
//ENde Whileschleife


/**
 * Die $invlevels müssen noch umgekehrt werden. Momentan ist der tiefste Eintrags-Lebel 1, 
 * aber der höchste Eintragslevel soll 1 werden
 */

//Das Anzahl Level wird abgespeichtert
$anzlevel = $invlevel;

$invlevel = 0;
$number = count($child_array);

//Die Umrechnunsschleife, die Levels werden neu gesetzt: Das Höchste jetzt das Tiefste und umgekehrt
for($i = 0; $i < $number; $i++) {
	$invlevel = $child_array[$i]['level'];
	$child_array[$i]['level'] = $anzlevel - $invlevel + 1;
}

//Die Subnav_array mit dem vollständigen child_array füllen
$subnav_array = $child_array;

$smarty->assign("subnav", $subnav_array);




/**
 * Das komplizierte ist jetzt vorbei
 * ************** Menu Ende ***********
 * 
 */



/**
 * Da ja nicht nur reiner Text sondern auch Module weitergegeben werden können, wird hier geschaut,
 * ob es ein Modul oder eine Page ist. Einfach erweiterbar durch einen weiteren enum-Eintrag in der DB
 * und die Erweiterung hier
 */

switch ($page_data["menu_pagetyp"]) {
	case "pag":
	$mysql->query("SELECT * FROM content WHERE content_ID = $page_id");
	$data = $mysql->fetcharray();
	$content_title = $data["content_title"];
	$content_text = $data["content_text"];

	if ($content_title == "" && $content_text == "") {
		$content_title = "JClub-Noch kein Inhalt";
		$content_text = "Keine Daten gefunden";
	}

	/**
	 * Das Index.tpl ist das Haupttemplate. In ihm werden die anderen Templates gespeichert.
	 * Hier das main.tpl
	 */

	$smarty->assign("content_title", $content_title);
	$smarty->assign("content_text", $content_text);
	$smarty->assign("file", "main.tpl");
	$smarty->display("index.tpl");
	break;

	case "mod":
	$mysql->query("SELECT * FROM modules WHERE modules_ID = $page_id");
	$module = $mysql->fetcharray();
	include ("./modules/".$module["modules_name"]);

	/* $mod_tpl aus der include-Datei */
	$smarty->assign("file", $mod_tpl);
	$smarty->display("index.tpl");

	break;
}

?>