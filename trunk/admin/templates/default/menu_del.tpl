      <div id="content">
		<div id="content_txt">
		<table width = 100% class="content_tab">
		</table>
		<form name="del" method="post" action="">
			<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
				<tr>
				<td class="formailer_header" colspan="2">{$menu_name}
				</td>
				</tr>
				<tr>
					<td class="formailer_options" colspan="2">
					
						<fieldset><legend>Menudaten</legend>
							<br />
							<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="width: 100%; height: 100%; font-size: 11px;" border="1">
								<tr  class="content_tab_header" >	
									<td style="padding: 6px">Name</td>
									<td style="padding: 6px">Top-ID</td>
									<td style="padding: 6px">Position</td>
									<td style="padding: 6px">Verweistyp</td>
									<td style="padding: 6px">Verweis-Id</td>
									<td style="padding: 6px">Verweis-Name</td>
									<td style="padding: 6px">Parameter</td>
									<td style="padding: 6px">Anzeige</td>
								</tr>
								{assign var="pad" value="2"}
								<tr class="content_tab_content2" style="padding: {$pad}px; {if $smarty.foreach.menuausgabe.iteration % 2 == 0}background-color: yellow;{/if}">	
									<td style="padding: {$pad}px">{$menu_name|default:"&nbsp;"}</td>
									<td style="padding: {$pad}px">{$menu_topid|default:"&nbsp;"}</td>
									<td style="padding: {$pad}px"> {$menu_position|default:"&nbsp;"}</td>
									<td style="padding: {$pad}px">{$menu_pagetyp|default:"&nbsp;"}</td>
									<td  style="padding: {$pad}px">{$menu_page|default:"&nbsp;"}</td>
									<td  style="padding: {$pad}px">{$menu_pagename|default:"&nbsp;"}</td>
									<td style="padding: {$pad}px">{$menu_modvar|default:"&nbsp;"}</td>
									<td style="padding: {$pad}px">{if $menu_display == 1}aktiv{else}inaktiv{/if}</td>
								</tr>
							</table>
							<!--<table>
								<tr>
									<td>Name: </td><td>{$menu_name}</td>
								</tr>
								<tr>
									<td>Verweis-ID: </td><td>{$menu_page}</td>
								</tr>
								<tr>
									<td>Verweis-Typ: </td><td>{$menu_modus}</td>
								</tr>
								<tr>
									<td>Verweis-Name: </td><td>{$menu_linkname}</td>
								</tr>
							</table>-->
						</fieldset>
						Wollen Sie das <b>Menu</b> mit der ID {$del_ID}<b> wirklich löschen</b>?<br />
						Die Löschung ist UNWIDERRUFLICH!<br />
					</td>
				</tr>
				<tr>
					<td class="formailer_options">               
						 <input type="submit" name="weiter" value="{$linktext}" />
					</td>
					<td class="formailer_options">               
						  <input type="submit" name="nein" value="{$linktext2}" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>