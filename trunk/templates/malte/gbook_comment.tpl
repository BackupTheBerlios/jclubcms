      {config_load file='textes.de.conf' section='Gbook'}
	  
	  <div id="content">
		<div id="contenttext">
			<h2>{#wrote_new_comment#}</h2>
			
		<div class="news"> 
				<div class="newsheadline"> 
					<div class="newsdesign1"></div> 
					<div class="newsdesign2"><div style="padding-top: 18px;"><strong>{$gbook.gbook_title}</strong> <small><small>{#of#} <strong>{$gbook.gbook_name}</strong> {#at#} {$gbook.gbook_time}</small></small></div></div> 
					<div class="newsdesign3"></div> 
					<div class="newsdesign4"></div> 
					<div class="newsdesign5"></div> 
				</div> 
				<div class="newsinhalt"> 
					<div class="newsinhaltposition">
					{$gbook.gbook_content}<br />
					<a href="?mail&nav_id={$local_link}&entry_id={$gbook.gbook_email}"><img src="{$TEMPLATESET_DIR}/style/icons/email.gif" /> {#email#}</a>
					{if $gbook.gbook_hp neq ""} | <a href="http://{$gbook.gbook_hp}" target="_blank"><img src="{$TEMPLATESET_DIR}/style/icons/house.gif" /> {#website#}</a>{/if}<br />
					<br />
					
					{foreach key=schluessel item=comment from=$gbook.comments}
					
					<div class="commentposition">
						<div class="commentname">   
							<a href="?mail&nav_id={$local_link}&entry_id={$comment.ID}">{$comment.gbook_name}</a>{if $comment.gbook_hp neq ""}<a href="http://{$comment.gbook_hp}" target="_blank"> ({#website#})</a>{/if} {#wrote_at#} {$comment.time}:
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
	<div class="news">
		<div class="newsheadline">
			<div class="newsdesign1"></div>
			<div class="newsdesign2"><div style="padding-top: 18px;"><strong>{$error_title|default:#error_invalid_data#}</strong></div></div>
			<div class="newsdesign3"></div>
			<div class="newsdesign4"></div>
			<div class="newsdesign5"></div>
		</div>
		<div class="newsinhalt"> 
		<div class="formposition">
			<div class="formposition">{$error_content}</div>
		</div>
		<div class="newsende"></div> 
	</div>
	{/if}
	<div class="news">
		<div class="newsheadline">
			<div class="newsdesign1"></div>
			<div class="newsdesign2"><div style="padding-top: 18px;"><strong>{#comment_new#}</strong></div></div>
			<div class="newsdesign3"></div>
			<div class="newsdesign4"></div>
			<div class="newsdesign5"></div>
		</div>	
	
		<div class="newsinhalt"> 
			<form name="newentry" method="post" action="">
			<div class="formposition">
				<input type="hidden" name="sessioncode" value="{$sessioncode}" />
	            <label for="name">{#name#}</label>
	            <input type="text" onclick="select()" name="name" value="{$entry_name|default:#entry_name#}" /><br /><br />
	            <label for="email">{#email#}</label>
	            <input onclick="select()" name="email" type="text" value="{$entry_email|default:#entry_email#}" /><br /><br />
				<label for="email">{#website#}</label>
	            <input onclick="select()" name="hp" type="text" value="{$entry_hp|default:#entry_hp#}" /><br /><br />
	            <label for="text">{#comment#}</label>
	            <textarea name="content"  cols="35" rows="10">{$entry_content|default:#entry_content#}</textarea><br />
	            <br /><label for="submit"> >> </label>
	            <input type="submit" name="btn_send" value="{#send#}"><input name="Clear" type="reset" id="Clear" value="{#undo#}">
			</div>
			<div class="captchabild">
				<img src="?nav_id={$captcha_link}&img={$captcha_img}" /><br />
				<small>{#wrote_text_of_image#}:</small><br />
				<input type="text" size="15" name="captcha_word" value="{$content}" /><br /><br />
				<small>{#unreadable_new_image#}</small><br />
				<input type="submit" name="captcha_revoke" value="{#new_image_please#}" />
			</div>
			</form>
		</div> 
		
		<div class="newsende"></div> 
	</div>
	
	<div class="news">
		<div class="newsheadline">
			<div class="newsdesign1"></div>
			<div class="newsdesign2"><div style="padding-top: 18px;"><strong>{#smilies#}</strong></div></div>
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