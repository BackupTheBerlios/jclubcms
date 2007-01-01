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
 */


//Nummern zuweisen oder false/1
$gallery = isset($_GET['gallery']) ? ((int) $_GET['gallery']) : false;
$pic = isset($_GET['pic']) ? ((int) $_GET['pic']) : false;
$page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;


$items_array = array();	//Wird als allgemeines Array gebraucht in allen Bedingungen

/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
//******************* If-Abragen ******************* /
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
if($gallery) {
	
	//Ein paar Daten berechnen
	$bildproseite = $gallery_pics_x * $gallery_pics_y;
	$start = ($page-1)*$bildproseite;

	
	//Einträge abrufen
	$mysql->query("SELECT gallery_alben.name , gallery_alben.fid_parent, 
         gallery_eintraege.fid_bild , gallery_eintraege.comment ,
         gallery_alben.ID
         FROM `gallery_eintraege`, `gallery_alben` 
         where gallery_alben.ID = $gallery AND gallery_eintraege.fid_album = $gallery 
         ORDER BY gallery_eintraege.sequence LIMIT $start, $bildproseite ");

	//Verbessern, eigene Variablen für album_name und parent_album
	$i = 0;
	while($gallery_data = $mysql->fetcharray()) {
		
		$items_array[$i] = array("album_name" => $gallery_data['name'], "parent_album" => $gallery_data['fid_parent'],
									"bilder_ID" => $gallery_data['fid_bild'], "comment" => $gallery_data['comment']); 

		
		$i++;
	}

	

	
	//Die Menu_ID finden für image.php
	$mysql->query("Select modules_ID from modules Where modules_name = 'image.php'");
	$imgMod_ID =  implode("",$mysql->fetcharray("num"));
	$mysql->query("SELECT menu_ID FROM `menu` where menu_pagetyp = 'mod' And menu_page = $imgMod_ID");
	$img_ID =  implode("",$mysql->fetcharray("num"));
	$smarty->assign("img_link", $img_ID);
	
	
	//Das gallery_array in Smarty schicken

	$smarty->assign("breakline", $gallery_pics_x);
	$smarty->assign("alben", $items_array);
	$smarty->assign("local_link", $nav_id);
	$mod_tpl = "gallery_album.tpl";
	

	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
} else if($pic) {
	
	//Die Album_ID und Reihennummer des Bildes in ein nummerisches Array speichern
	$mysql->query("Select fid_bild, fid_album, sequence from gallery_eintraege where fid_bild = $pic");
	$items_array[1] = $mysql->fetcharray("assoc");
	
	//Zur Vereinfachung
	$album = $items_array[1]['fid_album'];
	$pic_sequence = $items_array[1]['sequence'];
	
	//Falls der Limitstart negativ ausfallen sollte, wird er auf null gesetzt
	$start = ($pic_sequence-2) > 0 ? $pic_sequence -2: 0;
	
	//Ist das Bild gerade das erste, braucht es nur 2 Einträge, nicht 3
	$anz = ($pic_sequence == 1) ? 2 : 3;
	
	//Das vordere Bild und das hintere Bild abspeichern
	$mysql->query("Select fid_bild, fid_album, sequence from gallery_eintraege 
					where fid_album = $album Order By sequence 
					Limit $start,$anz");
	

	
	//Die Bild_ID der anderen Bildern abspeichern
	$items_array[0] = $mysql->fetcharray("assoc");
	if($anz == 2)
	{
			$items_array[2] = $mysql->fetcharray("assoc");
	} else {
			//Erst den 3. Eintrag nehmen, den 2. kann man vergessen
			$items_array[1] = $mysql->fetcharray("assoc");
			$items_array[2] = $mysql->fetcharray("assoc");
	}


	
	
	//Die Menu_ID finden für image.php
	$mysql->query("Select modules_ID from modules Where modules_name = 'image.php'");
	$imgMod_ID =  implode("",$mysql->fetcharray("num"));
	$mysql->query("SELECT menu_ID FROM `menu` where menu_pagetyp = 'mod' And menu_page = $imgMod_ID");
	$img_ID =  implode("",$mysql->fetcharray("num"));

	
	//Smarty-Variablen
	$smarty->assign("img_link", $img_ID);
	$smarty->assign("album", $album);
	$smarty->assign("local_link", $nav_id);
	$smarty->assign("ID_bild", $pic);
	$smarty->assign("prev_bild", $items_array[0]['fid_bild']);
	$smarty->assign("next_bild", $items_array[2]['fid_bild']);
	
	$mod_tpl = "gallery_pic.tpl";
	
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
} else {
	$i = 0;
	$mysql->query("SELECT * FROM gallery_alben");
	while($gallery_data = $mysql->fetcharray()) {
		$items_array[$i] = $gallery_data;
		$i++;
	}

	$smarty->assign("gallery", $items_array);
	$mod_tpl = "gallery.tpl";

	$microtime = microtime()-$microtime;
	$microtime=round($microtime, 3);
	$smarty->assign("generated_time", $microtime);

}

?>
	
