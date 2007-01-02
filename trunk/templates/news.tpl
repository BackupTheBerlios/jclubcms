<div id="contentContainer">
	<div id="content">
		<table class="pagesnav"><tr>
		{foreach item=page from=$pages}
		<td><a href="{$page.link}">[{$page.page}]</a></td>
		{/foreach}
		</tr>
		</table>
		{foreach item=news  from=$newsarray}
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
			<td class="content_tab_header" colspan="2">
			{$news.title}
			</td>
			</tr>
			<tr>
			<td class="content_tab_content1">
			{$news.content}
			</td>
			<td class="content_tab_content2">
			<img src="templates/style/icons/date.gif" /> {$news.time}<br />
			<img src="templates/style/icons/user.gif" /> {$news.name}<br />
			<a href="?nav_id={$local_link}&action=mail&entry_id={$news.ID}"><img src="templates/style/icons/email.gif" /> E-mail</a>
			{if $news.hp neq ""}<br /><a href="{$news.hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
			</td>
			</tr>
			{* Innere Schlaufe für das Auslesen der Kommentare *}
			{foreach key=schluessel item=comment from=$news.comments}
			</tr>
			<tr>
			<td class="content_tab_content1">
			{$comment.comment_content}
			</td>
			<td class="content_tab_content2">
			<img src="templates/style/icons/date.gif" /> {$comment.comment_time}<br />
			<img src="templates/style/icons/user.gif" /> {$comment.comment_name}<br />
			<a href="?nav_id={$local_link}&action=mail&entry_id={$comment.comment_ID}"><img src="templates/style/icons/email.gif" /> E-mail</a>
			{if $comment.comment_hp neq ""}<br /><a href="{$comment.comment_hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
			</td>
			</tr>
			{/foreach}
			</table>
		{/foreach}
		<table class="pagesnav"><tr>
		{foreach item=page from=$pages}
		<td><a href="{$page.link}">[{$page.page}]</a></td>
		{/foreach}
		</tr>
		</table>
		Erstellt in {$generated_time}s
	</div>
</div>
