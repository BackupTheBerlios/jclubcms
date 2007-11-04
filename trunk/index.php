<?php

/**
 * @author David Daester und Simon Daester
 * @package JClubCMS
 * Index.php
 * 
 * Diese Seite ist fuer die Anzeig der Navigation veranwortlich
 * und laedt die notwendigen Module
 */

/** Zu Testzwecken ! **/
//error_reporting(E_ALL|E_STRICT);
/** *** */

$microtime = microtime();

/**Konstanten definieren**/
define("ADMIN_DIR", "./admin/");
define("USER_DIR", "./");


//Config laden
require_once(USER_DIR.'config/user-config.inc.php');

require_once ADMIN_DIR.'config/global-config.inc.php';
require_once(ADMIN_DIR.'config/functions.inc.php');

//notwendige Module laden
require_once(ADMIN_DIR.'lib/mysql.class.php');
require_once(ADMIN_DIR.'lib/timeparser.class.php');
require_once(ADMIN_DIR.'lib/Smarty/Smarty.class.php');

//Smarty-Objekt
$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;

//Mysql-Objekt
$mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
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
 * Hier werden alle Verweise ausgelesen: ID, h�here Navigation (topid), Position, Name,
 * zugeh�rige Seite (page) und ob Modul oder Page �
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
 * Der gerade aktive Navigationslink und alle direkt dar�berliegende Links
 * werden im Array $root_array gespeichert.
 * 
 * Aufbau:
 * topid: 0     -Gallery
 * 				-G�stebuch
 * Und dann gehts weiter nach unten
 * Info: Eintr�ge mit 'menu_display' = 0 werden nicht angezeigt
 * 
 */

$child_array = array();
$root_array = array();
//Die Stufe beginnt von unten zu zaehlen, statt von oben. Wird am Schluss umgerechnet
$invlevel = 1;

//Alle Eintr�ge unterhalb des $nav_id Eintrags werden gelesen
//Sie haben den $invlevel 1
$mysql->query("SELECT menu_ID, menu_topid, menu_name FROM menu WHERE menu_topid = $nav_id and `menu_display` != '0' ORDER BY menu_position");
$i = 0;
while ($subnav_data = $mysql->fetcharray()) {
	$child_array[$i] = array('menu_ID'=>$subnav_data["menu_ID"], 'menu_name'=>$subnav_data["menu_name"], 'menu_topid'=>$subnav_data["menu_topid"], 'level'=>$invlevel);
	$i++;
}

//Die n�chsth�here TopID
$next_topid = $page_data["menu_topid"];


//Solange durchlaufen lassen bis obersten Navitationsteile erreicht sind (top_id == 0)

while (($next_topid != 0 || $next_topid != false))	{

	$i = 0;

	// $top_id kann aus dem Array $child_array herausgelesen werden
	// beim 1. Durchgang kann das Child-Array leer sein, man kann daf�r die $nav_id nehmen
	if(empty($child_array[0]["menu_topid"])) {
		$top_id = $nav_id;
	} else {
		$top_id = $child_array[0]["menu_topid"];
	}


	//Erh�hung des $invlevels, da eine Stufe weiter Richtung oben
	$invlevel++;

	$mysql->query("SELECT menu_ID, menu_topid, menu_name FROM menu WHERE menu_topid = $next_topid and `menu_display` != '0' ORDER BY menu_position ASC");
	//Die Tabelle auslesen
	while($subnav_data = $mysql->fetcharray()) {

		$root_array[$i] = array('menu_ID'=>$subnav_data["menu_ID"], 'menu_name'=>$subnav_data["menu_name"], 'menu_topid'=>$subnav_data["menu_topid"], 'level'=>$invlevel);
		/**
		 * //Wenn die menu_ID die Top_id des Child-Array ist, heisst das, 
		 * menu_ID liegt direkt dar�ber
		 * Z.B Eintrag 2.1
		 * 			Eintrag 2.1.1
		 * 			Eintrag 2.1.2
		 * 
		 * Eintrag 2.1 und Eintrag 2.1.1 liegen gerade �bereinander
		 * 
		 * Array werden zusammengef�gt.
		 * Anzahl der Elemente wird in $i gespeichert, damit weder �berschrieben wird noch sich eine L�cke bildet
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
	//Hier wird noch mit der alten $next_topid gerechnet. Die Topid vom h�heren Menu wird gelesen
	$mysql->query("SELECT menu_topid FROM menu WHERE menu_ID = $next_topid and `menu_display` != '0' LIMIT 1");
	$subnav_data = $mysql->fetcharray();
	//Neues $next_topid
	$next_topid = $subnav_data["menu_topid"];


}
//Ende Whileschleife


/**
 * Die $invlevels m�ssen noch umgekehrt werden. Momentan ist der tiefste Eintrags-Lebel 1, 
 * aber der h�chste Eintragslevel soll 1 werden
 */

//Das Anzahl Level wird abgespeichtert
$anzlevel = $invlevel;

$invlevel = 0;
$number = count($child_array);

//Die Umrechnunsschleife, die Levels werden neu gesetzt: Das H�chste jetzt das Tiefste und umgekehrt
for($i = 0; $i < $number; $i++) {
	$invlevel = $child_array[$i]['level'];
	$child_array[$i]['level'] = $anzlevel - $invlevel + 1;
}

//Die Subnav_array mit dem vollst�ndigen child_array f�llen
$subnav_array = $child_array;

$smarty->assign("subnav", $subnav_array);




/**
 * Das komplizierte ist jetzt vorbei
 * ************** Menu Ende ***********
 * 
 */



/**
 * Da ja nicht nur reiner Text sondern auch Module weitergegeben werden k�nnen, wird hier geschaut,
 * ob es ein Modul oder eine Page ist. Einfach erweiterbar durch einen weiteren enum-Eintrag in der DB
 * und die Erweiterung hier
 */
if(isset($_GET['mail'])) {
	/**
   * F�r den Mailversand auszul�sen wird hierr�ber gearbeitet.
   * Von hier werden die wichtigen Classen ge�ffnet, die Mail verschickt (sofern vorhanden)
   * und der DB-Eintrag gel�scht.
   */
	require_once(ADMIN_DIR.'lib//mailsend.class.php');
	
	$mail_hash = $_GET['mail'];
	$mail_send = new mailsend();
	$controll = $mail_send->mail_send_hash($mysql, $mail_hash);
	if ($controll == false)
	{
		$feedback_title = $mail_failer_title;
		$feedback_content = $mail_failer_content;
		$feedback_link = "";
		$feedback_linktext = $mail_send_link;	
	} else {
		$feedback_title = $mail_send_title;
		$feedback_content = $mail_send_title;
		$feedback_link = "";
		$feedback_linktext = $mail_send_link;	
	}
	$smarty->assign("feedback_title", $feedback_title);
	$smarty->assign("feedback_content", $feedback_content);
	$smarty->assign("link", $feedback_link);
	$smarty->assign("link_text", $feedback_linktext);	
	$smarty->assign("file", "feedback.tpl");
	$smarty->display("index.tpl");
	
} else {
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
}
$mysql->disconnect();
?>