<?php

/*-----------------------------------------------------------------
* File: image.php
* Classes: -
* Requieres: PHP5
* 
* Diese Datei wird aufgerufen, um ein Bild darzustellen. 
* Sie fragt die Datenbank nach der �bermittelten ID ab und erh�lt so die Bilddatei
* Mithilfe der Klasse "image" wird das Bild ver�ndert und/oder ausgegeben
* 
* Diese Klasse wird auch f�r Thumbs gebraucht
* Ist ein Thumb nicht vorhanden, wird es automatisch aus den zugeh�rigen Bild
* erstellt.
*
-------------------------------------------------------------------*/


require_once('image.class.php');
require_once('../config/config.inc.php');



(isset($_GET['bild']) && $_GET['image'] != "") ? $bild = (int)$_GET['bild'] : $bild = false;

(isset($_GET['thumb']) && $_GET['thumb'] != "") ? $thumb = (int)$_GET['thumb'] : $thumb = false;



//*******IF-ABFRAGEN*******//
if(isset($bild))
{
	
	//Eintrag zur ID vorhanden?
	$mysql->query("SELECT filename , height , width FROM `bilder` where bilder_ID = $bild LIMIT 1");
	
	$bild_mysql = $mysql->fetcharray();
	
	//�berpr�fung, ob ein Eintrag vorhanden ist
	if(!empty($array_bild))
	{
		$img = new image("$dir_orgImage.{$bild_mysql['filename']}");
	}
	else
	{
		
		$img = new image(); //Fehlerbild ausgeben, weil kein Eintrag vorhanden ist
		exit();				//Skript abbrechen, weil nichts anderes gemacht werden muss
	}
	
	
	
	//Information zur H�he und Breite erhalten
	$bild_data = $img->send_imageinfos();
	
	/*Umrechnen, falls
	  1. H�he oder Breite einen Wert �berschreiten
	  2. Kein Bild mit gleichem Namen im Ordner gallery gespeichert ist
	*/
	
	if(($bild_data['height'] > $image_maxheight || $bild_data['width'] > $image_maxwidth) && !(is_file("$dir_gallery.{$bild_mysql['filename']}")))
	{
		//H�he-Breite-Verh�ltnis zum Weiterrechnen bestimmen
		$verhaeltnis = $bild_data['height'] / $bild_data['width'];
		
		//Neue Breite zuweisen (meist ist die zu gross) und neue H�he berechnen
		$bild_newwidth = $image_maxwidth;
		$bild_newheight = $verhaeltnis * $bild_newwidth;
		
		//Wenn die H�he noch zu gross ist, wird die max. H�he bestimmt und neue Breite berechnet
		if($bild_newheight > $image_maxheight)
		{
			$bild_newheight = $image_maxheight;
			$bild_newwidth = (1/$verhaeltnis) * $bild_newheight;
		}
		
		$img->copy($bild_newwidth, $bild_newheight, "$dir_image.{$bild_mysql['filename']}");
	}
	
	$img->send_image();
	
	
} 
elseif(isset($thumb)) 
{
	//Eintrag zur ID vorhanden?
	
	//Thumb vorhanden (-> Bild vorhanden)
	
	//Ausgabe
	
	
	
}


?>