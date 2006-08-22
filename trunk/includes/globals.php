<?php
//Config laden
require_once('./config/config.inc.php');

//notwendige Module laden
require('./modules/mysql.class.php');
require('./modules/timeparser.class.php');
require('./Smarty/Smarty.class.php');

//Smarty-Objekt
$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;

//Mysql-Objekt
$mysql = new mysql($db_server, $db_name, $db_user, $db_pw);

?>