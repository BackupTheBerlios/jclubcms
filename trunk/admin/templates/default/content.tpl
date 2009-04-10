<div id="content">
	<div id="content_txt">
	<h1>Inhalte</h1>
	<div align="left"><a href="?nav_id={$local_link}&action=new&amp;{$SID}">Neuer Inhalt erstellen</a>
	<h2>Übersicht</h2>
	{foreach item=content  from=$contents}
		<a href="#{$content.content_ID}">{$content.content_title}</a>&nbsp;&nbsp;&nbsp;
	{/foreach}<br />
	<div align="center">{foreach item=page from=$pages}
			{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}
	{/foreach}</div>
	
	{foreach item=content  from=$contents}
	<a name="{$content.content_ID}"></a>
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="max-width: 80%;min-width: 60%;font-size: 11px;">
			<tr>	
				<td class="content_tab_header">
				{$content.content_title}
				</td>
				<td class="content_tab_header" colspan="1">
				 <img src="templates/style/icons/date.gif" />
				 {$content.content_time}
				</td>
				</td>
			</tr>
			<tr>
				<td class="content_tab_content1">
					{*Bei Links für Bilder wird noch die Sessionid angehängt, das diese im Text nicht vorkommt. Denn der Text wird auch im Userbereich angezeigt*}
					{$content.content_text|truncate:500:"..."|replace:"src=\"?image":"src=\"?image&amp;$SID"}
				</td>
				<td class="content_tab_content2" style="text-align:right">
				<!--<img src="templates/style/icons/user.gif" />  {$content.content_author|default:"Unknkow User"}<br />-->
					<br />
					<a href="?nav_id={$local_link}&amp;action=edit&amp;ref_ID={$content.content_ID}&amp;{$SID}"><img src="templates/style/icons/pencil.gif" />Editieren</a>
					<br />
					<a href="?nav_id={$local_link}&amp;action=del&amp;ref_ID={$content.content_ID}&amp;{$SID}"><img src="templates/style/icons/del.gif" />L&ouml;schen</a>
				</td>
			</tr>
		{/foreach}
			</td>
		</tr>
	</table>
	<div align="center">Erstellt in {$generated_time}s</div>
	</div>
</div>