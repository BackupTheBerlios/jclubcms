<div id="content">
	<div id="content_txt">
		<h1>Gallery</h1>
		<table style="content_tab" align="center" width="700">
			<tr class="content_tab_header">
				<td colspan="3"><div style="float: left">{foreach item=root_item from=$root}
					&gt; <a href="?nav_id=40&cat={$root_item.ID}">{$root_item.name}</a>
					{/foreach}
					&gt;  <a href="?nav_id=40&gal={$album.ID}">{$album.name}</a>
					</div>
					<div align="center">
					<a href="?nav_id={$local_link}&gal={$album.ID}" ><img src="templates/style/icons/gallery.gif" />zur Bilder-&Uuml;bersicht</a>
					</div>
				</td>
			</tr>
			<tr class="content_tab_content1" align="center">
				<td>
					{if $prev_bild}
					<a href="?nav_id={$local_link}&img={$prev_bild}" >
						<img src="templates/style/icons/back.gif"/>
					</a>
					{else}&nbsp;{/if}
					</td>
				<td><img src="?nav_id={$img_link}&img={$ID_bild}" /></td>
				<td>
					{if $next_bild}<a href="?nav_id={$local_link}&img={$next_bild}" ><img src="templates/style/icons/next.gif" /></a>{else}&nbsp;{/if}
				</td>
			</tr>
			<tr  class="content_tab_header" align="center">
				<td colspan="3">
					<div style="float: left; font-size: 14px; vertical-align: middle; text-align: center;">{$filename}</div>
					<div align="center">
					Bild {$number} von {$count}</a>
					</div>
				</td>
			</tr>
		</table>   
	</div>
</div>
