<?php
/**
 * @package JClubCMS
 * @author Andreas John
 * 
 * Jax Captcha Class v1.o1 - Copyright (c) 2005, Andreas John aka Jack (tR)
 * This program and it's moduls are Open Source in terms of General Public License (GPL) v2.0
 *
 * captcha_image.class.php 		(captcha image service)
 * Modified through Simon Däster aka Redox for propper use in PHP 5
 * 
 * Last modification through Jack (tR): 2005-09-05
 * Last modification through Redox: 2007-11-13
**/

require_once ADMIN_DIR.'lib/module.interface.php';

class Captcha_image implements Module
{
	/**
	 * Path zu den Captcha-Bildern
	 *
	 * @var string
	 */
	private $_tmp_dir_path = './data/temp/captcha';

	/**
	 * Zeit in Sekunden, bis das Captcha ablaeuft
	 *
	 * @var int
	 */
	private $_captcha_expires_after = 420;
	
	/**
	 * GET, POST, COOKIE-Daten
	 *
	 * @var array
	 */
	private $_gpc = array();
	
	/**
	 * Aufbau der Klasse
	 *
	 * @param Smarty $smarty
	 * @param Mysql $mysql
	 */
	public function __construct($smarty, $mysql)
	{
		;
	}

	/**
	 * Start des Moduls
	 *
	 * @param array $gpc
	 */
	public function action($gpc)
	{
		$this->_tmp_dir_path               = USER_DIR.'data/temp/captcha/';
		$this->_captcha_expires_after = 420;
		$this->_gpc = $gpc;
		$this->_initCaptcha();
		$this->_cleanUp();
	}

	//Gibt kein Template zurueck
	public function gettplfile()
	{
		return false;
	}

	/**
	 * Initialisierung des Captcha-Bildes
	 *
	 */
	private function _initCaptcha()
	{
		// deactivate Cache
		header("Expires: Mon, 01 Jul 1990 00:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT");
		header("Pragma: no-cache");
		header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
		header("Content-Type: image/jpeg", true);

		if (!empty($this->_gpc['GET']['img'] ) ) {
			$img = $this->_gpc['GET']['img'];

		} else {
			throw new CMSException('kein Bild über &img=... angegeben', EXCEPTION_MODULE_CODE, 'Parameterfehler');
			exit;
		}

		if (!$fh = fopen( $this->_tmp_dir_path.'cap_'.$img.'.jpg', 'rb')) {
			throw new CMSException('Die Bilddatei konnte nicht geöffnet werten!', EXCEPTION_MODULE_CODE, 'Fehler beim Öffnen');
		} else {
			fpassthru( $fh );
			fclose( $fh );
		}

	}
	
	/**
	 * Aufraeumarbeiten
	 *
	 */
	private function _cleanUp()
	{
		// clean up
		$tmp_dir = dir($this->_tmp_dir_path);
		while( $entry = $tmp_dir->read())
		{
			if ( is_file( $this->_tmp_dir_path . $entry ) )
			{
				if ( time() - filemtime( $this->_tmp_dir_path . $entry ) > $this->_captcha_expires_after )
				{
					unlink( $this->_tmp_dir_path . $entry );
				}
			}
		}
	}
}





?>
