<?php

	/*
	* Dieses Modul ist für die Anzeige des Gästebuches verantwortlich,
	* für die Naviagtion im Gästebuch, und auch noch für das Erstellen
	* der Einträge.
	*
	* Sie ist _NICHT_ zuständig für die Administration des Gästebuches
	*
	*/
	
	
//$smarty->debugging = true;
	switch ($_GET["action"]) {
		case "new":
			$button_click = $_REQUEST["btn_send"];
			$title = $_REQUEST["title"];
			$content = $_REQUEST["content"];
			$name = $_REQUEST["name"];
			$email = $_REQUEST["email"];
			$hp = $_REQUEST["hp"];
			
			if($button_click == "Senden") {
				if ($title == "" || $title==$gbook_entry_title) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content= $gbook_title_onerror_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				elseif ($content == "" || $content == $gbook_entry_content) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content= $gbook_content_onerror_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				elseif ($name == "" || $name == $gbook_entry_name) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content= $gbook_name_onerror_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				elseif ($email == "" || $email == $gbook_entry_email) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content= $gbook_email_onerror_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				elseif ($hp == $gbook_entry_hp) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content= $gbook_hp_onerror_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				else {
					//EMail-Possible-Check
					//HP-Check
					//Sichern
					$mysql->query("INSERT INTO gbook (gbook_time, gbook_name, gbook_email, gbook_hp, gbook_title, gbook_content) VALUES (NOW(), '$name', '$email', '$hp', '$title', '$content')");
					$feedback_title= $gbook_allright_title;
					$feedback_content= "Dein Eintrag wurde gespeichert, und steht sofort im GB zur Verfügung";
					$feedback_link = "?nav_id=$nav_id";
					$feedback_linktext = $gbook_allright_link;
				}
				
				$smarty->assign("feedback_title", $feedback_title);
				$smarty->assign("feedback_content", $feedback_content);
				$smarty->assign("link", $feedback_link);
				$smarty->assign("link_text", $feedback_linktext);
				$mod_tpl = "feedback.tpl";
								
			}
			else {
				$smarty->assign("nav_id", $nav_id);
				$smarty->assign("entry_title", $gbook_entry_title);
				$smarty->assign("entry_content", $gbook_entry_content);
				$smarty->assign("entry_name", $gbook_entry_name);
				$smarty->assign("entry_email", $gbook_entry_email);
				$smarty->assign("entry_hp", $gbook_entry_hp);
				$mod_tpl = "gbook_new_entry.tpl";
			}
			break;
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
		/*
		Kurzer Ideenbeschrieb, ist im Moment eine Kopie von "new"
		Thema: Gästebuch
		Ziel: Kommentar anfügen
		
		Absicht: Den Gästebucheintrag nochmal anzeigen, und unten den Kommentar anfügen lassen.
		
		*/	
		case "comment":
			$timeparser = new timeparser($time_format);
			
			$button_click = $_REQUEST["btn_send"];
			$content = $_REQUEST["content"];
			$name = $_REQUEST["name"];
			$email = $_REQUEST["email"];
			$hp = $_REQUEST["hp"];
			$ref_ID = $_REQUEST["ref_ID"];
			
			if($button_click == "Senden") {
				
				
				if ($content == "" || $content == $gbook_entry_content) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content= $gbook_content_onerror_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				elseif ($name == "" || $name == $gbook_entry_name) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content= $gbook_name_onerror_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				elseif ($email == "" || $email == $gbook_entry_email) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content= $gbook_email_onerror_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				elseif ($hp == $gbook_entry_hp) {
					$feedback_title= $gbook_onerror_title_de;
					$feedback_content= $gbook_hp_onerror_de;
					$feedback_link = "JavaScript:history.back()";
					$feedback_linktext = "Zur&uuml;ck";
				}
				else {
					//EMail-Possible-Check
					//HP-Check
					//Sichern
					$mysql->query("INSERT INTO gbook (gbook_ref_ID, gbook_time, gbook_name, gbook_email, gbook_hp, gbook_title, gbook_content) VALUES ('$ref_ID', NOW(), '$name', '$email', '$hp', '$title', '$content')");
					$feedback_title= $gbook_allright_title;
					$feedback_content= "Dein Eintrag wurde gespeichert, und steht sofort im GB zur Verfügung";
					$feedback_link = "?nav_id=$nav_id";
					$feedback_linktext = $gbook_allright_link;
				}
				$smarty->assign("feedback_content", $feedback_content);
				$smarty->assign("link", $feedback_link);
				$smarty->assign("link_text", $feedback_linktext);
				$mod_tpl = "feedback.tpl";
								
			}
			else {
				/* Hier befindet man sich, wenn der Kommentieren-Link vom Gästebuch aufgerufen
				** wurde.
				** Hier wird der Gästebucheintrag ausgelesen, nochmal ausgegeben, entweder
				** unterhalb oder oberhalb des Formulars.
				**/
				
				/*
				---------------------------------------------------------------------
				-- Auslesen des vorhergehenden Posts --
				---------------------------------------------------------------------
				*/
				$mysql->query("SELECT * FROM `gbook` WHERE gbook_ID=$ref_ID");
				$gbook_array = array();
				$i = 0;
				while ($main_entries = $mysql->fetcharray()) {
/*----------------------------------------------------------------------
* Für die Kommentare wird ein eigenes Array gebraucht, welches unten
* abgefüllt wird.
* Dieses Array wird nachher in das $gbook_array=>comments gelegt, und
* nachher an Smarty weitergereicht.
*---------------------------------------------------------------------*/
				  	$com_mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
					
					$com_mysql->query("SELECT * FROM `gbook` WHERE gbook_ref_ID = $ref_ID ORDER BY `gbook_time`ASC");
				  	$comment_array = array();
				  	$j = 0;
				  	while ($comment_entries = $com_mysql->fetcharray()) {
						$comment_array[$j] = array('comment_title'=>$comment_entries["comment_gbook_title"], 'comment_content'=>$comment_entries["gbook_content"], 'comment_name'=>$comment_entries["gbook_name"], 'comment_email'=>$comment_entries["gbook_email"], 'comment_hp'=>$comment_entries["gbook_hp"], 'comment_time'=>$timeparser->time_output($comment_entries["gbook_time"]));
						$j++;   
					}

/*----------------------------------------------------------------------
* $gbook_array beinhaltet alle Daten der Gästebucheinträge und deren
* Kommentare (comments=>$comment_array) der angezeigten Seite
* 
* Smarty liest nachher das Array mit Hilfe von {foreach} aus
*---------------------------------------------------------------------*/			  	
					$gbook_array[$i] = array('ID'=>$main_entries["gbook_ID"], 'title'=>$main_entries["gbook_title"], 'content'=>$main_entries["gbook_content"], 'name'=>$main_entries["gbook_name"], 'email'=>$main_entries["gbook_email"], 'hp'=>$main_entries["gbook_hp"], 'time'=>$timeparser->time_output($main_entries["gbook_time"]), 'comments'=>$comment_array);
					$gbook_IDs[$i] = $main_entries["gbook_ID"];
					$i++;
				
//__destruct des hier angelegten Objekts.				
					$com_mysql->__destruct;	  
				}		
				$smarty->assign("gbook", $gbook_array);
				/*
				---------------------------------------------------------------------
				*/
				
				$smarty->assign("ref_ID", $ref_ID);
				$smarty->assign("nav_id", $nav_id);
				$smarty->assign("entry_title", $gbook_entry['title']);
				$smarty->assign("entry_content", $gbook_entry_content);
				$smarty->assign("entry_name", $gbook_entry_name);
				$smarty->assign("entry_email", $gbook_entry_email);
				$smarty->assign("entry_hp", $gbook_entry_hp);
				$mod_tpl = "gbook_new_comment.tpl";
			}
			break;
			
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
		default:
			$smarty->assign("local_link", $nav_id);
			$timeparser = new timeparser($time_format);
			$mysql->query("SELECT gbook_ID FROM gbook WHERE gbook_ref_ID = 0");
			$number = $mysql->num_rows();
			$pages_count = ceil($number/$gbook_entries_per_page);
			$gbook_page = $_GET["gbpage"];
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
/*----------------------------------------------------------------------
* Für die Kommentare wird ein eigenes Array gebraucht, welches unten
* abgefüllt wird.
* Dieses Array wird nachher in das $gbook_array=>comments gelegt, und
* nachher an Smarty weitergereicht.
*---------------------------------------------------------------------*/
			  	$com_mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
				
				$com_mysql->query("SELECT * FROM `gbook` WHERE gbook_ref_ID = $main_entries[gbook_ID] ORDER BY `gbook_time`ASC");
			  	$comment_array = array();
			  	$j = 0;
			  	while ($comment_entries = $com_mysql->fetcharray()) {
					$comment_array[$j] = array('comment_title'=>$comment_entries["comment_gbook_title"], 'comment_content'=>$comment_entries["gbook_content"], 'comment_name'=>$comment_entries["gbook_name"], 'comment_email'=>$comment_entries["gbook_email"], 'comment_hp'=>$comment_entries["gbook_hp"], 'comment_time'=>$timeparser->time_output($comment_entries["gbook_time"]));
					$j++;   
				}

/*----------------------------------------------------------------------
* $gbook_array beinhaltet alle Daten der Gästebucheinträge und deren
* Kommentare (comments=>$comment_array) der angezeigten Seite
* 
* Smarty liest nachher das Array mit Hilfe von {foreach} aus
*---------------------------------------------------------------------*/			  	
				$gbook_array[$i] = array('ID'=>$main_entries["gbook_ID"], 'title'=>$main_entries["gbook_title"], 'content'=>$main_entries["gbook_content"], 'name'=>$main_entries["gbook_name"], 'email'=>$main_entries["gbook_email"], 'hp'=>$main_entries["gbook_hp"], 'time'=>$timeparser->time_output($main_entries["gbook_time"]), 'comments'=>$comment_array);
				$gbook_IDs[$i] = $main_entries["gbook_ID"];
				$i++;
				
//__destruct des hier angelegten Objekts.				
				$com_mysql->__destruct;	  
			}
			$timeparser->__destruct();
			$microtime = microtime()-$microtime;
			$microtime=round($microtime, 3);
			$smarty->assign("generated_time", $microtime);			
			$smarty->assign("gbook", $gbook_array);
			$mod_tpl = "gbook.tpl";
	}
		
?>
