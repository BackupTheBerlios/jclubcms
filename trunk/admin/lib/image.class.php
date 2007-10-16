<?php

/**
 * @author Simon D�ster
 * @package JClubCMS
 * File: image.class.php
 * Classes: image
 * Requieres: PHP5
 *
 * Die Klasse image ist zustaendig fuer Grafikfunktionen
 * Sie speichert die Informationen ueber ein Bild ab, kann diese Informationen senden
 * und das Bild selber ausgeben
 * Wenn keine Bilddatei vorhanden ist, dann wird automatisch ein Fehlerbild erstellt
 * Um Thumbs zu erstellen, kann die Funktion "copy" verwendet werden.
 * "copy" kann auch verwendet werden, um das Bild selber zu ver�ndern.
 * Dazu kann man einfach die Gr�ssen belassen
 * !Achtung: Vorhandene Dateien werden ohne Abfrage �berschrieben!!!
 *
 * Diese Klasse ist nicht fuer die Administration der Bilder zustaendig
 * Die Klasse wird fuer jedes Bild gebraucht, um es darzustellen und noetige
 * Informationen zum jeweiligen Bild zu erhalten
 *
 */


class image {

	private $file = null;
	private $im = null;
	private $graphicformat = "jpeg";
	private $height = null;
	private $width = null;


	/*------------------
	*** Oeffentliche Funktionen ***
	------------------*/


	/**
	 * Der Klassenkonstruktor
	 * Wird eine Datei angegeben, wird das Bild abgespeichert
	 * Ist das Argument leer, wird ein Fehlerbild erstellt
	 * Ist eine Datei angegeben, existiert aber nicht, wird ein anders Fehlerbild erstellt
	 * 
	 * @param string $file Bilddatei
	 */

	public function __construct($file) {

		if($file != "" && is_file($file))
		{
			$this->file = $file;

			$this->get_infos();

		}
		else
		{
			$this->file = "";
			$this->create_image(180, 100, "Bild nicht gefunden");
		}


	}



	/**
	 * Kopiert das Originalbild uns speichert es in ein neues Bild mit anderen H�hen/Breiten ab
	 *
	 * @param int $new_x Neue Breite
	 * @param int $new_y Neue H�he
	 * @param string $file Speicherort
	 * @param string $new_format[optional] Neues Bildformat
	 */

	public function copy($new_width, $new_height, $file, $new_format="jpeg") {

		if($this->im == null)
		{
			$this->get_im();
		}
		$new_im = imagecreatetruecolor($new_width, $new_height);

		imagecopyresized($new_im, $this->im, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
		eval("image$new_format(\$new_im, \$file);");
		imagedestroy($new_im);

	}

	/**
	 * Senden das Bild per HTTP an den User
	 *
	 */

	public function send_image() {

		$format = $this->graphicformat;
		
		$im = $this->im;

		header("Content-type: image/$format");
		if ($this->im != null) {
			eval("image$format(\$im);");
		} else {
			readfile($this->file);
		}
		
		
		
	}

	/**
	 * Ein Bild wird erstellt. 
	 * Die Farben sind vorgegeben
	 * 
	 * Wird vom Konstruktor aufgerufen
	 *
	 * @param string $width Breite des Bildes
	 * @param string $height H�he des Bildes
	 * @param string $text Text, welcher im Bild steht
	 * @param string $col_background Die Hintergrundfarbe im String mit RGB-Werten
	 * @param string $col_text Die Textfarbe im String mit RGB-Werten
	 */

	public function create_image($width, $height, $text="Bild nicht gefunden", $col_background = "000000000", $col_text="050255070") {

		//Fest vorgegeben
		$this->graphicformat = "jpeg";

		$this->width = $width;
		$this->height = $height;

		$this->im = imagecreatetruecolor($this->width, $this->height);

		//Aus den Parameter fuer Farbe (RGB-Werte) werden die Farben erstellt
		$background_color = imagecolorallocate ($this->im, (int)substr($col_background, 0,3) , (int)substr($col_background, 3,3) , (int)substr($col_background, 6,3));
		$text_color = imagecolorallocate($this->im, (int)substr($col_text, 0,3), (int)substr($col_text, 3,3), (int)substr($col_text, 6,3));

		imagefill($this->im, 0,0, $background_color);
		imagestring($this->im, 5, 5, 35, $text, $text_color);
	}




	/**
	 * Sendet Informationen ueber das Bild, namentlich
	 * Grafik-Resource, Grafik-Format, die Breite und die Hoehe
	 *
	 * @return array ("format", "width", "height") 
	 */

	public function send_infos() {
		return array("format" => $this->graphicformat,"width" => $this->width,
		"height" => $this->height);
	}



	/**
	 * Der Klassendestruktor
	 *
	 */

	public function __destruct() {
		$file = null;
		$im = null;
		$graphicformat = null;
		$height = null;
		$width = null;
	}




	/*------------------
	*** Private Funktionen ***
	------------------*/


	/**
	 * Schaut, ob das Grafikformat unterstuetzt wird
	 * Speichert das Grafikformat, Hoehe und Breite
	 */

	private function get_infos() {

		$supported = false;
		$array_image = getimagesize($this->file);

		switch ($array_image[2]) {
			case 1:
				$this->graphicformat = "gif";
				
				$supported = true;
				break;

			case 2:
				$this->graphicformat = "jpeg";
				$supported = true;
				break;

			case 3:
				$this->graphicformat = "png";				
				$supported = true;

				break;

			default:

				$this->create_image(300, 26, "Format wird nicht unterstuetzt");
				$this->send_image();
				$supported = false;
		}

		if($supported) {
			$this->width = $array_image[0];
			$this->height = $array_image[1];
		}

	}
	
	/**
	 * Holt die Datenresource aus dem Bild und speichert sie ab
	 *
	 * @return boolean Erfolg
	 */
	
	private function get_im()
	{
		//Informationen wurden wahrsch. nicht geholt
		if(empty($this->width) || empty($this->height))
		{
			$this->get_infos();
		}
		
		switch($this->graphicformat)
		{
			case 'gif':
				$this->im = imagecreatefromgif($this->file);
				return true;
			case 'jpeg':
				$this->im = imagecreatefromjpeg($this->file);
				return true;
			case 'png':
				$this->im = imagecreatefrompng($this->file);
				return true;
			default:
				return false;
		}
	}
}
?>
