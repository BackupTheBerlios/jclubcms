<?php

/*-----------------------------------------------------------------
* File: image.class.php
* Classes: image
* Requieres: PHP5
*
* Die Klasse image ist zuständig für Grafikfunktionen insbesonders
* für das Erstellen von Thumbs
*
* Funktionsbeschrieb:


-------------------------------------------------------------------*/


class image {

	private $file = null;
	private $im = null;
	private $graphicformat = null;
	private $height = null;
	private $width = null;

	private $thumb_im = null;
	private $thumb_graphicformat = null;
	private $thumb_height = null;
	private $thumb_width = null;
	private $thumb_file = null;




	/*------------------
	*** Öffentliche Funktionen ***
	------------------*/





	/**
	 * Der Klassenkonstruktor
	 *
	 * @param string $file Bilddatei
	 */
	public function __construct($file) {

		//Existiert das Bild überhaupt?
		if(is_file($file)) {
			$this->file = $file;
		} else {
			$this->error("Bild-Datei existiert nicht");
		}

		//Grafikressource und Graphikformat bestimmten
		$this->image_infos();
	}
	
	

	/**
	 *Erstellt ein Thumb im Format, das angegeben wird
	 *
	 * @param int $thumb_x Breite
	 * @param int $thumb_y Höhe
	 * @param string $thumb_format Bildformat des Thumbs
	 * @return array Bildressource|Bildformat  
	 */
	public function thumb_create($thumb_x, $thumb_y, $thumb_format = "") {


		//Thumb-Grafik überprüfen. Ünterstützes Format wird abgespeichert
		if($thumb_format == "gif" || $thumb_format == "jpeg" || $thumb_format == "png") {

			$this->thumb_graphicformat = $thumb_format;

			//Fehlerausgabe
		} elseif ($thumb_format == "") {
			$this->trigger_error("Thumb-Grafikformat ist nicht angegeben");
		} else {
			$this->trigger_error("Thumb-Grafikformat wird nicht unterstützt");
		}

		//**** Thumb erstellen
		$thumbim_temp = imagecreate($thumb_x, $thumb_y);

		eval("\$im_temp    = imagecreatefrom{$this->thumb_graphicformat}(\$this->file);");
		imagecopyresized($thumbim_temp, $im_temp, 0, 0, 0, 0, $thumb_x, $thumb_y, $this->width, $this->height);
		//***

		//Abspeichern und zurückgeben
		$this->thumb_im = $thumbim_temp;

		$return_array = array("im" => $this->thumb_im, "format" => $this->thumb_graphicformat);
		return $return_array;

	}

	
	
	/**
	 * Erstellt ein Thumb und speichert es am angegeben Ort ab
	 *
	 * @param int $thumb_x
	 * @param int $thumb_y
	 * @param string $thumb_file
	 * @return array  Bildressource|Bildformat 
	 */
	public function thumb_create_tfile($thumb_x, $thumb_y, $thumb_file) {

		if( is_file($thumb_file)) {
			$this->thumb_file = $thumb_file;

		} elseif ($thumb_file == "") {
			$this->trigger_error("Thumb-Speicherort ist nicht angegeben");

		} else {
			$this->trigger_error("Thumb-Datei ist keine regulaere Datei");

		}

		/*Grafikformat bestimmen */

		//4 letzten Zeichen nehmen -> Grafikformat
		$r_string = substr($thumb_file, -4);

		switch($r_string) {
			case ".png":
			$format_temp = "png";
			break;
			case ".gif":
			$format_temp = "gif";
			break;
			case "jpeg":

			case ".jpg":
			$format_temp = "jpeg";
			break;
			default:
			$this->trigger_error("");

		}

		$thumb_data = $this->thumb_create($thumb_x, $thumb_y, $format_temp);

		//Liefert bei Erfolg true und sonst false
		(eval("image{$this->thumb_graphicformat}(\$thumb_data['im'], \$this->thumb_file);"));
		
		return $thumb_data;
		
	}
	


	/**
	 * Verändert die Grösse des Bildes
	 *
	 * @param int $new_x
	 * @param int $new_y
	 */

	public function resize($new_x, $new_y) {
		//Zur Sicherheit immer kopieren
		copy($this->file, $this->file.".back") or $this->error("Abbruch. Das Bild konnte nicht kopiert werden");;

		$format = $this->graphicformat;

		$new_im = imagecreate($new_x, $new_y);

		eval("\$im    = imagecreatefrom$format(\$this->file);");
		imagecopyresized($new_im, $im, 0, 0, 0, 0, $new_x, $new_y, $this->width, $this->height);
		eval("image$format(\$new_im, \$filename);");
		imagedestroy($new_im);

		$this->image_imgra();
	}
	
	
	
	/**
	 * Gibt die Grafik-Resource, Grafik-Format, die Breite und die Höhe zurück
	 *
	 * @return array im, format, width, height
	 */
	
	public function send_imageinfos() {
		return array("im" => $this->im, "format" => $this->graphicformat,"width" => $this->width,
					"height" => $this->height);
	}
	
	
	
	/**
	 * Der Klassendestruktor
	 *
	 */
	
	public function __destruct() {
		;
	}




	/*------------------
	*** Private Funktionen ***
	------------------*/
	/**
	 * Liefert die Bildressource und das Bildformat des Bildes
	 *
	 */


	private function image_infos() {
		//Sehen, ob es eine gif-,jpg oder png-Grafik ist
		//Grafikformat und Bild-Resource abspeichern

		$array_image = getimagesize($this->file);
		switch ($array_image[2]) {
			case 1:
			$this->graphicformat = "gif";
			$this->im = imagecreatefromgif($this->file);
			break;
			case 2:
			$this->graphicformat = "jpeg";
			$this->im = imagecreatefromjpeg($this->file);
			break;
			case 3:
			$this->graphicformat = "png";
			$this->im = imagecreatefrompng($this->file);
			break;
			default:
			$this->error("Dieses Grafikformat für das Bild wird leider nicht unterstützt");

		}

		$this->width = $array_image[0];
		$this->height = $array_image[1];
	}
	
	
	

	/**
	 * Liefert die Thumb-Resource und das Thumb-Grafikformat
	 *
	 */
	private function thumb_infos() {

		$array_thumb = getimagesize($this->thumb_file);

		switch ($array_thumb[2]) {
			case 1:
			$this->thumb_graphicformat = "gif";
			$this->thumb_im = imagecreatefromgif($this->thumb_file);
			break;
			case 2:
			$this->thumb_graphicformat = "jpeg";
			$this->thumb_im = imagecreatefromjpeg($this->thumb_file);
			break;
			case 3:
			$this->thumb_graphicformat = "png";
			$this->thumb_im = imagecreatefrompng($this->thumb_file);
			break;
			default:
			$this->trigger_error("Dieses Grafikformat für den Thumb wird leider nicht unterstützt");
		}

		$this->thumb_width = imagesx($this->im);
		$this->thumb_height = imagesy($this->im);
	}
	
	


	/**
	 *Gibt eine benutzedefinierte PHP-Fehlermeldung aus
	 *
	 * @param string $error_msg
	 * @param konstant $error_type[optional]
	 */
	private function trigger_error($error_msg, $error_type = E_USER_WARNING) {
		trigger_error($error_msg, $error_type);
	}
	
	

}
?>