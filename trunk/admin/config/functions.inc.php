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
	if(!defined(ADMIN_DIR))
	{
		echo "ADMIN_DIR nicht definiert!<br />\n";
	}
	require_once(ADMIN_DIR."lib/$class_name.php");
}

function debugecho($line, $file, $function = null, $class = null, $msg = null)
{
	echo "There was an test in $file on line $line. ";
	if($class)
	{
		echo "Class $class; ";
	}
	
	if($function)
	{
		echo "Function $function; ";
	}
	
	if($msg)
	{
		echo "Message: $msg ";
	}
	echo "<br />\n";
}
?>