<?php
/**
 * Die Klasse timeparser ist zuständig für das Parsen der Zeiten die 
 * in den MySQL-Tabellen angelegt sind (Gästebuch, News, uä) und dessen
 * Werte die im Y-m-d H:i:s Format sind.
 * Geparst wird _OHNE_ den Weg über time() um "Zukunftssicher" zu sein.
 * 
 *
 *
 * Funktionsbeschrieb:
 * -  __construct($time_format)
 * -  Das Konstrukt dieser Klasse
 *
 * -  time2array() (wird von time_output ausgeführt)
 * -  Schreibt den String in ein Array
 *
 * -  year_replace($format) (wird von time_output ausgeführt)
 * -  Gibt das Jahr im gewünschten Format zurück
 *
 * -  month_replace($format) (wird von time_output ausgeführt)
 * -  Gibt den Monat im gewünschten Format zurück
 *
 * -  day_replace($format) (wird von time_output ausgeführt)
 * -  Gibt den Tag im gewünschten Format zurück
 *
 * -  hour_replace($format) (wird von time_output ausgeführt)
 * -  Gibt die Stunde im gewünschten Format zurück
 *
 * -  minute_replace($format) (wird von time_output ausgeführt)
 * -  Gibt ddie Minute im gewünschten Format zurück
 *
 * -  second_replace($format) (wird von time_output ausgeführt)
 * -  Gibt die Sekunden im gewünschten Format zurück
 *
 * -  time_output ($time_string)
 * -  Parst den String nachher in das angegebene Time-Format.
 *
 * -  __destruct
 * -  Der Destruktor der Klasse
 * 
 *
 * _Nicht_ geplante Unterstüzung:
 * 
 * - B	Swatch-Internet-Zeit
 * - D	Tag der Woche gekürzt auf drei Buchstaben
 * - I 	Fällt ein Datum in die Sommerzeit
 * - l 	Ausgeschriebener Tag der Woche
 * - L	Schaltjahr oder nicht
 * - O	Zeitunterschied zur Greenwich time (GMT) in Stunden
 * - S	Anhang der englischen Aufzählung für einen Monatstag, zwei Zeichen
 * - t	Anzahl der Tage des angegebenen Monats
 * - T	Zeitzoneneinstellung des Rechners
 * - U	Sekunden seit Beginn der UNIX-Epoche
 * - w	Numerischer Tag einer Woche
 * - W	ISO-8601 Wochennummer des Jahres, die Woche beginnt am Montag
 * - z	Der Tag eines Jahres
 * - Z	 Offset der Zeitzone in Sekunden.
 *
 * The Timeparser Class- Parst eine MySQL-Zeit in ein gewünschtes Format.
 * Die Daten aus der DB wird eingelesen und anschliessend über explode in die einzelnen
 * Blöcken (Jahr, Tag, Monat, Stunde, Minute und Sekunde) aufgeteilt und in das time_array
 * gespeichert.
 * 
 * Anschliessend wird über die Funktion time_output via den Vorlagestring (zum grösten Teil 
 * date()-ähnlich) ausgegeben.
 * Die date()-Funktion wird bewusst ausgelassen, damit auch nach 2038 noch funktionsfähig ist.
 * 
 * @author David Däster
 * @version 0.1
 * @package JClubCMS
 * @copyright JClub
 */

class Timeparser {
	private $mysql_time_set = "Y-m-d H:i:s";
	private $time_string = "";
	private $time_format = "";
	private $time_array = array();
	
	/**
	 * Liest das gewünschte Ausgabe-Timeformat ein
	 *
	 * @param string $time_format
	 */
	public function __construct($time_format) {
		$this->time_format = $time_format;
	}
	
	/**
	 * Parst den gewünschten Ausgabeformat-String um, und gibt dann in der Form die Zeit aus.
	 *
	 * @param string $time_string
	 * @return string
	 */
	public function time_output ($time_string) {
		$this->time_string = $time_string;
		$this->time2array();
		$time_format_len = strlen($this->time_format);
		$time_string = "";
		
		for ($i=0; $i<$time_format_len; $i++) {
			  switch ($this->time_format[$i]) {
			    case "\\":
			    	
			    	$time_string .= $this->time_format[$i+1];
			    	$i++;
			    	break;
			    case "\r":
			    	$time_string .= "r";
			    	break;
			    case "\n":
			    	$time_string .= "n";
			    	break;
			    //Jahres-Überprufung
			    case "Y":
			    	$time_string .= $this->year_replace("Y");
			    	break;
			    case "y":
			    	$time_string .= $this->year_replace("y");
			    	break;
			    //Montats-Überprüfung
			    case "m":
			    	$time_string .= $this->month_replace("m");
			    	break;
			    case "M":
			    	$time_string .= $this->month_replace("M");
			    	break;
			    case "F":
			    	$time_string .= $this->month_replace("F");
			    	break;
			    case "n":
			    	$time_string .= $this->month_replace("n");
			    	break;
			    //Tages-Überprüfung
			    case "d":
			    	$time_string .= $this->day_replace("d");
			    	break;
			    case "j":
			    	$time_string .= $this->day_replace("j");
			    	break;
			    //Stunden-Überprüfung
			    case "H":
			    	$time_string .= $this->hour_replace("H");
			    	break;
			    case "h":
			    	$time_string .= $this->hour_replace("h");
			    	break;
			    case "g":
			    	$time_string .= $this->hour_replace("g");
			    	break;
			    case "G":
			    	$time_string .= $this->hour_replace("G");
			    	break;
			    case "a":
			    	$time_string .= $this->hour_replace("a");
			    	break;
			    case "A":
			    	$time_string .= $this->hour_replace("A");
			    	break;
			    //Minuten-Überprüfung
			    case "i":
			    	$time_string .= $this->minute_replace("i");
			    	break;
			    //Sekunden-Überprüfung
			    case "s":
			    	$time_string .= $this->second_replace("s");
			    	break;
			    //Default			    				    	
				default:
					$time_string .= $this->time_format[$i];
			}
		  
		}
		return $time_string;
	}
	
	/** ********************************** **/
	/** * * * * PRIVATE FUNKTIONEN * * * * **/
	/** ********************************** **/
	
	/**
	 * Erstellt aus der Zeit in der DB ein Array, um nachher einfach weiter mit den Daten zu arbeiten
	 *
	 */
	private function time2array () {
		//Bedingung: Das Time-Format ist wie folgt: Y-m-d H:i:s
		$date_array = explode(" ", $this->time_string);
		$time_array = explode(":", $date_array[1]);
		$date_array = explode("-", $date_array[0]);
		
		$this->time_array = array('time_year'=>$date_array[0], 'time_month'=>$date_array[1], 'time_day'=>$date_array[2], 'time_hour'=>$time_array[0], 'time_minute'=>$time_array[1], 'time_second'=>$time_array[2]);
	}

	/**
	 * Gibt das Jahr in der gewünschten Position des Ausgabe-Timeformats aus.
	 *
	 * @param char $format
	 * @return string
	 */
	private function year_replace($format) {
	  	switch ($format) {
	  		case "Y":
	  			return $this->time_array['time_year'];
	  		break;
	  		
	  		case "y":
	  			$year = $this->time_array['time_year'];
	  			$year %=100;
	  			if ($year < 10) {
	  				$year = "0".$year;
	  			}	  			
	  			return $year;
	  		break;
	  		
	  		default:
	  			return $this->time_array['time_year'];
		}
	}
	/** 
	 * Gibt den Monat in der gewünschten Position des Ausgabe-Timeformats aus.
	 *
	 * @param char $format
	 * @return string
	 */
	private function month_replace($format) {
	  	switch ($format) {
	    	case "m":
	    		return $this->time_array['time_month'];
	    	break;
	    	
	    	case "n":
	    		$month = str_replace('0', '', $this->time_array['time_month']);
	    		return $month;
	    	break;
	    	
	    	case "M":
	    		$month_array = array('Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez');
	    		$month = $this->time_array['time_month'];
	    		settype($month, "integer");
	    		return $month_array[$month];
	    	break;
	    	
	    	case "F":
	    		$month_array = array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
	    		$month = $this->time_array['time_month'];
	    		settype($month, "integer");
	    		return $month_array[$month];
	    	break;
	    	default:
	    		return $this->time_array['time_month'];	    		
		}
	}
	/** 
	 * Gibt den Tag in der gewünschten Position des Ausgabe-Timeformats aus.
	 *
	 * @param char $format
	 * @return string
	 */
	private function day_replace($format) {
		switch ($format) {
		  	case "d":
		  		return $this->time_array['time_day'];
		  		break;
		  	case "j":
		  		$day = $this->time_array['time_day'];
		  		settype($day, "integer");
		  		return $day;
		  		break;
		  	default:
		  		return $this->time_array['time_day'];
		}
	}
	/** 
	 * Gibt die Stunde in der gewünschten Position des Ausgabe-Timeformats aus.
	 *
	 * @param char $format
	 * @return string
	 */
	private function hour_replace($format) {
	  	switch ($format) {
	  		case "H":
	  			return $this->time_array['time_hour'];
				break;
			case "h":
				if ($this->time_array['time_hour'] <= 12) {
					return $this->time_array['time_hour'];  
				}
				else {
					$time = $this->time_array['time_hour']-12;
					if ($time <10) {
					  $time = "0".$time;
					}
					return $time;
					
				}
				break;
			case "g":
				$hour = $this->time_array['time_hour'];
				settype($hour, "integer");
				if ($hour>12) {
					$hour -= 12;
				}
				return $hour;
				break;
			case "G":
				$hour = $this->time_array['time_hour'];
				settype($hour, "integer");
				return $hour;
				break;
			case "a":
				$hour = $this->time_array['time_hour'];
				if ($hour>12) {
					$hour = "pm";
				}
				else {
					$hour = "am";
				}
				return $hour;
				break;
			case "A":
				$hour = $this->time_array['time_hour'];
				if ($hour>12) {
					$hour = "PM";
				}
				else {
					$hour = "AM";
				}
				return $hour;
				break;
			default:
				return $this->time_array['time_hour'];
			}
	}
	/**
	 * Gibt die Minute in der gewünschten Position des Ausgabe-Timeformats aus.
	 *
	 * @param char $format
	 * @return string
	 */
	private function minute_replace($format) {
	  	switch ($format) {
	  		case "i":
	  			return $this->time_array['time_minute'];
				break;
			default:
	  			return $this->time_array['time_minute'];				
		}
	}
	/**
	 * Gibt die Sekunde in der gewünschten Position des Ausgabe-Timeformats aus.
	 *
	 * @param char $format
	 * @return string
	 */
	private function second_replace($format) {
	  	switch ($format) {
	  		case "s":
	  			return $this->time_array['time_second'];
				break;
			default:
	  			return $this->time_array['time_second'];				
		}
	}
	
	/** 
	 * Setzt alle Daten wieder auf die Standardwerte
	 */
	public function __destruct() {
		$this->mysql_time_set = "Y-m-d H:i:s";
		$this->time_string = "";
		$this->time_format = "";
		$this->time_array = array();
	}
}
?>
