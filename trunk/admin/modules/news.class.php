<?php 

/**
 * @author Simon Daester
 * @package JClubCMS
 * news_edit.class.php
 * 
 * Diese Klasse ist zustaendig fuer das Editieren der Newseintraege. Auch koennen neue Beitraege hinzugefuegt werden
 */

require_once(ADMIN_DIR.'lib/module.interface.php');

class news implements Module
{
	private $tplfile = null;
	private $mysql = null;
	private $smarty = null;
	private $post_arr = array();
	private $get_arr = array();

	
	public function __construct($mysql, $smarty)
	{
		$this->mysql = $mysql;
		$this->smarty = $smarty;
	}
	
	public function action($parameters)
	{
		$this->post_arr = $parameters['_POST'];
		$this->get_arr = $parameters['_GET'];
		
		switch($this->get['mode'])
		{
			case 'new':
				$this->add();
				break;
			case 'edit':
				$this->edit();
				break;
			case 'del':
				$this->del();
				break;
			case 'view':
				$this->view();
				break;
			case '':
				$this->view();
				break;
			default:
				$this->error(__LINE__, 1);
		}
	}
	
	public function gettplfile()
	{
		return $this->tplfile;
	}
	
	private function view()
	{
		$this->tplfile = 'news.tpl';
		$news_array = array();
		$this->mysql->query('SELECT * FROM `news` ORDER BY `news_time` DESC LIMIT 30');
		$news_array = $this->mysql->get_records();
		$this->smarty->assign($smarty_array); //!!depressed!!
		
		
	}
	
	private function add()
	{
		;
	}
	
	private function edit()
	{
		;
	}
	
	private function del()
	{
		;
	}
	
	private function error($line, $errorcode)
	{
		$this->tplfile = 'news-error.tpl';
		$errortext = "";
		$errortitle = "";
		
		switch($errorcode)
		{
			case 1:
				$errortitle = "Falsche URL-Parameter";
				$errortext = "Sie haben falsche URL-Parameter weitergegeben. Daher konnte keine entsprechende Aktion ausgef&uuml;fr werden<br />\nInfo: Fehler auf Zeile $line";
				break;
			default:
				$errortitle = "allgemeiner Fehler";
				$errortext = "Sie haben irgendwie ein Fehler verursacht, ich weiss aber auch nicht wie. W&auml;re nett, wenn sie mir das erkl&auml;en k&ouml;nnten.<br />\nInfo: Fehler auf Zeile $line";
		}
		
		$this->smarty->assign(array('title' => $errortitle, 'error' => $errortext));
		
	}
	
}

?>