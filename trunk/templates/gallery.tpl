<div id="background_content">&nbsp;</div>
<div id="contentContainer">
  <div id="content">
    {foreach item=gallery from=$gallery}
      <a href="./index.php?nav_id=40&gallery={$gallery.ID}">{$gallery.name}</a><br />
    {/foreach}
    {*Erstellt in {$generated_time}*}
  </div>
</div>