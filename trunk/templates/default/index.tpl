<?xml version="1.1"?>
<!DOCTYPE html PUBLIC XHTML "-//W3C//DTD XHTML 1.1//DE">
<html>
  <head>
    <title>{$content_title}</title>
	<link rel="shortcut icon" type="image/x-icon" href="templates/style/icons/favicon.ico">
    <style type="text/css">@import url(./templates/style/style.css) all;</style>
	<!--[if IE]>
	<style type="text/css">@import url(./templates/style/ie_style.css);</style>
	<![endif]-->
    
  </head>
<body>
	<div id="main">
		&nbsp;
	</div>
	<div id="header">
		&nbsp;
	</div>
	<div id="navigation">
		{if $shortlink} <div class="navigation_links" style="text-align:right">{else}
 <div class="navigation_links">{/if}
      
        {*Hier kommt die Navigation, ausgelesen aus der DB*}
        {foreach item=topnav from=$topnav}
          <a href="?nav_id={$topnav.menu_ID}">{$topnav.menu_name}</a>
        {/foreach}
        
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
        <a href="?nav_id={$subnav.menu_ID}">{$subnav.menu_name}</a>  
      </div>
      {/foreach}
      
    </div>
    <!--Header Ende -->
    {include file="$file"|default:"main.tpl"}
    </div>
	<!--Erstellt in {$generated_time}s-->
  </body>
</html>

