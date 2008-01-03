      <div id="content">
		<div id="content_txt">
		<h2>Neuer Inhalt verfassen</h2>
    <table width = 100% class="content_tab">
    </table>
	{*Fehlerausgabe wenn noetig*}
	{if $dump_errors}
	<table class="content_tab" align="center">
		<tr>
			<td class="formailer_header" style="background-color: #EC6442">{$error_title|default:"Einige Daten sind ungueltig"}</td>
		</tr>
		<tr>
			<td class="formailer_txt" style="background-color: #ED4B23">{$error_content}</td>
		</tr>
	</table>
	{/if}
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
    <form name="newentry" method="post" action="">
		  <table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="width: 90%">
			<tr>
				<td  class="formailer_txt">
					<fieldset style="border: 1px solid #FE7000;">
					  <legend style="color: #FF8000; font-weight: bolder">Inhalt verfassen</legend>
						<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="width: 100%">
							<tr>
							  <td class="formailer_header">Titel: <input class="formailer_header_input" name="title" type="text" onclick="select()" value="{$entry_title}" /></td>
							</tr>
							<tr>
							  <td class="formailer_txt">
							  Inhalt:<br />
							  <textarea class="formailer_txt_textarea" name="content" cols="38" rows="20">{$entry_content}</textarea></td>
							</tr>	
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td  class="formailer_txt">
					<fieldset style="border: 1px solid #FE7000;">
					  <legend style="color: #FF8000; font-weight: bolder">Menu</legend>
						<table cellpadding="0" cellspacing="0" align="center" class="content_tab" style="width: 100%">
							<tr>
							  <td class="formailer_header" colspan="2">Menu setzen: <input class="formailer_header_input" name="title" type="checkbox" value="{$entry_title}" /></td>
							</tr>
							<tr>
							  <td class="formailer_txt"><label for="menu_title">Title des Menus: </label>
							  <td class="formailer_txt"><input type="text" id="menu_title" name="menu_title" />
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
			  <td class="formailer_options" colspan="2">
			  <input type="submit" name="btn_send" value="Senden">
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
    <table cellpadding="0" cellspacing="0" align="center" class="content_tab">
     <tr>
      <td class="formailer_header" colspan="2"><b>Smilie-Liste</b></td> 
     </tr>
     <tr>
      <td class="formailer_txt">
       <table class="content_tab">
        <tr>
         {foreach key=schluessel item=smily from=$smilies_list}
          <td align="right">{$smily.sign}</td><td><img src="{$smily.file}" onclick="smilies('{$smily.sign}')" style="cursor:pointer;" alt="{$smily.file}"></img></td>
	{if ($schluessel+1)%5 == 0}
		</tr>
		<tr>
	  {/if}
         {/foreach}
        </tr>
       </table>
      </td>
     </tr>
    </table>
  </div>
</div>

