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


function debugecho($arrOline, $file=null, $function = null, $class = null, $msg = null)
{
	//echo "<pre>".print_r($arrOline,1)."</pre>";
	//Es kann auch ein Array mittels debug_backtrace() als Argumetn gegeben werden
	if(is_array($arrOline)) {
		$line = $arrOline[0];
		$file = $arrOline[0]['file'];
		$function = $arrOline[0]['function'];
		$class = $arrOline[0]['class'];

		if($msg == null) {
			$msg = print_r($arrOline[0]['args'],1);
		}
		
	} else {
		$line = $arrOline;
	}
	
	
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