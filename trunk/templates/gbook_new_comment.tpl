      <div id="content">
		<div id="content_txt">
    <table width = 100% class="content_tab">
    </table>
    <table cellpadding="0" cellspacing="0" align="center" class="content_tab">
      <tr>
        <td class="content_tab_header" colspan="2">
            {$gbook.title}
        </td>
      </tr>
      <tr>
        <td class="content_tab_content1">
          {$gbook.content}
        </td>
        <td class="content_tab_content2">
        <img src="templates/style/icons/date.gif" /> {$gbook.time}<br />
        <img src="templates/style/icons/user.gif" /> {$gbook.name}<br />
        <a href="?nav_id={$local_link}&action=mail&entry_id={$gbook.email}"><img src="templates/style/icons/email.gif" /> E-mail</a><br />
        {if $gbook.hp neq ""}<a href="?nav_id={$local_link}&action=mail&entry_id={$gbook.email}"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
        </td>
      </tr>
      {* Innere Schlaufe für das Auslesen der Kommentare *}
      {foreach key=schluessel item=comment from=$gbook.comments}
      <tr>
        <td class="content_tab_content1">
          {$comment.comment_content}
        </td>
        <td class="content_tab_content2">
          <img src="templates/style/icons/date.gif" /> {$comment.comment_time}<br />
          <img src="templates/style/icons/user.gif" /> {$comment.comment_name}<br />
          <a href="?nav_id={$local_link}&action=mail&entry_id={$comment.comment_email}"><img src="templates/style/icons/email.gif" /> E-mail</a><br />
          {if $comment.comment_hp neq ""}<a href="http://{$comment.comment_hp}"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
        </td>
      </tr>
      {/foreach}
    </table>

    <form method="post" action="?nav_id={$nav_id}&action=comment&ref_ID={$ref_ID}">
      <input type="hidden" name="sessionscode" value="{$sessionscode}" />
      <table cellpadding="0" cellspacing="0" align="center" class="content_tab">
        <tr>
          <td class="formailer_header" colspan="2">{$entry_title}
          </td>
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
          <td colspan="2" style="padding: 10px;" class="formailer_adress">
            <table border="0">
              <tr>
                <td rowspan="2"><img src="index.php?nav_id={$captcha_id}&img={$captcha_img}" /></td>
                <td><div style="font-size: 10px">Bitte den Text eingeben,<br /> der im Bild steht</div></td>
                
                <td><div style="font-size: 10px">Sollte der Text nicht erkennbar sein, neues Bild wählen</div></td>
              </tr>
              <tr>
                <td><input type="text" size="15" name="captcha_word" value="{$content}" /></td>
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
          <td>{$smily.sign}&nbsp;{$smily.file}&nbsp;&nbsp;</td>
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
