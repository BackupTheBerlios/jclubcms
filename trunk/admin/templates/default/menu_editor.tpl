	 {config_load file='textes.de.conf' section='Editor-Entry'}
	 <div id="content">
		<div id="content_txt">
		<h2>{$editor.title|default:"Neues Menu verfassen"}</h2>
    <table width = 100% class="content_tab">
{*Fehlerausgabe wenn noetig*}
	{if $editor.dump_errors}
	<table class="content_tab" align="center">
		<tr>
			<td class="formailer_header" style="background-color: #EC6442">{$editor.error_title|default:"Einige Daten sind ung&uuml;ltig"}</td>
		</tr>
		<tr>
			<td class="formailer_txt" style="background-color: #ED4B23; color:#000000">{$editor.error_content}</td>
		</tr>
	</table>
	{/if}
    <form name="newentry" method="post" action="">
		  <table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="width: 90%">
			<tr>
				<td  class="formailer_txt">
					<fieldset style="border: 1px solid #FE7000;">
					  <legend style="color: #FF8000; font-weight: bolder">Menu</legend>
					  {if $editor.info}<div align="left" style="background-color: yellow">Info: {$editor.info}</div>{/if}
					  {if $editor.menu_ID}<input type="hidden" name="menu_ID" value="{$editor.menu_ID}" />{/if}
						<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="width: 95%">
							<tr>
							  <td class="formailer_header" colspan="2">
								Menu - Eintrag
							  </td>
							</tr>
							<tr>
							  <td class="formailer_txt"><label for="menu_name">Name des Menus: </label></td>
							  <td class="formailer_txt"><input type="text" id="menu_name" name="menu_name" value="{$editor.menu_name|default:#menu_name#}"/></td>
							</tr>
							<tr>
							  <td class="formailer_txt"><label for="menu_topid">Übergeordnete Id des Menus</label></td>
							  <td class="formailer_txt">
								<select id="menu_topid" name="menu_topid" size="1">
									<option value="0" selected="selected">=Haupteintrag=</option>
									{foreach item=menu from=$editor.menues}
<option value="{$menu.menu_ID}" {if $menu.menu_ID == $editor.menu_topid}selected="selected"{/if}>{$menu.menu_name}</option>
									{/foreach}
								</select>
							  </td>
							</tr>
							<tr>
							  <td class="formailer_txt"><label for="menu_position">Position des Menus: </label></td>
							  <td class="formailer_txt">
								<select id="menu_position" name="menu_position" size="1">
								{foreach item=position from=$editor.positions}
<option value="{$position.pos_name}" {if $position.pos_name == $editor.menu_position}selected="selected"{/if}>{$position.pos_name}</option>
								{/foreach}
								</select>
							  </td>
							</tr>
							<tr>
							  <td class="formailer_txt"><label for="menu_modus">Modus des Menus: </label></td>
							  <td class="formailer_txt"><input type="radio" id="menu_modus" name="menu_modus" value="pag" {if $editor.menu_modus != "mod"}checked="checked"{/if}/> Seiten-Modus &nbsp;<input type="radio" id="menu_modus" name="menu_modus" value="mod" {if $editor.menu_modus == "mod"}checked="checked"{/if}/> Modul-Modus</td>
							</tr>
							<tr>
							  <td class="formailer_txt"><label for="menu_page">Id der verlinkten Seite/Moduls: </label></td>
							  <td class="formailer_txt"><input type="text" id="menu_page" name="menu_page" value="{$editor.menu_page}" size="2"></td>
							</tr>
							<tr>
							  <td class="formailer_txt"><label for="menu_display">Menu anzeigen: </label></td>
							  <td class="formailer_txt">
								<input class="formailer_header_input" type="checkbox" id="menu_display" name="menu_display" value="show" {if $editor.menu_display == true}checked="checked"{/if}/>
							  </td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
			  <td class="formailer_options" colspan="2">
			  <input type="submit" name="btn_senden" value="Senden">
			  <input name="Clear" type="reset" id="Clear" value="Zur&uuml;cksetzen"></td>
			</tr>
		</table>
    </form>
  </div>
</div>

