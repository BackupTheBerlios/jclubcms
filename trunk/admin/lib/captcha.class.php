<?php
/**
 * Jax Captcha Class v1.o1 - Copyright (c) 2005, Andreas John aka Jack (tR)
 * This program and it's moduls are Open Source in terms of General Public License (GPL) v2.0
 * 
 * Modified through Simon Däster aka Redox for propper use in PHP 5
 * 
 * class.captcha.php 		(captcha class module)
 * 
 * Last modification through Jack (tR): 2005-09-05
 * Last modification through Redox: 2007-11-18
 * 
 * @package JClubCMS
 * @author  Andreas John
*/

class Captcha
{
	/**
	 * Sessionschlüssel
	 *
	 * @var string
	 */
	private $_session_key = null;
	
	/**
	 * Ordner wo die Captcha-Bilder gespeichert werden
	 *
	 * @var string
	 */
	private $_temp_dir    = null;
	
	/**
	 * Ordner, wo die Textformat-Datei abgelegt ist
	 *
	 * @var string
	 */
	private $_data_dir = null;
	
	/**
	 * Breite des Bilde
	 *
	 * @var int
	 */
	private $_width       = 160;
	
	/**
	 * Höhe des Bildes
	 *
	 * @var int
	 */
	private $_height      = 60;
	
	/**
	 * JPEG-Qualität
	 *
	 * @var int
	 */
	private $_jpg_quality = 15;


	/**
	 * Constructor - Initializes Captcha class!
	 *
	 * @param string $session_key
	 * @param string $temp_dir
	 * @return captcha
	 */
	public function __construct( $session_key, $temp_dir, $data_dir = null )
	{
		$this->_session_key = $session_key;
		$this->_temp_dir    = $temp_dir;
		
		if(isset($data_dir) && !empty($data_dir)) {
			$this->_data_dir = $data_dir;
		} else {
			$this->_data_dir = USER_DIR.'data';		
		}
	}


	/**
	 * Generates Image file for captcha
	 *
	 * @param string $location
	 * @param string $char_seq
	 * @return true
	 */
	private function _generate_image( $location, $char_seq )
	{
		$num_chars = strlen($char_seq);

		$img = imagecreatetruecolor( $this->_width, $this->_height );
		imagealphablending($img, 1);
		imagecolortransparent( $img );

		// generate background of randomly built ellipses
		for ($i=1; $i<=200; $i++)
		{
			$r = round( rand( 0, 100 ) );
			$g = round( rand( 0, 100 ) );
			$b = round( rand( 0, 100 ) );
			$color = imagecolorallocate( $img, $r, $g, $b );
			imagefilledellipse( $img,round(rand(0,$this->_width)), round(rand(0,$this->_height)), round(rand(0,$this->_width/16)), round(rand(0,$this->_height/4)), $color );
		}

		$start_x = round($this->_width / $num_chars);
		$max_font_size = $start_x;
		$start_x = round(0.5*$start_x);
		$max_x_ofs = round($max_font_size*0.9);

		// set each letter with random angle, size and color
		for ($i=0;$i<=$num_chars;$i++)
		{
			$r = round( rand( 127, 255 ) );
			$g = round( rand( 127, 255 ) );
			$b = round( rand( 127, 255 ) );
			$y_pos = ($this->_height/2)+round( rand( 5, 20 ) );

			$fontsize = round( rand( 18, $max_font_size) );
			$color = imagecolorallocate( $img, $r, $g, $b);
			$presign = round( rand( 0, 1 ) );
			$angle = round( rand( 0, 25 ) );
			if ($presign==true) $angle = -1*$angle;
			
			ImageTTFText( $img, $fontsize, $angle, $start_x+$i*$max_x_ofs, $y_pos, $color, $this->_data_dir.'/default.ttf', substr($char_seq,$i,1) );
		}

		// create image file
		imagejpeg( $img, $location, $this->_jpg_quality );
		flush();
		imagedestroy( $img );
		return true;
	}


	/**
	 * Returns name of the new generated captcha image file
	 *
	 * @param int $num_chars
	 * @return mixed encrypted string or false when an error occured
	 */
	public function get_pic( $num_chars=8 )
	{
		// define characters of which the captcha can consist
		$alphabet = array(
		'A','B','C','D','E','F','G','H','I','J','K','L','M',
		'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'1','2','3','4','5','6','7','8','9','0' );

		$max = sizeof( $alphabet );

		// generate random string
		$captcha_str = '';
		for ($i=1;$i<=$num_chars;$i++) {
			 // from 1..$num_chars
			 
			// choose randomly a character from alphabet and append it to string
			$chosen = rand( 1, $max );
			$captcha_str .= $alphabet[$chosen-1];
		}

		// generate a picture file that displays the random string
		if ( $this->_generate_image( $this->_temp_dir.'/'.'cap_'.md5( strtolower( $captcha_str )).'.jpg' , $captcha_str ) ) {
			$fh = fopen( $this->_temp_dir.'/'.'cap_'.$this->_session_key.'.txt', "w" );
			fputs( $fh, md5( strtolower( $captcha_str ) ) );
			return( md5( strtolower( $captcha_str ) ) );
		} else {
			return false;
		}
	}

	/**
	 * check hash of password against hash of searched characters
	 *
	 * @param string $char_seq
	 * @return boolean
	 */
	public function verify( $char_seq )
	{
		$fh = fopen($this->_temp_dir.'/'.'cap_'.$this->_session_key.'.txt', "r" );
		$hash = fgets( $fh );
		fclose($fh);
		
		if (md5(strtolower($char_seq)) == $hash) {
			/* Damit das Passwort ungültig wird, überschreiben wir die Datei */
			$fh = fopen($this->_temp_dir.'/'.'cap_'.$this->_session_key.'.txt', "r+" );
			fputs($fh, "!!No more access!!");
			fclose($fh);
			return true;
		} else {
			return false;
		}
	}
}


?>
