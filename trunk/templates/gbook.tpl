<div id="content">
	<div id="content_txt">
	<table width="640" align="center" class="content_tab">
		<tr>
			<td><a href="?nav_id={$local_link}&action=new"><img src="templates/style/icons/book_open.gif" />Neuer Eintrag</a></td><td align="right">{if $entrys lte 1}{$entrys} Eintrag{else}{$entrys} Eintr&auml;ge{/if}</td>
		</tr>
		<tr>
			<td colspan="2" align="center">{foreach item=page from=$pages}
			<a href="{$page.link}">[{$page.page}]</a>
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
				Kommentäre: {$book.number_of_comments}
				</td>
			</tr>
			<tr>
				<td class="content_tab_content1">
				{$book.content}
				</td>
				<td class="content_tab_content2">
				<img src="templates/style/icons/date.gif" /> {$book.time}<br />
				<img src="templates/style/icons/user.gif" /> {$book.name}<br />
				<a href="?nav_id={$local_link}&action=mail&entry_id={$book.email}"><img src="templates/style/icons/email.gif" /> E-mail</a>
				{if $book.hp neq ""}<br /><a href="http://{$book.hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
				</td>
			</tr>
			{* Innere Schlaufe für das Auslesen der Kommentare *}
			{foreach key=schluessel item=comment from=$book.comments}
				<tr>
					<td class="content_tab_content1">
					{$comment.comment_content}
					</td>
					<td class="content_tab_content2">
					<img src="templates/style/icons/date.gif" /> {$comment.comment_time}<br />
					<img src="templates/style/icons/user.gif" /> {$comment.comment_name}<br />
					<a href="?nav_id={$local_link}&action=mail&entry_id={$comment.comment_email}"><img src="templates/style/icons/email.gif" /> E-mail</a>
					{if $comment.comment_hp neq ""}<br /><a href="http://{$comment.comment_hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
					</td>
				</tr>
			{/foreach}
			<tr>
				<td colspan="2" class="content_tab_content1" align="center"><a href="?nav_id={$local_link}&action=comment&ref_ID={$book.ID}"><img src="templates/style/icons/comment.gif" />Neuer Kommentar</a></td>
			</tr>
		</table>
	{/foreach}
	<table width="640" align="center" class="content_tab">
		<tr>
			<td><a href="?nav_id={$local_link}&action=new"><img src="templates/style/icons/book_open.gif" />Neuer Eintrag</a></td><td align="right">{if $entrys lte 1}{$entrys} Eintrag{else}{$entrys} Eintr&auml;ge{/if}</td>
		</tr>
		<tr>
			<td colspan="2" align="center">{foreach item=page from=$pages}
				<a href="{$page.link}">[{$page.page}]</a>
		{/foreach}
			</td>
		</tr>
	</table>
	<div align="center">Erstellt in {$generated_time}s</div>
	</div>
</div>