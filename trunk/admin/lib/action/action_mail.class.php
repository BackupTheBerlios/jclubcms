<?php
/**
 * @package JClubCMS
 * @author Simon Däster
 * File: mail.class.php
 * Classes: Mail
 * Requieres: PHP5
 *
 * Dieses Modul ist für das Mailforumular zum Versenden des Bestätigungsmail verantwortlich sowie 
 * für das Versenden des angegebenen Mails nach der erfolgreichen Bestätigung.
 *
 */

require_once ADMIN_DIR.'lib/module.interface.php';

class Mailclient implements Module
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
	 * Templatefile
	 *
	 * @var string
	 */
	private $_tplfile = 'mailform.tpl';

	
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
	public function __construct($smarty, $mysql)
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
		if (key_exists('hash', $gpc['GET']) && is_string($gpc['GET']['hash'])) {
			$this->_truemail_send($gpc['GET']['hash']);
		} elseif (key_exists('id', $gpc['GET']) && is_numeric($gpc['GET']['id'])) {
			$this->_checkmail_send($gpc['GET']['id']);
		} else {
			throw new CMSException('Die Parameternangaben sind ungültig. Bitte geben Sie richtige Parameter an oder lassen Sie es', EXCEPTION_MODULE_CODE);
		}
				
	}

	/**
	 * Rückgabe derm Templatedatei
	 *
	 * @return string Templatedatei
	 */
	public function gettplfile()
	{
		return $this->_tplfile;
	}
	
	private function _checkmail_send($mod_navID)
	{
		$this->_smarty->config_load('textes.de.conf', 'Mail');
		$mail_vars = $this->_smarty->get_config_vars();
		$this->_smarty->config_load('textes.de.conf', 'Form_Error');
		$error_vars = $this->_smarty->get_config_vars();

		$sessioncode = null;

		//Captcha zurücksetzen
		if (key_exists('captcha_revoke', $this->_gpc['POST'])) {
			$new_code = true;
		} else {
			$new_code = false;
		}
		
	}
	
	private function _truemail_send($hash)
	{
		;
	}

	
}





?>
