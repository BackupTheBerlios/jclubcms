      <div id="content">
		<div id="content_txt">
		<table width = 100% class="content_tab">
		</table>
		{*Fehlerausgabe wenn noetig*}
		{if $dump_errors}
		<table class="content_tab" align="center">
			<tr>
				<td class="formailer_header" style="background-color: #EC6442">{$error_title|default:"Einige Daten sind ungueltig"}</td>
			</tr>
			<tr>
				<td class="formailer_txt" style="background-color: #ED4B23">{$error_content}</td>
			</tr>
		</table>
		{/if}
		Mail an {$reciver_name}:
		<form method="post" action="?nav_id={$local_link}&action=mail&entry_id={$entry_id}">
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
                <input type="hidden" name="sessionscode" value="{$sessionscode}" />
			 <input type="hidden" name="entry_id" value="{$entry_id}" />
			<tr>
			<td class="formailer_header" colspan="2"><input class="formailer_header_input" name="title" type="text" onclick="select()" value="{$entry_title}" />
			</td>
			</tr>
			<tr>
			<td class="formailer_txt">
			<textarea class="formailer_txt_textarea" name="content" cols="38" rows="5">{$entry_content}</textarea></td>
			<td class="formailer_adress">
			<img src="templates/style/icons/user.gif" /> <input class="formailer_adress_input" onclick="select()" name="name" type="text" value="{$entry_name}" /><br />
			<img src="templates/style/icons/email.gif" /> <input class="formailer_adress_input" onclick="select()" name="email" type="text" value="{$entry_email}" /><br />
			</td>
			</tr>
                        <tr>
                          <td colspan="2" style="padding: 10px;" class="formailer_adress">
                            <table border="0">
                              <tr>
                                <td rowspan="2"><img src="index.php?nav_id={$captcha_link}&img={$captcha_img}" /></td>
                                <td><div style="font-size: 10px">Bitte den Text eingeben,<br /> der im Bild steht</div></td>
                                
                                <td><div style="font-size: 10px">Sollte der Text nicht erkennbar sein, neues Bild w�hlen</div></td>
                              </tr>
                              <tr>
                                <td><input type="text" size="15" name="captcha_word" value="" /></td>
                                <td><input type="submit" name="captcha_revoke" value="Anderes Bild bitte!" /></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
			<tr>
				<td class="formailer_options" colspan="2"><input type="submit" name="btn_send" value="Senden"><input name="Clear" type="reset" id="Clear" value="Zur&uuml;cksetzen"></td>
			</tr>
		</table>
	</div>
</div>
