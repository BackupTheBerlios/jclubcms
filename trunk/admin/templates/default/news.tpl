 <div id="content">
		<div id="content_txt">
			<h1>News</h1>
			<p style="background-color:#FF8822; text-align: center">{$info}</p>
		<table width="640" align="center" class="content_tab">
		<tr>
			<td><a href="?nav_id={$local_link}&action=new&amp;{$SID}"><img src="templates/style/icons/book_open.gif" />Neuer Eintrag</a></td><td align="right">{if $entries lte 1}{$entries|default:"kein"} Eintrag{else}{$entries} Eintr&auml;ge{/if}</td>
		</tr>
		<tr>
			<td colspan="2" align="center">{foreach item=page from=$pages}
			{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}
			{/foreach}
			</td>
		</tr>
	</table>
		{foreach item=news  from=$news}
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
				<td class="content_tab_header" colspan="1">
				{$news.title}
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
				{$news.content}
				</td>
				<td class="content_tab_content2">
					<img src="templates/style/icons/date.gif" /> {$news.time}<br />
					<img src="templates/style/icons/user.gif" /> {$news.name}<br />
					<a href="?mail&nav_id={$local_link}&entry_id={$news.ID}&amp;{$SID}"><img src="templates/style/icons/email.gif" /> E-mail</a>
					{if $news.hp neq ""}<br /><a href="http://{$news.hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>{/if}
				</td>
				<td class="content_tab_content2" style="text-align:right">
					<a href="?nav_id={$local_link}&amp;action=comment&amp;ref_ID={$news.ID}&amp;{$SID}"><img src="templates/style/icons/pencil.gif" />Kommentieren</a>
					<br />
					<a href="?nav_id={$local_link}&amp;action=edit&amp;ref_ID={$news.ID}&amp;{$SID}"><img src="templates/style/icons/pencil.gif" />Editieren</a>
					<br />
					<a href="?nav_id={$local_link}&amp;action=del&amp;ref_ID={$news.ID}&amp;{$SID}"><img src="templates/style/icons/del.gif" />L&ouml;schen</a>
				</td>
			</tr>
			{* Innere Schlaufe für das Auslesen der Kommentare *}
			{foreach key=schluessel item=comment from=$news.comments}
			<tr>
				<td class="content_tab_content1">
				{$comment.content}
				</td>
				<td class="content_tab_content2">	
					<img src="templates/style/icons/date.gif" /> {$comment.time}<br />
					<img src="templates/style/icons/user.gif" /> {$comment.name}<br />
					<a href="?mail&nav_id={$local_link}&entry_id={$comment.ID}&amp;{$SID}"><img src="templates/style/icons/email.gif" /> E-mail</a>
					{if $comment.hp neq ""}
					<br />
					<a href="http://{$comment.comment_hp}" target="_blank"><img src="templates/style/icons/house.gif" /> Website</a>
					{/if}
				</td>
				<td class="content_tab_content2" style="text-align:right">
					<a href="?nav_id={$local_link}&amp;action=edit&amp;ref_ID={$comment.ID}&amp;{$SID}"><img src="templates/style/icons/pencil.gif" />Editieren</a>
					<br />
					<a href="?nav_id={$local_link}&amp;action=del&amp;ref_ID={$comment.ID}&amp;{$SID}"><img src="templates/style/icons/del.gif" />L&ouml;schen</a>
				</td>
			</tr>
			{/foreach}
			</table>
		{/foreach}
		<table class="pagesnav"><tr>
		{foreach item=page from=$pages}
		<td>{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}</td>
		{/foreach}
		</tr>
		</table>
		Erstellt in {$generated_time}s
	</div>
</div>