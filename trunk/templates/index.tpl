<?xml version="1.1"?>
<!DOCTYPE html PUBLIC XHTML "-//W3C//DTD XHTML 1.1//DE">
<html>
  <head>
    <title>{$content_title|capitalize}</title>
    <link rel="stylesheet" href="./templates/style/style.css" type="text/css"/>
    
    <!--[if IE]>
    <link rel="stylesheet" href="./templates/style/ie_style.css" type="text/css"/
    <![endif]-->
    
  </head>
  <body>
    <div id="header">&nbsp;</div>
    <div id="navigationContainer">
      <div id="navigation">
      
        {*Hier kommt die Navigation, ausgelesen aus der DB*}
        {section name=topnav loop=$nav}
          <a href="./index.php?nav_id={$nav[topnav].menu_ID}">{$nav[topnav].menu_name}</a>
        {/section}
        
      </div>
    </div>
    <div id="subnavContainer">
    
      {foreach item=subnav from=$subnav}    
      {*Für alle Level grösser gleich 3 ist die CSS-Klasse subnav3, sonst eine andere*}
      {if $subnav.level == 1}
      <div class="subnav">
      {elseif $subnav.level <= 3}
      <div class="subnav{$subnav.level}">
      {else}
      <div class="subnav3">
      {/if}        
        <a href="./index.php?nav_id={$subnav.menu_ID}">{$subnav.menu_name}</a>  
      </div>
      {/foreach}
      
    </div>
    <!--Header Ende -->
    {include file="$file"|default:"main.tpl"}
    <div id="footerContainer">
        <div id="footer">
          &copy; by Schalk
        </div>
    </div>
  </body>
</html>
