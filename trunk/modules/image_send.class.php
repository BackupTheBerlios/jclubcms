<?php
/**
 * Für die Ausgabe der Bilder zuständig
 * 
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License version 3
 * @package JClubCMS
 * @author Simon Däster
 */
require_once ADMIN_DIR.'lib/module.interface.php';
require_once ADMIN_DIR.'lib/image.class.php';
/**
 * Diese Klasse ist zustaendig fuer das Anzeigen der Bilder.
 * 
 * @author Simon Däster
 * @package JClubCMS
 * image_send.class.php
 */

class Image_send implements Module
{
	/**
	 * Image-Objekt
	 *
	 * @var Image
	 */	
	private $_img = null;
	
	/**
	 * Smarty-Objekt
	 *
	 * @var Smarty
	 */
	private $_smarty = null;

	/**
	 * Mysql-Objekt
	 *
	 * @var Mysql
	 */
	private $_mysql = null;

	/**
	 * GET, POST, COOKIE
	 *
	 * @var array
	 */
	private $_gpc = null;
	
	/**
	 * Texte zu den Bildern
	 *
	 * @var array
	 */
	private $_img_textes = array();

	/**
	 * Konstruktor. Diese Klasse braucht den Zugriff auf das Smarty-Objekt nicht.
	 *
	 * @param Mysql $mysql
	 * @param Smarty $smarty
	 */
	public function __construct($mysql, $smarty)
	{
		$this->_mysql = $mysql;
		$this->_smarty = $smarty;
		
	}

	public function action($gpc)
	{
		$this->_smarty->config_load('textes.de.conf', 'Image');
		$this->_img_textes = $this->_smarty->get_config_vars();
		$this->_gpc = $gpc;
		if (isset($gpc['GET']['img'])) {
			$this->_initImg($gpc['GET']['img']);
		} elseif (isset($gpc['GET']['thumb'])) {
			$this->_initThumb($gpc['GET']['thumb']);
		} else {
			$this->_initErrImg($this->_img_textes['no_param']);
		}
	}

	/**
	 * Gibt kein template zurück
	 * @deprecated
	 */ 
	public function gettplfile()
	{
		return false;
	}

	/**
	 * Initialisiert das Bild
	 *
	 */

	private function _initImg($bild_ID)
	{
		//Eintrag zur ID vorhanden?
		$this->_mysql->query("SELECT `filename` FROM `bilder` WHERE `bilder_ID` = '$bild_ID' LIMIT 1");

		$mysql_data = $this->_mysql->fetcharray();


		if(empty($mysql_data)) {
			
			$this->_initErrImg(100, 80, $this->_img_textes['no_id']);
			return;
		}

		//Entweder liegt das Bild im Gallery-Ordner oder im Origianl-Ordner (mit falscher Groesse?)
		if(is_file(IMAGE_DIR_GALL.$mysql_data['filename'])) {
			$this->_img = new Image(IMAGE_DIR_GALL.$mysql_data['filename']);

		} else {

			$this->_img = new Image(IMAGE_DIR_ORIGN.$mysql_data['filename']);
			$bild_data = $this->_img->send_infos();

			if($bild_data['height'] > IMAGE_MAXHEIGHT || $bild_data['width'] > IMAGE_MAXWIDTH) {
				$newSize = $this->_calcSize($bild_data['width'], $bild_data['height'], IMAGE_MAXWIDTH, IMAGE_MAXHEIGHT);
				//verkleinertes Bild in den Ordner speichern
				$this->_img->copy($newSize['width'], $newSize['height'], IMAGE_DIR_GALL.$mysql_data['filename']);

				//Alte Instanz loeschen
				unset($this->_img);

				//Neue Instanz mit kleinem Bild
				$this->_img = new Image(IMAGE_DIR_GALL.$mysql_data['filename']);
			}
		}

		//Bild ausgeben
		$this->_img->send_image();
	}

	/**
	 * Initialisiert den Thumb
	 *
	 */
	private function _initThumb($thumb)
	{
		//Eintrag zur ID vorhanden?
		$this->_mysql->query("SELECT `filename` FROM `bilder` WHERE `bilder_ID` = '$thumb' LIMIT 1");

		$mysql_data = $this->_mysql->fetcharray();

		//Ueberpruefung, ob ein Eintrag vorhanden ist
		if(empty($mysql_data))
		{
			//Fehlerbild ausgeben, weil kein Eintrag vorhanden ist
			$this->_initErrImg(100, 80, $this->_img_textes['no_id']);
			return;
		}

		//Existiert kein Thumb, wird eins erstellt
		if(!is_file(THUMB_DIR.$mysql_data['filename']))
		{
			$orgImg = new Image(IMAGE_DIR_ORIGN.$mysql_data['filename']);
			$bild_data = $orgImg->send_infos();

			$newSize = $this->_calcSize($bild_data['width'], $bild_data['height'], THUMB_MAXWIDTH, THUMB_MAXHEIGHT);

			$orgImg->copy($newSize['width'] , $newSize['height'], THUMB_DIR.$mysql_data['filename'], "jpeg");
			unset($orgImg);
		}


		//Bild ausgeben
		$this->_img = new Image(THUMB_DIR.$mysql_data['filename']);
		$this->_img->send_image();
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

	private function _initErrImg($width = 100, $height = 80, $text = '', $col_bg = "000000255", $col_text = "200150080")
	{
		$text = ($text == '') ? $this->_img_textes['img_not_found'] : $text;
		$this->_img = new Image('');
		$this->_img->create_image($width, $height, $text, $col_bg, $col_text);
		$this->_img->send_image();
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

	private function _calcSize($isWidth, $isHeight, $maxWidth, $maxHeight) {
		$verhaeltnis = (float) $isHeight / $isWidth;

		//Neue Breite zuweisen und neue Hoehe berechnen
		$newWidth = $maxWidth;
		$newHeight = floor($verhaeltnis * $newWidth);		//Abrunden

		//Wenn die Hoehe noch zu gross ist, wird die max. Höhe bestimmt und neue Breite berechnet
		if($newHeight > $maxHeight)
		{
			$newHeight = $maxHeight;
			$newWidth = floor((1/$verhaeltnis) * $newHeight);	//Abrunden
		}

		return array('width' => $newWidth, 'height' => $newHeight );
	}
}
?>
