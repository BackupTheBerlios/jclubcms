<?php
/**
 * @author Simon Daester
 * @package JClubCMS
 * image_send.class.php
 * 
 * Diese Klasse ist zustaendig fuer das Editieren der Gaestebucheintraege. Auch koennen neue Beitraege hinzugefuegt oder geloescht
 * werden
 */

require_once ADMIN_DIR.'lib/image.class.php';

class Image_send implements Module
{
	/**
	 * Image-Objekt
	 *
	 * @var Image
	 */	
	private $img = null;

	/**
	 * Mysql-Objekt
	 *
	 * @var Mysql
	 */
	private $mysql = null;

	/**
	 * GET, POST, COOKIE
	 *
	 * @var array
	 */
	private $gpc = null;

	public function __construct($smarty, $mysql)
	{
		$this->mysql = $mysql;
	}

	public function action($gpc)
	{
		$this->gpc = $gpc;
		if (isset($gpc['GET']['bild'])) {
			$this->initImg($gpc['GET']['bild']);
		} elseif (isset($gpc['GET']['thumb'])) {
			$this->initThumb($gpc['GET']['thumb']);
		} else {
			$this->initErrImg('Keine Parameter');
		}
	}

	//Gibt kein Template zurueck
	public function gettplfile()
	{
		return false;
	}

	/**
	 * Initialisiert das Bild
	 *
	 */

	private function initImg($bild_ID)
	{
		global $dir_orgImage, $dir_galImage, $image_maxheight, $image_maxwidth, $thumb_maxheight, $thumb_maxwidth;

		//Eintrag zur ID vorhanden?
		$this->mysql->query("SELECT `filename` FROM `bilder` WHERE `bilder_ID` = '$bild_ID' LIMIT 1");

		$mysql_data = $this->mysql->fetcharray();


		if(empty($mysql_data)) {
			
			$this->initErrImg(80, 80, "Keine ID");
			return;
		}

		//Entweder liegt das Bild im Gallery-Ordner oder im Origianl-Ordner (mit falscher Groesse?)
		if(is_file($dir_galImage.$bild_data['filename'])) {
			$this->img = new Image($dir_galImage.$mysql_data['filename']);

		} else {

			$this->img = new Image($dir_orgImage.$mysql_data['filename']);
			$bild_data = $img->send_infos();

			if($bild_data['height'] > $image_maxheight || $bild_data['width'] > $image_maxwidth) {
				$newSize = $this->calcSize($bild_data['width'], $bild_data['height'], $image_maxwidth, $image_maxheight);
				//verkleinertes Bild in den Ordner speichern
				$this->img->copy($newSize['width'], $newSize['height'], $dir_galImage.$bild_mysql['filename']);

				//Alte Instanz loeschen
				unset($this->img);

				//Neue Instanz mit kleinem Bild
				$this->img = new Image($dir_galImage.$bild_mysql['filename']);
			}
		}

		//Bild ausgeben
		$this->img->send_image();
	}

	/**
	 * Initialisiert den Thumb
	 *
	 */
	private function initThumb($thumb)
	{
		//Eintrag zur ID vorhanden?
		$this->mysql->query("SELECT `filename` FROM `bilder` WHERE `bilder_ID` = '$thumb' LIMIT 1");

		$mysql_data = $this->mysql->fetcharray();

		//Ueberpruefung, ob ein Eintrag vorhanden ist
		if(empty($mysql_data))
		{
			//Fehlerbild ausgeben, weil kein Eintrag vorhanden ist
			$this->initErrImg(80, 80, "Keine ID");
			return;
		}

		//Existiert kein Thumb, wird eins erstellt
		if(!is_file($dir_thumb.$mysql_data['filename']))
		{
			$orgImg = new Image($dir_orgImage.$mysql_data['filename']);
			$bild_data = $orgImg->send_infos();

			$newSize = $this->calcSize($bild_data['width'], $bild_data['height'], $thumb_maxwidth, $thumb_maxheight);

			$orgImg->copy($newSize['width'] , $newSize['height'], $dir_thumb.$bild_mysql['filename'], "jpeg");
			unset($orgImg);
		}


		//Bild ausgeben
		$this->img = new Image($dir_thumb.$bild_mysql['filename']);
		$this->img->send_image();
	}

	/**
	 * Gibt ein Fehlerbild aus
	 *
	 * @param int $width
	 * @param int $height
	 * @param string $text
	 * @param string $col_bg Hintergrundfarbe
	 * @param string $col_text Textfarbe
	 */

	private function initErrImg($width = 100, $height = 80, $text = 'Bild nicht da', $col_bg = "000000255", $col_text = "200150080")
	{
		$this->img = new Image('');
		$this->img->create_image($width, $height, $text, $col_bg, $col_text);
		$this->img->send_image();
	}

	/**
	 * Berechnet die neue Groesse anhand der Parameter
	 *
	 * @param int $isWidth momentane Breite
	 * @param int $isHeight momentane Hoehe
	 * @param int $maxWidth maximale Breite
	 * @param int $maxHeight maximale Hoehe
	 * @return array neue Hoehe und Breite
	 */

	private function calcSize($isWidth, $isHeight, $maxWidth, $maxHeight) {
		$verhaeltnis = (float) $isHeight / $isWidth;

		//Neue Breite zuweisen und neue Hoehe berechnen
		$newWidth = $maxWidth;
		$newHeight = floor($verhaeltnis * $newWidth);		//Abrunden

		//Wenn die Hoehe noch zu gross ist, wird die max. H�he bestimmt und neue Breite berechnet
		if($newHeight > $maxHeight)
		{
			$newWidth = $image_maxheight;
			$newHeight = floor((1/$verhaeltnis) * $newWidth);	//Abrunden
		}

		return array('width' => $newWidth, 'height' => $newHeight );
	}
}
?>