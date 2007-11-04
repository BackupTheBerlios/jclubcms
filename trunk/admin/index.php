<?php
/**Konstanten definieren**/
define("ADMIN_DIR", "./");
define("USER_DIR", "../");

require_once ADMIN_DIR.'config/admin-config.inc.php';

require_once ADMIN_DIR.'lib/core.class.php';
new Core();
?>