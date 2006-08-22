<?php


/*
* Dieses Modul ist für die Gallery zuständig, die Anzeige von Bildern
*in den verschiedenen Alben und richtigen Reihenfolge
*
* Sie ist _NICHT_ zuständig für die Administration des Gallery
*
*/


//Nummern zuweisen oder false oder 1
$gallery = isset($_GET['gallery']) ? ((int) $_GET['gallery']) : false;
$pic = isset($_GET['pic']) ? ((int) $_GET['pic']) : false;
$page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;

$gallery_array = array();

/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
//******************* If-Abragen ******************* /
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
if($gallery) {
	
	
	$bildproseite = $gallery_pics_x * $gallery_pics_y;
	$start = ($page-1)*$bildproseite;
	$ende = $page*$bildproseite - 1;
	
	
	$mysql->query("SELECT gallery_alben . name , "/*gallery_alben . fid_parent, */."
         gallery_eintraege . fid_bild , gallery_eintraege . comment ,
         gallery_alben.ID
         FROM `gallery_eintraege` , `gallery_alben` 
         where gallery_alben . ID = $gallery AND gallery_eintraege . fid_album = gallery_alben . ID 
         ORDER BY gallery_eintraege . sequence LIMIT $start, $ende ");

	$i = 0;
	while($gallery_data = $mysql->fetcharray()) {
		
		$gallery_array[$i] = array("album_name" => $gallery_data['name'], "bilder_ID" => $gallery_data['fid_bild'],
									"comment" => $gallery_data['comment']); 
									
		/*
		Image.php läuft so
		Per GET-Parameter werden die bilder mit der Ip geschickt. Die Datei managt das Ganze.
		
		!Image.php wird !!!NICHT!!! von gallery.php aufgerufen. Sondern über die Templates.
		etwa so: <img src="image.php?bild=1&thumb oder image.php?thumb=1 und image.php?bild=1
		
		mit dem Modul-System KANN (muss nicht)!! das dann wie folgt aussehen
		
		<img src="index.php?nav_id=42&bild=1 heig
		*/
		
		$i++;
	}

	$text = "<pre>".print_r($gallery_array, 1)."</pre>";

	$smarty->assign("text", $text);
	$mod_tpl = "gallery_album.tpl";


	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
} else if($pic) {
	;


	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
	/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
} else {
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
	
