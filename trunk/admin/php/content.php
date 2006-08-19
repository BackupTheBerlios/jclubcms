<?php
	function showContent($doParam) {
		if ((isset($_POST['del'])) && (isset($_POST['contentID']))) {
			delContentItem($_POST['contentID']);
		} elseif ($doParam == 'new') {
			addContentItemForm();
		}  elseif (isset($_POST['add'])) {
			addContentItem();
		} elseif ((isset($_POST['edit'])) && (isset($_POST['contentID']))) {
			chdir('../');
			editContentItemForm($_POST['contentID']);
		} elseif ((isset($_POST['update'])) && (isset($_POST['myID']))) {
			updateContentItem();
		} else {
			listContentActions();
		}
	}
	
	function addContentItem() {
		if (($_POST['contentTitle'] != '') &&($_POST['contentText'] != '')) {
			mysql_query("
				INSERT
				INTO mib_content
					(content_title, content_text) 
				VALUES ('"
					.parse($_POST['contentTitle'])."', '"
					.parse($_POST['contentText'])
			."')") or die(mysql_error());
		} else {
			echo '<strong>Fehler: Seite oder Titel leer!</strong><br /><br />';
		}
		listContentActions();
	}
	
	function updateContentItem() {
		if (($_POST['contentTitle'] != '') && ($_POST['contentText'] != '')) {
			mysql_query("UPDATE mib_content
							SET  
								content_title='".parse($_POST['contentTitle'])."',
								content_text='".parse($_POST['contentText'])."'
							WHERE  
								content_ID='".$_POST['myID']."'") or die(mysql_error());
		} else {
			echo '<strong>Fehler: Seite oder Titel leer!</strong><br /><br />';
		}
		listContentActions();
	}
	
	function delContentItem($id) {
		mysql_query("DELETE FROM mib_content
						WHERE content_ID=".$id) or die(mysql_error());
		listContentActions();
	}
	
	function addContentItemForm() {
		include('tiny.php');
		echo '
			<br />
			<form name="addContent" method="post" action="?" enctype="multipart/form-data">';
		// Seiten Titel	
		echo 'Seiten Titel<br /><input name="contentTitle" type="text" size="30" maxlength="40" value="Titel" />';
		// Seiten Text
		echo '<br /><br />Seiten Text:<br />
			  <textarea name="contentText" cols="60" rows="25">Hier kommt der Text hin.</textarea>';
		echo '<br /><br /><input type="submit" name="add" value="Speichern" /></form>';
		echo '<br /><br /><a href="php/imageindex.php" target="_blank">vorhandene Bilder</a>';
	}
	
	function editContentItemForm($id) {
		$itemRes = mysql_query("SELECT * FROM mib_content WHERE content_ID = ".$id);
		$itemData = mysql_fetch_array($itemRes);
		include('tiny.php');
		echo '
			<br />
			<form name="addContent" method="post" action="?" enctype="multipart/form-data">';
		// Seiten Titel	
		echo 'Seiten Titel<br /><input name="contentTitle" type="text" size="30" maxlength="40" value="'.reparse($itemData['content_title']).'" />';
		// Seiten Text
		echo '<br /><br />Seiten Text:<br />
			  <textarea name="contentText" cols="60" rows="25">'.reparse($itemData['content_text']).'</textarea>';
		echo '<br /><br /><input type="submit" name="update" value="Speichern" />';
		echo '<input type="hidden" name="myID" value="'.$itemData['content_ID'].'" /></form>';
		echo '<br /><br /><a href="php/imageindex.php" target="_blank">vorhandene Bilder</a>';
	}
	
	function listAllPages() {
		$res = mysql_query("SELECT content_title, content_ID FROM mib_content ORDER BY content_title ASC");
		echo '<form name="pagesList" method="post" action="?" enctype="multipart/form-data">
				<select name="contentID" size="15">';
			if (mysql_num_rows($res) > 0) {
				while ($data = mysql_fetch_array($res)) {
					echo '<option value="'.$data['content_ID'].'">'.reparse($data['content_title']).'</option>';
				}
			}		
		echo '</select><br /><br />
				<input type="submit" name="edit" value="Editieren" />&nbsp;
			  	<input type="submit" name="del" value="L&ouml;schen" /></form>';
	}
	
	function listContentActions() {
		echo '
			<a href="?do=new">
				<div class="menuItem">Neue Seite</div>
			</a><br />
			Editierbare Nachrichten:<br /><br />';
		listAllPages();		
	}
	
?>
