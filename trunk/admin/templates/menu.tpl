<div id="content">
	<div id="content_txt">
	<h1>Inhalte</h1>
	<div align="left"><a href="?nav_id={$local_link}&action=new&amp;{$SID}">Neuer Inhalt erstellen</a>
	<h2>Übersicht</h2>
	{foreach item=menu  from=$menus}
		<a href="#{$content.content_ID}">{$menu.menu_name}</a>&nbsp;&nbsp;&nbsp;
	{/foreach}<br />
	<div align="center">{foreach item=page from=$pages}
			{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}
	{/foreach}</div>
	<form name="menus" method="post" action="">
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="max-width: 80%;min-width: 60%;font-size: 11px; border-width:2px solid yellow;">
			<tr  class="content_tab_header" >	
				<td style="padding: 6px">Name</td>
				<td style="padding: 6px">Position</td>
				<td style="padding: 6px">Verweistyp</td>
				<td style="padding: 6px">Verweis-Id</td>
				<td style="padding: 6px">Parameter</td>
				<td style="padding: 6px">Anzeige</td>
				<td style="padding: 6px">&auml;ndern</td>
			</tr>
			{foreach name=menuausgabe item=menu  from=$menus}
			<tr name="{$menu.menu_ID}" class="content_tab_content2" style="padding: 6px; {if $smarty.foreach.menuausgabe.iteration % 2 == 0}background-color: yellow;{/if}">	
				<td>{$menu.menu_space}<a href="?nav_id={$local_link}&amp;action=edit&amp;ref_ID={$menu.menu_ID}&amp;{$SID}">{$menu.menu_name}</a></td>
				<td>
				<select id="menu_position" name="menu_position" size="1">
					{foreach item=position from=$positions}
			<option value="{$position.pos_name}" {if $position.pos_name == $menu.menu_position}selected="selected"{/if}>{$position.pos_name}</option>
					{/foreach}
				</td>
				<td>{$menu.menu_pagetyp}</td>
				<td>{$menu._menu_page}</td>
				<td>{$menu.menu_modvar}</td>
				<td>{if $menu.menu_display == 1}aktiv{else}inaktiv{/if}</td>
				<td><input type="checkbox" name="menu_check[]" /></td>
			</tr>
				{/foreach}
				<tr>
					 <td class="formailer_options" colspan="7">&nbsp;</td>
				</td>
				<tr>
				  <td class="formailer_options" colspan="7">
				  <input type="submit" name="btn_senden" value="Senden">
				  <input name="Clear" type="reset" id="Clear" value="Zur&uuml;cksetzen"></td>
			</tr>
		</table>
		<input type="submit" name="
	</form>
	<div align="center">Erstellt in {$generated_time}s</div>
	</div>
</div>