{config_load file="textes.de.conf" section="Menu"}
<div id="content">
	<div id="content_txt">
	<h1>{#menues#}</h1>
	<p style="background-color:#FF8822; text-align: center">{$info}</p>
	<div align="left"><a href="?nav_id={$local_link}&action=new&amp;{$SID}">{#menu_create#}</a>
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
	<p>{#info_exact#}</p>
	<form name="menues" method="post" action="">
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="max-width: 80%;min-width: 60%;font-size: 11px;">
			<tr  class="content_tab_header" >	
				<td style="padding: 6px">{#name#}</td>
				<td style="padding: 6px">{#top_id#}</td>
				<td style="padding: 6px">{#position#}</td>
				<td style="padding: 6px">{#refer_typ#}</td>
				<td style="padding: 6px">{#refer_id#}</td>
				<td style="padding: 6px">{#param#}</td>
				<td style="padding: 6px">{#prompt#}</td>
				<td style="padding: 6px">{#change#}</td>
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
						<option value="1" {if $menu.menu_display == 1}selected="selected"{/if} style="color: green; font-weight: bold">{#activ#}</option>
						<option value="0" {if $menu.menu_display != 1}selected="selected"{/if} style="color: red; font-weight: bold">{#inactiv#}</option>
					</select>{if $menu.menu_display == 1}{#activ#}{else}{#inactiv#}{/if}
				</td>
				<td style="padding: {$pad}px">
					<input type="checkbox" name="menu_check[{$menu.menu_ID}]" value="{$menu.menu_ID}"/>&nbsp;
					<a href="?nav_id={$local_link}&amp;action=edit&amp;ref_ID={$menu.menu_ID}&amp;{$SID}"><img src="{$TEMPLATESET_DIR}/style/icons/pencil.gif" alt="{#pencil#}" title="{#change#}"/></a>
					&nbsp;<a href="?nav_id={$local_link}&amp;action=del&amp;ref_ID={$menu.menu_ID}&amp;{$SID}"><img src="{$TEMPLATESET_DIR}/style/icons/del.gif" alt="{#cross#} title="{#del#}"/></a>
				</td>
			</tr>
				{/foreach}
				<tr>
					 <td class="formailer_options" colspan="8">&nbsp;</td>
				</td>
				<tr>
				  <td class="formailer_options" colspan="8">
				  <input type="submit" name="btn_senden" value="{#send#}">
				  <input name="Clear" type="reset" id="Clear" value="{#undo#}"></td>
			</tr>
		</table>
	</form>
	<div align="center">{#created_in#} {$generated_time}s</div>
	</div>
</div>