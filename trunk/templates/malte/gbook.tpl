	<div id="content">
		<div id="contenttext">
			<h2>G&auml;stebuch</h2>
			<a href="?nav_id={$local_link}&action=new"><img src="templates/style/icons/book_open.gif" /><strong>Neuer Eintrag</strong></a><br /><br />
			{if $entries == 1}{$entries} Eintrag{else}{$entries} Eintr&auml;ge{/if} (+{if $comments == 1}{$comments} Kommentar{else}{$comments} Kommentare{/if})
			<br /><br />

			{foreach item=book  from=$gbook}
			<div class="news"> 
				<div class="newsheadline"> 
					<div class="newsdesign1"></div> 
					<div class="newsdesign2"><div style="padding-top: 18px;"><strong>{$book.title}</strong> <small><small>von <strong>{$book.name}</strong> am {$book.time} Uhr</small></small></div></div> 
					<div class="newsdesign3"></div> 
					<div class="newsdesign4"></div> 
					<div class="newsdesign5"></div> 
				</div> 
				<div class="newsinhalt"> 
					<div class="newsinhaltposition">
					{$book.content}<br /<br />
					<a href="?mail&nav_id={$local_link}&entry_id={$book.ID}"><img src="templates/style/icons/email.gif" /> E-mail</a>
					{if $book.hp neq ""} | <a href="http://{$book.hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
					<br /><a href="?nav_id={$local_link}&action=comment&ref_ID={$book.ID}"><img src="templates/style/icons/comment.gif" />Neuer Kommentar</a>
					
					{foreach key=schluessel item=comment from=$book.comments}
					
					<div class="commentposition">
						<div class="commentname">   
							<a href="?mail&nav_id={$local_link}&entry_id={$comment.ID}">{$comment.name}</a>{if $comment.hp neq ""} <a href="http://{$comment.hp}" target="_blank"> (Website)</a>{/if} schrieb dazu am {$comment.time} Uhr:
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