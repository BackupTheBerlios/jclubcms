<?php
/**
 * @package JClubCMS
 * @author Simon Däster
 * File: members.php
 * Classes: none
 * Requieres: PHP5
 *
 *
 * Dieses Modul gibt die Mitglieder aus, welche im Mysql gespeichert sind.
 *
 * Sie ist _NICHT_ zuständig für die Administration der Mitgliedereinträge
 */

require_once("./modules/pagesnav.class.php");
$members_array = array();

$mysql->query('Select members_name,members_spitzname,DATE_FORMAT(`members_birthday`, \'%W, %e.%m.%Y\') as members_birthday,members_song,members_hobby,"
			 ." members_job,members_motto,members_FIDimage from members ORDER BY `members`.`members_birthday` ASC Limit 0,30');

$i = 0;
while($members_data = $mysql->fetcharray("assoc"))
{
	$members_name[$i] = $members_data['members_name'];
	$members_spitzname[$i] = $members_data['members_spitzname'];
	$members_birthday[$i] = $members_data['members_birthday'];
	$members_song[$i] = $members_data['members_song'];
	$members_hobby[$i] = $members_data['members_hobby'];
	$members_job[$i] = $members_data['members_job'];
	$members_motto[$i] = $members_data['members_motto'];
	$members_IDimage[$i] = $members_data['members_FIDimage'];
	
	$i++;
}


$smarty->assign("name", $members_name);
$smarty->assign("spitzname", $members_spitzname);
$smarty->assign("birthday", $members_birthday);
$smarty->assign("song", $members_song);
$smarty->assign("job", $members_job);
$smarty->assign("motto", $members_motto);
$smarty->assign("IDimage", $members_IDimage);

$mod_tpl = "members.tpl";
?>