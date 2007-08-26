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
	
	public function __construct()
	{
		;
	}
	
	public function readparameters($Getarray)
	{
		;
	}
	
	public function gettplfile()
	{
		return $this->tplfile;
	}
}

?>