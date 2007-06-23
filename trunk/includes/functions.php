<?php
/**
 * @author Simon Däster
 * @package JClubCMS
 * Diese Datei speichert bestimmte Funktionen ab. Diese Funktionen sind 
 * standalone-Funktionen, die an keine Klasse oder Modul gebunden sind.
 * 
 */
 
 
 function replace_smilies($text)
 {
 	$smilies_arr = arra();
	$mysql->query("Select * from smilies");
	
	$smilies_arr = $mysql->fetcharray("assoc");
	
 
 }

?>