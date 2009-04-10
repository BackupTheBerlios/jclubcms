<div id="content">
	<div id="content_txt">
		<h1>G&auml;stebuch</h1>
	<table width="640" align="center" class="content_tab">
		<tr>
			<td><a href="?nav_id={$local_link}&action=new"><img src="{$TEMPLATESET_DIR}/style/icons/book_open.gif" />Neuer Eintrag</a></td><td align="right">{if $entries == 1}{$entries} Eintrag{else}{$entries} Eintr&auml;ge{/if} (+{if $comments == 1}{$comments} Kommentar{else}{$comments} Kommentare{/if})</td>
		</tr>
		<tr>
			<td colspan="2" align="center">{foreach item=page from=$pages}
			{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}
			{/foreach}
			</td>
		</tr>
	</table>
	{foreach item=book  from=$gbook}
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
				<td class="content_tab_header">
				{$book.title}
				</td>
				<td class="content_tab_header" style="border-left: 0px;">
				Kommentare: {$book.number_of_comments}
				</td>
			</tr>
			<tr>
				<td class="content_tab_content1">
				{$book.content}
				</td>
				<td class="content_tab_content2">
				<img src="{$TEMPLATESET_DIR}/style/icons/date.gif" /> {$book.time}<br />
				<img src="{$TEMPLATESET_DIR}/style/icons/user.gif" /> {$book.name}<br />
				<a href="?mail&nav_id={$local_link}&entry_id={$book.ID}"><img src="{$TEMPLATESET_DIR}/style/icons/email.gif" /> E-mail</a>
				{if $book.hp neq ""}<br /><a href="http://{$book.hp}" target="_blank"><img src="{$TEMPLATESET_DIR}/style/icons/house.gif" /> Website</a>{/if}
				</td>
			</tr>
			{* Innere Schlaufe für das Auslesen der Kommentare *}
			{foreach key=schluessel item=comment from=$book.comments}
				<tr>
					<td class="content_tab_content1">
					{$comment.content}
					</td>
					<td class="content_tab_content2">
					<img src="{$TEMPLATESET_DIR}/style/icons/date.gif" /> {$comment.time}<br />
					<img src="{$TEMPLATESET_DIR}/style/icons/user.gif" /> {$comment.name}<br />
					<a href="?mail&nav_id={$local_link}&entry_id={$comment.ID}"><img src="{$TEMPLATESET_DIR}/style/icons/email.gif" /> E-mail</a>
					{if $comment.hp neq ""}<br /><a href="http://{$comment.hp}" target="_blank"><img src="{$TEMPLATESET_DIR}/style/icons/house.gif" /> Website</a>{/if}
					</td>
				</tr>
			{/foreach}
			<tr>
				<td colspan="2" class="content_tab_content1" align="center"><a href="?nav_id={$local_link}&action=comment&ref_ID={$book.ID}"><img src="{$TEMPLATESET_DIR}/style/icons/comment.gif" />Neuer Kommentar</a></td>
			</tr>
		</table>
	{/foreach}
	<table width="640" align="center" class="content_tab">
		<tr>
			<td><a href="?nav_id={$local_link}&action=new"><img src="{$TEMPLATESET_DIR}/style/icons/book_open.gif" />Neuer Eintrag</a></td><td align="right">{if $entries == 1}{$entries} Eintrag{else}{$entries} Eintr&auml;ge{/if} (+{if $comments == 1}{$comments} Kommentar{else}{$comments} Kommentare{/if})</td>
		</tr>
		<tr>
			<td colspan="2" align="center">{foreach item=page from=$pages}
				{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}
		{/foreach}
			</td>
		</tr>
	</table>
	<div align="center">Erstellt in {$generated_time}s</div>
	</div>
</div>