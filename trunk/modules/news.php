<?php

	/**
	 * @package JClubCMS
	 * @author David Däster
	* Dieses Modul ist für die Anzeige der News verantwortlich und
	* für die Naviagtion in den News,
	*
	* Sie ist _NICHT_ zuständig für das erstellen und verändern der News,
	* und auch nicht für Administration des Gästebuches
	*/
	require_once("./modules/mail.class.php");
	require_once("./modules/pagesnav.class.php");	
	
	//$smarty->debugging = true;
	

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
			  	$com_mysql = new mysql($db_server, $db_name, $db_user, $db_pw);
				
				$com_mysql->query("SELECT * FROM `news` WHERE news_ref_ID = $main_entries[news_ID] ORDER BY `news_time`ASC");
			  	$comment_array = array();
			  	$j = 0;
			  	while ($comment_entries = $com_mysql->fetcharray()) {
					$comment_array[$j] = array('comment_title'=>$comment_entries["comment_news_title"], 'comment_content'=>$comment_entries["news_content"], 'comment_name'=>$comment_entries["news_name"], 'comment_email'=>$comment_entries["news_email"], 'comment_hp'=>$comment_entries["news_hp"], 'comment_time'=>$timeparser->time_output($comment_entries["news_time"]));
					$j++;   
				}
				
				/**
				* $news_array beinhaltet alle Daten der Gästebucheinträge und deren
				* Kommentare (comments=>$comment_array) der angezeigten Seite
				* 
				* Smarty liest nachher das Array mit Hilfe von {foreach} aus
				*/			  	
				$news_array[$i] = array('ID'=>$main_entries["news_ID"], 'title'=>$main_entries["news_title"], 'content'=>$main_entries["news_content"], 'name'=>$main_entries["news_name"], 'email'=>$main_entries["news_email"], 'hp'=>$main_entries["news_hp"], 'time'=>$timeparser->time_output($main_entries["news_time"]), 'comments'=>$comment_array);
				$news_IDs[$i] = $main_entries["news_ID"];
				$i++;
				
				/**
				* Destrukt der angelegten Objekten
				*/ 				
				$com_mysql->__destruct();  
			}
			
			$pages_nav = new pagesnav($number, $news_entries_per_page);
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
			$smarty->assign("newsarray", $news_array);
			$smarty->assign("pages", $pages_array);
			$mod_tpl = "news.tpl";
	
?>