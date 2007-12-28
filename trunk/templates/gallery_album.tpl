      <div id="content">
		<div id="content_txt">
		<h1>Gallery</h1>
    <table width="700" align="center" class="content_tab">
      <colgroup>
        <col width="1*">
        <col width="1*">
        <col width="1*">
	   <col width="1*">
      </colgroup>
	<tr class="content_tab_header">
		<td>{foreach item=root_item from=$root}
		&gt; <a href="?nav_id=40&cat={$root_item.ID}">{$root_item.name}</a>
		{/foreach}</td>
		<td><a href="?nav_id={$local_link}&cat={$top_ID}" ><img src="templates/style/icons/gallery.gif" />zur Gallery-&Uuml;bersicht</a></td>
		<td align="right">{$number} Bilder</td>
	</tr>
	<tr class="content_tab_content1" style="text-align:center; font-size:14px; font-weight: bold">
		<td colspan="3">
		{$gallery_name} - Seite {$thispage}
		</td>
	</tr>
      <tr class="content_tab_content1">
        <td colspan="3" align="center">
          {foreach item=page from=$pages}
            <a href="{$page.link}&gallery={$gal_ID}">[{$page.page}]</a>
          {/foreach}
        </td>
      </tr>
	  <tr class="content_tab_content1">
		<td colspan="3">
		<!--Bilder-->
		<table cellpadding="3" cellspacing="0" align="center" class="content_tab">
		  <tr  class="content_tab_content1">
		  {foreach key=index item=img from=$gallery}
			  <td><a href="?nav_id={$local_link}&img={$img.img_ID}" ><img src="index.php?nav_id={$img_link}&thumb={$img.img_ID}" /></a></td>
		  {if (($index+1) mod $breakline) == 0}
			</tr>
			<tr  class="content_tab_content1">
		  {/if}
		  {foreachelse}
			<td>Keine Bilder vorhanden</td>
		  {/foreach}
		  </tr>
		</table>
		<!--Ende der Bilder-->
		</td>
	</tr>
	<tr class="content_tab_content1">
        <td colspan="3" align="center">
          {foreach item=page from=$pages}
            <a href="{$page.link}&gallery={$gal_ID}">[{$page.page}]</a>
          {/foreach}
        </td>
      </tr>
	<tr class="content_tab_content1" style="text-align:center; font-size:14px; font-weight: bold">
		<td colspan="3">
		{$gallery_name} - Seite {$thispage}
		</td>
	</tr>
     <tr class="content_tab_header">
		<td>{foreach item=root_item from=$root}
		&gt; <a href="?nav_id=40&cat={$root_item.ID}">{$root_item.name}</a>
		{/foreach}</td>
		<td><a href="?nav_id={$local_link}" ><img src="templates/style/icons/gallery.gif" />zur Gallery-&Uuml;bersicht</a></td>
		<td align="right">{$number} Bilder</td>
	</tr>
    </table>
    <br />
  </div>
</div>
