<?php
/**
 *
 * Dieses Modul gibt die Mitglieder aus, welche im Mysql gespeichert sind.
 *
 * @package JClubCMS
 * @author Simon Däster
 * File: members.class.php
 * Classes: Members
 * @requieres PHP5
 */

require_once ADMIN_DIR.'lib/module.interface.php';

require_once ADMIN_DIR.'lib/captcha.class.php';

require_once ADMIN_DIR.'lib/mailsend.class.php';  //Für das versenden vom senden des Mails
require_once ADMIN_DIR.'lib/formularcheck.class.php'; //Überprüfen der Formularfelder
require_once USER_DIR.'config/mail_textes.inc.php'; //Standard-Texte für Mailformular und -fehler
require_once USER_DIR.'config/gbook_textes.inc.php';


class Members implements Module
{
	/**
	 * Smarty-Objekt
	 *
	 * @var Smarty
	 */
	private $_smarty;

	/**
	 * Mysql-Objekt
	 *
	 * @var Mysql
	 */
	private $_mysql;

	/**
	 * Template-Datei
	 *
	 * @var string
	 */
	private $_tpl_file;

	/**
	 * GET, POST, COOKIE-Daten
	 *
	 * @var array
	 */
	private $_gpc = array();

	/**
	 * Aufbau der Klasse
	 *
	 * @param Smarty $smarty
	 * @param Mysql $mysql
	 */
	public function __construct($mysql, $smarty)
	{
		$this->_smarty = $smarty;
		$this->_mysql = $mysql;
	}

	/**
	 * Start des Moduls
	 *
	 * @param array $gpc
	 */
	public function action($gpc)
	{
		$this->_gpc = $gpc;

		$this->_smarty->debugging = false;
		if (key_exists('action', $this->_gpc['GET'])) {
			switch ($this->_gpc['GET']['action']) {
				case 'mail':
					$this->_mail();
					break;
				default:
					$this->_view();
			}
		} else {
			$this->_view();
		}



	}


	public function gettplfile()
	{
		return $this->_tpl_file;
	}

	private function _view()
	{
		$this->_tpl_file = "members.tpl";
		$members = array();

		$this->_mysql->query('Select members_ID, members_name, members_spitzname, 
		DATE_FORMAT(`members_birthday`, \'%W, %e.%m.%Y\') as members_birthday, members_song, members_hobby, 
		members_job, members_motto, members_FIDimage FROM `members` 
		ORDER BY `members`.`members_birthday` ASC Limit 0,30');

		$this->_mysql->saverecords('assoc');
		$members = $this->_mysql->get_records();

		$this->_smarty->assign('members', $members);

	}

}







?>
