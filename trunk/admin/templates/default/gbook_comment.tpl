      <div id="content">
		<div id="content_txt">
		<p style="background-color:#FF8822; text-align: center">{$info}</p>
    <table width = 100% class="content_tab">
    </table>
    {************************************************************}
    {************************************************************}
<script type="text/javascript" src="../javascript/smilies.js"></script>
    {************************************************************}
    {************************************************************}
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
					<img src="{$TEMPLATESET_DIR}/style/icons/date.gif" /> {$gbook.time}<br />
					<img src="{$TEMPLATESET_DIR}/style/icons/user.gif" /> {$gbook.name}<br />
					<a href="?nav_id={$local_link}&action=mail&entry_id={$gbook.ID}&amp;{$SID}"><img src="{$TEMPLATESET_DIR}/style/icons/email.gif" /> E-mail</a>
					{if $gbook.hp neq ""}<br /><a href="{$gbook.hp}" target="_blank"><img src="{$TEMPLATESET_DIR}/style/icons/house.gif" /> Website</a>{/if}
				</td>
			</tr>
			{* Innere Schlaufe f�r das Auslesen der Kommentare *}
		  {foreach key=schluessel item=comment from=$gbook.comments}
		  <tr>
			<td class="content_tab_content1">
			  {$comment.content}
			</td>
			<td class="content_tab_content2">
			  <img src="{$TEMPLATESET_DIR}/style/icons/date.gif" /> {$comment.time}<br />
			  <img src="{$TEMPLATESET_DIR}/style/icons/user.gif" /> {$comment.name}<br />
			  <a href="?mail&nav_id={$local_link}&entry_id={$comment.ID}"><img src="{$TEMPLATESET_DIR}/style/icons/email.gif" /> E-mail</a><br />
			  {if $comment.hp neq ""}<a href="http://{$comment.hp}"><img src="{$TEMPLATESET_DIR}/style/icons/house.gif" /> Website</a>{/if}
			</td>
		  </tr>
		  {/foreach}
	</table>
	{*Fehlerausgabe wenn noetig*}
	{if $dump_errors}
	<table class="content_tab" align="center">
		<tr>
			<td class="formailer_header" style="background-color: #EC6442">{$error_title|default:"Einige Daten sind ung&uuml;ltig"}</td>
		</tr>
		<tr>
			<td class="formailer_txt" style="background-color: #ED4B23; color:black">{$error_content}</td>
		</tr>
	</table>
	{/if}
	<!-- Eintrags-Formular -->
    <form name="newentry" method="post" action="">
      <table cellpadding="0" cellspacing="0" align="center" class="content_tab">	  
        <tr>
          <td class="formailer_header" colspan="2"></td>
        </tr>
        <tr>
          <td class="formailer_txt">
          <textarea class="formailer_txt_textarea" name="content" cols="38" rows="5">{$entry_content}</textarea></td>
          <td class="formailer_adress">
          <img src="{$TEMPLATESET_DIR}/style/icons/user.gif" /> <input class="formailer_adress_input" onclick="select()" name="name" type="text" value="{$entry_name}" /><br />
          <img src="{$TEMPLATESET_DIR}/style/icons/email.gif" /> <input class="formailer_adress_input" onclick="select()" name="email" type="text" value="{$entry_email}" /><br />
          <img src="{$TEMPLATESET_DIR}/style/icons/house.gif" /> <input class="formailer_adress_input" onclick="select()" name="hp" type="text" value="{$entry_hp}" /></a>
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
