      <div id="content">
		<div id="content_txt">
			<h1>Gallery</h1>
				<table class="content_tab" width="700" align="center" >
				<tr class="content_tab_header">
					<td colspan="3">
					{foreach item=root_item from=$root}
					&gt; <a href="?nav_id=40&cat={$root_item.ID}">{$root_item.name}</a>
					{/foreach}
					<div align="center"></div>
					</td>
				</tr>
				<tr class="content_tab_header" style="text-align:center">
					<th>Name</th>
					<th>Kommentar</th>
					<th>Erstellt</th>
				</tr>
				
				<tr class="content_tab_content1">
					<td colspan="3" style="text-align: center; font-size:17px; font-weight: bold">
					{$cat_name}
					</td>
				</tr>
				<!--Kategorien-->
				<tr class="content_tab_content2">
					<td colspan="3">Kategorien</td>
				</tr>
			{foreach item=category from=$categories}
			<tr class="content_tab_content1" style="text-align:center">
				<td><a href="?nav_id=40&cat={$category.ID}"><img src="{$TEMPLATESET_DIR}/style/icons/gallery.gif" />{$category.name}</a><br /></td>
				<td>{$category.comment}</td>
				<td>{$category.time}</td>
			</tr>
			{foreachelse}
			<tr class="content_tab_content1" style="text-align:center">
				<td colspan="3">Keine Kategorien</td>
			</tr>
			{/foreach}
			<!--Gallerien-->
			<tr class="content_tab_content2">
				<td colspan="3">Gallerien</td>
			</tr>
			{foreach item=gallery from=$galleries}
			<tr class="content_tab_content1" style="text-align:center">
				<td><a href="?nav_id=40&gal={$gallery.ID}"><img src="{$TEMPLATESET_DIR}/style/icons/gallery.gif" />{$gallery.name}</a><br /></td>
				<td>{$gallery.comment}</td>
				<td>{$gallery.time}</td>
			</tr>
			{foreachelse}
			<tr class="content_tab_content1" style="text-align:center">
					<td colspan="3">Keine Gallerien</td>
			</tr>
			{/foreach}
  </div>
</div>