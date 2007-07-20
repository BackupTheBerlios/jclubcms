<?xml version="1.1"?>
<!DOCTYPE html PUBLIC XHTML "-//W3C//DTD XHTML 1.1//DE">
<html>
  <head>
    <title>{$content_title}</title>

    <style type="text/css">@import url(./templates/style/style.css) all;</style>
	<!--[if IE]>
	<style type="text/css">@import url(./templates/style/ie_style.css);</style>
	<![endif]-->
  </head>
<body>
{* Dieses div ist NUR für Overlib, damit alles so funktioniert wie es soll. *}
	<div id="main">
		&nbsp;
	</div>
	<div id="header">
		&nbsp;
	</div>
	<div id="navigation">
		<div class="navigation_links">
      
        {*Hier kommt die Navigation, ausgelesen aus der DB*}
        {section name=topnav loop=$nav}
          <a href="./index.php?nav_id={$nav[topnav].menu_ID}">{$nav[topnav].menu_name}</a>
        {/section}
        
      </div>
    </div>
    <div id="subnavigation">

		<div class="subnavigation_links">
		      <a href="index.html">Aktuell</a>
		      <a href="index.html">&Uuml;ber uns</a>
		      <a href="index.html">Das Leiterteam</a>
		      <a href="index.html">Die Gruppen</a>
		      <a href="index.html">BESJ</a>
		      <a href="index.html">Fotos &amp; Videos</a>
		      <a href="index.html">Downloads</a>
		</div>
	</div>
	<div id="footer">
		<div class="footer_txt">
			&copy; 2007 by JG J-Club Balsthal
		</div>
	</div>
     <div id="subnavigation">
    
      {foreach item=subnav from=$subnav}    
      {*Für alle Level grösser gleich 3 ist die CSS-Klasse subnav3, sonst eine andere*}
      {if $subnav.level == 1}
      <div class="subnavigation_links">
      {elseif $subnav.level <= 3}
      <div class="subnavigation_links{$subnav.level}">
      {else}
      <div class="subnavigation_links3">
      {/if}        
        <a href="./index.php?nav_id={$subnav.menu_ID}">{$subnav.menu_name}</a>  
      </div>
      {/foreach}
      
    </div>
    <!--Header Ende -->
    {include file="$file"|default:"main.tpl"}
    </div>
  </body>
</html>
