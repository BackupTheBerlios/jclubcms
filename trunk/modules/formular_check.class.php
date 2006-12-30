<?php
/** 
 * @author David Däster
 * @package JClubCMS
 * File: formular_check.class.php
 * Classes: formularcheck
 * Requieres: PHP5
 */

class formular_check {
	public function __construct () {
		return 0;
	}
	public function field_check ($field, $not_allowed = NULL) {
		if ($field == "" || $field==$not_allowed) {
			return false;
		}
		else {
			return true;
		}
	}
	public function __destruct() {
		
	}
}
?>