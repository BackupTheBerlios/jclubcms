<?php
/**Konstanten definieren**/
define("ADMIN_DIR", "./admin/");
define("USER_DIR", "./");

require_once USER_DIR.'config/user-config.inc.php';

require_once ADMIN_DIR.'lib/core.class.php';
Core::singleton();
?>