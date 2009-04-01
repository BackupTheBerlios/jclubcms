<?php

/**
 * @author Simon Däster
 * @package JClubCMS
 * File: exceptions.class.php
 * Classes: coreexception, mysqlexception, moduleexception, stdexception
 * Requieres: PHP5
 * 
 * 
 * Beschrieb:
 * Sammlung der Exception, mit denen die Fehlerbehandlung des CMS funktioniert
 */

/**
 * in
 */

if (!defined('EXCEPTION_CORE_CODE')) {

	/**
	 * Konstante fuer ein Exception im Kern des CMS
	 *
	 */
	define('EXCEPTION_CORE_CODE', 1);
}

if (!defined('EXCEPTION_MYSQL_CODE')) {
	/**
	 * Konstante fuer ein Exception im MySQL
	 *
	 */
	define('EXCEPTION_MYSQL_CODE', 2);
}

if (!defined('EXCEPTION_MODULE_CODE')) {

	/**
	 * Konstante fuer ein Exception in den Modules
	 *
	 */
	define('EXCEPTION_MODULE_CODE', 3);
}

if (!defined('EXCEPTION_LIBARY_CODE')) {

	/**
	 * Konstante fuer ein Exception in den Libaries
	 *
	 */
	define('EXCEPTION_LIBARY_CODE', 4);
}

/**
 * Sammlung der Exception, mit denen die Fehlerbehandlung des CMS funktioniert
 * @author Simon Däster
 * @package JClubCMS
 * File: exceptions.class.php
 * Classes: coreexception, mysqlexception, moduleexception, stdexception
 * @requieres PHP5
 */

class CMSException extends Exception
{
	private $_title = "";

	/**
	 * Aufbau der Exception-Klasse
	 *
	 * @param string $message Nachricht
	 * @param int $code Benutzercode
	 * @param string $title Fehlertitel
	 */

	public function __construct($message, $code = 0, $title = "")
	{
		// sicherstellen, dass alles korrekt zugewiesen wird
		parent::__construct($message, $code);
		
		switch ($code) {
			case EXCEPTION_CORE_CODE:
				$this->_title = "CMS-Core-Fehler";
				break;
			case EXCEPTION_MYSQL_CODE:
				$this->_title = 'Mysql-Fehler';
				break;
			case EXCEPTION_MODULE_CODE:
				$this->_title = 'Modul-Fehler';
				break;
			case EXCEPTION_LIBARY_CODE:
				$this->_title = "Libary-Fehler";
				break;
			default:
				$this->_title = 'Fehler';
				break;
		}
		
		if (!empty($title)) {
			$this->_title .= " - $title";
		}
	}

	/**
	 * Liefert den Titel zurück
	 *
	 * @return string Fehlertitel
	 */

	public function getTitle()
	{
		return $this->_title;
	}

	/**
	 * Gibt den Dateinamen ohne Ordnerangaben zurück.
	 *
	 * @return string Dateiname
	 */

	public function getFilename()
	{
		return basename($this->getFile());
	}


	/**
	 * Ausgabe der Excpetion bei Verwendung als String. Magische Funktion.
	 *
	 * @return string Exceptionstring.
	 */

	public function __toString()
	{
		return "<b>".htmlentities($this->_title)."</b><br />\nEs ist ein Fehler aufgetreten in der Datei ".basename($this->getFile())." auf  Zeile {$this->getLine()} mit folgendern Nachricht: ".htmlentities($this->getMessage());
	}

	/**
	 * Exceptionhandler für nicht aufgefangene Exceptions, nicht nur für CMS-Exception.
	 *
	 * @param Exception $exception
	 */

	public static function stdExceptionHandler($exception)
	{
		$file = basename($exception->getFile());
		
		//1. Gartenhag nicht umbrechen -> String bei replace verkleinern und Gartenhag voranhängen
		$strTrace = '#'.str_replace('#', "<br />\n#", substr($exception->getTraceAsString(), 1));
		
		self::printException($file, $exception->getLine(), $exception->getMessage(), $strTrace);
		self::logException($exception, "Uncaught Exception");


	}

	/**
	 * Schreibt die Exception in eine Log-Datei
	 *
	 * @param Exception $e Exceptionklasse 
	 */

	public static function logException($e, $title = null, $comment = null)
	{
		date_default_timezone_set("Europe/Zurich");
		$time = date("Y-m-d H:i");
		if (empty($title)) {
			$title = $e->getTitle();
		}
		
		$rpcl_arr = array("\t" => " ", "\n" => " ", "\r" => " ", "\xOB" => " ");
		$file = $e->getFile();
		$code = $e->getCode();
		$msg = strtr($e->getMessage(), $rpcl_arr);
		$line = $e->getLine();
		$trace =  strtr($e->getTraceAsString(), $rpcl_arr);

		if (!empty($comment)) {
			$comment = strtr($comment, $rpcl_arr);
		}
		
		if (key_exists('HTTP_POST_VARS', $GLOBALS)) {
			$post = strtr(print_r($GLOBALS['HTTP_POST_VARS'],1), $rpcl_arr);
		} else {
			$post = "POST_VARS ARE NOT AVAILABLE";
		}
		
		if (key_exists('HTTP_GET_VARS', $GLOBALS)) {
			$get = strtr(print_r($GLOBALS['HTTP_GET_VARS'],1), $rpcl_arr);
		} else {
			$get = "GET_VARS ARE NOT AVAILABLE";
		}

		/* Log schreiben */
		$fh = fopen(ADMIN_DIR."log/.exception.log", "a");

		$log_line = "#LOG-ENTRY\nTITLE: $title\nCODE: $code\nTIME: $time\nFILE: $file\nLINE: $line\nMESSAGE: $msg\n"
		."TRACE: $trace\nPOST: $post\nGET: $get\nCOMMENT: $comment\n#END\n\n";
		fputs($fh, $log_line);
		fclose($fh);

	}


	/**
	 * Gibt eine Exception-Fehlermeldung heraus
	 *
	 * @param string $file Datei
	 * @param string $line Zeile
	 * @param string $msg Nachricht
	 * @param string $trace Trace
	 */

	public static function printException($file, $line, $msg, $trace)
	{
		//Style: padding in px
		$pad = 5;
		
		$file = CMSException::htmlencode($file);
		$msg = CMSException::htmlencode($msg);
		$trace = nl2br(CMSException::htmlencode($trace));
		echo <<<END
		<html>
			<head>
				<title>Jclub -  Fehler</title>
			</head>
			<body>
				<p style="margin-left: 20%; font-size: 28px; font-weight: bold;">Es ist ein unerwarteter Fehler aufgetreten</p>
				<table style="margin-left: 20%; border-style: solid;">
					<tr style="background-color: #FFDD90">
						<td colspan="2" style="font-weight: bold; padding:{$pad}px">Fehlertabelle</td>
					</tr>
					<tr>
						<td style="padding: {$pad}px">Datei</td>
						<td style="padding: {$pad}px">$file</td>
					</tr>
					<tr style="background-color: #EFEFEF; padding: 30px">
						<td style="padding: {$pad}px">Zeile</td>
						<td style="padding: {$pad}px">$line</td>
					</tr>
					<tr>
						<td style="padding: {$pad}px">Nachricht</td>
						<td style="padding: {$pad}px">$msg</td>
					</tr>
					<tr style="background-color: #EFEFEF;">
						<td style="padding: {$pad}px">Trace</td>
						<td style="padding: {$pad}px">$trace</td>
					</tr>
				</table>
				<p style="margin-left: 20%; font-style: italic">Sollte dieser Fehler &ouml;fters auftreten, kontaktieren Sie bitte den Administrator. Danke.</p>
			</body>
		</html>
END;
	}
	
	/**
	 * Kodiert Zeichen mit einer HTML-Entsprechung in die HTML-Form. Die Kodierung
	 * findet auf der Basis des Zeichensatzes UTF-8 statt, weswegen sie für interne Ausgaben 
	 * (PHP-Datei ist im UTF-8-Format) verwendet werden muss.
	 *
	 * @param string $string Zu kodierender String
	 * @return string Kodierter String
	 */
	
	public static function htmlencode($string)
	{
		return htmlentities($string, ENT_COMPAT, 'UTF-8');
	}
	
}

?>
