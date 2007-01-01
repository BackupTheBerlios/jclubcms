<div id="contentContainer">
  <div id="content">
  <table align="center">
    <tr>
    {foreach key=index item=alben from=$alben}
	<td><a href="./index.php?nav_id={$local_link}&pic={$alben.bilder_ID}" ><img src="index.php?nav_id={$img_link}&thumb={$alben.bilder_ID}" /></a></td>
        {if (($index+1) mod $breakline) == 0}
        </tr>
        <tr>
        {/if}
    {/foreach}
    </tr>
    {*Erstellt in {$generated_time}s*}
  </div>
</div>