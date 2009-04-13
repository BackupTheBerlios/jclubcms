<?php
/**
 * TODO File Description
 * 
 * Fehlender Filebeschrieb
 * 
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 * @package JClubCMS
 * @author Simon Däster
 *
 */

/**
 * TODO ClassDescription
 * 
 * Fehlender Klassenbeschrieb
 *
 * @author Simon Däster
 * @package JClubCMS
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
	/**
	 * TODO Documentation
	 */
	public function _exe_reserved_action($function)
	{
		$function = (string)($function);
		include_once(ADMIN_DIR."lib/action/action_$function.class.php");
	}
	
}
?>