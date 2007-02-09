<?php

/*-----------------------------------------------------------------
* @author Simon Däster
* @package JClubCMS
* File: image.class.php
* Classes: image
* Requieres: PHP5
*
* Die Klasse image ist zuständig für Grafikfunktionen
* Sie speichert die Informationen über ein Bild ab, kann diese Informationen senden
* und das Bild selber ausgeben
* Wenn keine Bilddatei vorhanden ist, dann wird automatisch ein Fehlerbild erstellt
* Um Thumbs zu erstellen, kann die Funktion "copy" verwendet werden.
* "copy" kann auch verwendet werden, um das Bild selber zu verändern.
* Dazu kann man einfach die Grössen belassen
* !Achtung: Vorhandene Dateien werden ohne Abfrage überschrieben!!!
*
* Diese Klasse ist nicht für die Administration der Bilder zuständig
* Die Klasse wird für jedes Bild gebraucht, um es darzustellen und nötige
* Informationen zum jeweiligen Bild zu erhalten
*
-------------------------------------------------------------------*/


class image {

	private $file = null;
	private $im = null;
	private $graphicformat = "jpeg";
	private $height = null;
	private $width = null;


	/*------------------
	*** Öffentliche Funktionen ***
	------------------*/


	/**
	 * Der Klassenkonstruktor
	 * Wird eine Datei angegeben, wird das Bild abgespeichert
	 * Ist das Argument leer, wird ein Fehlerbild erstellt
	 * Ist eine Datei angegeben, existiert aber nicht, wird ein anders Fehlerbild erstellt
	 * 
	 * @param string $file[optional] Bilddatei
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
	 * Kopiert das Originalbild uns speichert es in ein neues Bild mit anderen Höhen/Breiten ab
	 *
	 * @param int $new_x Neue Breite
	 * @param int $new_y Neue Höhe
	 * @param string $file Speicherort
	 * @param string $new_format[optional] Neues Bildformat
	 */

	public function copy($new_width, $new_height, $file, $new_format="jpeg") {

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

		eval("header(\"Content-type: image/$format\");");
		eval("image$format(\$im);");
		exit;
		
	}

	/**
	 * Ein Bild wird erstellt. 
	 * Die Farben sind vorgegeben
	 * 
	 * Wird vom Konstruktor aufgerufen
	 *
	 * @param string $text
	 * @param string $col_background Die Hintergrundfarbe im String mit RGB-Werten
	 * @param string $col_text Die Textfarbe im String mit RGB-Werten
	 */

	public function create_image($width, $height, $text="Bild nicht gefunden", $col_background = "000000000", $col_text="050255070") {

		//Fest vorgegeben
		$this->graphicformat = "jpeg";

		$this->width = $width;
		$this->height = $height;

		$this->im = imagecreatetruecolor($this->width, $this->height);

		//Aus den Parameter für Farbe (RGB-Werte) werden die Farben erstellt
		$background_color = imagecolorallocate ($this->im, (int)substr($col_background, 0,3) , (int)substr($col_background, 3,3) , (int)substr($col_background, 6,3));
		$text_color = imagecolorallocate($this->im, (int)substr($col_text, 0,3), (int)substr($col_text, 3,3), (int)substr($col_text, 6,3));

		imagefill($this->im, 0,0, $background_color);
		imagestring($this->im, 5, 5, 35, $text, $text_color);
	}




	/**
	 * Sendet Informationen über das Bild, namentlich
	 * Grafik-Resource, Grafik-Format, die Breite und die Höhe
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
	 * Schaut, ob das Grafikformat unterstützt wird
	 * Speichert das Grafikformat und die Bildressource
	 * Speichert auch die Höhe und Breite
	 */

	private function get_infos() {

		$supported = false;
		$array_image = getimagesize($this->file);

		switch ($array_image[2]) {
			case 1:
				$this->graphicformat = "gif";
				$this->im = imagecreatefromgif($this->file);
				$supported = true;
				break;

			case 2:
				$this->graphicformat = "jpeg";
				$this->im = imagecreatefromjpeg($this->file);
				$supported = true;
				break;

			case 3:
				$this->graphicformat = "png";
				$this->im = imagecreatefrompng($this->file);
				$supported = true;

				break;

			default:

				$this->create_image(330, 26, "Dieses Format wird nicht unterstützt");
				$this->send_image();
				$supported = false;
		}

		if($supported) {
			$this->width = $array_image[0];
			$this->height = $array_image[1];
		}

	}


	/**
	 *Gibt eine benutzedefinierte PHP-Fehlermeldung aus
	 *
	 * @param string $error_msg	Fehlernachricht
	 * @param konstant $error_type[optional]	Fehlertyp
	 */
	private function trigger_error($error_msg, $error_type = E_USER_WARNING) {
		trigger_error($error_msg, $error_type);
	}



}
?>