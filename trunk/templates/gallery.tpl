      <div id="content">
		<div id="content_txt">
    {foreach item=gallery from=$gallery}
      <a href="?nav_id=40&gallery={$gallery.ID}"><img src="templates/style/icons/gallery.gif" />{$gallery.name}</a><br />
    {/foreach}
  </div>
</div>