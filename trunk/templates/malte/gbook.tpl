{config_load file="textes.de.conf" section="Gbook"}
	<div id="content">
		<div id="contenttext">
			<h2>{#gbook#}</h2>
			<a href="?nav_id={$local_link}&action=new"><img src="{$TEMPLATESET_DIR}/style/icons/book_open.gif" /><strong>{#entry_new#}</strong></a><br /><br />
			{if $entries == 1}{$entries} {#entry#}{else}{$entries} {#entries#}{/if} (+{if $comments == 1}{$comments} {#comment#}{else}{$comments} {#comments#}{/if})
			<br /><br />

			{foreach item=book  from=$gbook}
			<div class="news"> 
				<div class="newsheadline"> 
					<div class="newsdesign1"></div> 
					<div class="newsdesign2"><div style="padding-top: 18px;"><strong>{$book.title}</strong> <small><small>{#of#} <strong>{$book.name}</strong> {#at#} {$book.time} </small></small></div></div> 
					<div class="newsdesign3"></div> 
					<div class="newsdesign4"></div> 
					<div class="newsdesign5"></div> 
				</div> 
				<div class="newsinhalt"> 
					<div class="newsinhaltposition">
					{$book.content}<br /<br />
					<a href="?mail&nav_id={$local_link}&entry_id={$book.ID}"><img src="{$TEMPLATESET_DIR}/style/icons/email.gif" /> {#email#}</a>
					{if $book.hp neq ""} | <a href="http://{$book.hp}" target="_blank"><img src="{$TEMPLATESET_DIR}/style/icons/house.gif" /> {#website#}</a>{/if}
					<br /><a href="?nav_id={$local_link}&action=comment&ref_ID={$book.ID}"><img src="{$TEMPLATESET_DIR}/style/icons/comment.gif" />N{#comment_new#}</a>
					
					{foreach key=schluessel item=comment from=$book.comments}
					
					<div class="commentposition">
						<div class="commentname">   
							<a href="?mail&nav_id={$local_link}&entry_id={$comment.ID}">{$comment.name}</a>{if $comment.hp neq ""} <a href="http://{$comment.hp}" target="_blank"> ({#website#})</a>{/if} {#wrote_at#} {$comment.time}:
						</div>
						<div style="margin-left: 3px;">
							{$comment.content}
						</div>
					</div>
					{/foreach}
					</div> 
				</div>

				<div class="newsende"></div> 
			</div>
			{/foreach}

			<div><br /><br />
			{foreach item=page from=$pages}
			{if $page.link != ""}<a href="{$page.link}"> [{$page.page}] -</a>{else} [{$page.page}] -{/if}</a>
			{/foreach}
			</div>
		</div>
	</div>