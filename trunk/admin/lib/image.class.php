<?php
/**

 * Beinhaltet die Elemente für Grafikfunktionen.
 * 
 * @author Simon Däster
 * @package JClubCMS
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 */
/**
 * Die Klasse Image ist zustaendig fuer Grafikfunktionen
 * 
 * Image speichert die Informationen ueber ein Bild ab, kann diese Informationen senden
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
 * @author Simon Däster
 * @package JClubCMS
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 * File: image.class.php
 * Classes: image
 * @requieres PHP5
 */
class Image {

	/**
	 * Datei zum Bild
	 *
	 * @var string
	 */
	private $file = null;
	/**
	 * Binäre Bildinformation
	 *
	 * @var binary
	 */
	private $im = null;
	/**
	 * Grafikformat
	 *
	 * @var string
	 */
	private $graphicformat = "jpeg";
	/**
	 * Höhe des Bildes
	 *
	 * @var numeric
	 */
	private $height = null;
	/**
	 * Breite des Bildes
	 *
	 * @var numeric
	 */
	private $width = null;
	/**
	 * Texte für die Bilder bei Fehlern
	 *
	 * @var array
	 */
	private $textes = array();


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
	public function __construct($file) 
	{
		global $system_textes;
		$this->_textes = $system_textes[LANGUAGE_ABR]['img'];
		
		if($file != "" && is_file($file) && file_exists($file)) {
			$this->_file = $file;

			$this->get_infos();

		} else {
			$this->_file = "";			
			$this->create_image(180, 100, $this->_textes['img_not_found']);
		}


	}
	
	/**
	 * Ein Bild wird erstellt. 
	 * Die Farben sind vorgegeben
	 * 
	 * Wird vom Konstruktor aufgerufen
	 *
	 * @param string $width Breite des Bildes
	 * @param string $height Hoehe des Bildes
	 * @param string $text Text, welcher im Bild steht
	 * @param string $col_background Die Hintergrundfarbe im String mit RGB-Werten
	 * @param string $col_text Die Textfarbe im String mit RGB-Werten
	 */

	public function create_image($width, $height, $text="", $background_color=BACKGROUND_COLOR, $text_color=TEXT_COLOR) 	{

		//Fest vorgegeben
		$this->_graphicformat = "jpeg";

		$this->_width = $width;
		$this->_height = $height;
		
		empty($text) ? $text = $this->_textes['img_not_found'] : $text = $text;

		$this->_im = imagecreatetruecolor($this->_width, $this->_height);

		//Aus den Parameter fuer Farbe (RGB-Werte) werden die Farben erstellt
		$background_color = imagecolorallocate ($this->_im, (int)substr($background_color, 0,3) , (int)substr($background_color, 3,3) , (int)substr($background_color, 6,3));
		$text_color = imagecolorallocate($this->_im, (int)substr($text_color, 0,3), (int)substr($text_color, 3,3), (int)substr($text_color, 6,3));

		imagefill($this->_im, 0,0, $background_color);
		imagestring($this->_im, 5, 5, 35, $text, $text_color);
	}
	




	/**
	 * Kopiert das Originalbild uns speichert es in ein neues Bild mit anderen Hoehen/Breiten ab
	 *
	 * @param int $new_x Neue Breite
	 * @param int $new_y Neue Hoehe
	 * @param string $file Speicherort
	 * @param string $new_format[optional] Neues Bildformat
	 */

	public function copy($new_width, $new_height, $file, $new_format="jpeg") 
	{

		if ($file != '' && is_file($file) && file_exists($file)) {
			$this->create_image(300, 26, $this->_textes['copy_failed']);
		}
		
		if($this->_im == null)
		{
			$this->get_im();
		}
		$new_im = imagecreatetruecolor($new_width, $new_height);

		imagecopyresized($new_im, $this->_im, 0, 0, 0, 0, $new_width, $new_height, $this->_width, $this->_height);
		eval("image$new_format(\$new_im, \$file);");
		imagedestroy($new_im);
		
		return true;

	}

	/**
	 * Senden das Bild per HTTP an den User
	 *
	 */

	public function send_image() 
	{

		$format = $this->_graphicformat;
		
		$im = $this->_im;

		header("Content-type: image/$format");
		if ($this->_im != null) {
			eval("image$format(\$im);");
		} else {
			readfile($this->_file);
		}
		
		
		
	}





	/**
	 * Sendet Informationen ueber das Bild, namentlich
	 * Grafik-Resource, Grafik-Format, die Breite und die Hoehe
	 *
	 * @return array ("format", "width", "height") 
	 */

	public function send_infos() 
	{
		return array("format" => $this->_graphicformat,"width" => $this->_width,
		"height" => $this->_height);
	}



	/**
	 * Der Klassendestruktor
	 *
	 */

	public function __destruct() 
	{
		$this->_file = null;
		$this->_im = null;
		$this->_graphicformat = null;
		$this->_height = null;
		$this->_width = null;
	}




	/*------------------
	*** Private Funktionen ***
	------------------*/


	/**
	 * Schaut, ob das Grafikformat unterstuetzt wird
	 * Speichert das Grafikformat, Hoehe und Breite
	 */

	private function get_infos() 
	{

		$supported = false;
		$array_image = getimagesize($this->_file);

		switch ($array_image[2]) {
			case 1:
				$this->_graphicformat = "gif";
				
				$supported = true;
				break;

			case 2:
				$this->_graphicformat = "jpeg";
				$supported = true;
				break;

			case 3:
				$this->_graphicformat = "png";				
				$supported = true;

				break;

			default:

				$this->create_image(300, 26, $this->_textes['format_not_supported']);
				$supported = false;
		}

		if($supported) {
			$this->_width = $array_image[0];
			$this->_height = $array_image[1];
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
		if(empty($this->_width) || empty($this->_height))
		{
			$this->get_infos();
		}
		
		switch($this->_graphicformat)
		{
			case 'gif':
				$this->_im = imagecreatefromgif($this->_file);
				return true;
			case 'jpeg':
				$this->_im = imagecreatefromjpeg($this->_file);
				return true;
			case 'png':
				$this->_im = imagecreatefrompng($this->_file);
				return true;
			default:
				return false;
		}
	}
}
?>
