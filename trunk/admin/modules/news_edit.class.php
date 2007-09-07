<?php 

/**
 * @author Simon Daester
 * @package JClubCMS
 * news_edit.class.php
 * 
 * Diese Klasse ist zustaendig fuer das Editieren der Newseintraege. Auch koennen neue Beitraege hinzugefuegt werden
 */

require_once(ADMIN_DIR.'lib/module.interface.php');


global $smarty;

class news_edit implements Module
{
	private $tplfile = null;
	private $mysql = null;
	//private $smarty = null;
	

	
	public function __construct($mysql, $smarty)
	{
		global $smarty;
		//$this->mysql = $mysql;
		$this->smarty = $smarty;
	}
	
	public function readparameters($Getarray)
	{
		echo  "news ";
		$this->smarty->assign("test", "hallo zusammen");
		$this->tplfile = 'news.tpl';
	}
	
	public function gettplfile()
	{
		return $this->tplfile;
	}
}

?>