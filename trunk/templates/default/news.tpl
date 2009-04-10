      <div id="content">
		<div id="content_txt">
		<h1>News</h1>
		<table class="pagesnav" align="center"><tr>
		{foreach item=page from=$pages}
		<td>{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}</td>
		{/foreach}
		</tr>
		</table>
		{foreach item=news  from=$newsarray}
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
			<td class="content_tab_header" colspan="2">
			{$news.news_title}
			</td>
			</tr>
			<tr>
			<td class="content_tab_content1">
			{$news.news_content}
			</td>
			<td class="content_tab_content2">
			<img src="templates/style/icons/date.gif" /> {$news.news_time}<br />
			<img src="templates/style/icons/user.gif" /> {$news.news_name}<br />
			<a href="?mail&nav_id={$local_link}&entry_id={$news.news_ID}"><img src="templates/style/icons/email.gif" /> E-mail</a>
			{if $news.news_hp neq ""}<br /><a href="http://{$news.news_hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
			</td>
			</tr>
			{* Innere Schlaufe für das Auslesen der Kommentare *}
			{foreach key=schluessel item=comment from=$news.comments}
			</tr>
			<tr>
			<td class="content_tab_content1">
			{$comment.news_content}
			</td>
			<td class="content_tab_content2">
			<img src="templates/style/icons/date.gif" /> {$comment.news_time}<br />
			<img src="templates/style/icons/user.gif" /> {$comment.news_name}<br />
			<a href="?mail&nav_id={$local_link}&entry_id={$comment.news_ID}"><img src="templates/style/icons/email.gif" /> E-mail</a>
			{if $comment.news_hp neq ""}<br /><a href="http://{$comment.news_hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
			</td>
			</tr>
			{/foreach}
			</table>
		{/foreach}
		<table class="pagesnav" align="center"><tr>
		{foreach item=page from=$pages}
		<td>{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}</a></td>
		{/foreach}
		</tr>
		</table>
	</div>
</div>
