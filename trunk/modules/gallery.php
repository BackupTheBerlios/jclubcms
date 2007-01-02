<?php

/**
 * @package JClubCMS
 * @author Simon Däster
 * File: gallery.php
 * Classes: none
 * Requieres: PHP5
 *
 *
 * Dieses Modul ist für die Gallery zuständig, die Anzeige von Bildern
 *in den verschiedenen Alben und richtigen Reihenfolge
 *
 * Sie ist _NICHT_ zuständig für die Administration des Gallery
 * 
 * INFO:
 * GALLERY IN GALLERY WIRD NOCH NICHT UNTERSTÜTZT
 */

require_once("pagesnav.class.php");

//Nummern zuweisen oder false/1
$gallery = isset($_GET['gallery']) ? ((int) $_GET['gallery']) : false;
$bild = isset($_GET['bild']) ? ((int) $_GET['bild']) : false;
$page = isset($_GET['page']) ? ((int) $_GET['page']) : 0;



/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
//******************* If-Abragen ******************* /
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
if($gallery) {

	//Ein paar Daten berechnen
	$bildproseite = (int)($gallery_pics_x * $gallery_pics_y);
	$start = (int)($page*$bildproseite);

	//Anzahl Einträge
	$mysql->query("SELECT * FROM gallery_eintraege WHERE fid_album = '$gallery'");
	$number = $mysql->num_rows();

	//Albenname
	$mysql->query("Select gallery_alben.name From `gallery_alben` WHERE gallery_alben.ID = '$gallery'
					Limit 1");
	$items_array = $mysql->fetcharray("num");
	$gallery_name = $items_array[0];


	//Einträge abrufen
	$mysql->query("SELECT gallery_eintraege.fid_bild FROM `gallery_eintraege`,`gallery_alben`
					WHERE gallery_alben.ID = '$gallery' AND gallery_eintraege.fid_album = '$gallery'
					ORDER BY gallery_eintraege.sequence
					LIMIT $start,$bildproseite");

	$i = 0;
	while($gallery_data = $mysql->fetcharray()) {

		$bild_ID[$i] = $gallery_data['fid_bild'];
		$i++;
	}

	$pages_nav = new pagesnav($number, $bildproseite);
	$pages_array = $pages_nav->build_array();
	$pages_nav->__destruct();


	//Gab es einen Mysql-Fehler??
	if($error = $mysql->get_error())
	{
		$smarty->assign("feedback_title", "<b>Mysql-Fehler</b>");
		$smarty->assign("feedback_content", "Fehlernummer: {$error[0]}<br />\nFehlertext: {$error[1]}");
		$mod_tpl = "feedback.tpl";

	} else {

		//Die Menu_ID finden für image.php
		$mysql->query("Select modules_ID from modules Where modules_name = 'image.php'");
		$imgMod_ID =  implode("",$mysql->fetcharray("num"));
		$mysql->query("SELECT menu_ID FROM `menu` where menu_pagetyp = 'mod' And menu_page = $imgMod_ID");
		$img_ID =  implode("",$mysql->fetcharray("num"));
		$smarty->assign("img_link", $img_ID);


		//Smarty-Variablen belegen
		$smarty->assign("thispage", $page+1);
		$smarty->assign("pages", $pages_array);
		$smarty->assign("number", $number);
		$smarty->assign("gal_ID", $gallery);
		$smarty->assign("gallery_name", $gallery_name);
		$smarty->assign("breakline", $gallery_pics_x);
		$smarty->assign("bild_ID", $bild_ID);
		$smarty->assign("local_link", $nav_id);
		$mod_tpl = "gallery_album.tpl";
	}


	
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*Bild-Ansicht-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
} else if($bild) {

	$items_array = array();
	//Die Album_ID und Reihennummer des Bildes in ein nummerisches Array speichern
	$mysql->query("Select fid_bild, fid_album, sequence from gallery_eintraege where fid_bild = $bild");
	$shown_bild = $mysql->fetcharray("assoc");

	//Zur Vereinfachung
	$album_ID = $shown_bild['fid_album'];
	$bild_sequence = (int)$shown_bild['sequence'];

	
	//Das vordere Bild 
	$mysql->query("SELECT fid_bild FROM `gallery_eintraege` WHERE sequence < $bild_sequence and fid_album = '$album_ID' 
	ORDER BY sequence DESC Limit 1");
	$prev_bild = $mysql->fetcharray("assoc");
	
	//Das hintere Bild 
	$mysql->query("SELECT fid_bild FROM `gallery_eintraege` WHERE sequence > $bild_sequence and fid_album = '$album_ID' 
	ORDER BY sequence ASC Limit 1");
	$next_bild = $mysql->fetcharray("assoc");

	
	//Die Menu_ID finden für image.php und an Smarty weitergeben
	$mysql->query("Select modules_ID from modules Where modules_name = 'image.php'");
	$imgMod_ID =  implode("",$mysql->fetcharray("num"));
	$mysql->query("SELECT menu_ID FROM `menu` where menu_pagetyp = 'mod' And menu_page = $imgMod_ID");
	$img_ID =  implode("",$mysql->fetcharray("num"));
	$smarty->assign("img_link", $img_ID);


	//weitere Smarty-Variablen
	$smarty->assign("album", $album_ID);
	$smarty->assign("local_link", $nav_id);
	$smarty->assign("ID_bild", $bild);
	$smarty->assign("prev_bild", $prev_bild['fid_bild']);
	$smarty->assign("next_bild", $next_bild['fid_bild']);

	$mod_tpl = "gallery_pic.tpl";
	
	
	

	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-Alben-Ansich*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
} else {
	$gallery_array = array();
	$i = 0;
	$mysql->query("SELECT * FROM gallery_alben");
	while($gallery_data = $mysql->fetcharray()) {
		$gallery_array[$i] = $gallery_data;
		$i++;
	}

	$smarty->assign("gallery", $gallery_array);
	$mod_tpl = "gallery.tpl";

	$microtime = microtime()-$microtime;
	$microtime=round($microtime, 3);
	$smarty->assign("generated_time", $microtime);

}

?>
	
