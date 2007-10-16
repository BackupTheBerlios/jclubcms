<?php


/**
 * @author Simon Daester
 * @package JClubCMS
 * File: functions.inc.ph
 * 
 * Diese Datei beinhaltet Funktionen, die nicht einer Klasse zugeordnet werden können. Dies betriff meist
 * auf ueberladene magische Funktionen
 *
 */


function __autoload($class_name)
{

	//Funktioniert nur, wenn im ADMIN-Modus!!!! -> Aendern
	if (!defined(ADMIN_DIR)) {
		debug_print_backtrace();
		echo "ADMIN_DIR nicht definiert!<br />\n";
		
		$len_dirfile = strlen(__FILE__);
		
		if ($file = strrchr(__FILE__, '/')) {
			$needle = '/';
		} else {
			$file = strrchr(__FILE__, '\\');
			$needle = '\\';
		}
		$len_file = strlen($file);
		$dir = substr(__FILE__, 0, $len_dirfile - $len_file);
		$sub_dir = strrchr($dir, $needle);
		$len_sub = strlen($sub_dir);
		$dir = substr(__FILE__, 0, $$len_dirfile - $len_file - $len_sub);
		echo $dir;
		
		
		$class_file = strtolower($class_name);
		require_once("$dir/lib/$class_file.class.php");
	} else {
		$class_file = strtolower($class_name);
		require_once(ADMIN_DIR."lib/$class_file.php");
	}
}


/**
 * Gibt eine Ausgabe aus mit den Angaben der Datei, Zeile, Funktion (wenn vorhanden), Klasse (wenn vorhanden) und einer 
 * Nachricht (wenn vorhanden). Auch kann die Ausgabe in ein String umgeleitet werden, wenn gewünscht,
 *
 * @param array|string $arrOline
 * @param string $file0msg
 * @param string|boolean $function0ndisp
 * @param string $class
 * @param string $msg
 * @param boolean $notdisplay
 */

function debugecho($arrOline, $file0msg=null, $function0return = null, $class = null, $msg = null, $return = false)
{
	//echo "<pre>".print_r($arrOline,1)."</pre>";
	//Es kann auch ein Array mittels debug_backtrace() als Argumetn gegeben werden
	if (is_array($arrOline)) {
		$line = $arrOline[0]['line'];
		$file = $arrOline[0]['file'];
		$function = $arrOline[0]['function'];
		$class = $arrOline[0]['class'];
		$msg = $file0msg;
		$return = $function0return;
		
	} else {
		$line = $arrOline;
		$file = $file0msg;
		$fucntion = $function0return;
	}
	
	$str = "There was an test in $file on line $line. ";
	if ($class) {
		$str .= "Class $class; ";
	}
	
	if ($function0return) {
		$str .= "Function $function0return; ";
	}
	
	if ($msg) {
		$str .= "Message: $msg ";
	}
	$str .= "<br />\n";
	
	if ($return == true) {
		return $str;
	} else {
		echo $str;
	}
	
}


?>