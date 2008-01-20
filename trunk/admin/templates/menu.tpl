<div id="content">
	<div id="content_txt">
	<h1>Menues</h1>
	<p style="background-color:#FF8822; text-align: center">{$info}</p>
	<div align="left"><a href="?nav_id={$local_link}&action=new&amp;{$SID}">Neues Menu erstellen</a>
	<div align="center">{foreach item=page from=$pages}
			{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}
	{/foreach}</div>
	<script language="JavaScript" type="text/javascript">
		function Check(id)
		{ldelim}
		var elementname = "menu_check["+id+"]";
		document.forms["menues"].elements[elementname].checked = true;
		{rdelim}
	</script>
	{assign var="pad" value="2"}
	<form name="menues" method="post" action="">
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="max-width: 80%;min-width: 60%;font-size: 11px;">
			<tr  class="content_tab_header" >	
				<td style="padding: 6px">Name</td>
				<td style="padding: 6px">Top-ID</td>
				<td style="padding: 6px">Position</td>
				<td style="padding: 6px">Verweistyp</td>
				<td style="padding: 6px">Verweis-Id</td>
				<td style="padding: 6px">Parameter</td>
				<td style="padding: 6px">Anzeige</td>
				<td style="padding: 6px">&auml;ndern</td>
			</tr>
			{foreach name=menuausgabe item=menu  from=$menus}
			<tr name="{$menu.menu_ID}" class="content_tab_content2" style="padding: 6px; {if $smarty.foreach.menuausgabe.iteration % 2 == 0}background-color: yellow;{/if}">	
				<td style="padding: {$pad}px">{$menu.menu_space}<a href="?nav_id={$local_link}&amp;action=edit&amp;ref_ID={$menu.menu_ID}&amp;{$SID}">{$menu.menu_name}</a></td>
				<td style="padding: {$pad}px">{$menu.menu_topid}</td>
				<td style="padding: {$pad}px">
					<select id="menu_position" name="menu_position[{$menu.menu_ID}]" size="1" onclick="Check({$menu.menu_ID})">
						{foreach item=position from=$positions}
				<option value="{$position.pos_name}" {if $position.pos_name == $menu.menu_position}selected="selected"{/if}>{$position.pos_name}</option>
						{/foreach}
					</select>
				</td>
				<td style="padding: {$pad}px">{$menu.menu_pagetyp}</td>
				<td  style="padding: {$pad}px">{$menu._menu_page}</td>
				<td style="padding: {$pad}px">{$menu.menu_modvar}</td>
				<td style="padding: {$pad}px">
					<select name="menu_display[{$menu.menu_ID}]" size="1" {if $menu.menu_display == 1}style="color: green; font-weight: bold"{else}style="color: red; font-weight: bold"{/if}  onclick="Check({$menu.menu_ID})">
						<option value="1" {if $menu.menu_display == 1}selected="selected"{/if} style="color: green; font-weight: bold">aktiv</option>
						<option value="0" {if $menu.menu_display != 1}selected="selected"{/if} style="color: red; font-weight: bold">inaktiv</option>
					</select>{if $menu.menu_display == 1}aktiv{else}inaktiv{/if}
				</td>
				<td style="padding: {$pad}px">
					<input type="checkbox" name="menu_check[{$menu.menu_ID}]" value="{$menu.menu_ID}"/>&nbsp;
					<a href="?nav_id={$local_link}&amp;action=edit&amp;ref_ID={$menu.menu_ID}&amp;{$SID}"><img src="templates/style/icons/pencil.gif" alt="Pencil" title="&Auml;ndern"/></a>
					&nbsp;<a href="?nav_id={$local_link}&amp;action=del&amp;ref_ID={$menu.menu_ID}&amp;{$SID}"><img src="templates/style/icons/del.gif" alt="Kreuz" title="L&ouml;schen"/></a>
				</td>
			</tr>
				{/foreach}
				<tr>
					 <td class="formailer_options" colspan="8">&nbsp;</td>
				</td>
				<tr>
				  <td class="formailer_options" colspan="8">
				  <input type="submit" name="btn_senden" value="Senden">
				  <input name="Clear" type="reset" id="Clear" value="Zur&uuml;cksetzen"></td>
			</tr>
		</table>
	</form>
	<div align="center">Erstellt in {$generated_time}s</div>
	</div>
</div>