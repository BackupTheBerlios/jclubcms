<?php
/**
 * @author Simon Däster
 * @package JClubCMS
 * File: module.interface.php
 * interace: Modules
 * 
 * Dieses Inteface wird von jedem Modul impliziert!
 *
 */

interface  Module
{
	//Liest aus der Variable $_GET['mode'] den Modus aus und führt die zugehörige Methode aus
	public function readparameters($GETmode);	
	
	//Gibt das zur Klasse gehörende Templatefile zurück, welches dann im Haupt-Template (siehe index.php) eingebunden wird
	public function gettplfile();
}
?>