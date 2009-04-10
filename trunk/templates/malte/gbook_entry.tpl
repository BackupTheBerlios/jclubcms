      {config_load file='textes.de.conf' section='Gbook'}
	  
	  <div id="content">
		<div id="contenttext">
			<h2>Neuen Eintrag schreiben</h2>
			
	
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
			<div class="newsdesign2"><div style="padding-top: 18px;"><strong>Dein Eintrag:</strong></div></div>
			<div class="newsdesign3"></div>
			<div class="newsdesign4"></div>
			<div class="newsdesign5"></div>
		</div>	
	
		<div class="newsinhalt"> 
			<form name="newentry" method="post" action="">
			<div class="formposition">
				<input type="hidden" name="sessioncode" value="{$sessioncode}" />
				<label for="name">Titel</label>
	            <input name="title" type="text" onclick="select()" value="{$entry_title|default:#entry_title#}" /><br /><br />
	            <label for="name">Name</label>
	            <input type="text" onclick="select()" name="name" value="{$entry_name|default:#entry_name#}" /><br /><br />
	            <label for="email">Emailadresse</label>
	            <input onclick="select()" name="email" type="text" value="{$entry_email|default:#entry_email#}" /><br /><br />
				<label for="email">Website</label>
	            <input onclick="select()" name="hp" type="text" value="{$entry_hp|default:#entry_hp#}" /><br /><br />
	            <label for="text">Eintrag</label>
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