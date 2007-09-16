<?php
/**
 * @author David D�ster und Simon D�ster
 * @package JClubCMS
 * Dieses Modul ist f�r die Anzeige des G�stebuches verantwortlich,
 * f�r die Naviagtion im G�stebuch, und auch noch f�r das Erstellen
 * der Eintr�ge.
 *
 * Sie ist _NICHT_ zust�ndig f�r die Administration des G�stebuches
 */

/**
 * TEST
 * Bei Fehlern gelangt man nicht mithilfe von JavaScript:history.back() zur�ck zum Eintragen, 
 * sondern �ber einen anderen Link.
 * Eingegebene Felder werden uebernommen.
 */
require_once(USER_DIR.'config/gbook_textes.inc.php');
require_once(USER_DIR.'config/mail_textes.inc.php');
require_once(ADMIN_DIR.'lib/pagesnav.class.php');
require_once(ADMIN_DIR.'lib/formular_check.class.php');
require_once(ADMIN_DIR.'lib/captcha.class.php');
require_once(ADMIN_DIR.'lib/smilies.class.php');
require_once(ADMIN_DIR.'lib/bbcodes.class.php');
/**
 * Es gibt 4 Actionen, die getrennt ausgef�hrt werden.
 * 1. New: Ein neuer Eintrag in das G�stebuch
 * 2. Comment: Einen Kommentar zu einem bestehenden Eintrag
 * 3. mail: Versenden von Mails an die Authoren
 * 4. default: Ansehen des G�stebuches.
 */

$action = "";
$content_title = "G&auml;stebuch";

if (isset($_GET["action"]) && $_GET["action"] != "") {
	$action = $_GET["action"];
}

if(isset($_REQUEST['sessionscode'])) {
	$sessionscode = $_REQUEST['sessionscode'];
} else {
	$sessionscode = md5(round(rand(0,40000)));
}

$captcha = new captcha($sessionscode, "./data/temp");
$smilies = new smilies($dir_smilies);
$bbcodes = new bbcodes("GB", new mysql($db_server, $db_name, $db_user, $db_pw));

$comments_mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
$smilies_mysql = new mysql($db_server, $db_name, $db_user, $db_pw);

switch ($action) {
	/**
         * Einen neuen Eintrag erstellen in das G�stebuch.
         */
	case "new":

		$content_title .= " - Neuer Eintrag";

		//blabla
		$button_click = !empty($_REQUEST["btn_send"]) ? $_REQUEST["btn_send"] : null;
		$title = !empty($_REQUEST["title"]) ? $_REQUEST["title"] : $gbook_entry_title;
		$content = !empty($_REQUEST["content"]) ? $_REQUEST["content"] : $gbook_entry_content;
		$name = !empty($_REQUEST["name"]) ? $_REQUEST["name"] : $gbook_entry_name;
		$email = !empty($_REQUEST["email"]) ? $_REQUEST["email"] : $gbook_entry_email;
		$hp = !empty($_REQUEST["hp"]) ? $_REQUEST["hp"] : $gbook_entry_hp;
		$navigation_id = $_REQUEST["nav_id"];
		$captcha_word = $_REQUEST["captcha_word"];


		if($button_click == "Senden") {

			/**
                         * Zwingende Angaben sind immer:
                         * - Einen Titel
                         * - Einen Text
                         * - Einen Namen
                         * - eine EMail-Adresse
                         */
			$formular_check = new formular_check();
			$failer_return = 0;
			$feedback_content = "";

			if ($formular_check->field_check($title, $gbook_entry_title) == false) {
				$feedback_content .= $gbook_title_onerror_de."<br />";
				$failer_return++;
			}

			if ($formular_check->field_check($content, $gbook_entry_content) == false) {
				$feedback_content .= $gbook_content_onerror_de."<br />";
				$failer_return++;
			}

			if ($formular_check->field_check($name, $gbook_entry_name) == false) {
				$feedback_content .= $gbook_name_onerror_de."<br />";
				$failer_return++;
			}

			if ($formular_check->field_check($email, $gbook_entry_email) == false) {
				$feedback_content .= $gbook_email_onerror_de."<br />";
				$failer_return++;
			}
			else {
				$mailerrorcode = $formular_check->mailcheck($email);
				if ($mailerrorcode > 0) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content.= $gbook_email_checkfaild_de."<br />";
					$failer_return++;
				}
			}

			if(!$captcha->verify($captcha_word)) {
				$feedback_content .= $gbook_captcha_onerror_de."<br />";
				$failer_return++;
			}


			if ($failer_return > 0) {
				$feedback_title= $gbook_onerror_title_de;
				$feedback_link = "?nav_id=$navigation_id&action=new";
				$feedback_linktext = "Zur&uuml;ck";

				$send_form = true;
			}
			else {
				/**
                                 * Wenn die angegebene HP nicht veraendert wurde, soll der Eintrag leer sein.
                                 */
				if ($hp == $gbook_entry_hp) {
					$hp = "";
				} else {
					$hp = $formular_check->hpcheck($hp);
				}

				$mysql->query("INSERT INTO gbook (gbook_time, gbook_name, gbook_email, gbook_hp, gbook_title, gbook_content) VALUES (NOW(), '$name', '$email', '$hp', '$title', '$content')");
				$feedback_title= $gbook_allright_title;
				$feedback_content= "Dein Eintrag wurde gespeichert, und steht sofort im GB zur Verf&uuml;gung";
				$feedback_link = "?nav_id=$navigation_id";
				$feedback_linktext = $gbook_allright_link;

				$send_form = false;
			}
			/**
                         * Smarty-Arbeit
                         */
			//Zum Weiterarbeiten
			$smarty->assign("SEND_FORMS", $send_form);
			if($send_form === true) {
				$smarty->assign("form_array", array('title' => $title, 'content' => $content, 'name' => $name, 'email' => $email, 'hp' => $hp));
			}
			$smarty->assign("title", $title);
			$smarty->assign("content", $content);
			$smarty->assign("name", $name);
			$smarty->assign("email", $email);
			$smarty->assign("hp", $hp);

			$smarty->assign("feedback_title", $feedback_title);
			$smarty->assign("feedback_content", $feedback_content);
			$smarty->assign("link", $feedback_link);
			$smarty->assign("link_text", $feedback_linktext);
			$mod_tpl = "feedback.tpl";

		}
		else {
			/* Auslesen der Navigations_Id f�r das Captcha-Modul*/
			$mysql->query("SELECT menu_ID FROM `menu`, modules WHERE modules.modules_ID = menu.menu_page
                        and modules.modules_name = 'captcha_image.php' and menu.menu_pagetyp = 'mod'");
			$captcha_id = $mysql->fetcharray("num");
			
			//Smilies-Liste generieren
			$smilies_list = $smilies->create_smiliesarray($mysql);

			/**
                         * Smarty-Arbeit
                         */  
			$smarty->assign("captcha_id", $captcha_id[0]);
			$smarty->assign("nav_id", $navigation_id);
			$smarty->assign("entry_title", $title);
			$smarty->assign("entry_content", $content);
			$smarty->assign("entry_name", $name);
			$smarty->assign("entry_email", $email);
			$smarty->assign("entry_hp", $hp);
			$smarty->assign("smilies_list", $smilies_list);
			$smarty->assign("captcha_img", $captcha->get_pic(4));
			$smarty->assign("sessionscode", $sessionscode);
			$mod_tpl = "gbook_new_entry.tpl";
		}
		break;
		
		
		/**
         * Erstellt einen Kommentar zu einem bestehenden Eintrag.
         * Als Referenz wird immer der Haupteintrag genommen, um so effizient zusammenh�ngende Beitr�ge zu suchen.
         * 
         * Weiter wird auch der zu kommentierende Beitrag mit allen Kommentare nochmal angezeigt,
         * um sich den Text besser zurecht zu legen.
         */
	case "comment":

		$content_title .= " - Neuer Kommentar";

		$timeparser = new timeparser($time_format);
		$local_link = $_REQUEST["nav_id"];

		$smarty->assign("local_link", $local_link);

		$button_click = !empty($_REQUEST["btn_send"]) ? $_REQUEST["btn_send"] : null;
		$title = !empty($_REQUEST["title"]) ? $_REQUEST["title"] : $gbook_entry_title;
		$content = !empty($_REQUEST["content"]) ? $_REQUEST["content"] : $gbook_entry_content;
		$name = !empty($_REQUEST["name"]) ? $_REQUEST["name"] : $gbook_entry_name;
		$email = !empty($_REQUEST["email"]) ? $_REQUEST["email"] : $gbook_entry_email;
		$hp = !empty($_REQUEST["hp"]) ? $_REQUEST["hp"] : $gbook_entry_hp;
		$ref_ID = $_REQUEST["ref_ID"];
		$navigation_id = $_REQUEST["nav_id"];
		$captcha_word = $_REQUEST["captcha_word"];


		if($button_click == "Senden") {

			/**
                         * Zwingende Angaben sind immer:
                         * - Einen Titel
                         * - Einen Text
                         * - Einen Namen
                         * - eine EMail-Adresse
                         * |- EMail-Validator pr�fen
                         */

			$formular_check = new formular_check();
			$failer_return = 0;
			$feedback_content = "";

			if ($formular_check->field_check($content, $gbook_entry_content) == false) {
				$feedback_content .= $gbook_content_onerror_de."<br />";
				$failer_return++;
			}

			if ($formular_check->field_check($name, $gbook_entry_name) == false) {
				$feedback_content .= $gbook_name_onerror_de."<br />";
				$failer_return++;
			}

			if ($formular_check->field_check($email, $gbook_entry_email) == false) {
				$feedback_content .= $gbook_email_onerror_de."<br />";
				$failer_return++;
			}
			else {
				$mailerrorcode = $formular_check->mailcheck($email);
				if ($mailerrorcode > 0) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content.= $gbook_email_checkfaild_de."<br />";
					$failer_return++;
				}
			}

			if(!$captcha->verify($captcha_word)) {
				$feedback_content .= $gbook_captcha_onerror_de."<br />";
				$failer_return++;
			}


			if ($failer_return > 0) {
				$feedback_title= $gbook_onerror_title_de;
				$feedback_link = "?nav_id=$navigation_id&action=comment&ref_ID=$ref_ID";
				$feedback_linktext = "Zur&uuml;ck";
				$send_form = true;
			}
			else {
				//EMail-Possible-Check
				//HP-Check
				//Sichern
				/**
                                 * Wenn die angegebene HP nicht ver�ndert wurde, soll der Eintrag leer sein.
                                 */
				if ($hp == $gbook_entry_hp) {
					$hp = "";
				} else {
					$hp = $formular_check->hpcheck($hp);
				}


				$mysql->query("INSERT INTO gbook (gbook_ref_ID, gbook_time, gbook_name, gbook_email, gbook_hp, gbook_title, gbook_content) VALUES ('$ref_ID', NOW(), '$name', '$email', '$hp', '$title', '$content')");
				$feedback_title= $gbook_allright_title;
				$feedback_content= "Dein Eintrag wurde gespeichert, und steht sofort im GB zur Verf&uuml;gung";
				$feedback_link = "?nav_id=$navigation_id";
				$feedback_linktext = $gbook_allright_link;
				$send_form = false;

			}

			//Zum Weiterarbeiten
			$smarty->assign("SEND_FORMS", $send_form);
			if($send_form === true) {
				$smarty->assign("form_array", array('title' => $title, 'content' => $content, 'name' => $name, 'email' => $email, 'hp' => $hp));
			}

			$smarty->assign("feedback_content", $feedback_content);
			$smarty->assign("link", $feedback_link);
			$smarty->assign("link_text", $feedback_linktext);
			$mod_tpl = "feedback.tpl";

		}
		else {
			/**
                         * Hier befindet man sich, wenn der Kommentieren-Link vom G�stebuch aufgerufen
                         * wurde.
                         * Hier wird der G�stebucheintrag ausgelesen, nochmal ausgegeben, entweder
                         * unterhalb oder oberhalb des Formulars.
                         */

			/* Auslesen der Navigations_Id f�r das Captcha-Modul*/
			$mysql->query("SELECT menu_ID FROM `menu`, modules WHERE modules.modules_ID = menu.menu_page
                        and modules.modules_name = 'captcha_image.php' and menu.menu_pagetyp = 'mod'");
			$captcha_id = $mysql->fetcharray("num");





			/*
			---------------------------------------------------------------------
			-- Auslesen des vorhergehenden Posts --
			---------------------------------------------------------------------
			*/
			$mysql->query("SELECT * FROM `gbook` WHERE gbook_ID=$ref_ID");
			$gbook_array = array();
			while ($main_entries = $mysql->fetcharray()) {

				/**
                                * F�r die Kommentare wird ein eigenes Array gebraucht, welches unten
                                * abgef�llt wird.
                                * Dieses Array wird nachher in das $gbook_array=>comments gelegt, und
                                * nachher an Smarty weitergereicht.
                            */
				//////$com_mysql = clone $mysql;

				$comments_mysql->query("SELECT * FROM `gbook` WHERE gbook_ref_ID = $ref_ID ORDER BY `gbook_time`ASC");
				$comment_array = array();
				$j = 0;
				while ($comment_entries = $comments_mysql->fetcharray("assoc")) {
					$comment_ID = $comment_entries["gbook_ID"];
					$comment_title = htmlentities($comment_entries["gbook_title"]);
					$comment_content = $smilies->show_smilie(nl2br(htmlentities($comment_entries["gbook_content"])), $smilies_mysql);
					$comment_content = $bbcodes->replace_bbcodes($comment_content);
					$comment_name = htmlentities($comment_entries["gbook_name"]);
					$comment_hp = htmlentities($comment_entries["gbook_hp"]);
					$comment_time = $timeparser->time_output($comment_entries["gbook_time"]);

					$comment_array[$j] = array('comment_ID'=>$comment_ID, 'comment_title'=>$comment_title, 'comment_content'=>$comment_content, 'comment_name'=>$comment_name, 'comment_email'=>$comment_ID, 'comment_hp'=>$comment_hp, 'comment_time'=>$comment_time);
					$j++;
				}

				/**
                                * $gbook_array beinhaltet alle Daten der G�stebucheintr�ge und deren
                                * Kommentare (comments=>$comment_array) der angezeigten Seite
                                * 
                                * Smarty liest nachher das Array mit Hilfe von {foreach} aus
                                */			  	
				$main_ID = $main_entries["gbook_ID"];
				$main_title = htmlentities($main_entries["gbook_title"]);
				$main_content = $smilies->show_smilie(nl2br(htmlentities($main_entries["gbook_content"])), $smilies_mysql);
				$main_name = htmlentities($main_entries["gbook_name"]);
				$main_hp = htmlentities($main_entries["gbook_hp"]);
				$main_time = $timeparser->time_output($main_entries["gbook_time"]);

				$gbook_array = array('ID'=>$main_ID, 'title'=>$main_title, 'content'=>$main_content, 'name'=>$main_name, 'email'=>$main_ID, 'hp'=>$main_hp, 'time'=>$main_time, 'comments'=>$comment_array);
				$gbook_IDs = $main_ID;
				$i++;

				/**
                                 * Destrukt der angelegten Objekten
                                 */
				$comments_mysql->disconnect();
			}
			
			//Smilies-Liste generieren
			$smilies_list = $smilies->create_smiliesarray($mysql);

			/**
                         * Smarty-Arbeit
                         */
			$smarty->assign("gbook", $gbook_array);
			$smarty->assign("captcha_id", $captcha_id[0]);
			$smarty->assign("ref_ID", $ref_ID);
			$smarty->assign("nav_id", $navigation_id);
			$smarty->assign("entry_title", $gbook_array['title']);
			$smarty->assign("entry_content", $content);
			$smarty->assign("entry_name", $name);
			$smarty->assign("entry_email", $email);
			$smarty->assign("entry_hp", $hp);
			$smarty->assign("smilies_list", $smilies_list);
			$smarty->assign("sessionscode", $sessionscode);
			$smarty->assign("captcha_img", $captcha->get_pic(4));
			$mod_tpl = "gbook_new_comment.tpl";
		}
		break;
		/**
         * Ist die Mail-Funktion speziell f�r das G�stebuch.
         * @uses mail_send.class.php
         */
	case "mail":

		$content_title .= "- Mail";

		$button_click = !empty($_REQUEST["btn_send"]) ? $_REQUEST["btn_send"] : null;
		$title = !empty($_REQUEST["title"]) ? $_REQUEST["title"] : $mail_entry_title;
		$content = !empty($_REQUEST["content"]) ? $_REQUEST["content"] : $mail_entry_content;
		$sender_name = !empty($_REQUEST["name"]) ? $_REQUEST["name"] : $mail_entry_name;
		$sender_email = !empty($_REQUEST["email"]) ? $_REQUEST["email"] : $mail_entry_email;
		$entry_id = $_REQUEST["entry_id"];
		$navigation_id = $_REQUEST["nav_id"];
		$captcha_word = $_REQUEST['captcha_word'];



		//$com_mysql = clone $mysql;


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

			if ($formular_check->field_check($sender_name, $mail_entry_name) == false) {
				$feedback_content .= $gbook_name_onerror_de."<br />";
				$failer_return++;
			}

			if ($formular_check->field_check($sender_email, $mail_entry_email) == false) {
				$feedback_content .= $gbook_email_onerror_de."<br />";
				$failer_return++;
			}
			else {
				$mailerrorcode = $formular_check->mailcheck($sender_email);
				if ($mailerrorcode > 0) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content.= $gbook_email_checkfaild_de."<br />";
					$failer_return++;
				}
			}

			if(!$captcha->verify($captcha_word)) {
				$feedback_content .= $gbook_captcha_onerror_de."<br />";
				$failer_return++;
			}

			if ($failer_return > 0) {
				$feedback_title= $gbook_onerror_title_de;
				$feedback_link = "?nav_id=$navigation_id&action=mail&entry_id=$entry_id";
				$feedback_linktext = "Zur&uuml;ck";

				$send_form = true;
			}
			else {

				require_once(ADMIN_DIR.'lib/mailsend.class.php');


				$comments_mysql->query("SELECT gbook_name, gbook_email FROM gbook WHERE gbook_ID = $entry_id");
				$mail_reciver = $comments_mysql->fetcharray();
				$mail_reciver_name = $mail_reciver["gbook_name"];
				$mail_reciver_email = $mail_reciver["gbook_email"];
				$mail = new mailsend();
				$mailsend_controll = $mail->mail_send_link($comments_mysql, $mail_reciver_name, $mail_reciver_email, $sender_name, $sender_email, $title, $content);
				if ($mailsend_controll == true) {
					$feedback_title = $mail_saved_title;
					$feedback_content = $mail_saved_content;
					$feedback_link = "?nav_id=$navigation_id";
					$feedback_linktext = $gbook_allright_link;
					$send_form = false;
				}
				else {
					$feedback_title = $mail_failer_title;
					$feedback_content = $mail_failer_content;
					$feedback_link = "?nav_id=$navigation_id";
					$feedback_linktext = $gbook_allright_link;
					$send_form = false;
				}
				//$mail->__destruct();
			}


			$smarty->assign("SEND_FORMS", $send_form);
			if($send_form) {
				$smarty->assign("form_array", array('title' => $title, 'content' => $content, 'name' => $sender_name, 'email' => $sender_email));
			}

			$smarty->assign("feedback_title", $feedback_title);
			$smarty->assign("feedback_content", $feedback_content);
			$smarty->assign("link", $feedback_link);
			$smarty->assign("link_text", $feedback_linktext);
			$mod_tpl = "feedback.tpl";
		}
		else {
			/* Auslesen der Navigations_Id f�r das Captcha-Modul*/
			$mysql->query("SELECT menu_ID FROM `menu`, modules WHERE modules.modules_ID = menu.menu_page
                        and modules.modules_name = 'captcha_image.php' and menu.menu_pagetyp = 'mod'");
			$captcha_id = $mysql->fetcharray("num");

			$comments_mysql->query("SELECT gbook_name FROM gbook WHERE gbook_ID = $entry_id");
			$gbook_array = $comments_mysql->fetcharray();
			$gbook_name = $gbook_array["gbook_name"];

			$smarty->assign("nav_id", $navigation_id);
			$smarty->assign("captcha_id", $captcha_id[0]);
			$smarty->assign("entry_id", $entry_id);
			$smarty->assign("reciver_name", $gbook_name);
			$smarty->assign("entry_title", $title);
			$smarty->assign("entry_content", $content);
			$smarty->assign("entry_name", $sender_name);
			$smarty->assign("entry_email", $sender_email);
			$smarty->assign("sessionscode", $sessionscode);
			$smarty->assign("captcha_img", $captcha->get_pic(4));
			$mod_tpl = "mail_form.tpl";
		}

		$comments_mysql->disconnect();
		break;
		/**
         * Liest alle Beitr�ge aus dem G�stebuch aus.
         * Zuerst werden nur die Haupteintr�ge ausgelesen, und nachher Rekursiv die
         * dazugeh�rigen Kommentare.
         * 
         * Abgef�llt werden die Daten alle in ein Array, welches an Smarty weitergegeben
         * wird, und die Daten nachher ausgibt.
         */
	default:
		$local_link = $_REQUEST["nav_id"];

		$smarty->assign("local_link", $local_link);
		$timeparser = new timeparser($time_format);
		$mysql->query("SELECT gbook_ID FROM gbook WHERE gbook_ref_ID = 0");
		$number = $mysql->num_rows();
		$pages_count = ceil($number/$gbook_entries_per_page);
		$gbook_page = 0;
		if (isset($_GET["page"])) {
			$gbook_page = $_GET["page"];
		}

		if ($gbook_page <= 0) {
			$gbook_page = 0;
		}

		$smarty->assign("test1", "GBook-Page $gbook_page");
		$smarty->assign("entrys", $number);

		$start_entry = $gbook_page * $gbook_entries_per_page;
		$number_of_entry = $number - $start_entry;

		$mysql->query("SELECT * FROM `gbook` WHERE gbook_ref_ID = 0 ORDER BY `gbook_time` DESC LIMIT $start_entry, $gbook_entries_per_page");
		$gbook_array = array();
		$i = 0;
		while ($main_entries = $mysql->fetcharray()) {
			/**
                         * Hier kommt ein Kommentar
                         */
			//$com_mysql = clone $mysql;

			$comments_mysql->query("SELECT * FROM `gbook` WHERE gbook_ref_ID = $main_entries[gbook_ID] ORDER BY `gbook_time`ASC");
			$comment_array = array();
			$j = 0;
			while ($comment_entries = $comments_mysql->fetcharray()) {
							
				$comment_ID = $comment_entries["gbook_ID"];
				$comment_title = htmlentities($comment_entries["gbook_title"]);
				$comment_content = $bbcodes->replace_bbcodes($comment_entries["gbook_content"]);
				$comment_content = $smilies->show_smilie(nl2br(htmlentities($comment_content)), $smilies_mysql);
				$comment_name = htmlentities($comment_entries["gbook_name"]);
				$comment_hp = htmlentities($comment_entries["gbook_hp"]);
				$comment_time = $timeparser->time_output($comment_entries["gbook_time"]);

				$comment_array[$j] = array('comment_ID'=>$comment_ID, 'comment_title'=>$comment_title, 'comment_content'=>$comment_content, 'comment_name'=>$comment_name, 'comment_email'=>$comment_ID, 'comment_hp'=>$comment_hp, 'comment_time'=>$comment_time);
				$j++;
			}

			/**
                        * $gbook_array beinhaltet alle Daten der G�stebucheintr�ge und deren
                        * Kommentare (comments=>$comment_array) der angezeigten Seite
                        * 
                        * Smarty liest nachher das Array mit Hilfe von {foreach} aus
                        */

			$main_ID = $main_entries["gbook_ID"];
			$main_title = htmlentities($main_entries["gbook_title"]);
			//$main_content = $smilies->show_smilie(nl2br(htmlentities($main_entries["gbook_content"])), $comments_mysql);
			//$main_content = $bbcodes->replace_bbcodes($main_content);
			$main_content = $bbcodes->replace_bbcodes($main_entries["gbook_content"]);
			$main_content = $smilies->show_smilie(nl2br(htmlentities($main_content)), $comments_mysql);
			$main_name = htmlentities($main_entries["gbook_name"]);
			$main_hp = htmlentities($main_entries["gbook_hp"]);
			$main_time = $timeparser->time_output($main_entries["gbook_time"]);
			$comments_count = $j;
			
			$gbook_array[$i] = array('ID'=>$main_ID, 'title'=>$main_title, 'content'=>$main_content, 'name'=>$main_name, 'email'=>$main_ID, 'hp'=>$main_hp, 'time'=>$main_time, 'number_of_comments'=>$comments_count, 'comments'=>$comment_array);
			$gbook_IDs[$i] = $main_ID;
			$i++;

			/**
                        * Destrukt der angelegten Objekten
                        */ 				
			//$comments_mysql->disconnect();
		}

		$pages_nav = new pagesnav($number, $gbook_entries_per_page);
		$pages_array = $pages_nav->build_array();
		$pages_nav->__destruct();

				/**
                 * Array der Seiten, wobei der Text immer eines h�her ist als der Link.
                 * Page 0 = Seite 1; Page 1 = Seite 2;
        		 */

		$timeparser->__destruct();
		$microtime = microtime()-$microtime;
		$microtime=round($microtime, 3);

		/**
                 * Smarty-Arbeit
                 */
		$smarty->assign("generated_time", $microtime);
		$smarty->assign("gbook", $gbook_array);
		$smarty->assign("pages", $pages_array);
		$mod_tpl = "gbook.tpl";
}
$smarty->assign("content_title", $content_title);

?>
