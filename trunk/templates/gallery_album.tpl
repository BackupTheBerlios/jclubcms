<div id="background_content">&nbsp;</div>
<div id="contentContainer">
  <div id="content">
    {foreach item=alben from=$alben}
      <a href="./index.php?nav_id={$local_link}&pic={$alben.bilder_ID}" ><img src="index.php?nav_id={$img_link}&thumb={$alben.bilder_ID}" /></a>
      <br />
    {/foreach}
    {*Erstellt in {$generated_time}s*}
    {$text}
  </div>
</div>