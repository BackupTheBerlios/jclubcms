<?php
/**
 * @package JClubCMS
 */
//Config laden
require_once('./config/config.inc.php');

//notwendige Module laden
require_once('./modules/mysql.class.php');
require_once('./modules/timeparser.class.php');
require_once('./Smarty/Smarty.class.php');

require_once('./includes/functions.php');

//Smarty-Objekt
$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;

//Mysql-Objekt
$mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
?>
