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
	$action = "";
	if (isset($_GET["action"]) && $_GET["action"] != "") {
		$action = $_GET["action"];	
	}

	switch ($action) {
		
	
		case "mail":
			require_once("./modules/mailsend.class.php");  //Für das versenden vom senden des Mails
			require_once("./modules/formular_check.class.php"); //Überprüfen der Formularfelder
			require_once("./config/mail_textes.inc.php"); //Standard-Texte für Mailformular und -fehler
			
			$button_click = $_REQUEST["btn_send"];
			$title = $_REQUEST["title"];
			$content = $_REQUEST["content"];
			$name = $_REQUEST["name"];
			$email = $_REQUEST["email"];
			$entry_id = $_REQUEST["entry_id"];
			$navigation_id = $_REQUEST["nav_id"];
			
			$com_mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
			
			if($button_click == "Senden") {
				$formular_check = new formular_check();
				$failer_return = 0;
				$feedback_content = "";
				
				if ($formular_check->field_check($title, $mail_entry_title) == false) {
					$feedback_content .= $gbook_title_onerror_de."<br />";
					$failer_return++;
				} 
				
				if ($formular_check->field_check($content, $mail_entry_content) == false) {
					$feedback_content .= $gbook_content_onerror_de."<br />";
					$failer_return++;
				}
				
				if ($formular_check->field_check($name, $mail_entry_name) == false) {
					$feedback_content .= $gbook_name_onerror_de."<br />";
					$failer_return++;
				}
				
				if ($formular_check->field_check($email, $mail_entry_email) == false) {
					$feedback_content .= $gbook_email_onerror_de."<br />";
					$failer_return++;
				}
				else {
					$mailcheck = new mailverify($email);
					$mailerrorcode = $mailcheck->mailcheck();
					if ($mailerrorcode > 0) {
						$feedback_title= $gbook_onerror_title_de;
						$feedback_content.= $gbook_email_checkfaild_de."<br />";	
						$failer_return++;				
					}
				}
				
				if ($failer_return > 0) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				else {
					
					require_once("./modules/mailsend.class.php");	
					require_once("./config/mail_textes.inc.php");	
					
					
					$com_mysql->query("SELECT members_name, members_email FROM members WHERE members_ID = $entry_id");
					$mail_reciver = $com_mysql->fetcharray();
					$mail_reciver_name = $mail_reciver['members_name'];
					$mail_reciver_email = $mail_reciver['members_email'];					
					$mail = new mailsend();
					$mailsend_controll = $mail->mail_send_link($com_mysql, $mail_reciver_name, $mail_reciver_email, $name, $email, $title, $content);
					if ($mailsend_controll == true) {
						$feedback_title = $mail_saved_title;
						$feedback_content = $mail_saved_content;
						$feedback_link = "?nav_id=$navigation_id";
						$feedback_linktext = $news_mail_link;
					}
					else {
						$feedback_title = $mail_failer_title;
						$feedback_content = $mail_failer_content;
						$feedback_link = "?nav_id=$navigation_id";
						$feedback_linktext = $news_mail_link;
					}
					$mail->__destruct();
				}
				$smarty->assign("feedback_title", $feedback_title);
				$smarty->assign("feedback_content", $feedback_content);
				$smarty->assign("link", $feedback_link);
				$smarty->assign("link_text", $feedback_linktext);
				$mod_tpl = "feedback.tpl";
			}
			else {
				$com_mysql->query("SELECT members_name FROM members WHERE members_ID = $entry_id");
				$news_array = $com_mysql->fetcharray();
				$news_name = $news_array["members_name"];
				$smarty->assign("nav_id", $navigation_id);
				$smarty->assign("entry_id", $news_id);
				$smarty->assign("reciver_name", $news_name);
				$smarty->assign("entry_title", $mail_entry_title);
				$smarty->assign("entry_content", $mail_entry_content);
				$smarty->assign("entry_name", $mail_entry_name);
				$smarty->assign("entry_email", $mail_entry_email);
				$mod_tpl = "mail_form.tpl";
			}
			
			$com_mysql->disconnect();
		break;
		
		default:
			$members_array = array();
			$local_link = $_REQUEST["nav_id"];
						
			$mysql->query('Select members_ID, members_name,members_spitzname,DATE_FORMAT(`members_birthday`, \'%W, %e.%m.%Y\') as members_birthday,members_song,members_hobby,"
						 ." members_job,members_motto,members_FIDimage from members ORDER BY `members`.`members_birthday` ASC Limit 0,30');
			
			$i = 0;
			while($members_data = $mysql->fetcharray("assoc"))
			{
				$members_ID[$i] = $members_data['members_ID'];
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
			$smarty->assign("local_link", $local_link);
			$smarty->assign("ID", $members_ID);
			$smarty->assign("name", $members_name);
			$smarty->assign("spitzname", $members_spitzname);
			$smarty->assign("birthday", $members_birthday);
			$smarty->assign("song", $members_song);
			$smarty->assign("job", $members_job);
			$smarty->assign("motto", $members_motto);
			$smarty->assign("IDimage", $members_IDimage);
			
			$mod_tpl = "members.tpl";
		break;
	}
?>