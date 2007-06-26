<?php
/**
 * @author Simon Däster
 * @package JClubCMS
 * Diese Datei speichert bestimmte Funktionen ab. Diese Funktionen sind 
 * standalone-Funktionen, die an keine Klasse oder Modul gebunden sind.
 * 
 */
require_once("./config/config.inc.php");
require_once("./modules/mysql.class.php"); 

 
 function replace_smilies($text, $mysql_link)
 {
 	//$link = mysql_connect("localhost", "jclubbeta", "jclubbeta");
 	//mysql_select_db("jclubbeta");
 	global $dir_smilies;
 	
 	$mysql_link->query("SELECT smilies_sign, smilies_file FROM `smilies`");
		
 	
 	$smilies_signs = array();
 	$smilies_files = array();
 	$smilies_arr = array();
 	
 	$i = 0;
 	
	//$result = mysql_query("SELECT smilies_sign, smilies_file FROM `smilies`");	
	while($smilies_arr = $mysql_link->fetcharray("assoc"))
	{
		$smilies_signs[$i] = $smilies_arr['smilies_sign'];
		$smilies_files[$i] = "<img src=\"$dir_smilies".$smilies_arr['smilies_file']."\" />";
		
		$i++;
	}
	
	
	
	/*echo "Print_r:<br />\n";
	print_r($smilies_files);
	echo "<br />\n";
	print_r($smilies_signs);
	
	echo "<br />\n";*/
	
	$return_text = str_replace($smilies_signs, $smilies_files, $text);
	return $return_text;

 
 }

?>