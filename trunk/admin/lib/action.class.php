<?php
/**
 * @package JClubCMS
 * @author Simon Däster
 * File: action.class.php
 * Classes: Action
 * Requieres: PHP5
 *
 */

class Action
{
	/**
	 * Core-Objekt
	 *
	 * @var Core
	 */
	private $_core = null;
	
	/**
	 * Smarty-Objekt
	 *
	 * @var Smarty
	 */
	private $_smarty = null;
	
	/**
	 * Mysql-Objekt
	 *
	 * @var Mysql
	 */
	private $_mysql = null;
	
	/**
	 * Reservierte Aktionen
	 *
	 * @var array
	 */
	private static $_reserved_action = array('logout' => 'admin', 'mail' => 'user');
	
	/**
	 * Initilalisieren der Funktion
	 *
	 * @param Smarty $smarty
	 * @param Mysql $mysql
	 * @param Core $core
	 */
	public function __construct($smarty, $mysql, $core = null)
	{
		$this->_smarty = $smarty;
		$this->_mysql = $mysql;
		$this->_core = $core;
	}
	
	/**
	 * Zurückgeben des Array mit den reservierten Aktionen
	 *
	 * @return array $_reserved_action
	 */
	public static function get_reserved_action()
	{
		return self::$_reserved_action;
	}
	
	public function _exe_reserved_action($function)
	{
		include_once(ADMIN_DIR."lib/action/action_$function.class.php");
	}
	
	
	public function _exe_reserved_mail()
	{
		$mail = new Mailclient($this->_smarty, $this->_mysql);
		echo "\nAufruf der Mailclient-Klasse<br />\n";
	}
}
?>