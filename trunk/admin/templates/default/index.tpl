<?xml version="1.1"?>
<!DOCTYPE html PUBLIC XHTML "-//W3C//DTD XHTML 1.1//DE">
<html>
  <head>
    <title>{$content_title}</title>
	<link rel="shortcut icon" type="image/x-icon" href="{$TEMPLATESET_DIR}/style/icons/favicon.ico">
    <style type="text/css">@import url(./{$TEMPLATESET_DIR}/style/style.css) all;</style>
	<!--[if IE]>
	<style type="text/css">@import url(./{$TEMPLATESET_DIR}/style/ie_style.css);</style>
	<![endif]-->
	{config_load file="textes.de.conf"}
  </head>
<body>
	<div id="main">
		&nbsp;
	</div>
	<div id="header">
		&nbsp;
	</div>
	<div id="navigation">
		<div class="navigation_links"{if $shortlink} style="text-align:right"{/if}>
      
        {*Hier kommt die Navigation, ausgelesen aus der DB*}
       {foreach item=topnav from=$topnav}
          <a href="./index.php?nav_id={$topnav.menu_ID}{if $topnav.menu_modvar != ""}&{$topnav.menu_modvar}{/if}&{$SID}">{$topnav.menu_name}</a>
        {/foreach}
        
      </div>
    </div>
	<div id="footer">
		<div class="footer_txt">
		{#copyright#}
		</div>
	</div>
     <div id="subnavigation">
    
      {foreach item=subnav from=$subnav}    
      {*F�r alle Level grösser gleich 3 ist die CSS-Klasse subnav3, sonst eine andere*}
      {if $subnav.level == 1}
      <div class="subnavigation_links">
      {elseif $subnav.level <= 3}
      <div class="subnavigation_links{$subnav.level}">
      {else}
      <div class="subnavigation_links3">
      {/if}        
        <a href="./index.php?nav_id={$subnav.menu_ID}{if $subnav.menu_modvar != ""}&{$subnav.menu_modvar}{/if}&{$SID}">{$subnav.menu_name}</a>  
      </div>
      {/foreach}
      
    </div>
    <!--Header Ende -->
    {include file="$file"|default:"main.tpl"}
    </div>
  </body>
</html>
