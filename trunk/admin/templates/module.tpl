<div id="content">
	<div id="content_txt">
	<h1>Modules</h1>
	<div align="left"><a href="?nav_id={$local_link}&action=new&amp;{$SID}">Neues Menu erstellen</a>
	<div align="center">{foreach item=page from=$pages}
			{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}
	{/foreach}</div>
	<script language="JavaScript" type="text/javascript">
		function Check(id)
		{ldelim}
		var elementname = "modules_check["+id+"]";
		document.forms["modules"].elements[elementname].checked = true;
		{rdelim}
	</script>
	{assign var="pad" value="4"}
	<form name="modules" method="post" action="">
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="max-width: 80%;min-width: 60%;font-size: 11px;">
			<tr  class="content_tab_header" >	
				<td style="padding: 6px">Name</td>
				<td style="padding: 6px">Datei</td>
				<td style="padding: 6px">Template-Support</td>
				<td style="padding: 6px">Mail-Support</td>
				<td style="padding: 6px">Status</td>
				<td style="padding: 6px">&auml;ndern</td>
			</tr>
			{foreach name=modulausgabe item=module  from=$modules}
			<tr name="{$module.modules_ID}" class="content_tab_content2" style="padding: 6px; {if $smarty.foreach.modulausgabe.iteration % 2 == 0}background-color: yellow;{/if}" >	
				<td style="padding: {$pad}px">{$module.modules_name}</a></td>
				<td style="padding: {$pad}px">{$module.modules_file}</td>
				<td style="padding: {$pad}px">{$module.modules_template_support}</td>
				<td style="padding: {$pad}px">{$module.modules_mail_support}</td>
				<td  style="padding: {$pad}px">
					<select id="modules_status" name="modules_status[{$module.modules_ID}]" size="2" onclick="Check({$module.modules_ID})">
						<option value="on" {if $module.modules_status == "on"}selected="selected"{/if} style="color: green; font-weight: bold">on</option>
						<option value="off" {if $module.modules_status == "off"}selected="selected"{/if} style="color: red; font-weight: bold">off</option>
					</select>{$module.modules_status}
				</td>
				<td style="padding: {$pad}px">
					<input type="checkbox" id="modules_check[{$module.modules_ID}]" name="modules_check[{$module.modules_ID}]" value="{$module.modules_ID}" />
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