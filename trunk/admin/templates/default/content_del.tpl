      <div id="content">
		<div id="content_txt">
		{config_load file='textes.de.conf' section='Content'}
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
					
						<fieldset><legend>{#message#}</legend>
						<br />
						{$text|replace:"src=\"?image":"src=\"?image&amp;$SID"}
						</fieldset>
						ID = {$del_ID} - {#del_really}<br />
						{#del_not_undo#}<br />
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