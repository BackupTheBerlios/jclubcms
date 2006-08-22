<?php

require_once('image.class.php');


(isset($_GET['bild']) && $_GET['image'] != "") ? $bild = (int)$_GET['bild'] : $bild = false;

(isset($_GET['thumb']) && $_GET['thumb'] != "") ? $bild = (int)$_GET['thumb'] : $bild = false;


if($bild) {
	$mysql->query("SELECT bilder_ID, filename, thumb, erstellt FROM bilder WHERE bilder_ID = $bild");
	$bild = $mysql->fetcharray();

	
	if(!is_file($bild['filename'])) {
		
		//eigenes Fehler-Bild erstellen
		$im = imagecreate($image_maxwidth-100, $image_maxheight-100);
		$background_color = imagecolorallocate ($im, 255, 255, 255); //weiss
		$text_color = imagecolorallocate($im, 0, 250, 154); //MediumSpringGreen
		imagestring($im, 1, 5, 5, "Bild konnte nicht gefunden werden", $text_color);
		
		//Bild senden
		header("Content-Type: image/jpeg");
		imagejpeg($im);
		imagedestroy($im);
		exit();
	}
	
	
	$image = new image($bild['filename']);
	
	$img_array = $image->send_imageinfos();
	$im = $img_array['im']; 
	$format = $img_array['format']; 
	
	//Bild senden
	header("Content-Type: image/$format");
	eval("image$format(\$im);");
	imagedestroy($im);
	

	
	/*___-----------------------
	----------------------____*/
} elseif ($thumb) {
	$mysql->query("SELECT bilder_ID, filename, thumb, erstellt FROM bilder WHERE bilder_ID = $thumb");
	$bild = $mysql->fetcharray();
	
	if(!is_file($bild['filename'])) {
		
		//eigenes Fehler-Bild erstellen
		$im = imagecreate($thumb_maxwidth-100, $thumb_maxheight-100);
		$background_color = imagecolorallocate ($im, 255, 255, 255); //weiss
		$text_color = imagecolorallocate($im, 0, 250, 154); //MediumSpringGreen
		imagestring($im, 1, 5, 5, "Bild konnte nicht gefunden werden", $text_color);
		
		//Bild senden
		header("Content-Type: image/jpeg");
		imagejpeg($im);
		imagedestroy($im);
		exit();
	}
	
	$image = new image($bild['filename']);
	
	//Beim Thumb-Erstellen Seitenverhältniss beachten
	//Noch klären, was klasse macht
	//Muss File angegeben werden. Vielleicht eine offenere Klasse machen!!!!
	
	
	if($cache_thumb) {
		;
	}

}

/*

$img = new image("../bilder/gallery/ende_phase_1_01.jpg");


$bild_data = $img->thumb_create(141, 110, "jpeg");

$im = $bild_data['im'];

header("Content-type: image/jpeg");
$zahl = imagejpeg($im);
imagedestroy($im);

echo "Testeaeraasdfasfadsfasdfasdf: Zahl \n\n\n\n\n\n\n$zahl";

$img->trigger_error("THallo");
*/


?>