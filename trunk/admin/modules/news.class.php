<?php 

/**
 * @author Simon Daester
 * @package JClubCMS
 * news_edit.class.php
 * 
 * Diese Klasse ist zustaendig fuer das Editieren der Newseintraege. Auch koennen neue Beitraege hinzugefuegt werden
 */

require_once(ADMIN_DIR.'lib/module.interface.php');
require_once ADMIN_DIR.'lib/messageboxes.class.php';

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
		$this->post_arr = $parameters['POST'];
		$this->get_arr = $parameters['GET'];
		if(isset($this->get_arr['action']))
		{
			switch($this->get_arr['action'])
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
					$this->view(15);
					break;
				case '':
					$this->view(15);
					break;
				case 'tesst':
					$this->msboxtest();
				default:
					$this->error(__LINE__, 1);
			}
		} 
		else 
		{
			$this->view(15);
		}
	}

	public function gettplfile()
	{
		return $this->tplfile;
	}
	
	private function msboxtest()
	{
		$msbox = new MessageBoxes($this->mysql, 'news', array('ID' => 'news_ID', 'ref_ID' => 'news_ref_ID', 'content' => 'news_content'));
		debugecho(debug_backtrace(),"Fehler da?: ".var_export($msbox->isError(),1));
		
		debugecho(debug_backtrace(),"Fehler bei Tabelle:<br />\n".var_export($msbox->getError(),1));	
	}

	private function view($max_entries_pp)
	{
		$this->tplfile = 'news.tpl';
		$news_array = array();
		$this->mysql->query('SELECT *, DATE_FORMAT(`news_time`, \'%e.%m.%Y %k:%i\') AS `news_time` FROM `news` ORDER BY `news_time` DESC LIMIT '.$max_entries_pp);

		$data_array = $this->mysql->get_records();
		$this->mysql->query('SELECT COUNT(*) FROM `news` WHERE `news_ref_ID` = \'0\'');
		
		//Kommentaere nicht beachtet und ganzer code uebermittelt
		$this->smarty->assign('newsarray', $data_array);
		
		

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