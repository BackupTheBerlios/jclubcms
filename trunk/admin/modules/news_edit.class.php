<?php 

/**
 * @author Simon Daester
 * @package JClubCMS
 * news_edit.class.php
 * 
 * Diese Klasse ist zustaendig fuer das Editieren der Newseintraege. Auch koennen neue Beitraege hinzugefuegt werden
 */

require_once(ADMIN_DIR.'lib/module.interface.php');

class news_edit implements Module
{
	private $tplfile = null;
	private $mysql = null;
	private $smarty = null;
	
	public function __construct($mysql, $smarty)
	{
		$this->mysql = $mysql;
		$this->smarty = $smarty;
	}
	
	public function readparameters($Getarray)
	{
		echo  "news ";
	}
	
	public function gettplfile()
	{
		return $this->tplfile;
	}
}

?>