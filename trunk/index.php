<?php
require('./modules/mysql.class.php');
require('./Smarty/Smarty.class.php');

$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;

$mysql = new mysql();

/* Aufbau der Navigation */
/* Auslesen der Top-Navigation */
$mysql->query("SELECT * FROM menu WHERE menu_topid=0 ORDER BY menu_position ASC");
$nav_array =array();
$i = 0;
while ($nav_data = $mysql->fetcharray()) {
	$nav_array[$i] = array('menu_ID'=>$nav_data["menu_ID"], 'menu_name'=>$nav_data["menu_name"]);
	$i++;
}
$smarty->assign("nav", $nav_array);

$nav_id = $_GET["nav_id"];
if ($nav_id <= 0) {
	$nav_id = $nav_array[0]['menu_ID'];
}

/*Hier werden alle Verweise ausgelesen, wie: 
**Zugehörigkeit einer höheren Navigation, ob Modul oder Page, und welche ID*/
$mysql->query("SELECT * FROM menu WHERE menu_ID = $nav_id");
$page_data = $mysql->fetcharray();
$page_id = $page_data["menu_page"];

/*Das Auslesen der Navigationen im Submenu. Welche überhaupt, ob ein SubSubMenu vorhanden usw*/
if ($page_data["menu_topid"] == 0) {
	$mysql->query("SELECT * FROM menu WHERE menu_topid=$nav_id ORDER BY menu_position ASC");
	$subnav_array =array();
	$i = 0;
	while ($subnav_data = $mysql->fetcharray()) {
		$subnav_array[$i] = array('menu_ID'=>$subnav_data["menu_ID"], 'menu_name'=>$subnav_data["menu_name"]);
		$i++;
	}
	$smarty->assign("subnav", $subnav_array);
}
/*********************************************************************/
else {
	$mysql->query("SELECT * FROM menu WHERE menu_topid=$page_data[menu_topid] ORDER BY menu_position ASC");

	$subnav_array = array();
	$i = 0;
	while ($subnav_data = $mysql->fetcharray()) {
		$subnav_array[$i] = array('menu_ID'=>$subnav_data["menu_ID"], 'menu_name'=>$subnav_data["menu_name"]);
		$i++;		
	}
	$smarty->assign("subnav", $subnav_array);
}

/*Da ja nicht nur reiner Text sondern auch Module weitergegeben werden können,  wird hier geschaut ob es ein Modul oder eine Page ist.
Einfach erweiterbar durch einen weiteren enum-Eintrag in der DB und die Erweiterung hier*/
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
		$smarty->assign("content_title", $content_title);
		$smarty->assign("content_text", $content_text);
		$smarty->display("index.tpl");
	break;
	case "mod":
		$smarty->assign("content_title", "Module-Fehler");
		$smarty->assign("content_text", "Module werden leider noch nicht unterst&uuml;tzt.<br />"
										."Comming soon :-)");
		$smarty->display("index.tpl");		 
	break;
}
