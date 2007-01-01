<div id="background_content">&nbsp;</div>
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
			<img src="templates/style/icons/date.png" /> {$news.time}<br />
			<img src="templates/style/icons/user.png" /> {$news.name}<br />
			<a href="?nav_id={$local_link}&action=mail&entry_id={$news.ID}"><img src="templates/style/icons/email.png" /> E-mail</a><br />
			<a href="{$news.hp}"><img src="templates/style/icons/link.png" /> Website</a>
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
			<img src="templates/style/icons/date.png" /> {$comment.comment_time}<br />
			<img src="templates/style/icons/user.png" /> {$comment.comment_name}<br />
			<a href="?nav_id={$local_link}&action=mail&entry_id={$comment.comment_ID}"><img src="templates/style/icons/email.png" /> E-mail</a><br />
			<a href="{$comment.comment_hp}"><img src="templates/style/icons/link.png" /> Website</a>
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
