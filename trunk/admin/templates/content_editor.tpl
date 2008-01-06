	 {config_load file='textes.de.conf' section='Editor-Entry'}
	 <div id="content">
		<div id="content_txt">
		<h2>Neuer Inhalt verfassen</h2>
    <table width = 100% class="content_tab">
    </table>
	<!-- tinyMCE -->
	<script type="text/javascript" src="../javascript/tinymce/tiny_mce_gzip.js"></script>
<script type="text/javascript">
tinyMCE_GZ.init({ldelim}
	plugins : 'style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+ 
	'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	themes : 'simple,advanced',
	languages : 'de',
	disk_cache : true,
	debug : false
{rdelim});
</script>
<script language="javascript" type="text/javascript">
	// Notice: The simple theme does not use all options some of them are limited to the advanced theme
	tinyMCE.init({ldelim}
		mode : "textareas",
		theme : "advanced",
		language : "de"
	{rdelim});
</script>
<!-- /tinyMCE -->
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
					  <legend style="color: #FF8000; font-weight: bolder">Inhalt verfassen</legend>
						<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="width: 95%">
							<tr>
							  <td class="formailer_header">
								Titel: <input class="formailer_header_input" name="content_title" type="text" value="{$editor.content_title|default:#content_title#}" />
							  </td>
							</tr>
							<tr>
							  <td class="formailer_txt">
							  Inhalt:<br />
							  <textarea class="formailer_txt_textarea" name="content_text" cols="75" rows="20">{$editor.content_text|replace:"src=\"?image":"src=\"?image&amp;$SID"|default:#content_text#}</textarea></td>
							</tr>	
							<tr>
								<td class="formailer_txt">
								<label for="content_hide">Inhalt unerreichbar machen</label>
								<input type="checkbox" id="content_hide" name="content_hide" {if $editor.content_hide == true}checked="checked"{/if} />
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td  class="formailer_txt">
					<fieldset style="border: 1px solid #FE7000;">
					  <legend style="color: #FF8000; font-weight: bolder">Menu</legend>
					  {if $editor.info}<div align="left" style="background-color: yellow">Info: {$editor.info}</div>{/if}
					  {if $editor.menu_ID}<input type="hidden" name="menu_ID" value="{$editor.menu_ID}" />{/if}
					  {if $editor.menu_new}<input type="hidden" name="menu_new" value="{$editor.menu_new}" />{/if}
						<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="width: 95%">
							<tr>
							  <td class="formailer_header" colspan="2">
								Menu ignorieren<input class="formailer_header_input" type="checkbox" name="menu_ignore" {if $editor.menu_ignore == true}checked="checked"{/if}/>
							  </td>
							</tr>
							<tr>
							  <td class="formailer_txt"><label for="menu_name">Name des Menus: </label></td>
							  <td class="formailer_txt"><input type="text" id="menu_name" name="menu_name" value="{$editor.menu_name|default:#menu_name#}"/></td>
							</tr>
							<tr>
							  <td class="formailer_txt"><label for="menu_topid">Übergeordnete Id des Menus: </label></td>
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
							  <td class="formailer_txt"><label for="menu_display">Menu anzeigen: </label></td>
							  <td class="formailer_txt">
								<input class="formailer_header_input" type="checkbox" id="menu_display" name="menu_display" {if $editor.menu_display == true}checked="checked"{/if}/>
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
	<!--  <form name="newentry" method="post" action="">
		  <table cellpadding="0" cellspacing="0" align="center" class="content_tab" border="2">
			<fieldset>
			  <legend>Inhalt verfassen</legend>
				<tr>
				  <td class="formailer_header">Titel: <img src="templates/style/icons/pencil.gif" /><input class="formailer_header_input" name="title" type="text" onclick="select()" value="{$entry_title}" /></td>
				</tr>
				<tr>
				  <td class="formailer_txt">
				  Inhalt:<br />
				  <textarea class="formailer_txt_textarea" name="content" cols="38" rows="20">{$entry_content}</textarea></td>
				</tr>
				<tr>
				<tr>
				  <td class="formailer_options" colspan="2">
				  <input type="submit" name="btn_send" value="Senden">
				  <input name="Clear" type="reset" id="Clear" value="Zur&uuml;cksetzen"></td>
				</tr>
			</fieldset>
		  </table>
    </form>-->
  </div>
</div>

