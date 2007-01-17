<?php
	/**
	 * @author David Däster
	 * @package JClubCMS
	 * Dieses Modul ist für die Anzeige des Gästebuches verantwortlich,
	 * für die Naviagtion im Gästebuch, und auch noch für das Erstellen
	 * der Einträge.
	 *
	 * Sie ist _NICHT_ zuständig für die Administration des Gästebuches
	 */
	require_once("./config/gbook_textes.inc.php");
	require_once("./modules/pagesnav.class.php");
	require_once("./modules/formular_check.class.php");	
	
	//$smarty->debugging = true;
	
	/**
	 * Es gibt 4 Actionen, die getrennt ausgeführt werden.
	 * 1. New: Ein neuer Eintrag in das Gästebuch
	 * 2. Comment: Einen Kommentar zu einem bestehenden Eintrag
	 * 3. mail: Versenden von Mails an die Authoren
	 * 4. default: Ansehen des Gästebuches.
	 */
	$action = "";
	if (isset($_GET["action"]) && $_GET["action"] != "") {
		$action = $_GET["action"];	
	}

	switch ($action) {
		/**
		 * Einen neuen Eintrag erstellen in das Gästebuch.
		 */
		case "new":
			$button_click = $_REQUEST["btn_send"];
			$title = $_REQUEST["title"];
			$content = $_REQUEST["content"];
			$name = $_REQUEST["name"];
			$email = $_REQUEST["email"];
			$hp = $_REQUEST["hp"];
			$navigation_id = $_REQUEST["nav_id"];
			
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
				
				
				if ($failer_return > 0) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				else {
					/**
					 * Wenn die angegebene HP nicht verändert wurde, soll der Eintrag leer sein.
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
				}
				/**
				 * Smarty-Arbeit
				 */
				$smarty->assign("feedback_title", $feedback_title);
				$smarty->assign("feedback_content", $feedback_content);
				$smarty->assign("link", $feedback_link);
				$smarty->assign("link_text", $feedback_linktext);
				$mod_tpl = "feedback.tpl";
								
			}
			else {
				/**
				 * Smarty-Arbeit
				 */
				$smarty->assign("nav_id", $navigation_id);
				$smarty->assign("entry_title", $gbook_entry_title);
				$smarty->assign("entry_content", $gbook_entry_content);
				$smarty->assign("entry_name", $gbook_entry_name);
				$smarty->assign("entry_email", $gbook_entry_email);
				$smarty->assign("entry_hp", $gbook_entry_hp);
				$mod_tpl = "gbook_new_entry.tpl";
			} 
			break;
		/**
		 * Erstellt einen Kommentar zu einem bestehenden Eintrag.
		 * Als Referenz wird immer der Haupteintrag genommen, um so effizient zusammenhängende Beiträge zu suchen.
		 * 
		 * Weiter wird auch der zu kommentierende Beitrag mit allen Kommentären nochmal angezeigt,
		 * um sich den Text besser zurecht zu legen.
		 */
		case "comment":
			$timeparser = new timeparser($time_format);
			$local_link = $_REQUEST["nav_id"];
			
			$smarty->assign("local_link", $local_link);
			
			$button_click = $_REQUEST["btn_send"];
			$content = $_REQUEST["content"];
			$name = $_REQUEST["name"];
			$email = $_REQUEST["email"];
			$hp = $_REQUEST["hp"];
			$ref_ID = $_REQUEST["ref_ID"];
			$navigation_id = $_REQUEST["nav_id"];
			if($button_click == "Senden") {
				
				/**
				 * Zwingende Angaben sind immer:
				 * - Einen Titel
				 * - Einen Text
				 * - Einen Namen
				 * - eine EMail-Adresse
				 * |- EMail-Validator prüfen
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
				
				if ($failer_return > 0) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				else {
					//EMail-Possible-Check
					//HP-Check
					//Sichern
					/**
					 * Wenn die angegebene HP nicht verändert wurde, soll der Eintrag leer sein.
					 */
					if ($hp == $gbook_entry_hp) {
					$hp = "";
					}

					
					$mysql->query("INSERT INTO gbook (gbook_ref_ID, gbook_time, gbook_name, gbook_email, gbook_hp, gbook_title, gbook_content) VALUES ('$ref_ID', NOW(), '$name', '$email', '$hp', '$title', '$content')");
					$feedback_title= $gbook_allright_title;
					$feedback_content= "Dein Eintrag wurde gespeichert, und steht sofort im GB zur Verf&uuml;gung";
					$feedback_link = "?nav_id=$navigation_id";
					$feedback_linktext = $gbook_allright_link;
					
				}
				$smarty->assign("feedback_content", $feedback_content);
				$smarty->assign("link", $feedback_link);
				$smarty->assign("link_text", $feedback_linktext);
				$mod_tpl = "feedback.tpl";
								
			}
			else {
				/**
				 * Hier befindet man sich, wenn der Kommentieren-Link vom Gästebuch aufgerufen
				 * wurde.
				 * Hier wird der Gästebucheintrag ausgelesen, nochmal ausgegeben, entweder
				 * unterhalb oder oberhalb des Formulars.
				 */
				
				/*
				---------------------------------------------------------------------
				-- Auslesen des vorhergehenden Posts --
				---------------------------------------------------------------------
				*/
				$mysql->query("SELECT * FROM `gbook` WHERE gbook_ID=$ref_ID");
				$gbook_array = array();
				$i = 0;
				while ($main_entries = $mysql->fetcharray()) {
					
					/**
					* Für die Kommentare wird ein eigenes Array gebraucht, welches unten
					* abgefüllt wird.
					* Dieses Array wird nachher in das $gbook_array=>comments gelegt, und
					* nachher an Smarty weitergereicht.
				    */
				  	$com_mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
					
					$com_mysql->query("SELECT * FROM `gbook` WHERE gbook_ref_ID = $ref_ID ORDER BY `gbook_time`ASC");
				  	$comment_array = array();
				  	$j = 0;
				  	while ($comment_entries = $com_mysql->fetcharray()) {
						$comment_ID = $comment_entries["gbook_ID"];
						$comment_title = htmlentities($comment_entries["gbook_title"]);
						$comment_content = nl2br(htmlentities($comment_entries["gbook_content"]));
						$comment_name = htmlentities($comment_entries["gbook_name"]);
						$comment_hp = htmlentities($comment_entries["gbook_hp"]);
						$comment_time = $timeparser->time_output($comment_entries["gbook_time"]);
						
						$comment_array[$j] = array('comment_ID'=>$comment_ID, 'comment_title'=>$comment_title, 'comment_content'=>$comment_content, 'comment_name'=>$comment_name, 'comment_email'=>$comment_ID, 'comment_hp'=>$comment_hp, 'comment_time'=>$comment_time);
					$j++;   
					}
					
					/**
					* $gbook_array beinhaltet alle Daten der Gästebucheinträge und deren
					* Kommentare (comments=>$comment_array) der angezeigten Seite
					* 
					* Smarty liest nachher das Array mit Hilfe von {foreach} aus
					*/			  	
				$main_ID = $main_entries["gbook_ID"];
				$main_title = htmlentities($main_entries["gbook_title"]);
				$main_content = nl2br(htmlentities($main_entries["gbook_content"]));
				$main_name = htmlentities($main_entries["gbook_name"]);
				$main_hp = htmlentities($main_entries["gbook_hp"]);
				$main_time = $timeparser->time_output($main_entries["gbook_time"]);
				
				$gbook_array[$i] = array('ID'=>$main_ID, 'title'=>$main_title, 'content'=>$main_content, 'name'=>$main_name, 'email'=>$main_ID, 'hp'=>$main_hp, 'time'=>$main_time, 'comments'=>$comment_array);
				$gbook_IDs[$i] = $main_ID;
				$i++;
				
					/**
					 * Destrukt der angelegten Objekten
					 */
					$com_mysql->disconnect();	  
				}		
				$smarty->assign("gbook", $gbook_array);
				/**
				 * Smarty-Arbeit
				 */
				
				$smarty->assign("ref_ID", $ref_ID);
				$smarty->assign("nav_id", $navigation_id);
				$smarty->assign("entry_title", $gbook_entry['title']);
				$smarty->assign("entry_content", $gbook_entry_content);
				$smarty->assign("entry_name", $gbook_entry_name);
				$smarty->assign("entry_email", $gbook_entry_email);
				$smarty->assign("entry_hp", $gbook_entry_hp);
				$mod_tpl = "gbook_new_comment.tpl";
			}
			break;
		/**
		 * Ist die Mail-Funktion speziell für das Gästebuch.
		 * @uses mail_send.class.php
		 */
		case "mail":
			$button_click = $_REQUEST["btn_send"];
			$title = $_REQUEST["title"];
			$content = $_REQUEST["content"];
			$sender_name = $_REQUEST["name"];
			$sender_email = $_REQUEST["email"];
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
				
				if ($failer_return > 0) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				else {
					
					require_once("./modules/mailsend.class.php");	
					
					
					$com_mysql->query("SELECT gbook_name, gbook_email FROM gbook WHERE gbook_ID = $entry_id");
					$mail_reciver = $com_mysql->fetcharray();
					$mail_reciver_name = $mail_reciver["gbook_name"];
					$mail_reciver_email = $mail_reciver["gbook_email"];					
					$mail = new mailsend();
					$mailsend_controll = $mail->mail_send_link($com_mysql, $mail_reciver_name, $mail_reciver_email, $sender_name, $sender_email, $title, $content);
					if ($mailsend_controll == true) {
						$feedback_title = $mail_saved_title;
						$feedback_content = $mail_saved_content;
						$feedback_link = "?nav_id=$navigation_id";
						$feedback_linktext = $gbook_allright_link;
					}
					else {
						$feedback_title = $mail_failer_title;
						$feedback_content = $mail_failer_content;
						$feedback_link = "?nav_id=$navigation_id";
						$feedback_linktext = $gbook_allright_link;
					}
					//$mail->__destruct();
				}
				$smarty->assign("feedback_title", $feedback_title);
				$smarty->assign("feedback_content", $feedback_content);
				$smarty->assign("link", $feedback_link);
				$smarty->assign("link_text", $feedback_linktext);
				$mod_tpl = "feedback.tpl";
			}
			else {
				$com_mysql->query("SELECT gbook_name FROM gbook WHERE gbook_ID = $entry_id");
				$gbook_array = $com_mysql->fetcharray();
				$gbook_name = $gbook_array["gbook_name"];
				$smarty->assign("nav_id", $navigation_id);
				$smarty->assign("entry_id", $entry_id);
				$smarty->assign("reciver_name", $gbook_name);
				$smarty->assign("entry_title", $gbook_entry_title);
				$smarty->assign("entry_content", $gbook_entry_content);
				$smarty->assign("entry_name", $gbook_entry_name);
				$smarty->assign("entry_email", $gbook_entry_email);
				$mod_tpl = "mail_form.tpl";
			}
			
			$com_mysql->disconnect();
		break;
		/**
		 * Liest alle Beiträge aus dem Gästebuch aus.
		 * Zuerst werden nur die Haupteinträge ausgelesen, und nachher Rekursiv die
		 * dazugehörigen Kommentare.
		 * 
		 * Abgefüllt werden die Daten alle in ein Array, welches an Smarty weitergegeben
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
			  	$com_mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
				
				$com_mysql->query("SELECT * FROM `gbook` WHERE gbook_ref_ID = $main_entries[gbook_ID] ORDER BY `gbook_time`ASC");
			  	$comment_array = array();
			  	$j = 0;
			  	while ($comment_entries = $com_mysql->fetcharray()) {

					$comment_ID = $comment_entries["gbook_ID"];
					$comment_title = htmlentities($comment_entries["gbook_title"]);
					$comment_content = nl2br(htmlentities($comment_entries["gbook_content"]));
					$comment_name = htmlentities($comment_entries["gbook_name"]);
					$comment_hp = htmlentities($comment_entries["gbook_hp"]);
					$comment_time = $timeparser->time_output($comment_entries["gbook_time"]);
					
					$comment_array[$j] = array('comment_ID'=>$comment_ID, 'comment_title'=>$comment_title, 'comment_content'=>$comment_content, 'comment_name'=>$comment_name, 'comment_email'=>$comment_ID, 'comment_hp'=>$comment_hp, 'comment_time'=>$comment_time);
					$j++;   
				}
				
				/**
				* $gbook_array beinhaltet alle Daten der Gästebucheinträge und deren
				* Kommentare (comments=>$comment_array) der angezeigten Seite
				* 
				* Smarty liest nachher das Array mit Hilfe von {foreach} aus
				*/
				
				$main_ID = $main_entries["gbook_ID"];
				$main_title = htmlentities($main_entries["gbook_title"]);
				$main_content = nl2br(htmlentities($main_entries["gbook_content"]));
				$main_name = htmlentities($main_entries["gbook_name"]);
				$main_hp = htmlentities($main_entries["gbook_hp"]);
				$main_time = $timeparser->time_output($main_entries["gbook_time"]);
				
				$gbook_array[$i] = array('ID'=>$main_ID, 'title'=>$main_title, 'content'=>$main_content, 'name'=>$main_name, 'email'=>$main_ID, 'hp'=>$main_hp, 'time'=>$main_time, 'comments'=>$comment_array);
				$gbook_IDs[$i] = $main_ID;
				$i++;
				
				/**
				* Destrukt der angelegten Objekten
				*/ 				
				$com_mysql->disconnect();  
			}
			
			$pages_nav = new pagesnav($number, $gbook_entries_per_page);
			$pages_array = $pages_nav->build_array();
			$pages_nav->__destruct();
			
			/**
			 * Array der Seiten, wobei der Text immer eines höher ist als der Link.
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
?>
