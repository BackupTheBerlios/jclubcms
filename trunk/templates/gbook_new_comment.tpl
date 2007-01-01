<div id="contentContainer">
	<div id="content">
		<table width = 100% class="content_tab">
		</table>
		
		{foreach item=book  from=$gbook}
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
			<td class="content_tab_header" colspan="2">
			{$book.title}
			</td>
			</tr>
			<tr>
			<td class="content_tab_content1">
			{$book.content}
			</td>
			<td class="content_tab_content2">
			<img src="templates/style/icons/date.gif" /> {$book.time}<br />
			<img src="templates/style/icons/user.gif" /> {$book.name}<br />
			<a href="mailto:{$book.email}"><img src="templates/style/icons/email.gif" /> E-mail</a><br />
			<a href="{$book.hp}"><img src="templates/style/icons/link.gif" /> Website</a>
			</td>
			</tr>
			{* Innere Schlaufe für das Auslesen der Kommentare *}
			{foreach key=schluessel item=comment from=$book.comments}
			</tr>
			<tr>
			<td class="content_tab_content1">
			{$comment.comment_content}
			</td>
			<td class="content_tab_content2">
			<img src="templates/style/icons/date.gif" /> {$comment.comment_time}<br />
			<img src="templates/style/icons/user.gif" /> {$comment.comment_name}<br />
			<a href="mailto:{$comment.comment_email}"><img src="templates/style/icons/email.gif" /> E-mail</a><br />
			<a href="{$comment.comment_hp}"><img src="templates/style/icons/house.gif" /> Website</a>
			</td>
			</tr>
			{/foreach}
			<tr>
			<td colspan="2" class="content_tab_content1" align="center"><a href="?nav_id={$local_link}&action=comment&id={$book.ID}">Neuer Kommentar</a></td></tr>
		</table>
		{/foreach}
		
		<form method="post" action="?nav_id={$nav_id}&action=comment&ref_ID={$ref_ID}">
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
			<td class="formailer_header" colspan="2">{$entry_title}
			</td>
			</tr>
			<tr>
			<td class="formailer_txt">
			<textarea class="formailer_txt_textarea" name="content" onclick="select()" cols="38" rows="5">{$entry_content}</textarea></td>
			<td class="formailer_adress">
			<img src="templates/style/icons/user.gif" /> <input class="formailer_adress_input" onclick="select()" name="name" type="text" value="{$entry_name}" /><br />
			<img src="templates/style/icons/email.gif" /> <input class="formailer_adress_input" onclick="select()" name="email" type="text" value="{$entry_email}" /><br />
			<img src="templates/style/icons/house.gif" /> <input class="formailer_adress_input" onclick="select()" name="hp" type="text" value="{$entry_hp}" /></a>
			</td>
			</tr>
			<tr>
				<td class="formailer_options" colspan="2"><input type="submit" name="btn_send" value="Senden"><input name="Clear" type="reset" id="Clear" value="Zur&uuml;cksetzen"></td>
			</tr>
		</table>
	</div>
</div>
