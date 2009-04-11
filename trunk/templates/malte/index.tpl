<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>{$content_title}</title>
	<link rel="stylesheet" type="text/css" href="{$TEMPLATESET_DIR}/style/style.css"></link>
	<link rel="shortcut icon" type="image/x-icon" href="{$TEMPLATESET_DIR}/style/icons/favicon.ico"></link>
	<style>
	body {ldelim}
		background-image: url('{$TEMPLATESET_DIR}/style/images/bg.jpg');
	{rdelim}
	</style>
</head>

<body>

	<div id="center">

		<div id="header">

			<div id="flashposition">
				<object width="224" height="300" type="application/x-shockwave-Flash" data="{$TEMPLATESET_DIR}/style/head.swf">
				<param name="movie" value="{$TEMPLATESET_DIR}/style/head.swf" />
				</object>
			</div>
		
		</div>
		
		<div id="middle">
		
			<div id="navi">
			
				<div id="naviposition">
					<br />
					{foreach item=topnav from=$topnav}
						<a href="index.php?nav_id={$topnav.menu_ID}"><strong>>> {$topnav.menu_name}<br /></strong></a>				
					{/foreach}
					
					{if isset($subnav)}<br /><strong>>> Unterpunkte</strong><br />{/if}
					{foreach item=subnav from=$subnav}
						{if $subnav.level == 1}
						<div style="float: left;">
						{elseif $subnav.level <= 3}
						<div style="float: left; margin-left: 10px;">>> 
						{else}
						<div style="float: left; margin-left: 15px;">>> 
						{/if}
						<a href="index.php?nav_id={$subnav.menu_ID}">{$subnav.menu_name}</a>
						</div><br />
					{/foreach}	
				</div>
			
			</div>
			
			<div id="content">

			{include file="$file"|default:"main.tpl"}
			
			</div>
			
		</div>
		
		<div id="footer">
		
			<div id="flashposition2">

				<object width="294" height="144" type="application/x-shockwave-Flash" data="{$TEMPLATESET_DIR}/style/plane.swf">
				<param name="movie" value="{$TEMPLATESET_DIR}/style/plane.swf" />
				</object>
				
			</div>
		</div>

	</div>

</body>
</html>