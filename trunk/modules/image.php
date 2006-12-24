<?php

/*-----------------------------------------------------------------
* @author Simon D�ster
* @package JClubCMS
* File: image.php
* Classes: -
* Requieres: PHP5
*
* GRUNDSATZ:
* "Befindet sich ein Bild im Ordner Gallery oder im Thumb, dann ist es dort richtig. D.h.
*  es hat die richtige Gr�sse und sieht korrekt aus!!"
* --> Kann zu Konflikt f�hren, wenn config.inc.php ge�ndert wird
*
* Diese Datei (image.php= wird aufgerufen, um ein Bild darzustellen.
* Sie fragt die Datenbank nach der �bermittelten ID ab und erh�lt so die Bilddatei
* Ist ein Bild zu gross, wird es verkleinert im Ordner 'gallery' abgespeichert
* Mithilfe der Klasse "image" wird das Bild (ver�ndert) ausgegeben
*
* Die image-Klasse wird auch f�r Thumbs gebraucht
* Ist ein Thumb nicht vorhanden, wird es automatisch aus dem zugeh�rigen Bild
* erstellt und im Ordner 'thumb' abgespeichert.
*
-------------------------------------------------------------------*/


require_once('./modules/image.class.php');
require_once('./config/config.inc.php');
require_once('./includes/globals.php');



(isset($_GET['bild']) && $_GET['bild'] != "") ? $bild = (int)$_GET['bild'] : $bild = false;

(isset($_GET['thumb']) && $_GET['thumb'] != "") ? $thumb = (int)$_GET['thumb'] : $thumb = false;



//******* BILD *******//
if($bild)
{

	//Eintrag zur ID vorhanden?
	$mysql->query("SELECT filename FROM `bilder` where bilder_ID = $bild LIMIT 1");

	$bild_mysql = $mysql->fetcharray();

	//�berpr�fung, ob ein Eintrag vorhanden ist
	if(!empty($bild_mysql))
	{

		$img = new image($dir_orgImage.$bild_mysql['filename']);

	}
	else
	{

		$img = new image(""); //Fehlerbild ausgeben, weil kein Eintrag vorhanden ist
		$img->create_image(240, 80, "Keine Id zu diesem Bild", "000000255", "200150080");
		$img->send_image();
		die();			//Skript abbrechen, weil nichts anderes gemacht werden muss
	}

	$bild_data = $img->send_infos();

	//Ist das Bild zu gross?
	if($bild_data['height'] > $image_maxheight || $bild_data['width'] > $image_maxwidth)
	{
		if(is_file($dir_galImage.$bild_mysql['filename']))
		{
			//Ist das Bild schon im gallery-Ordner, wird nichts ver�ndert
			;
		} else {

			//H�he-Breite-Verh�ltnis zum Weiterrechnen bestimmen
			$verhaeltnis = $bild_data['height'] / $bild_data['width'];

			//Neue Breite zuweisen (meist ist die zu gross) und neue H�he berechnen
			$bild_newwidth = $image_maxwidth;
			$bild_newheight = floor($verhaeltnis * $bild_newwidth);		//Abrunden

			//Wenn die H�he noch zu gross ist, wird die max. H�he bestimmt und neue Breite berechnet
			if($bild_newheight > $image_maxheight)
			{
				$bild_newheight = $image_maxheight;
				$bild_newwidth = floor((1/$verhaeltnis) * $bild_newheight);	//Abrunden
			}

			$img->copy($bild_newwidth, $bild_newheight, $dir_galImage.$bild_mysql['filename']);
		}

		
		$img = new image($dir_galImage.$bild_mysql['filename']);
	}

	$img->send_image();
	
	
}
//****** THUMB *****//
elseif($thumb)
{
	//Eintrag zur ID vorhanden?
	$mysql->query("SELECT filename FROM `bilder` where bilder_ID = $thumb LIMIT 1");

	$bild_mysql = $mysql->fetcharray();

	//�berpr�fung, ob ein Eintrag vorhanden ist
	if(empty($bild_mysql))
	{
		$img = new image(""); //Fehlerbild ausgeben, weil kein Eintrag vorhanden ist
		$img->create_image(80, 80, "Keine Id", "000000255", "200150080");
		$img->send_image();
		die();	
	}

	//Existiert kein Thumb, wird eins erstellt
	if(!is_file($dir_thumb.$bild_mysql['filename'])) 
	{
		//***Neues Thumb erstellen
		
		$orgImg = new image($dir_orgImage.$bild_mysql['filename']);
		$bild_data = $orgImg->send_infos();
		
		$verhaeltnis = $bild_data['height'] / $bild_data['width'];
		
		//Neue Breite zuweisen (meist ist die zu gross) und neue H�he berechnen
			$bild_newwidth = $thumb_maxwidth;
			$bild_newheight = floor($verhaeltnis * $bild_newwidth);		//Abrunden

			//Wenn die H�he noch zu gross ist, wird die max. H�he bestimmt und neue Breite berechnet
			if($bild_newheight > $thumb_maxheight)
			{
				$bild_newheight = $thumb_maxheight;
				$bild_newwidth = floor((1/$verhaeltnis) * $bild_newheight);	//Abrunden
			}

			$orgImg->copy($bild_newwidth, $bild_newheight, $dir_thumb.$bild_mysql['filename'], "jpeg");	
	}

	
	//Bild ausgeben
	$img = new image($dir_thumb.$bild_mysql['filename']);
	$img->send_image();

}


?>