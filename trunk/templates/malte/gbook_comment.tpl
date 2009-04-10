      {config_load file='textes.de.conf' section='Gbook'}
	  
	  <div id="content">
		<div id="contenttext">
			<h2>Neuen Kommentar schreiben</h2>
			
		<div class="news"> 
				<div class="newsheadline"> 
					<div class="newsdesign1"></div> 
					<div class="newsdesign2"><div style="padding-top: 18px;"><strong>{$gbook.gbook_title}</strong> <small><small>von <strong>{$gbook.gbook_name}</strong> am {$gbook.gbook_time} Uhr</small></small></div></div> 
					<div class="newsdesign3"></div> 
					<div class="newsdesign4"></div> 
					<div class="newsdesign5"></div> 
				</div> 
				<div class="newsinhalt"> 
					<div class="newsinhaltposition">
					{$gbook.gbook_content}<br />
					<a href="?mail&nav_id={$local_link}&entry_id={$gbook.gbook_email}"><img src="templates/style/icons/email.gif" /> E-mail</a>
					{if $gbook.gbook_hp neq ""} | <a href="http://{$gbook.gbook_hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}<br />
					<br />
					
					{foreach key=schluessel item=comment from=$gbook.comments}
					
					<div class="commentposition">
						<div class="commentname">   
							<a href="?mail&nav_id={$local_link}&entry_id={$comment.ID}">{$comment.gbook_name}</a>{if $comment.gbook_hp neq ""}<a href="http://{$comment.gbook_hp}" target="_blank"> (Website)</a>{/if} schrieb dazu am {$comment.time} Uhr:
						</div>
						<div style="margin-left: 3px;">
							{$comment.gbook_content}
						</div>
				
					</div>
					{/foreach}
					
					</div> 
				</div>

				<div class="newsende"></div> 
			</div>
			
    {************************************************************}
    {************************************************************}
	<script type="text/javascript" src="./javascript/smilies.js"></script>
    {************************************************************}
    {************************************************************}
	{*Fehlerausgabe wenn noetig*}
	{if $dump_errors}
	<table class="content_tab" align="center">
		<tr>
			<td class="formailer_header" style="background-color: #EC6442">{$error_title|default:"Einige Daten sind ung&uuml;ltig"}</td>
		</tr>
		<tr>
			<td class="formailer_txt" style="background-color: #ED4B23; color: #000000">{$error_content}</td>
		</tr>
	</table>
	{/if}
	<div class="news">
		<div class="newsheadline">
			<div class="newsdesign1"></div>
			<div class="newsdesign2"><div style="padding-top: 18px;"><strong>Kommentar schreiben</strong></div></div>
			<div class="newsdesign3"></div>
			<div class="newsdesign4"></div>
			<div class="newsdesign5"></div>
		</div>	
	
		<div class="newsinhalt"> 
			<form name="newentry" method="post" action="">
			<div class="formposition">
				<input type="hidden" name="sessioncode" value="{$sessioncode}" />
	            <label for="name">Name</label>
	            <input type="text" onclick="select()" name="name" value="{$entry_name|default:#entry_name#}" /><br /><br />
	            <label for="email">Emailadresse</label>
	            <input onclick="select()" name="email" type="text" value="{$entry_email|default:#entry_email#}" /><br /><br />
				<label for="email">Website</label>
	            <input onclick="select()" name="hp" type="text" value="{$entry_hp|default:#entry_hp#}" /><br /><br />
	            <label for="text">Kommentar</label>
	            <textarea name="content"  cols="35" rows="10">{$entry_content|default:#entry_content#}</textarea><br />
	            <br /><label for="submit"> >> </label>
	            <input type="submit" name="btn_send" value="Senden"><input name="Clear" type="reset" id="Clear" value="Zur&uuml;cksetzen">
			</div>
			<div class="captchabild">
				<img src="?nav_id={$captcha_link}&img={$captcha_img}" /><br />
				<small>Bitte den Text eingeben, der in diesem Bild steht:</small><br />
				<input type="text" size="15" name="captcha_word" value="{$content}" /><br /><br />
				<small>Sollte der Text nicht erkennbar sein, neues Bild w&auml;hlen</small><br />
				<input type="submit" name="captcha_revoke" value="Anderes Bild bitte!" />
			</div>
			</form>
		</div> 
		
		<div class="newsende"></div> 
	</div>
	
	<div class="news">
		<div class="newsheadline">
			<div class="newsdesign1"></div>
			<div class="newsdesign2"><div style="padding-top: 18px;"><strong>Smilies</strong></div></div>
			<div class="newsdesign3"></div>
			<div class="newsdesign4"></div>
			<div class="newsdesign5"></div>
		</div>	
	
		<div class="newsinhalt">
			<div style="margin-left: 20px; margin-right: 24px">
			{foreach key=schluessel item=smily from=$smilies_list}
			{$smily.sign} <img src="{$smily.file}" onclick="smilies('{$smily.sign}')" style="cursor:pointer;" alt="{$smily.sign}"></img> 
			{/foreach}
			</div>
		</div> 
		
		<div class="newsende"></div> 
	</div>

    
	</div>
</div>