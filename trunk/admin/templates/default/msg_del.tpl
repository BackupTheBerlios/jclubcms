      <div id="content">
		<div id="content_txt">
		<table width = 100% class="content_tab">
		</table>
		<form name="del" method="post" action="">
			<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
				<tr>
				<td class="formailer_header" colspan="2">{$title}
				</td>
				</tr>
				<tr>
					<td class="formailer_options" colspan="2">
					
						<fieldset><legend>Nachricht</legend>
						<br />
						{$content}
						</fieldset>
						Wollen Sie die <b>Nachricht</b> mit der ID {$del_ID} mit allen <b>Kommentaren(!) wirklich löschen</b>?<br />
						Die Löschung ist UNWIDERRUFLICH!<br />
					</td>
				<tr>
					<td class="formailer_options">               
						 <input type="submit" name="weiter" value="{$linktext}" />
					</td>
					<td class="formailer_options">               
						  <input type="submit" name="nein" value="{$linktext2}" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>