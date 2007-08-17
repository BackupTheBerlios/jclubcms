<?php

/**
 * @author Simon Däster
 * @package JClubCMS
 * File: page.class.php
 * class: Page
 * requires: auth.class.php, Smarty.class.php
 * 
 * Diese Klasse ist für die Darstellung der Seite verantworlich. Sie allein kommuniziert mit Smarty.
 *
 */

class Page
{
	private $smartyobj;
	private $mysqlhobj;
	private $authobj;
	
	public function __construct($smartyobj, $mysqlobj)
	{
		$this->smartyobj = $smartyobj;
		$this->mysqlobj = $mysqlobj;
		$authoj = new Auth($this, $mysqlobj);
	}
	
	public function show_menu()
	{
		;
	}
	
	/**
	 * Diese Funktion speichert die Variablen im Smarty.
	 * Der erste Parameter kann ein String sein (Variablenname im Template) 
	 * oder ein Array mit 'Variable' => Inhalt. Entspricht der erste 
	 * Parameter dem Variablenname, so ist der 2. Parameter der Inhalt
	 * @param array|string
	 * @param string
	**/
	
	public function smarty_assign($arrVar, $content = null)
	{
		$smartyobj = $this->smartyobj;
		
		if(is_array($arrVar))
		{
			$smartyobj->assign($arrVar);
		} 
		elseif(is_string($content))
		{
			$smartyobj->assign($arrVar, $content);
		}
		
	}
	
	public function smarty_show($tplfile, $arrVar = null)
	{
		$smartyobj = $this->smartyobj;
		
		$this->smarty_assign($arrVar);
		
		$smartyobj->display("$tplfile.tpl");
	}
	
	public function __destruct()
	{
		$this->smartyobj = null;
		$this->mysqlobj = null;
		$this->authobj = null;
	}
	
	
}
?>