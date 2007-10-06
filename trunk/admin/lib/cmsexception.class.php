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
	define('EXCEPTION_CORE_CODE', 1);
}

if (!defined('EXCEPTION_MYSQL_CODE')) {
	define('EXCEPTION_MYSQL_CODE', 2);
}

if (!defined('EXCEPTION_MODULE_CODE')) {
	define('EXCEPTION_MODULE_CODE', 3);
}


class CMSException extends Exception 
{
	private $title = "Unbekannter Fehler";
	
	/**
	 * Aufbau der Exception-Klasse
	 *
	 * @param string $message
	 * @param int $code
	 */
	
	public function __construct($message, $code = 0)
	{
		
		switch ($code) {
			case EXCEPTION_CORE_CODE:
				$this->title = "CMS-Core-Fehler";
				break;
			case EXCEPTION_MYSQL_CODE:
				$this->title = 'Mysql-Fehler';
				break;
			case EXCEPTION_MODULE_CODE:
				$this->title = 'Modul-Fehler';
				break;
			default:
				break;
		}
		
		// sicherstelen, dass alles korrekt zugewiesen wird 
		parent::__construct($message, $code);
	}
	
	/**
	 * Liefert den Titel zurueck
	 *
	 * @return string Fehlertitel
	 */
	
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * Gibt den Dateinamen ohne Ordnerangaben zurueck.
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
		return "<b>{$this->title}</b><br />\nEs ist ein Fehler aufgetreten in der Datei ".basename($this->getFile())." auf  Zeile {$this->getLine()} mit folgendern Nachricht: {$this->getMessage()}";
	}
	
	/**
	 * Exceptionhandler für nicht aufgefangene Exceptions, nicht nur für CMS-Exception.
	 *
	 * @param Exception $exception
	 */
	
	public static function stdExceptionHandler($exception)
	{
		$file = basename($exception->getFile());
		$pad = 5;
		echo <<<END
		<html>
			<head>
				<title>Jclub</title>
			</head>
			<body>
				<p style="margin-left: 20%; font-size: 28px; font-weight: bold;">Es ist ein unerwarteter Fehler aufgetreten</p>
				<table style="margin-left: 20%; width: 50%; border-style: solid;">
					<tr style="background-color: #FFDD90">
						<td colspan="2" style="font-weight: bold; padding:{$pad}px">Fehlertabelle</td>
					</tr>
					<tr>
						<td style="padding:{$pad}px">Datei</td>
						<td style="padding:{$pad}px">$file</td>
					</tr>
					<tr style="background-color: #EFEFEF; padding: 30px">
						<td style="padding:{$pad}px">Zeile</td>
						<td style="padding:{$pad}px">{$exception->getLine()}</td>
					</tr>
					<tr>
						<td style="padding:{$pad}px">Nachricht</td>
						<td style="padding:{$pad}px">{$exception->getMessage()}</td>
					</tr>
					<tr style="background-color: #EFEFEF;">
						<td style="padding:{$pad}px">Trace</td>
						<td style="padding:{$pad}px">{$exception->getTraceAsString()}</td>
					</tr>
				</table>
				<p style="margin-left: 20%; font-style: italic">Sollte dieser Fehler &ouml;fters auftreten, kontaktieren Sie bitte den Administrator. Danke.</p>
			</body>
		</html>
END;
	}
	
}
?>