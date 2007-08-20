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
	private $smarty;
	private $mysqlhobj;
	private $auth;
	
	public function __construct($smarty, $mysql)
	{
		$this->smarty = $smarty;
		$this->mysql = $mysql;
		$this->auth = new Auth($this, $mysql);
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
		$smarty = $this->smarty;
		
		if(is_array($arrVar))
		{
			$smarty->assign($arrVar);
		} 
		elseif(is_string($content))
		{
			$smarty->assign($arrVar, $content);
		}
		
	}
	
	public function smarty_show($tplfile, $arrVar = null)
	{
		$smarty = $this->smarty;
		
		$this->smarty_assign($arrVar);
		
		$smarty->display("$tplfile.tpl");
	}
	
	public function __destruct()
	{
		$this->smarty = null;
		$this->mysql = null;
		$this->auth = null;
	}
	
	
}
?>