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
	
	//Liest aus der Variable $_GET['mode'] den Modus aus und f�hrt die zugeh�rige Methode aus
	public function readparameters($Getarray);	
	
	//Gibt das zur Klasse geh�rende Templatefile zur�ck, welches dann im Haupt-Template (siehe index.php) eingebunden wird
	public function gettplfile();
}
?>