<div id="contentContainer">
	<div id="content">
		<table width = 100% class="content_tab">
		</table>
		<form method="post" action="?nav_id={$nav_id}&action=new">
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
			<td class="formailer_header" colspan="2"><img src="templates/style/icons/pencil.gif" /><input class="formailer_header_input" name="title" type="text" onclick="select()" value="{$entry_title}" /></td>
			</tr>
			<tr>
			<td class="formailer_txt">
			<textarea class="formailer_txt_textarea" onclick="select()" name="content" cols="38" rows="5">{$entry_content}</textarea></td>
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
