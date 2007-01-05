<div id="contentContainer">
<div id="contentContainer">
  <div id="content">
    <table width="640" align="center" class="content_tab">
      <colgroup>
        <col width="1*">
        <col width="1*">
        <col width="1*">
      </colgroup>
      <tr>
	<td><b>{$gallery_name}</b></td>
        <td><a href="./index.php?nav_id={$local_link}" ><img src="templates/style/icons/gallery.gif" />zur Gallery-&Uuml;bersicht</a></td>
        <td align="right">Seite {$thispage}</td>
      </tr>
      <tr>
        <td colspan="3" align="center">
          {foreach item=page from=$pages}
            <a href="{$page.link}&gallery={$gal_ID}">[{$page.page}]</a>
          {/foreach}
        </td>
      </tr>
    </table>
    <!--Bilder-->
    <table cellpadding="3" cellspacing="0" align="center" class="content_tab">
      <tr>
      {foreach key=index item=bild_ID from=$bild_ID}
          <td><a href="./index.php?nav_id={$local_link}&bild={$bild_ID}" ><img src="index.php?nav_id={$img_link}&thumb={$bild_ID}" /></a></td>
      {if (($index+1) mod $breakline) == 0}
        </tr>
        <tr>
      {/if}
      {/foreach}
      </tr>
    </table>
    <!--Ende der Bilder-->
    <table width="640" align="center" class="content_tab">
      <colgroup>
        <col width="1*">
        <col width="1*">
        <col width="1*">
      </colgroup>
      <tr>
	<td><b>{$gallery_name}</b></td>
        <td><a href="./index.php?nav_id={$local_link}" ><img src="templates/style/icons/gallery.gif" />zur Gallery-&Uuml;bersicht</a></td>
        <td align="right">Seite {$thispage}</td>
      </tr>
      <tr>
        <td colspan="3" align="center">
          {foreach item=page from=$pages}
            <a href="{$page.link}&gallery={$gal_ID}">[{$page.page}]</a>
          {/foreach}
        </td>
      </tr>
    </table>
    <br />
  </div>
</div>