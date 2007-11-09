<?php
/**
 * @package JClubCMS
 * @author Andreas John
 * 
 * Jax Captcha Class v1.o1 - Copyright (c) 2005, Andreas John aka Jack (tR)
 * This program and it's moduls are Open Source in terms of General Public License (GPL) v2.0
 *
 * captcha_image.php 		(captcha image service)
 *
 * Last modification: 2005-09-05
 * 
 * 
**/

class Captcha_image extends Module
{
	/**
	 * Path zu den Captcha-Bildern
	 *
	 * @var string
	 */
	private $tmp_dir_path = './data/temp/';

	/**
	 * Zeit in Sekunden, bis das Captcha ablaeuft
	 *
	 * @var int
	 */
	private $captcha_expires_after = 420;
	
	/**
	 * GET, POST, COOKIE-Daten
	 *
	 * @var array
	 */
	private $gpc = array();
	
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
		$this->tmp_dir_path               = './data/temp/';
		$this->captcha_expires_after = 420;
		$this->gpc = $gpc;
		$this->initCaptcha();
		$this->cleanUp();
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
	private function initCaptcha()
	{
		// deactivate Cache
		header("Expires: Mon, 01 Jul 1990 00:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT");
		header("Pragma: no-cache");
		header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
		header("Content-Type: image/jpeg", true);

		if (!empty($this->gpc['GET']['img'] ) ) {
			$img = $this->gpc['GET']['img'];

		} else {
			echo 'no image file specified via &img=...';
			exit;
		}

		if (!$fh = fopen( $this->tmp_dir_path.'cap_'.$img.'.jpg', 'rb')) {
			echo 'could not open image file!';
		} else {
			fpassthru( $fh );
			fclose( $fh );
		}

	}
	
	/**
	 * Aufraeumarbeiten
	 *
	 */
	private function cleanUp()
	{
		// clean up
		$tmp_dir = dir($this->tmp_dir_path);
		while( $entry = $tmp_dir->read())
		{
			if ( is_file( $tmp_dir_path . $entry ) )
			{
				if ( mktime() - filemtime( $tmp_dir_path . $entry ) > $this->captcha_expires_after )
				{
					unlink( $this->tmp_dir_path . $entry );
				}
			}
		}
	}
}





?>
