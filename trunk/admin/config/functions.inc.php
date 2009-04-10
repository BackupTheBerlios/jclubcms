<?php


/**
 * @author Simon Däster
 * @package JClubCMS
 * File: functions.inc.ph
 * 
 * Diese Datei beinhaltet Funktionen, die nicht einer Klasse zugeordnet werden können. Dies betriff meist
 * auf ueberladene magische Funktionen zu.
 *
 */

function __autoload($class_name)
{
	//Kleine Unschönheit: Wenn der Autoload in der obersten index.php aufgerufen wird, klappts nicht!!
	if (!defined(ADMIN_DIR)) {
	
		$len_dirfile = strlen(__FILE__);
		
		//Entweder wird nach Unix-Path-Style ('/') oder nach Windows-Path-Style ('\') gesucht
		if (($file = strrchr(__FILE__, '/')) == true) {
			$needle = '/';
		} else {
			$file = strrchr(__FILE__, '\\');
			$needle = '\\';
		}
		
		$len_file = strlen($file);
		
		//Gibt den directory-path zurueck
		$dir = substr(__FILE__, 0, $len_dirfile - $len_file);
		
		//Ordner gerade oberhalb der Datei
		$sub_dir = strrchr($dir, $needle);
		$len_sub = strlen($sub_dir);
		
		//Direcotry ohne Unterordner (der gerade oberhalb der Datei liegt)
		$dir = substr(__FILE__, 0, $len_dirfile - $len_file - $len_sub);
		
		//Nicht bereits im Adminordner
		if (strripos($dir, 'admin') === false) {
			$dir .= $needle.'admin';
		}
		
		$class_file = strtolower($class_name);
		include_once $dir.$needle.'lib'.$needle.$class_file.'.class.php';
		
	} else {
		$class_file = strtolower($class_name);
		include_once ADMIN_DIR.'lib'.$needle.$class_file.'.class.php';
	}
}



?>