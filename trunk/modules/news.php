<?php

	/**
	 * @package JClubCMS
	 * @author David D�ster
	 * Dieses Modul ist f�r die Anzeige der News verantwortlich und
	 * f�r die Naviagtion in den News,
	 *
	 * Sie ist _NICHT_ zust�ndig f�r das erstellen und ver�ndern der News,
	 * und auch nicht f�r Administration des G�stebuches
	 */
	require_once("./modules/pagesnav.class.php");
	
	//$smarty->debugging = true;
	$action = "";
	if (isset($_GET["action"]) && $_GET["action"] != "") {
		$action = $_GET["action"];	
	}

	switch ($action) {
		
	
		case "mail":
			require_once("./modules/mailsend.class.php");  //F�r das versenden vom senden des Mails
			require_once("./modules/formular_check.class.php"); //�berpr�fen der Formularfelder
			require_once("./config/mail_textes.inc.php"); //Standard-Texte f�r Mailformular und -fehler
			
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
					
					require_once("./modules/mailsend.class.php");	
					require_once("./config/mail_textes.inc.php");	
					
					
					$com_mysql->query("SELECT news_name, news_email FROM news WHERE news_ID = $entry_id");
					$mail_reciver = $com_mysql->fetcharray();
					$mail_reciver_name = $mail_reciver['news_name'];
					$mail_reciver_email = $mail_reciver['news_email'];					
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
				$com_mysql->query("SELECT news_name FROM news WHERE news_ID = $entry_id");
				$news_array = $com_mysql->fetcharray();
				$news_name = $news_array["news_name"];
				$smarty->assign("nav_id", $navigation_id);
				$smarty->assign("entry_id", $entry_id);
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

			$smarty->assign("local_link", $nav_id);
			$timeparser = new timeparser($time_format);
			$mysql->query("SELECT news_ID FROM news WHERE news_ref_ID = 0");
			$number = $mysql->num_rows();
			$pages_count = ceil($number/$news_entries_per_page);
			$news_page = 0;
			if (isset($_GET["page"])) {
				$news_page = $_GET["page"];
			}
			
			if ($news_page <= 0) {
				$news_page = 0;
			}
			
			$smarty->assign("test1", "GBook-Page $news_page");	
			$smarty->assign("entrys", $number);
			
			$start_entry = $news_page * $news_entries_per_page;
			$number_of_entry = $number - $start_entry;
			
			$mysql->query("SELECT * FROM `news` WHERE news_ref_ID = 0 ORDER BY `news_time` DESC LIMIT $start_entry, $news_entries_per_page");
			$news_array = array();
			$i = 0;
			while ($main_entries = $mysql->fetcharray()) {
				/**
				 * Hier kommt ein Kommentar
				 */
				$main_ID = $main_entries["news_ID"];
		  		$main_title = htmlentities($main_entries["news_title"]);
		  		$main_content = nl2br(htmlentities($main_entries["news_content"]));
		  		$main_name = htmlentities($main_entries["news_name"]);
		  		$main_hp = htmlentities($main_entries["news_hp"]);
		  		$main_time = $timeparser->time_output($comment_entries["news_time"]);
		  			
			  	$com_mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
				
				$com_mysql->query("SELECT * FROM `news` WHERE news_ref_ID = $main_ID ORDER BY `news_time` ASC");
			  	$comment_array = array();
			  	$j = 0;
			  	while ($comment_entries = $com_mysql->fetcharray()) {
			  		
			  		$comment_ID = $comment_entries["news_ID"];
			  		$comment_content = nl2br(htmlentities($comment_entries["news_content"]));
			  		$comment_name = htmlentities($comment_entries["news_name"]);
			  		$comment_hp = htmlentities($comment_entries["news_hp"]);
			  		$comment_time = $timeparser->time_output($comment_entries["news_time"]);
			  		
					$comment_array[$j] = array('comment_content'=>$comment_content, 'comment_name'=>$comment_name, 'comment_email'=>$comment_ID, 'comment_hp'=>$comment_hp, 'comment_time'=>$comment_time);
					$j++;   
				}
				
				/**
				* $news_array beinhaltet alle Daten der G�stebucheintr�ge und deren
				* Kommentare (comments=>$comment_array) der angezeigten Seite
				* 
				* Smarty liest nachher das Array mit Hilfe von {foreach} aus
				*/			  				  	
				$news_array[$i] = array('ID'=>$main_ID, 'title'=>$main_title, 'content'=>$main_content, 'name'=>$main_name, 'email'=>$main_ID, 'hp'=>$main_hp, 'time'=>$main_time, 'comments'=>$comment_array);
				$main_IDs[$i] = $main_ID;
				$i++;
				
				/**
				* Destrukt der angelegten Objekten
				*/ 				
				$com_mysql->disconnect();  
			}
			
			$pages_nav = new pagesnav($number, $news_entries_per_page);
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
			$smarty->assign("newsarray", $news_array);
			$smarty->assign("pages", $pages_array);
			$mod_tpl = "news.tpl";
		break;
	}	
	
?>