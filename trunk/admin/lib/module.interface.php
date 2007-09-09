<?php
/**
 * @author Simon D�ster
 * @package JClubCMS
 * File: module.interface.php
 * interace: Modules
 * 
 * Dieses Inteface wird von jedem Modul impliziert!
 *
 */

interface Module
{
	//Nimmt die Objekte mysql und smarty auf
	public function __construct($mysql, $smarty);
	
	//Liest aus der Variable $parameters ($_GET und $_POST) die noetigen Daten aus und startet die zugehoerige Methode
	public function action($parameters);
	
	//Gibt das zur Klasse gehoerende Templatefile zurueck, welches dann im Haupt-Template (siehe index.php) eingebunden wird
	public function gettplfile();
}
?>