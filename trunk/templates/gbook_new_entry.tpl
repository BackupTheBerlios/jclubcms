      <div id="content">
		<div id="content_txt">
		<h2>Neuer Eintrag schreiben</h2>
    <table width = 100% class="content_tab">
    </table>
    {************************************************************}
    {************************************************************}
<script type="text/javascript" src="./javascript/smilies.js"></script>
    {************************************************************}
    {************************************************************}
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
    <form name="newentry" method="post" action="">
      <input type="hidden" name="sessionscode" value="{$sessionscode}" />
      <table cellpadding="0" cellspacing="0" align="center" class="content_tab">
        <tr>
          <td class="formailer_header" colspan="2"><img src="templates/style/icons/pencil.gif" /><input class="formailer_header_input" name="title" type="text" onclick="select()" value="{$entry_title}" /></td>
        </tr>
        <tr>
          <td class="formailer_txt">
          <textarea class="formailer_txt_textarea" name="content" cols="38" rows="5">{$entry_content}</textarea></td>
          <td class="formailer_adress">
          <img src="templates/style/icons/user.gif" /> <input class="formailer_adress_input" onclick="select()" name="name" type="text" value="{$entry_name}" /><br />
          <img src="templates/style/icons/email.gif" /> <input class="formailer_adress_input" onclick="select()" name="email" type="text" value="{$entry_email}" /><br />
          <img src="templates/style/icons/house.gif" /> <input class="formailer_adress_input" onclick="select()" name="hp" type="text" value="{$entry_hp}" /></a>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="padding: 10px;" class="formailer_txt">
            <table border="0">
              <tr>
                <td rowspan="2"><img src="?nav_id={$captcha_link}&img={$captcha_img}" /></td>
                <td><div style="font-size: 10px">Bitte den Text eingeben,<br /> der im Bild steht</div></td>
                
                <td><div style="font-size: 10px">Sollte der Text nicht erkennbar sein, neues Bild w&auml;hlen</div></td>
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
    </form>
    <table cellpadding="0" cellspacing="0" align="center" class="content_tab">
     <tr>
      <td class="formailer_header" colspan="2"><b>Smilie-Liste</b></td> 
     </tr>
     <tr>
      <td class="formailer_txt">
       <table class="content_tab">
        <tr>
         {foreach key=schluessel item=smily from=$smilies_list}
          <td align="right">{$smily.sign}</td><td><img src="{$smily.file}" onclick="smilies('{$smily.sign}')" style="cursor:pointer;" alt="{$smily.file}"></img></td>
	{if ($schluessel+1)%5 == 0}
		</tr>
		<tr>
	  {/if}
         {/foreach}
        </tr>
       </table>
      </td>
     </tr>
    </table>
  </div>
</div>
