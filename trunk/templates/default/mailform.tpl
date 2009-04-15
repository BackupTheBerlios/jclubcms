      {config_load file='textes.de.conf' section='Mail'}
	  
	  <div id="content">
		<div id="content_txt">
		<h1>{#mail_write#}</h1>
		<table width = 100% class="content_tab">
		</table>
		{#mail_to#} {$reciver_name}:
		{*Fehlerausgabe wenn noetig*}
		{if $dump_errors}
		<table class="content_tab" align="center">
			<tr>
				<td class="formailer_header" style="background-color: #EC6442">{$error_title|default:#error_invalid_data#}}</td>
			</tr>
			<tr>
				<td class="formailer_txt" style="background-color: #ED4B23">{foreach item=error_content from=$error_contents}<li>{$error_content}</li>{/foreach}</td>
			</tr>
		</table>
		{/if}
		
		<form method="post" action="">
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
                <input type="hidden" name="sessioncode" value="{$sessioncode}" />
			 <input type="hidden" name="entry_id" value="{$entry_id}" />
			<tr>
			<td class="formailer_header" colspan="2"><input class="formailer_header_input" name="title" type="text" onclick="select()" value="{$entry_title|default:#entry_title#}" />
			</td>
			</tr>
			<tr>
			<td class="formailer_txt">
			<textarea class="formailer_txt_textarea" name="content" cols="38" rows="5">{$entry_content|default:#entry_content#}</textarea></td>
			<td class="formailer_adress">
			<img src="{$TEMPLATESET_DIR}/style/icons/user.gif" /> <input class="formailer_adress_input" onclick="select()" name="name" type="text" value="{$entry_name|default:#entry_name#}" /><br />
			<img src="{$TEMPLATESET_DIR}/style/icons/email.gif" /> <input class="formailer_adress_input" onclick="select()" name="email" type="text" value="{$entry_email|default:#entry_email#}" /><br />
			</td>
			</tr>
                        <tr>
                          <td colspan="2" style="padding: 10px;" class="formailer_adress">
                            <table border="0">
                              <tr>
                                <td rowspan="2"><img src="?nav_id={$captcha_link}&img={$captcha_img}" /></td>
                                <td><div style="font-size: 10px">{#wrote_text_of_image#}</div></td>
                                
                                <td><div style="font-size: 10px">{#unreadable_new_image#}</div></td>
                             </tr>
                              <tr>
                                <td><input type="text" size="15" name="captcha_word" value="" /></td>
                                <td><input type="submit" name="captcha_revoke" value="{#new_image_please#}" /></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
			<tr>
				<td class="formailer_options" colspan="2"><input type="submit" name="btn_send" value="{#send#}"><input name="Clear" type="reset" id="Clear" value="{#undo#}"></td>
			</tr>
		</table>
	</div>
</div>
