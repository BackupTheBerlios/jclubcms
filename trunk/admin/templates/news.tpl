 <div id="content">
		<div id="content_txt">
			<h1>News</h1>
		<table width="640" align="center" class="content_tab">
		<tr>
			<td><a href="?nav_id={$local_link}&action=new&amp;{$SID}"><img src="templates/style/icons/book_open.gif" />Neuer Eintrag</a></td><td align="right">{if $entrys lte 1}{$entrys|default:"kein"} Eintrag{else}{$entrys} Eintr&auml;ge{/if}</td>
		</tr>
		<tr>
			<td colspan="2" align="center">{foreach item=page from=$pages}
			<a href="{$page.link}">[{$page.page}]</a>
			{/foreach}
			</td>
		</tr>
	</table>
		{foreach item=news  from=$newsarray}
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
				<td class="content_tab_header" colspan="1">
				{$news.news_title}
				</td>
				<td class="content_tab_header" colspan="1">
				Kommentare: {$news.number_of_comments}
				</td>
				<td class="content_tab_header" colspan="1">
				Optionen
				</td>
			</tr>
			<tr>
				<td class="content_tab_content1">
				{$news.news_content}
				</td>
				<td class="content_tab_content2">
					<img src="templates/style/icons/date.gif" /> {$news.time}<br />
					<img src="templates/style/icons/user.gif" /> {$news.news_name}<br />
					<a href="?nav_id={$local_link}&action=mail&entry_id={$news.ID}&amp;{$SID}"><img src="templates/style/icons/email.gif" /> E-mail</a>
					{if $news.hp neq ""}<br /><a href="{$news.hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
				</td>
				<td class="content_tab_content2" style="text-align:right">
					<a href="./index.php?nav_id={$local_link}&amp;action=edit&amp;id={$news.news_ID}&amp;{$SID}"><img src="templates/style/icons/pencil.gif" />Editieren</a>
					<br />
					<a href="./index.php?nav_id={$local_link}&amp;action=del&amp;id={$news.news_ID}&amp;{$SID}"><img src="templates/style/icons/del.gif" />L&ouml;schen</a>
				</td>
			</tr>
			{* Innere Schlaufe für das Auslesen der Kommentare *}
			{foreach key=schluessel item=comment from=$news.comments}
			<tr>
				<td class="content_tab_content1">
				{$comment.news_content}
				</td>
				<td class="content_tab_content2">	
					<img src="templates/style/icons/date.gif" /> {$comment.time}<br />
					<img src="templates/style/icons/user.gif" /> {$comment.news_name}<br />
					<a href="?nav_id={$local_link}&action=mail&entry_id={$comment.comment_ID}&amp;{$SID}"><img src="templates/style/icons/email.gif" /> E-mail</a>
					{if $comment.news_hp neq ""}
					<br />
					<a href="{$comment.comment_hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>
					{/if}
				</td>
				<td class="content_tab_content2" style="text-align:right">
					<a href="./index.php?nav_id={$local_link}&amp;action=edit&amp;id={$comment.news_ID}&amp;{$SID}"><img src="templates/style/icons/pencil.gif" />Editieren</a>
					<br />
					<a href="./index.php?nav_id={$local_link}&amp;action=del&amp;id={$comment.news_ID}&amp;{$SID}"><img src="templates/style/icons/del.gif" />L&ouml;schen</a>
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