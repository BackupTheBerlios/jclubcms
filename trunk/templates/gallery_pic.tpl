      <div id="content">
		<div id="content_txt">
    <table align="center">
      <tr>
	<td colspan="3" align="center"><a href="./index.php?nav_id={$local_link}&gallery={$album}" ><img src="templates/style/icons/gallery.gif" />zur Bilder-&Uuml;bersicht</a></td>
      </tr>
      <tr>
	<td>
        {if $prev_bild}<a href="./index.php?nav_id={$local_link}&bild={$prev_bild}" ><img src="templates/style/icons/back.gif" /></a>
        {else}{/if}
        </td>
	<td><img src="index.php?nav_id={$img_link}&bild={$ID_bild}" /></td>
	<td>
        {if $next_bild}<a href="./index.php?nav_id={$local_link}&bild={$next_bild}" ><img src="templates/style/icons/next.gif" /></a>{else}{/if}
        </td>
      </tr>
    </table>
    <!--Erstellt in {$generated_time}s-->
    
  </div>
</div>
