<?php
/**
 * 
 * Dieses Inteface wird von jedem Modul impliziert!
 *
 * @author Simon Däster
 * @package JClubCMS
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License version 3
 */

interface Module
{
	//Nimmt die Objekte mysql und smarty auf
	public function __construct($mysql, $smarty);
	
	//Liest aus der Variable $parameters ($_GET, $_POST, $_COOKIE) die noetigen Daten aus und startet die zugehoerige Methode
	public function action($gpc);
	
	//Gibt das zur Klasse gehoerende Templatefile zurueck, welches dann im Haupt-Template (siehe index.php) eingebunden wird
	public function gettplfile();
}
?>
