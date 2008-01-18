<div id="content">
	<div id="content_txt">
	<h1>Modules</h1>
	<div align="left"><a href="?nav_id={$local_link}&action=new&amp;{$SID}">Neues Menu erstellen</a>
	<div align="center">{foreach item=page from=$pages}
			{if $page.link != ""}<a href="{$page.link}">[{$page.page}]</a>{else}[{$page.page}]{/if}
	{/foreach}</div>
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
			{foreach name=modulausgabe item=modul  from=$modules}
			<tr name="{$modul.modules_ID}" class="content_tab_content2" style="padding: 6px; {if $smarty.foreach.modulausgabe.iteration % 2 == 0}background-color: yellow;{/if}">	
				<td style="padding: {$pad}px">{$modul.modules_name}</a></td>
				<td style="padding: {$pad}px">{$modul.modules_file}</td>
				<td style="padding: {$pad}px">{$modul.modules_template_support}</td>
				<td style="padding: {$pad}px">{$modul.modules_mail_support}</td>
				<td  style="padding: {$pad}px">
					<select id="modules_status" name="modules_status[{$modul.modules_ID}]" size="1" style="color: blue; font-weight: bold">
						<option value="on" {if $modul.modules_statust == "on"}selected="selected"{/if} style="color: green; font-weight: bold">on</option>
						<option value="off" {if $modul.modules_statust == "off"}selected="selected"{/if} style="color: red; font-weight: bold">off</option>
					</select>
				</td>
				<td style="padding: {$pad}px">
					<input type="checkbox" name="modul_check[{$modul.modules_ID}]" value="{$modul.modules_ID}" />
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